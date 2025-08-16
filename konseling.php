<!DOCTYPE html>
<html>
<head>
    <title>Menu Konseling</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Fungsi untuk mengambil data siswa berdasarkan NISN
        async function fetchSiswaData(nisn) {
            try {
                let response = await fetch('fetch_siswa.php?nisn=' + nisn);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                let data = await response.json();
                document.getElementById('nama_siswa').value = data.nama_siswa;
                document.getElementById('kelas').value = data.kelas;
                document.getElementById('jenis_kelamin').value = data.jenis_kelamin;
            } catch (error) {
                console.error('There has been a problem with your fetch operation:', error);
            }
        }

        // Fungsi untuk mengisi kolom hari berdasarkan tanggal yang dipilih
        function isiHari() {
            const hari = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
            const tanggal = new Date(document.getElementById('tanggal').value);
            const hariIni = hari[tanggal.getDay()];

            document.getElementById('hari').value = hariIni;
        }

        // Event listener untuk input NISN dan tanggal
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('nisn').addEventListener('input', function() {
                let nisn = this.value;
                if (nisn.length > 0) {
                    fetchSiswaData(nisn);
                } else {
                    document.getElementById('nama_siswa').value = '';
                    document.getElementById('kelas').value = '';
                    document.getElementById('jenis_kelamin').value = '';
                }
            });

            document.getElementById('tanggal').addEventListener('input', isiHari);

            // Mengisi tanggal hari ini saat halaman dimuat
            const sekarang = new Date().toISOString().split('T')[0];
            document.getElementById('tanggal').value = sekarang;
            isiHari();
        });
    </script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-10">
        <div class="bg-white shadow-md rounded p-6">
            <h2 class="text-3xl font-bold mb-6">Bimbingan Konseling</h2>
            <form id="konselingForm" action="proses_konseling.php" method="POST">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="nisn">NISN</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nisn" name="nisn" type="text" placeholder="Masukkan NISN" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="nama_siswa">Nama Siswa</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nama_siswa" name="nama_siswa" type="text" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="kelas">Kelas</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="kelas" name="kelas" type="text" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="jenis_kelamin">Jenis Kelamin</label>
                    <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="jenis_kelamin" name="jenis_kelamin" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="tanggal">Tanggal</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="tanggal" name="tanggal" type="date" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="hari">Hari</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="hari" name="hari" type="text" readonly>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="skor">Skor</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="skor" name="skor" type="number" placeholder="Masukkan Skor" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="keterangan">Keterangan</label>
                    <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="keterangan" name="keterangan" placeholder="Masukkan Keterangan" required></textarea>
                </div>
                <div class="flex justify-end">
                    <a href="dashboard.php" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">Kembali</a>
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mr-2">Simpan</button>
                    <button type="reset" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Reset</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
