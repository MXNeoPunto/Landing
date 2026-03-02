<?php
class EmailService {
    public static function sendEmail($to, $subject, $htmlMessage, $configData) {
        $host = $configData['smtp_host'] ?? 'localhost';
        $port = $configData['smtp_port'] ?? 587;
        $user = $configData['smtp_user'] ?? '';
        $pass = $configData['smtp_pass'] ?? '';
        $fromEmail = $configData['smtp_from_email'] ?? 'noreply@neopunto.com';
        $fromName = $configData['smtp_from_name'] ?? 'NeoPunto';

        // Use native PHP mail if no SMTP configured
        if (empty($user) || empty($pass)) {
            $headers  = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8\r\n";
            $headers .= "From: {$fromName} <{$fromEmail}>\r\n";
            return @mail($to, $subject, $htmlMessage, $headers);
        }

        // Basic SMTP Socket Client for SES (TLS)
        $context = stream_context_create(['ssl' => ['verify_peer' => false, 'verify_peer_name' => false]]);
        $socket = stream_socket_client("tcp://{$host}:{$port}", $errno, $errstr, 10, STREAM_CLIENT_CONNECT, $context);

        if (!$socket) {
            error_log("SMTP Error: $errstr ($errno)");
            return false;
        }

        self::readSocket($socket); // read banner

        self::sendCommand($socket, "EHLO " . $_SERVER['SERVER_NAME']);

        // Start TLS if supported and on port 587
        if ($port == 587) {
            self::sendCommand($socket, "STARTTLS");
            stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
            self::sendCommand($socket, "EHLO " . $_SERVER['SERVER_NAME']);
        }

        // Auth LOGIN
        self::sendCommand($socket, "AUTH LOGIN");
        self::sendCommand($socket, base64_encode($user));
        self::sendCommand($socket, base64_encode($pass));

        // Sender & Recipient
        self::sendCommand($socket, "MAIL FROM:<{$fromEmail}>");
        self::sendCommand($socket, "RCPT TO:<{$to}>");

        // Data
        self::sendCommand($socket, "DATA");

        // Headers & Body
        $msg = "MIME-Version: 1.0\r\n";
        $msg .= "Content-Type: text/html; charset=UTF-8\r\n";
        $msg .= "From: =?UTF-8?B?" . base64_encode($fromName) . "?= <{$fromEmail}>\r\n";
        $msg .= "To: <{$to}>\r\n";
        $msg .= "Subject: =?UTF-8?B?" . base64_encode($subject) . "?=\r\n";
        $msg .= "\r\n";
        $msg .= $htmlMessage . "\r\n";
        $msg .= ".\r\n";

        fwrite($socket, $msg);
        self::readSocket($socket);

        self::sendCommand($socket, "QUIT");
        fclose($socket);

        return true;
    }

    private static function sendCommand($socket, $command) {
        fwrite($socket, $command . "\r\n");
        return self::readSocket($socket);
    }

    private static function readSocket($socket) {
        $data = '';
        while ($str = fgets($socket, 515)) {
            $data .= $str;
            if (substr($str, 3, 1) == ' ') { break; }
        }
        return $data;
    }
}
