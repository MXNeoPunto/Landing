<?php require_once __DIR__ . '/../../partials/header.php'; ?>

<div class="flex min-h-screen bg-gray-100">
    <?php require_once __DIR__ . '/partials/sidebar.php'; ?>

    <div class="flex-1 flex flex-col p-6 overflow-y-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Mis Pedidos</h1>

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
             <?php if(empty($orders)): ?>
                <div class="p-8 text-center text-gray-500">
                    <p>No tienes pedidos aún. ¡Solicita uno nuevo desde el dashboard!</p>
                </div>
            <?php else: ?>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Servicio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach($orders as $order): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">#<?php echo $order['id']; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium"><?php echo htmlspecialchars($order['service_name']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                <?php
                                    echo match($order['status']) {
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'processing' => 'bg-blue-100 text-blue-800',
                                        'completed' => 'bg-green-100 text-green-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-800'
                                    };
                                ?>">
                                <?php echo ucfirst($order['status']); ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$<?php echo number_format($order['total_amount'], 2); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo date('d/m/Y', strtotime($order['created_at'])); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <?php if ($order['status'] === 'pending'): ?>
                                <button onclick="openPaymentModal(<?php echo $order['id']; ?>, <?php echo $order['total_amount']; ?>)" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs transition">
                                    <i class="fa-solid fa-credit-card mr-1"></i> Pagar
                                </button>
                            <?php endif; ?>
                            <a href="#" class="text-indigo-600 hover:text-indigo-900 ml-2"><i class="fa-solid fa-eye"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div id="paymentModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Pagar Orden #<span id="modalOrderId"></span></h3>
            <p class="text-sm text-gray-500 mb-4">Total a pagar: $<span id="modalAmount"></span></p>

            <form action="/client/orders/pay" method="POST" enctype="multipart/form-data" class="mt-2 text-left">
                <?php echo $csrf_input; ?>
                <input type="hidden" name="order_id" id="formOrderId">

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Método de Pago</label>
                    <div class="flex items-center mb-2">
                        <input type="radio" id="n1co" name="payment_method" value="n1co" class="mr-2" checked onchange="togglePaymentFields()">
                        <label for="n1co" class="text-sm text-gray-700 font-medium"><i class="fa-solid fa-credit-card text-blue-600 mr-1"></i> Tarjeta (N1co)</label>
                    </div>
                    <div class="flex items-center">
                        <input type="radio" id="transfer" name="payment_method" value="transfer" class="mr-2" onchange="togglePaymentFields()">
                        <label for="transfer" class="text-sm text-gray-700 font-medium"><i class="fa-solid fa-building-columns text-green-600 mr-1"></i> Transferencia Bancaria</label>
                    </div>
                </div>

                <div id="transferFields" class="hidden mb-4 bg-gray-50 p-3 rounded">
                    <p class="text-xs text-gray-600 mb-2">Realiza la transferencia a la cuenta:</p>
                    <p class="text-sm font-bold text-gray-800">Bank Corp - 1234567890</p>
                    <div class="mt-3">
                        <label class="block text-gray-700 text-xs font-bold mb-1">Subir Comprobante</label>
                        <input type="file" name="proof_image" class="w-full text-xs">
                    </div>
                </div>

                <div class="flex items-center justify-between mt-6">
                    <button type="button" onclick="document.getElementById('paymentModal').classList.add('hidden')" class="bg-gray-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline hover:bg-gray-600 text-sm">Cancelar</button>
                    <button type="submit" class="bg-blue-900 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline hover:bg-blue-800 text-sm">Procesar Pago</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openPaymentModal(id, amount) {
        document.getElementById('modalOrderId').innerText = id;
        document.getElementById('formOrderId').value = id;
        document.getElementById('modalAmount').innerText = amount.toFixed(2);
        document.getElementById('paymentModal').classList.remove('hidden');
    }

    function togglePaymentFields() {
        const method = document.querySelector('input[name="payment_method"]:checked').value;
        const transferFields = document.getElementById('transferFields');
        if (method === 'transfer') {
            transferFields.classList.remove('hidden');
        } else {
            transferFields.classList.add('hidden');
        }
    }
</script>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>
