<?php
$rootDir = dirname(__DIR__);
require_once $rootDir . '/config/db.php';
require_once $rootDir . '/services/PaymentGatewayService.php';

// Webhooks receive POST payload usually as JSON
$rawPayload = file_get_contents('php://input');
$gateway = $_GET['gateway'] ?? 'unknown';

if ($rawPayload) {
    try {
        switch ($gateway) {
            case 'paypal':
                PaymentGatewayService::handlePayPalWebhook($rawPayload, getallheaders());
                break;
            case 'n1co':
                PaymentGatewayService::handleN1coWebhook($rawPayload, getallheaders());
                break;
            case 'tilopay':
                PaymentGatewayService::handleTilopayWebhook($rawPayload, getallheaders());
                break;
            default:
                http_response_code(400);
                echo "Gateway desconocido.";
                exit();
        }
        http_response_code(200);
        echo "Webhook procesado.";
    } catch (\Exception $e) {
        error_log("Webhook Error ($gateway): " . $e->getMessage());
        http_response_code(400); // Bad Request to indicate failure to provider
        echo "Error procesando webhook.";
    }
} else {
    http_response_code(400);
    echo "Payload vacío.";
}
