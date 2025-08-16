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

// Proses update data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $nisn = $_POST['nisn'];
    $nama_siswa = $_POST['nama_siswa'];
    $kelas = $_POST['kelas'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $hari = $_POST['hari'];
    $tanggal = $_POST['tanggal'];
    $skor = $_POST['skor'];
    $keterangan = $_POST['keterangan'];

    $sql = "UPDATE konseling SET nisn = ?, nama_siswa = ?, kelas = ?, jenis_kelamin = ?, hari = ?, tanggal = ?, skor = ?, keterangan = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssisi", $nisn, $nama_siswa, $kelas, $jenis_kelamin, $hari, $tanggal, $skor, $keterangan, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location.href='history.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data!');</script>";
    }

    $stmt->close();
} elseif (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM konseling WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "<script>alert('Data tidak ditemukan!'); window.location.href='history.php';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('ID tidak valid!'); window.location.href='history.php';</script>";
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Konseling</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-10 px-4">
        <div class="bg-white shadow-md rounded p-6">
            <h2 class="text-3xl font-bold mb-6 text-center text-gray-800">Edit Konseling</h2>
            <form method="POST">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                <div class="mb-4">
                    <label for="nisn" class="block text-gray-700">NISN</label>
                    <input type="text" id="nisn" name="nisn" value="<?= htmlspecialchars($row['nisn']) ?>" class="border border-gray-300 rounded px-3 py-2 w-full" required>
                </div>
                <div class="mb-4">
                    <label for="nama_siswa" class="block text-gray-700">Nama Siswa</label>
                    <input type="text" id="nama_siswa" name="nama_siswa" value="<?= htmlspecialchars($row['nama_siswa']) ?>" class="border border-gray-300 rounded px-3 py-2 w-full" required>
                </div>
                <div class="mb-4">
                    <label for="kelas" class="block text-gray-700">Kelas</label>
                    <input type="text" id="kelas" name="kelas" value="<?= htmlspecialchars($row['kelas']) ?>" class="border border-gray-300 rounded px-3 py-2 w-full" required>
                </div>
                <div class="mb-4">
                    <label for="jenis_kelamin" class="block text-gray-700">Jenis Kelamin</label>
                    <select id="jenis_kelamin" name="jenis_kelamin" class="border border-gray-300 rounded px-3 py-2 w-full" required>
                        <option value="Laki-laki" <?= ($row['jenis_kelamin'] == 'Laki-laki') ? 'selected' : '' ?>>Laki-laki</option>
                        <option value="Perempuan" <?= ($row['jenis_kelamin'] == 'Perempuan') ? 'selected' : '' ?>>Perempuan</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="hari" class="block text-gray-700">Hari</label>
                    <input type="text" id="hari" name="hari" value="<?= htmlspecialchars($row['hari']) ?>" class="border border-gray-300 rounded px-3 py-2 w-full" readonly>
                </div>
                <div class="mb-4">
                    <label for="tanggal" class="block text-gray-700">Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal" value="<?= htmlspecialchars($row['tanggal']) ?>" class="border border-gray-300 rounded px-3 py-2 w-full" required>
                </div>
                <div class="mb-4">
                    <label for="skor" class="block text-gray-700">Skor</label>
                    <input type="number" id="skor" name="skor" value="<?= htmlspecialchars($row['skor']) ?>" class="border border-gray-300 rounded px-3 py-2 w-full" required>
                </div>
                <div class="mb-4">
                    <label for="keterangan" class="block text-gray-700">Keterangan</label>
                    <textarea id="keterangan" name="keterangan" class="border border-gray-300 rounded px-3 py-2 w-full" required><?= htmlspecialchars($row['keterangan']) ?></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded">Simpan</button>
                    <button type="reset" class="bg-red-500 hover:bg-red-700 text-white px-4 py-2 rounded ml-2">Reset</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
