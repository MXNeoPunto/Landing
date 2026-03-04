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

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 pt-32 md:pt-10">

    <div class="mb-8">
        <h1 class="text-3xl font-semibold text-appleBlack tracking-tight">Hola, <?php echo htmlspecialchars($user['username']); ?></h1>
        <p class="text-gray-500 mt-1">Bienvenido a tu panel de control NeoPunto.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                        <!-- User Info Card -->
        <div class="glass-card p-6 md:col-span-2 relative group">
            <h2 class="text-lg font-semibold border-b border-gray-100 pb-4 mb-4 flex justify-between items-center">
                <span><i class="fa-regular fa-address-card text-neoBlue mr-2"></i> Información de la Cuenta</span>
                <button onclick="document.getElementById('editProfileModal').classList.remove('hidden')" class="text-sm bg-gray-100 hover:bg-gray-200 px-3 py-1.5 rounded-full text-gray-700 font-medium transition-colors">
                    <i class="fa-solid fa-pen text-xs mr-1"></i> Editar
                </button>
            </h2>

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
                    <dt class="text-sm font-medium text-gray-500">Ubicación</dt>
                    <dd class="mt-1 text-base text-gray-900"><i class="fa-solid fa-globe text-gray-400 mr-1"></i> <?php echo htmlspecialchars($user['pais']); ?></dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Moneda Preferida</dt>
                    <dd class="mt-1 text-base text-gray-900"><span class="px-2 py-1 bg-gray-100 rounded text-sm"><?php echo htmlspecialchars($user['moneda']); ?></span></dd>
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
    <!-- Request Service Form -->
    <div class="glass-card overflow-hidden mt-8 backdrop-blur-md bg-white/50 rounded-3xl shadow-lg">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-white/80">
            <h2 class="text-xl font-semibold text-gray-800"><i class="fa-solid fa-paper-plane text-neoBlue mr-2"></i> Solicitar Servicio / Cotización</h2>
        </div>
        <div class="p-6">
            <form action="../controllers/QuotesController.php" method="POST" class="space-y-4">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generate_csrf_token()); ?>">
                <input type="hidden" name="action" value="create_quote">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Seleccionar Servicio</label>
                    <select name="servicio_id" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-neoBlue focus:ring-neoBlue sm:text-sm px-4 py-2 bg-white/70">
                                                <?php
                        $servicios = $pdo->query("SELECT id, nombre, tipo FROM servicios WHERE estado = 'activo'")->fetchAll();
                        foreach($servicios as $s):
                        ?>
                        <option value="<?php echo $s['id']; ?>"><?php echo htmlspecialchars($s['nombre'] . ' (' . ucfirst(str_replace('_', ' ', $s['tipo'])) . ')'); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Cuéntanos sobre tu proyecto</label>
                    <textarea name="descripcion" rows="4" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-neoBlue focus:ring-neoBlue sm:text-sm px-4 py-2 bg-white/70" placeholder="Describe los requisitos..."></textarea>
                </div>
                <button type="submit" class="bg-neoBlue text-white px-6 py-2 rounded-full font-medium hover:bg-blue-700 transition shadow-md shadow-blue-500/30">
                    Enviar Solicitud
                </button>
            </form>
        </div>
    </div>

    <!-- My Services / Status -->
    <div class="glass-card overflow-hidden mt-8 backdrop-blur-md bg-white/50 rounded-3xl shadow-lg">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-white/80">
            <h2 class="text-xl font-semibold text-gray-800"><i class="fa-solid fa-list-check text-neoBlue mr-2"></i> Mis Proyectos y Pagos</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 rounded-t-xl">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Servicio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monto</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                                        <?php
                    $cotizaciones = $pdo->prepare("SELECT c.*, s.nombre AS servicio_nombre, f.ruta_pdf FROM cotizaciones c LEFT JOIN servicios s ON c.servicio_id = s.id LEFT JOIN facturas f ON c.id = f.cotizacion_id WHERE c.usuario_id = ? ORDER BY c.id DESC");
                    $cotizaciones->execute([$_SESSION['user_id']]);
                    foreach($cotizaciones->fetchAll() as $c):
                    ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo htmlspecialchars($c['servicio_nombre'] ?? 'Otro'); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800"><?php echo ucfirst(str_replace('_', ' ', $c['estado'])); ?></span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <?php echo $c['moneda'] . ' ' . ($c['precio_final'] ?? '0.00'); ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="ticket.php?id=<?php echo $c['id']; ?>" class="text-neoBlue hover:text-blue-900 mr-3"><i class="fa-solid fa-comments"></i> Chat</a>

                            <?php
                                $horas = (time() - strtotime($c['creado_en'])) / 3600;
                                if ($horas >= 2 && !in_array($c['estado'], ['finalizado', 'cancelado'])):
                            ?>
                            <form action="../controllers/QuotesController.php" method="POST" class="inline-block" onsubmit="return handleEditRequest(this);">
                                <input type="hidden" name="action" value="request_edit">
                                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generate_csrf_token()); ?>">
                                <input type="hidden" name="cotizacion_id" value="<?php echo $c['id']; ?>">
                                <input type="hidden" name="motivo" class="motivo-input" value="">
                                <button type="submit" class="text-orange-500 hover:text-orange-700 mr-3 text-xs border border-orange-500 px-2 py-1 rounded-full"><i class="fa-solid fa-pen-to-square"></i> Solicitar Edición</button>
                            </form>
                            <?php endif; ?>

                            <?php if ($c['estado'] === 'aprobado' || $c['estado'] === 'en_proceso'): ?>
                            <a href="#pagos" onclick="document.getElementById('cotizacion_id_factura').value = <?php echo $c['id']; ?>" class="bg-green-500 text-white px-3 py-1.5 rounded-full text-xs hover:bg-green-600 shadow-sm"><i class="fa-solid fa-credit-card"></i> Pagar / Facturar</a>
                            <?php endif; ?>

                            <?php if (!empty($c['ruta_pdf'])): ?>
                            <a href="../<?php echo htmlspecialchars($c['ruta_pdf']); ?>" target="_blank" class="bg-neoBlue text-white px-3 py-1.5 rounded-full text-xs hover:bg-blue-700 shadow-sm ml-2"><i class="fa-solid fa-download"></i> Factura PDF</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
