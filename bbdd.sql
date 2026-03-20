-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS zapatillas_db;
USE zapatillas_db;

-- Tabla de marcas
CREATE TABLE marcas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

-- Tabla de modelos
CREATE TABLE modelos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    marca_id INT NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (marca_id) REFERENCES marcas(id) ON DELETE CASCADE
);

-- Tabla de zapatillas
CREATE TABLE zapatillas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sku VARCHAR(20) NOT NULL UNIQUE,
    modelo_id INT NOT NULL,
    nombre VARCHAR(200) NOT NULL,
    precio DECIMAL(8,2) NOT NULL,
    imagen_url VARCHAR(255) NULL,
    tendencia BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (modelo_id) REFERENCES modelos(id) ON DELETE CASCADE
);

-- Insertar marcas
INSERT INTO marcas (nombre, created_at, updated_at) VALUES
('Nike', NOW(), NOW()),
('Adidas', NOW(), NOW()),
('New Balance', NOW(), NOW()),
('Puma', NOW(), NOW()),
('Jordan', NOW(), NOW());

-- Insertar modelos
INSERT INTO modelos (nombre, marca_id, created_at, updated_at) VALUES
-- Nike (marca_id = 1)
('Air Force 1', 1, NOW(), NOW()),
('Dunk Low', 1, NOW(), NOW()),
('Air Max 90', 1, NOW(), NOW()),

-- Adidas (marca_id = 2)
('Samba', 2, NOW(), NOW()),
('Superstar', 2, NOW(), NOW()),
('Gazelle', 2, NOW(), NOW()),

-- New Balance (marca_id = 3)
('550', 3, NOW(), NOW()),
('993', 3, NOW(), NOW()),

-- Puma (marca_id = 4)
('Speedcat', 4, NOW(), NOW()),
('Suede', 4, NOW(), NOW()),

-- Jordan (marca_id = 5)
('Air Jordan 1', 5, NOW(), NOW()),
('Air Jordan 4', 5, NOW(), NOW());

-- Insertar zapatillas
INSERT INTO zapatillas (sku, modelo_id, nombre, precio, imagen_url, tendencia, created_at, updated_at) VALUES
('CW2288-111', 1, 'Nike Air Force 1 ''07 Triple White', 100.00, 'https://ejemplo.com/af1-white.jpg', TRUE, NOW(), NOW()),
('CW2288-001', 1, 'Nike Air Force 1 ''07 Triple Black', 100.00, 'https://ejemplo.com/af1-black.jpg', FALSE, NOW(), NOW()),
('DD1391-100', 2, 'Nike Dunk Low Retro White/Black', 110.00, 'https://ejemplo.com/dunk-panda.jpg', TRUE, NOW(), NOW()),
('DD1391-102', 2, 'Nike Dunk Low Retro White/University Blue', 110.00, 'https://ejemplo.com/dunk-blue.jpg', FALSE, NOW(), NOW()),
('B75806', 4, 'Adidas Samba OG White/Black', 80.00, 'https://ejemplo.com/samba-white.jpg', TRUE, NOW(), NOW()),
('B75807', 4, 'Adidas Samba OG Black/White', 80.00, 'https://ejemplo.com/samba-black.jpg', FALSE, NOW(), NOW()),
('BB550PB1', 7, 'New Balance 550 White/Green', 110.00, 'https://ejemplo.com/nb550-green.jpg', TRUE, NOW(), NOW()),
('396472-01', 9, 'Puma Speedcat OG Red', 90.00, 'https://ejemplo.com/speedcat-red.jpg', TRUE, NOW(), NOW());