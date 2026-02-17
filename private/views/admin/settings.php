<?php require_once __DIR__ . '/../../partials/header.php'; ?>

<div class="flex min-h-screen bg-gray-100">
    <?php require_once __DIR__ . '/partials/sidebar.php'; ?>

    <div class="flex-1 flex flex-col p-6 overflow-y-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Ajustes del Sistema</h1>

        <div class="bg-white rounded-xl shadow-md p-6 max-w-4xl">
            <form action="/admin/settings/update" method="POST">
                <?php echo $csrf_input; ?>
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">Configuración General</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="site_name">Nombre del Sitio</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="site_name" name="site_name" type="text" value="<?php echo $settings['site_name'] ?? 'SaaS Corp'; ?>">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="admin_email">Correo de Administración</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="admin_email" name="admin_email" type="email" value="<?php echo $settings['admin_email'] ?? 'admin@saascorp.com'; ?>">
                        </div>
                    </div>
                </div>

                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">Configuración SMTP (Amazon SES)</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="smtp_host">Host SMTP</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="smtp_host" name="smtp_host" type="text" value="<?php echo $settings['smtp_host'] ?? ''; ?>">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="smtp_port">Puerto SMTP</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="smtp_port" name="smtp_port" type="text" value="<?php echo $settings['smtp_port'] ?? '587'; ?>">
                        </div>
                         <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="smtp_user">Usuario SMTP</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="smtp_user" name="smtp_user" type="text" value="<?php echo $settings['smtp_user'] ?? ''; ?>">
                        </div>
                         <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="smtp_pass">Contraseña SMTP</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="smtp_pass" name="smtp_pass" type="password" value="<?php echo $settings['smtp_pass'] ?? ''; ?>">
                        </div>
                    </div>
                </div>

                 <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">Pasarela de Pago (N1co)</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="n1co_key">API Key</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="n1co_key" name="n1co_key" type="password" value="<?php echo $settings['n1co_key'] ?? ''; ?>">
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end">
                    <button class="bg-blue-900 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>
