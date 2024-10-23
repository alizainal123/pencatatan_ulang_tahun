<?php
include 'config.php';
include 'function.php';

$birthdays = getAllBirthdays($pdo);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ulang Tahun</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Daftar Ulang Tahun</h1>
    <table>
        <tr>
            <th>Nama</th>
            <th>Tanggal</th>
            <th>Gambar</th>
            <th>Aksi</th>
        </tr>
        <?php foreach ($birthdays as $birthday): ?>
            <tr>
                <td><?php echo htmlspecialchars($birthday['name']); ?></td>
                <td>
                    <?php 
                    
                        $originalDate = $birthday['date'];
                        $formattedDate = date('Y-m-d', strtotime($originalDate));
                        echo htmlspecialchars($formattedDate);
                    ?>
                </td>
                <td>
                    <?php if ($birthday['image']): ?>
                        <img src="<?php echo htmlspecialchars($birthday['image']); ?>" alt="Gambar Ulang Tahun" style="width: 100px; height: auto;">
                    <?php else: ?>
                        Tidak ada gambar
                    <?php endif; ?>
                </td>
                <td>
                    <a href="edit.php?id=<?php echo $birthday['id']; ?>" class="button">Edit</a>
                    <a href="delete.php?id=<?php echo $birthday['id']; ?>" class="button" onclick="return confirm('Anda yakin ingin menghapus?')">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="add.php" class="button">Tambah Ulang Tahun</a>
</body>
</html>
