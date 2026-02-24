<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Política de Cookies - NeoPunto</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        neoBlue: '#2563eb',
                        neoYellow: '#f59e0b',
                        neoDark: '#f8fafc',
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #f8fafc; color: #1e293b; }
    </style>
</head>
<body class="antialiased font-sans">
    <header class="py-6 px-6 border-b border-slate-200 bg-white">
        <div class="container mx-auto flex justify-between items-center">
            <a href="index.php" class="text-2xl font-bold tracking-wider">
                <span class="text-neoBlue"><i class="fa-solid fa-code"></i></span>
                <span class="text-slate-900">Neo</span><span class="text-neoYellow">Punto</span>
            </a>
            <a href="index.php" class="text-sm text-slate-500 hover:text-neoBlue"><i class="fa-solid fa-arrow-left"></i> Volver al inicio</a>
        </div>
    </header>

    <main class="container mx-auto px-6 py-12 max-w-4xl">
        <h1 class="text-3xl md:text-4xl font-bold mb-8 text-neoBlue">Política de Cookies</h1>

        <div class="space-y-6 text-slate-600 leading-relaxed">
            <section>
                <h2 class="text-xl font-bold text-slate-900 mb-2">1. ¿Qué son las Cookies?</h2>
                <p>Las cookies son pequeños archivos de texto que se almacenan en su dispositivo (ordenador o dispositivo móvil) cuando visita ciertos sitios web.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-slate-900 mb-2">2. ¿Cómo usamos las Cookies?</h2>
                <p>NeoPunto utiliza cookies para:</p>
                <ul class="list-disc ml-5 space-y-2">
                    <li>Mejorar la experiencia de navegación del usuario.</li>
                    <li>Recordar sus preferencias y configuraciones.</li>
                    <li>Analizar el tráfico del sitio y el rendimiento.</li>
                    <li>Facilitar la integración con servicios de terceros como Google AdSense y redes sociales.</li>
                </ul>
            </section>

            <section>
                <h2 class="text-xl font-bold text-slate-900 mb-2">3. Tipos de Cookies</h2>
                <p>Utilizamos cookies de sesión (que se borran al cerrar el navegador) y cookies persistentes (que permanecen en su dispositivo hasta que expiran o se borran).</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-slate-900 mb-2">4. Control de Cookies</h2>
                <p>Usted puede controlar y/o eliminar las cookies como desee. Puede borrar todas las cookies que ya están en su computadora y puede configurar la mayoría de los navegadores para evitar que se coloquen.</p>
            </section>
        </div>
    </main>

    <footer class="py-8 text-center text-slate-500 text-sm border-t border-slate-200 bg-white">
        &copy; <?php echo date('Y'); ?> NeoPunto. Todos los derechos reservados.
    </footer>
</body>
</html>
