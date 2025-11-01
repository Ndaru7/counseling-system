<?php
session_start();
require_once "../database/config.php";

if (!isset($_SESSION["username"])) {
    header("Location: ../auth/login.php");
}

if ($_SESSION["peran"] != "2") {
    header("Location: ../auth/logout.php");
}

$pengaturan = pdo_query(
    $conn,
    "SELECT nama_sistem, nama_instansi, tahun FROM tb_pengaturan"
)->fetch(PDO::FETCH_ASSOC);

$halaman = "catatan_siswa";
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $pengaturan['nama_sistem'] ?> | Catatan Siswa</title>
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
                        <a href="../dashboard_siswa/profile.php" class="dropdown-item">
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
                <img src="../assets/images/logo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light"><?= $pengaturan['nama_sistem'] ?></span>
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
            <!-- Content Header (Page header) -->
            <section class="content-header">

            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="card card-warning">
                        <div class="card-header d-flex justify-content-center">
                            <h3 class="card-title"><i class="fas fa-history"></i>&nbsp;Catatan Siswa</h3>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div style="overflow-x: auto;">
                                <table class="table table-bordered table-hover text-center">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Pelanggaran</th>
                                            <th>Kategori</th>
                                            <th>Poin</th>
                                            <th>Pencatat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $query = pdo_query(
                                            $conn,
                                            "SELECT tb_catatan_konseling.id AS id,
                                                    tb_catatan_konseling.tanggal AS tanggal,
                                                    tb_siswa.nisn AS id_siswa,
                                                    tb_siswa.nama AS siswa,
                                                    tb_siswa.no_hp AS no_hp,
                                                    tb_pelanggaran.id AS id_pelanggaran,
                                                    tb_pelanggaran.nama AS pelanggaran,
                                                    tb_pelanggaran.kategori AS kategori,
                                                    tb_pelanggaran.poin AS poin_pelanggaran,
                                                    tb_pengguna.nama AS pencatat,
                                                    tb_catatan_konseling.deskripsi AS deskripsi
                                            FROM
                                                tb_catatan_konseling
                                            JOIN
                                                tb_siswa ON tb_catatan_konseling.id_siswa = tb_siswa.nisn
                                            JOIN
                                                tb_pelanggaran ON tb_catatan_konseling.id_pelanggaran = tb_pelanggaran.id
                                            JOIN
                                                tb_pengguna ON tb_catatan_konseling.pencatat = tb_pengguna.id
                                            ORDER BY
                                                tb_catatan_konseling.tanggal DESC"
                                        );

                                        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                            <tr data-widget="expandable-table" aria-expanded="false">
                                                <td><?= $no++ ?></td>
                                                <td><?= $row["tanggal"] ?></td>
                                                <td><?= $row["pelanggaran"] ?></td>
                                                <td><?= $row["kategori"] ?></td>
                                                <td><?= $row["poin_pelanggaran"] ?></td>
                                                <td><?= $row["pencatat"] ?></td>
                                            </tr>
                                            <tr class="expandable-body">
                                                <td colspan="6">
                                                    <p class="text-center">
                                                        <strong>Deskripsi</strong>
                                                    <br>
                                                    <?= $row["deskripsi"] ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.card -->
            </section>
            <!-- /.content -->


        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
        <footer class="main-footer">
            <?php include "../footer.php"; ?>
        </footer>
    </div>
    <!-- ./wrapper -->

    <?php include "../script.php"; ?>

</body>

</html>
