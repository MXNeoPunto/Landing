<?php
$rootDir = dirname(__DIR__);
require_once $rootDir . '/config/db.php';
require_once $rootDir . '/includes/security.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Authentication check
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'admin') {
    http_response_code(403);
    echo "Acceso denegado.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_general') {
    if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
        http_response_code(403);
        exit("Token de seguridad inválido.");
    }

    // 1. Handle text inputs
    $smtp_host = $_POST['smtp_host'] ?? '';
    $smtp_port = !empty($_POST['smtp_port']) ? (int)$_POST['smtp_port'] : null;
    $smtp_user = $_POST['smtp_user'] ?? '';
    $smtp_pass = $_POST['smtp_pass'] ?? '';
    $smtp_from_email = filter_var($_POST['smtp_from_email'] ?? '', FILTER_VALIDATE_EMAIL) ?: '';
    $smtp_from_name = $_POST['smtp_from_name'] ?? '';

    $seo_title = $_POST['seo_title'] ?? '';
    $seo_description = $_POST['seo_description'] ?? '';
    $seo_keywords = $_POST['seo_keywords'] ?? '';

    // 2. Handle file uploads (logo_header, favicon)
    $uploadDir = $rootDir . '/assets/uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $logoPath = null;
    $faviconPath = null;

    $allowedMimes = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
        'image/x-icon' => 'ico',
        'image/svg+xml' => 'svg'
    ];

    if (isset($_FILES['logo_header']) && $_FILES['logo_header']['error'] === UPLOAD_ERR_OK) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $_FILES['logo_header']['tmp_name']);
        finfo_close($finfo);

        $ext = strtolower(pathinfo($_FILES['logo_header']['name'], PATHINFO_EXTENSION));

        if (array_key_exists($mime, $allowedMimes) && ($allowedMimes[$mime] === $ext || ($mime === 'image/jpeg' && $ext === 'jpeg'))) {
            $filename = time() . '_logo_' . uniqid() . '.' . $ext;
            $targetPath = $uploadDir . $filename;
            if (move_uploaded_file($_FILES['logo_header']['tmp_name'], $targetPath)) {
                $logoPath = 'assets/uploads/' . $filename;
            }
        }
    }

    if (isset($_FILES['favicon']) && $_FILES['favicon']['error'] === UPLOAD_ERR_OK) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $_FILES['favicon']['tmp_name']);
        finfo_close($finfo);

        $ext = strtolower(pathinfo($_FILES['favicon']['name'], PATHINFO_EXTENSION));

        if (array_key_exists($mime, $allowedMimes) && ($allowedMimes[$mime] === $ext || ($mime === 'image/jpeg' && $ext === 'jpeg'))) {
            $filename = time() . '_favicon_' . uniqid() . '.' . $ext;
            $targetPath = $uploadDir . $filename;
            if (move_uploaded_file($_FILES['favicon']['tmp_name'], $targetPath)) {
                $faviconPath = 'assets/uploads/' . $filename;
            }
        }
    }

    // 3. Update Database (assuming id=1 exists)
    try {
        $sql = "UPDATE config_general SET
                smtp_host = :h, smtp_port = :p, smtp_user = :u, smtp_pass = :pa,
                smtp_from_email = :fe, smtp_from_name = :fn, seo_title = :st,
                seo_description = :sd, seo_keywords = :sk";

        $params = [
            ':h' => $smtp_host, ':p' => $smtp_port, ':u' => $smtp_user, ':pa' => $smtp_pass,
            ':fe' => $smtp_from_email, ':fn' => $smtp_from_name, ':st' => $seo_title,
            ':sd' => $seo_description, ':sk' => $seo_keywords
        ];

        if ($logoPath !== null) {
            $sql .= ", logo_header = :lh";
            $params[':lh'] = $logoPath;
        }
        if ($faviconPath !== null) {
            $sql .= ", favicon = :fv";
            $params[':fv'] = $faviconPath;
        }

        $sql .= " WHERE id = 1";

        global $pdo;
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        $_SESSION['success_msg'] = "Configuración actualizada correctamente.";
        if (php_sapi_name() !== 'cli') {
            header('Location: ../panel/admin.php');
            exit();
        }

    } catch (\PDOException $e) {
        $_SESSION['error_msg'] = "Error al actualizar: " . $e->getMessage();
        if (php_sapi_name() !== 'cli') {
            header('Location: ../panel/admin.php');
            exit();
        } else {
            echo "Error DB: " . $e->getMessage();
        }
    }
}
