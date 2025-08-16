<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_mbskonseling";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mendapatkan ID dari URL
$id = intval($_GET['id']);

// Query untuk menghapus data konseling
$sql = "DELETE FROM konseling WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "<script>alert('Data berhasil dihapus!'); window.location.href='history.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus data!'); window.location.href='history.php';</script>";
}

$stmt->close();
$conn->close();
?>
