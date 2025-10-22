<?php
session_start();
require_once "../database/config.php";

if (isset($_POST["edit"])) {
    $id = $_POST["id"];
    $nama = $_POST["nama"];
    $username = $_POST["username"];
    $password_baru = sha1($_POST["password_baru"]);
    pdo_query(
        $conn,
        "UPDATE tb_pengguna SET passwd = ?, nama = ?, username = ? WHERE id = ? ",
        [$password_baru, $nama, $username, $id],
    );

    $_SESSION["flash"] = [
        "type" => "success",
        "msg" => "Edit data berhasil, silahkan login ulang!",
    ];
    header("Location: ../auth/logout.php");
}
?>
