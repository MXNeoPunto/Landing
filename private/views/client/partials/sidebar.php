<aside class="w-64 bg-gray-900 text-white min-h-screen hidden md:block">
    <div class="p-6">
        <a href="/" class="text-2xl font-bold flex items-center gap-2">
            <i class="fa-solid fa-cube text-yellow-400"></i>
            <span>SaaS<span class="text-yellow-400">Client</span></span>
        </a>
    </div>
    <nav class="mt-6">
        <a href="/client/dashboard" class="flex items-center py-3 px-6 hover:bg-gray-800 transition <?php echo strpos($_SERVER['REQUEST_URI'], 'dashboard') !== false ? 'bg-gray-800 border-l-4 border-yellow-400' : ''; ?>">
            <i class="fa-solid fa-gauge w-6"></i> Resumen
        </a>
        <a href="/client/orders" class="flex items-center py-3 px-6 hover:bg-gray-800 transition <?php echo strpos($_SERVER['REQUEST_URI'], 'orders') !== false ? 'bg-gray-800 border-l-4 border-yellow-400' : ''; ?>">
            <i class="fa-solid fa-cart-shopping w-6"></i> Mis Pedidos
        </a>
        <a href="/client/tickets" class="flex items-center py-3 px-6 hover:bg-gray-800 transition <?php echo strpos($_SERVER['REQUEST_URI'], 'tickets') !== false ? 'bg-gray-800 border-l-4 border-yellow-400' : ''; ?>">
            <i class="fa-solid fa-life-ring w-6"></i> Soporte
        </a>
        <a href="#" class="flex items-center py-3 px-6 hover:bg-gray-800 transition">
            <i class="fa-solid fa-user w-6"></i> Mi Perfil
        </a>
    </nav>
</aside>
