<?php
session_start();
require_once "../database/config.php";

if (isset($_POST["edit"])) {
    $id = $_POST["id"];
    $nama = $_POST["nama"];
    $username = $_POST["username"];
    $password_baru = sha1($_POST["password_baru"]);

    $sql = "UPDATE tb_pengguna SET passwd = '$password_baru', nama = '$nama', username = '$username' WHERE id = '$id' ";
    pdo_query($conn, $sql);

    $_SESSION["flash"] = [
        "type" => "success",
        "msg" => "Edit data berhasil, silahkan login ulang!"
    ];
    header("Location: ../auth/logout.php");
}
?>
