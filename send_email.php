<?php

require 'config.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = strip_tags(trim($_POST["message"]));

    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Datos inválidos."]);
        exit;
    }

    $to = ADMIN_EMAIL;
    $subject = "Nuevo contacto de: $name";

    $body = "
        <h2>Nuevo mensaje desde NeoPunto Web</h2>
        <p><strong>Nombre:</strong> $name</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Mensaje:</strong></p>
        <p>$message</p>
    ";

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: " . SMTP_FROM_NAME . " <" . SMTP_FROM_EMAIL . ">" . "\r\n";
    $headers .= "Reply-To: " . $name . " <" . $email . ">" . "\r\n";

    if (mail($to, $subject, $body, $headers)) {
        echo json_encode(["status" => "success", "message" => "Mensaje enviado correctamente."]);
    } else {
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "El mensaje no pudo ser enviado."]);
    }
} else {
    http_response_code(403);
    echo json_encode(["status" => "error", "message" => "Acceso denegado."]);
}
