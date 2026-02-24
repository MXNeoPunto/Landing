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
                        neoBlue: '#2563eb',
                        neoYellow: '#f59e0b',
                        neoDark: '#f8fafc',
                        neoGlass: 'rgba(255, 255, 255, 0.7)',
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
            background-color: #f8fafc;
            color: #1e293b;
            overflow-x: hidden;
        }
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
        }
        .glass-header {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        .text-glow {
            text-shadow: 0 0 10px rgba(37, 99, 235, 0.3);
        }
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #2563eb;
            border-radius: 5px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #f59e0b;
        }
    </style>
</head>
<body class="antialiased">

    <!-- Fixed Header -->
    <header class="fixed w-full top-0 z-50 bg-white/90 backdrop-blur-md shadow-sm transition-all duration-300" id="navbar">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center relative z-50">
            <!-- Logo -->
            <a href="#" class="text-2xl font-bold flex items-center gap-2 group">
                <span class="text-neoBlue group-hover:rotate-12 transition-transform duration-300"><i class="fa-solid fa-code"></i></span>
                <div>
                    <span class="text-slate-900">Neo</span><span class="text-neoYellow">Punto</span>
                </div>
            </a>

            <!-- Desktop Menu -->
            <nav class="hidden md:flex items-center gap-8 text-base font-medium text-slate-700">
                <a href="#inicio" class="hover:text-neoBlue transition-colors relative group">
                    Inicio
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-neoBlue transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="#servicios" class="hover:text-neoBlue transition-colors relative group">
                    Servicios
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-neoBlue transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="#usos" class="hover:text-neoBlue transition-colors relative group">
                    Usos
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-neoBlue transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="#acerca" class="hover:text-neoBlue transition-colors relative group">
                    Acerca de
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-neoBlue transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="#contacto" class="px-6 py-2.5 bg-neoBlue text-white rounded-full hover:bg-blue-600 hover:-translate-y-0.5 transition-all shadow-lg shadow-blue-500/30 font-medium">
                    Contáctanos
                </a>
            </nav>

            <!-- Mobile Menu Button (Hamburger) -->
            <button id="menu-btn" class="md:hidden z-50 w-10 h-10 flex flex-col justify-center items-center gap-1.5 text-slate-900 focus:outline-none group">
                <span class="w-6 h-0.5 bg-slate-900 rounded-full transition-all duration-300 origin-center hamburger-line"></span>
                <span class="w-6 h-0.5 bg-slate-900 rounded-full transition-all duration-300 origin-center hamburger-line"></span>
                <span class="w-6 h-0.5 bg-slate-900 rounded-full transition-all duration-300 origin-center hamburger-line"></span>
            </button>
        </div>

    </header>

    <!-- Mobile Menu Overlay -->
    <div id="mobile-menu" class="fixed inset-0 w-full h-full bg-white z-40 transform translate-x-full transition-transform duration-300 ease-in-out md:hidden overflow-y-auto">
        <!-- Decorative Background Elements -->
        <div class="absolute top-0 right-0 -z-10 w-72 h-72 bg-blue-500/20 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 -z-10 w-72 h-72 bg-amber-500/20 rounded-full blur-3xl opacity-50 pointer-events-none"></div>

        <div class="min-h-screen flex flex-col px-8 pb-8 pt-28">

            <!-- Navigation Links -->
            <nav class="flex-1 flex flex-col justify-start space-y-6">
                <a href="#inicio" class="group flex items-center gap-4 text-xl font-bold text-slate-800 hover:text-neoBlue mobile-link transition-colors p-4 rounded-xl hover:bg-blue-50">
                    <span class="w-10 h-10 rounded-lg bg-blue-100 text-neoBlue flex items-center justify-center text-lg group-hover:bg-neoBlue group-hover:text-white transition-colors">
                        <i class="fa-solid fa-house"></i>
                    </span>
                    Inicio
                </a>
                <a href="#servicios" class="group flex items-center gap-4 text-xl font-bold text-slate-800 hover:text-neoBlue mobile-link transition-colors p-4 rounded-xl hover:bg-blue-50">
                    <span class="w-10 h-10 rounded-lg bg-blue-100 text-neoBlue flex items-center justify-center text-lg group-hover:bg-neoBlue group-hover:text-white transition-colors">
                        <i class="fa-solid fa-briefcase"></i>
                    </span>
                    Servicios
                </a>
                <a href="#usos" class="group flex items-center gap-4 text-xl font-bold text-slate-800 hover:text-neoBlue mobile-link transition-colors p-4 rounded-xl hover:bg-blue-50">
                    <span class="w-10 h-10 rounded-lg bg-blue-100 text-neoBlue flex items-center justify-center text-lg group-hover:bg-neoBlue group-hover:text-white transition-colors">
                        <i class="fa-solid fa-layer-group"></i>
                    </span>
                    Usos
                </a>
                <a href="#acerca" class="group flex items-center gap-4 text-xl font-bold text-slate-800 hover:text-neoBlue mobile-link transition-colors p-4 rounded-xl hover:bg-blue-50">
                    <span class="w-10 h-10 rounded-lg bg-blue-100 text-neoBlue flex items-center justify-center text-lg group-hover:bg-neoBlue group-hover:text-white transition-colors">
                        <i class="fa-solid fa-users"></i>
                    </span>
                    Acerca de
                </a>
            </nav>

            <!-- CTA & Footer -->
            <div class="mt-8 pt-8 border-t border-slate-100">
                <a href="#contacto" class="block w-full py-4 bg-neoBlue text-white text-center rounded-xl font-bold text-lg hover:bg-blue-600 transition-all shadow-lg shadow-blue-500/30 mobile-link mb-8">
                    Contáctanos <i class="fa-solid fa-paper-plane ml-2"></i>
                </a>

                <div class="flex justify-center gap-6 text-slate-400">
                    <a href="#" class="hover:text-neoBlue transition-colors"><i class="fa-brands fa-facebook-f text-xl"></i></a>
                    <a href="#" class="hover:text-neoBlue transition-colors"><i class="fa-brands fa-instagram text-xl"></i></a>
                    <a href="#" class="hover:text-neoBlue transition-colors"><i class="fa-brands fa-twitter text-xl"></i></a>
                </div>
                <p class="text-center text-slate-400 text-sm mt-4">
                    &copy; <?php echo date('Y'); ?> NeoPunto.
                </p>
            </div>
        </div>
    </div>

    <!-- Hero Section -->
    <section id="inicio" class="min-h-screen flex items-center justify-center relative overflow-hidden pt-20">
        <!-- Background Decor -->
        <div class="absolute inset-0 -z-10 h-full w-full bg-slate-50 bg-[linear-gradient(to_right,#8080800a_1px,transparent_1px),linear-gradient(to_bottom,#8080800a_1px,transparent_1px)] bg-[size:14px_24px]">
            <div class="absolute left-0 right-0 top-0 -z-10 m-auto h-[310px] w-[310px] rounded-full bg-blue-500 opacity-20 blur-[100px]"></div>
            <div class="absolute right-0 bottom-0 -z-10 m-auto h-[310px] w-[310px] rounded-full bg-amber-500 opacity-20 blur-[100px]"></div>
        </div>

        <div class="container mx-auto px-6 text-center z-10" data-aos="fade-up">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white text-neoBlue text-sm font-semibold mb-8 border border-slate-200 shadow-sm animate-fade-in-down">
                <span class="relative flex h-3 w-3">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-3 w-3 bg-neoBlue"></span>
                </span>
                Innovación en Desarrollo
            </div>

            <h1 class="text-5xl md:text-8xl font-black mb-8 leading-tight text-slate-900 tracking-tight">
                Creamos el <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-neoBlue to-neoYellow">
                    Futuro Digital
                </span>
            </h1>

            <p class="text-xl md:text-2xl text-slate-500 mb-12 max-w-3xl mx-auto leading-relaxed">
                Transformamos ideas complejas en experiencias digitales simples y poderosas. Desarrollo web de alto nivel desde Guatemala.
            </p>

            <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                <a href="#servicios" class="group px-8 py-4 bg-neoBlue text-white rounded-full font-bold text-lg hover:bg-blue-600 transition-all shadow-xl shadow-blue-500/20 hover:shadow-blue-500/40 hover:-translate-y-1 flex items-center gap-3">
                    Explorar Servicios <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </a>
                <a href="#contacto" class="group px-8 py-4 bg-white text-slate-700 border border-slate-200 rounded-full font-bold text-lg hover:bg-slate-50 transition-all shadow-sm hover:shadow-md hover:-translate-y-1 flex items-center gap-3">
                    <i class="fa-brands fa-whatsapp text-green-500 text-xl"></i> Cotizar Proyecto
                </a>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="servicios" class="py-24 bg-white relative">
        <div class="container mx-auto px-6">
            <div class="text-center mb-20" data-aos="fade-up">
                <span class="text-neoBlue font-bold tracking-wider uppercase text-sm">Nuestras Soluciones</span>
                <h2 class="text-4xl md:text-5xl font-black mt-2 text-slate-900">
                    Servicios <span class="text-neoYellow">Premium</span>
                </h2>
                <p class="text-slate-500 max-w-2xl mx-auto mt-4 text-lg">
                    Diseñamos estrategias digitales a la medida para potenciar tu marca.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Service 1 -->
                <div class="group bg-slate-50 border border-slate-100 p-8 rounded-3xl hover:bg-white hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-300 hover:-translate-y-2" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-16 h-16 rounded-2xl bg-white shadow-sm flex items-center justify-center text-3xl text-neoBlue mb-6 group-hover:bg-neoBlue group-hover:text-white transition-colors duration-300">
                        <i class="fa-solid fa-laptop-code"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-slate-900">Diseño Web Moderno</h3>
                    <p class="text-slate-500 leading-relaxed">Sitios web responsivos, ultra modernos con animaciones fluidas y diseño adaptable a todos los dispositivos.</p>
                </div>

                <!-- Service 2 -->
                <div class="group bg-slate-50 border border-slate-100 p-8 rounded-3xl hover:bg-white hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-300 hover:-translate-y-2" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-16 h-16 rounded-2xl bg-white shadow-sm flex items-center justify-center text-3xl text-neoYellow mb-6 group-hover:bg-neoYellow group-hover:text-white transition-colors duration-300">
                        <i class="fa-solid fa-mobile-screen-button"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-slate-900">Apps de Radio</h3>
                    <p class="text-slate-500 leading-relaxed">Aplicaciones móviles dedicadas para estaciones de radio con streaming de alta calidad y diseño personalizado.</p>
                </div>

                <!-- Service 3 -->
                <div class="group bg-slate-50 border border-slate-100 p-8 rounded-3xl hover:bg-white hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-300 hover:-translate-y-2" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-16 h-16 rounded-2xl bg-white shadow-sm flex items-center justify-center text-3xl text-neoBlue mb-6 group-hover:bg-neoBlue group-hover:text-white transition-colors duration-300">
                        <i class="fa-solid fa-truck-fast"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-slate-900">Servicios de Paquetería</h3>
                    <p class="text-slate-500 leading-relaxed">Soluciones tecnológicas para el rastreo y gestión de envíos de paquetería.</p>
                </div>

                <!-- Service 4 -->
                <div class="group bg-slate-50 border border-slate-100 p-8 rounded-3xl hover:bg-white hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-300 hover:-translate-y-2" data-aos="fade-up" data-aos-delay="400">
                    <div class="w-16 h-16 rounded-2xl bg-white shadow-sm flex items-center justify-center text-3xl text-neoYellow mb-6 group-hover:bg-neoYellow group-hover:text-white transition-colors duration-300">
                        <i class="fa-solid fa-store"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-slate-900">Tiendas en Línea</h3>
                    <p class="text-slate-500 leading-relaxed">E-commerce robustos con carritos de compra, inventario y gestión de pedidos.</p>
                </div>

                <!-- Service 5 -->
                <div class="group bg-slate-50 border border-slate-100 p-8 rounded-3xl hover:bg-white hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-300 hover:-translate-y-2" data-aos="fade-up" data-aos-delay="500">
                    <div class="w-16 h-16 rounded-2xl bg-white shadow-sm flex items-center justify-center text-3xl text-neoBlue mb-6 group-hover:bg-neoBlue group-hover:text-white transition-colors duration-300">
                        <i class="fa-brands fa-wordpress"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-slate-900">WordPress</h3>
                    <p class="text-slate-500 leading-relaxed">Implementación y personalización avanzada de sitios WordPress optimizados y seguros.</p>
                </div>

                <!-- Service 6 -->
                <div class="group bg-slate-50 border border-slate-100 p-8 rounded-3xl hover:bg-white hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-300 hover:-translate-y-2" data-aos="fade-up" data-aos-delay="600">
                    <div class="w-16 h-16 rounded-2xl bg-white shadow-sm flex items-center justify-center text-3xl text-neoYellow mb-6 group-hover:bg-neoYellow group-hover:text-white transition-colors duration-300">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-slate-900">Seguridad Web</h3>
                    <p class="text-slate-500 leading-relaxed">Protección contra ataques, certificados SSL y copias de seguridad automáticas.</p>
                </div>

                <!-- Service 7 -->
                <div class="group bg-gradient-to-br from-slate-900 to-slate-800 p-8 rounded-3xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 md:col-span-2 lg:col-span-3 text-center shadow-lg relative overflow-hidden" data-aos="fade-up" data-aos-delay="700">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-green-500/10 rounded-full blur-3xl -mr-16 -mt-16"></div>
                    <div class="relative z-10">
                        <div class="w-20 h-20 mx-auto rounded-full bg-slate-800 flex items-center justify-center text-4xl text-green-400 mb-6 border border-slate-700">
                            <i class="fa-solid fa-money-bill-wave"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-4 text-white">Pasarelas de Pago</h3>
                        <p class="text-slate-400 max-w-2xl mx-auto text-lg">Integración de pagos en Quetzales (GTQ) y Dólares (USD) para facilitar tus ventas en línea.</p>
                    </div>
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
                <h2 class="text-3xl md:text-5xl font-bold mb-6 text-slate-900">Sobre <span class="text-neoBlue">NeoPunto</span></h2>
                <p class="text-slate-600 mb-6 text-lg leading-relaxed">
                    Somos una agencia digital enfocada en el futuro. Nuestra misión es empoderar negocios en Guatemala y el mundo con herramientas tecnológicas de vanguardia.
                </p>
                <p class="text-slate-600 mb-8 text-lg leading-relaxed">
                    Desde apps de radio hasta complejas tiendas en línea, utilizamos los stacks más modernos para garantizar velocidad, seguridad y un diseño impactante.
                </p>
                <div class="grid grid-cols-2 gap-6">
                    <div class="text-center">
                        <h4 class="text-4xl font-bold text-neoYellow">500+</h4>
                        <p class="text-sm text-slate-500">Proyectos</p>
                    </div>
                    <div class="text-center">
                        <h4 class="text-4xl font-bold text-neoBlue">99%</h4>
                        <p class="text-sm text-slate-500">Clientes Felices</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contacto" class="py-24 bg-slate-50 relative">
        <div class="container mx-auto px-6 max-w-4xl" data-aos="zoom-in">
            <div class="bg-white p-8 md:p-12 rounded-[2.5rem] shadow-2xl shadow-slate-200 relative overflow-hidden border border-slate-100">
                <!-- Decorative Circle -->
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-gradient-to-br from-blue-500 to-amber-500 opacity-10 rounded-full blur-2xl"></div>

                <div class="text-center mb-12">
                    <span class="text-neoBlue font-bold tracking-wider uppercase text-sm">Empecemos Ahora</span>
                    <h2 class="text-3xl md:text-5xl font-black mt-2 mb-4 text-slate-900">Contáctanos</h2>
                    <p class="text-slate-500 text-lg">¿Listo para iniciar tu próximo proyecto? Escríbenos.</p>
                </div>

                <form action="send_email.php" method="POST" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Nombre</label>
                            <input type="text" name="name" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-4 focus:outline-none focus:bg-white focus:border-neoBlue focus:ring-4 focus:ring-blue-500/10 transition-all duration-300 text-slate-900 placeholder-slate-400 font-medium" placeholder="Tu nombre">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Email</label>
                            <input type="email" name="email" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-4 focus:outline-none focus:bg-white focus:border-neoBlue focus:ring-4 focus:ring-blue-500/10 transition-all duration-300 text-slate-900 placeholder-slate-400 font-medium" placeholder="tucorreo@ejemplo.com">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Mensaje</label>
                        <textarea name="message" rows="4" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-4 focus:outline-none focus:bg-white focus:border-neoBlue focus:ring-4 focus:ring-blue-500/10 transition-all duration-300 text-slate-900 placeholder-slate-400 font-medium" placeholder="Cuéntanos sobre tu proyecto..."></textarea>
                    </div>

                    <button type="submit" class="w-full py-5 bg-gradient-to-r from-neoBlue to-blue-600 rounded-xl font-bold text-xl text-white hover:shadow-xl hover:shadow-blue-500/30 transition-all transform hover:-translate-y-1">
                        Enviar Mensaje <i class="fa-solid fa-paper-plane ml-2"></i>
                    </button>
                </form>

                <div class="mt-12 pt-8 border-t border-slate-100 flex flex-col md:flex-row justify-between items-center gap-6 text-slate-600 font-medium">
                    <div class="flex items-center gap-3 bg-slate-50 px-4 py-2 rounded-lg">
                        <i class="fa-brands fa-whatsapp text-green-500 text-2xl"></i>
                        <span>WhatsApp: 56434857</span>
                    </div>
                    <div class="flex items-center gap-3 bg-slate-50 px-4 py-2 rounded-lg">
                        <i class="fa-solid fa-envelope text-neoBlue text-2xl"></i>
                        <span>clientes@neopunto.com</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 text-white py-16 border-t border-slate-800 relative z-10">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                <!-- Brand -->
                <div class="col-span-1">
                    <a href="#" class="text-2xl font-bold flex items-center gap-2 mb-6">
                        <span class="text-neoBlue"><i class="fa-solid fa-code"></i></span>
                        <div>
                            <span class="text-white">Neo</span><span class="text-neoYellow">Punto</span>
                        </div>
                    </a>
                    <p class="text-slate-400 text-sm leading-relaxed mb-6">
                        Innovación digital para empresas visionarias. Transformamos el futuro con código y diseño de alto nivel.
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-neoBlue hover:text-white transition-all text-slate-400 hover:-translate-y-1"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-neoBlue hover:text-white transition-all text-slate-400 hover:-translate-y-1"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-neoBlue hover:text-white transition-all text-slate-400 hover:-translate-y-1"><i class="fa-brands fa-twitter"></i></a>
                    </div>
                </div>

                <!-- Links -->
                <div>
                    <h4 class="text-lg font-bold mb-6 text-white border-b border-slate-800 pb-2 inline-block">Navegación</h4>
                    <ul class="space-y-3 text-slate-400 text-sm">
                        <li><a href="#inicio" class="hover:text-neoBlue transition-colors flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs"></i> Inicio</a></li>
                        <li><a href="#servicios" class="hover:text-neoBlue transition-colors flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs"></i> Servicios</a></li>
                        <li><a href="#usos" class="hover:text-neoBlue transition-colors flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs"></i> Usos</a></li>
                        <li><a href="#acerca" class="hover:text-neoBlue transition-colors flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs"></i> Acerca de</a></li>
                        <li><a href="#contacto" class="hover:text-neoBlue transition-colors flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs"></i> Contacto</a></li>
                    </ul>
                </div>

                <!-- Legal -->
                <div>
                    <h4 class="text-lg font-bold mb-6 text-white border-b border-slate-800 pb-2 inline-block">Legal</h4>
                    <ul class="space-y-3 text-slate-400 text-sm">
                        <li><a href="terminos.php" class="hover:text-neoBlue transition-colors">Términos de Uso</a></li>
                        <li><a href="privacidad.php" class="hover:text-neoBlue transition-colors">Política de Privacidad</a></li>
                        <li><a href="cookies.php" class="hover:text-neoBlue transition-colors">Política de Cookies</a></li>
                        <li><a href="anuncios.php" class="hover:text-neoBlue transition-colors">Política de Anuncios</a></li>
                        <li><a href="politica_correos.php" class="hover:text-neoBlue transition-colors">Política de Correos</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                     <h4 class="text-lg font-bold mb-6 text-white border-b border-slate-800 pb-2 inline-block">Contacto Directo</h4>
                     <ul class="space-y-4 text-slate-400 text-sm">
                        <li class="flex items-start gap-3">
                            <i class="fa-brands fa-whatsapp text-green-500 mt-1"></i>
                            <span>56434857<br><span class="text-xs text-slate-500">Lun-Vie 9am-6pm</span></span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-envelope text-neoBlue mt-1"></i>
                            <span>clientes@neopunto.com<br><span class="text-xs text-slate-500">Respuesta en 24h</span></span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-location-dot text-neoYellow mt-1"></i>
                            <span>Guatemala, Guatemala<br><span class="text-xs text-slate-500">Oficinas Centrales</span></span>
                        </li>
                     </ul>
                </div>
            </div>

            <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-slate-500">
                <div>
                    &copy; <?php echo date('Y'); ?> NeoPunto. Todos los derechos reservados.
                </div>
                <div class="flex gap-4 items-center">
                    <span>Desarrollado con <i class="fa-solid fa-heart text-red-500 mx-1"></i> en Guatemala</span>
                </div>
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
        const hamburgerLines = document.querySelectorAll('.hamburger-line');

        menuBtn.addEventListener('click', () => {
            const isClosed = mobileMenu.classList.contains('translate-x-full');

            if (isClosed) {
                // Open Menu
                mobileMenu.classList.remove('translate-x-full');
                mobileMenu.classList.add('translate-x-0');
                document.body.style.overflow = 'hidden'; // Prevent scrolling

                // Animate to X
                hamburgerLines[0].classList.add('rotate-45', 'translate-y-2');
                hamburgerLines[1].classList.add('opacity-0');
                hamburgerLines[2].classList.add('-rotate-45', '-translate-y-2');
            } else {
                // Close Menu
                mobileMenu.classList.add('translate-x-full');
                mobileMenu.classList.remove('translate-x-0');
                document.body.style.overflow = 'auto'; // Enable scrolling

                // Animate back to hamburger
                hamburgerLines[0].classList.remove('rotate-45', 'translate-y-2');
                hamburgerLines[1].classList.remove('opacity-0');
                hamburgerLines[2].classList.remove('-rotate-45', '-translate-y-2');
            }
        });

        // Close mobile menu on link click
        document.querySelectorAll('.mobile-link').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('translate-x-full');
                mobileMenu.classList.remove('translate-x-0');
                document.body.style.overflow = 'auto';

                // Reset Icon
                hamburgerLines[0].classList.remove('rotate-45', 'translate-y-2');
                hamburgerLines[1].classList.remove('opacity-0');
                hamburgerLines[2].classList.remove('-rotate-45', '-translate-y-2');
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
