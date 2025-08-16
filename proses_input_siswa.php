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

// Mendapatkan data dari form
$nisn = $_POST['nisn'];
$nama_siswa = $_POST['nama_siswa'];
$kelas = $_POST['kelas'];

// Query untuk memasukkan data siswa
$sql = "INSERT INTO siswa (nisn, nama_siswa, kelas) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $nisn, $nama_siswa, $kelas);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Data berhasil disimpan!";
} else {
    echo "Gagal menyimpan data.";
}

$stmt->close();
$conn->close();
?>
