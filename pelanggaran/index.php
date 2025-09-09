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
                <img src="../assets/images/logo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
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

            </section>

            <!-- Main content -->
            <section class="content">
                <!-- Default box -->
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-users"></i> Data Pelanggaran</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-tambah">
                                <i class="fas fa-plus"> tambah</i>
                            </button>
                            <p></p>
                            <table id="example1" class="table table-bordered table-striped justify-content-between">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Kategori</th>
                                        <th>Poin</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $query = "SELECT pelanggaran.id, pelanggaran.nama, pelanggaran.poin, kategori.nama AS kategori FROM pelanggaran JOIN kategori ON pelanggaran.id_kategori = kategori.id";
                                    $pdo = pdo_query($conn, $query);

                                    while ($row = $pdo->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $row["nama"] ?></td>
                                            <?php 
                                            if ($row["kategori"] == "ringan") {
                                                echo '<td><p class="badge badge-success">Ringan</p></td>';
                                            } else if ($row["kategori"] == "sedang") {
                                                echo '<td><p class="badge badge-warning">Sedang</p></td>';
                                            } else if ($row["kategori"] == "berat") {
                                                echo '<td><p class="badge badge-danger">Berat</p></td>';
                                            }
                                            ?>
                                            <td><?= $row["poin"] ?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning btn-sm open-modal-edit" data-toggle="modal" data-target="#modal-edit"
                                                data-id="<?= $row['id'] ?>"
                                                data-nama="<?= $row['nama'] ?>"
                                                data-kategori="<?= $row['kategori'] ?>"
                                                data-poin="<?= $row['poin'] ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm open-modal-hapus" data-toggle="modal" data-target="#modal-hapus"
                                                data-id="<?= $row['id'] ?>"
                                                data-nama="<?= $row['nama'] ?>">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.card -->

            </section>
            <!-- /.content -->

            <!-- Modal Tambah -->
            <div class="modal fade" id="modal-tambah">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Tambah Data</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Main Modal -->
                            <!-- form start -->
                            <form action="aksi.php" method="post">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="tambahNama">Nama pelanggaran</label>
                                        <input type="text" name="nama" class="form-control" id="tambahNama" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Kategori</label>
                                        <select name="kategori" class="form-control" id="tambahKategori" required>
                                            <option>-- pilih --</option>
                                            <option value=1>Ringan</option>
                                            <option value=2>Sedang</option>
                                            <option value=3>Berat</option>
                                        </select>
                                    </div>
                                    <!-- <input type="hidden" name="point" class="form-control" id="addPoint" required> -->
                                    <div class="form-group">
                                        <label for="tambahPoin">Poin</label>
                                        <input type="text" name="poin" class="form-control" id="tambahPoin" required>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="submit" name="simpan" class="btn btn-primary btn-block"><i class="fas fa-save"></i> Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- Modal Update -->
            <div class="modal fade" id="modal-edit">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit Data</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Main Modal -->
                            <!-- form start -->
                            <form action="aksi.php" method="post">
                                <div class="modal-body">
                                    <input type="hidden" name="id" class="form-control" id="editId" required>
                                    <div class="form-group">
                                        <label for="editNama">Nama pelanggaran</label>
                                        <input type="text" name="nama" class="form-control" id="editNama" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Kategori</label>
                                        <select name="kategori" class="form-control" id="editKategori" required>
                                            <option>-- pilih --</option>
                                            <option value=1>Ringan</option>
                                            <option value=2>Sedang</option>
                                            <option value=3>Berat</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="editPoin">Poin</label>
                                        <input type="number" name="poin" class="form-control" id="editPoin" required>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="submit" name="edit" class="btn btn-warning btn-block"><i class="fas fa-edit"></i> Edit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- Modal Delete -->
            <div class="modal fade" id="modal-hapus">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Hapus Data</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Main Modal -->
                            <!-- form start -->
                            <form action="aksi.php" method="post">
                                <h4>Apakah anda yakin ingin menghapus data berikut?</h4>
                                <div class="form-group">
                                    <!-- <label for="hapusNisn">NISN</label> -->
                                    <input type="hidden" name="id" class="form-control" id="hapusId" required>
                                </div>
                                <div class="form-group">
                                    <label for="hapusNama">Nama</label>
                                    <input type="text" name="nama" class="form-control" id="hapusNama" disabled required>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="submit" name="hapus" class="btn btn-danger btn-block"><i class="fas fa-trash"></i> Hapus</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->

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

    <script type="text/javascript">
        $(document).on("click", ".open-modal-edit", function() {
            $("#editId").val($(this).data("id"));
            $("#editNama").val($(this).data("nama"));
            $("#editKategori").val($(this).data("kategori"));
            $("#editPoin").val($(this).data("poin"));                         

            $("#modal-edit").modal("show");
        })

        $(document).on("click", ".open-modal-hapus", function() {
            $("#hapusId").val($(this).data("id"));                         
            $("#hapusNama").val($(this).data("nama"));

            $("#modal-hapus").modal("show");
        })
    </script>

</body>

</html>