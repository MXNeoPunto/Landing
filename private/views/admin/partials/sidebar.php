<aside class="w-64 bg-blue-900 text-white min-h-screen hidden md:block">
    <div class="p-6">
        <a href="/" class="text-2xl font-bold flex items-center gap-2">
            <i class="fa-solid fa-cube text-yellow-400"></i>
            <span>SaaS<span class="text-yellow-400">Admin</span></span>
        </a>
    </div>
    <nav class="mt-6">
        <a href="/admin/dashboard" class="flex items-center py-3 px-6 hover:bg-blue-800 transition <?php echo strpos($_SERVER['REQUEST_URI'], 'dashboard') !== false ? 'bg-blue-800 border-l-4 border-yellow-400' : ''; ?>">
            <i class="fa-solid fa-gauge w-6"></i> Dashboard
        </a>
        <a href="/admin/orders" class="flex items-center py-3 px-6 hover:bg-blue-800 transition <?php echo strpos($_SERVER['REQUEST_URI'], 'orders') !== false ? 'bg-blue-800 border-l-4 border-yellow-400' : ''; ?>">
            <i class="fa-solid fa-cart-shopping w-6"></i> Pedidos
        </a>
        <a href="/admin/services" class="flex items-center py-3 px-6 hover:bg-blue-800 transition <?php echo strpos($_SERVER['REQUEST_URI'], 'services') !== false ? 'bg-blue-800 border-l-4 border-yellow-400' : ''; ?>">
            <i class="fa-solid fa-list w-6"></i> Servicios
        </a>
        <a href="/admin/users" class="flex items-center py-3 px-6 hover:bg-blue-800 transition <?php echo strpos($_SERVER['REQUEST_URI'], 'users') !== false ? 'bg-blue-800 border-l-4 border-yellow-400' : ''; ?>">
            <i class="fa-solid fa-users w-6"></i> Usuarios
        </a>
        <a href="/admin/settings" class="flex items-center py-3 px-6 hover:bg-blue-800 transition <?php echo strpos($_SERVER['REQUEST_URI'], 'settings') !== false ? 'bg-blue-800 border-l-4 border-yellow-400' : ''; ?>">
            <i class="fa-solid fa-cog w-6"></i> Ajustes
        </a>
    </nav>
</aside>
