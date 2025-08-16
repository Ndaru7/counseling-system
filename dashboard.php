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

// Menghitung total konseling
$sqlTotalKonseling = "SELECT COUNT(*) as totalKonseling FROM konseling";
$resultTotalKonseling = $conn->query($sqlTotalKonseling);
$rowTotalKonseling = $resultTotalKonseling->fetch_assoc();
$totalKonseling = $rowTotalKonseling['totalKonseling'];

// Menghitung total pria
$sqlTotalPria = "SELECT COUNT(*) as totalPria FROM konseling WHERE jenis_kelamin = 'Laki-laki'";
$resultTotalPria = $conn->query($sqlTotalPria);
$rowTotalPria = $resultTotalPria->fetch_assoc();
$totalPria = $rowTotalPria['totalPria'];

// Menghitung total wanita
$sqlTotalWanita = "SELECT COUNT(*) as totalWanita FROM konseling WHERE jenis_kelamin = 'Perempuan'";
$resultTotalWanita = $conn->query($sqlTotalWanita);
$rowTotalWanita = $resultTotalWanita->fetch_assoc();
$totalWanita = $rowTotalWanita['totalWanita'];

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Konseling</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        .welcome-text {
            font-family: 'Arial', sans-serif;
            font-size: 2.5rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
        }
        .sub-text {
            font-family: 'Arial', sans-serif;
            font-size: 2rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }
        .stats-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
        }
        .stat-card {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            flex: 1;
            max-width: 250px;
        }
        .stat-icon {
            font-size: 4rem;
        }
        .stat-text {
            margin-top: 10px;
        }
        .back-button {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-1/5 bg-gray-800 h-screen text-white">
            <div class="p-4 text-center text-lg font-bold border-b border-gray-700">
                <span class="text-blue-500"> MBS BUMIAYU</span>
            </div>
            <ul class="mt-4">
                <li class="p-4 hover:bg-gray-700">
                    <i class="fas fa-tachometer-alt mr-2"></i>
                    <a href="dashboard.php">Dashboard</a>
                </li>
                <li class="p-4 hover:bg-gray-700">
                    <i class="fas fa-user-friends mr-2"></i>
                    <a href="konseling.php">Konseling</a>
                </li>
                <li class="p-4 hover:bg-gray-700">
                    <i class="fas fa-history mr-2"></i>
                    <a href="history.php">History Konseling</a>
                </li>
            </ul>
        </div>
        <!-- Main Content -->
        <div class="w-4/5 p-6">
            <div class="welcome-text">
                Selamat Datang Di Dashboard Konseling
            </div>
            <div class="sub-text">
                Muhammadiyah Boarding School Bumiayu
            </div>
            <div class="stats-container">
                <div class="stat-card">
                    <i class="fas fa-calendar-alt text-red-500 stat-icon"></i>
                    <div class="stat-text">
                        <p class="text-2xl font-bold"><?php echo $totalKonseling; ?></p>
                        <p>Total Konseling</p>
                    </div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-male text-teal-500 stat-icon"></i>
                    <div class="stat-text">
                        <p class="text-2xl font-bold"><?php echo $totalPria; ?></p>
                        <p>Total Siswa Pria</p>
                    </div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-female text-yellow-500 stat-icon"></i>
                    <div class="stat-text">
                        <p class="text-2xl font-bold"><?php echo $totalWanita; ?></p>
                        <p>Total Siswa Perempuan</p>
                    </div>
                </div>
            </div>
            <div class="back-button">
                <a href="index.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</body>
</html>
