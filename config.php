<?php
// Amazon SES SMTP Configuration
// Replace these values with your actual Amazon SES credentials

define('SMTP_HOST', 'email-smtp.us-east-1.amazonaws.com'); // Example region
define('SMTP_USER', 'YOUR_SES_SMTP_USERNAME');
define('SMTP_PASS', 'YOUR_SES_SMTP_PASSWORD');
define('SMTP_PORT', 587); // TLS port
define('SMTP_FROM_EMAIL', 'clientes@neopunto.com');
define('SMTP_FROM_NAME', 'NeoPunto Web');

// Recipient Email (Admin)
define('ADMIN_EMAIL', 'clientes@neopunto.com');
