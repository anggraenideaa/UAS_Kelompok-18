<?php
session_start();
if (!isset($_SESSION['username'])) {
        // Arahkan pengguna ke halaman login
        header("Location: login.php");
        exit();
    }

$koneksi = mysqli_connect("localhost", "root", "", "pentolgila");

if (isset($_POST['add_to_cart'])) {
    if (isset($_SESSION['cart'])) {
        $session_array_id = array_column($_SESSION['cart'], "id");

        if (!in_array($_GET['id'], $session_array_id)) {
            $session_array = array(
                'id' => $_GET['id'],
                "nama" => $_POST['nama'],
                "harga" => $_POST['harga'],
                "qty" => $_POST['qty']
            );

            $_SESSION['cart'][] = $session_array;
        }
    } else {
        $session_array = array(
            'id' => $_GET['id'],
            "nama" => $_POST['nama'],
            "harga" => $_POST['harga'],
            "qty" => $_POST['qty']
        );

        $_SESSION['cart'][] = $session_array;
    }
}elseif (isset($_POST['buy'])) {
  $orderDate = date('Y-m-d'); // Mendapatkan tanggal sekarang
  $customerName = $_POST['customerName'];
  $totalPrice = 0;

  foreach ($_SESSION['cart'] as $item) {
    $hargaItem = $item['harga'];
    $jumlah = $item['qty'];
    $subtotal = $hargaItem * $jumlah;
    $totalPrice += $subtotal;
  }

  // Simpan data pesanan ke dalam tabel pesanan
  $insertPesananQuery = "INSERT INTO pesanan (tanggal_pesanan, nama_pelanggan, total) VALUES ('$orderDate', '$customerName', '$totalPrice')";
  mysqli_query($koneksi, $insertPesananQuery);

  // Dapatkan ID pesanan yang baru saja dimasukkan
  $pesananId = mysqli_insert_id($koneksi);

  // Simpan detail pesanan ke dalam tabel detail_pesanan
  foreach ($_SESSION['cart'] as $item) {
    $menuId = $item['id'];
    $jumlah = $item['qty'];

    $insertDetailQuery = "INSERT INTO detail_pesanan (pesanan_id, menu_id, jumlah) VALUES ('$pesananId', '$menuId', '$jumlah')";
    mysqli_query($koneksi, $insertDetailQuery);
  }

  // Reset keranjang belanja
  unset($_SESSION['cart']);

  // Redirect ke halaman sukses atau halaman lain yang diinginkan
  header("Location: tampil_pesanan.php");
  exit();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pembeli</title>
  <link rel="icon" href="Logo.ico">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
</head>
<body>

  <!-- Sidebar -->
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-3">
        <div class="sidebar">
          <h3>Info Pengguna</h3>
          <?php
          if (isset($_SESSION['username'])) {
            echo "<p>Selamat datang, " . $_SESSION['username'] . "</p>";
          } else {
            echo "<p>Pengguna tidak terautentikasi</p>";
          }
          ?>
          <p><a href="logout.php" class="btn btn-danger">Logout</a></p>
        </div>
      </div>
      <div class="col-md-9">
        <!-- Konten utama -->
        <h1>Daftar Menu</h1>

        <div class="col-md-12">
          <div class="row">
            <?php 
        $query = "SELECT * FROM menu1";
        $result = mysqli_query($koneksi,$query);

        while ($row = mysqli_fetch_array($result)) {?>
          <div class="col-md-4">
            <form method="post" action="pembeli1.php?id=<?=$row['id']?>">
              <div class="card py-4 mb-4" style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                <img src="img/<?= $row['gambar'] ?>" style="height: 230px; margin-bottom: 10px;">
            <h5 class="text-center"><?= $row['nama'] ?></h5>
            <p class="text-center">Rp<?= number_format($row['harga'],2); ?></p>

            <input type="hidden" name="nama" value="<?= $row['nama'] ?>">
            <input type="hidden" name="harga" value="<?= $row['harga'] ?>">

            <div class="cart" style="display: flex;">
              <input type="number" name="qty" value="0" class="form-control" style="width: 60px;">
              <input type="submit" name="add_to_cart" class="btn btn-warning" value="Add to Cart" style="height: 40px;">
            </div>
            

              </div>

            
          </form>
          </div>
          
        

        <?php }

        ?>
          </div>
        </div>

        <!-- <table class="table">
          <thead>
            <tr>
              <th>Nama Menu</th>
              <th>Harga</th>
            </tr>
          </thead>
          <tbody>
            Menampilkan daftar menu dari database
            <?php
              // include 'koneksi.php';
              // $query = "SELECT * FROM menu";
              // $result = mysqli_query($koneksi, $query);

              // while ($row = mysqli_fetch_assoc($result)) {
              //   echo "<tr>";
              //   echo "<td>" . $row['nama_menu'] . "</td>";
              //   echo "<td>Rp. " . $row['harga_menu'] . "</td>";
              //   echo "</tr>";
              // }
            ?>
          </tbody>
        </table> -->

        <hr>
        

        <h1>Pesananmu</h1>
        <div class="checkout">
          <?php 

        $total = 0;

        $output = "";

        $output .= "
        <table class='table table-bordered table-striped'>
          <tr>
            <th>ID</th>
            <th>Item name</th>
            <th>Item price</th>
            <th>Qty</th>
            <th>Total price</th>
            <th>Action</th>
          </tr>
        ";

        if(!empty($_SESSION['cart'])) {
          foreach ($_SESSION['cart'] as $key => $value) {
            $output .= "
              <tr>
                <td>".$value['id']."</td>
                <td>".$value['nama']."</td>
                <td>".$value['harga']."</td>
                <td>".$value['qty']."</td>
                <td>Rp".number_format($value['harga'] * $value['qty'],2)."</td>
                <td>
                <form method='post' action='pembeli1.php?action=remove&id=".$value['id']."'>
                <button class='btn btn-danger btn-block' onclick='return confirm(\"Apakah Anda yakin ingin menghapus item ini?\")'>Remove</button>
                </form>
                </td>

              </tr>
            ";
            
            $total = $total + $value['qty'] * $value['harga'];
          }
          $output .= "
            <tr>
              <td colspan='3'>" . date('d/m/Y') . "</td>
              <td></b>Total Price</b></td>
              <td>Rp".number_format($total,2)."</td>
              <td>
                <form method='post' action='pembeli1.php'>
                <input type='hidden' name='orderDate' value='" . date('d/m/Y') . "'>
                <input type='hidden' name='customerName' value='" . (isset($_SESSION['username']) ? $_SESSION['username'] : '') . "'>
                <button type='submit' name='buy' class='btn btn-warning btn-block'>Buy</button>
                </form>
              </td>
            </tr>
          ";
        }
    echo $output;
        ?>
        </div>
        
          

          <div class="mb-3">
            <label for="orderDate" class="form-label">Tanggal Pesanan</label>
            <?php
            date_default_timezone_set('Asia/Jakarta');
            $tanggalSekarang = date('Y-m-d');
            ?>
            <input type="date" class="form-control" id="orderDate" name="orderDate" required value="<?php echo $tanggalSekarang; ?>">
          </div>

          <div class="mb-3">
            <label for="customerName" class="form-label">Nama Pelanggan</label>
            <input type="text" class="form-control" id="customerName" name="customerName" required value="<?php echo $_SESSION['username']; ?>">
          </div>

          
        </form>
      </div>
    </div>
  </div>

  <?php 

if(isset($_GET['action'])) {
  if($_GET['action'] == "clearall") {
    unset($_SESSION['cart']);
  }

  if($_GET['action'] == "remove"){
    foreach ($_SESSION['cart'] as $key => $value) {
      if($value['id'] == $_GET['id']) {
        unset($_SESSION['cart'][$key]);
      }
    }
  }
}
?>

 <!--  order items container jadikan satu untuk disimpan ke satu kali transaksi -->
  <script>
    function toggleForm() {
  var orderItemsContainer1 = document.getElementById("orderItemsContainer1");
  if (orderItemsContainer1.style.display === "none") {
    orderItemsContainer1.style.display = "block";
  } else {
    orderItemsContainer1.style.display = "none";
  }
}
  </script>

  <script>
    function tambahItem() {
      var orderItemsContainer = document.getElementById('orderItemsContainer');

      var div = document.createElement('div');
      div.classList.add('mb-3');

      var menuSelect = document.createElement('select');
      menuSelect.classList.add('form-select');
      menuSelect.setAttribute('name', 'menu[]');
      menuSelect.setAttribute('required', '');

      var options = <?php echo json_encode($menuOptions); ?>; // Menggunakan variabel $menuOptions yang telah diisi sebelumnya

      options.forEach(function(option) {
        var optionElement = document.createElement('option');
        optionElement.value = option.id;
        optionElement.text = option.nama_menu;
        menuSelect.appendChild(optionElement);
      });

      div.appendChild(menuSelect);

      var quantityInput = document.createElement('input');
      quantityInput.setAttribute('type', 'number');
      quantityInput.classList.add('form-control');
      quantityInput.setAttribute('name', 'quantity[]');
      quantityInput.setAttribute('required', '');

      div.appendChild(quantityInput);

      orderItemsContainer.appendChild(div);
    }

    // Menghitung total pembayaran saat memilih menu dan jumlah
    function hitungTotal() {
      var totalAmountInput = document.getElementById('totalAmount');
      var menuSelects = document.querySelectorAll('select[name="menu[]"]');
      var quantityInputs = document.querySelectorAll('input[name="quantity[]"]');

      var total = 0;

      for (var i = 0; i < menuSelects.length; i++) {
        var menuId = menuSelects[i].value;
        var quantity = parseInt(quantityInputs[i].value);
        var hargaMenu = 0; // Nilai awal harga menu

        // Cari harga menu berdasarkan menuId
        <?php
          mysqli_data_seek($result, 0);
          while ($row = mysqli_fetch_assoc($result)) {
            echo 'if (menuId === "' . $row['id'] . '") {';
            echo 'hargaMenu = ' . $row['harga_menu'] . ';';
            echo '}';
          }
        ?>

        total += hargaMenu * quantity;
      }

      totalAmountInput.value = total.toFixed(2);
    }

    // Panggil fungsi hitungTotal saat ada perubahan pada pilihan menu atau jumlah
    var menuSelects = document.querySelectorAll('select[name="menu[]"]');
    var quantityInputs = document.querySelectorAll('input[name="quantity[]"]');

    for (var i = 0; i < menuSelects.length; i++) {
      menuSelects[i].addEventListener('change', hitungTotal);
      quantityInputs[i].addEventListener('change', hitungTotal);
    }
  </script>

</body>
</html>
