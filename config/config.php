<?php

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'neopunto');

// Amazon SES configuration (Simulated for mail)
define('SMTP_HOST', 'email-smtp.us-east-1.amazonaws.com');
define('SMTP_USER', 'YOUR_SES_SMTP_USERNAME');
define('SMTP_PASS', 'YOUR_SES_SMTP_PASSWORD');
define('SMTP_PORT', 587);

define('SMTP_FROM_EMAIL', 'clientes@neopunto.com');
define('SMTP_FROM_NAME', 'NeoPunto Web');

// Recipient Email (Admin)
define('ADMIN_EMAIL', 'clientes@neopunto.com');
