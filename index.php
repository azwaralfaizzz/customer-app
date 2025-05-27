<?php
include 'config/db.php';
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Customer</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Data Customer</h2>
    <!-- Tampilkan Pesan -->
    <?php if (isset($_SESSION['message'])): ?>
        <div style="padding:10px; border:1px solid #ccc; background-color:#e0ffe0; margin-bottom:10px;">
            <?= htmlspecialchars($_SESSION['message']) ?>
        </div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
    <a href="tambah.php">+ Tambah Customer</a>
    <table>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Telepon</th>
            <th>Aksi</th>
        </tr>
        <?php
        $no = 1;
        $query = "SELECT * FROM customers";
        $result = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                <td>$no</td>
                <td>".htmlspecialchars($row['nama'])."</td>
                <td>".htmlspecialchars($row['email'])."</td>
                <td>".htmlspecialchars($row['telepon'])."</td>
                <td>
                    <a href='edit.php?id={$row['id']}'>Edit</a> |
                    <a href='hapus.php?id={$row['id']}' onclick='return confirm(\"Yakin?\")'>Hapus</a>
                </td>
            </tr>";
            $no++;
        }
        ?>
    </table>
</body>
</html>