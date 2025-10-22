<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem BK | Landing Page</title>
    <!-- Style -->
    <?php include "../style.php"; ?>
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
            <div class="container">
                <a href="../" class="navbar-brand">
                    <img src="../assets/images/logo.png" alt="Logo MBS" class="brand-image img-circle elevation-3" style="opacity: .8">
                    <span class="brand-text font-weight-light"><b>Sistem BK</b></span>
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
                        <a href="../pengguna" class="dropdown-item">
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
                                        <input type="text" class="form-control" name="nisn" id="nisn" placeholder="Masukan NISN siswa" maxlength="10" required>
                                    </div>
                                </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-search">&nbsp;Cek Siswa</i>
                            </button>
                        </div>
                        </form>
                        <!-- /.card-footer-->
                    </div>
                    <!-- /.card -->

                    <div id="resultSection" class="card" style="display: none;">
                        <div class="card-body">
                            <div id="resultContent">Loading...</div>
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
    <?php include "../script.php"; ?>

    <script>
        $(document).ready(function() {
            // Handle form submission
            $('#formNisn').on('submit', function(e) {
                e.preventDefault();

                var nisn = $('#nisn').val();

                // Show loading
                $('#loadingOverlay').show();
                $('#resultSection').hide();

                // AJAX Request
                $.ajax({
                    url: 'aksi.php',
                    type: 'POST',
                    data: {
                        nisn: nisn
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#loadingOverlay').hide();

                        if (response.status === 'success') {
                            let dataSiswa = response.data_siswa;
                            // Menampilkan Table
                            let html = '<div class="row">';
                            html += '<div class="col-md-6">';

                            html += '<table class="table table-borderless mx-auto">';
                            html += '<tr>';
                            html += '<th>NISN</th>';
                            html += '<td>&nbsp;:&nbsp;</td>';
                            html += '<td>' + dataSiswa.nisn +'</td>';
                            html += '</tr>';
                            html += '<tr>';
                            html += '<th>Nama </th>';
                            html += '<td>&nbsp;:&nbsp;</td>';
                            html += '<td>' + dataSiswa.nama +'</td>';
                            html += '</tr>';
                            html += '<tr>';
                            html += '<th>Poin</th>';
                            html += '<td>&nbsp;:&nbsp;</td>';
                            html += '<td>' + dataSiswa.poin +'</td>';
                            html += '</tr>';
                            html += '</table>';
                            html += '</div>'; //tutup div col-md-6

                            html += '<div class="col-md-6">';

                            html += '<table class="table table-borderless mx-auto">';
                            html += '<tr>';
                            html += '<th>Alamat</th>';
                            html += '<td>&nbsp;:&nbsp;</td>';
                            html += '<td>' + dataSiswa.alamat +'</td>';
                            html += '</tr>';
                            html += '<tr>';
                            html += '<th>Orang Tua / Wali</th>';
                            html += '<td>&nbsp;:&nbsp;</td>';
                            html += '<td>' + dataSiswa.orang_tua +'</td>';
                            html += '</tr>';
                            html += '<tr>';
                            html += '<th>No. HP</th>';
                            html += '<td>&nbsp;:&nbsp;</td>';
                            html += '<td>' + dataSiswa.no_hp +'</td>';
                            html += '</tr>';
                            html += '</table>';

                            html += '</div>'; // tutup div col-md-6
                            html += '</div>'; // tutup row
                            html += '<div class="my-3"></div>';

                            if (response.has_records) {
                                html += '<table class="table table-bordered table-striped">';
                                html += '<thead class="bg-primary">';
                                html += '<tr>';
                                html += '<th class="align-middle">No</th>';
                                html += '<th class="align-middle">Tanggal</th>';
                                html += '<th class="align-middle">Pelanggaran</th>';
                                html += '<th class="align-middle">Kategori</th>';
                                html += '<th class="align-middle">Poin Pelanggaran</th>';
                                html += '<th class="align-middle">Deskripsi</th>';
                                html += '</tr>';
                                html += '</thead>';
                                html += '<tbody>';

                                // Loop didalam tabel
                                $.each(response.data_catatan, function(index, row) {
                                    html += '<tr>';
                                    html += '<td class="align-middle">' + (index + 1) + '</td>';
                                    html += '<td class="align-middle">' + row.tanggal + '</td>';
                                    html += '<td class="align-middle">' + row.pelanggaran + '</td>';
                                    html += '<td class="align-middle">' + row.kategori + '</td>';
                                    html += '<td class="align-middle">' + row.poin_pelanggaran + '</td>';
                                    html += '<td class="align-middle">' + row.deskripsi + '</td>';
                                    html += '</tr>';
                                });

                                html += '</tbody>';
                                html += '</table>';

                            } else {
                                html += '<div class="alert alert-info">';
                                html += '<h5><i class="icon fas fa-info"></i> Informasi</h5>';
                                html += 'Siswa ini belum memiliki catatan konseling.';
                                html += '</div>';
                            }

                            $('#resultContent').html(html);
                            $('#resultSection').slideDown();

                        } else {
                            $('#resultContent').html(
                                '<div class="alert alert-danger alert-dismissible">' +
                                '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                                '<h5><i class="icon fas fa-ban"></i> Error!</h5>' +
                                response.message +
                                '</div>'
                            );
                            $('#resultSection').slideDown();
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#loadingOverlay').hide();
                        $('#resultContent').html(
                            '<div class="alert alert-danger alert-dismissible">' +
                            '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                            '<h5><i class="icon fas fa-ban"></i> Error!</h5>' +
                            'Terjadi kesalahan saat memproses data. Silakan coba lagi.' +
                            '</div>'
                        );
                        $('#resultSection').slideDown();
                    }
                });
            });

            // Close result section
            $('#closeResult').on('click', function() {
                $('#resultSection').slideUp();
            });

            // Reset form
            $('#formNISN').on('reset', function() {
                $('#resultSection').hide();
            });
        });
    </script>

</body>

</html>
