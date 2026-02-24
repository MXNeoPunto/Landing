<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Términos de Uso - NeoPunto</title>
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
        <h1 class="text-3xl md:text-4xl font-bold mb-8 text-neoBlue">Términos de Uso</h1>

        <div class="space-y-6 text-slate-600 leading-relaxed">
            <section>
                <h2 class="text-xl font-bold text-slate-900 mb-2">1. Aceptación de los Términos</h2>
                <p>Al acceder y utilizar los servicios de NeoPunto, usted acepta estar sujeto a estos términos y condiciones. Si no está de acuerdo con alguna parte de estos términos, no podrá acceder al servicio.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-slate-900 mb-2">2. Descripción del Servicio</h2>
                <p>NeoPunto ofrece servicios de diseño web, desarrollo de aplicaciones móviles (incluyendo apps de radio), servicios de paquetería tecnológica y soluciones de comercio electrónico.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-slate-900 mb-2">3. Uso de los Servicios</h2>
                <p>Usted se compromete a utilizar nuestros servicios únicamente con fines legales y de una manera que no infrinja los derechos de, restrinja o inhiba el uso y disfrute de los servicios por parte de cualquier tercero.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-slate-900 mb-2">4. Propiedad Intelectual</h2>
                <p>Todo el contenido incluido en este sitio web, como texto, gráficos, logotipos, imágenes, así como la compilación de los mismos, es propiedad de NeoPunto o de sus proveedores de contenido y está protegido por las leyes de propiedad intelectual.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-slate-900 mb-2">5. Pagos</h2>
                <p>Los pagos por servicios se pueden realizar en Quetzales (GTQ) o Dólares (USD). Utilizamos pasarelas de pago seguras para procesar sus transacciones.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-slate-900 mb-2">6. Limitación de Responsabilidad</h2>
                <p>NeoPunto no será responsable de ningún daño directo, indirecto, incidental o consecuente que resulte del uso o la imposibilidad de uso de nuestros servicios.</p>
            </section>
        </div>
    </main>

    <footer class="py-8 text-center text-slate-500 text-sm border-t border-slate-200 bg-white">
        &copy; <?php echo date('Y'); ?> NeoPunto. Todos los derechos reservados.
    </footer>
</body>
</html>