</tbody>
            </table>
        </div>
    </div>
    <!-- Invoicing Form -->
    <div id="pagos" class="glass-card overflow-hidden mt-8 backdrop-blur-md bg-white/50 rounded-3xl shadow-lg">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-white/80">
            <h2 class="text-xl font-semibold text-gray-800"><i class="fa-solid fa-file-invoice-dollar text-neoBlue mr-2"></i> Datos de Facturación</h2>
        </div>
        <div class="p-6">
            <form action="../controllers/InvoiceController.php" method="POST" enctype="multipart/form-data" class="space-y-4">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generate_csrf_token()); ?>">
                <input type="hidden" name="action" value="request_invoice">
                <input type="hidden" name="cotizacion_id" id="cotizacion_id_factura" value="">
                <!-- Dynamic in real app -->

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nombre Legal / Razón Social</label>
                        <input type="text" name="nombre_legal" value="<?php echo htmlspecialchars($user['username']); ?>" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-neoBlue focus:ring-neoBlue sm:text-sm px-4 py-2 bg-white/70" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tipo de Identificación</label>
                        <select name="tipo_identificacion" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-neoBlue focus:ring-neoBlue sm:text-sm px-4 py-2 bg-white/70" required>
                            <?php if($user['pais'] === 'Guatemala'): ?>
                                <option value="NIT">NIT</option>
                                <option value="Consumidor Final">Consumidor Final (CF)</option>
                            <?php else: ?>
                                <option value="Tax ID">Identificación Fiscal Local (Tax ID)</option>
                                <option value="Consumidor Final">Consumidor Final</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Número de Identificación (Si aplica)</label>
                        <input type="text" name="identificacion_numero" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-neoBlue focus:ring-neoBlue sm:text-sm px-4 py-2 bg-white/70">
                    </div>

                    <div class="md:col-span-2 border-t border-gray-200 pt-4 mt-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Método de Pago</label>
                        <select name="metodo_pago_id" id="metodo_pago_id" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-neoBlue focus:ring-neoBlue sm:text-sm px-4 py-2 bg-white/70" required onchange="toggleComprobante()">
                            <option value="">Selecciona un método de pago...</option>
                            <?php
                            $metodos = $pdo->query("SELECT id, nombre, tipo FROM metodos_pago WHERE estado = 'activo'")->fetchAll();
                            foreach($metodos as $m):
                            ?>
                                <option value="<?php echo $m['id']; ?>" data-tipo="<?php echo $m['tipo']; ?>"><?php echo htmlspecialchars($m['nombre']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div id="comprobante_div" class="md:col-span-2 hidden bg-gray-50 p-4 rounded-xl border border-gray-200">
                        <label class="block text-sm font-medium text-gray-700">Comprobante de Transferencia</label>
                        <p class="text-xs text-gray-500 mb-2">Por favor, sube una imagen o PDF de la boleta de pago.</p>
                        <input type="file" name="comprobante" id="comprobante" accept="image/*,.pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-200">
                    <button type="submit" class="w-full bg-gray-800 text-white px-6 py-2 rounded-full font-medium hover:bg-black transition shadow-md shadow-gray-500/30">
                        Pagar y Solicitar Factura
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
    function handleEditRequest(form) {
        let motivo = prompt('Motivo de la edición (Requiere aprobación del admin):');
        if (motivo !== null && motivo.trim() !== '') {
            form.querySelector('.motivo-input').value = motivo;
            return true;
        }
        return false;
    }

    function toggleComprobante() {
        const select = document.getElementById('metodo_pago_id');
        const selectedOption = select.options[select.selectedIndex];
        const tipo = selectedOption.getAttribute('data-tipo');
        const compDiv = document.getElementById('comprobante_div');
        const compInput = document.getElementById('comprobante');

        if (tipo === 'transferencia') {
            compDiv.classList.remove('hidden');
            compInput.required = true;
        } else {
            compDiv.classList.add('hidden');
            compInput.required = false;
        }
    }
</script>

    <!-- Edit Profile Modal -->
    <div id="editProfileModal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center backdrop-blur-sm p-4">
        <div class="glass-card w-full max-w-md p-6 relative bg-white rounded-2xl shadow-2xl">
            <button onclick="document.getElementById('editProfileModal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
            <h3 class="text-xl font-semibold mb-4 text-appleBlack"><i class="fa-solid fa-user-pen text-neoBlue mr-2"></i> Editar Perfil</h3>

            <form action="../controllers/UserController.php" method="POST" class="space-y-4">
                <input type="hidden" name="action" value="update_self">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generate_csrf_token()); ?>">

                <div>
                    <label class="block text-sm font-medium text-gray-700">Nombre de Usuario</label>
                    <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-neoBlue focus:ring-neoBlue sm:text-sm px-4 py-2 bg-gray-50" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-neoBlue focus:ring-neoBlue sm:text-sm px-4 py-2 bg-gray-50" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                    <input type="text" name="telefono" value="<?php echo htmlspecialchars($user['telefono']); ?>" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-neoBlue focus:ring-neoBlue sm:text-sm px-4 py-2 bg-gray-50" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">País</label>
                    <input type="text" name="pais" value="<?php echo htmlspecialchars($user['pais']); ?>" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-neoBlue focus:ring-neoBlue sm:text-sm px-4 py-2 bg-gray-50" required>
                </div>

                <div class="pt-4 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('editProfileModal').classList.add('hidden')" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-xl text-sm font-medium hover:bg-gray-200 transition">Cancelar</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-xl text-sm font-medium hover:bg-blue-700 transition shadow-md shadow-blue-500/30">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
