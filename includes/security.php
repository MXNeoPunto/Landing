<?php
session_start();

function generate_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf_token($token) {
    if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        return false;
    }
    return true;
}

function rate_limit_check($key, $max_requests = 5, $time_window = 300) {
    if (!isset($_SESSION[$key])) {
        $_SESSION[$key] = [];
    }

    // Remove old requests
    $_SESSION[$key] = array_filter($_SESSION[$key], function($timestamp) use ($time_window) {
        return ($timestamp > (time() - $time_window));
    });

    if (count($_SESSION[$key]) >= $max_requests) {
        return false; // Limit exceeded
    }

    $_SESSION[$key][] = time();
    return true; // Limit not exceeded
}



function check_auth() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /auth/login.php');
        exit();
    }
}

// Global Config & Maintenance Check
if (isset($pdo)) {
    try {
        $configStmt = $pdo->query("SELECT mantenimiento, zona_horaria FROM config_general WHERE id = 1");
        $globalConfig = $configStmt->fetch();

        if ($globalConfig) {
            if (!empty($globalConfig['zona_horaria'])) {
                date_default_timezone_set($globalConfig['zona_horaria']);
            }

            // Maintenance mode check
            $currentPath = $_SERVER['SCRIPT_NAME'];
            $isAdminRoute = strpos($currentPath, '/panel/admin') !== False;
            $isAuthRoute = strpos($currentPath, '/auth/') !== False;
            $isApiRoute = strpos($currentPath, '/controllers/') !== False;
            $isMantenimientoPage = strpos($currentPath, '/mantenimiento.php') !== False;

            if ($globalConfig['mantenimiento'] && !$isMantenimientoPage) {
                // If logged in, only admins can bypass
                $canBypass = isset($_SESSION['rol']) && in_array($_SESSION['rol'], ['admin', 'admin_principal', 'admin_secundario']);

                if (!$canBypass && !$isAuthRoute && !$isApiRoute) {
                    header('Location: /mantenimiento.php');
                    exit();
                }
            }
        }
    } catch (\PDOException $e) {
        // Suppress DB errors here to prevent breaking pages before install
    }
}


// Global Config & Maintenance Check
if (isset($pdo)) {
    try {
        $configStmt = $pdo->query("SELECT mantenimiento, zona_horaria FROM config_general WHERE id = 1");
        $globalConfig = $configStmt->fetch();

        if ($globalConfig) {
            if (!empty($globalConfig['zona_horaria'])) {
                date_default_timezone_set($globalConfig['zona_horaria']);
            }

            // Maintenance mode check
            $currentPath = $_SERVER['SCRIPT_NAME'];
            $isAdminRoute = strpos($currentPath, '/panel/admin') !== False;
            $isAuthRoute = strpos($currentPath, '/auth/') !== False;
            $isApiRoute = strpos($currentPath, '/controllers/') !== False;
            $isMantenimientoPage = strpos($currentPath, '/mantenimiento.php') !== False;

            if ($globalConfig['mantenimiento'] && !$isMantenimientoPage) {
                // If logged in, only admins can bypass
                $canBypass = isset($_SESSION['rol']) && in_array($_SESSION['rol'], ['admin', 'admin_principal', 'admin_secundario']);

                if (!$canBypass && !$isAuthRoute && !$isApiRoute) {
                    header('Location: /mantenimiento.php');
                    exit();
                }
            }
        }
    } catch (\PDOException $e) {
        // Suppress DB errors here to prevent breaking pages before install
    }
}
