<?php
	// Pastikan Anda telah membuat koneksi ke database
	include 'koneksi.php';
	session_start();
	// Mendapatkan data dari form login
	$username = $_POST['username'];
	$password = $_POST['password'];
	$role = $_POST['role'];

	// Lakukan validasi login di sini sesuai dengan struktur tabel database Anda
	if ($role == 'admin') {
		// Query untuk memeriksa kecocokan username dan password admin
		// Gantikan "admin" dengan nama tabel admin pada database Anda
		$query = "SELECT * FROM admin WHERE BINARY username='$username' AND BINARY password='$password'";
		$result = mysqli_query($koneksi, $query);

		if (mysqli_num_rows($result) == 1) {
			// Login admin berhasil
			$_SESSION['role'] = 'admin';
			$_SESSION['username'] = $username;
			header('Location: admin.php');
		} else {
			// Login admin gagal
			$error = "Username atau password admin salah.";
			header('Location: login.php?error=' . urlencode($error));
		}
	} else if ($role == 'pembeli') {
		// Query untuk memeriksa kecocokan username dan password pembeli
		// Gantikan "pembeli" dengan nama tabel pembeli pada database Anda
		$query = "SELECT * FROM pembeli WHERE BINARY username='$username' AND BINARY password='$password'";
		$result = mysqli_query($koneksi, $query);

		if (mysqli_num_rows($result) == 1) {
			// Login pembeli berhasil
			$_SESSION['role'] = 'pembeli';
			$_SESSION['username'] = $username;
			header('Location: pembeli1.php');
		} else {
			// Login pembeli gagal
			$error = "Username atau password pembeli salah.";
			header('Location: login.php?error=' . urlencode($error));
		}
	}
?>
