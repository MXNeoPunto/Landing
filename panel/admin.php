<?php
require_once '../config/db.php';
require_once '../includes/security.php';

check_auth();

if ($_SESSION['rol'] !== 'admin') {
    header('Location: cliente.php');
    exit();
}

$stmt = $pdo->query("SELECT id, username, email, pais, rol, creado_en FROM usuarios ORDER BY id DESC LIMIT 10");
$users = $stmt->fetchAll();

$totalStmt = $pdo->query("SELECT COUNT(*) FROM usuarios");
$totalUsers = $totalStmt->fetchColumn();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrador - NeoPunto</title>
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
<nav class="bg-gray-900 text-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="../index.php" class="text-xl font-bold text-white tracking-wide">NeoPunto <span class="font-normal text-neoBlue">Admin</span></a>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-sm font-medium text-gray-300"><i class="fa-solid fa-user-shield mr-2 text-neoBlue"></i>Administrador</span>
                <a href="../auth/logout.php" class="text-red-400 hover:text-red-300 text-sm font-medium ml-4 border-l border-gray-700 pl-4"><i class="fa-solid fa-power-off mr-1"></i> Salir</a>
            </div>
        </div>
    </div>
</nav>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-semibold text-appleBlack tracking-tight">Dashboard General</h1>
            <p class="text-gray-500 mt-1">Resumen del sistema y últimos registros.</p>
        </div>

        <div class="glass-card px-6 py-4 flex items-center shadow-sm">
            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mr-4">
                <i class="fa-solid fa-users text-xl"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Total Usuarios</p>
                <p class="text-2xl font-bold text-gray-900"><?php echo htmlspecialchars($totalUsers); ?></p>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="glass-card overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-white">
            <h2 class="text-lg font-semibold text-gray-800">Últimos Registros</h2>
            <button class="text-sm text-neoBlue font-medium hover:underline">Ver todos</button>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">País</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rol</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    <?php if (count($users) > 0): ?>
                        <?php foreach ($users as $u): ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">#<?php echo htmlspecialchars($u['id']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($u['username']); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($u['email']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><i class="fa-solid fa-flag text-gray-300 mr-1"></i> <?php echo htmlspecialchars($u['pais']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if($u['rol'] === 'admin'): ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">Admin</span>
                                <?php else: ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Cliente</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo date('d/m/Y', strtotime($u['creado_en'])); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-sm text-gray-500">No hay usuarios registrados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

</body>
</html>
