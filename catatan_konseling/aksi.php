<?php
session_start();
require_once "../database/config.php";
require_once "../bot.php";


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
        $query_poin = "SELECT nama, no_hp, poin FROM tb_siswa WHERE nisn = '$siswa' ";
        $query_pelanggaran = "SELECT kategori, poin FROM tb_pelanggaran WHERE id = '$pelanggaran' ";
        $row_poin = pdo_query($conn, $query_poin)->fetch(PDO::FETCH_ASSOC);
        $row_pelanggaran = pdo_query($conn, $query_pelanggaran)->fetch(PDO::FETCH_ASSOC);
        $nama_siswa = $row_poin["nama"];
        $poin_siswa = $row_poin["poin"];
        $no_hp_ortu = $row_poin["no_hp"];
        $poin_pelanggaran = $row_pelanggaran["poin"];
        $kategori_pelanggaran = $row_pelanggaran["kategori"];
        $pencatat_pesan = $_SESSION["nama"];
        $query_poin = pdo_query($conn, "UPDATE tb_siswa SET poin = ('$poin_siswa' + '$poin_pelanggaran') WHERE nisn = '$siswa' ");
        $berhasil++;

        //Kirim notifikasi ke orang tua
        $pesan = pesanKonseling($siswa, $nama_siswa, date("Y-m-d H:i:s"), $kategori_pelanggaran, $deskripsi, $pencatat_pesan);
        kirimPesan($no_hp_ortu, $pesan);
        
    }
    $_SESSION["flash"] = [
        "type" => "success",
        "msg" => "$berhasil" . " " . "catatan berhasil ditambahkan!"
    ];
    header("Location: ../catatan_konseling");
}
