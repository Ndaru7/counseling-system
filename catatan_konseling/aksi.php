<?php
require_once "../database/config.php";


if (isset($_POST["simpan"])) {
    $siswa = $_POST["siswa"];
    $pelanggaran = $_POST["pelanggaran"];
    $deskripsi = $_POST["deskripsi"];
    $query_catatan = pdo_query($conn, "INSERT INTO catatan_konseling (id_siswa,
                                            id_pelanggaran,
                                            deskripsi) VALUES ('$siswa',
                                                                '$pelanggaran',
                                                                '$deskripsi')");
    $query_poin = "SELECT poin FROM siswa WHERE nisn = '$siswa' ";
    $query_pelanggaran = "SELECT poin FROM pelanggaran WHERE id = '$pelanggaran' ";
    $row_poin = pdo_query($conn, $query_poin)->fetch(PDO::FETCH_ASSOC);
    $row_pelanggaran = pdo_query($conn, $query_pelanggaran)->fetch(PDO::FETCH_ASSOC);
    $poin_siswa = $row_poin["poin"];
    $poin_pelanggaran = $row_pelanggaran["poin"];
    $query_poin = pdo_query($conn, "UPDATE siswa SET poin = ('$poin_siswa' + '$poin_pelanggaran') WHERE nisn = '$siswa' ");
    header("Location: ../catatan_konseling");

} else if (isset($_POST["simpan-banyak"])) {
    $pelanggaran = $_POST["pelanggaran"];
    $deskripsi = $_POST["deskripsi"];

    foreach ($_POST["siswa"] as $siswa) {
        $query_catatan = pdo_query($conn, "INSERT INTO catatan_konseling (id_siswa,
                                            id_pelanggaran,
                                            deskripsi) VALUES ('$siswa',
                                                                '$pelanggaran',
                                                                '$deskripsi')");
        $query_poin = "SELECT poin FROM siswa WHERE nisn = '$siswa' ";
        $query_pelanggaran = "SELECT poin FROM pelanggaran WHERE id = '$pelanggaran' ";
        $row_poin = pdo_query($conn, $query_poin)->fetch(PDO::FETCH_ASSOC);
        $row_pelanggaran = pdo_query($conn, $query_pelanggaran)->fetch(PDO::FETCH_ASSOC);
        $poin_siswa = $row_poin["poin"];
        $poin_pelanggaran = $row_pelanggaran["poin"];
        $query_poin = pdo_query($conn, "UPDATE siswa SET poin = ('$poin_siswa' + '$poin_pelanggaran') WHERE nisn = '$siswa' ");
    }
    header("Location: ../catatan_konseling");
}
