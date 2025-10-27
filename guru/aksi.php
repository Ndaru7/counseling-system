<?php

use PhpOffice\PhpSpreadsheet\IOFactory;

session_start();
require_once "../database/config.php";
require_once "../vendor/autoload.php";


if (isset($_POST["simpan"])) {
    $nuptk = $_POST["nuptk"];
    $nama = $_POST["nama"];
    $no_hp = $_POST["no_hp"];
    $email = $_POST["email"];

    // Cek apakah NUPTK sudah ada
    $query_cek = pdo_query(
        $conn,
        "SELECT nuptk FROM tb_guru WHERE nuptk = ?",
        [$nuptk]
    )->fetch(PDO::FETCH_ASSOC);

    if ($query_cek > 0) {
        $_SESSION["flash"] = [
            "type" => "danger",
            "msg" => "NUPTK sudah ada!"
        ];
        header("Location: ../guru");
        exit;
    }

    pdo_query(
        $conn,
        "INSERT INTO tb_guru VALUES (?, ?, ?, ?)",
        [$nuptk, $nama, $no_hp, $email]
    );

    //Membuat akun guru
    $username = $nuptk;
    $password = sha1($nuptk);

    pdo_query(
        $conn,
        "INSERT INTO tb_pengguna ( nama,
                                   username,
                                   passwd,
                                   peran ) VALUES (?, ?, ?, ?)",
        [$nama, $username, $password, 1]
    );

    $_SESSION["flash"] = [
        "type" => "success",
        "msg" => "Data berhasil ditambahkan!"
    ];

    header("Location: ../guru");

} else if (isset($_POST["edit"])) {
    $nuptk = $_POST["nuptk"];
    $nama = $_POST["nama"];
    $no_hp = $_POST["no_hp"];
    $email = $_POST["email"];

    pdo_query(
        $conn,
        "UPDATE tb_guru SET nama = ?,
                            no_hp = ?,
                            email = ? WHERE nuptk = ?",
        [$nama, $no_hp, $email, $nuptk]
    );

    $_SESSION["flash"] = [
        "type" => "success",
        "msg" => "Data guru berhasil diedit!"
    ];

    header("Location: ../guru");

} else if (isset($_POST["hapus"])) {
    $nuptk = $_POST["nuptk"];

    pdo_query(
        $conn,
        "DELETE FROM tb_guru WHERE nuptk = ?",
        [$nuptk]
    );

    $_SESSION["flash"] = [
        "type" => "success",
        "msg" => "Data berhasil dihapus!"
    ];

    header("Location: ../guru");

} else if (isset($_POST["import"])) {
    if (isset($_FILES["file"])) {
        //global $berhasil;
        $file = $_FILES["file"]["tmp_name"];
        $spreadsheet = IOFactory::load($file);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        $berhasil = 0;

        for ($i = 1; $i < count($rows); $i++) {
            $nuptk = trim($rows[$i][0]);
            $nama = trim($rows[$i][1]);
            $no_hp = trim($rows[$i][2]);
            $email = trim($rows[$i][3]);

            if (empty($nuptk)) {
                continue;
            }

            $query_cek = pdo_query(
                            $conn,
                            "SELECT nuptk FROM tb_guru WHERE nuptk = ?",
                            [$nuptk]
                         );
            $exist = $query_cek->fetchColumn();

            if ($exist > 0) {
                continue;
            }

            pdo_query(
                $conn,
                "INSERT INTO tb_guru VALUES (?, ?, ?, ?)",
                [$nuptk, $nama, $no_hp, $email]
            );

            // Membuat akun guru bk
            $username = $nuptk;
            $password = sha1($nuptk);

            pdo_query(
                $conn,
                "INSERT INTO tb_pengguna ( nama,
                                           username,
                                           passwd,
                                           peran ) VALUES (?, ?, ?, ?)",
                [$nama, $username, $password, 1]
            );
            $berhasil++;
        }

        $_SESSION["flash"] = [
            "type" => "success",
            "msg" => $berhasil . " data guru berhasil ditambahkan!"
        ];
    }

    header("Location: ../guru");
}
