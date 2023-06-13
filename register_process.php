<?php
    // Pastikan Anda telah membuat koneksi ke database
    include 'koneksi.php';
    session_start();

    // Mendapatkan data dari form registrasi
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Lakukan validasi registrasi di sini sesuai dengan struktur tabel database Anda
    // Query untuk memeriksa apakah pembeli dengan username yang sama sudah terdaftar sebelumnya
    // Gantikan "pembeli" dengan nama tabel pembeli pada database Anda
    $query = "SELECT * FROM pembeli WHERE username='$username'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) == 0) {
        // Tambahkan pembeli baru ke database
        $query = "INSERT INTO pembeli (username, password) VALUES ('$username', '$password')";
        mysqli_query($koneksi, $query);

        // Set pesan sukses menggunakan session
        $_SESSION['success_message'] = "Pendaftaran pembeli berhasil.";

        header('Location: register.php');
        exit();
    } else {
        // Pembeli dengan username yang sama sudah terdaftar
        header('Location: register.php');
        exit();
    }
?>
