<?php
session_start();
require_once "../database/config.php";
require_once "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (isset($_POST["edit"])) {
    $id = $_POST["id"];
    $nama = $_POST["nama"];
    $password_baru = sha1($_POST["password_baru"]);
    pdo_query(
        $conn,
        "UPDATE tb_pengguna SET passwd = ?, nama = ? WHERE id = ?",
        [$password_baru, $nama, $id],
    );

    $_SESSION["flash"] = [
        "type" => "success",
        "msg" => "Edit data berhasil, silahkan login ulang!",
    ];
    header("Location: ../auth/logout.php");
} else if (isset($_POST["rekap"])) {
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
    $baris = 2;

    $spreadsheet = new Spreadsheet();
    $activeWorksheet = $spreadsheet->getActiveSheet();
    $activeWorksheet->setTitle("rekapitulasi_bk");
    $activeWorksheet->setCellValue("A1","TANGGAL");
    $activeWorksheet->setCellValue("B1","PENCATAT");
    $activeWorksheet->setCellValue("C1","NISN");
    $activeWorksheet->setCellValue("D1","NAMA SISWA");
    $activeWorksheet->setCellValue("E1","PELANGGARAN");
    $activeWorksheet->setCellValue("F1","KATEGORI");
    $activeWorksheet->setCellValue("G1","DESKRIPSI");

    foreach (range("A", "G") as $columnID) {
    	$activeWorksheet->getColumnDimension($columnID)->setAutoSize(true);
    	$activeWorksheet->getStyle($columnID . "1")->getFont()->setBold(true);
    }

	while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
		$activeWorksheet->setCellValue("A" . $baris, $row["tanggal"]);
		$activeWorksheet->setCellValue("B" . $baris, $row["pencatat"]);
		$activeWorksheet->setCellValue("C" . $baris, $row["id_siswa"]);
		$activeWorksheet->setCellValue("D" . $baris, $row["siswa"]);
		$activeWorksheet->setCellValue("E" . $baris, $row["pelanggaran"]);
		$activeWorksheet->setCellValue("F" . $baris, $row["kategori"]);
		$activeWorksheet->setCellValue("G" . $baris, $row["deskripsi"]);
		$baris++;
    }

    $filename = "rekapitulasi" . date("d-m-Y H:i:s") . ".xlsx";
    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header("Content-Disposition: attachment; filename=$filename");
    header("Cache-Control: max-age=0");

    $writer = new Xlsx($spreadsheet);
    $writer->save("php://output");
}

?>
