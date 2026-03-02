<?php
$rootDir = dirname(__DIR__);
require_once $rootDir . '/config/db.php';
require_once $rootDir . '/includes/security.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

check_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
        http_response_code(403);
        exit("Token de seguridad inválido.");
    }

    $action = $_POST['action'];

    // ACTIONS FOR CLIENT / ADMIN EDITING OWN PROFILE
    if ($action === 'update_self') {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $pais = trim($_POST['pais'] ?? '');

        if (!$username || !$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error_msg'] = "Datos inválidos.";
            header('Location: ../panel/cliente.php');
            exit();
        }

        try {
            $stmt = $pdo->prepare("UPDATE usuarios SET username = ?, email = ?, telefono = ?, pais = ? WHERE id = ?");
            $stmt->execute([$username, $email, $telefono, $pais, $_SESSION['user_id']]);
            $_SESSION['success_msg'] = "Perfil actualizado correctamente.";
        } catch (\PDOException $e) {
            if ($e->getCode() == 23000) {
                $_SESSION['error_msg'] = "El correo o usuario ya está en uso.";
            } else {
                $_SESSION['error_msg'] = "Error al actualizar el perfil.";
            }
        }
        header('Location: ../panel/cliente.php');
        exit();
    }

    // ACTIONS FOR ADMINS ONLY BELOW
    if (!in_array($_SESSION['rol'], ['admin', 'admin_principal', 'admin_secundario'])) {
        http_response_code(403);
        exit("Acceso denegado.");
    }

    $user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
    if (!$user_id) {
        header('Location: ../panel/admin.php');
        exit();
    }

    $targetUrl = "../panel/admin_user.php?id=" . $user_id;

    if ($action === 'update_profile') {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $pais = trim($_POST['pais'] ?? '');

        try {
            $stmt = $pdo->prepare("UPDATE usuarios SET username = ?, email = ?, telefono = ?, pais = ? WHERE id = ?");
            $stmt->execute([$username, $email, $telefono, $pais, $user_id]);
            $_SESSION['success_msg'] = "Perfil de usuario actualizado.";
        } catch (\PDOException $e) {
            $_SESSION['error_msg'] = "Error al actualizar (posible duplicado).";
        }
        header("Location: $targetUrl");
        exit();
    }

    if ($action === 'update_role') {
        $nuevoRol = $_POST['rol'] ?? 'cliente';

        // Basic security check: Only admin_principal can assign other admin roles
        if (in_array($nuevoRol, ['admin_principal', 'admin_secundario', 'admin']) && $_SESSION['rol'] !== 'admin_principal') {
            $_SESSION['error_msg'] = "No tienes permisos para asignar este rol.";
            header("Location: $targetUrl");
            exit();
        }

        try {
            $stmt = $pdo->prepare("UPDATE usuarios SET rol = ? WHERE id = ?");
            $stmt->execute([$nuevoRol, $user_id]);
            $_SESSION['success_msg'] = "Rol actualizado correctamente.";
        } catch (\PDOException $e) {
            $_SESSION['error_msg'] = "Error al actualizar el rol.";
        }
        header("Location: $targetUrl");
        exit();
    }

    if ($action === 'reset_password') {
        // Generate a random temporary password
        $tempPass = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$'), 0, 10);
        $hashed = password_hash($tempPass, PASSWORD_DEFAULT);

        try {
            $stmt = $pdo->prepare("UPDATE usuarios SET password = ? WHERE id = ?");
            $stmt->execute([$hashed, $user_id]);
            // In a real scenario, this should be sent via email.
            $_SESSION['success_msg'] = "Contraseña restablecida. La nueva contraseña temporal es: <strong>$tempPass</strong>. Por favor, compártala con el usuario de forma segura.";
        } catch (\PDOException $e) {
            $_SESSION['error_msg'] = "Error al restablecer contraseña.";
        }
        header("Location: $targetUrl");
        exit();
    }

    if ($action === 'force_verify') {
        try {
            $stmt = $pdo->prepare("UPDATE usuarios SET estado = 'activo' WHERE id = ? AND estado = 'sin_verificar'");
            $stmt->execute([$user_id]);
            if ($stmt->rowCount() > 0) {
                $_SESSION['success_msg'] = "Usuario verificado manualmente.";
            } else {
                $_SESSION['error_msg'] = "El usuario ya estaba verificado o no se pudo actualizar.";
            }
        } catch (\PDOException $e) {
            $_SESSION['error_msg'] = "Error al verificar.";
        }
        header("Location: $targetUrl");
        exit();
    }

    if ($action === 'change_status') {
        $estado = $_POST['estado'] ?? 'activo';
        $allowed = ['activo', 'suspendido', 'baneado', 'sin_verificar'];

        if (in_array($estado, $allowed)) {
            try {
                $stmt = $pdo->prepare("UPDATE usuarios SET estado = ? WHERE id = ?");
                $stmt->execute([$estado, $user_id]);
                $_SESSION['success_msg'] = "Estado actualizado a " . ucfirst($estado) . ".";
            } catch (\PDOException $e) {
                $_SESSION['error_msg'] = "Error al actualizar estado.";
            }
        }
        header("Location: $targetUrl");
        exit();
    }

    if ($action === 'soft_delete') {
        try {
            $stmt = $pdo->prepare("UPDATE usuarios SET deleted_at = CURRENT_TIMESTAMP WHERE id = ?");
            $stmt->execute([$user_id]);
            $_SESSION['success_msg'] = "Usuario eliminado (Soft Delete).";
            header("Location: ../panel/admin.php");
            exit();
        } catch (\PDOException $e) {
            $_SESSION['error_msg'] = "Error al eliminar usuario.";
            header("Location: $targetUrl");
            exit();
        }
    }
}
