<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="icon" href="Logo.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        .sidebar {
            background-color: #A61916;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            padding: 20px;
            color: #fff;
        }

        .sidebar ul {
            list-style: none;
            padding-left: 0;
        }

        .sidebar ul li {
            margin-bottom: 10px;
        }

        .sidebar ul li a {
            display: block;
            padding: 10px;
            color: #fff;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .sidebar ul li a:hover {
            background-color: #B13554;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <?php
        session_start();

        // Periksa apakah pengguna tidak login atau bukan admin
        if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
            // Alihkan pengguna ke halaman login
            header("Location: login.php");
            exit();
        }
    ?>

    <div class="sidebar">
        <h2 class="mb-4">Admin Panel</h2>
        <ul>
            <li><a href="admin.php"><i class="bi bi-people"></i> List Pembeli</a></li>
            <li><a href="registrasi_admin.php"><i class="bi bi-file-earmark-text"></i> Registrasi Admin</a></li>
            <li><a href="chart.php"><i class="bi bi-bar-chart"></i> Grafik Penjualan Produk</a></li>
        </ul>
        <ul class="mt-auto">
            <li><a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
        </ul>
    </div>
    <div class="content">
        <div class="container mt-3">
            <?php
            // Koneksi ke database
            include 'koneksi.php';

            // Inisialisasi variabel tanggal awal dan tanggal akhir
            $tanggal_awal = "";
            $tanggal_akhir = "";

            // Periksa apakah form telah disubmit
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Validasi input tanggal
                $tanggal_awal = $_POST["tanggal_awal"];
                $tanggal_akhir = $_POST["tanggal_akhir"];

                // Mengubah format tanggal menjadi Y-m-d (hanya tanggal, tanpa waktu)
                $tanggal_awal = date("Y-m-d", strtotime($tanggal_awal));
                $tanggal_akhir = date("Y-m-d", strtotime($tanggal_akhir));

                // Query untuk mengambil data pemesanan berdasarkan tanggal
                $query = "SELECT * FROM pesanan WHERE DATE(tanggal_pesanan) >= '$tanggal_awal' AND DATE(tanggal_pesanan) <= '$tanggal_akhir'";
                $result = mysqli_query($koneksi, $query);
            } else {
                // Query untuk mengambil semua data pemesanan
                $query = "SELECT * FROM pesanan";
                $result = mysqli_query($koneksi, $query);
            }

            // Periksa apakah ada data pemesanan
            if (mysqli_num_rows($result) > 0) {
                echo '<h2 class="mb-4">Data Pemesanan</h2>';

                // Tampilkan form pemilihan tanggal
                echo '
                    <form method="POST" action="">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="tanggal_awal">Tanggal Awal</label>
                                <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal" value="' . $tanggal_awal . '">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="tanggal_akhir">Tanggal Akhir</label>
                                <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="' . $tanggal_akhir . '">
                            </div>
                            <div class="col-md-2 align-self-end" style="margin-bottom: 1rem;">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </div>
                    </form>
                ';

                // Tampilkan data pemesanan
                echo '
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>No.</th>
                                <th>Nama Pembeli</th>
                                <th>Tanggal Pesanan</th>
                                <th>Total Harga Pesanan</th>
                            </tr>
                        </thead>
                        <tbody>
                ';

                // Batasan jumlah data per halaman
                $limit = 7;

                // Hitung total halaman
                $total_records = mysqli_num_rows($result);
                $total_pages = ceil($total_records / $limit);

                // Periksa halaman saat ini
                if (!isset($_GET['page'])) {
                    $page = 1;
                } else {
                    $page = $_GET['page'];
                }

                // Hitung offset
                $offset = ($page - 1) * $limit;

                // Query untuk mengambil data pemesanan sesuai dengan halaman saat ini
                $query_page = $query . " LIMIT $offset, $limit";
                $result_page = mysqli_query($koneksi, $query_page);
                // Inisialisasi nomor urut
                $nomor_urut = ($page - 1) * $limit + 1;

                // Loop untuk menampilkan data pemesanan
                while ($row = mysqli_fetch_assoc($result_page)) {
                    echo '
                        <tr>
                            <td>' . $nomor_urut . '</td>
                            <td>' . $row['nama_pelanggan'] . '</td>
                            <td>' . $row['tanggal_pesanan'] . '</td>
                            <td>' . $row['total'] . '</td>
                        </tr>
                    ';

                    // Increment nomor urut
                    $nomor_urut++;
                }

                echo '
                        </tbody>
                    </table>
                ';

                // Tampilkan tombol previous dan next
                echo '
                    <div class="mt-3">
                        <ul class="pagination">
                            <li class="page-item ' . ($page == 1 ? "disabled" : "") . '">
                                <a class="page-link" href="?page=' . ($page - 1) . '">Previous</a>
                            </li>
                ';

                // Tampilkan halaman-halaman
                for ($i = 1; $i <= $total_pages; $i++) {
                    echo '
                        <li class="page-item ' . ($page == $i ? "active" : "") . '">
                            <a class="page-link" href="?page=' . $i . '">' . $i . '</a>
                        </li>
                    ';
                }

                echo '
                            <li class="page-item ' . ($page == $total_pages ? "disabled" : "") . '">
                                <a class="page-link" href="?page=' . ($page + 1) . '">Next</a>
                            </li>
                        </ul>
                    </div>
                ';
            } else {
                echo '<h2 class="mb-4">Tidak ada data pemesanan</h2>';
            }

            // Tutup koneksi database
            mysqli_close($koneksi);
            ?>
            <div class="row">
    <div class="col-md-6">
        <form method="POST" action="export_excel.php" class="d-inline">
            <input type="hidden" name="tanggal_awal" value="<?php echo $tanggal_awal; ?>">
            <input type="hidden" name="tanggal_akhir" value="<?php echo $tanggal_akhir; ?>">
            <button type="submit" class="btn btn-success float-right ml-2">Export to Excel</button>
        </form>
        <form method="POST" action="export_pdf.php" class="d-inline">
            <input type="hidden" name="tanggal_awal" value="<?php echo $tanggal_awal; ?>">
            <input type="hidden" name="tanggal_akhir" value="<?php echo $tanggal_akhir; ?>">
            <button type="submit" class="btn btn-danger float-right m-2">Export to PDF</button>
        </form>
    </div>
</div>

        </div>
    </div>
</body>
</html>
