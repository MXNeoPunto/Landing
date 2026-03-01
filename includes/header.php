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
            <a href="index.php" class="text-2xl font-bold flex items-center gap-2 group">
                <span class="text-neoBlue group-hover:rotate-12 transition-transform duration-300"><i class="fa-solid fa-code"></i></span>
                <div>
                    <span class="text-slate-900">Neo</span><span class="text-neoYellow">Punto</span>
                </div>
            </a>

            <!-- Desktop Menu -->
            <nav class="hidden md:flex items-center gap-8 text-base font-medium text-slate-700">
                <a href="index.php#inicio" class="hover:text-neoBlue transition-colors relative group">
                    Inicio
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-neoBlue transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="index.php#servicios" class="hover:text-neoBlue transition-colors relative group">
                    Servicios
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-neoBlue transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="index.php#usos" class="hover:text-neoBlue transition-colors relative group">
                    Usos
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-neoBlue transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="index.php#acerca" class="hover:text-neoBlue transition-colors relative group">
                    Acerca de
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-neoBlue transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="index.php#contacto" class="px-6 py-2.5 bg-neoBlue text-white rounded-full hover:bg-blue-600 hover:-translate-y-0.5 transition-all shadow-lg shadow-blue-500/30 font-medium">
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
                <a href="index.php#inicio" class="group flex items-center gap-4 text-xl font-bold text-slate-800 hover:text-neoBlue mobile-link transition-colors p-4 rounded-xl hover:bg-blue-50">
                    <span class="w-10 h-10 rounded-lg bg-blue-100 text-neoBlue flex items-center justify-center text-lg group-hover:bg-neoBlue group-hover:text-white transition-colors">
                        <i class="fa-solid fa-house"></i>
                    </span>
                    Inicio
                </a>
                <a href="index.php#servicios" class="group flex items-center gap-4 text-xl font-bold text-slate-800 hover:text-neoBlue mobile-link transition-colors p-4 rounded-xl hover:bg-blue-50">
                    <span class="w-10 h-10 rounded-lg bg-blue-100 text-neoBlue flex items-center justify-center text-lg group-hover:bg-neoBlue group-hover:text-white transition-colors">
                        <i class="fa-solid fa-briefcase"></i>
                    </span>
                    Servicios
                </a>
                <a href="index.php#usos" class="group flex items-center gap-4 text-xl font-bold text-slate-800 hover:text-neoBlue mobile-link transition-colors p-4 rounded-xl hover:bg-blue-50">
                    <span class="w-10 h-10 rounded-lg bg-blue-100 text-neoBlue flex items-center justify-center text-lg group-hover:bg-neoBlue group-hover:text-white transition-colors">
                        <i class="fa-solid fa-layer-group"></i>
                    </span>
                    Usos
                </a>
                <a href="index.php#acerca" class="group flex items-center gap-4 text-xl font-bold text-slate-800 hover:text-neoBlue mobile-link transition-colors p-4 rounded-xl hover:bg-blue-50">
                    <span class="w-10 h-10 rounded-lg bg-blue-100 text-neoBlue flex items-center justify-center text-lg group-hover:bg-neoBlue group-hover:text-white transition-colors">
                        <i class="fa-solid fa-users"></i>
                    </span>
                    Acerca de
                </a>
            </nav>

            <!-- CTA & Footer -->
            <div class="mt-8 pt-8 border-t border-slate-100">
                <a href="index.php#contacto" class="block w-full py-4 bg-neoBlue text-white text-center rounded-xl font-bold text-lg hover:bg-blue-600 transition-all shadow-lg shadow-blue-500/30 mobile-link mb-8">
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