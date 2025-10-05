<?php
require_once "../database/config.php";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["nisn"])) {
    $nisn = $_POST["nisn"];
    $query_siswa = "SELECT tb_catatan_konseling.id AS id,
                            tb_catatan_konseling.tanggal AS tanggal,
                            tb_siswa.nisn AS id_siswa,
                            tb_siswa.nama AS siswa,
                            tb_siswa.poin AS poin,
                            tb_siswa.alamat AS alamat,
                            tb_siswa.orang_tua AS orang_tua,
                            tb_siswa.no_hp AS no_hp,
                            tb_pelanggaran.id AS id_pelanggaran,
                            tb_pelanggaran.nama AS pelanggaran,
                            tb_pelanggaran.kategori AS kategori,
                            tb_pelanggaran.poin AS poin_pelanggaran,
                            tb_catatan_konseling.deskripsi AS deskripsi
                            FROM tb_catatan_konseling JOIN tb_siswa ON tb_catatan_konseling.id_siswa = tb_siswa.nisn JOIN tb_pelanggaran ON tb_catatan_konseling.id_pelanggaran = tb_pelanggaran.id WHERE tb_siswa.nisn = '$nisn' ORDER BY tb_catatan_konseling.tanggal DESC";

    $pdo = pdo_query($conn, $query_siswa);

    if($row = $pdo->fetchAll(PDO::FETCH_ASSOC)) {
        echo json_encode([
            "status" => "success",
            "message" => "Data berhasil ditemukan",
            "data" => $row
        ]);
    }
    
}
?>
