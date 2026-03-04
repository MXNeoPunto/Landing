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


    if ($_POST['action'] === 'update_gateways') {
        // Toggle gateways
        $n1co = isset($_POST['n1co_active']) ? 'activo' : 'inactivo';
        $paypal = isset($_POST['paypal_active']) ? 'activo' : 'inactivo';
        $tilopay = isset($_POST['tilopay_active']) ? 'activo' : 'inactivo';

        // Ensure they exist in DB, if not insert, if yes update
        $gateways = [
            'N1co E-Pay' => ['tipo' => 'pasarela', 'estado' => $n1co, 'monedas' => 'GTQ,USD'],
            'PayPal' => ['tipo' => 'pasarela', 'estado' => $paypal, 'monedas' => 'USD'],
            'Tilopay' => ['tipo' => 'pasarela', 'estado' => $tilopay, 'monedas' => 'GTQ']
        ];

        try {
            foreach ($gateways as $nombre => $data) {
                // Check if exists
                $stmt = $pdo->prepare("SELECT id FROM metodos_pago WHERE nombre = ? AND tipo = 'pasarela'");
                $stmt->execute([$nombre]);
                $exists = $stmt->fetchColumn();

                if ($exists) {
                    $update = $pdo->prepare("UPDATE metodos_pago SET estado = ? WHERE id = ?");
                    $update->execute([$data['estado'], $exists]);
                } else {
                    $insert = $pdo->prepare("INSERT INTO metodos_pago (nombre, tipo, estado, monedas_soportadas) VALUES (?, ?, ?, ?)");
                    $insert->execute([$nombre, $data['tipo'], $data['estado'], $data['monedas']]);
                }
            }
            $_SESSION['success_msg'] = "Pasarelas actualizadas.";
        } catch (\PDOException $e) {
            $_SESSION['error_msg'] = "Error: " . $e->getMessage();
        }
    }

    elseif ($_POST['action'] === 'create_bank') {
        // Create bank transfer method
        $banco = $_POST['banco'] ?? '';
        $tipo_cuenta = $_POST['tipo_cuenta'] ?? '';
        $numero_cuenta = $_POST['numero_cuenta'] ?? '';
        $nombre_titular = $_POST['nombre_titular'] ?? '';
        $moneda = $_POST['moneda'] ?? 'GTQ';

        // Combine into JSON config
        $config = json_encode([
            'banco' => $banco,
            'tipo_cuenta' => $tipo_cuenta,
            'numero_cuenta' => $numero_cuenta,
            'nombre_titular' => $nombre_titular
        ]);

        $nombre = "Transferencia - $banco";

        try {
            $stmt = $pdo->prepare("INSERT INTO metodos_pago (nombre, tipo, estado, configuracion, monedas_soportadas) VALUES (?, 'transferencia', 'activo', ?, ?)");
            $stmt->execute([$nombre, $config, $moneda]);
            $_SESSION['success_msg'] = "Cuenta bancaria agregada.";
        } catch (\PDOException $e) {
            $_SESSION['error_msg'] = "Error al agregar cuenta: " . $e->getMessage();
        }
    }

    elseif ($_POST['action'] === 'delete_bank' && isset($_POST['id'])) {
        try {
            $stmt = $pdo->prepare("DELETE FROM metodos_pago WHERE id = ? AND tipo = 'transferencia'");
            $stmt->execute([$_POST['id']]);
            $_SESSION['success_msg'] = "Cuenta eliminada.";
        } catch (\PDOException $e) {
            $_SESSION['error_msg'] = "Error al eliminar: " . $e->getMessage();
        }
    }

    elseif ($_POST['action'] === 'verify_payment' && isset($_POST['factura_id']) && isset($_POST['estado'])) {
        try {
            $estado = in_array($_POST['estado'], ['pagado', 'fallido']) ? $_POST['estado'] : 'en_revision';
            $stmt = $pdo->prepare("UPDATE facturas SET estado_pago = ? WHERE id = ?");
            $stmt->execute([$estado, $_POST['factura_id']]);
            $_SESSION['success_msg'] = "Pago " . ($estado === 'pagado' ? "aprobado" : "rechazado") . " correctamente.";
        } catch (\PDOException $e) {
            $_SESSION['error_msg'] = "Error al verificar pago: " . $e->getMessage();
        }
    }

    if (php_sapi_name() !== 'cli') {
        header('Location: ../panel/admin.php');
        exit();
    }
}
