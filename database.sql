CREATE DATABASE IF NOT EXISTS neopunto;
USE neopunto;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    username VARCHAR(100) NOT NULL UNIQUE,
    telefono VARCHAR(20) NOT NULL,
    pais VARCHAR(100) NOT NULL,
    moneda VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol ENUM('cliente', 'admin', 'admin_principal', 'admin_secundario', 'soporte') DEFAULT 'cliente',
    estado ENUM('activo', 'suspendido', 'baneado', 'sin_verificar') DEFAULT 'activo',
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL DEFAULT NULL
);

CREATE TABLE IF NOT EXISTS password_resets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    token VARCHAR(6) NOT NULL,
    expira DATETIME NOT NULL,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS config_general (
    id INT AUTO_INCREMENT PRIMARY KEY,
    smtp_host VARCHAR(255),
    smtp_port INT,
    smtp_user VARCHAR(255),
    smtp_pass VARCHAR(255),
    smtp_from_email VARCHAR(255),
    smtp_from_name VARCHAR(255),
    seo_title VARCHAR(255),
    seo_description TEXT,
    seo_keywords TEXT,
    seo_og_image VARCHAR(255),
    logo_header VARCHAR(255),
    favicon VARCHAR(255),
    logo_facturas VARCHAR(255),
    footer_social_facebook VARCHAR(255),
    footer_social_instagram VARCHAR(255),
    footer_whatsapp VARCHAR(20),
    footer_copyright VARCHAR(255),
    mantenimiento BOOLEAN DEFAULT FALSE,
    zona_horaria VARCHAR(100) DEFAULT 'America/Guatemala',
    version_sistema VARCHAR(20) DEFAULT '1.0.0',
    r2_access_key VARCHAR(255),
    r2_secret_key VARCHAR(255),
    r2_endpoint VARCHAR(255),
    r2_bucket VARCHAR(255),
    r2_public_url VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS metodos_pago (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    tipo ENUM('transferencia', 'pasarela') NOT NULL,
    estado ENUM('activo', 'inactivo') DEFAULT 'activo',
    configuracion JSON, -- Store gateway keys or bank details here
    monedas_soportadas VARCHAR(100) -- e.g., "GTQ,USD"
);

CREATE TABLE IF NOT EXISTS servicios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    tipo ENUM('cotizable', 'precio_fijo') NOT NULL,
    precio_aproximado DECIMAL(10, 2), -- For cotizable
    precio_fijo DECIMAL(10, 2), -- For precio_fijo
    estado ENUM('activo', 'inactivo') DEFAULT 'activo',
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS cotizaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    servicio_id INT,
    descripcion_cliente TEXT,
    estado ENUM('pendiente', 'en_revision', 'aprobado', 'en_proceso', 'finalizado', 'cancelado') DEFAULT 'pendiente',
    precio_final DECIMAL(10, 2), -- Set by admin
    moneda VARCHAR(20),
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (servicio_id) REFERENCES servicios(id)
);

CREATE TABLE IF NOT EXISTS tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cotizacion_id INT NOT NULL,
    usuario_id INT NOT NULL, -- Admin or Cliente
    mensaje TEXT NOT NULL,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cotizacion_id) REFERENCES cotizaciones(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE IF NOT EXISTS archivos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ticket_id INT, -- To attach to a specific chat message
    cotizacion_id INT NOT NULL,
    nombre_archivo VARCHAR(255) NOT NULL,
    ruta_archivo VARCHAR(255) NOT NULL,
    tamano INT NOT NULL, -- Bytes
    subido_por INT NOT NULL,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ticket_id) REFERENCES tickets(id) ON DELETE CASCADE,
    FOREIGN KEY (cotizacion_id) REFERENCES cotizaciones(id) ON DELETE CASCADE,
    FOREIGN KEY (subido_por) REFERENCES usuarios(id)
);

CREATE TABLE IF NOT EXISTS facturas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cotizacion_id INT NOT NULL,
    usuario_id INT NOT NULL,
    tipo_identificacion VARCHAR(50) NOT NULL, -- 'NIT', 'Consumidor Final', 'Tax ID'
    identificacion_numero VARCHAR(100),
    nombre_legal VARCHAR(255) NOT NULL,
    monto_total DECIMAL(10, 2) NOT NULL,
    moneda VARCHAR(20) NOT NULL,
    ruta_pdf VARCHAR(255),
    estado_pago ENUM('pendiente', 'pagado', 'fallido', 'en_revision') DEFAULT 'pendiente',
    metodo_pago_id INT,
    comprobante_ruta VARCHAR(255),
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cotizacion_id) REFERENCES cotizaciones(id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (metodo_pago_id) REFERENCES metodos_pago(id),
    UNIQUE (cotizacion_id)
);

-- Insert initial empty config record to allow updates
INSERT INTO config_general (id) VALUES (1);
