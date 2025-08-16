<!DOCTYPE html>
<html>
<head>
    <title>Input Data Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-10">
        <div class="bg-white shadow-md rounded p-6">
            <h2 class="text-3xl font-bold mb-6">Input Data Siswa</h2>
            <form action="proses_input_siswa.php" method="POST">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="nisn">NISN</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nisn" name="nisn" type="text" placeholder="Masukkan NISN" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="nama_siswa">Nama Siswa</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nama_siswa" name="nama_siswa" type="text" placeholder="Masukkan Nama Siswa" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="kelas">Kelas</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="kelas" name="kelas" type="text" placeholder="Masukkan Kelas" required>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mr-2">Simpan</button>
                    <button type="reset" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Reset</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
