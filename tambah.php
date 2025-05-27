<?php
include 'config/db.php';
session_start();

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $telepon = trim($_POST['telepon']);

    // Validasi
    if (empty($nama)) $errors[] = "Nama wajib diisi.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email tidak valid.";
    if (!empty($telepon) && !ctype_digit($telepon)) $errors[] = "Telepon hanya boleh berisi angka.";

    if (count($errors) === 0) {
        $query = "INSERT INTO customers (nama, email, telepon) VALUES ('$nama', '$email', '$telepon')";
        if (mysqli_query($conn, $query)) {
            $_SESSION['message'] = "Data customer berhasil ditambahkan.";
            header("Location: index.php");
            exit;
        } else {
            $errors[] = "Gagal menambahkan data: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Customer</title>
</head>
<body>
    <h2>Tambah Customer</h2>

    <?php if (!empty($errors)): ?>
            <ul style="color: red;">
                <?php foreach ($errors as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

    <form method="POST">
        Nama: <input type="text" name="nama" value="<?= isset($nama) ? htmlspecialchars($nama) : '' ?>"><br>
        Email: <input type="email" name="email" value="<?= isset($email) ? htmlspecialchars($email) : '' ?>"><br>
        Telepon: <input type="text" name="telepon" value="<?= isset($telepon) ? htmlspecialchars($telepon) : '' ?>"><br>
        <button type="submit">Simpan</button>
    </form>
</body>
</html>