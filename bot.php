<?php

require "vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

define("FONNTE_TOKEN", $_ENV["WHATSAPP_API"]);

function kirimPesan($nomor_tujuan, $pesan)
{
    $curl = curl_init();
    $nomor_tujuan = preg_replace("/[^0-9]/", "", $nomor_tujuan);

    if (substr($nomor_tujuan, 0, 1) == "0") {
        $nomor_tujuan = "62" . substr($nomor_tujuan, 1);
    }

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.fonnte.com/send",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => array(
            'target' => $nomor_tujuan,
            'message' => $pesan,
            'countryCode' => '62'
        ),
        CURLOPT_HTTPHEADER => array(
            'Authorization: ' . FONNTE_TOKEN
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    return json_decode($response, true);
}

function pesanKonseling($nisn, $nama_siswa, $tanggal, $kategori, $deskripsi, $pencatat) {
    $pesan = "*NOTIFIKASI KONSELING SISWA*\n\n";
    $pesan .= "Yth. Orang Tua/Wali dari:\n";
    $pesan .= "NISN : {$nisn}\n";
    $pesan .= "Nama : {$nama_siswa}\n\n";
    $pesan .= "━━━━━━━━━━━━━━━\n\n";
    $pesan .= "Kami informasikan bahwa telah dilakukan pencatatan konseling:\n\n";
    $pesan .= "Tanggal   : {$tanggal}\n";
    $pesan .= "kategori  : {$kategori}\n\n";
    $pesan .= "Deskripsi : \n{$deskripsi}\n\n";
    $pesan .= "━━━━━━━━━━━━━━━\n\n";
    $pesan .= "Pencatat : {$pencatat}\n\n";
    $pesan .= "Untuk informasi lebih lanjut, silahkan menghubungi guru BK.\n\n";
    $pesan .= "Terimakasih";

    return $pesan;
}
