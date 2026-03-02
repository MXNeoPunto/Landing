<?php
$rootDir = dirname(__DIR__);
require_once $rootDir . '/config/db.php';
require_once $rootDir . '/includes/security.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    // Simulate Email Verification / Password Recovery Request
    if ($_POST['action'] === 'request_reset') {
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL); // fix from INPUT_POST which doesn't see direct $_POST overrides in CLI

        if ($email) {
            global $pdo;
            $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
            $stmt->execute([$email]);

            if ($stmt->fetch()) {
                // Generate token
                $token = sprintf('%06d', mt_rand(100000, 999999));
                $expira = date('Y-m-d H:i:s', strtotime('+1 hour'));

                // Insert into password_resets
                $ins = $pdo->prepare("INSERT INTO password_resets (email, token, expira) VALUES (?, ?, ?)");
                $ins->execute([$email, $token, $expira]);

                // Fetch SMTP settings
                $smtp = $pdo->query("SELECT smtp_host, smtp_user, smtp_from_email, smtp_from_name FROM config_general WHERE id = 1")->fetch();

                // Simulate Email Sending using native mail() or mock logic
                // In a real app with AWS SES, you'd use PHPMailer or AWS SDK here
                // For this native/no-dep requirement, we mock it or use mail() if sendmail is configured

                $to = $email;
                $subject = "Recuperación de Contraseña - NeoPunto";
                $message = "Tu código de recuperación es: " . $token;
                $headers = "From: " . ($smtp['smtp_from_name'] ?? 'NeoPunto') . " <" . ($smtp['smtp_from_email'] ?? 'noreply@neopunto.com') . ">\r\n";

                // @mail($to, $subject, $message, $headers); // Commented out to prevent errors in non-configured envs

                $_SESSION['success_msg'] = "Si el correo existe, se ha enviado un código de recuperación. (MOCK: $token)";
            } else {
                $_SESSION['success_msg'] = "Si el correo existe, se ha enviado un código de recuperación."; // Generic message to prevent enum
            }
        } else {
            $_SESSION['error_msg'] = "Correo inválido.";
        }

        if (php_sapi_name() !== 'cli') {
            header('Location: ../auth/olvide_password.php');
            exit();
        }
    }
}

    // OAuth: Google Callback Stub
    if ((isset($_POST['action']) && $_POST['action'] === 'oauth_google') || isset($_GET['code'])) {
        // En una app real, aquí se verifica el estado (CSRF),
        // se intercambia \$_GET['code'] por un access_token vía cURL,
        // se obtienen los datos del usuario (email, nombre) desde la API de Google,
        // y se registra o inicia sesión al usuario.

        $code = $_GET['code'] ?? null;
        if ($code) {
            // Ejemplo de llamada cURL que se haría:
            // \$ch = curl_init('https://oauth2.googleapis.com/token');
            // curl_setopt(\$ch, CURLOPT_POSTFIELDS, ...);
            // \$response = curl_exec(\$ch);

            // En Producción: Aquí se verificaría el token con la API de Google
            // Como no tenemos credenciales reales configuradas, mostramos un error en lugar de simular acceso.
            $_SESSION['error_msg'] = "La autenticación de Google no está configurada.";

            if (php_sapi_name() !== 'cli') {
                header('Location: ../panel/cliente.php');
                exit();
            }
        }
    }
