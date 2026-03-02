<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenimiento - NeoPunto</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f5f5f7; color: #1d1d1f; }
        .glass-card { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(16px); border-radius: 20px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05); }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="glass-card w-full max-w-lg p-8 text-center bg-white space-y-6">
        <i class="fa-solid fa-tools text-6xl text-blue-500"></i>
        <h1 class="text-3xl font-bold tracking-tight">Estamos en mantenimiento</h1>
        <p class="text-gray-600 text-lg">Estamos realizando mejoras en el sistema para ofrecerte una mejor experiencia. Por favor, vuelve más tarde.</p>
        <div class="pt-6 border-t border-gray-100">
            <a href="/auth/login.php" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Acceso para administradores</a>
        </div>
    </div>
</body>
</html>
