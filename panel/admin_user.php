<?php
require_once '../config/db.php';
require_once '../includes/security.php';

check_auth();

if (!in_array($_SESSION['rol'], ['admin', 'admin_principal', 'admin_secundario'])) {
    header('Location: cliente.php');
    exit();
}

$user_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$user_id) {
    header('Location: admin.php');
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ? AND deleted_at IS NULL");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    $_SESSION['error_msg'] = "Usuario no encontrado.";
    header('Location: admin.php');
    exit();
}

// Fetch Histories
$quotesStmt = $pdo->prepare("SELECT c.*, s.nombre AS servicio_nombre FROM cotizaciones c LEFT JOIN servicios s ON c.servicio_id = s.id WHERE c.usuario_id = ? ORDER BY c.creado_en DESC");
$quotesStmt->execute([$user_id]);
$quotes = $quotesStmt->fetchAll();

$invoicesStmt = $pdo->prepare("SELECT f.*, mp.nombre as metodo_nombre FROM facturas f LEFT JOIN metodos_pago mp ON f.metodo_pago_id = mp.id WHERE f.usuario_id = ? ORDER BY f.creado_en DESC");
$invoicesStmt->execute([$user_id]);
$invoices = $invoicesStmt->fetchAll();

$activityStmt = $pdo->prepare("SELECT * FROM tickets WHERE usuario_id = ? ORDER BY creado_en DESC LIMIT 10");
$activityStmt->execute([$user_id]);
$activities = $activityStmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario - NeoPunto Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f5f5f7; color: #1d1d1f; }
        .glass-card { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(16px); border-radius: 20px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05); }
    </style>
</head>
<body class="min-h-screen">

<nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center">
                <a href="admin.php" class="text-blue-600 hover:text-blue-800 flex items-center gap-2 font-medium">
                    <i class="fa-solid fa-arrow-left"></i> Volver
                </a>
                <span class="ml-4 text-xl font-bold tracking-tight">Detalle de Usuario</span>
            </div>
        </div>
    </div>
