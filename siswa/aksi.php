<?php
session_start();
require_once "../database/config.php";


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
}
?>