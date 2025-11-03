<?php

$host = 'localhost';
$db_name = 'koneksi_database'; // nama database yang ingin dibuat
$username = 'root'; // sesuaikan dengan user MySQL kamu
$password = ''; // isi jika ada password MySQL

try {
    // 1️⃣ Koneksi ke MySQL tanpa database dulu
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 2️⃣ Buat database jika belum ada
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $db_name CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

    // 3️⃣ Koneksi ulang ke database yang sudah dibuat
    $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 4️⃣ (Opsional) Buat tabel contoh
    $sql = "
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ";
    $pdo->exec($sql);

    echo json_encode(["status" => "success", "message" => "Database & tabel siap digunakan."]);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}