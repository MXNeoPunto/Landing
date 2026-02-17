<?php require_once __DIR__ . '/../../partials/header.php'; ?>

<div class="flex min-h-screen bg-gray-100">
    <?php require_once __DIR__ . '/partials/sidebar.php'; ?>

    <div class="flex-1 flex flex-col p-6 overflow-y-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Gestión de Servicios</h1>
            <button onclick="document.getElementById('createModal').classList.remove('hidden')" class="bg-blue-900 text-white px-4 py-2 rounded hover:bg-blue-800 transition">
                <i class="fa-solid fa-plus mr-2"></i> Nuevo Servicio
            </button>
        </div>

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach($services as $service): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo htmlspecialchars($service['name']); ?></td>
                        <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate"><?php echo htmlspecialchars($service['description']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$<?php echo number_format($service['price'], 2); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $service['active'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                                <?php echo $service['active'] ? 'Activo' : 'Inactivo'; ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button onclick="openEditModal(<?php echo htmlspecialchars(json_encode($service)); ?>)" class="text-indigo-600 hover:text-indigo-900 mr-3"><i class="fa-solid fa-edit"></i></button>
                            <form action="/admin/services/delete" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este servicio?');" class="inline">
                                <?php echo $csrf_input; ?>
                                <input type="hidden" name="service_id" value="<?php echo $service['id']; ?>">
                                <button type="submit" class="text-red-600 hover:text-red-900"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Create Service -->
<div id="createModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Crear Nuevo Servicio</h3>
            <form action="/admin/services/create" method="POST" class="mt-2 text-left">
                <?php echo $csrf_input; ?>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Nombre</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" name="name" type="text" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="description">Descripción</label>
                    <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" name="description"></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="price">Precio</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="price" name="price" type="number" step="0.01" required>
                </div>
                <div class="flex items-center justify-between mt-4">
                    <button type="button" onclick="document.getElementById('createModal').classList.add('hidden')" class="bg-gray-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline hover:bg-gray-600">Cancelar</button>
                    <button type="submit" class="bg-blue-900 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline hover:bg-blue-800">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Service -->
<div id="editModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Editar Servicio</h3>
            <form action="/admin/services/update" method="POST" class="mt-2 text-left" id="editForm">
                <?php echo $csrf_input; ?>
                <input type="hidden" name="service_id" id="edit_service_id">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="edit_name">Nombre</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="edit_name" name="name" type="text" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="edit_description">Descripción</label>
                    <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="edit_description" name="description"></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="edit_price">Precio</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="edit_price" name="price" type="number" step="0.01" required>
                </div>
                 <div class="mb-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" class="form-checkbox text-blue-600" id="edit_active" name="active" value="1">
                        <span class="ml-2 text-gray-700">Activo</span>
                    </label>
                </div>
                <div class="flex items-center justify-between mt-4">
                    <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')" class="bg-gray-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline hover:bg-gray-600">Cancelar</button>
                    <button type="submit" class="bg-blue-900 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline hover:bg-blue-800">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openEditModal(service) {
        document.getElementById('edit_service_id').value = service.id;
        document.getElementById('edit_name').value = service.name;
        document.getElementById('edit_description').value = service.description;
        document.getElementById('edit_price').value = service.price;
        document.getElementById('edit_active').checked = service.active == 1;
        document.getElementById('editModal').classList.remove('hidden');
    }
</script>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>
