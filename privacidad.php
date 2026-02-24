<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Política de Privacidad - NeoPunto</title>
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
        <h1 class="text-3xl md:text-4xl font-bold mb-8 text-neoBlue">Política de Privacidad</h1>

        <div class="space-y-6 text-slate-600 leading-relaxed">
            <section>
                <h2 class="text-xl font-bold text-slate-900 mb-2">1. Introducción</h2>
                <p>En NeoPunto, nos tomamos muy en serio la privacidad de nuestros usuarios y clientes. Esta Política de Privacidad explica qué información recopilamos, cómo la usamos y sus derechos.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-slate-900 mb-2">2. Información que Recopilamos</h2>
                <ul class="list-disc ml-5 space-y-2">
                    <li>Información de contacto (Nombre, Correo Electrónico, Teléfono) proporcionada a través de formularios.</li>
                    <li>Información sobre el uso del sitio web a través de cookies.</li>
                    <li>Datos necesarios para procesar pagos y envíos de paquetería.</li>
                </ul>
            </section>

            <section>
                <h2 class="text-xl font-bold text-slate-900 mb-2">3. Uso de la Información</h2>
                <p>Utilizamos su información para:</p>
                <ul class="list-disc ml-5 space-y-2">
                    <li>Proporcionar y mejorar nuestros servicios de diseño y desarrollo web.</li>
                    <li>Procesar transacciones y pagos seguros.</li>
                    <li>Gestionar envíos de paquetería y rastreo.</li>
                    <li>Enviar comunicaciones relevantes sobre su cuenta o servicios.</li>
                </ul>
            </section>

            <section>
                <h2 class="text-xl font-bold text-slate-900 mb-2">4. Seguridad de los Datos</h2>
                <p>Implementamos medidas de seguridad técnicas y organizativas para proteger su información personal contra el acceso no autorizado, la alteración, la divulgación o la destrucción.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-slate-900 mb-2">5. Compartir Información</h2>
                <p>No vendemos, intercambiamos ni transferimos su información personal a terceros, excepto cuando sea necesario para proporcionar el servicio (por ejemplo, pasarelas de pago o servicios de mensajería).</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-slate-900 mb-2">6. Contacto</h2>
                <p>Si tiene preguntas sobre esta política, contáctenos en <span class="text-neoBlue">clientes@neopunto.com</span> o vía WhatsApp al <span class="text-neoYellow">56434857</span>.</p>
            </section>
        </div>
    </main>

    <footer class="py-8 text-center text-slate-500 text-sm border-t border-slate-200 bg-white">
        &copy; <?php echo date('Y'); ?> NeoPunto. Todos los derechos reservados.
    </footer>
</body>
</html>
