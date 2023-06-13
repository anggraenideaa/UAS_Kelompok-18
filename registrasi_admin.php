<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel</title>
  <link rel="icon" href="logo.ico">
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
    <h1>Registrasi Admin</h1>

    <?php
    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Check if the form fields are empty
      if (empty($_POST["username"]) || empty($_POST["password"])) {
        echo '<div class="alert alert-danger" role="alert">Please fill in all fields.</div>';
      } else {
        // Get the form data
        $username = $_POST["username"];
        $password = $_POST["password"];

        // No password encryption
        $hashedPassword = $password;


        // Insert the admin data into the database
        include 'koneksi.php'; // Include the database connection file

        $query = "INSERT INTO admin (username, password) VALUES ('$username', '$hashedPassword')";
        $result = mysqli_query($koneksi, $query);

        if ($result) {
          echo '<div class="alert alert-success" role="alert">Berhasil Registrasi Admin.</div>';
        } else {
          echo '<div class="alert alert-danger" role="alert">Error: ' . mysqli_error($koneksi) . '</div>';
        }

        // Close the database connection
        mysqli_close($koneksi);
      }
    }
    ?>

    <!-- Registration form -->
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
      <button type="submit" class="btn btn-primary">Register</button>
    </form>
  </div>

</body>
</html>
