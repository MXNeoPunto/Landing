<?php
require_once '../config/db.php';
require_once '../includes/security.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $error = "Token de seguridad inválido.";
    } elseif (empty($_POST['captcha_token'])) {
        $error = "Por favor verifica que eres humano.";
    } elseif (!rate_limit_check('reset_pwd_limit', 3, 300)) { // Max 3 intentos cada 5 min
        $error = "Demasiados intentos. Por favor espera 5 minutos.";
    } else {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

        if (!$email) {
            $error = "Por favor ingresa un correo válido.";
        } else {
            try {
                // Verificar si existe el correo
                $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
                $stmt->execute([$email]);

                if ($stmt->fetch()) {
                    // Generar OTP de 6 dígitos
                    $otp = sprintf("%06d", random_int(0, 999999));
                    $expira = date('Y-m-d H:i:s', strtotime('+15 minutes'));

                    // Guardar OTP
                    $stmt_otp = $pdo->prepare("INSERT INTO password_resets (email, token, expira) VALUES (?, ?, ?)");
                    $stmt_otp->execute([$email, $otp, $expira]);

                    // Aquí simulamos el envío de correo usando mail() de PHP
                    // ya que está configurado Amazon SES a través del servidor o en configuraciones similares.
                    // Si tienes PHPMailer instalado por composer, podrías usarlo. Para este demo simularemos:

                    $to = $email;
                    $subject = "Restablecer tu contraseña - NeoPunto";
                    $message = "Tu código OTP para restablecer tu contraseña es: " . $otp . "\n\nEste código expira en 15 minutos.";
                    $headers = "From: " . SMTP_FROM_NAME . " <" . SMTP_FROM_EMAIL . ">\r\n";

                    // @mail($to, $subject, $message, $headers); // Simulación de envío

                    // Guardar email temporalmente en sesión para el siguiente paso
                    $_SESSION['reset_email'] = $email;

                    header('Location: restablecer.php');
                    exit();
                } else {
                    // Mensaje genérico por seguridad (no revelar si existe o no)
                    $success = "Si tu correo está registrado, recibirás un OTP con instrucciones.";
                }
            } catch (PDOException $e) {
                $error = "Error al procesar la solicitud.";
            } catch (Exception $e) {
                $error = "Error inesperado.";
            }
        }
    }
}

$csrf_token = generate_csrf_token();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña - NeoPunto</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/captcha.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        appleBlack: '#1d1d1f',
                        appleGray: '#f5f5f7',
                        neoBlue: '#0066cc',
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #f5f5f7; color: #1d1d1f; }
        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(16px);
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
            border: none;
        }
        .input-apple {
            background-color: #ffffff;
            border: 1px solid #d2d2d7;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        .input-apple:focus {
            outline: none;
            border-color: #0066cc;
            box-shadow: 0 0 0 4px rgba(0, 102, 204, 0.1);
        }
        .btn-apple {
            background-color: #0066cc;
            color: white;
            border-radius: 12px;
            padding: 14px 20px;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.2s ease;
            width: 100%;
        }
        .btn-apple:hover { background-color: #005bb5; transform: scale(0.98); }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

<div class="glass-card w-full max-w-md p-8">
    <div class="text-center mb-8">
        <h1 class="text-2xl font-semibold text-appleBlack">Recuperar Acceso</h1>
        <p class="text-gray-500 mt-2">Te enviaremos un código OTP a tu correo</p>
    </div>

    <?php if ($error): ?>
        <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 text-sm border border-red-100">
            <i class="fa-solid fa-circle-exclamation mr-2"></i><?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="bg-green-50 text-green-600 p-4 rounded-xl mb-6 text-sm border border-green-100">
            <i class="fa-solid fa-circle-check mr-2"></i><?php echo htmlspecialchars($success); ?>
        </div>
    <?php else: ?>

    <form method="POST" action="">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
        <input type="hidden" name="captcha_token" id="captcha_token" value="">

        <div class="space-y-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                <input type="email" name="email" required class="input-apple w-full" placeholder="tu@correo.com">
            </div>

            <!-- Custom Captcha -->
            <div class="captcha-slider-container">
                <div class="captcha-text">Desliza para verificar</div>
                <div class="captcha-slider-track"></div>
                <div class="captcha-slider-handle"><i class="fa-solid fa-arrow-right"></i></div>
            </div>

            <button type="submit" class="btn-apple mt-4">Enviar Código OTP</button>
        </div>
    </form>

    <?php endif; ?>

    <div class="text-center mt-6 text-sm text-gray-500">
        <a href="login.php" class="text-neoBlue hover:underline font-medium"><i class="fa-solid fa-arrow-left mr-1"></i> Volver a Iniciar Sesión</a>
    </div>
</div>

<script src="../assets/js/captcha.js"></script>
</body>
</html>
