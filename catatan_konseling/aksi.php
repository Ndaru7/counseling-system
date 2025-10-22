<?php
session_start();
require_once "../database/config.php";
require_once "../bot.php";


if (isset($_POST["simpan"])) {
    $pelanggaran = $_POST["pelanggaran"];
    $deskripsi = $_POST["deskripsi"];
    $pencatat = $_SESSION["id"];
    $berhasil = 0;

    foreach ($_POST["siswa"] as $siswa) {
        $query_catatan = pdo_query(
            $conn,
            "INSERT INTO tb_catatan_konseling ( id_siswa,
                                                id_pelanggaran,
                                                deskripsi,
                                                pencatat ) VALUES (?, ?, ?, ?)",
            [$siswa, $pelanggaran, $deskripsi, $pencatat]
        );

        $row_poin = pdo_query(
            $conn,
            "SELECT poin FROM tb_siswa WHERE nisn = ?",
            [$siswa]
        )->fetch(PDO::FETCH_ASSOC);

        $row_pelanggaran = pdo_query(
            $conn,
            "SELECT poin FROM tb_pelanggaran WHERE id = ?",
            [$pelanggaran]
        )->fetch(PDO::FETCH_ASSOC);

        $nama_siswa = $row_poin["nama"];
        $poin_siswa = $row_poin["poin"];
        $poin_pelanggaran = $row_pelanggaran["poin"];

        $query_poin = pdo_query(
            $conn,
            "UPDATE tb_siswa SET poin = (? + ?) WHERE nisn = ?",
            [$poin_siswa, $poin_pelanggaran, $siswa]
        );
        $berhasil++;
    }
    $_SESSION["flash"] = [
        "type" => "success",
        "msg" => "$berhasil" . " " . "catatan berhasil ditambahkan!"
    ];
    header("Location: ../catatan_konseling");
}
