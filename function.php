<?php
// Fungsi untuk mengambil semua pengguna dari tabel users
function getAllUsers($pdo) {
    $sql = "SELECT * FROM users ORDER BY name";  // Mengurutkan berdasarkan nama
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fungsi untuk menambah ulang tahun ke tabel birthdays
function addBirthday($pdo, $user_id, $date, $image) {
    $sql = "INSERT INTO birthdays (user_id, date, image) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$user_id, $date, $image]);
}

// Fungsi untuk mendapatkan semua ulang tahun dari tabel birthdays
function getAllBirthdays($pdo) {
    $sql = "SELECT b.*, u.name FROM birthdays b 
            JOIN users u ON b.user_id = u.id 
            ORDER BY b.date";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fungsi untuk menghapus ulang tahun berdasarkan ID
function deleteBirthday($pdo, $id) {
    // Ambil informasi gambar terlebih dahulu
    $birthday = getBirthdayById($pdo, $id);
    if ($birthday && !empty($birthday['image'])) {
        $image_path = "uploads/" . $birthday['image'];
        if (file_exists($image_path)) {
            unlink($image_path); // Hapus file gambar
        }
    }
    
    $sql = "DELETE FROM birthdays WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$id]);
}

// Fungsi untuk mendapatkan data ulang tahun berdasarkan ID (dengan data user)
function getBirthdayWithUserById($pdo, $id) {
    $sql = "SELECT b.*, u.name FROM birthdays b 
            JOIN users u ON b.user_id = u.id 
            WHERE b.id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Fungsi untuk mendapatkan data ulang tahun berdasarkan ID
function getBirthdayById($pdo, $id) {
    $sql = "SELECT * FROM birthdays WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Fungsi untuk memperbarui data ulang tahun
function updateBirthday($pdo, $id, $user_id, $date, $image) {
    $sql = "UPDATE birthdays SET user_id = ?, date = ?, image = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$user_id, $date, $image, $id]);
}

// Fungsi untuk memperbarui nama pengguna
function updateUserName($pdo, $user_id, $name) {
    $sql = "UPDATE users SET name = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$name, $user_id]);
}

// Tambahan: Fungsi untuk mendapatkan pengguna berdasarkan ID
function getUserById($pdo, $user_id) {
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
