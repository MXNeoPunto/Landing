<!-- Footer -->
    <footer class="bg-slate-900 text-white py-16 border-t border-slate-800 relative z-10">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                <!-- Brand -->
                <div class="col-span-1">
                    <a href="index.php" class="text-2xl font-bold flex items-center gap-2 mb-6">
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
                        <li><a href="index.php#inicio" class="hover:text-neoBlue transition-colors flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs"></i> Inicio</a></li>
                        <li><a href="index.php#servicios" class="hover:text-neoBlue transition-colors flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs"></i> Servicios</a></li>
                        <li><a href="index.php#usos" class="hover:text-neoBlue transition-colors flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs"></i> Usos</a></li>
                        <li><a href="index.php#acerca" class="hover:text-neoBlue transition-colors flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs"></i> Acerca de</a></li>
                        <li><a href="index.php#contacto" class="hover:text-neoBlue transition-colors flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs"></i> Contacto</a></li>
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
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: 1000,
                once: true,
            });
        }

        // Mobile Menu Logic
        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const navbar = document.getElementById('navbar');
        const hamburgerLines = document.querySelectorAll('.hamburger-line');

        if (menuBtn && mobileMenu && navbar && hamburgerLines) {
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
        }
    </script>
</body>
</html>