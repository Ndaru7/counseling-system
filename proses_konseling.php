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
$jenis_kelamin = $_POST['jenis_kelamin'];
$hari = $_POST['hari'];
$tanggal = $_POST['tanggal'];
$skor = $_POST['skor'];
$keterangan = $_POST['keterangan'];

// Query untuk memasukkan data konseling
$sql = "INSERT INTO konseling (nisn, nama_siswa, kelas, jenis_kelamin, hari, tanggal, skor, keterangan) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssis", $nisn, $nama_siswa, $kelas, $jenis_kelamin, $hari, $tanggal, $skor, $keterangan);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    // Mengarahkan ke halaman cetak dengan parameter ID data yang baru disimpan
    $last_id = $conn->insert_id;
    header("Location: print_konseling.php?id=$last_id");
    exit();
} else {
    echo "Gagal menyimpan data.";
}

$stmt->close();
$conn->close();
?>
