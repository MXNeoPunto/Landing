<?php require_once __DIR__ . '/../../partials/header.php'; ?>

<div class="flex min-h-screen bg-gray-100">
    <?php require_once __DIR__ . '/partials/sidebar.php'; ?>

    <div class="flex-1 flex flex-col p-6 overflow-y-auto">
        <header class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Hola, <?php echo $_SESSION['user_name'] ?? 'Cliente'; ?></h1>
            <a href="/client/orders" class="bg-yellow-400 text-blue-900 font-bold py-2 px-6 rounded-lg shadow hover:bg-yellow-300 transition">
                <i class="fa-solid fa-plus mr-2"></i> Nuevo Pedido
            </a>
        </header>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-blue-500">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Mis Pedidos</p>
                        <h3 class="text-3xl font-bold text-gray-800"><?php echo $ordersCount; ?></h3>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-full text-blue-600">
                        <i class="fa-solid fa-box-open text-xl"></i>
                    </div>
                </div>
            </div>
             <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-yellow-400">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Facturas Pendientes</p>
                        <h3 class="text-3xl font-bold text-gray-800">0</h3>
                    </div>
                    <div class="p-3 bg-yellow-100 rounded-full text-yellow-600">
                        <i class="fa-solid fa-file-invoice-dollar text-xl"></i>
                    </div>
                </div>
            </div>
             <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-green-500">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Tickets Abiertos</p>
                        <h3 class="text-3xl font-bold text-gray-800">0</h3>
                    </div>
                    <div class="p-3 bg-green-100 rounded-full text-green-600">
                        <i class="fa-solid fa-ticket text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Available Services -->
        <h2 class="text-xl font-bold text-gray-800 mb-6">Servicios Disponibles</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php foreach($services as $service): ?>
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2"><?php echo htmlspecialchars($service['name']); ?></h3>
                    <p class="text-gray-600 mb-4 h-20 overflow-hidden text-sm"><?php echo htmlspecialchars($service['description']); ?></p>
                    <div class="flex justify-between items-center">
                        <span class="text-2xl font-bold text-blue-900">$<?php echo number_format($service['price'], 2); ?></span>
                        <form action="/client/orders/create" method="POST">
                            <?php echo $csrf_input; ?>
                            <input type="hidden" name="service_id" value="<?php echo $service['id']; ?>">
                            <button type="submit" class="bg-blue-900 text-white py-2 px-4 rounded hover:bg-blue-800 transition text-sm font-bold">
                                Solicitar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>
