<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SaaS Corporativo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        corporate: {
                            blue: '#0f172a',
                            yellow: '#fbbf24',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen font-sans">
    <nav class="bg-corporate-blue text-white shadow-lg">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold flex items-center gap-2">
                <i class="fa-solid fa-cube text-corporate-yellow"></i>
                <span class="text-white">SaaS<span class="text-corporate-yellow">Corp</span></span>
            </a>

            <div class="hidden md:flex items-center space-x-8">
                <a href="/" class="hover:text-corporate-yellow transition">Inicio</a>
                <a href="#services" class="hover:text-corporate-yellow transition">Servicios</a>
                <a href="#contact" class="hover:text-corporate-yellow transition">Contacto</a>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if ($_SESSION['user_role'] === 'admin'): ?>
                        <a href="/admin/dashboard" class="bg-corporate-yellow text-corporate-blue px-4 py-2 rounded-lg font-bold hover:bg-yellow-300 transition">Panel Admin</a>
                    <?php else: ?>
                        <a href="/client/dashboard" class="bg-corporate-yellow text-corporate-blue px-4 py-2 rounded-lg font-bold hover:bg-yellow-300 transition">Mi Panel</a>
                    <?php endif; ?>
                    <a href="/logout" class="text-red-400 hover:text-red-300 transition"><i class="fa-solid fa-sign-out-alt"></i></a>
                <?php else: ?>
                    <a href="/login" class="text-white hover:text-corporate-yellow transition">Iniciar Sesión</a>
                    <a href="/register" class="bg-corporate-yellow text-corporate-blue px-4 py-2 rounded-lg font-bold hover:bg-yellow-300 transition">Registrarse</a>
                <?php endif; ?>
            </div>

            <!-- Mobile Menu Button -->
            <button class="md:hidden text-white focus:outline-none">
                <i class="fa-solid fa-bars text-2xl"></i>
            </button>
        </div>
    </nav>
    <main class="flex-grow">
