<?php

use PhpOffice\PhpSpreadsheet\IOFactory;

session_start();
require_once "../database/config.php";
require_once "../vendor/autoload.php";

if (isset($_POST["simpan"])) {
    $nama = $_POST["nama"];
    $kategori = $_POST["kategori"];
    $poin = $_POST["poin"];

    pdo_query(
        $conn,
        "INSERT INTO tb_pelanggaran (nama, kategori, poin) VALUES (?, ?, ?)",
        [$nama, $kategori, $poin]
    );

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

    pdo_query(
        $conn,
        "UPDATE tb_pelanggaran SET nama = ? kategori = ?, poin = ? WHERE id = ?",
        [$nama, $kategori, $poin, $id]
    );

    $_SESSION["flash"] = [
        "type" => "success",
        "msg" => "Data berhasil diedit!"
    ];

    header("Location: ../pelanggaran");

} else if (isset($_POST["hapus"])) {
    $id = $_POST['id'];

    pdo_query(
        $conn,
        "DELETE FROM tb_pelanggaran WHERE id = ?",
        [$id]
    );

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

            $query_cek = pdo_query(
                $conn,
                "SELECT * FROM tb_pelanggaran WHERE nama = ? AND kategori = ? AND poin = ?",
                [$nama, $kategori, $poin]
            );
            $exist = $query_cek->fetchColumn();

            if ($exist > 0) {
                continue;
            }

            pdo_query(
                $conn,
                "INSERT INTO tb_pelanggaran (nama, kategori, poin) VALUES (?, ?, ?)",
                [$nama, $kategori, $poin]
            );
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
