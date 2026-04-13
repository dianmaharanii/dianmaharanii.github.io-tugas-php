<?php
$host = 'localhost';
$db   = 'kampus_db';
$user = 'root';
$pass = '';

$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // tampilkan error
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // hasil array assoc
    ]);

    echo "Koneksi berhasil!\n"; // hanya untuk testing
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>