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

// Mendapatkan ID data konseling
$id = $_GET['id'];

// Query untuk mendapatkan data konseling berdasarkan ID
$sql = "SELECT * FROM konseling WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Print Konseling</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }
        .data-label {
            width: 200px; /* Anda bisa menyesuaikan lebar sesuai kebutuhan */
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-10">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-3xl font-bold mb-6 text-center">Data Konseling</h2>
            <table class="min-w-full bg-white border border-gray-300">
                <tbody>
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b data-label">NISN:</th>
                        <td class="px-6 py-4 text-sm text-gray-900 border-b"><?php echo $data['nisn']; ?></td>
                    </tr>
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b data-label">Nama Siswa:</th>
                        <td class="px-6 py-4 text-sm text-gray-900 border-b"><?php echo $data['nama_siswa']; ?></td>
                    </tr>
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b data-label">Kelas:</th>
                        <td class="px-6 py-4 text-sm text-gray-900 border-b"><?php echo $data['kelas']; ?></td>
                    </tr>
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b data-label">Jenis Kelamin:</th>
                        <td class="px-6 py-4 text-sm text-gray-900 border-b"><?php echo $data['jenis_kelamin']; ?></td>
                    </tr>
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b data-label">Hari:</th>
                        <td class="px-6 py-4 text-sm text-gray-900 border-b"><?php echo $data['hari']; ?></td>
                    </tr>
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b data-label">Tanggal:</th>
                        <td class="px-6 py-4 text-sm text-gray-900 border-b"><?php echo $data['tanggal']; ?></td>
                    </tr>
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b data-label">Skor:</th>
                        <td class="px-6 py-4 text-sm text-gray-900 border-b"><?php echo $data['skor']; ?></td>
                    </tr>
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider data-label">Keterangan:</th>
                        <td class="px-6 py-4 text-sm text-gray-900"><?php echo $data['keterangan']; ?></td>
                    </tr>
                </tbody>
            </table>
            <div class="mt-6 flex justify-between no-print">
                <button onclick="window.print()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Print</button>
                <a href="dashboard.php" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Kembali</a>
            </div>
        </div>
    </div>
</body>
</html>
