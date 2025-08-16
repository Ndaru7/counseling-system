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

// Mendapatkan NISN dari permintaan
$nisn = $_GET['nisn'];

// Query untuk mengambil data siswa berdasarkan NISN
$sql = "SELECT nama_siswa, kelas FROM siswa WHERE nisn = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nisn);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Mengambil data siswa
    $row = $result->fetch_assoc();
    echo json_encode($row);
} else {
    echo json_encode(['nama_siswa' => '', 'kelas' => '']);
}

$stmt->close();
$conn->close();
?>
