<?php
$filePath = "../assets/template_import/template_import_siswa.xlsx";

if(file_exists($filePath)) {
    ob_clean();
    header("Content-Description: File Transfer");
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=" . basename($filePath));
    header("Expires: 0");
    header("Cache-Control: must-revalidate");
    header("Pragma: public");
    header("Content-Length: ". filesize($filePath));
    flush();
    readfile($filePath);
    exit;
} else {
    echo "Error: File not found.";
}

?>
