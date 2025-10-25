<?php
session_start();
require_once "../database/config.php";

if (!isset($_SESSION["username"])) {
    header("Location: ../auth/login.php");
}

if ($_SESSION["peran"] != "2") {
    header("Location: ../auth/logout.php");
}

$halaman = "catatan_siswa";
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sitem BK | Riwayat Catatan Konseling</title>
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
                        <a href="../dashboard_guru" class="dropdown-item">
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
                <div class="container-fluid">
                    <div class="card card-warning">
                        <div class="card-header d-flex justify-content-center">
                            <h3 class="card-title"><i class="fas fa-history"></i>&nbsp;Riwayat Catatan Konseling</h3>
                        </div>
                        <div class="card-body">
                            <div style="overflow-x: auto;">
                                <table class="table table-bordered table-hover text-center">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Pencatat</th>
                                            <th>Nama Siswa</th>
                                            <th>Pelanggaran</th>
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
                                                <td><?= $row["pencatat"] ?></td>
                                                <td><?= $row["siswa"] ?></td>
                                                <td><?= $row["pelanggaran"] ?></td>
                                            </tr>
                                            <tr class="expandable-body">
                                                <td colspan="5">
                                                    <p class="text-center">
                                                        <strong>Deskripsi</strong>
                                                    <p></p>
                                                    <?= $row["deskripsi"] ?>
                                                    </p>
                                                    <div class="text-right">
                                                        <button type="button" title="Edit" class="btn btn-warning mr-2 open-modal-edit" data-toggle="modal" data-target="#modal-edit"
                                                            data-id="<?= $row['id'] ?>"
                                                            data-siswa="<?= $row['id_siswa'] ?>"
                                                            data-pelanggaran="<?= $row['id_pelanggaran'] ?>"
                                                            data-deskripsi="<?= $row['deskripsi'] ?>">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button type="button" title="Hapus" class="btn btn-danger mr-2 open-modal-hapus" data-toggle="modal" data-target="#modal-hapus"
                                                            data-id="<?= $row['id'] ?>"
                                                            data-siswa="<?= $row['siswa'] ?>"
                                                            data-pelanggaran="<?= $row['pelanggaran'] ?>">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        <button type="button" title="Notifikasi Whatsapp" class="btn btn-success mr-2 open-modal-notifikasi" data-toggle="modal" data-target="#modal-notifikasi"
                                                            data-id="<?= $row['id'] ?>"
                                                            data-nama="<?= $row['siswa'] ?>"
                                                            data-no_hp="<?= $row['no_hp'] ?>"
                                                            data-siswa="<?= $row['id_siswa'] ?>"
                                                            data-pelanggaran="<?= $row['id_pelanggaran'] ?>">
                                                            <i class="fab fa-whatsapp"></i>
                                                        </button>
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
            <strong>Copyright &copy; 2025 <a href="">MBS Bumiayu</a>.</strong> All rights reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- modal edit -->
    <div class="modal fade" id="modal-edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center">
                    <h4 class="modal-title">Edit Riwayat Catatan</h4>
                </div>
                <form action="aksi.php" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="id" class="form-control" id="editId" required>
                        <div class="form-group">
                            <label for="editSiswa">Nama Siswa</label>
                            <select name="siswa" class="form-control select2" id="editSiswa" required>
                                <?php
                                $query_siswa = pdo_query($conn, "SELECT nisn, nama FROM tb_siswa");

                                while ($row = $query_siswa->fetch(PDO::FETCH_ASSOC)) {
                                    $nisn = $row["nisn"];
                                    $nama = $row["nama"];
                                    echo '<option value="' . $nisn . '">' . $nama . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="editPelanggaran">Pelanggaraan</label>
                            <select name="pelanggaran" class="form-control select2" id="editPelanggaran" required>
                                <?php
                                $query_pelanggaran = pdo_query($conn, "SELECT id, nama FROM tb_pelanggaran");

                                while ($row = $query_pelanggaran->fetch(PDO::FETCH_ASSOC)) {
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
        </div>
    </div>
    <!-- end modal edit -->

    <!-- modal hapus -->
    <div class="modal fade" id="modal-hapus">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center">
                    <h4 class="modal-title">Hapus Riwayat Catatan</h4>
                </div>
                <form action="aksi.php" method="post">
                    <div class="modal-body">
                        <p>
                            Apakah anda yakin ingin menghapus catatan (<b id="displayNama"></b>) <b id="displayPelanggaran"></b>.
                            Setelah catatan dihapus poin siswa tersebut tidak akan berkurang!
                        </p>
                        <input type="hidden" name="id" class="form-control" id="hapusId" required>
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
        </div>
    </div>
    <!-- end modal hapus -->

    <!-- modal notifikasi -->
    <div class="modal fade" id="modal-notifikasi">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center">
                    <h4 class="modal-title">Notifikasi Whatsapp</h4>
                </div>
                <form action="aksi.php" method="post">
                    <div class="modal-body">
                        <p>
                            Notifikasi akan dikirimkan ke whatsapp orang tua dari siswa <b id="displayNamaNotif"></b> sesuai dengan nomor yang terdapat pada data siswa.&nbsp;&nbsp;Apakah anda ingin kirim notifikasi ke <b id="displayNo"></b>?
                        </p>
                        <input type="hidden" name="id" class="form-control" id="notifikasiId" required>
                        <input type="hidden" name="siswa" class="form-control" id="notifikasiSiswa" required>
                        <input type="hidden" name="pelanggaran" class="form-control" id="notifikasiPelanggaran" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>&nbsp;Batal
                        </button>
                        <button type="submit" name="notifikasi" class="btn btn-success">
                            <i class="fab fa-whatsapp"></i>&nbsp;Kirim
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end modal notifikasi -->

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
            $("#displayNama").text($(this).data("siswa"));
            $("#displayPelanggaran").text($(this).data("pelanggaran"));
            $("#hapusId").val($(this).data("id"));

            $("#modal-delete").modal("show");
        })

        $(document).on("click", ".open-modal-notifikasi", function() {
            $("#displayNamaNotif").text($(this).data("nama"));
            $("#displayNo").text($(this).data("no_hp"));
            $("#notifikasiId").val($(this).data("id"));
            $("#notifikasiSiswa").val($(this).data("siswa"));
            $("#notifikasiPelanggaran").val($(this).data("pelanggaran"));

            $("#modal-notifikasi").modal("show");
        })
    </script>

</body>

</html>
