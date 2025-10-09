<?php

use PhpOffice\PhpSpreadsheet\IOFactory;

session_start();
require_once "../database/config.php";
require_once "../vendor/autoload.php";

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

} else if (isset($_POST["import"])) {
    if (isset($_FILES["file"])) {
        global $berhasil;
        $file = $_FILES["file"]["tmp_name"];
        $spreadsheet = IOFactory::load($file);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();
        
        $berhasil = 0;

        for ($i = 1; $i < count($rows); $i++) {
            $nama = trim($rows[$i][0]);
            $kategori = trim($rows[$i][1]);
            $poin = trim($rows[$i][2]);

            if (empty($nama) || empty($kategori) || empty($poin)) {
                continue;
            }

            $query_cek = "SELECT * FROM tb_pelanggaran WHERE nama = '$nama' AND kategori = '$kategori' AND poin = '$poin' ";
            $pdo = pdo_query($conn, $query_cek);
            $exist = $pdo->fetchColumn();

            if ($exist > 0) {
                continue;
            }

            $query = "INSERT INTO tb_pelanggaran (nama, kategori, poin) VALUES ('$nama',
                                                                                '$kategori',
                                                                                '$poin')";
            pdo_query($conn, $query);
            $berhasil++;
        }
        $_SESSION["flash"] = [
            "type" => "success",
            "msg" => $berhasil . " data pelanggaran berhasil ditambahkan!"
        ];
    }
    header("Location: ../pelanggaran");
}
?>
