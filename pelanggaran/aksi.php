<?php
session_start();
require_once "../database/config.php";

if (isset($_POST["simpan"])) {
    $nama = $_POST["nama"];
    $kategori = $_POST["kategori"];
    $poin = $_POST["poin"];
    $query = "INSERT INTO tb_pelanggaran (nama, kategori, poin) VALUES ('$nama',
                                                                        '$kategori',
                                                                        '$poin')";
    pdo_query($conn, $query);
    $_SESSION["flash"] = [
        "type" => "success",
        "msg" => "Data berhasil disimpan!"
    ];
    header("Location: ../pelanggaran");

} else if (isset($_POST["edit"])) {
    $id = $_POST["id"];
    $nama = $_POST["nama"];
    $kategori = $_POST["kategori"];
    $poin = $_POST["poin"];
    $query = "UPDATE tb_pelanggaran SET nama = '$nama', kategori = '$kategori', poin = '$poin' WHERE id = '$id' ";

    pdo_query($conn, $query);
    $_SESSION["flash"] = [
        "type" => "success",
        "msg" => "Data berhasil diedit!"
    ];
    header("Location: ../pelanggaran");

} else if (isset($_POST["hapus"])) {
    $id = $_POST['id'];
    $query = "DELETE FROM tb_pelanggaran WHERE id = '$id' ";
    pdo_query($conn, $query);
    $_SESSION["flash"] = [
        "type" => "success",
        "msg" => "Data berhasil dihapus!"
    ];
    header("Location: ../pelanggaran");
}
?>
