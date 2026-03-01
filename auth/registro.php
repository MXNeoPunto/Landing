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
    } else {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $username = trim($_POST['username'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $pais = trim($_POST['pais'] ?? '');
        $password = $_POST['password'] ?? '';

        if (!$email || empty($username) || empty($telefono) || empty($pais) || empty($password)) {
            $error = "Todos los campos son requeridos.";
        } else {
            // Asignar moneda
            $moneda = (strtolower($pais) === 'guatemala') ? 'Quetzal' : 'Dólar';

            // Hash password (PHP 8.4 usa un algoritmo fuerte por defecto con PASSWORD_DEFAULT, usualmente bcrypt o argon2i)
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            try {
                $stmt = $pdo->prepare("INSERT INTO usuarios (email, username, telefono, pais, moneda, password) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$email, $username, $telefono, $pais, $moneda, $hashed_password]);
                $success = "Cuenta creada exitosamente. Ya puedes iniciar sesión.";
            } catch (PDOException $e) {
                if ($e->getCode() == 23000) { // Duplicate entry
                    $error = "El correo o nombre de usuario ya está registrado.";
                } else {
                    $error = "Error al crear la cuenta. Intenta nuevamente.";
                }
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
    <title>Crear Cuenta - NeoPunto</title>
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
        <a href="../index.php" class="text-2xl font-bold text-neoBlue block mb-2">NeoPunto</a>
        <h1 class="text-2xl font-semibold text-appleBlack">Crear Cuenta</h1>
        <p class="text-gray-500 mt-2">Únete a nosotros para continuar</p>
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
            <a href="login.php" class="text-neoBlue hover:underline font-medium">Ir a Iniciar Sesión</a>
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

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre de Usuario</label>
                <input type="text" name="username" required class="input-apple w-full" placeholder="usuario123">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Número de Teléfono</label>
                <input type="tel" name="telefono" required class="input-apple w-full" placeholder="+502 12345678">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">País</label>
                <select name="pais" required class="input-apple w-full text-gray-700">
                    <option value="">Selecciona tu país</option>
                    <option value="Guatemala">Guatemala</option>
                    <option value="México">México</option>
                    <option value="El Salvador">El Salvador</option>
                    <option value="Honduras">Honduras</option>
                    <option value="Nicaragua">Nicaragua</option>
                    <option value="Costa Rica">Costa Rica</option>
                    <option value="Panamá">Panamá</option>
                    <option value="Colombia">Colombia</option>
                    <!-- Añadir más según Latam -->
                </select>
                <p class="text-xs text-gray-500 mt-1">Tu moneda se configurará automáticamente.</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                <input type="password" name="password" required class="input-apple w-full" placeholder="••••••••">
            </div>

            <!-- Custom Captcha -->
            <div class="captcha-slider-container">
                <div class="captcha-text">Desliza para verificar</div>
                <div class="captcha-slider-track"></div>
                <div class="captcha-slider-handle"><i class="fa-solid fa-arrow-right"></i></div>
            </div>

            <button type="submit" class="btn-apple mt-4">Crear Cuenta</button>
        </div>
    </form>

    <div class="text-center mt-6 text-sm text-gray-500">
        ¿Ya tienes cuenta? <a href="login.php" class="text-neoBlue hover:underline font-medium">Iniciar sesión</a>
    </div>

    <?php endif; ?>
</div>

<script src="../assets/js/captcha.js"></script>
</body>
</html>
