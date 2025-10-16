<?php
session_start();
require_once "../database/config.php";
require_once "../bot.php";


if(isset($_POST["edit"])) {
    $id = $_POST["id"];
    $siswa = $_POST["siswa"];
    $pelanggaran = $_POST["pelanggaran"];
    $deskripsi = $_POST["deskripsi"];

    $query = "UPDATE tb_catatan_konseling SET id_siswa = '$siswa',
                                            id_pelanggaran = '$pelanggaran',
                                            deskripsi = '$deskripsi' WHERE id = '$id' ";
    pdo_query($conn, $query);
    header("Location: ../riwayat");

} else if(isset($_POST["hapus"])) {
    $id = $_POST["id"];
    $query = "DELETE FROM tb_catatan_konseling WHERE id = '$id' ";
    pdo_query($conn, $query);
    header("Location: ../riwayat");

} else if(isset($_POST["notifikasi"])) {
    $id_siswa = $_POST["siswa"];
    $id_pelanggaran = $_POST["pelanggaran"];
    $id_catatan = $_POST["id"];

    $query_siswa = "SELECT nisn, nama, no_hp FROM tb_siswa WHERE nisn = '$id_siswa' ";
    $query_pelanggaran = "SELECT kategori FROM tb_pelanggaran WHERE id = '$id_pelanggaran' ";
    $query_catatan = "SELECT tanggal, deskripsi FROM tb_catatan_konseling WHERE id = '$id_catatan' ";

    $pdo_siswa = pdo_query($conn, $query_siswa);
    $pdo_pelanggaran = pdo_query($conn, $query_pelanggaran);
    $pdo_catatan = pdo_query($conn, $query_catatan);

    $row_siswa = $pdo_siswa->fetch(PDO::FETCH_ASSOC);
    $row_pelanggaran = $pdo_pelanggaran->fetch(PDO::FETCH_ASSOC);
    $row_catatan = $pdo_catatan->fetch(PDO::FETCH_ASSOC);

    $nisn = $row_siswa["nisn"];
    $nama_siswa = $row_siswa["nama"];
    $no_hp = $row_siswa["no_hp"];
    $kategori = $row_pelanggaran["kategori"];
    $tanggal = $row_catatan["tanggal"];
    $deskripsi = $row_catatan["deskripsi"];
    $pencatat = $_SESSION["nama"];

    $pesan = pesanKonseling($nisn, $nama_siswa, $tanggal, $kategori, $deskripsi, $pencatat);
    kirimPesan($no_hp, $pesan);

    $_SESSION["flash"] = [
        "type" => "success",
        "msg" => "Notifikasi terkirim!"
    ];

    header("Location: ../riwayat");
}
?>
