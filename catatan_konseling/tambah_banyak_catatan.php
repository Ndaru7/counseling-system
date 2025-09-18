<?php
session_start();
require_once "../database/config.php";

if (!isset($_SESSION["username"])) {
    header("Location: ../auth/login.php");
}

$halaman = "catatan_konseling";
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

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">

                </div>
                <!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-file"></i>&nbsp;Tambah Banyak Catatan Konseling</h3>

                            <div class="card-tools">
                                <!-- <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button> -->
                                <!-- <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button> -->
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <a href="../catatan_konseling" class="btn btn-warning">
                                <i class="fas fa-arrow-left">&nbsp;kembali</i>
                            </a>
                            <p></p>
                            <div class="row">
                                <div class="col-12">
                                    <form action="aksi.php" method="post">
                                        <div class="form-group">
                                            <label for="tambahSiswa">Nama Siswa</label>
                                            <select name="siswa[]" id="tambahSiswa" class="duallistbox" multiple="multiple">
                                                <!-- <option value="" selected>--Nama Siswa--</option> -->
                                                <?php
                                                $query = pdo_query($conn, "SELECT nisn, nama FROM tb_siswa");
                                                while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                                                    $nisn = $row["nisn"];
                                                    $nama_siswa = $row["nama"];
                                                    echo '<option value="' . $nisn . '">' . $nisn . ' - ' . $nama_siswa . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="tambahPelanggaran">Pelanggaraan</label>
                                            <select name="pelanggaran" class="form-control" id="tambahPelanggaran" required>
                                                <option>-- Pilih --</option>
                                                <?php
                                                $query_pelanggaran = "SELECT id, nama FROM tb_pelanggaran";
                                                $pdo_pelanggaran = pdo_query($conn, $query_pelanggaran);

                                                while ($row = $pdo_pelanggaran->fetch(PDO::FETCH_ASSOC)) {
                                                    $id = $row["id"];
                                                    $nama = $row["nama"];
                                                    echo '<option value="' . $id . '">' . $nama . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <textarea name="deskripsi" class="form-control" id="tambahDeskripsi" rows="10" placeholder="Deskripsi.." required></textarea>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="submit" name="simpan-banyak" class="btn btn-primary btn-block"><i class="fas fa-save"></i> Simpan</button>
                                        </div>
                                    </form>

                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
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