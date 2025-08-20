<?php
require_once('../dbcon.php');
require __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$query = "SELECT 
            pendapatan_asli_daerah, dana_alokasi_umum, dana_alokasi_khusus, dana_bagi_hasil, 
            belanja_modal, belanja_pegawai, produk_domestik_regional_bruto, penduduk, 
            aparatur_sipil_negera, pulau_jawa, provinsi, kabupaten, kota, 
            estimasi_kerugian_negara, minimal_kerugian_negara, maksimal_kerugian_negara, 
            estimasi_temuan_bpk, minimal_temuan_bpk, maksimal_temuan_bpk, 
            estimasi_ipm, minimal_ipm, maksimal_ipm 
         FROM histori";
$result = $conn->query($query);

if($result && $result->num_rows > 0){
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $headers = [
        'No', 'Pendapatan Asli Daerah', 'Dana Alokasi Umum', 'Dana Alokasi Khusus',
        'Dana Bagi Hasil', 'Belanja Modal', 'Belanja Pegawai', 'Produk Domestik Regional Bruto',
        'Penduduk', 'Aparatur Sipil Negara', 'Pulau Jawa', 'Kabupaten', 'Kota', 'Provinsi',
        'Estimasi Kerugian Negara', 'Minimal Kerugian Negara', 'Maksimal Kerugian Negara',
        'Estimasi Temuan BPK', 'Minimal Temuan BPK', 'Maksimal Temuan BPK', 'Estimasi IPM',
        'Minimal IPM', 'Maksimal IPM'
    ];
    foreach($headers as $index => $header){
        $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);
        $sheet->setCellValue($colLetter . '1', $header);
    }

    $row = 2;
    while($data = $result->fetch_assoc()){
        $sheet->setCellValue('A' . $row, $row - 1);
        $index = 2;
        foreach($data as $value){
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index);
            $sheet->setCellValue($colLetter . $row, $value);
            $index++;
        }
        $row++;
    }

    $filename = 'download.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
} else{
    alert("Tidak ada data di database.");
}
?>