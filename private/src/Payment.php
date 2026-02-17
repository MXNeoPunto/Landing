<?php

namespace App;

use Dotenv\Dotenv;

class Payment
{
    private $apiKey;
    private $merchantId;
    private $testMode;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->safeLoad();

        $this->apiKey = $_ENV['N1CO_API_KEY'] ?? '';
        $this->merchantId = $_ENV['N1CO_MERCHANT_ID'] ?? '';
        $this->testMode = $_ENV['N1CO_TEST_MODE'] ?? 'true';
    }

    public function createN1coOrder($amount, $orderId, $customerEmail)
    {
        // Mock implementation of N1co API call
        // In a real scenario, this would create a POST request to https://api.n1co.com/v1/orders

        $url = $this->testMode === 'true' ? 'https://api-sandbox.n1co.com/v1/orders' : 'https://api.n1co.com/v1/orders';

        $data = [
            'amount' => $amount,
            'currency' => 'USD',
            'order_id' => $orderId,
            'customer_email' => $customerEmail,
            // ... other required fields
        ];

        // Simulate successful response for now
        return [
            'success' => true,
            'redirect_url' => "https://checkout.n1co.com/pay/{$orderId}", // Mock URL
            'transaction_id' => 'mock_txn_' . uniqid()
        ];
    }

    public function processManualTransfer($file, $orderId)
    {
        // Handle file upload for bank transfer proof
        $targetDir = __DIR__ . '/../../public_html/uploads/transfers/';
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $fileName = basename($file["name"]);
        $targetFilePath = $targetDir . uniqid() . '_' . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Allow certain file formats
        $allowTypes = array('jpg', 'png', 'jpeg', 'pdf');
        if (in_array($fileType, $allowTypes)) {
            if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
                return [
                    'success' => true,
                    'file_path' => str_replace(__DIR__ . '/../../public_html', '', $targetFilePath)
                ];
            }
        }

        return ['success' => false, 'message' => 'Error al subir el archivo.'];
    }
}
