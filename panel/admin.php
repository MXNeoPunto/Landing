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
    <!-- General Settings Form -->
    <div class="glass-card overflow-hidden mt-8 backdrop-blur-md bg-white/50 rounded-3xl shadow-lg">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-white/80">
            <h2 class="text-xl font-semibold text-gray-800"><i class="fa-solid fa-cogs text-neoBlue mr-2"></i> Configuración General</h2>
        </div>
        <div class="p-6">
            <form action="../controllers/SettingsController.php" method="POST" enctype="multipart/form-data" class="space-y-6">
                <input type="hidden" name="action" value="update_general">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generate_csrf_token()); ?>">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- SMTP Settings -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Configuración SMTP (Amazon SES)</h3>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Host SMTP</label>
                            <input type="text" name="smtp_host" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-neoBlue focus:ring-neoBlue sm:text-sm px-4 py-2 bg-white/70" placeholder="email-smtp.us-east-1.amazonaws.com">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Puerto</label>
                                <input type="number" name="smtp_port" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-neoBlue focus:ring-neoBlue sm:text-sm px-4 py-2 bg-white/70" placeholder="587">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Usuario SMTP</label>
                                <input type="text" name="smtp_user" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-neoBlue focus:ring-neoBlue sm:text-sm px-4 py-2 bg-white/70">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Contraseña SMTP</label>
                            <input type="password" name="smtp_pass" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-neoBlue focus:ring-neoBlue sm:text-sm px-4 py-2 bg-white/70">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email Remitente</label>
                                <input type="email" name="smtp_from_email" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-neoBlue focus:ring-neoBlue sm:text-sm px-4 py-2 bg-white/70" placeholder="no-reply@tudominio.com">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nombre Remitente</label>
                                <input type="text" name="smtp_from_name" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-neoBlue focus:ring-neoBlue sm:text-sm px-4 py-2 bg-white/70" placeholder="NeoPunto">
                            </div>
                        </div>
                    </div>

                    <!-- SEO & Branding -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900 border-b pb-2">SEO y Branding</h3>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Meta Título Global</label>
                            <input type="text" name="seo_title" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-neoBlue focus:ring-neoBlue sm:text-sm px-4 py-2 bg-white/70">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Meta Descripción</label>
                            <textarea name="seo_description" rows="2" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-neoBlue focus:ring-neoBlue sm:text-sm px-4 py-2 bg-white/70"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Keywords (separadas por coma)</label>
                            <input type="text" name="seo_keywords" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-neoBlue focus:ring-neoBlue sm:text-sm px-4 py-2 bg-white/70">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Logo Header</label>
                                <input type="file" name="logo_header" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Favicon</label>
                                <input type="file" name="favicon" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-gray-200">
                    <button type="submit" class="bg-neoBlue text-white px-6 py-2 rounded-full font-medium hover:bg-blue-700 transition shadow-md shadow-blue-500/30">
                        Guardar Configuración
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- Payment Methods Config -->
    <div class="glass-card overflow-hidden mt-8 backdrop-blur-md bg-white/50 rounded-3xl shadow-lg">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-white/80">
            <h2 class="text-xl font-semibold text-gray-800"><i class="fa-solid fa-credit-card text-neoBlue mr-2"></i> Métodos de Pago</h2>
        </div>
        <div class="p-6">
            <form action="../controllers/PaymentsController.php" method="POST" class="space-y-6">
                <input type="hidden" name="action" value="update_gateways">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generate_csrf_token()); ?>">

                <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Pasarelas de Pago</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- N1co -->
                    <div class="border rounded-2xl p-4 bg-white/70 shadow-sm flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <i class="fa-brands fa-cc-visa text-3xl text-blue-600"></i>
                            <div>
                                <p class="font-semibold text-gray-800">N1co E-Pay</p>
                                <p class="text-xs text-gray-500">GTQ / USD</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="n1co_active" value="1" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-neoBlue"></div>
                        </label>
                    </div>

                    <!-- PayPal -->
                    <div class="border rounded-2xl p-4 bg-white/70 shadow-sm flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <i class="fa-brands fa-paypal text-3xl text-blue-500"></i>
                            <div>
                                <p class="font-semibold text-gray-800">PayPal</p>
                                <p class="text-xs text-gray-500">USD</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="paypal_active" value="1" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-neoBlue"></div>
                        </label>
                    </div>

                    <!-- Tilopay -->
                    <div class="border rounded-2xl p-4 bg-white/70 shadow-sm flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <i class="fa-solid fa-money-bill-wave text-3xl text-green-500"></i>
                            <div>
                                <p class="font-semibold text-gray-800">Tilopay</p>
                                <p class="text-xs text-gray-500">GTQ</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="tilopay_active" value="1" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-neoBlue"></div>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="bg-gray-800 text-white px-6 py-2 rounded-full font-medium hover:bg-black transition shadow-md shadow-gray-500/30">
                        Actualizar Pasarelas
                    </button>
                </div>
            </form>

            <hr class="my-6 border-gray-200">

            <!-- Bank Transfers -->
            <div class="flex justify-between items-center border-b pb-2 mb-4">
                <h3 class="text-lg font-medium text-gray-900">Transferencias Bancarias (Guatemala)</h3>
                <button onclick="document.getElementById('bankModal').classList.remove('hidden')" class="bg-neoBlue text-white px-4 py-1.5 rounded-full text-sm font-medium hover:bg-blue-700 transition">
                    + Nueva Cuenta
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 rounded-t-xl">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Banco</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Número</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titular</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Moneda</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100" id="bankAccountsList">
                        <?php
                        $bancos = $pdo->query("SELECT id, configuracion, monedas_soportadas FROM metodos_pago WHERE tipo = 'transferencia'")->fetchAll();
                        foreach($bancos as $b):
                            $conf = json_decode($b['configuracion'], true);
                        ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900"><?php echo htmlspecialchars($conf['banco'] ?? ''); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-500"><?php echo htmlspecialchars($conf['tipo_cuenta'] ?? ''); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-500"><?php echo htmlspecialchars($conf['numero_cuenta'] ?? ''); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-500"><?php echo htmlspecialchars($conf['nombre_titular'] ?? ''); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-500"><?php echo htmlspecialchars($b['monedas_soportadas']); ?></td>
                            <td class="px-6 py-4 text-right text-sm font-medium">
                                <form action="../controllers/PaymentsController.php" method="POST" onsubmit="return confirm('¿Eliminar cuenta?');">
                                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generate_csrf_token()); ?>">
                                    <input type="hidden" name="action" value="delete_bank">
                                    <input type="hidden" name="id" value="<?php echo $b['id']; ?>">
                                    <button type="submit" class="text-red-500 hover:text-red-700">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal for new Bank Account -->
    <div id="bankModal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center backdrop-blur-sm">
        <div class="glass-card w-full max-w-md p-6 relative bg-white">
            <button onclick="document.getElementById('bankModal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
            <h3 class="text-xl font-semibold mb-4 text-appleBlack">Agregar Cuenta Bancaria</h3>
            <form action="../controllers/PaymentsController.php" method="POST" class="space-y-4">
                <input type="hidden" name="action" value="create_bank">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generate_csrf_token()); ?>">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Banco</label>
                    <select name="banco" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-neoBlue focus:ring-neoBlue sm:text-sm px-4 py-2 bg-gray-50" required>
                        <option value="Banrural">Banrural</option>
                        <option value="Banco Industrial">Banco Industrial</option>
                        <option value="BAM">BAM</option>
                        <option value="G&T Continental">G&T Continental</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tipo de Cuenta</label>
                    <select name="tipo_cuenta" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-neoBlue focus:ring-neoBlue sm:text-sm px-4 py-2 bg-gray-50">
                        <option value="Monetaria">Monetaria</option>
                        <option value="Ahorro">Ahorro</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Número de Cuenta</label>
                    <input type="text" name="numero_cuenta" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-neoBlue focus:ring-neoBlue sm:text-sm px-4 py-2 bg-gray-50" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nombre Titular</label>
                    <input type="text" name="nombre_titular" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-neoBlue focus:ring-neoBlue sm:text-sm px-4 py-2 bg-gray-50" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Moneda</label>
                    <select name="moneda" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-neoBlue focus:ring-neoBlue sm:text-sm px-4 py-2 bg-gray-50">
                        <option value="GTQ">GTQ</option>
                        <option value="USD">USD</option>
                    </select>
                </div>
                <button type="submit" class="w-full bg-neoBlue text-white py-2 rounded-xl font-medium hover:bg-blue-700 transition">
                    Guardar Cuenta
                </button>
            </form>
        </div>
    </div>
    <!-- Services Management -->
    <div class="glass-card overflow-hidden mt-8 backdrop-blur-md bg-white/50 rounded-3xl shadow-lg">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-white/80">
            <h2 class="text-xl font-semibold text-gray-800"><i class="fa-solid fa-briefcase text-neoBlue mr-2"></i> Gestión de Servicios</h2>
            <button onclick="document.getElementById('serviceModal').classList.remove('hidden')" class="bg-neoBlue text-white px-4 py-1.5 rounded-full text-sm font-medium hover:bg-blue-700 transition">
                + Nuevo Servicio
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 rounded-t-xl">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100" id="servicesList">
                    <?php
                    $servicios = $pdo->query("SELECT * FROM servicios WHERE estado = 'activo'")->fetchAll();
                    foreach($servicios as $s):
                    ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900"><?php echo htmlspecialchars($s['nombre']); ?></td>
                        <td class="px-6 py-4 text-sm text-gray-500"><?php echo ucfirst(str_replace('_', ' ', $s['tipo'])); ?></td>
                        <td class="px-6 py-4 text-sm text-gray-500"><?php echo $s['tipo'] === 'cotizable' ? 'Aprox: $' . ($s['precio_aproximado'] ?? '0.00') : '$' . ($s['precio_fijo'] ?? '0.00'); ?></td>
                        <td class="px-6 py-4 text-sm text-gray-500"><span class="px-2 bg-green-100 text-green-800 rounded-full text-xs">Activo</span></td>
                        <td class="px-6 py-4 text-right text-sm font-medium">
                            <form action="../controllers/ServicesController.php" method="POST" onsubmit="return confirm('¿Desactivar servicio?');">
                                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generate_csrf_token()); ?>">
                                <input type="hidden" name="action" value="delete_service">
                                <input type="hidden" name="id" value="<?php echo $s['id']; ?>">
                                <button type="submit" class="text-red-500 hover:text-red-700">Desactivar</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for new Service -->
    <div id="serviceModal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center backdrop-blur-sm">
        <div class="glass-card w-full max-w-lg p-6 relative bg-white">
            <button onclick="document.getElementById('serviceModal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
            <h3 class="text-xl font-semibold mb-4 text-appleBlack">Crear Servicio</h3>
            <form action="../controllers/ServicesController.php" method="POST" class="space-y-4">
                <input type="hidden" name="action" value="create_service">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generate_csrf_token()); ?>">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nombre del Servicio</label>
                    <input type="text" name="nombre" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-neoBlue focus:ring-neoBlue sm:text-sm px-4 py-2 bg-gray-50" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Descripción</label>
                    <textarea name="descripcion" rows="3" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-neoBlue focus:ring-neoBlue sm:text-sm px-4 py-2 bg-gray-50"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tipo de Servicio</label>
                    <select name="tipo" id="tipoServicio" onchange="togglePrecioFields()" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-neoBlue focus:ring-neoBlue sm:text-sm px-4 py-2 bg-gray-50">
                        <option value="cotizable">Servicio Cotizable</option>
                        <option value="precio_fijo">Producto de Precio Fijo</option>
                    </select>
                </div>
                <div id="precioAproxDiv">
                    <label class="block text-sm font-medium text-gray-700">Precio Aproximado (Opcional)</label>
                    <input type="number" step="0.01" name="precio_aproximado" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-neoBlue focus:ring-neoBlue sm:text-sm px-4 py-2 bg-gray-50">
                </div>
                <div id="precioFijoDiv" class="hidden">
                    <label class="block text-sm font-medium text-gray-700">Precio Fijo</label>
                    <input type="number" step="0.01" name="precio_fijo" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-neoBlue focus:ring-neoBlue sm:text-sm px-4 py-2 bg-gray-50">
                </div>
                <button type="submit" class="w-full bg-neoBlue text-white py-2 rounded-xl font-medium hover:bg-blue-700 transition">
                    Guardar Servicio
                </button>
            </form>
        </div>
    </div>

    <script>
        function togglePrecioFields() {
            const tipo = document.getElementById('tipoServicio').value;
            if (tipo === 'cotizable') {
                document.getElementById('precioAproxDiv').classList.remove('hidden');
                document.getElementById('precioFijoDiv').classList.add('hidden');
            } else {
                document.getElementById('precioAproxDiv').classList.add('hidden');
                document.getElementById('precioFijoDiv').classList.remove('hidden');
            }
        }
    </script>
    <!-- Quotes / Tickets Management -->
    <div class="glass-card overflow-hidden mt-8 backdrop-blur-md bg-white/50 rounded-3xl shadow-lg">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-white/80">
            <h2 class="text-xl font-semibold text-gray-800"><i class="fa-solid fa-file-invoice text-neoBlue mr-2"></i> Cotizaciones y Tickets</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 rounded-t-xl">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Servicio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100" id="quotesList">
                                        <?php
                    $cotizaciones = $pdo->query("SELECT c.*, u.username, s.nombre AS servicio_nombre FROM cotizaciones c JOIN usuarios u ON c.usuario_id = u.id LEFT JOIN servicios s ON c.servicio_id = s.id ORDER BY c.id DESC LIMIT 20")->fetchAll();
                    foreach($cotizaciones as $c):
                    ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">#<?php echo $c['id']; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo htmlspecialchars($c['username']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($c['servicio_nombre'] ?? 'Otro'); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800"><?php echo ucfirst(str_replace('_', ' ', $c['estado'])); ?></span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo date('d/m/Y', strtotime($c['creado_en'])); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="ticket.php?id=<?php echo $c['id']; ?>" class="text-neoBlue hover:text-blue-900 bg-blue-50 px-3 py-1.5 rounded-full"><i class="fa-solid fa-comment-dots mr-1"></i> Ver Ticket</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
