<?php
require_once "../database/config.php";

if (isset($_POST["simpan"])) {
    $nama = $_POST["nama"];
    $kategori = $_POST["kategori"];
    $poin = $_POST["poin"];
    $query = "INSERT INTO pelanggaran (nama, id_kategori, poin) VALUES ('$nama',
                                                                        '$kategori',
                                                                        '$poin')";
    pdo_query($conn, $query);
    header("Location: ../pelanggaran");

} else if (isset($_POST["edit"])) {
    $nama = $_POST["nama"];
    $kategori = $_POST["kategori"];
    $poin = $_POST["poin"];
    $query = "UPDATE pelanggaran SET nama = '$nama', id_kategori = '$kategori', poin = '$poin' WHERE nisn = '$nisn' ";

    pdo_query($conn, $query);
    header("Location: ../pelanggaran");

} else if (isset($_POST["hapus"])) {
    $id = $_POST['id'];
    $query = "DELETE FROM pelanggaran WHERE id = '$id' ";
    pdo_query($conn, $query);
    header("Location: ../pelanggaran");
}
?>