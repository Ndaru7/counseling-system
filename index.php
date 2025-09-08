<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index Page</title>
    <style>
        /* CSS untuk menambahkan gambar latar belakang */
        body {
            background-image: url('assets/images/mbs.jpg');
            /* Sesuaikan dengan lokasi gambar Anda */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            /* Background tetap saat di-scroll */
            image-rendering: auto;
        }
    </style>
</head>

<body class="bg-gray-100">
    <!-- Header dengan Logo dan Teks -->
    <header class="flex items-center justify-start p-4 bg-black bg-opacity-50">
        <img src="assets/images/logo.png" alt="Logo" class="h-20 w-20 mr-4"> <!-- Sesuaikan ukuran logo di sini -->
        <div class="text-white">
            <h1 class="text-2xl font-bold">PONDOK PESANTREN MODERN</h1>
            <h2 class="text-xl">MUHAMMADIYAH BOARDING SCHOOL BUMIAYU</h2>
        </div>
    </header>

    <!-- Teks Selamat Datang di atas Konten Utama -->
    <div class="text-center text-white mb-1">
        <h3 class="text-4xl font-bold mb-2">Selamat Datang di Sistem Bimbingan Konseling</h3>
        <h1 class="text-4xl font-bold mb-2">معهد محمدية الاسلامى بومى ايو</h1>
        <h2 class="text-3xl font-bold mb-2">PONDOK PESANTREN MODERN</h2>
        <h3 class="text-3xl font-bold mb-4">MUHAMMADIYAH BOARDING SCHOOL BUMIAYU</h3>
    </div>

    <!-- Konten Tengah -->
    <div class="flex items-center justify-center h-screen">
        <div class="bg-black bg-opacity-50 p-8 rounded-lg shadow-lg w-full max-w-md text-center">
            <!-- Tulisan di atas tombol Login dan Registrasi -->
            <p class="mt-2 mb-2 text-white text-3xl">Silakan login atau registrasi untuk melanjutkan</p> <!-- Ukuran teks diperbesar -->
            
            <!-- Tombol Login -->
            <a href="login.php" class="block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
                Login
            </a>
        </div>
    </div>
</body>
</html>
