<?php

use PhpOffice\PhpSpreadsheet\IOFactory;

session_start();
require_once "../database/config.php";
require_once "../vendor/autoload.php";


if (isset($_POST["simpan"])) {
    $nisn = $_POST["nisn"];
    $nama = $_POST["nama"];
    $kelas = $_POST["kelas"];
    $jenis_kelamin = $_POST["jenis_kelamin"];
    $no_hp = $_POST["no_hp"];
    $email = $_POST["email"];

    // Cek apakah NISN sudah ada
    $query_cek = pdo_query(
        $conn,
        "SELECT nisn FROM tb_siswa WHERE nisn = ?",
        [$nisn]
    )->fetch(PDO::FETCH_ASSOC);

    if ($query_cek > 0) {
        $_SESSION["flash"] = [
            "type" => "danger",
            "msg" => "NISN sudah ada!"
        ];
        header("Location: ../siswa");
        exit;
    }

    pdo_query(
        $conn,
        "INSERT INTO tb_siswa VALUES (?, ?, ?, ?, ?, ?, ?)",
        [$nisn, $nama, $kelas, $jenis_kelamin, 0, $no_hp, $email]
    );

    // Membuat akun siswa
    $username = $nisn;
    $password = sha1($nisn);

    pdo_query(
        $conn,
        "INSERT INTO tb_pengguna ( nama,
                                   username,
                                   passwd,
                                   peran ) VALUES (?, ?, ?, ?)",
        [$nama, $username, $password, 2]
    );

    $_SESSION["flash"] = [
        "type" => "success",
        "msg" => "Data siswa berhasil ditambahkan!"
    ];

    header("Location: ../siswa");

} else if (isset($_POST["edit"])) {
    $nisn = $_POST["nisn"];
    $nama = $_POST["nama"];
    $kelas = $_POST["kelas"];
    $jenis_kelamin = $_POST["jenis_kelamin"];
    $poin = $_POST["poin"];
    $no_hp = $_POST["no_hp"];
    $email = $_POST["email"];

    pdo_query(
        $conn,
        "UPDATE tb_siswa SET nama = ?,
                             kelas = ?,
                             jenis_kelamin = ?,
                             poin = ?,
                             no_hp = ?,
                             email = ? WHERE nisn = ?",
        [$nama, $kelas, $jenis_kelamin, $poin, $no_hp, $email, $nisn]
    );

    $_SESSION["flash"] = [
        "type" => "success",
        "msg" => "Data siswa berhasil diedit!"
    ];

    header("Location: ../siswa");

} else if (isset($_POST["hapus"])) {
    $nisn = $_POST["nisn"];

    pdo_query(
        $conn,
        "DELETE FROM tb_siswa WHERE nisn = ?",
        [$nisn]
    );

    $_SESSION["flash"] = [
        "type" => "success",
        "msg" => "Data siswa berhasil dihapus!"
    ];

    header("Location: ../siswa");

} else if (isset($_POST["import"])) {
    if (isset($_FILES["file"])) {
        //global $berhasil;
        $file = $_FILES["file"]["tmp_name"];
        $spreadsheet = IOFactory::load($file);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        $berhasil = 0;

        for ($i = 1; $i < count($rows); $i++) {
            $nisn = trim($rows[$i][0]);
            $nama = trim($rows[$i][1]);
            $kelas = trim($rows[$i][2]);
            $jenis_kelamin = trim($rows[$i][3]);
            $poin = trim($rows[$i][4]);
            $no_hp = trim($rows[$i][5]);
            $email = trim($rows[$i][6]);

            if (empty($nisn)) {
                continue;
            }

            $query_cek = pdo_query(
                $conn,
                "SELECT nisn FROM tb_siswa WHERE nisn = ?",
                [$nisn]
            );
            $exist = $query_cek->fetchColumn();

            if ($exist > 0) {
                continue;
            }

            pdo_query(
                $conn,
                "INSERT INTO tb_siswa VALUES (?, ?, ?, ?, ?, ?, ?)",
                [$nisn, $nama, $kelas, $jenis_kelamin, $poin, $no_hp, $email]
            );

            $username = $nisn;
            $password = sha1($nisn);

            // Membuat akun siswa
            pdo_query(
                $conn,
                "INSERT INTO tb_pengguna ( nama,
                                           username,
                                           passwd,
                                           peran ) VALUES (?, ?, ?, ?)",
                [$nama, $username, $password, 2]
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
