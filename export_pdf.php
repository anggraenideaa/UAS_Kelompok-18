<?php
    // Koneksi ke database
    include 'koneksi.php';

    // Load dompdf library
    require_once("dompdf/autoload.inc.php");

    // Create new PDF document
    $dompdf = new Dompdf\Dompdf();

    // Set document information
    $dompdf->set_option('isHtml5ParserEnabled', true);
    $dompdf->set_option('isRemoteEnabled', true);

    // Set default header data
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->set_option('defaultFont', 'helvetica');

    // Set margins
    $dompdf->set_option('margin', '15mm');

    // Enable PHP support
    $dompdf->set_option('isPhpEnabled', true);

    // Add content to the PDF
    $html = '<h1 style="text-align: center;">Daftar Laporan Transaksi Pesanan</h1>';

    // Retrieve filter values
    $tanggal_awal = $_POST["tanggal_awal"];
    $tanggal_akhir = $_POST["tanggal_akhir"];

    // Prepare the query with filter
    $query = "SELECT * FROM pesanan WHERE tanggal_pesanan >= '$tanggal_awal' AND tanggal_pesanan <= '$tanggal_akhir'";
    $result = mysqli_query($koneksi, $query);

    // Check if there are records
    if (mysqli_num_rows($result) > 0) {
        // Add table with order data to the HTML
        $html .= '<table style="margin: 0 auto;" border="1" cellpadding="5">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Pesanan</th>
                            <th>Nama Pembeli</th>
                            <th>Tanggal Pesanan</th>
                            <th>Total Harga</th>
                        </tr>
                    </thead>
                    <tbody>';

        $totalTransaksi = 0;
        $counter = 1; // Initialize counter variable

        while ($row = mysqli_fetch_assoc($result)) {
            $html .= '<tr>
                        <td style="text-align: center;">' . $counter . '</td>
                        <td style="text-align: center;">' . $row['id_pesanan'] . '</td>
                        <td style="text-align: center;">' . $row['nama_pelanggan'] . '</td>
                        <td style="text-align: center;">' . $row['tanggal_pesanan'] . '</td>
                        <td style="text-align: center;">' . $row['total'] . '</td>
                    </tr>';

            // Add the total price to the transaction total
            $totalTransaksi += $row['total'];

            $counter++; // Increment counter
        }

        $html .= '<tr>
                    <td colspan="4" style="text-align: center; font-weight: bold;">Total Transaksi</td>
                    <td style="text-align: center; font-weight: bold;">' . $totalTransaksi . '</td>
                </tr>';

        $html .= '</tbody>
                </table>';

        $dompdf->loadHtml($html);

        // Render the HTML content to PDF
        $dompdf->render();

        // Output PDF document
        $dompdf->stream('data_pemesanan.pdf', ['Attachment' => false]);
    } else {
        echo '<h2>Tidak ada data pemesanan.</h2>';
    }

    // Tutup koneksi ke database
    mysqli_close($koneksi);
?>
