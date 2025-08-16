<?php
session_start();
// Koneksi ke database
$servername = "localhost"; // Ganti dengan server database Anda jika perlu
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$dbname = "db_mbskonseling"; // Ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$error_message = ""; // Untuk menyimpan pesan kesalahan

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email']; // Menambahkan field email
    $password = $_POST['password'];
    
    // Memeriksa apakah password konfirmasi ada
    if (isset($_POST['confirm_password'])) {
        $confirm_password = $_POST['confirm_password'];
        
        // Memeriksa apakah password cocok
        if ($password !== $confirm_password) {
            $error_message = "Password tidak cocok!";
        } else {
            // Memeriksa apakah email sudah terdaftar
            $check_email_sql = "SELECT * FROM users WHERE email = ?";
            $stmt = $conn->prepare($check_email_sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $error_message = "Email sudah terdaftar. Silakan gunakan email lain.";
            } else {
                // Hash password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Menyimpan data pengguna ke database
                $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss", $username, $email, $hashed_password);
                
                if ($stmt->execute()) {
                    // Jika berhasil, redirect ke halaman login dengan pesan sukses
                    header("Location: login.php?success=1");
                    exit();
                } else {
                    $error_message = "Terjadi kesalahan saat registrasi. Silakan coba lagi.";
                }
            }
            $stmt->close();
        }
    } else {
        $error_message = "Konfirmasi password harus diisi!";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registrasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="w-full max-w-xs">
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <h2 class="text-center text-gray-700 text-xl font-bold mb-4">Halaman Registrasi</h2>
            
            <?php if (!empty($error_message)): ?>
                <div class="bg-red-500 text-white p-2 rounded mb-4 text-center">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            
            <form action="" method="POST">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="username">Username</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" name="username" type="text" required />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" name="email" type="email" required />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password" name="password" type="password" required />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="confirm_password">Konfirmasi Password</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="confirm_password" name="confirm_password" type="password" required />
                </div>
                <div class="flex items-center justify-center">
                    <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                        Registrasi
                    </button>
                </div>
            </form>
            <div class="mt-4 text-center">
                <p class="text-gray-600">Sudah punya akun? <a href="login.php" class="text-blue-500 hover:underline">Login di sini</a></p>
            </div>
        </div>
    </div>
</body>
</html>
