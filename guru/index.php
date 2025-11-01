<?php
session_start();
require_once "../database/config.php";

if (!isset($_SESSION["username"])) {
    header("Location: ../auth/login.php");
}

if ($_SESSION["peran"] != "0") {
    header("Location: ../auth/logout.php");
}

$pengaturan = pdo_query(
    $conn,
    "SELECT nama_sistem, nama_instansi, tahun FROM tb_pengaturan"
)->fetch(PDO::FETCH_ASSOC);

$halaman = "guru";
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $pengaturan['nama_sistem'] ?> | Data Guru BK</title>

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
                        <a href="../dashboard_admin/profile.php" class="dropdown-item">
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
                <!-- Default box -->
                <div class="container-fluid">
                   <div class="card card-warning">
                      <div class="card-header d-flex justify-content-center">
                          <h3 class="card-title"><i class="fas fa-chalkboard-teacher"></i> Data Guru BK</h3>
                      </div>
                   </div>
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-tambah">
                                <i class="fas fa-plus">&nbsp;Tambah</i>
                            </button>
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-import">
                                <i class="fas fa-file-excel">&nbsp;Import</i>
                            </button>
                            <p></p>
                            <div style="overflow-x: auto;">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NUPTK</th>
                                            <th>Nama</th>
                                            <th>NO. HP</th>
                                            <th>Email</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $query = pdo_query(
                                            $conn,
                                            "SELECT * FROM tb_guru",
                                        );

                                        while ($row = $query->fetch(PDO::FETCH_ASSOC)) { ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $row["nuptk"] ?></td>
                                                <td><?= $row["nama"] ?></td>
                                                <td><?= $row["no_hp"] ?></td>
                                                <td><?= $row["email"] ?></td>
                                                <td>
                                                   <button type="button" class="btn btn-warning btn-sm open-modal-edit" title="Edit" data-toggle="modal" data-target="#modal-edit"
                                                       data-nuptk="<?= $row["nuptk"] ?>"
                                                       data-nama="<?= $row["nama"] ?>"
                                                       data-no_hp="<?= $row["no_hp"] ?>"
                                                       data-email="<?= $row["email"] ?>">
                                                          <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm open-modal-hapus" title="Hapus" data-toggle="modal" data-target="#modal-hapus"
                                                        data-nuptk="<?= $row["nuptk"] ?>"
                                                        data-nama="<?= $row["nama"] ?>">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php }
                                        ?>
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

            <!-- modal tambah -->
            <div class="modal fade" id="modal-tambah">
                <div class="modal-dialog">
                    <!-- start modal content -->
                    <div class="modal-content">
                        <div class="modal-header d-flex justify-content-center">
                            <h4 class="modal-title">Tambah Data Guru</h4>
                        </div>
                        <form action="aksi.php" method="post">
                            <div class="modal-body">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="tambahNuptk">NUPTK</label>
                                        <input type="text" name="nuptk" class="form-control" id="tambahNuptk" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="tambahNama">Nama</label>
                                        <input type="text" name="nama" class="form-control" id="tambahNama" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="tambahNohp">No. HP</label>
                                        <input type="text" name="no_hp" class="form-control" id="tambahNohp" maxlength="15" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="tambahEmail">Email</label>
                                        <input type="email" name="email" class="form-control" id="tambahEmail" maxlength="50" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">
                                    <i class="fas fa-times"></i>&nbsp;Batal
                                </button>
                                <button type="submit" name="simpan" class="btn btn-primary">
                                    <i class="fas fa-save"></i>&nbsp;Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- end modal content -->
                </div>
            </div>
            <!-- end modal tambah -->

            <!-- modal edit -->
            <div class="modal fade" id="modal-edit">
                <div class="modal-dialog">
                    <!-- modal content -->
                    <div class="modal-content">
                        <div class="modal-header d-flex justify-content-center">
                            <h4 class="modal-title">Edit Data Guru</h4>
                        </div>
                        <form action="aksi.php" method="post">
                            <div class="modal-body">
                                <div class="modal-body">
                                    <input type="hidden" name="nuptk" class="form-control" id="editNuptk" required>
                                    <div class="form-group">
                                        <label for="editNama">Nama</label>
                                        <input type="text" name="nama" class="form-control" id="editNama" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="editNohp">No. HP</label>
                                        <input type="text" name="no_hp" class="form-control" id="editNohp" maxlength="15" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="editEmail">Email</label>
                                        <input type="email" name="email" class="form-control" id="editEmail" maxlength="50" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">
                                    <i class="fas fa-times"></i>&nbsp;Batal
                                </button>
                                <button type="submit" name="edit" class="btn btn-warning">
                                    <i class="fas fa-edit"></i>&nbsp;Edit
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- end modal content -->
                </div>
            </div>
            <!-- end modal edit -->

            <!-- modal hapus -->
            <div class="modal fade" id="modal-hapus">
                <div class="modal-dialog">
                    <!-- modal content -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title d-flex justify-content-center">Hapus Data Guru</h4>
                        </div>
                        <form action="aksi.php" method="post">
                            <div class="modal-body">
                                <p>Apakah anda yakin ingin menghapus data <b id="displayNama"></b></p>
                                <input type="hidden" name="nuptk" class="form-control" id="hapusNuptk" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">
                                    <i class="fas fa-times"></i>&nbsp;Batal
                                </button>
                                <button type="submit" name="hapus" class="btn btn-danger">
                                    <i class="fas fa-trash"></i>&nbsp;Hapus
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- end modal content -->
                </div>
            </div>
            <!-- end modal hapus -->

            <!-- modal import -->
            <div class="modal fade" id="modal-import">
                <div class="modal-dialog">
                    <!-- modal content -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Import Data Guru</h4>
                        </div>
                        <form action="aksi.php" method="post" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="custom-file">
                                    <input type="file" name="file" class="custom-file-input" id="importExcel" accept=".xlsx, .xls" required>
                                    <label for="importExcel" class="custom-file-label">Pilih File Excel</label>
                                </div>
                                <p></p>
                                <a href="download_file_import.php" class="btn btn-warning"><i class="fas fa-download"></i>&nbsp;Download Template</a>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">
                                    <i class="fas fa-times"></i>&nbsp;Batal
                                </button>
                                <button type="submit" name="import" class="btn btn-success">
                                    <i class="fas fa-upload"></i>&nbsp;Upload
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- end modal content -->
                </div>
            </div>
            <!-- end modal import -->

        </div>
        <!-- end content-wrapper -->

        <footer class="main-footer">
            <?php include "../footer.php"; ?>
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
            $("#editNuptk").val($(this).data("nisn"));
            $("#editNama").val($(this).data("nama"));
            $("#editNohp").val($(this).data("no_hp"));
            $("#editEmail").val($(this).data("email"));

            $("#modal-edit").modal("show");
        })

        $(document).on("click", ".open-modal-hapus", function() {
            $("#hapusNuptk").val($(this).data("nuptk"));
            $("#displayNama").text($(this).data("nama"));

            $("#modal-hapus").modal("show");
        })
    </script>

</body>

</html>
