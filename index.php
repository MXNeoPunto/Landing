<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NeoPunto - Desarrollo Web & Apps</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        neoBlue: '#007bff',
                        neoYellow: '#fbbf24',
                        neoDark: '#0f172a',
                        neoGlass: 'rgba(255, 255, 255, 0.1)',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #0f172a;
            color: white;
            overflow-x: hidden;
        }
        .glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }
        .glass-header {
            background: rgba(15, 23, 42, 0.98);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .text-glow {
            text-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
        }
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }
        ::-webkit-scrollbar-track {
            background: #0f172a;
        }
        ::-webkit-scrollbar-thumb {
            background: #007bff;
            border-radius: 5px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #fbbf24;
        }
    </style>
</head>
<body class="antialiased">

    <!-- Fixed Header -->
    <header class="fixed w-full top-0 z-50 glass-header transition-all duration-300" id="navbar">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <!-- Logo -->
            <a href="#" class="text-2xl font-bold flex items-center gap-2">
                <span class="text-neoBlue"><i class="fa-solid fa-code"></i></span>
                <div>
                    <span class="text-white">Neo</span><span class="text-neoYellow">Punto</span>
                </div>
            </a>

            <!-- Desktop Menu -->
            <nav class="hidden md:flex gap-8 text-base font-medium">
                <a href="#inicio" class="hover:text-neoBlue transition-colors">Inicio</a>
                <a href="#servicios" class="hover:text-neoBlue transition-colors">Servicios</a>
                <a href="#usos" class="hover:text-neoBlue transition-colors">Usos</a>
                <a href="#acerca" class="hover:text-neoBlue transition-colors">Acerca de</a>
                <a href="#contacto" class="px-6 py-2.5 bg-neoBlue text-white rounded-lg hover:bg-blue-600 transition-all shadow-lg shadow-blue-500/30">
                    Contáctanos
                </a>
            </nav>

            <!-- Mobile Menu Button -->
            <button id="menu-btn" class="md:hidden text-2xl text-white focus:outline-none">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden glass-header absolute w-full left-0 top-full border-t border-gray-700">
            <div class="flex flex-col p-6 space-y-4 text-center">
                <a href="#inicio" class="block hover:text-neoYellow mobile-link">Inicio</a>
                <a href="#servicios" class="block hover:text-neoYellow mobile-link">Servicios</a>
                <a href="#usos" class="block hover:text-neoYellow mobile-link">Usos</a>
                <a href="#acerca" class="block hover:text-neoYellow mobile-link">Acerca de</a>
                <a href="#contacto" class="block text-neoBlue font-bold mobile-link">Contáctanos</a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="inicio" class="min-h-screen flex items-center justify-center relative overflow-hidden pt-20">
        <!-- Background Decor -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10">
            <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-yellow-500/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
        </div>

        <div class="container mx-auto px-6 text-center z-10" data-aos="fade-up">
            <h1 class="text-5xl md:text-7xl font-extrabold mb-6 leading-tight">
                Innovación Digital <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-neoBlue to-neoYellow text-glow">
                    Sin Límites
                </span>
            </h1>
            <p class="text-lg md:text-xl text-gray-300 mb-10 max-w-2xl mx-auto">
                Transformamos ideas en experiencias digitales ultra modernas.
                Desarrollo web, aplicaciones y soluciones tecnológicas desde Guatemala para el mundo.
            </p>
            <div class="flex flex-col md:flex-row gap-4 justify-center">
                <a href="#servicios" class="px-8 py-3 bg-neoBlue rounded-full font-semibold hover:bg-blue-600 transition-all shadow-lg shadow-blue-500/30 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-rocket"></i> Ver Servicios
                </a>
                <a href="#contacto" class="px-8 py-3 glass rounded-full font-semibold hover:bg-white/10 transition-all flex items-center justify-center gap-2">
                    <i class="fa-brands fa-whatsapp"></i> Cotizar Ahora
                </a>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="servicios" class="py-20 bg-neoDark/50 relative">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl md:text-5xl font-bold text-center mb-16" data-aos="fade-up">
                Nuestros <span class="text-neoYellow">Servicios</span>
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Service 1 -->
                <div class="glass p-8 rounded-2xl hover:bg-white/5 transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-4xl text-neoBlue mb-6">
                        <i class="fa-solid fa-laptop-code"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Diseño Web Moderno</h3>
                    <p class="text-gray-400">Sitios web responsivos, ultra modernos con animaciones fluidas y diseño adaptable a todos los dispositivos.</p>
                </div>

                <!-- Service 2 -->
                <div class="glass p-8 rounded-2xl hover:bg-white/5 transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="200">
                    <div class="text-4xl text-neoYellow mb-6">
                        <i class="fa-solid fa-mobile-screen-button"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Apps de Radio</h3>
                    <p class="text-gray-400">Aplicaciones móviles dedicadas para estaciones de radio con streaming de alta calidad y diseño personalizado.</p>
                </div>

                <!-- Service 3 -->
                <div class="glass p-8 rounded-2xl hover:bg-white/5 transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="300">
                    <div class="text-4xl text-neoBlue mb-6">
                        <i class="fa-solid fa-truck-fast"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Servicios de Paquetería</h3>
                    <p class="text-gray-400">Soluciones tecnológicas para el rastreo y gestión de envíos de paquetería.</p>
                </div>

                <!-- Service 4 -->
                <div class="glass p-8 rounded-2xl hover:bg-white/5 transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="400">
                    <div class="text-4xl text-neoYellow mb-6">
                        <i class="fa-solid fa-store"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Tiendas en Línea</h3>
                    <p class="text-gray-400">E-commerce robustos con carritos de compra, inventario y gestión de pedidos.</p>
                </div>

                <!-- Service 5 -->
                <div class="glass p-8 rounded-2xl hover:bg-white/5 transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="500">
                    <div class="text-4xl text-neoBlue mb-6">
                        <i class="fa-brands fa-wordpress"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4">WordPress</h3>
                    <p class="text-gray-400">Implementación y personalización avanzada de sitios WordPress optimizados y seguros.</p>
                </div>

                <!-- Service 6 -->
                <div class="glass p-8 rounded-2xl hover:bg-white/5 transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="600">
                    <div class="text-4xl text-neoYellow mb-6">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Seguridad Web</h3>
                    <p class="text-gray-400">Protección contra ataques, certificados SSL y copias de seguridad automáticas.</p>
                </div>

                <!-- Service 7 -->
                <div class="glass p-8 rounded-2xl hover:bg-white/5 transition-all duration-300 transform hover:-translate-y-2 md:col-span-2 lg:col-span-3 text-center" data-aos="fade-up" data-aos-delay="700">
                    <div class="text-4xl text-green-500 mb-6">
                        <i class="fa-solid fa-money-bill-wave"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Pasarelas de Pago</h3>
                    <p class="text-gray-400 max-w-2xl mx-auto">Integración de pagos en Quetzales (GTQ) y Dólares (USD) para facilitar tus ventas en línea.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Usos / About Section -->
    <section id="acerca" class="py-20 relative overflow-hidden">
        <div class="container mx-auto px-6 flex flex-col md:flex-row items-center gap-12">
            <div class="w-full md:w-1/2" data-aos="fade-right">
                <div class="relative">
                    <div class="absolute inset-0 bg-neoBlue/30 rounded-2xl blur-xl transform rotate-6"></div>
                    <img src="https://images.unsplash.com/photo-1550751827-4bd374c3f58b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Sobre NeoPunto" class="relative rounded-2xl shadow-2xl glass p-2 w-full object-cover h-80 md:h-96">
                </div>
            </div>
            <div class="w-full md:w-1/2" data-aos="fade-left">
                <h2 class="text-3xl md:text-5xl font-bold mb-6">Sobre <span class="text-neoBlue">NeoPunto</span></h2>
                <p class="text-gray-300 mb-6 text-lg leading-relaxed">
                    Somos una agencia digital enfocada en el futuro. Nuestra misión es empoderar negocios en Guatemala y el mundo con herramientas tecnológicas de vanguardia.
                </p>
                <p class="text-gray-300 mb-8 text-lg leading-relaxed">
                    Desde apps de radio hasta complejas tiendas en línea, utilizamos los stacks más modernos para garantizar velocidad, seguridad y un diseño impactante.
                </p>
                <div class="grid grid-cols-2 gap-6">
                    <div class="text-center">
                        <h4 class="text-4xl font-bold text-neoYellow">500+</h4>
                        <p class="text-sm text-gray-400">Proyectos</p>
                    </div>
                    <div class="text-center">
                        <h4 class="text-4xl font-bold text-neoBlue">99%</h4>
                        <p class="text-sm text-gray-400">Clientes Felices</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contacto" class="py-20 bg-neoDark relative">
        <div class="container mx-auto px-6 max-w-4xl" data-aos="zoom-in">
            <div class="glass p-8 md:p-12 rounded-3xl relative overflow-hidden">
                <!-- Decorative Circle -->
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-neoYellow/20 rounded-full blur-2xl"></div>

                <div class="text-center mb-10">
                    <h2 class="text-3xl md:text-5xl font-bold mb-4">Contáctanos</h2>
                    <p class="text-gray-400">¿Listo para iniciar tu próximo proyecto? Escríbenos.</p>
                </div>

                <form action="send_email.php" method="POST" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Nombre</label>
                            <input type="text" name="name" required class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-3 focus:outline-none focus:border-neoBlue focus:ring-1 focus:ring-neoBlue transition-colors text-white placeholder-gray-500" placeholder="Tu nombre">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                            <input type="email" name="email" required class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-3 focus:outline-none focus:border-neoBlue focus:ring-1 focus:ring-neoBlue transition-colors text-white placeholder-gray-500" placeholder="tucorreo@ejemplo.com">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Mensaje</label>
                        <textarea name="message" rows="4" required class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-3 focus:outline-none focus:border-neoBlue focus:ring-1 focus:ring-neoBlue transition-colors text-white placeholder-gray-500" placeholder="Cuéntanos sobre tu proyecto..."></textarea>
                    </div>

                    <button type="submit" class="w-full py-4 bg-gradient-to-r from-neoBlue to-blue-600 rounded-lg font-bold text-lg hover:shadow-lg hover:shadow-blue-500/40 transition-all transform hover:-translate-y-1">
                        Enviar Mensaje <i class="fa-solid fa-paper-plane ml-2"></i>
                    </button>
                </form>

                <div class="mt-10 pt-6 border-t border-white/10 flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-gray-400">
                    <div class="flex items-center gap-2">
                        <i class="fa-brands fa-whatsapp text-neoGreen text-xl"></i>
                        <span>WhatsApp: 56434857</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-envelope text-neoBlue text-xl"></i>
                        <span>clientes@neopunto.com</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-black/40 py-10 border-t border-white/5">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-center mb-8">
                <a href="#" class="text-2xl font-bold tracking-wider mb-4 md:mb-0">
                    <span class="text-neoBlue"><i class="fa-solid fa-code"></i></span>
                    <span class="text-white">Neo</span><span class="text-neoYellow">Punto</span>
                </a>
                <div class="flex gap-4 text-xl">
                    <a href="#" class="w-10 h-10 rounded-full glass flex items-center justify-center hover:bg-neoBlue hover:text-white transition-all"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="w-10 h-10 rounded-full glass flex items-center justify-center hover:bg-neoBlue hover:text-white transition-all"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="w-10 h-10 rounded-full glass flex items-center justify-center hover:bg-neoBlue hover:text-white transition-all"><i class="fa-brands fa-twitter"></i></a>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm text-gray-400 mb-8 border-b border-white/5 pb-8">
                <a href="terminos.php" class="hover:text-neoBlue transition-colors">Términos de Uso</a>
                <a href="privacidad.php" class="hover:text-neoBlue transition-colors">Política de Privacidad</a>
                <a href="cookies.php" class="hover:text-neoBlue transition-colors">Política de Cookies</a>
                <a href="anuncios.php" class="hover:text-neoBlue transition-colors">Política de Anuncios</a>
                <a href="politica_correos.php" class="hover:text-neoBlue transition-colors">Política de Correos</a>
            </div>

            <div class="text-center text-gray-500 text-xs">
                &copy; <?php echo date('Y'); ?> NeoPunto. Todos los derechos reservados. Guatemala.
            </div>
        </div>
    </footer>

    <!-- AOS Script -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true,
        });

        // Mobile Menu Logic
        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const navbar = document.getElementById('navbar');

        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            const icon = menuBtn.querySelector('i');
            if (mobileMenu.classList.contains('hidden')) {
                icon.classList.remove('fa-xmark');
                icon.classList.add('fa-bars');
                navbar.classList.remove('bg-neoDark');
            } else {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-xmark');
                navbar.classList.add('bg-neoDark');
            }
        });

        // Close mobile menu on link click
        document.querySelectorAll('.mobile-link').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
                menuBtn.querySelector('i').classList.remove('fa-xmark');
                menuBtn.querySelector('i').classList.add('fa-bars');
            });
        });

        // Sticky Navbar Effect on Scroll
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('shadow-lg');
            } else {
                navbar.classList.remove('shadow-lg');
            }
        });
    </script>
</body>
</html>
