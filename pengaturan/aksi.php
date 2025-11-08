<?php
session_start();
require_once "../database/config.php";

$row = pdo_query($conn, "SELECT logo, latar_belakang FROM tb_pengaturan")->fetch(PDO::FETCH_ASSOC);
$logo_lama = $row["logo"];
$latar_belakang_lama = $row["latar_belakang"];

if (isset($_POST["edit"])) {
    $id = $_POST["id"];
    $nama_instansi = $_POST["nama_instansi"];
    $nama_sistem = $_POST["nama_sistem"];
    $logo = $_FILES["gambarLogo"];
    $latar_belakang = $_FILES["gambarLatarBelakang"];
    $tahun = $_POST["tahun"];

    if ($logo["size"] > 5000000 || $latar_belakang["size"] > 5000000) {
        $_SESSION["flash"] = [
            "type" => "danger",
            "msg" => "File terlalu besar!",
        ];
        header("Location: ../pengaturan");
        exit;
    }

    $target_folder = "../assets/images/";

    if (isset($logo) && $logo["error"] === UPLOAD_ERR_OK) {
        $path_logo_baru = $target_folder . "logo.png";
        $path_logo_lama = $target_folder . $logo_lama;

        if (file_exists($path_logo_lama)) {
            unlink($path_logo_lama);
        }
        move_uploaded_file($logo["tmp_name"], $path_logo_baru);
    }

    if (isset($latar_belakang) && $latar_belakang["error"] === UPLOAD_ERR_OK) {
        $path_latar_belakang_baru = $target_folder . "latarbelakang.png";
        $path_latar_belakang_lama = $target_folder . $latar_belakang_lama;

        if (file_exists($path_latar_belakang_lama)) {
            unlink($path_latar_belakang_lama);
        }
        move_uploaded_file($latar_belakang["tmp_name"], $path_latar_belakang_baru);
    }

    pdo_query(
        $conn,
        "UPDATE tb_pengaturan SET nama_instansi = ?,
                                  nama_sistem = ?,
                                  logo = ?,
                                  latar_belakang = ?,
                                  tahun = ? WHERE id = ?",
        [$nama_instansi, $nama_sistem, "logo.png", "latarbelakang.png", $tahun, $id]
    );

    $_SESSION["flash"] = [
        "type" => "success",
        "msg" => "Data berhasil diedit!",
    ];
    header("Location: ../pengaturan");
}
?>
