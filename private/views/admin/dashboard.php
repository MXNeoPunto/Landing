<?php require_once __DIR__ . '/../../partials/header.php'; ?>

<div class="flex min-h-screen bg-gray-100">
    <?php require_once __DIR__ . '/partials/sidebar.php'; ?>

    <div class="flex-1 flex flex-col">
        <!-- Topbar -->
        <header class="bg-white shadow-sm p-4 flex justify-between items-center">
            <button class="md:hidden text-gray-500"><i class="fa-solid fa-bars"></i></button>
            <div class="flex items-center gap-4">
                <span class="text-gray-600">Bienvenido, Admin</span>
                <img src="https://ui-avatars.com/api/?name=Admin&background=facc15&color=0f172a" class="w-8 h-8 rounded-full">
            </div>
        </header>

        <main class="p-6 overflow-y-auto">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Dashboard General</h1>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-blue-500">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total Pedidos</p>
                            <h3 class="text-3xl font-bold text-gray-800"><?php echo $stats['total_orders']; ?></h3>
                        </div>
                        <div class="p-3 bg-blue-100 rounded-full text-blue-600">
                            <i class="fa-solid fa-clipboard-list text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-yellow-400">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Pendientes</p>
                            <h3 class="text-3xl font-bold text-gray-800"><?php echo $stats['pending_orders']; ?></h3>
                        </div>
                        <div class="p-3 bg-yellow-100 rounded-full text-yellow-600">
                            <i class="fa-solid fa-clock text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-indigo-500">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">En Proceso</p>
                            <h3 class="text-3xl font-bold text-gray-800"><?php echo $stats['processing_orders']; ?></h3>
                        </div>
                        <div class="p-3 bg-indigo-100 rounded-full text-indigo-600">
                            <i class="fa-solid fa-spinner text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-green-500">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Finalizados</p>
                            <h3 class="text-3xl font-bold text-gray-800"><?php echo $stats['completed_orders']; ?></h3>
                        </div>
                        <div class="p-3 bg-green-100 rounded-full text-green-600">
                            <i class="fa-solid fa-check-circle text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity / Chart Placeholder -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Ingresos Recientes</h3>
                    <div class="h-64 bg-gray-50 rounded-lg flex items-center justify-center border border-dashed border-gray-300">
                        <span class="text-gray-400">Gráfico de Ingresos (Simulado)</span>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-md">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Actividad del Sistema</h3>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <div class="flex-shrink-0 w-2 h-2 mt-2 rounded-full bg-green-500"></div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-600">Nuevo pedido registrado <span class="font-bold text-gray-800">#1024</span></p>
                                <span class="text-xs text-gray-400">Hace 5 minutos</span>
                            </div>
                        </li>
                         <li class="flex items-start">
                            <div class="flex-shrink-0 w-2 h-2 mt-2 rounded-full bg-blue-500"></div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-600">Usuario registrado <span class="font-bold text-gray-800">Juan Perez</span></p>
                                <span class="text-xs text-gray-400">Hace 2 horas</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </main>
    </div>
</div>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>
