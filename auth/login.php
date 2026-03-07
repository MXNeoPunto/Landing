<?php
require_once '../config/db.php';
require_once '../includes/security.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $error = "Token de seguridad inválido.";
    } else {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'] ?? '';

        if (!$email || empty($password)) {
            $error = "Credenciales inválidas.";
        } else {
            try {
                $stmt = $pdo->prepare("SELECT id, username, rol, password FROM usuarios WHERE email = ?");
                $stmt->execute([$email]);
                $user = $stmt->fetch();

                if ($user && password_verify($password, $user['password'])) {
                    // Password es correcto, regeneramos id de session por seguridad
                    session_regenerate_id(true);

                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['rol'] = $user['rol'];

                    if ($user['rol'] === 'admin') {
                        header('Location: ../panel/admin.php');
                    } else {
                        header('Location: ../panel/cliente.php');
                    }
                    exit();
                } else {
                    $error = "Correo o contraseña incorrectos.";
                }
            } catch (PDOException $e) {
                $error = "Error al intentar iniciar sesión.";
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
    <title>Iniciar Sesión - NeoPunto</title>
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
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

<div class="glass-card w-full max-w-md p-8">
    <div class="text-center mb-8">
        <a href="../index.php" class="text-2xl font-bold text-neoBlue block mb-2">NeoPunto</a>
        <h1 class="text-2xl font-semibold text-appleBlack">Bienvenido de nuevo</h1>
        <p class="text-gray-500 mt-2">Inicia sesión en tu cuenta</p>
    </div>

    <?php if ($error): ?>
        <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 text-sm border border-red-100">
            <i class="fa-solid fa-circle-exclamation mr-2"></i><?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">

        <div class="space-y-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                <input type="email" name="email" required class="input-apple w-full" placeholder="tu@correo.com">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                <input type="password" name="password" required class="input-apple w-full" placeholder="••••••••">
            </div>

            <div class="flex items-center justify-end">
                <a href="olvide_password.php" class="text-sm text-neoBlue hover:underline font-medium">¿Olvidaste tu contraseña?</a>
            </div>

            <button type="submit" class="btn-apple mt-4">Iniciar Sesión</button>
        </div>
    </form>
            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white/70 text-gray-500 rounded-full">O continúa con</span>
                    </div>
                </div>

                <p class="text-xs text-center text-gray-500 mt-2 mb-4">(Solo se puede iniciar o conectar redes sociales si ya creó una cuenta)</p>

                <div class="mt-6 grid grid-cols-2 gap-3">
                    <div>
                        <a href="https://accounts.google.com/o/oauth2/v2/auth?client_id=YOUR_GOOGLE_CLIENT_ID&redirect_uri=https://neopunto.com/controllers/AuthController.php?action=oauth_google&response_type=code&scope=email profile" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-xl shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 backdrop-blur-md transition">
                            <span class="sr-only">Sign in with Google</span>
                            <i class="fa-brands fa-google text-red-500 text-lg"></i>
                        </a>
                    </div>
                    <div>
                        <a href="https://www.facebook.com/v19.0/dialog/oauth?client_id=YOUR_FACEBOOK_APP_ID&redirect_uri=https://neopunto.com/controllers/AuthController.php?action=oauth_facebook&scope=email,public_profile" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-xl shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 backdrop-blur-md transition">
                            <span class="sr-only">Sign in with Facebook</span>
                            <i class="fa-brands fa-facebook text-blue-600 text-lg"></i>
                        </a>
                    </div>
                </div>
            </div>

    <div class="text-center mt-6 text-sm text-gray-500">
        ¿No tienes cuenta? <a href="registro.php" class="text-neoBlue hover:underline font-medium">Crea una ahora</a>
    </div>
</div>

</body>
</html>
