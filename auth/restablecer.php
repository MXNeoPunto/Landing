<?php
require_once '../config/db.php';
require_once '../includes/security.php';

$error = '';
$success = '';

$email = $_SESSION['reset_email'] ?? '';

if (empty($email)) {
    header('Location: olvide_password.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $error = "Token de seguridad inválido.";
    } else {
        $otp = trim($_POST['otp'] ?? '');
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        if (empty($otp) || empty($new_password) || empty($confirm_password)) {
            $error = "Todos los campos son obligatorios.";
        } elseif ($new_password !== $confirm_password) {
            $error = "Las contraseñas no coinciden.";
        } elseif (strlen($new_password) < 8) {
            $error = "La contraseña debe tener al menos 8 caracteres.";
        } else {
            try {
                // Verificar OTP
                $stmt = $pdo->prepare("SELECT id FROM password_resets WHERE email = ? AND token = ? AND expira > NOW() ORDER BY creado_en DESC LIMIT 1");
                $stmt->execute([$email, $otp]);
                $reset = $stmt->fetch();

                if ($reset) {
                    // Hash nueva contraseña
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                    // Actualizar contraseña
                    $stmt_update = $pdo->prepare("UPDATE usuarios SET password = ? WHERE email = ?");
                    $stmt_update->execute([$hashed_password, $email]);

                    // Eliminar OTPs usados
                    $stmt_del = $pdo->prepare("DELETE FROM password_resets WHERE email = ?");
                    $stmt_del->execute([$email]);

                    unset($_SESSION['reset_email']); // Limpiar sesión
                    $success = "Contraseña actualizada exitosamente. Ya puedes iniciar sesión.";
                } else {
                    $error = "El código OTP es inválido o ha expirado.";
                }
            } catch (PDOException $e) {
                $error = "Error al intentar cambiar la contraseña.";
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
    <title>Nueva Contraseña - NeoPunto</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        .otp-input {
            text-align: center;
            letter-spacing: 0.5em;
            font-family: monospace;
            font-size: 1.5rem;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

<div class="glass-card w-full max-w-md p-8">
    <div class="text-center mb-8">
        <h1 class="text-2xl font-semibold text-appleBlack">Ingresa tu código</h1>
        <p class="text-gray-500 mt-2">Enviamos un OTP a <?php echo htmlspecialchars($email); ?></p>
        <p class="text-xs text-gray-400 mt-1">(Verifica tu base de datos simulada para obtenerlo)</p>
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
        <div class="text-center mt-4">
            <a href="login.php" class="btn-apple inline-block">Ir a Iniciar Sesión</a>
        </div>
    <?php else: ?>

    <form method="POST" action="">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">

        <div class="space-y-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Código de 6 dígitos</label>
                <input type="text" name="otp" required maxlength="6" class="input-apple w-full otp-input" placeholder="000000" autocomplete="off">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nueva Contraseña</label>
                <input type="password" name="new_password" required minlength="8" class="input-apple w-full" placeholder="••••••••">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Confirmar Contraseña</label>
                <input type="password" name="confirm_password" required minlength="8" class="input-apple w-full" placeholder="••••••••">
            </div>

            <button type="submit" class="btn-apple mt-4">Cambiar Contraseña</button>
        </div>
    </form>

    <?php endif; ?>
</div>

</body>
</html>
