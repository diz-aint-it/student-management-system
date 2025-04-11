<?php
// Load environment variables
$env = parse_ini_file(__DIR__ . '/../.env');

try {
    $pdo = new PDO(
        "mysql:host={$env['DB_HOST']};port={$env['DB_PORT']};dbname={$env['DB_NAME']}",
        $env['DB_USER'],
        $env['DB_PASS'],
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
    echo "Database connected successfully!";
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
