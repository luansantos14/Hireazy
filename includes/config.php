<?php
$host = getenv('HIREAZY_DB_HOST') ?: '127.0.0.1';
$db = getenv('HIREAZY_DB_NAME') ?: 'hireazy';
$user = getenv('HIREAZY_DB_USER') ?: 'root';
$pass = getenv('HIREAZY_DB_PASS') ?: '';
$dsn = "mysql:host={$host};dbname={$db};charset=utf8mb4";
try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    $pdo = null;
}
