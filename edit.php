<?php
include 'config.php';
include 'function.php';

$id = $_GET['id'];
$birthday = getBirthdayWithUserById($pdo, $id); // Mengambil data ulang tahun dan pengguna

if (!$birthday) {
    echo "Ulang tahun tidak ditemukan.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $name = $_POST['name']; // Menyimpan nama dari input
    $date = $_POST['date'];

    // Validasi user_id
    $user = getUserById($pdo, $user_id);
    if (!$user) {
        echo "User ID tidak valid.";
        exit;
    }

    // Update data ulang tahun di database
    updateBirthday($pdo, $id, $user_id, $date, $birthday['image']); // Menggunakan gambar lama

    // Update nama pengguna jika ada perubahan
    if ($name !== $user['name']) {
        updateUserName($pdo, $user_id, $name);
    }
    
    header("Location: index.php");
    exit; // Pastikan untuk keluar setelah redireksi
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Ulang Tahun</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Edit Ulang Tahun</h1>
    <form action="" method="post">
        <label for="user_id">User ID:</label>
        <input type="text" name="user_id" value="<?php echo $birthday['user_id']; ?>" required readonly>
        
        <label for="name">Nama:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($birthday['name']); ?>" required>
        
        <label for="date">Tanggal:</label>
        <input type="date" name="date" value="<?php echo $birthday['date']; ?>" required>
        
        <button type="submit">Update</button>
    </form>
    <a href="index.php">Kembali</a>
</body>
</html>
