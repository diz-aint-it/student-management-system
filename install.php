<?php
global $pdo;
require 'includes/config.php';
require 'includes/functions.php';

if (file_exists(__DIR__ . '/.env')) {
    die("Installation already completed.");
}

// Create tables
$sql = <<<SQL
CREATE TABLE IF NOT EXISTS user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS section (
    id INT AUTO_INCREMENT PRIMARY KEY,
    designation VARCHAR(50) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS student (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    birthday DATE NOT NULL,
    image VARCHAR(255),
    section_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (section_id) REFERENCES section(id)
);
SQL;

try {
    $pdo->exec($sql);

    // Create admin user
    $password = password_hash('admin123', PASSWORD_BCRYPT);
    $pdo->prepare("INSERT INTO user (username, email, password, role) VALUES (?, ?, ?, ?)")
        ->execute(['admin', 'admin@example.com', $password, 'admin']);

    file_put_contents(__DIR__ . '/.env', file_get_contents(__DIR__ . '/.env.example'));
    echo "Installation successful! Default admin credentials: admin/admin123";
} catch (PDOException $e) {
    die("Installation failed: " . $e->getMessage());
}