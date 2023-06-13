<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel</title>
  <link rel="icon" href="logo.ico">

  <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
  <script type="text/javascript" src="Chart.js"></script>
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
    <div class="container">
      <div class="row">
        <h2 class="summary mb-3">Summary</h2>
        <!-- Total Income Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col auto">
                                            <div class="text-xs text-primary text-uppercase mb-1"><b>Total Produk Terjual</b></div>
                                            <div class="h3 mb-0">
                                                <?php  
                                                    $mysqli = mysqli_connect("localhost","root","","pentolgila");
                                                    $sql = "SELECT SUM(jumlah) as jml_pentol from detail_pesanan";
                                                    $query = mysqli_query($mysqli,$sql);
                                                        while($row2=mysqli_fetch_array($query)){
                                                            echo number_format($row2['jml_pentol']);
                                                        }
                                                ?>  
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-boxes fa-2x text-gray-400"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Total Employees Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs text-warning text-uppercase mb-1"><b>Total Transaksi</b></div>
                                            <div class="h3 mb-0">
                                                <?php
                                                    $sql = "SELECT COUNT(id_pesanan) as tot_trans from pesanan";
                                                    $query = mysqli_query($mysqli,$sql);
                                                        while($row2=mysqli_fetch_array($query)){
                                                            echo number_format($row2['tot_trans']);
                                                        }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-users fa-2x text-gray-400"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Products Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs text-danger text-uppercase mb-1"><b>Total Pembeli</b></div>
                                            <div class="h3 mb-0">
                                                <?php
                                                    $sql = "SELECT COUNT(id_pembeli) as tot_cust from pembeli";
                                                    $query = mysqli_query($mysqli,$sql);
                                                        while($row2=mysqli_fetch_array($query)){
                                                            echo number_format($row2['tot_cust'],0,".",",");
                                                        }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                           <i class="fa fa-user-tie fa-2x text-gray-400"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Products Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs text-danger text-uppercase mb-1"><b>Total Pendapatan</b></div>
                                            <div class="h3 mb-0">
                                                <?php
                                                    $sql = "SELECT SUM(total) as tot_income from pesanan";
                                                    $query = mysqli_query($mysqli,$sql);
                                                        while($row2=mysqli_fetch_array($query)){
                                                            echo 'Rp'.number_format($row2['tot_income']);
                                                        }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                           <i class="fa fa-user-tie fa-2x text-gray-400"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
        <h2 class="judul mt-4 mb-3">Grafik Total Penjualan Produk Pentol Gila</h2>
        <div class="pie chart mb-4">
            <!-- <iframe src="pie.php" width="100%" height="400"></iframe> -->
            <canvas id="pieChart" width="100%" height="30"></canvas>
            <?php
include('koneksi.php');

$query = mysqli_query($koneksi,"SELECT m.nama AS product_name, COUNT(d.id_detail) AS total_sold
FROM pesanan p
JOIN detail_pesanan d ON p.id_pesanan = d.pesanan_id
JOIN menu1 m ON d.menu_id = m.id
GROUP BY m.nama");
while ($row = mysqli_fetch_assoc($query)) {
    $product_name[] = $row['product_name'];
    $total_sold[] = $row['total_sold'];
}
?>
            

            <script>
              var pieConfig = {
                type: 'pie',
                data: {
                  datasets: [{
                    data:<?php echo json_encode($total_sold); ?>,
                    backgroundColor: [
                      'rgba(255, 99, 132, 0.2)',
                      'rgba(54, 162, 235, 0.2)',
                      'rgba(255, 206, 86, 0.2)',
                      'rgba(75, 192, 192, 0.2)',
                      'rgba(128, 128, 128, 0.2)',
                      'rgba(255, 0, 255, 0.2)',
                      'rgba(0, 255, 255, 0.2)',
                      'rgba(255, 0, 0, 0.2)',
                      'rgba(128, 0, 128, 0.2)'
                    ],
                    borderColor: [
                      'rgba(255,99,132,0.2)',
                      'rgba(54, 162, 235, 0.2)',
                      'rgba(255, 206, 86, 0.2)',
                      'rgba(75, 192, 192, 0.2)',
                      'rgba(128, 128, 128, 0.2)',
                      'rgba(255, 0, 255, 0.2)',
                      'rgba(0, 255, 255, 0.2)',
                      'rgba(255, 0, 0, 0.2)',
                      'rgba(128, 0, 128, 0.2)'
                    ],
                    label: 'Grafik total penjualan produk pentol gila'
                  }],
                  labels: <?php echo json_encode($product_name); ?>
                },
                options: {
                  responsive: true
                }
              };

              var pieCtx = document.getElementById('pieChart').getContext('2d');
              window.myPie = new Chart(pieCtx, pieConfig);
            </script>

          </div>
        
</body>
</html>