</tbody>
            </table>
        </div>
    </div>
    <!-- Invoice Requests -->
    <div class="glass-card overflow-hidden mt-8 backdrop-blur-md bg-white/50 rounded-3xl shadow-lg">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-white/80">
            <h2 class="text-xl font-semibold text-gray-800"><i class="fa-solid fa-file-pdf text-neoBlue mr-2"></i> Solicitudes de Facturación</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 rounded-t-xl">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Factura ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente/Empresa</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIT/CF</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monto</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones (Subir PDF)</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100" id="invoicesList">
                                        <?php
                    $facturas = $pdo->query("SELECT * FROM facturas WHERE ruta_pdf IS NULL OR ruta_pdf = '' ORDER BY id DESC")->fetchAll();
                    foreach($facturas as $f):
                    ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">#F-<?php echo $f['id']; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo htmlspecialchars($f['nombre_legal']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($f['tipo_identificacion'] . ': ' . $f['identificacion_numero']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo htmlspecialchars($f['moneda'] . ' ' . $f['monto_total']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <form action="../controllers/InvoiceController.php" method="POST" enctype="multipart/form-data" class="flex items-center justify-end space-x-2">
                                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generate_csrf_token()); ?>">
                                <input type="hidden" name="action" value="upload_invoice">
                                <input type="hidden" name="factura_id" value="<?php echo $f['id']; ?>">
                                <input type="file" name="pdf_factura" accept=".pdf" class="block w-48 text-sm text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
                                <button type="submit" class="bg-green-500 text-white px-3 py-1.5 rounded-full text-xs hover:bg-green-600 shadow-sm"><i class="fa-solid fa-upload"></i> Subir</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
</tbody>
            </table>
        </div>
    </div>
</main>

</body>
</html>
