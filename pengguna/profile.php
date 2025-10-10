<?php
session_start();
require_once "../database/config.php";

if (!isset($_SESSION["username"])) {
    header("Location: ../auth/login.php");
}

$halaman = "profile";
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sitem BK | Profil</title>
    <!-- CSS -->
    <?php include "../style.php"; ?>
</head>

<body class="hold-transition sidebar-mini">
    <?php include "../pesan.php"; ?>
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
                <img src="../assets/images/logo.png" alt="Logo MBS" class="brand-image img-circle elevation-3" style="opacity: .8">
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

        <!-- content wrapper -->
        <div class="content-wrapper">
            <!-- content header -->
            <section class="content-header">

            </section>
            <!-- end content header -->

            <!-- main content  -->
            <section class="content">
                <div class="container-fluid">
                    <div class="card card-warning">
                        <div class="card-header d-flex justify-content-center">
                            <h3 class="card-title"><i class="fas fa-user"></i>&nbsp;Profil</h3>
                        </div>
                        <?php
                        $id = $_SESSION["id"];
                        $sql = "SELECT * FROM tb_pengguna WHERE id = '$id' ";
                        $pdo = pdo_query($conn, $sql);
                        $row = $pdo->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <form action="aksi.php" method="post">
                            <div class="card-body">
                                <div class="form-group">
                                    <input type="hidden" name="id" class="form-control" value="<?php echo $row['id']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" name="nama" class="form-control" value="<?php echo $row['nama']; ?>" id="nama" required>
                                </div>
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" name="username" class="form-control" value="<?php echo $row['username']; ?>" id="username" required>
                                </div>
                                <div class="form-group">
                                    <label for="newPassword">Password Baru</label>
                                    <input type="password" name="password_baru" class="form-control" id="newPassword" required>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <a href="../pengguna" class="btn btn-secondary">
                                    <i class="fas fa-back"></i>&nbsp;Kembali
                                </a>
                                <button type="submit" name="edit" class="btn btn-warning">
                                    <i class="fas fa-edit"></i>&nbsp;Edit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
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
