<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-2xl shadow-xl">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-blue-900">
                Crear Cuenta
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                ¿Ya tienes cuenta?
                <a href="/login" class="font-medium text-yellow-600 hover:text-yellow-500">
                    Inicia sesión aquí
                </a>
            </p>
        </div>

        <?php if ($msg = App\flash('error')): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                <p><?php echo $msg; ?></p>
            </div>
        <?php endif; ?>

        <form class="mt-8 space-y-6" action="/register" method="POST">
            <?php echo App\CSRF::input(); ?>
            <div class="rounded-md shadow-sm -space-y-px">
                <div>
                    <label for="full_name" class="sr-only">Nombre Completo</label>
                    <input id="full_name" name="full_name" type="text" autocomplete="name" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 focus:z-10 sm:text-sm" placeholder="Nombre Completo">
                </div>
                <div>
                    <label for="email-address" class="sr-only">Correo Electrónico</label>
                    <input id="email-address" name="email" type="email" autocomplete="email" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 focus:z-10 sm:text-sm" placeholder="Correo Electrónico">
                </div>
                <div>
                    <label for="phone" class="sr-only">Teléfono</label>
                    <div class="flex">
                        <select id="country_code" name="country_code" class="appearance-none rounded-none relative block w-24 px-3 py-2 border border-gray-300 bg-white text-gray-900 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 focus:z-10 sm:text-sm">
                            <option value="+52">MX (+52)</option>
                            <option value="+57">CO (+57)</option>
                            <option value="+54">AR (+54)</option>
                            <option value="+56">CL (+56)</option>
                            <option value="+51">PE (+51)</option>
                            <option value="+593">EC (+593)</option>
                            <option value="+58">VE (+58)</option>
                            <option value="+502">GT (+502)</option>
                            <option value="+503">SV (+503)</option>
                            <option value="+504">HN (+504)</option>
                            <option value="+505">NI (+505)</option>
                            <option value="+506">CR (+506)</option>
                            <option value="+507">PA (+507)</option>
                            <option value="+591">BO (+591)</option>
                            <option value="+595">PY (+595)</option>
                            <option value="+598">UY (+598)</option>
                        </select>
                        <input id="phone" name="phone" type="tel" autocomplete="tel" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 focus:z-10 sm:text-sm" placeholder="Número de Teléfono">
                    </div>
                </div>
                <div>
                    <label for="password" class="sr-only">Contraseña</label>
                    <input id="password" name="password" type="password" autocomplete="new-password" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 focus:z-10 sm:text-sm" placeholder="Contraseña (Mín. 8 chars, 1 Mayus, 1 Num, 1 Simbolo)">
                    <p class="text-xs text-gray-500 mt-1 pl-2">Debe tener al menos 8 caracteres, una mayúscula, un número y un símbolo.</p>
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-900 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fa-solid fa-user-plus text-blue-300 group-hover:text-blue-100"></i>
                    </span>
                    Registrarse
                </button>
            </div>

             <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">
                            O registrarse con
                        </span>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-1 gap-3">
                    <div>
                        <a href="/auth/google" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <i class="fa-brands fa-google text-red-500 mr-2 text-lg"></i> Google
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
