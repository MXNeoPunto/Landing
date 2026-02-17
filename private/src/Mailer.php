<?php

namespace App;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

class Mailer
{
    private $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->safeLoad();

        try {
            $this->mail->isSMTP();
            $this->mail->Host = $_ENV['SMTP_HOST'] ?? 'email-smtp.us-east-1.amazonaws.com';
            $this->mail->SMTPAuth = true;
            $this->mail->Username = $_ENV['SMTP_USER'] ?? '';
            $this->mail->Password = $_ENV['SMTP_PASS'] ?? '';
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mail->Port = $_ENV['SMTP_PORT'] ?? 587;

            $this->mail->setFrom($_ENV['SMTP_FROM_EMAIL'] ?? 'noreply@example.com', $_ENV['SMTP_FROM_NAME'] ?? 'SaaS App');
        } catch (Exception $e) {
            // Log error
        }
    }

    public function send($to, $subject, $body)
    {
        try {
            $this->mail->addAddress($to);
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body    = $body;
            $this->mail->AltBody = strip_tags($body);

            $this->mail->send();
            return true;
        } catch (Exception $e) {
            return "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
        }
    }
}