</nav>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    <?php if(isset($_SESSION['success_msg'])): ?>
        <div class="bg-green-50 border border-green-200 text-green-800 rounded-xl p-4 flex items-center">
            <i class="fa-solid fa-check-circle mr-2"></i> <?php echo $_SESSION['success_msg']; unset($_SESSION['success_msg']); ?>
        </div>
    <?php endif; ?>
    <?php if(isset($_SESSION['error_msg'])): ?>
        <div class="bg-red-50 border border-red-200 text-red-800 rounded-xl p-4 flex items-center">
            <i class="fa-solid fa-triangle-exclamation mr-2"></i> <?php echo $_SESSION['error_msg']; unset($_SESSION['error_msg']); ?>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- User Info Panel -->
        <div class="md:col-span-1 space-y-6">
            <div class="glass-card p-6 bg-white">
                <div class="flex items-center justify-between mb-6 border-b pb-4">
                    <h2 class="text-lg font-semibold"><i class="fa-solid fa-user-circle mr-2"></i> Perfil</h2>
                    <span class="px-3 py-1 bg-gray-100 text-sm font-medium rounded-full uppercase"><?php echo htmlspecialchars($user['rol']); ?></span>
                </div>

                <form action="../controllers/UserController.php" method="POST" class="space-y-4">
                    <input type="hidden" name="action" value="update_profile">
                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generate_csrf_token()); ?>">

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nombre de Usuario</label>
                        <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm px-4 py-2 bg-gray-50 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm px-4 py-2 bg-gray-50 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                        <input type="text" name="telefono" value="<?php echo htmlspecialchars($user['telefono']); ?>" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm px-4 py-2 bg-gray-50 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">País</label>
                        <input type="text" name="pais" value="<?php echo htmlspecialchars($user['pais']); ?>" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm px-4 py-2 bg-gray-50 focus:ring-blue-500">
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-xl font-medium hover:bg-blue-700 transition">Guardar Cambios</button>
                </form>
            </div>

            <!-- Actions Panel -->
            <div class="glass-card p-6 bg-white space-y-4">
                <h3 class="font-semibold mb-4 border-b pb-2"><i class="fa-solid fa-shield-halved mr-2"></i> Seguridad y Acciones</h3>

                <form action="../controllers/UserController.php" method="POST">
                    <input type="hidden" name="action" value="update_role">
                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generate_csrf_token()); ?>">
                    <label class="block text-xs text-gray-500 mb-1">Cambiar Rol</label>
                    <div class="flex gap-2">
                        <select name="rol" class="block w-full rounded-lg border-gray-300 text-sm py-1.5 bg-gray-50">
                            <option value="cliente" <?php if($user['rol'] == 'cliente') echo 'selected'; ?>>Cliente</option>
                            <option value="soporte" <?php if($user['rol'] == 'soporte') echo 'selected'; ?>>Soporte</option>
                            <?php if ($_SESSION['rol'] == 'admin_principal'): ?>
                            <option value="admin_secundario" <?php if($user['rol'] == 'admin_secundario') echo 'selected'; ?>>Admin Secundario</option>
                            <?php endif; ?>
                            <?php if ($_SESSION['rol'] == 'admin_principal' && $user['id'] != $_SESSION['user_id']): ?>
                            <option value="admin_principal" <?php if($user['rol'] == 'admin_principal') echo 'selected'; ?>>Admin Principal</option>
                            <?php endif; ?>
                        </select>
                        <button type="submit" class="bg-gray-200 px-3 rounded-lg text-sm hover:bg-gray-300">Aplicar</button>
                    </div>
                </form>

                <form action="../controllers/UserController.php" method="POST" onsubmit="return confirm('¿Restablecer contraseña a una aleatoria temporal?');">
                    <input type="hidden" name="action" value="reset_password">
                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generate_csrf_token()); ?>">
                    <button type="submit" class="w-full text-left py-2 px-3 hover:bg-gray-50 rounded-lg text-sm flex items-center"><i class="fa-solid fa-key w-5 text-gray-400"></i> Restablecer Contraseña</button>
                </form>

                <form action="../controllers/UserController.php" method="POST">
                    <input type="hidden" name="action" value="force_verify">
                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generate_csrf_token()); ?>">
                    <button type="submit" class="w-full text-left py-2 px-3 hover:bg-gray-50 rounded-lg text-sm flex items-center"><i class="fa-solid fa-envelope-circle-check w-5 text-gray-400"></i> Forzar Verificación Email</button>
                </form>

                <div class="border-t pt-4 mt-2">
                    <form action="../controllers/UserController.php" method="POST" class="mb-2">
                        <input type="hidden" name="action" value="change_status">
                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generate_csrf_token()); ?>">

                        <div class="flex gap-2">
                            <select name="estado" class="block w-full rounded-lg border-gray-300 text-sm py-1.5 bg-gray-50">
                                <option value="activo" <?php if($user['estado'] == 'activo') echo 'selected'; ?>>Activo</option>
                                <option value="suspendido" <?php if($user['estado'] == 'suspendido') echo 'selected'; ?>>Suspendido</option>
                                <option value="baneado" <?php if($user['estado'] == 'baneado') echo 'selected'; ?>>Baneado</option>
                            </select>
                            <button type="submit" class="bg-gray-200 px-3 rounded-lg text-sm hover:bg-gray-300">Guardar</button>
                        </div>
                    </form>

                    <form action="../controllers/UserController.php" method="POST" onsubmit="return confirm('¿Eliminar usuario (soft delete)?');">
                        <input type="hidden" name="action" value="soft_delete">
                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generate_csrf_token()); ?>">
                        <button type="submit" class="w-full text-left py-2 px-3 text-red-600 hover:bg-red-50 rounded-lg text-sm flex items-center font-medium"><i class="fa-solid fa-trash w-5"></i> Eliminar Cuenta</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- History Panel -->
        <div class="md:col-span-2 space-y-6">

            <div class="glass-card p-6 bg-white overflow-hidden">
                <h3 class="text-lg font-semibold border-b pb-4 mb-4"><i class="fa-solid fa-file-invoice text-blue-500 mr-2"></i> Historial de Cotizaciones</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                            <tr>
                                <th class="px-4 py-3">ID</th>
                                <th class="px-4 py-3">Servicio</th>
                                <th class="px-4 py-3">Estado</th>
                                <th class="px-4 py-3">Fecha</th>
                                <th class="px-4 py-3">Ticket</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($quotes as $q): ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3">#<?php echo $q['id']; ?></td>
                                <td class="px-4 py-3 font-medium text-gray-900"><?php echo htmlspecialchars($q['servicio_nombre'] ?? 'Otro'); ?></td>
                                <td class="px-4 py-3"><span class="bg-blue-100 text-blue-800 text-xs px-2 py-0.5 rounded"><?php echo ucfirst($q['estado']); ?></span></td>
                                <td class="px-4 py-3"><?php echo date('d/m/Y', strtotime($q['creado_en'])); ?></td>
                                <td class="px-4 py-3"><a href="ticket.php?id=<?php echo $q['id']; ?>" class="text-blue-600 hover:underline">Ver</a></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if(empty($quotes)): ?><tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">No hay cotizaciones.</td></tr><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="glass-card p-6 bg-white overflow-hidden">
                <h3 class="text-lg font-semibold border-b pb-4 mb-4"><i class="fa-solid fa-credit-card text-green-500 mr-2"></i> Historial de Pagos</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                            <tr>
                                <th class="px-4 py-3">Factura</th>
                                <th class="px-4 py-3">Monto</th>
                                <th class="px-4 py-3">Método</th>
                                <th class="px-4 py-3">Estado</th>
                                <th class="px-4 py-3">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($invoices as $i): ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3">#F-<?php echo $i['id']; ?></td>
                                <td class="px-4 py-3 font-medium text-gray-900"><?php echo htmlspecialchars($i['moneda'] . ' ' . $i['monto_total']); ?></td>
                                <td class="px-4 py-3 text-gray-500"><?php echo htmlspecialchars($i['metodo_nombre'] ?? '-'); ?></td>
                                <td class="px-4 py-3">
                                    <?php
                                    $stClass = 'bg-yellow-100 text-yellow-800';
                                    if ($i['estado_pago'] == 'pagado') $stClass = 'bg-green-100 text-green-800';
                                    if ($i['estado_pago'] == 'fallido') $stClass = 'bg-red-100 text-red-800';
                                    ?>
                                    <span class="text-xs px-2 py-0.5 rounded <?php echo $stClass; ?>"><?php echo ucfirst($i['estado_pago']); ?></span>
                                </td>
                                <td class="px-4 py-3"><?php echo date('d/m/Y', strtotime($i['creado_en'])); ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if(empty($invoices)): ?><tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">No hay pagos registrados.</td></tr><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</main>
</body>
</html>
