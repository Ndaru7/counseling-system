<?php
require_once "../database/config.php";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["nisn"])) {
    $nisn = $_POST["nisn"];
    // $query_siswa = "SELECT * FROM tb_siswa WHERE nisn = '$nisn' ";
    $pdo_siswa = pdo_query(
        $conn,
        "SELECT * FROM tb_siswa WHERE nisn = '$nisn' ",
    );
    $row_siswa = $pdo_siswa->fetch(PDO::FETCH_ASSOC);
    if (!$row_siswa) {
        echo json_encode([
            "status" => "error",
            "message" => "NISN tidak ditemukan",
        ]);
        exit();
    }

    $query_catatan = "SELECT tb_catatan_konseling.id AS id,
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

    $pdo_catatan = pdo_query($conn, $query_catatan);
    $row_catatan = $pdo_catatan->fetchAll(PDO::FETCH_ASSOC);

    if (empty($row_catatan)) {
        echo json_encode([
            "status" => "success",
            "message" => "Siswa belum memiliki catatan konseling",
            "data_siswa" => $row_siswa,
            "data_catatan" => [],
            "has_records" => false,
        ]);
        exit();
    }

    echo json_encode([
        "status" => "success",
        "message" => "Data berhasil ditemukan",
        "data_siswa" => $row_siswa,
        "data_catatan" => $row_catatan,
        "has_records" => true,
    ]);
    exit();
}
