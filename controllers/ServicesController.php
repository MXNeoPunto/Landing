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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
        http_response_code(403);
        exit("Token de seguridad inválido.");
    }


    if ($_POST['action'] === 'create_service') {
        $nombre = $_POST['nombre'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';
        $tipo = $_POST['tipo'] ?? 'cotizable';

        $precio_aproximado = null;
        $precio_fijo = null;

        if ($tipo === 'cotizable') {
            $precio_aproximado = !empty($_POST['precio_aproximado']) ? $_POST['precio_aproximado'] : null;
        } else {
            $precio_fijo = !empty($_POST['precio_fijo']) ? $_POST['precio_fijo'] : null;
        }

        try {
            $stmt = $pdo->prepare("INSERT INTO servicios (nombre, descripcion, tipo, precio_aproximado, precio_fijo, estado) VALUES (?, ?, ?, ?, ?, 'activo')");
            $stmt->execute([$nombre, $descripcion, $tipo, $precio_aproximado, $precio_fijo]);
            $_SESSION['success_msg'] = "Servicio creado exitosamente.";
        } catch (\PDOException $e) {
            $_SESSION['error_msg'] = "Error al crear servicio: " . $e->getMessage();
        }
    }

    elseif ($_POST['action'] === 'delete_service' && isset($_POST['id'])) {
        try {
            $stmt = $pdo->prepare("UPDATE servicios SET estado = 'inactivo' WHERE id = ?");
            $stmt->execute([$_POST['id']]);
            $_SESSION['success_msg'] = "Servicio desactivado.";
        } catch (\PDOException $e) {
            $_SESSION['error_msg'] = "Error al desactivar: " . $e->getMessage();
        }
    }

    if (php_sapi_name() !== 'cli') {
        header('Location: ../panel/admin.php');
        exit();
    }
}
