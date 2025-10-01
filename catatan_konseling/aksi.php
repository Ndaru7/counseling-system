<?php
session_start();
require_once "../database/config.php";


if (isset($_POST["simpan"])) {
    $pelanggaran = $_POST["pelanggaran"];
    $deskripsi = $_POST["deskripsi"];
    $berhasil = 0;
    $pencatat = $_SESSION["id"];

    foreach ($_POST["siswa"] as $siswa) {
        $query_catatan = pdo_query($conn, "INSERT INTO tb_catatan_konseling (id_siswa,
                                            id_pelanggaran,
                                            deskripsi,
                                            pencatat) VALUES ('$siswa',
                                                                '$pelanggaran',
                                                                '$deskripsi',
                                                                '$pencatat')");
        $query_poin = "SELECT poin FROM tb_siswa WHERE nisn = '$siswa' ";
        $query_pelanggaran = "SELECT poin FROM tb_pelanggaran WHERE id = '$pelanggaran' ";
        $row_poin = pdo_query($conn, $query_poin)->fetch(PDO::FETCH_ASSOC);
        $row_pelanggaran = pdo_query($conn, $query_pelanggaran)->fetch(PDO::FETCH_ASSOC);
        $poin_siswa = $row_poin["poin"];
        $poin_pelanggaran = $row_pelanggaran["poin"];
        $query_poin = pdo_query($conn, "UPDATE tb_siswa SET poin = ('$poin_siswa' + '$poin_pelanggaran') WHERE nisn = '$siswa' ");
        $berhasil++;
    }
    $_SESSION["flash"] = [
        "type" => "success",
        "msg" => "$berhasil" . " " . "catatan berhasil ditambahkan!"
    ];
    header("Location: ../catatan_konseling");
}
