<?php
require_once '../config/db.php';
require_once '../includes/security.php';

check_auth();

if ($_SESSION['rol'] !== 'cliente') {
    header('Location: admin.php');
    exit();
}

$stmt = $pdo->prepare("SELECT email, username, telefono, pais, moneda, creado_en FROM usuarios WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Cliente - NeoPunto</title>
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
    </style>
</head>
<body class="min-h-screen">

<!-- Simple Navbar -->
<nav class="bg-white/80 backdrop-blur-xl border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="../index.php" class="text-xl font-bold text-neoBlue">NeoPunto</a>
                <span class="ml-4 text-sm font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full">Panel Cliente</span>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-sm font-medium text-gray-700"><i class="fa-solid fa-user-circle mr-2 text-gray-400 text-lg"></i><?php echo htmlspecialchars($user['username']); ?></span>
                <a href="../auth/logout.php" class="text-red-500 hover:text-red-700 text-sm font-medium"><i class="fa-solid fa-arrow-right-from-bracket mr-1"></i> Salir</a>
            </div>
        </div>
    </div>
</nav>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="mb-8">
        <h1 class="text-3xl font-semibold text-appleBlack tracking-tight">Hola, <?php echo htmlspecialchars($user['username']); ?></h1>
        <p class="text-gray-500 mt-1">Bienvenido a tu panel de control NeoPunto.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- User Info Card -->
        <div class="glass-card p-6 md:col-span-2">
            <h2 class="text-lg font-semibold border-b border-gray-100 pb-4 mb-4"><i class="fa-regular fa-address-card text-neoBlue mr-2"></i> Información de la Cuenta</h2>

            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Correo Electrónico</dt>
                    <dd class="mt-1 text-base text-gray-900"><?php echo htmlspecialchars($user['email']); ?></dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Teléfono</dt>
                    <dd class="mt-1 text-base text-gray-900"><?php echo htmlspecialchars($user['telefono']); ?></dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">País</dt>
                    <dd class="mt-1 text-base text-gray-900"><i class="fa-solid fa-earth-americas text-gray-400 mr-1"></i> <?php echo htmlspecialchars($user['pais']); ?></dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Moneda Asignada</dt>
                    <dd class="mt-1 text-base font-medium <?php echo $user['moneda'] === 'Quetzal' ? 'text-green-600' : 'text-blue-600'; ?>">
                        <i class="fa-solid fa-coins mr-1"></i> <?php echo htmlspecialchars($user['moneda']); ?>
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Miembro desde</dt>
                    <dd class="mt-1 text-sm text-gray-600"><?php echo date('d M Y', strtotime($user['creado_en'])); ?></dd>
                </div>
            </dl>
        </div>

        <!-- Simulated Actions -->
        <div class="glass-card p-6 flex flex-col justify-between bg-gradient-to-br from-white to-blue-50">
            <div>
                <h2 class="text-lg font-semibold mb-4 text-neoBlue">Tus Servicios</h2>
                <div class="space-y-4">
                    <div class="flex items-center p-3 bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mr-3">
                            <i class="fa-solid fa-globe"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Landing Page</p>
                            <p class="text-xs text-green-500 font-medium">Activo</p>
                        </div>
                    </div>
                    <div class="flex items-center p-3 bg-white rounded-xl shadow-sm border border-gray-100 opacity-60">
                        <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 mr-3">
                            <i class="fa-solid fa-mobile-screen"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">App Móvil</p>
                            <p class="text-xs text-gray-500 font-medium">Sin contratar</p>
                        </div>
                    </div>
                </div>
            </div>

            <button class="mt-6 w-full py-3 bg-white border-2 border-neoBlue text-neoBlue font-medium rounded-xl hover:bg-blue-50 transition-colors text-sm">
                Solicitar Soporte
            </button>
        </div>
    </div>
</main>

</body>
</html>
