CREATE DATABASE IF NOT EXISTS hireazy
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE hireazy;

CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(160) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    phone VARCHAR(30) NULL,
    city VARCHAR(80) NULL,
    role ENUM('client', 'provider') NOT NULL,
    profession VARCHAR(100) NULL,
    bio TEXT NULL,
    hourly_rate DECIMAL(10, 2) NULL,
    rating DECIMAL(2, 1) NOT NULL DEFAULT 5.0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS service_requests (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    client_id INT UNSIGNED NOT NULL,
    provider_id INT UNSIGNED NOT NULL,
    title VARCHAR(160) NOT NULL,
    description TEXT NOT NULL,
    status ENUM(
        'pending',
        'accepted',
        'completed',
        'cancelled'
    ) NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (client_id)
        REFERENCES users(id)
        ON DELETE CASCADE,

    FOREIGN KEY (provider_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);

INSERT IGNORE INTO users (
    name,
    email,
    password_hash,
    city,
    role,
    profession,
    bio,
    hourly_rate,
    rating
) VALUES
(
    'Ana Martins',
    'ana@hireazy.local',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3RoSxR1GqM8O8Ff5u4r9qI7e',
    'São Paulo',
    'provider',
    'Designer de interiores',
    'Transformo espaços em lugares para viver melhor.',
    120.00,
    4.9
),
(
    'Rafael Lima',
    'rafael@hireazy.local',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3RoSxR1GqM8O8Ff5u4r9qI7e',
    'Rio de Janeiro',
    'provider',
    'Eletricista residencial',
    'Instalação, manutenção e pequenos reparos com segurança.',
    90.00,
    4.8
),
(
    'Carla Souza',
    'carla@hireazy.local',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3RoSxR1GqM8O8Ff5u4r9qI7e',
    'Belo Horizonte',
    'provider',
    'Fotógrafa',
    'Retratos naturais para marcas, eventos e histórias reais.',
    180.00,
    5.0
);