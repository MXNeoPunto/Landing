<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Política de Correos (SES) - NeoPunto</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        neoBlue: '#007bff',
                        neoYellow: '#fbbf24',
                        neoDark: '#0f172a',
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #0f172a; color: white; }
    </style>
</head>
<body class="antialiased font-sans">
    <header class="py-6 px-6 border-b border-gray-800">
        <div class="container mx-auto flex justify-between items-center">
            <a href="index.php" class="text-2xl font-bold tracking-wider">
                <span class="text-neoBlue"><i class="fa-solid fa-code"></i></span>
                <span class="text-white">Neo</span><span class="text-neoYellow">Punto</span>
            </a>
            <a href="index.php" class="text-sm text-gray-400 hover:text-white"><i class="fa-solid fa-arrow-left"></i> Volver al inicio</a>
        </div>
    </header>

    <main class="container mx-auto px-6 py-12 max-w-4xl">
        <h1 class="text-3xl md:text-4xl font-bold mb-8 text-neoBlue">Política de Correos Electrónicos</h1>

        <div class="space-y-6 text-gray-300 leading-relaxed">
            <section>
                <h2 class="text-xl font-bold text-white mb-2">1. Uso de Amazon SES</h2>
                <p>NeoPunto utiliza Amazon Simple Email Service (SES) para enviar correos electrónicos transaccionales y de marketing. Nos aseguramos de cumplir con todas las políticas de uso aceptable de AWS y las leyes de privacidad aplicables.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-white mb-2">2. Consentimiento y Suscripción</h2>
                <p>Solo enviamos correos electrónicos a usuarios que han dado su consentimiento explícito para recibir comunicaciones de nuestra parte. Al completar nuestros formularios de contacto o suscribirse a nuestros boletines, usted acepta recibir correos electrónicos relacionados con su solicitud o interés.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-white mb-2">3. Cancelación de Suscripción (Opt-Out)</h2>
                <p>Todos nuestros correos electrónicos de marketing incluyen un enlace claro y fácil de usar para cancelar la suscripción. Respetamos su decisión y procesaremos su solicitud de baja de manera inmediata.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-white mb-2">4. Manejo de Reebotes y Quejas</h2>
                <p>Monitoreamos activamente nuestras tasas de rebote y quejas para mantener una alta reputación de envío y garantizar que nuestros correos lleguen a su bandeja de entrada. Eliminamos automáticamente las direcciones de correo electrónico que generan rebotes permanentes o quejas de spam.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-white mb-2">5. Contenido del Correo</h2>
                <p>Nos comprometemos a enviar contenido relevante, útil y libre de material engañoso o fraudulento. Todos nuestros correos electrónicos identifican claramente a NeoPunto como el remitente.</p>
            </section>
        </div>
    </main>

    <footer class="py-8 text-center text-gray-500 text-sm border-t border-gray-800">
        &copy; <?php echo date('Y'); ?> NeoPunto. Todos los derechos reservados.
    </footer>
</body>
</html>
