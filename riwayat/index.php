<?php
session_start();
require_once "../database/config.php";

if (!isset($_SESSION["username"])) {
    header("Location: ../auth/login.php");
}
$halaman = "riwayat";
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sitem BK | Riwayat Catatan Konseling</title>

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

            </section>

            <!-- Main content -->
            <section class="content">
                <!-- Default box -->
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-history"></i> Riwayat Catatan Konseling</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div style="overflow-x: auto;">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Nama</th>
                                            <th>Pelanggaran</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $query = "SELECT tb_catatan_konseling.id AS id, tb_catatan_konseling.tanggal AS tanggal, tb_siswa.nisn AS id_siswa, tb_siswa.nama AS siswa, tb_pelanggaran.id AS id_pelanggaran, tb_pelanggaran.nama AS pelanggaran, tb_catatan_konseling.deskripsi AS deskripsi FROM tb_catatan_konseling JOIN tb_siswa ON tb_catatan_konseling.id_siswa = tb_siswa.nisn JOIN tb_pelanggaran ON tb_catatan_konseling.id_pelanggaran = tb_pelanggaran.id ORDER BY tb_catatan_konseling.tanggal DESC";
                                        $pdo = pdo_query($conn, $query);

                                        while ($row = $pdo->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                            <tr data-widget="expandable-table" aria-expanded="false">
                                                <td><?= $no++ ?></td>
                                                <td><?= $row["tanggal"] ?></td>
                                                <td><?= $row["siswa"] ?></td>
                                                <td><?= $row["pelanggaran"] ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning btn-sm open-modal-edit" data-toggle="modal" data-target="#modal-edit"
                                                        data-id="<?= $row['id'] ?>"
                                                        data-siswa="<?= $row['id_siswa'] ?>"
                                                        data-pelanggaran="<?= $row['id_pelanggaran'] ?>"
                                                        data-deskripsi="<?= $row['deskripsi'] ?>">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm open-modal-hapus" data-toggle="modal" data-target="#modal-hapus"
                                                        data-id="<?= $row['id'] ?>">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr class="expandable-body">
                                                <td colspan="5">
                                                    <p class="text-center">
                                                        <?= $row["deskripsi"] ?>
                                                    </p>
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
            <strong>Copyright &copy; 2025 <a href="">MBS Bumiayu</a>.</strong> All rights reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- Modal Tambah -->
    <div class="modal fade" id="modal-tambah">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Catatan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Main Modal -->
                    <!-- form start -->
                    <form action="aksi.php" method="post">
                        <div class="form-group">
                            <label for="tambahSiswa">Nama Siswa</label>
                            <select name="siswa" class="form-control" id="tambahSiswa" required>
                                <option>-- Pilih --</option>
                                <?php
                                $query_siswa = "SELECT nisn, nama FROM tb_siswa";
                                $pdo_siswa = pdo_query($conn, $query_siswa);

                                while ($row = $pdo_siswa->fetch(PDO::FETCH_ASSOC)) {
                                    $nisn = $row["nisn"];
                                    $nama = $row["nama"];
                                    echo '<option value="' . $nisn . '">' . $nama . '</option>';
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
                            <textarea name="deskripsi" class="form-control" id="tambahDeskripsi" placeholder="Deskripsi.." required></textarea>
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
                    <h4 class="modal-title">Edit Catatan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Main Modal -->
                    <form action="aksi.php" method="post">
                        <input type="hidden" name="id" class="form-control" id="editId" required>
                        <div class="form-group">
                            <label for="editSiswa">Nama Siswa</label>
                            <select name="siswa" class="form-control" id="editSiswa" required>
                                <option>-- Pilih --</option>
                                <?php
                                $query_siswa = "SELECT nisn, nama FROM tb_siswa";
                                $pdo_siswa = pdo_query($conn, $query_siswa);

                                while ($row = $pdo_siswa->fetch(PDO::FETCH_ASSOC)) {
                                    $nisn = $row["nisn"];
                                    $nama = $row["nama"];
                                    echo '<option value="' . $nisn . '">' . $nama . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="editPelanggaran">Pelanggaraan</label>
                            <select name="pelanggaran" class="form-control" id="editPelanggaran" required>
                                <option value="">-- Pilih --</option>
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
                            <label for="editDeskripsi">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" id="editDeskripsi" required></textarea>
                            <!-- <input type="text" name="deskripsi" class="form-control" id="editDeskripsi" required> -->
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="submit" name="edit" class="btn btn-warning btn-block"><i class="fas fa-edit"></i> Edit </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- Modal Hapus -->
    <div class="modal fade" id="modal-hapus">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Hapus Catatan</h4>
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

    <?php include "../script.php"; ?>

    <script type="text/javascript">
        $(document).on("click", ".open-modal-edit", function() {
            $("#editId").val($(this).data("id"));
            $("#editSiswa").val($(this).data("siswa"));
            $("#editPelanggaran").val($(this).data("pelanggaran"));
            $("#editDeskripsi").val($(this).data("deskripsi"));

            $("#modal-edit").modal("show");
        })

        $(document).on("click", ".open-modal-hapus", function() {
            $("#hapusId").val($(this).data("id"));

            $("#modal-delete").modal("show");
        })
    </script>

</body>

</html>