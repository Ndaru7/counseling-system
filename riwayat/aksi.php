<?php
require_once "../database/config.php";


if(isset($_POST["edit"])) {
    $id = $_POST["id"];
    $siswa = $_POST["siswa"];
    $pelanggaran = $_POST["pelanggaran"];
    $deskripsi = $_POST["deskripsi"];

    $query = "UPDATE catatan_konseling SET id_siswa = '$siswa',
                                            id_pelanggaran = '$pelanggaran',
                                            deskripsi = '$deskripsi' WHERE id = '$id' ";
    pdo_query($conn, $query);
    header("Location: ../riwayat");

} else if(isset($_POST["hapus"])) {
    $id = $_POST["id"];
    $query = "DELETE FROM catatan_konseling WHERE id = '$id' ";
    pdo_query($conn, $query);
    header("Location: ../riwayat");
}
?>