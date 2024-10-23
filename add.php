<?php
include 'config.php';
include 'function.php';

// Jika form disubmit
if (isset($_POST['submit'])) {
    // Ambil data dari form
    $name = $_POST['name']; // Mengambil nama dari input
    $date = $_POST['date'];

    // Cek jika ada file gambar yang diupload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $uploadOk = 1;

        // Cek ukuran file
        if ($_FILES["image"]["size"] > 500000) { // Maksimum 500 KB
            echo "Maaf, ukuran gambar terlalu besar.";
            $uploadOk = 0;
        }

        // Cek jenis file
        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            echo "Maaf, hanya file JPG, JPEG, PNG & GIF yang diperbolehkan.";
            $uploadOk = 0;
        }

        // Cek jika uploadOk = 1, maka upload file
        if ($uploadOk == 1) {
            // Pastikan direktori uploads ada
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // Simpan data ke database, termasuk path gambar
                $sql = "INSERT INTO users (name) VALUES (?)"; // Menyimpan nama pengguna
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$name]);

                // Ambil ID pengguna yang baru ditambahkan
                $user_id = $pdo->lastInsertId();

                // Tambahkan ulang tahun
                if (addBirthday($pdo, $user_id, $date, $target_file)) {
                    echo "Ulang tahun berhasil ditambahkan.";
                } else {
                    echo "Terjadi kesalahan saat menyimpan data ke database.";
                }
            } else {
                echo "Maaf, terjadi kesalahan saat mengupload gambar.";
            }
        }
    } else {
        echo "Tidak ada gambar yang diupload atau terjadi kesalahan.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Ulang Tahun</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Tambah Ulang Tahun</h1>
        
        <form action="add.php" method="post" enctype="multipart/form-data">
            <label for="name">Nama:</label>
            <input type="text" name="name" id="name" required>
            
            <label for="date">Tanggal Ulang Tahun:</label>
            <input type="date" name="date" id="date" required>
            
            <label for="image">Gambar (Opsional):</label>
            <input type="file" name="image" id="image">
            
            <button type="submit" name="submit">Tambah Ulang Tahun</button>
        </form>
        
     
        <a href="index.php" class="btn-back">Kembali</a>
    </div>
</body>
</html>

