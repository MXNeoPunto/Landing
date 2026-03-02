<?php
// Installer for NeoPunto

if (file_exists(__DIR__ . '/install.lock')) {
    die("El sistema ya está instalado. Por seguridad, elimina este archivo (installer.php) y install.lock del servidor.");
}

$step = isset($_GET['step']) ? (int)$_GET['step'] : 1;
$error = '';
$success = '';

if ($step === 2 && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $db_host = $_POST['db_host'] ?? '';
    $db_name = $_POST['db_name'] ?? '';
    $db_user = $_POST['db_user'] ?? '';
    $db_pass = $_POST['db_pass'] ?? '';

    if (empty($db_host) || empty($db_name) || empty($db_user)) {
        $error = 'Por favor, completa todos los campos requeridos.';
    } else {
        try {
            // Test connection and create DB if not exists
            $pdo = new PDO("mysql:host=$db_host;charset=utf8mb4", $db_user, $db_pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            $pdo->exec("USE `$db_name`");

            // Read and execute database.sql
            $sql = file_get_contents(__DIR__ . '/database.sql');
            if ($sql === false) {
                 throw new Exception("No se pudo leer el archivo database.sql.");
            }
            $pdo->exec($sql);

            // Update config.php
            // Escape user inputs to prevent RCE
            $safe_host = addcslashes($db_host, "'\\");
            $safe_user = addcslashes($db_user, "'\\");
            $safe_pass = addcslashes($db_pass, "'\\");
            $safe_name = addcslashes($db_name, "'\\");

            $config_content = "<?php\n\n";
            $config_content .= "// Database configuration\n";
            $config_content .= "define('DB_HOST', '$safe_host');\n";
            $config_content .= "define('DB_USER', '$safe_user');\n";
            $config_content .= "define('DB_PASS', '$safe_pass');\n";
            $config_content .= "define('DB_NAME', '$safe_name');\n\n";
            $config_content .= "// Amazon SES configuration (Simulated for mail)\n";
            $config_content .= "define('SMTP_HOST', 'email-smtp.us-east-1.amazonaws.com');\n";
            $config_content .= "define('SMTP_USER', 'YOUR_SES_SMTP_USERNAME');\n";
            $config_content .= "define('SMTP_PASS', 'YOUR_SES_SMTP_PASSWORD');\n";
            $config_content .= "define('SMTP_PORT', 587);\n\n";
            $config_content .= "define('SMTP_FROM_EMAIL', 'clientes@neopunto.com');\n";
            $config_content .= "define('SMTP_FROM_NAME', 'NeoPunto Web');\n\n";
            $config_content .= "// Recipient Email (Admin)\n";
            $config_content .= "define('ADMIN_EMAIL', 'clientes@neopunto.com');\n";

            if (file_put_contents(__DIR__ . '/config/config.php', $config_content) === false) {
                throw new Exception("No se pudo escribir en config/config.php. Verifica los permisos.");
            }

            // Add initial admin user
            $admin_email = 'admin@neopunto.com';
            $admin_user = 'admin';
            $admin_pass = password_hash('admin123', PASSWORD_DEFAULT);
            $admin_tel = '12345678';
            $admin_pais = 'Guatemala';
            $admin_moneda = 'GTQ';

            $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
            $stmt->execute([$admin_email]);
            if ($stmt->rowCount() == 0) {
                $stmt = $pdo->prepare("INSERT INTO usuarios (email, username, telefono, pais, moneda, password, rol, estado) VALUES (?, ?, ?, ?, ?, ?, 'admin_principal', 'activo')");
                $stmt->execute([$admin_email, $admin_user, $admin_tel, $admin_pais, $admin_moneda, $admin_pass]);
            }

            // Create lock file to prevent re-installation
            file_put_contents(__DIR__ . '/install.lock', 'locked');

            header("Location: installer.php?step=3");
            die();

        } catch (Exception $e) {
            $error = "Error: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalador de NeoPunto</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white rounded-3xl shadow-xl max-w-md w-full p-8 border border-slate-100">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-slate-800">NeoPunto <span class="text-blue-600">Installer</span></h1>
            <p class="text-slate-500 text-sm mt-2">Configuración inicial del sistema</p>
        </div>

        <?php if ($error): ?>
            <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 text-sm">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <?php if ($step === 1): ?>
            <div class="space-y-4 text-slate-600 text-sm">
                <p>Bienvenido al instalador de NeoPunto. Este proceso configurará la base de datos y preparará el sistema para su uso.</p>
                <p>Asegúrate de tener lista la siguiente información:</p>
                <ul class="list-disc list-inside ml-2">
                    <li>Servidor de Base de Datos</li>
                    <li>Nombre de Base de Datos</li>
                    <li>Usuario de Base de Datos</li>
                    <li>Contraseña de Base de Datos</li>
                </ul>
                <div class="pt-4">
                    <a href="?step=2" class="block w-full text-center bg-blue-600 text-white font-medium py-3 rounded-xl hover:bg-blue-700 transition-colors">
                        Comenzar Instalación
                    </a>
                </div>
            </div>
        <?php elseif ($step === 2): ?>
            <form method="POST" class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Servidor (Host)</label>
                    <input type="text" name="db_host" value="localhost" required class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nombre de Base de Datos</label>
                    <input type="text" name="db_name" value="neopunto" required class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Usuario</label>
                    <input type="text" name="db_user" value="root" required class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Contraseña</label>
                    <input type="password" name="db_pass" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                    <p class="text-xs text-slate-500 mt-1">Déjalo en blanco si tu usuario root no tiene contraseña (común en XAMPP/WAMP local).</p>
                </div>
                <div class="pt-2 flex gap-3">
                    <a href="?step=1" class="flex-1 text-center bg-slate-100 text-slate-700 font-medium py-3 rounded-xl hover:bg-slate-200 transition-colors">
                        Volver
                    </a>
                    <button type="submit" class="flex-1 bg-blue-600 text-white font-medium py-3 rounded-xl hover:bg-blue-700 transition-colors">
                        Instalar
                    </button>
                </div>
            </form>
        <?php elseif ($step === 3): ?>
            <div class="text-center space-y-4">
                <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-2xl mx-auto mb-4">
                    ✓
                </div>
                <h2 class="text-xl font-bold text-slate-800">¡Instalación Completada!</h2>
                <p class="text-slate-600 text-sm">El sistema ha sido configurado correctamente.</p>
                <div class="bg-blue-50 text-left p-4 rounded-xl text-sm text-blue-800 space-y-2 mt-4">
                    <p class="font-semibold">Credenciales de Administrador por defecto:</p>
                    <p>Email: <b>admin@neopunto.com</b></p>
                    <p>Contraseña: <b>admin123</b></p>
                </div>
                <p class="text-red-500 text-xs mt-4 font-medium">Por seguridad, elimina este archivo (installer.php) después de instalar.</p>
                <div class="pt-4">
                    <a href="index.php" class="block w-full text-center bg-blue-600 text-white font-medium py-3 rounded-xl hover:bg-blue-700 transition-colors">
                        Ir al Inicio
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
