<?php
require_once 'vendor/autoload.php'; // Memuat autoloader DOMPDF

session_start();
$koneksi = mysqli_connect("localhost", "root", "", "pentolgila");

if (isset($_GET['pesanan_id'])) {
    $pesananId = $_GET['pesanan_id'];

    // Query untuk mendapatkan detail pesanan
    $query = "SELECT dp.menu_id, m.nama_menu, m.harga_menu, dp.jumlah
              FROM detail_pesanan dp
              INNER JOIN menu m ON dp.menu_id = m.id
              WHERE dp.pesanan_id = $pesananId";


    // Menampilkan alamat, tanggal, rincian pesanan, dan total harga dari pesanan terakhir
    $query = "SELECT * FROM pesanan ORDER BY id_pesanan DESC LIMIT 1";
    $result = mysqli_query($koneksi, $query);
    $pesanan = mysqli_fetch_assoc($result);

    // Menampilkan detail pesanan
    $query = "SELECT * FROM detail_pesanan WHERE pesanan_id = " . $pesanan['id_pesanan'];
    $result = mysqli_query($koneksi, $query);
}
?>
<?php
// Mengecek apakah ada parameter action dan id yang diterima melalui GET
if (isset($_GET['action']) && $_GET['action'] == "remove" && isset($_GET['id'])) {
    $removeItemId = $_GET['id'];

    foreach ($_SESSION['cart'] as $key => $value) {
        if ($value['id'] == $removeItemId) {
            unset($_SESSION['cart'][$key]);
            break;
        }
    }
}

// Menampilkan alamat, tanggal, rincian pesanan, dan total harga dari pesanan terakhir
$query = "SELECT * FROM pesanan ORDER BY id_pesanan DESC LIMIT 1";
$result = mysqli_query($koneksi, $query);

if ($result) {
    $pesanan = mysqli_fetch_assoc($result);

    // Menampilkan detail pesanan
    $query = "SELECT * FROM detail_pesanan WHERE pesanan_id = " . $pesanan['id_pesanan'];
    $result = mysqli_query($koneksi, $query);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Pentol Gila</title>
    <link rel="icon" href="logo.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h1>Invoice Pentol Gila</h1>

                <?php if ($result && mysqli_num_rows($result) > 0) { ?>
                    <label>Jl. Rungkut Madya No.99, Rungkut Kidul, Kec. Rungkut, Surabaya, Jawa Timur 60293</label>
                    <?php
                    date_default_timezone_set('Asia/Jakarta');
                    $waktuIndonesia = date('Y-m-d', time());
                    ?>
                    <p>Waktu Pesanan: <?php echo $waktuIndonesia; ?></p>

                    <?php
                    if (isset($_SESSION['username'])) {
                        echo "<p>Nama Pelanggan  : " . $_SESSION['username'] . "</p>";
                    } else {
                        echo "<p>Pengguna tidak terautentikasi</p>";
                    }
                    ?>
                    <h3>Rincian Pesanan</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Menu</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $totalHarga = 0;
                            while ($row = mysqli_fetch_assoc($result)) {
                                // Mendapatkan informasi menu berdasarkan menu_id
                                $queryMenu = "SELECT * FROM menu1 WHERE id = " . $row['menu_id'];
                                $resultMenu = mysqli_query($koneksi, $queryMenu);
                                $menu = mysqli_fetch_assoc($resultMenu);

                                $subTotal = $row['jumlah'] * $menu['harga'];
                                $totalHarga += $subTotal;
                            ?>
                                <tr>
                                    <td><?php echo $menu['nama']; ?></td>
                                    <td><?php echo $row['jumlah']; ?></td>
                                    <td>Rp<?php echo number_format($menu['harga'], 2); ?></td>
                                    <td>Rp<?php echo number_format($subTotal, 2); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                    <h3>Total Harga</h3>
                    <p>Rp<?php echo number_format($totalHarga, 2); ?></p>
                    <a href="pembeli1.php" class="btn btn-secondary">Kembali</a>

                <?php } else { ?>
                    <p>Tidak ada pesanan yang ditemukan.</p>
                <?php } ?>
            </div>
        </div>
    </div>
</body>
</html>