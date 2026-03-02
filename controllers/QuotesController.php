<?php
$rootDir = dirname(__DIR__);
require_once $rootDir . '/config/db.php';
require_once $rootDir . '/includes/security.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Authentication check
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo "Acceso denegado.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
        http_response_code(403);
        exit("Token de seguridad inválido.");
    }


    // Create new quote (Usually done by Client)
    if ($_POST['action'] === 'create_quote' && $_SESSION['rol'] === 'cliente') {
        $servicio_id = $_POST['servicio_id'] ?? null;
        $descripcion = $_POST['descripcion'] ?? '';

        // Get user currency
        global $pdo;
        $stmtUser = $pdo->prepare("SELECT moneda FROM usuarios WHERE id = ?");
        $stmtUser->execute([$_SESSION['user_id']]);
        $moneda = $stmtUser->fetchColumn() ?: 'USD';

        try {
            $stmt = $pdo->prepare("INSERT INTO cotizaciones (usuario_id, servicio_id, descripcion_cliente, moneda, estado) VALUES (?, ?, ?, ?, 'pendiente')");
            $stmt->execute([$_SESSION['user_id'], $servicio_id, $descripcion, $moneda]);
            $_SESSION['success_msg'] = "Cotización solicitada con éxito.";
        } catch (\PDOException $e) {
            $_SESSION['error_msg'] = "Error: " . $e->getMessage();
        }

        if (php_sapi_name() !== 'cli') {
            header('Location: ../panel/cliente.php');
            exit();
        }
    }

    // Update Quote Status (Admin only)
    elseif ($_POST['action'] === 'update_status' && $_SESSION['rol'] === 'admin') {
        $cotizacion_id = $_POST['cotizacion_id'] ?? null;
        $estado = $_POST['estado'] ?? 'pendiente';
        $precio_final = !empty($_POST['precio_final']) ? $_POST['precio_final'] : null;

        try {
            $stmt = $pdo->prepare("UPDATE cotizaciones SET estado = ?, precio_final = ? WHERE id = ?");
            $stmt->execute([$estado, $precio_final, $cotizacion_id]);
            $_SESSION['success_msg'] = "Estado de cotización actualizado.";
        } catch (\PDOException $e) {
            $_SESSION['error_msg'] = "Error: " . $e->getMessage();
        }

        if (php_sapi_name() !== 'cli') {
            header('Location: ../panel/admin.php');
            exit();
        }
    }

    // Add Chat Message (Ticket) - Admin or Client
    elseif ($_POST['action'] === 'add_message') {
        $cotizacion_id = $_POST['cotizacion_id'] ?? null;
        $mensaje = trim($_POST['mensaje'] ?? '');
        $ticket_id = null;

        if (!empty($mensaje) && $cotizacion_id) {
            try {
                // Verify user owns the quote if they are a client
                if ($_SESSION['rol'] === 'cliente') {
                    $verify = $pdo->prepare("SELECT id FROM cotizaciones WHERE id = ? AND usuario_id = ?");
                    $verify->execute([$cotizacion_id, $_SESSION['user_id']]);
                    if (!$verify->fetch()) {
                        throw new \Exception("No autorizado para esta cotización.");
                    }
                }

                $stmt = $pdo->prepare("INSERT INTO tickets (cotizacion_id, usuario_id, mensaje) VALUES (?, ?, ?)");
                $stmt->execute([$cotizacion_id, $_SESSION['user_id'], $mensaje]);
                $ticket_id = $pdo->lastInsertId();

                $_SESSION['success_msg'] = "Mensaje enviado.";
            } catch (\Exception $e) {
                $_SESSION['error_msg'] = "Error: " . $e->getMessage();
            }
        }

                // Handle File Upload if exists
        if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['archivo'];
            $maxSize = 5 * 1024 * 1024; // 5MB

            // Security: Validate MIME type and Extension
            $allowedMimes = [
                'application/pdf' => 'pdf',
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'application/msword' => 'doc',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
                'application/zip' => 'zip',
                'text/plain' => 'txt'
            ];

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $file['tmp_name']);
            finfo_close($finfo);

            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            if ($file['size'] > $maxSize) {
                $_SESSION['error_msg'] = "El archivo excede el límite de 5MB.";
            } elseif (!array_key_exists($mime, $allowedMimes) || $allowedMimes[$mime] !== $ext && ($mime !== 'image/jpeg' || $ext !== 'jpeg')) {
                $_SESSION['error_msg'] = "Tipo de archivo no permitido o extensión inválida.";
            } else {
                $uploadDir = $rootDir . '/assets/uploads/tickets/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                // Force safe filename
                $filename = time() . '_' . uniqid() . '.' . $ext;
                $targetPath = $uploadDir . $filename;

                if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                    try {
                        $ruta = 'assets/uploads/tickets/' . $filename;
                        $stmt = $pdo->prepare("INSERT INTO archivos (ticket_id, cotizacion_id, nombre_archivo, ruta_archivo, tamano, subido_por) VALUES (?, ?, ?, ?, ?, ?)");
                        $stmt->execute([$ticket_id, $cotizacion_id, $file['name'], $ruta, $file['size'], $_SESSION['user_id']]);
                    } catch (\PDOException $e) {
                        $_SESSION['error_msg'] = "Error al guardar archivo en BD: " . $e->getMessage();
                    }
                } else {
                    $_SESSION['error_msg'] = "Error al subir el archivo.";
                }
            }
        }

        if (php_sapi_name() !== 'cli') {
            header('Location: ../panel/' . ($_SESSION['rol'] === 'admin' ? 'admin.php' : 'cliente.php'));
            exit();
        }
    }

    // Delete Old Files (Admin Only)
    elseif ($_POST['action'] === 'delete_old_files' && $_SESSION['rol'] === 'admin') {
        try {
            // Find files older than 5 months
            $stmt = $pdo->prepare("SELECT id, ruta_archivo FROM archivos WHERE creado_en < DATE_SUB(NOW(), INTERVAL 5 MONTH)");
            $stmt->execute();
            $archivos = $stmt->fetchAll();

            $eliminados = 0;
            foreach ($archivos as $archivo) {
                $filePath = $rootDir . '/' . $archivo['ruta_archivo'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                // Delete record from DB
                $del = $pdo->prepare("DELETE FROM archivos WHERE id = ?");
                $del->execute([$archivo['id']]);
                $eliminados++;
            }
            $_SESSION['success_msg'] = "$eliminados archivos antiguos eliminados.";
        } catch (\PDOException $e) {
            $_SESSION['error_msg'] = "Error: " . $e->getMessage();
        }

        if (php_sapi_name() !== 'cli') {
            header('Location: ../panel/admin.php');
            exit();
        }
    }
}

    // Request Edit (Client Only) - 2 Hour Rule & Admin Approval
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'request_edit' && $_SESSION['rol'] === 'cliente') {
        $cotizacion_id = $_POST['cotizacion_id'] ?? null;
        $motivo = trim($_POST['motivo'] ?? '');

        if ($cotizacion_id && !empty($motivo)) {
            try {
                // Verify ownership and rules
                $stmt = $pdo->prepare("SELECT estado, creado_en FROM cotizaciones WHERE id = ? AND usuario_id = ?");
                $stmt->execute([$cotizacion_id, $_SESSION['user_id']]);
                $quote = $stmt->fetch();

                if ($quote) {
                    $creado = strtotime($quote['creado_en']);
                    $ahora = time();
                    $horasTranscurridas = ($ahora - $creado) / 3600;

                    if ($horasTranscurridas < 2) {
                        $_SESSION['error_msg'] = "Deben pasar al menos 2 horas desde la creación para solicitar edición.";
                    } elseif ($quote['estado'] === 'finalizado' || $quote['estado'] === 'cancelado') {
                        $_SESSION['error_msg'] = "No se puede solicitar edición en estado finalizado o cancelado.";
                    } else {
                        // Request is valid, notify admin via ticket and change status to 'solicitud_edicion' if needed
                        // For this implementation, we log it as a ticket and flag it (could add a new status or just use the ticket)
                        $msg = "SOLICITUD DE EDICIÓN: " . $motivo;
                        $ins = $pdo->prepare("INSERT INTO tickets (cotizacion_id, usuario_id, mensaje) VALUES (?, ?, ?)");
                        $ins->execute([$cotizacion_id, $_SESSION['user_id'], $msg]);

                        $_SESSION['success_msg'] = "Solicitud de edición enviada al administrador para su aprobación.";
                    }
                } else {
                    $_SESSION['error_msg'] = "Cotización no válida.";
                }
            } catch (\PDOException $e) {
                $_SESSION['error_msg'] = "Error: " . $e->getMessage();
            }
        }

        if (php_sapi_name() !== 'cli') {
            header('Location: ../panel/cliente.php');
            exit();
        }
    }
