<?php include 'includes/header.php'; ?>

    <!-- Hero Section -->
    <section id="inicio" class="min-h-screen flex items-center justify-center relative overflow-hidden pt-20">
        <!-- Background Decor -->
        <div class="absolute inset-0 -z-10 h-full w-full bg-appleGray">
            <div class="absolute left-10 top-20 -z-10 h-[400px] w-[400px] rounded-full bg-neoBlue opacity-10 blur-[120px]"></div>
            <div class="absolute right-10 bottom-20 -z-10 h-[400px] w-[400px] rounded-full bg-slate-400 opacity-10 blur-[120px]"></div>
        </div>

        <div class="container mx-auto px-6 text-center z-10" data-aos="fade-up">
            <h1 class="text-5xl md:text-8xl font-black mb-8 leading-tight text-appleBlack tracking-tight">
                Creamos el <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-neoBlue to-blue-800">
                    Futuro Digital
                </span>
            </h1>

            <p class="text-xl md:text-2xl text-slate-500 mb-12 max-w-3xl mx-auto leading-relaxed">
                Transformamos ideas complejas en experiencias digitales simples y poderosas. Desarrollo web de alto nivel desde Guatemala.
            </p>

            <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                <a href="#servicios" class="group px-8 py-4 bg-neoBlue text-white rounded-full font-bold text-lg hover:bg-blue-700 transition-all shadow-xl shadow-blue-500/20 hover:shadow-blue-500/40 hover:-translate-y-1 flex items-center gap-3">
                    Explorar Servicios <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </a>
                <a href="#contacto" class="group px-8 py-4 bg-white text-appleBlack border border-slate-300 rounded-full font-bold text-lg hover:bg-slate-50 transition-all shadow-sm hover:shadow-md hover:-translate-y-1 flex items-center gap-3">
                    <i class="fa-brands fa-whatsapp text-appleBlack text-xl"></i> Cotizar Proyecto
                </a>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="servicios" class="py-24 bg-white relative">
        <div class="container mx-auto px-6">
            <div class="text-center mb-20" data-aos="fade-up">
                <span class="text-neoBlue font-bold tracking-wider uppercase text-sm">Nuestras Soluciones</span>
                <h2 class="text-4xl md:text-5xl font-black mt-2 text-appleBlack">
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
                    <h3 class="text-2xl font-bold mb-4 text-appleBlack">Diseño Web Moderno</h3>
                    <p class="text-slate-500 leading-relaxed">Sitios web responsivos, ultra modernos con animaciones fluidas y diseño adaptable a todos los dispositivos.</p>
                </div>

                <!-- Service 2 -->
                <div class="group bg-slate-50 border border-slate-100 p-8 rounded-3xl hover:bg-white hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-300 hover:-translate-y-2" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-16 h-16 rounded-2xl bg-white shadow-sm flex items-center justify-center text-3xl text-neoYellow mb-6 group-hover:bg-neoYellow group-hover:text-white transition-colors duration-300">
                        <i class="fa-solid fa-mobile-screen-button"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-appleBlack">Apps de Radio</h3>
                    <p class="text-slate-500 leading-relaxed">Aplicaciones móviles dedicadas para estaciones de radio con streaming de alta calidad y diseño personalizado.</p>
                </div>

                <!-- Service 3 -->
                <div class="group bg-slate-50 border border-slate-100 p-8 rounded-3xl hover:bg-white hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-300 hover:-translate-y-2" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-16 h-16 rounded-2xl bg-white shadow-sm flex items-center justify-center text-3xl text-neoBlue mb-6 group-hover:bg-neoBlue group-hover:text-white transition-colors duration-300">
                        <i class="fa-solid fa-truck-fast"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-appleBlack">Servicios de Paquetería</h3>
                    <p class="text-slate-500 leading-relaxed">Soluciones tecnológicas para el rastreo y gestión de envíos de paquetería.</p>
                </div>

                <!-- Service 4 -->
                <div class="group bg-slate-50 border border-slate-100 p-8 rounded-3xl hover:bg-white hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-300 hover:-translate-y-2" data-aos="fade-up" data-aos-delay="400">
                    <div class="w-16 h-16 rounded-2xl bg-white shadow-sm flex items-center justify-center text-3xl text-neoYellow mb-6 group-hover:bg-neoYellow group-hover:text-white transition-colors duration-300">
                        <i class="fa-solid fa-store"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-appleBlack">Tiendas en Línea</h3>
                    <p class="text-slate-500 leading-relaxed">E-commerce robustos con carritos de compra, inventario y gestión de pedidos.</p>
                </div>

                <!-- Service 5 -->
                <div class="group bg-slate-50 border border-slate-100 p-8 rounded-3xl hover:bg-white hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-300 hover:-translate-y-2" data-aos="fade-up" data-aos-delay="500">
                    <div class="w-16 h-16 rounded-2xl bg-white shadow-sm flex items-center justify-center text-3xl text-neoBlue mb-6 group-hover:bg-neoBlue group-hover:text-white transition-colors duration-300">
                        <i class="fa-brands fa-wordpress"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-appleBlack">WordPress</h3>
                    <p class="text-slate-500 leading-relaxed">Implementación y personalización avanzada de sitios WordPress optimizados y seguros.</p>
                </div>

                <!-- Service 6 -->
                <div class="group bg-slate-50 border border-slate-100 p-8 rounded-3xl hover:bg-white hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-300 hover:-translate-y-2" data-aos="fade-up" data-aos-delay="600">
                    <div class="w-16 h-16 rounded-2xl bg-white shadow-sm flex items-center justify-center text-3xl text-neoYellow mb-6 group-hover:bg-neoYellow group-hover:text-white transition-colors duration-300">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-appleBlack">Seguridad Web</h3>
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
                <h2 class="text-3xl md:text-5xl font-bold mb-6 text-appleBlack">Sobre <span class="text-neoBlue">NeoPunto</span></h2>
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
                    <h2 class="text-3xl md:text-5xl font-black mt-2 mb-4 text-appleBlack">Contáctanos</h2>
                    <p class="text-slate-500 text-lg">¿Listo para iniciar tu próximo proyecto? Escríbenos.</p>
                </div>

                <form action="send_email.php" method="POST" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Nombre</label>
                            <input type="text" name="name" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-4 focus:outline-none focus:bg-white focus:border-neoBlue focus:ring-4 focus:ring-blue-500/10 transition-all duration-300 text-appleBlack placeholder-slate-400 font-medium" placeholder="Tu nombre">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Email</label>
                            <input type="email" name="email" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-4 focus:outline-none focus:bg-white focus:border-neoBlue focus:ring-4 focus:ring-blue-500/10 transition-all duration-300 text-appleBlack placeholder-slate-400 font-medium" placeholder="tucorreo@ejemplo.com">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Mensaje</label>
                        <textarea name="message" rows="4" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-4 focus:outline-none focus:bg-white focus:border-neoBlue focus:ring-4 focus:ring-blue-500/10 transition-all duration-300 text-appleBlack placeholder-slate-400 font-medium" placeholder="Cuéntanos sobre tu proyecto..."></textarea>
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

    <!-- FAQs Section -->
    <section id="faqs" class="py-24 bg-white relative">
        <div class="container mx-auto px-6 max-w-4xl" data-aos="fade-up">
            <div class="text-center mb-16">
                <span class="text-neoBlue font-bold tracking-wider uppercase text-sm">Soporte</span>
                <h2 class="text-3xl md:text-5xl font-black mt-2 text-appleBlack">
                    Preguntas <span class="text-neoYellow">Frecuentes</span>
                </h2>
                <p class="text-slate-500 mt-4 text-lg">Resuelve tus dudas sobre nuestros servicios de desarrollo y pagos.</p>
            </div>

            <div class="space-y-6">
                <!-- FAQ Item 1 -->
                <div class="bg-appleGray p-6 rounded-2xl">
                    <h3 class="text-xl font-bold text-appleBlack mb-2 flex items-center gap-2">
                        <i class="fa-solid fa-circle-question text-neoBlue"></i> ¿Cuánto tiempo toma desarrollar una app o sitio web?
                    </h3>
                    <p class="text-slate-600 ml-7">El tiempo varía según la complejidad del proyecto, pero generalmente toma entre 4 a 12 semanas desde el diseño hasta el lanzamiento final.</p>
                </div>

                <!-- FAQ Item 2 -->
                <div class="bg-appleGray p-6 rounded-2xl">
                    <h3 class="text-xl font-bold text-appleBlack mb-2 flex items-center gap-2">
                        <i class="fa-solid fa-credit-card text-neoBlue"></i> ¿Qué métodos de pago aceptan?
                    </h3>
                    <p class="text-slate-600 ml-7">Aceptamos pagos con tarjeta de crédito/débito y transferencias bancarias directas a través de Banrural y Banco Industrial.</p>
                </div>

                <!-- FAQ Item 3 -->
                <div class="bg-appleGray p-6 rounded-2xl">
                    <h3 class="text-xl font-bold text-appleBlack mb-2 flex items-center gap-2">
                        <i class="fa-solid fa-headset text-neoBlue"></i> ¿Ofrecen soporte después del lanzamiento?
                    </h3>
                    <p class="text-slate-600 ml-7">Sí, ofrecemos planes de mantenimiento y soporte continuo para asegurar que tu plataforma digital esté siempre actualizada y segura.</p>
                </div>
            </div>
        </div>
    </section>

<?php include 'includes/footer.php'; ?>
