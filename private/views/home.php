<?php require_once __DIR__ . '/partials/header.php'; ?>

<!-- Hero Section -->
<section class="bg-gradient-to-r from-blue-900 via-blue-800 to-indigo-900 py-24 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-pattern opacity-10"></div>
    <div class="container mx-auto px-6 relative z-10 flex flex-col md:flex-row items-center">
        <div class="md:w-1/2 mb-12 md:mb-0 text-center md:text-left">
            <h1 class="text-4xl md:text-6xl font-extrabold leading-tight mb-6">
                Impulsa tu Negocio al <span class="text-yellow-400">Siguiente Nivel</span>
            </h1>
            <p class="text-lg md:text-xl text-gray-300 mb-8 max-w-lg mx-auto md:mx-0">
                La plataforma todo-en-uno para gestionar, optimizar y escalar tus operaciones empresariales con tecnología de punta.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                <a href="/register" class="bg-yellow-400 text-blue-900 font-bold py-3 px-8 rounded-full shadow-lg hover:bg-yellow-300 hover:shadow-xl transition transform hover:-translate-y-1">
                    Comenzar Gratis
                </a>
                <a href="#services" class="bg-transparent border-2 border-white text-white font-bold py-3 px-8 rounded-full hover:bg-white hover:text-blue-900 transition">
                    Ver Servicios
                </a>
            </div>
        </div>
        <div class="md:w-1/2 flex justify-center">
            <img src="https://via.placeholder.com/600x400?text=Dashboard+UI" alt="Dashboard Preview" class="rounded-xl shadow-2xl border-4 border-white/20 transform rotate-2 hover:rotate-0 transition duration-500">
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="py-20 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">¿Por qué elegirnos?</h2>
            <div class="w-20 h-1 bg-yellow-400 mx-auto rounded-full"></div>
            <p class="text-gray-600 mt-4 max-w-2xl mx-auto">
                Diseñado para simplificar procesos complejos con una interfaz intuitiva y potente.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <!-- Feature 1 -->
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition group">
                <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-600 transition duration-300">
                    <i class="fa-solid fa-chart-line text-3xl text-blue-600 group-hover:text-white transition duration-300"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Analítica Avanzada</h3>
                <p class="text-gray-600">
                    Visualiza el rendimiento de tu negocio en tiempo real con dashboards interactivos y reportes detallados.
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition group">
                <div class="w-16 h-16 bg-yellow-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-yellow-400 transition duration-300">
                    <i class="fa-solid fa-shield-halved text-3xl text-yellow-600 group-hover:text-white transition duration-300"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Seguridad Total</h3>
                <p class="text-gray-600">
                    Tus datos protegidos con los estándares más altos de la industria. Encriptación de extremo a extremo.
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition group">
                <div class="w-16 h-16 bg-indigo-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-indigo-600 transition duration-300">
                    <i class="fa-solid fa-rocket text-3xl text-indigo-600 group-hover:text-white transition duration-300"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Escalabilidad</h3>
                <p class="text-gray-600">
                    Crece sin límites. Nuestra infraestructura se adapta a tus necesidades conforme tu negocio se expande.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="bg-blue-900 py-20 relative overflow-hidden">
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-yellow-400 rounded-full opacity-10 blur-3xl"></div>
    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-blue-500 rounded-full opacity-10 blur-3xl"></div>

    <div class="container mx-auto px-6 text-center relative z-10">
        <h2 class="text-3xl md:text-5xl font-bold text-white mb-8">Listo para transformar tu gestión?</h2>
        <p class="text-xl text-blue-200 mb-10 max-w-2xl mx-auto">
            Únete a cientos de empresas que ya confían en SaaS Corp para optimizar sus flujos de trabajo.
        </p>
        <a href="/register" class="inline-block bg-yellow-400 text-blue-900 font-bold py-4 px-10 rounded-full shadow-lg hover:bg-yellow-300 hover:scale-105 transition transform">
            Crear Cuenta Gratis <i class="fa-solid fa-arrow-right ml-2"></i>
        </a>
    </div>
</section>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
