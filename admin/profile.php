<?php
session_start();
require_once "../database/config.php";

if (!isset($_SESSION["username"])) {
    header("Location: ../auth/login.php");
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sitem BK | Dashboard</title>

    <?php include "../style.php"; ?>
</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-user"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <div class="dropdown-divider"></div>
                        <a href="../admin/profile.php" class="dropdown-item">
                            <i class="fas fa-user mr-2"></i>Profil
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="../auth/logout.php" class="dropdown-item">
                            <i class="fas fa-sign-out-alt mr-2"></i>Keluar
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="" class="brand-link">
                <img src="../assets/images/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Sistem BK</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- SidebarSearch Form -->
                <div class="form-inline mt-2">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <?php include "../sidebar.php"; ?>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <!-- Default box -->
                <div class="container-fluid">
                    <br>
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-user"></i>  Profil</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="" method="post">
                            <div class="card-body">
                                <div class="form-group">
                                    <input type="hidden" name="id" class="form-control" value="<?php echo $_SESSION['id']; ?>" id="exampleInputEmail1">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nama</label>
                                    <input type="text" name="name" class="form-control" value="<?php echo $_SESSION['name']; ?>" id="exampleInputEmail1" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Username</label>
                                    <input type="text" name="username" class="form-control" value="<?php echo $_SESSION['username']; ?>" id="exampleInputEmail1" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password Baru</label>
                                    <input type="password" name="new-password" class="form-control" id="exampleInputPassword1" required>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" name="update" class="btn btn-warning btn-block"><i class="fas fa-pen"></i>  Update</button>
                            </div>
                        </form>
                    </div>

                    <!-- /.row -->
                </div><!-- /.container-fluid -->
                <!-- /.card -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <strong>Copyright &copy; 2025 <a href="">MBS Bumiayu</a>.</strong> All rights reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <?php include "../script.php"; ?>

</body>

</html>

<?php 
if (isset($_POST["update"])) {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $username = $_POST["username"];
    $new_password = $_POST["password"];

    $sql = "UPDATE admin SET passwd = '$new_password', name = '$name', username = '$username' WHERE id = '$id' ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    echo "<script>alert('Data berhasil diubah!');</script>";
}
?>