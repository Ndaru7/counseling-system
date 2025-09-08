<?php
require_once "../database/config.php";


if (isset($_POST["simpan"])) {
    $nisn = $_POST["nisn"];
    $nama = $_POST["nama"];
    $jenis_kelamin = $_POST["jenis_kelamin"];
    $alamat = $_POST["alamat"];
    $orang_tua = $_POST["orang_tua"];
    $no_hp = $_POST["no_hp"];

    $query = "INSERT INTO siswa (nisn,
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
    header("Location: ../siswa");

} else if (isset($_POST["edit"])) {
    $nisn = $_POST["nisn"];
    $nama = $_POST["nama"];
    $jenis_kelamin = $_POST["jenis_kelamin"];
    $alamat = $_POST["alamat"];
    $orang_tua = $_POST["orang_tua"];
    $no_hp = $_POST["no_hp"];

    $query = "UPDATE siswa SET nisn = '$nisn',
                                    nama = '$nama',
                                    jenis_kelamin = '$jenis_kelamin',
                                    alamat = '$alamat',
                                    orang_tua = '$orang_tua',
                                    no_hp = '$no_hp' WHERE nisn = '$nisn' ";
    pdo_query($conn, $query);
    header("Location: ../siswa");

} else if (isset($_POST["hapus"])) {
    $nisn = $_POST["nisn"];
    echo $nisn;
    $query = "DELETE FROM siswa WHERE nisn = '$nisn' ";
    pdo_query($conn, $query);
    header("Location: ../siswa");
}
?>