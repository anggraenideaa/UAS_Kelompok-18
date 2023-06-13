<?php
require_once 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Koneksi ke database
include 'koneksi.php';

// Ambil data tanggal_awal dan tanggal_akhir dari form sebelumnya
$tanggal_awal = $_POST['tanggal_awal'];
$tanggal_akhir = $_POST['tanggal_akhir'];

// Query untuk mengambil data pemesanan berdasarkan tanggal
$query = "SELECT * FROM pesanan WHERE tanggal_pesanan BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
$result = mysqli_query($koneksi, $query);

// Membuat objek Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Menambahkan judul laporan
$sheet->setCellValue('A1', 'Daftar Laporan Transaksi Pesanan');
$sheet->mergeCells('A1:E1');
$sheet->getStyle('A1')->getFont()->setBold(true);
$sheet->getStyle('A1')->getFont()->setSize(16);

// Menambahkan header kolom
$sheet->setCellValue('A2', 'No.');
$sheet->setCellValue('B2', 'ID Pesanan');
$sheet->setCellValue('C2', 'Nama Pembeli');
$sheet->setCellValue('D2', 'Tanggal Pesanan');
$sheet->setCellValue('E2', 'Total Harga');

// Menambahkan data pemesanan ke sheet
$rowNumber = 3;
$no = 1; // Nomor awal
$totalTransaksi = 0; // Total transaksi
while ($row = mysqli_fetch_assoc($result)) {
    $sheet->setCellValue('A' . $rowNumber, $no);
    $sheet->setCellValue('B' . $rowNumber, $row['id_pesanan']);
    $sheet->setCellValue('C' . $rowNumber, $row['nama_pelanggan']);
    $sheet->setCellValue('D' . $rowNumber, $row['tanggal_pesanan']);
    $sheet->setCellValue('E' . $rowNumber, $row['total']);
    $rowNumber++;
    $no++; // Increment nomor
    $totalTransaksi += $row['total']; // Akumulasi total transaksi
}

// Menambahkan total transaksi di baris terakhir
$sheet->setCellValue('D' . $rowNumber, 'Total Transaksi');
$sheet->setCellValue('E' . $rowNumber, $totalTransaksi);
$sheet->getStyle('D' . $rowNumber . ':E' . $rowNumber)->getFont()->setBold(true);

// Mengatur lebar kolom
$sheet->getColumnDimension('A')->setWidth(10);
$sheet->getColumnDimension('B')->setWidth(15);
$sheet->getColumnDimension('C')->setWidth(25);
$sheet->getColumnDimension('D')->setWidth(20);
$sheet->getColumnDimension('E')->setWidth(15);

// Mengatur style header kolom
$headerStyle = $sheet->getStyle('A2:E2');
$headerStyle->getFont()->setBold(true);
$headerStyle->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$headerStyle->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
$headerStyle->getFill()->getStartColor()->setARGB('FFCCCCCC');

// Mengatur border
$borderStyle = array(
    'borders' => array(
        'allBorders' => array(
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
        )
    )
);
$sheet->getStyle('A2:E' . ($rowNumber - 1))->applyFromArray($borderStyle);
$sheet->getStyle('D' . $rowNumber . ':E' . $rowNumber)->applyFromArray($borderStyle);

// Menyimpan file Excel
$filename = 'Data_Pemesanan.xlsx';
$writer = new Xlsx($spreadsheet);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer->save('php://output');

// Tutup koneksi ke database
mysqli_close($koneksi);
exit();
?>
