<?php require_once __DIR__ . '/../../partials/header.php'; ?>

<div class="flex min-h-screen bg-gray-100">
    <?php require_once __DIR__ . '/partials/sidebar.php'; ?>

    <div class="flex-1 flex flex-col p-6 overflow-y-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Soporte Técnico</h1>
            <button onclick="document.getElementById('newTicketModal').classList.remove('hidden')" class="bg-blue-900 text-white px-4 py-2 rounded hover:bg-blue-800 transition">
                <i class="fa-solid fa-plus mr-2"></i> Nuevo Ticket
            </button>
        </div>

        <div class="grid grid-cols-1 gap-6">
            <?php foreach($tickets as $ticket): ?>
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 <?php echo $ticket['status'] === 'open' ? 'border-green-500' : 'border-gray-500'; ?>">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800"><?php echo htmlspecialchars($ticket['subject']); ?></h3>
                        <span class="text-xs text-gray-500"><?php echo date('d/m/Y H:i', strtotime($ticket['created_at'])); ?></span>
                    </div>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full <?php echo $ticket['status'] === 'open' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'; ?>">
                        <?php echo ucfirst($ticket['status']); ?>
                    </span>
                </div>
                <p class="text-gray-600 text-sm mb-4 bg-gray-50 p-3 rounded">
                    <?php echo nl2br(htmlspecialchars($ticket['message'])); ?>
                </p>
                <div class="text-right">
                    <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Ver conversación <i class="fa-solid fa-arrow-right ml-1"></i></a>
                </div>
            </div>
            <?php endforeach; ?>

            <?php if(empty($tickets)): ?>
                <div class="text-center py-10 text-gray-500">
                    <i class="fa-solid fa-life-ring text-4xl mb-4 text-gray-300"></i>
                    <p>No hay tickets de soporte abiertos.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- New Ticket Modal -->
<div id="newTicketModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Crear Ticket de Soporte</h3>
            <form action="/client/tickets/create" method="POST" class="mt-2 text-left">
                <?php echo $csrf_input; ?>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="subject">Asunto</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="subject" name="subject" type="text" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="message">Mensaje</label>
                    <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline h-32" id="message" name="message" required></textarea>
                </div>
                <div class="flex items-center justify-between mt-4">
                    <button type="button" onclick="document.getElementById('newTicketModal').classList.add('hidden')" class="bg-gray-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline hover:bg-gray-600">Cancelar</button>
                    <button type="submit" class="bg-blue-900 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline hover:bg-blue-800">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>
