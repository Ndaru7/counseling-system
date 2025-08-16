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

// Inisialisasi filter dan pencarian
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'nama_siswa';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Query untuk mendapatkan semua data konseling dengan filter dan pencarian
$sql = "SELECT * FROM konseling ";
if (!empty($search)) {
    $sql .= "WHERE $filter LIKE '%$search%' ";
}
$sql .= "ORDER BY $filter ASC";
$result = $conn->query($sql);

// Inisialisasi variabel untuk menghitung total konseling dan total pria/wanita
$totalPria = 0;
$totalWanita = 0;
$totalKonseling = 0;

// Hitung total pria, wanita, dan konseling
while ($row = $result->fetch_assoc()) {
    $totalKonseling++;
    if ($row['jenis_kelamin'] == 'Laki-laki') {
        $totalPria++;
    } elseif ($row['jenis_kelamin'] == 'Perempuan') {
        $totalWanita++;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History Konseling</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-10 px-4">
        <div class="bg-white shadow-md rounded p-6">
            <h2 class="text-3xl font-bold mb-6 text-center text-gray-800">History Konseling</h2>

            <!-- Form Filter dan Pencarian -->
            <form method="GET" class="flex items-center mb-4 space-x-2">
                <select name="filter" class="border border-gray-300 rounded px-3 py-2">
                    <option value="nama_siswa" <?= $filter === 'nama_siswa' ? 'selected' : '' ?>>Nama Siswa</option>
                    <option value="kelas" <?= $filter === 'kelas' ? 'selected' : '' ?>>Kelas</option>
                    <option value="jenis_kelamin" <?= $filter === 'jenis_kelamin' ? 'selected' : '' ?>>Jenis Kelamin</option>
                    <option value="tanggal" <?= $filter === 'tanggal' ? 'selected' : '' ?>>Tanggal</option>
                </select>
                <input type="text" name="search" placeholder="Cari..." value="<?= htmlspecialchars($search) ?>" class="border border-gray-300 rounded px-3 py-2 w-1/3">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">Cari</button>
            </form>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">No</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">NISN</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Nama Siswa</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Kelas</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Jenis Kelamin</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Hari</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Tanggal</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Skor</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Keterangan</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Tanggal Input</th>
                            <th class="border border-gray-300 px-4 py-3 text-center text-xs font-medium text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1; // Inisialisasi nomor urut
                        $result->data_seek(0); // Mengatur ulang pointer hasil query
                        while($row = $result->fetch_assoc()) { ?>
                        <tr class="hover:bg-gray-100">
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-800 text-center"><?php echo $no++; ?></td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-800"><?php echo $row['nisn']; ?></td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-800"><?php echo $row['nama_siswa']; ?></td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-800"><?php echo $row['kelas']; ?></td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-800"><?php echo $row['jenis_kelamin']; ?></td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-800"><?php echo $row['hari']; ?></td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-800"><?php echo $row['tanggal']; ?></td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-800"><?php echo $row['skor']; ?></td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-800"><?php echo $row['keterangan']; ?></td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-800"><?php echo $row['tanggal_input']; ?></td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-800 text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="print_konseling.php?id=<?php echo $row['id']; ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">Print</a>
                                    <a href="edit_konseling.php?id=<?php echo $row['id']; ?>" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded">Edit</a>
                                    <a href="delete_konseling.php?id=<?php echo $row['id']; ?>" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Hapus</a>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                <a href="dashboard.php?totalKonseling=<?php echo $totalKonseling; ?>&totalPria=<?php echo $totalPria; ?>&totalWanita=<?php echo $totalWanita; ?>" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Kembali</a>
            </div>
        </div>
    </div>
</body>
</html>
<?php
$conn->close();
?>
