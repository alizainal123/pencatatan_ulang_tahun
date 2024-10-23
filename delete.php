<?php
include 'config.php';
include 'function.php';

// Cek apakah ID ada di URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
} else {
    echo "ID tidak ditemukan.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Hapus</title>
    <script>
        // Fungsi untuk menampilkan alert konfirmasi
        function confirmDelete() {
            const confirmation = confirm("Apakah Anda yakin ingin menghapus ulang tahun ini?");
            if (confirmation) {
                // Jika pengguna mengonfirmasi, redirect ke delete.php dengan parameter confirm
                window.location.href = "delete.php?id=<?php echo $id; ?>&confirm=yes";
            } else {
                // Jika tidak, kembali ke index.php
                window.location.href = "index.php";
            }
        }
    </script>
</head>
<body onload="confirmDelete()">
    <h1>Konfirmasi Hapus</h1>
    <p>Apakah Anda yakin ingin menghapus ulang tahun ini?</p>
    <button onclick="confirmDelete()">Hapus</button>
    <a href="index.php">Batal</a>
</body>
</html>

<?php
// Cek apakah penghapusan dikonfirmasi
if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
    // Hapus ulang tahun dari database berdasarkan ID
    deleteBirthday($pdo, $id);

    // Redirect ke halaman index setelah penghapusan
    header("Location: index.php");
    exit();
}
?>
