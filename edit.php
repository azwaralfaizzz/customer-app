<?php
include 'config/db.php';
session_start();

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM customers WHERE id = $id");
$data = mysqli_fetch_assoc($result);

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $telepon = trim($_POST['telepon']);

    if (empty($nama)) $errors[] = "Nama wajib diisi.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email tidak valid.";
    if (!empty($telepon) && !ctype_digit($telepon)) $errors[] = "Telepon hanya boleh berisi angka.";

    if (count($errors) === 0) {
        $query = "UPDATE customers SET nama='$nama', email='$email', telepon='$telepon' WHERE id=$id";
        if (mysqli_query($conn, $query)) {
            $_SESSION['message'] = "Data customer berhasil diperbarui.";
            header("Location: index.php");
            exit;
        } else {
            $errors[] = "Gagal mengupdate data: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Customer</title>
</head>
<body>
    <h2>Edit Customer</h2>

    <?php if (!empty($errors)): ?>
            <ul style="color: red;">
                <?php foreach ($errors as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

    <form method="POST">
        Nama: <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>"><br>
        Email: <input type="email" name="email" value="<?= htmlspecialchars($data['email']) ?>"><br>
        Telepon: <input type="text" name="telepon" value="<?= htmlspecialchars($data['telepon']) ?>"><br>
        <button type="submit">Update</button>
    </form>
</body>
</html>