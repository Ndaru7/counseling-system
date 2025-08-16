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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Mencari pengguna di database
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Memverifikasi password
        if (password_verify($password, $user['password'])) {
            // Set session dan arahkan ke dashboard
            $_SESSION['username'] = $user['username'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error_message = "Password salah!";
        }
    } else {
        $error_message = "Username tidak ditemukan! Silakan registrasi terlebih dahulu.";
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="w-full max-w-xs">
        <div class="flex justify-center mb-6">
            <img src="images/logo.png"alt="logo" class="w-32 h-32" height="150" src="https://storage.googleapis.com/a1aa/image/msFITzq2zU4CJNNJ8lbXHN1DKfNedijtrf0YiGtZukK7Ne1OB.jpg" width="150"/>
        </div>
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <h2 class="text-center text-gray-700 text-xl font-bold mb-4">Halaman Login</h2>

            <?php if (isset($error_message)): ?>
                <div class="bg-red-500 text-white p-2 rounded mb-4 text-center">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                        <i class="fas fa-user"></i> Username
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" name="username" type="text" required />
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        <i class="fas fa-lock"></i> Password
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" name="password" type="password" required />
                </div>
                <div class="flex items-center justify-center">
                    <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                        Login
                    </button>
                </div>
            </form>
            <div class="mt-4 text-center">
                <p class="text-gray-600">Belum punya akun? <a href="registrasi.php" class="text-blue-500 hover:underline">Registrasi di sini</a></p>
            </div>
        </div>
        <p class="text-center text-gray-500 text-xs">
            2024 © ARDA PRIAMBADA
            <br/>
            PONDOK PESANTREN MBS BUMIAYU
        </p>
    </div>
</body>
</html>
