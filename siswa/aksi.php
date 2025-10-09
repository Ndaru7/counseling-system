<?php

use PhpOffice\PhpSpreadsheet\IOFactory;

session_start();
require_once "../database/config.php";
require_once "../vendor/autoload.php";


if (isset($_POST["simpan"])) {
    $nisn = $_POST["nisn"];
    $nama = $_POST["nama"];
    $jenis_kelamin = $_POST["jenis_kelamin"];
    $alamat = $_POST["alamat"];
    $orang_tua = $_POST["orang_tua"];
    $no_hp = $_POST["no_hp"];

    $query = "INSERT INTO tb_siswa (nisn,
                nama,
                jenis_kelamin,
                alamat,
                orang_tua,
                no_hp) VALUES ('$nisn',
                                        '$nama',
                                        '$jenis_kelamin',
                                        '$alamat',
                                        '$orang_tua',
                                        '$no_hp')";
    pdo_query($conn, $query);
    $_SESSION["flash"] = [
        "type" => "success",
        "msg" => "Data siswa berhasil ditambahkan!"
    ];
    header("Location: ../siswa");
} else if (isset($_POST["edit"])) {
    $nisn = $_POST["nisn"];
    $nama = $_POST["nama"];
    $jenis_kelamin = $_POST["jenis_kelamin"];
    $alamat = $_POST["alamat"];
    $orang_tua = $_POST["orang_tua"];
    $no_hp = $_POST["no_hp"];

    $query = "UPDATE tb_siswa SET nisn = '$nisn',
                                    nama = '$nama',
                                    jenis_kelamin = '$jenis_kelamin',
                                    alamat = '$alamat',
                                    orang_tua = '$orang_tua',
                                    no_hp = '$no_hp' WHERE nisn = '$nisn' ";
    pdo_query($conn, $query);
    $_SESSION["flash"] = [
        "type" => "success",
        "msg" => "Data siswa berhasil diedit!"
    ];
    header("Location: ../siswa");
} else if (isset($_POST["hapus"])) {
    $nisn = $_POST["nisn"];
    $query = "DELETE FROM tb_siswa WHERE nisn = '$nisn' ";
    pdo_query($conn, $query);
    $_SESSION["flash"] = [
        "type" => "success",
        "msg" => "Data siswa berhasil dihapus!"
    ];
    header("Location: ../siswa");
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

            $query_cek = "SELECT * FROM tb_siswa WHERE nisn = '$nisn' ";
            $pdo = pdo_query($conn, $query_cek);
            $exist = $pdo->fetchColumn();

            if ($exist > 0) {
                continue;
            }

            $query = "INSERT INTO tb_siswa VALUES ('$nisn',
                                                  '$nama',
                                                  '$jenis_kelamin',
                                                  '$poin',
                                                  '$alamat',
                                                  '$orang_tua',
                                                  '$no_hp')";
            pdo_query($conn, $query);
            $berhasil++;
        }
        $_SESSION["flash"] = [
            "type" => "success",
            "msg" => $berhasil . " data siswa berhasil ditambahkan!"
        ];
    }
    header("Location: ../siswa");
}
