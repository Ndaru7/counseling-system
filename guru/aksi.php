<?php

use PhpOffice\PhpSpreadsheet\IOFactory;

session_start();
require_once "../database/config.php";
require_once "../vendor/autoload.php";


if (isset($_POST["simpan"])) {
    $nama = $_POST["nama"];
    $username = $_POST["username"];
    $password = sha1($_POST["password"]);
    $no_hp = $_POST["no_hp"];

    pdo_query(
        $conn,
        "INSERT INTO tb_pengguna ( nama,
                                   username,
                                   passwd,
                                   peran,
                                   no_hp ) VALUES (?, ?, ?, ?, ?)",
        [$nama, $username, $password, 1, $no_hp]
    );

    $_SESSION["flash"] = [
        "type" => "success",
        "msg" => "Akun guru berhasil dibuat!"
    ];

    header("Location: ../guru");

} else if (isset($_POST["edit"])) {
    $nisn = $_POST["nisn"];
    $nama = $_POST["nama"];
    $jenis_kelamin = $_POST["jenis_kelamin"];
    $poin = $_POST["poin"];
    $alamat = $_POST["alamat"];
    $orang_tua = $_POST["orang_tua"];
    $no_hp = $_POST["no_hp"];

    pdo_query(
        $conn,
        "UPDATE tb_siswa SET nama = ?,
                             jenis_kelamin = ?,
                             alamat = ?,
                             poin = ?,
                             orang_tua = ?,
                             no_hp = ? WHERE nisn = ?",
        [$nama, $jenis_kelamin, $alamat, $poin, $orang_tua, $no_hp, $nisn]
    );

    $_SESSION["flash"] = [
        "type" => "success",
        "msg" => "Data siswa berhasil diedit!"
    ];

    header("Location: ../siswa");

} else if (isset($_POST["hapus"])) {
    $id = $_POST["id"];

    pdo_query(
        $conn,
        "DELETE FROM tb_pengguna WHERE id = ?",
        [$id]
    );

    $_SESSION["flash"] = [
        "type" => "success",
        "msg" => "Akun berhasil dihapus!"
    ];

    header("Location: ../guru");

} else if (isset($_POST["import"])) {
    if (isset($_FILES["file"])) {
        global $berhasil;
        $file = $_FILES["file"]["tmp_name"];
        $spreadsheet = IOFactory::load($file);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        $berhasil = 0;

        for ($i = 1; $i < count($rows); $i++) {
            $nisn = trim($rows[$i][0]);
            $nama = trim($rows[$i][1]);
            $jenis_kelamin = trim($rows[$i][2]);
            $poin = trim($rows[$i][3]);
            $alamat = trim($rows[$i][4]);
            $orang_tua = trim($rows[$i][5]);
            $no_hp = trim($rows[$i][6]);

            if (empty($nisn)) {
                continue;
            }

            $query_cek = pdo_query(
                            $conn,
                            "SELECT * FROM tb_siswa WHERE nisn = ?",
                            [$nisn]
                         );
            $exist = $query_cek->fetchColumn();

            if ($exist > 0) {
                continue;
            }

            pdo_query(
                $conn,
                "INSERT INTO tb_siswa VALUES (?, ?, ?, ?, ?, ?, ?)",
                [$nisn, $nama, $jenis_kelamin, $poin, $alamat, $orang_tua, $no_hp]
            );
            $berhasil++;
        }

        $_SESSION["flash"] = [
            "type" => "success",
            "msg" => $berhasil . " data siswa berhasil ditambahkan!"
        ];
    }

    header("Location: ../siswa");
}
