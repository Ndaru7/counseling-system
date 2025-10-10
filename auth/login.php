<?php
session_start();

require "../database/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM tb_pengguna WHERE username = '$username'";
    $pdo = pdo_query($conn, $sql);
    $user = $pdo->fetch(PDO::FETCH_ASSOC);

    if ($user && sha1($password) == $user["passwd"]) {
        $_SESSION["id"] = $user["id"];
        $_SESSION["nama"] = $user["nama"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["password"] = $user["passwd"];
        $_SESSION["flash"] = [
            "type" => "success",
            "msg" => "Login Berhasil!"
        ];
        header("Location: ../pengguna/dashboard.php");
        exit;
    } else {
        $_SESSION["flash"] = [
            "type" => "danger",
            "msg" => "Username atau Password salah!"
        ];
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem BK | Login Page</title>

    <!-- style area -->
    <?php include "../style.php" ?>
    <!-- end style area -->
</head>

<body class="hold-transition login-page">
    <!-- alert message -->
    <?php include "../pesan.php" ?>
    <!-- end alert message-->

    <!-- login box -->
    <div class="login-box">
        <!-- card -->
        <div class="card card-outline card-success">
            <div class="card-header text-center">
                <h3>Sistem BK MBS</h3>
            </div>
            <div class="card-body">
            <div class="d-flex justify-content-center">
                <img class="img-circle" src="../assets/images/logo.png" height="150x" width="150x" alt="Logo MBS">
            </div> <br>
                <form action="" method="post">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="username" placeholder="Username" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block toastrDefaultSuccess">Masuk</button>
                </form>

                <!--<p class="mb-1">
                    <a href="#">Lupa password</a>
                </p>-->
            </div>
        </div>
        <!-- end card -->
    </div>
    <!-- end login box-->

    <!-- javascript area -->
    <?php include "../script.php" ?>
    <!-- end javascript area -->

</body>

</html>
