<?php
require_once "../database/config.php";

if (isset($_POST["cek"])) {
    //$nisn = $_POST["nisn"];
    //echo $nisn;
    var_dump($_POST);
    exit;
    $query_siswa = "SELECT tb_catatan_konseling.id AS id,
                            tb_catatan_konseling.tanggal AS tanggal,
                            tb_siswa.nisn AS id_siswa,
                            tb_siswa.nama AS siswa,
                            tb_pelanggaran.id AS id_pelanggaran,
                            tb_pelanggaran.nama AS pelanggaran,
                            tb_catatan_konseling.deskripsi AS deskripsi
                            FROM tb_catatan_konseling JOIN tb_siswa ON tb_catatan_konseling.id_siswa = tb_siswa.nisn JOIN tb_pelanggaran ON tb_catatan_konseling.id_pelanggaran = tb_pelanggaran.id WHERE tb_siswa.nisn = '$nisn' ORDER BY tb_catatan_konseling.tanggal DESC";

    $pdo = pdo_query($conn, $query_siswa);
    echo '
    <table id="example1" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Pelanggaran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
    ';

    $no = 1;
    while ($row = $pdo->fetch(PDO::FETCH_ASSOC)) {
        echo '
            <tr>
                <td>' . $no++ . '</td>
                <td>' . $row["tanggal"] . '</td>
                <td>' . $row["pelanggaran"] . '</td>
                <td>Lorem Ipsum</td>
            </tr>
        ';
    }

    echo '
        </tbody>
    </table>';

}
?>
