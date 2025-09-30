<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem BK | Landing Page</title>
    <!-- Style -->
    <?php include "../style.php" ?>
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
            <div class="container">
                <a href="../" class="navbar-brand">
                    <img src="" alt="Logo MBS" class="brand-image img-circle elevation-3" style="opacity: .8">
                    <span class="brand-text font-weight-light"><b>Sistem BK</b></span>
                    <!-- <h2 class="brand-text">Sistem  BK</h2> -->
                </a>

                <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                    <!-- Left navbar links -->
                    <ul class="navbar-nav">

                    </ul>
                </div>
            </div>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-user"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <div class="dropdown-divider"></div>
                        <a href="pengguna/dashboard.php" class="dropdown-item">
                            <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container">

                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container">
                    <div class="callout callout-info">
                        <h5><i class="fas fa-info"></i> Catatan:</h5>
                        Silahkan masukan NISN siswa untuk melihat data perilaku. Apapun hasilnya itu adalah apa yang dilakukan siswa tanpa adanya manipulasi data. Bila ada yang ingin ditanyakan silahkan hubungi guru BK
                    </div>
                    <div class="card card-success">
                        <div class="card-header d-flex justify-content-center">
                            <h3 class="card-title carrd-success"><i class="fas fa-user-graduate"></i>&nbsp;Cek Siswa</h3>
                        </div>
                        <div class="card-body">
                            <form id="formNisn">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="nisn">NISN</label>
                                        <input type="text" class="form-control" name="nisn" id="nisn" placeholder="Masukan NISN siswa" maxlength="5" required>
                                    </div>
                                </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" name="cek" class="btn btn-primary btn-block">Kirim</button>
                        </div>
                        </form>
                        <!-- /.card-footer-->
                    </div>
                    <!-- /.card -->

                    <div id="dataCard" class="card" style="display: none;">
                        <div class="card-body">
                            <div id="resultTable">Loading...</div>
                        </div>
                    </div>

                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer navbar-green">
            <!-- Default to the left -->
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <?php include "../script.php" ?>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#formNisn").on("submit", function(e){
                e.preventDefault();
                let nisn = $("#nisn").val();
                console.log("Kirim nisn: ", nisn);

                $.post("aksi.php", {nisn: nisn}, function(data){
                    $("#resultTable").html(data);
                    $("#dataCard").slideDown();
                });
            });
        });
    </script>

</body>

</html>
