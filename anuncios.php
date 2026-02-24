<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Política de Anuncios - NeoPunto</title>
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
        <h1 class="text-3xl md:text-4xl font-bold mb-8 text-neoBlue">Política de Anuncios</h1>

        <div class="space-y-6 text-slate-600 leading-relaxed">
            <section>
                <h2 class="text-xl font-bold text-slate-900 mb-2">1. Uso de Google AdSense / AdMob</h2>
                <p>NeoPunto utiliza Google AdSense y AdMob para publicar anuncios en su sitio web y aplicaciones móviles. Google y sus socios utilizan cookies para publicar anuncios basados en las visitas anteriores de los usuarios a nuestro sitio web u otros sitios web en Internet.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-slate-900 mb-2">2. Cookies de Publicidad</h2>
                <p>Google utiliza cookies de publicidad para ayudar a que los anuncios que se muestran sean más relevantes para usted. Estas cookies recopilan información sobre sus hábitos de navegación para ofrecer anuncios basados en sus intereses.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-slate-900 mb-2">3. Control de Publicidad Personalizada</h2>
                <p>Los usuarios pueden inhabilitar la publicidad personalizada visitando la <a href="https://adssettings.google.com" target="_blank" class="text-neoBlue hover:underline">Configuración de Anuncios de Google</a>. Alternativamente, puede inhabilitar el uso de cookies de proveedores externos para publicidad personalizada visitando <a href="https://www.aboutads.info" target="_blank" class="text-neoBlue hover:underline">aboutads.info</a>.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-slate-900 mb-2">4. Transparencia</h2>
                <p>Nos esforzamos por ser transparentes sobre cómo se utilizan los anuncios en nuestros servicios y cómo se recopilan los datos para fines publicitarios. Para obtener más información, consulte nuestra <a href="privacidad.php" class="text-neoBlue hover:underline">Política de Privacidad</a>.</p>
            </section>
        </div>
    </main>

    <footer class="py-8 text-center text-slate-500 text-sm border-t border-slate-200 bg-white">
        &copy; <?php echo date('Y'); ?> NeoPunto. Todos los derechos reservados.
    </footer>
</body>
</html>
