<?php require_once __DIR__ . '/partials/header.php'; ?>

<div class="flex flex-col items-center justify-center min-h-[60vh] text-center px-4">
    <h1 class="text-9xl font-extrabold text-blue-900 tracking-widest">404</h1>
    <div class="bg-yellow-400 px-2 text-sm rounded rotate-12 absolute">
        Página No Encontrada
    </div>
    <div class="mt-8">
        <h3 class="text-2xl font-bold md:text-3xl text-gray-800 mb-4">¡Ups! Te has perdido.</h3>
        <p class="text-gray-500 mb-8 max-w-md mx-auto">La página que buscas no existe o ha sido movida.</p>
        <a href="/" class="group relative inline-flex items-center justify-center px-8 py-3 text-base font-medium text-white bg-blue-900 rounded-full shadow-md hover:bg-blue-800 transition-all duration-200">
            <span class="absolute inset-0 w-full h-full -mt-1 rounded-full opacity-30 bg-gradient-to-b from-transparent via-transparent to-black"></span>
            <span class="relative">Volver al Inicio</span>
        </a>
    </div>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
