<?php
include 'config/db.php';
session_start();

$id = $_GET['id'];

if (mysqli_query($conn, "DELETE FROM customers WHERE id = $id")) {
    $_SESSION['message'] = "Data customer berhasil dihapus.";
} else {
    $_SESSION['message'] = "Gagal menghapus data.";
}

header("Location: index.php");
exit;
?>