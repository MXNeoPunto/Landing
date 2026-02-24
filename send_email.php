<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
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

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USER;
        $mail->Password   = SMTP_PASS;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = SMTP_PORT;

        // Recipients
        $mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
        $mail->addAddress(ADMIN_EMAIL);
        $mail->addReplyTo($email, $name);

        // Content
        $mail->isHTML(true);
        $mail->Subject = "Nuevo contacto de: $name";
        $mail->Body    = "
            <h2>Nuevo mensaje desde NeoPunto Web</h2>
            <p><strong>Nombre:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Mensaje:</strong></p>
            <p>$message</p>
        ";
        $mail->AltBody = "Nombre: $name\nEmail: $email\n\nMensaje:\n$message";

        $mail->send();
        echo json_encode(["status" => "success", "message" => "Mensaje enviado correctamente."]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "El mensaje no pudo ser enviado. Error: {$mail->ErrorInfo}"]);
    }
} else {
    http_response_code(403);
    echo json_encode(["status" => "error", "message" => "Acceso denegado."]);
}
