<?php
include 'config.php';

// Buat tabel users
$sql1 = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
)";

$pdo->exec($sql1);

// Buat tabel birthdays
$sql2 = "CREATE TABLE IF NOT EXISTS birthdays (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    date DATE NOT NULL,
    image VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)";

$pdo->exec($sql2);
echo "Database dan tabel telah dibuat.";
?>
