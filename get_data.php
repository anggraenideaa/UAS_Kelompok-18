

<?php
include('koneksi.php');

$bulan = $_GET['bulan'];

$sql = "SELECT menu1.id, menu1.nama, IFNULL(SUM(detail_pesanan.jumlah), 0) AS total_terjual
        FROM menu1
        LEFT JOIN detail_pesanan ON menu1.id = detail_pesanan.menu_id
        LEFT JOIN pesanan ON detail_pesanan.pesanan_id = pesanan.id_pesanan
        WHERE MONTH(pesanan.tanggal_pesanan) = $bulan OR pesanan.id_pesanan IS NULL
        GROUP BY menu1.id, menu1.nama";
$result = $koneksi->query($sql);

$data = array();
$data['nama'] = array();
$data['total_terjual'] = array();
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $data['nama'][] = $row['nama'];
    $data['total_terjual'][] = $row['total_terjual'];
  }
}

$koneksi->close();

header('Content-Type: application/json');
echo json_encode($data);
?>
