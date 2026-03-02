<?php

class PaymentGatewayService {

    // PayPal Webhook Verification & Processing
    public static function handlePayPalWebhook($payload, $headers) {
        $data = json_decode($payload, true);

        // 1. In real scenario, verify webhook signature using cURL to PayPal API
        // using the CERT-URL, TRANSMISSION-SIG, etc. from $headers

        if ($data['event_type'] === 'PAYMENT.CAPTURE.COMPLETED') {
            $orderId = $data['resource']['supplementary_data']['related_ids']['order_id'] ?? '';
            $status = $data['resource']['status'] ?? '';

            // Validate and update DB based on custom_id passed during payment creation
            global $pdo;
            $facturaId = $data['resource']['custom_id'] ?? 0;

            if ($status === 'COMPLETED') {
                $stmt = $pdo->prepare("UPDATE facturas SET estado_pago = 'pagado' WHERE id = ?");
                $stmt->execute([$facturaId]);
            }
        }
    }

    // N1co E-Pay Webhook Processing
    public static function handleN1coWebhook($payload, $headers) {
        $data = json_decode($payload, true);

        // N1co typically sends an HMAC signature or token in headers to verify
        // $n1coSecret = 'DB_CONFIG_SECRET';
        // $signature = hash_hmac('sha256', $payload, $n1coSecret);

        if (isset($data['status']) && $data['status'] === 'success') {
            $facturaId = $data['reference'] ?? 0;
            global $pdo;
            $stmt = $pdo->prepare("UPDATE facturas SET estado_pago = 'pagado' WHERE id = ?");
            $stmt->execute([$facturaId]);
        }
    }

    // Tilopay Webhook Processing
    public static function handleTilopayWebhook($payload, $headers) {
        $data = json_decode($payload, true);

        // Check Tilopay HMAC signature from headers

        if (isset($data['Status']) && $data['Status'] === 'Aprobada') {
            $facturaId = $data['OrderNumber'] ?? 0;
            global $pdo;
            $stmt = $pdo->prepare("UPDATE facturas SET estado_pago = 'pagado' WHERE id = ?");
            $stmt->execute([$facturaId]);
        }
    }

    // Example cURL to create a PayPal Order
    public static function createPayPalOrder($amount, $currency, $facturaId) {
        $ch = curl_init('https://api-m.sandbox.paypal.com/v2/checkout/orders');
        $payload = json_encode([
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "amount" => ["currency_code" => $currency, "value" => $amount],
                    "custom_id" => (string)$facturaId
                ]
            ]
        ]);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Authorization: Bearer MOCK_ACCESS_TOKEN']);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }
}
