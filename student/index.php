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
            <!-- Content Header (Page header) -->
            <section class="content-header">

            </section>

            <!-- Main content -->
            <section class="content">
                <!-- Default box -->
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-users"></i> Data Siswa</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-add">
                                <i class="fas fa-plus"> tambah</i>
                            </button>
                            <p></p>
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NISN</th>
                                        <th>Nama</th>
                                        <th>Jenis kelamin</th>
                                        <th>Poin</th>
                                        <th>Alamat</th>
                                        <th>Orang Tua</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $query = "SELECT * FROM student";
                                    $stmt = $conn->prepare($query);
                                    $stmt->execute();

                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $row["nisn"] ?></td>
                                            <td><?= $row["name"] ?></td>
                                            <td><?= $row["gender"] ?></td>
                                            <td><?= $row["point"] ?></td>
                                            <td><?= $row["address"] ?></td>
                                            <td><?= $row["parent"], "<br> (",$row['parent_phone'], ")" ?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning btn-sm open-modal-update" data-toggle="modal" data-target="#modal-update"
                                                data-nisn="<?= $row['nisn'] ?>"
                                                data-name="<?= $row['name'] ?>"
                                                data-gender="<?= $row['gender'] ?>"
                                                data-address="<?= $row['address'] ?>"
                                                data-parent="<?= $row['parent'] ?>"
                                                data-phone="<?= $row['parent_phone'] ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                </tbody>
                            <?php } ?>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.card -->

            </section>
            <!-- /.content -->

            <!-- Modal Add -->
            <div class="modal fade" id="modal-add">
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
                            <form action="action.php" method="post">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="addNisn">NISN</label>
                                        <input type="text" name="nisn" class="form-control" id="addNisn" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="addName">Name</label>
                                        <input type="text" name="name" class="form-control" id="addName" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Jenis Kelamin</label>
                                        <select name="gender" class="form-control" id="addGender" required>
                                            <option>-- pilih --</option>
                                            <option value="pria">pria</option>
                                            <option value="perempuan">perempuan</option>
                                        </select>
                                    </div>
                                    <!-- <input type="hidden" name="point" class="form-control" id="addPoint" required> -->
                                    <div class="form-group">
                                        <label for="addAddress">Alamat</label>
                                        <input type="text" name="address" class="form-control" id="addAlamat" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="addParent">Orang Tua/Wali</label>
                                        <input type="text" name="parent" class="form-control" id="addParent" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="addParentPhone">No. Hp Orang Tua/Wali</label>
                                        <input type="number" name="parentPhone" class="form-control" id="addParentPhone" required>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="submit" name="save" class="btn btn-primary btn-block"><i class="fas fa-save"></i> Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- Modal Update -->
            <div class="modal fade" id="modal-update">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Data</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Main Modal -->
                            <!-- form start -->
                            <form action="action.php" method="post">
                                <div class="modal-body">
                                    <input type="hidden" name="nisn" class="form-control" id="updateNisn" required>
                                    <div class="form-group">
                                        <label for="updateName">Name</label>
                                        <input type="text" name="name" class="form-control" id="updateName" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Jenis Kelamin</label>
                                        <select name="gender" class="form-control" id="updateGender" required>
                                            <option>-- pilih --</option>
                                            <option value="pria">pria</option>
                                            <option value="perempuan">perempuan</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="updateAddress">Alamat</label>
                                        <input type="text" name="address" class="form-control" id="updateAddress" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="updateParent">Orang Tua/Wali</label>
                                        <input type="text" name="parent" class="form-control" id="updateParent" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="updatePhone">No. Hp Orang Tua/Wali</label>
                                        <input type="number" name="phone" class="form-control" id="updatePhone" required>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="submit" name="update" class="btn btn-warning btn-block"><i class="fas fa-edit"></i> Update</button>
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
        $(document).on("click", ".open-modal-update", function() {
            $("#updateNisn").val($(this).data("nisn"));
            $("#updateName").val($(this).data("name"));
            $("#updateGender").val($(this).data("gender"));
            $("#updateAddress").val($(this).data("address"));
            $("#updateParent").val($(this).data("parent"));
            $("#updatePhone").val($(this).data("phone"));                           

            $("#modal-update").modal("show");
        })
    </script>

</body>

</html>