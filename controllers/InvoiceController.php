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

    // Client requesting an invoice (providing NIT/CF)
    if ($_POST['action'] === 'request_invoice' && $_SESSION['rol'] === 'cliente') {

        $cotizacion_id = $_POST['cotizacion_id'] ?? null;
        $nombre_legal = trim($_POST['nombre_legal'] ?? '');
        $tipo_identificacion = trim($_POST['tipo_identificacion'] ?? '');
        $identificacion_numero = trim($_POST['identificacion_numero'] ?? '');

        if ($cotizacion_id && $nombre_legal && $tipo_identificacion) {
            try {
                // Get quote details to pre-fill total and currency
                $stmtQ = $pdo->prepare("SELECT precio_final, moneda FROM cotizaciones WHERE id = ? AND usuario_id = ?");
                $stmtQ->execute([$cotizacion_id, $_SESSION['user_id']]);
                $quote = $stmtQ->fetch();

                if ($quote) {
                    $monto_total = $quote['precio_final'] ?? 0;
                    $moneda = $quote['moneda'];

                    // Insert or update invoice request
                    $stmt = $pdo->prepare("INSERT INTO facturas (cotizacion_id, usuario_id, tipo_identificacion, identificacion_numero, nombre_legal, monto_total, moneda, estado_pago)
                                           VALUES (?, ?, ?, ?, ?, ?, ?, 'pendiente')
                                           ON DUPLICATE KEY UPDATE
                                           tipo_identificacion = VALUES(tipo_identificacion),
                                           identificacion_numero = VALUES(identificacion_numero),
                                           nombre_legal = VALUES(nombre_legal)");

                    $stmt->execute([$cotizacion_id, $_SESSION['user_id'], $tipo_identificacion, $identificacion_numero, $nombre_legal, $monto_total, $moneda]);

                    $_SESSION['success_msg'] = "Datos de facturación enviados. El administrador subirá tu factura pronto.";
                } else {
                    $_SESSION['error_msg'] = "Cotización no válida o no autorizada.";
                }
            } catch (\PDOException $e) {
                $_SESSION['error_msg'] = "Error al solicitar factura: " . $e->getMessage();
            }
        } else {
            $_SESSION['error_msg'] = "Faltan datos requeridos.";
        }

        if (php_sapi_name() !== 'cli') {
            header('Location: ../panel/cliente.php');
            exit();
        }
    }

    // Admin uploading the generated PDF invoice
    elseif ($_POST['action'] === 'upload_invoice' && $_SESSION['rol'] === 'admin') {
        $factura_id = $_POST['factura_id'] ?? null;

        if ($factura_id && isset($_FILES['pdf_factura']) && $_FILES['pdf_factura']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['pdf_factura'];

            // Validate it's a PDF
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $file['tmp_name']);
            finfo_close($finfo);

            if ($mime !== 'application/pdf') {
                $_SESSION['error_msg'] = "Solo se permiten archivos PDF.";
            } else {
                $uploadDir = $rootDir . '/assets/uploads/facturas/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $filename = time() . '_factura_' . $factura_id . '.pdf';
                $targetPath = $uploadDir . $filename;

                if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                    try {
                        $ruta = 'assets/uploads/facturas/' . $filename;
                        $stmt = $pdo->prepare("UPDATE facturas SET ruta_pdf = ? WHERE id = ?");
                        $stmt->execute([$ruta, $factura_id]);
                        $_SESSION['success_msg'] = "Factura PDF subida y enviada al cliente.";
                    } catch (\PDOException $e) {
                        $_SESSION['error_msg'] = "Error al actualizar BD: " . $e->getMessage();
                    }
                } else {
                    $_SESSION['error_msg'] = "Error al guardar el archivo PDF.";
                }
            }
        } else {
            $_SESSION['error_msg'] = "Datos inválidos o archivo no seleccionado.";
        }

        if (php_sapi_name() !== 'cli') {
            header('Location: ../panel/admin.php');
            exit();
        }
    }
}
