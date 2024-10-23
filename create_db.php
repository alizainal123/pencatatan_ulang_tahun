 <?php
$host = 'localhost';
$username = 'root'; // Ganti sesuai dengan username database Anda
$password = ''; // Ganti sesuai dengan password database Anda jika diperlukan

try {
    // Buat koneksi ke MySQL
    $conn = new PDO("mysql:host=$host", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Buat database
    $sql = "CREATE DATABASE IF NOT EXISTS birthday_app";
    $conn->exec($sql);
    echo "Database 'birthday_app' telah dibuat atau sudah ada.";

    // Pilih database yang baru dibuat
    $conn->exec("USE birthday_app");

    // Buat tabel users
    $sql1 = "CREATE TABLE IF NOT EXISTS users (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL
    )";
    $conn->exec($sql1);

    // Buat tabel birthdays
    $sql2 = "CREATE TABLE IF NOT EXISTS birthdays (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        user_id INT(11) NOT NULL,
        date DATE NOT NULL,
        image VARCHAR(255),
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )";
    $conn->exec($sql2);

    echo "Tabel 'users' dan 'birthdays' telah dibuat.";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
-->