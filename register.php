<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Registrasi</title>
	<link rel="icon" href="logo.ico">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
	<style>
		body {
			background-color: #A61916;
		}

		.container {
			background-color: #ffffff;
			border-radius: 8px;
			padding: 20px;
			max-width: 400px;
			margin: 0 auto;
			margin-top: 100px;
		}

		h1 {
			text-align: center;
			color: #A61916;
		}

		.btn-primary {
			background-color: #A61916;
			border-color: #A61916;
		}

		.btn-primary:hover {
			background-color: #ff4757;
			border-color: #ff4757;
		}

		p {
			text-align: center;
		}

		a {
			color: #A61916;
		}

		.alert {
			margin-top: 10px;
			padding: 5px;
			font-size: 12px;
			text-align: center;
		}

		.alert-success {
			color: #155724;
			background-color: #d4edda;
			border-color: #c3e6cb;
		}

		.alert-danger {
			color: #721c24;
			background-color: #f8d7da;
			border-color: #f5c6cb;
		}
	</style>
</head>
<body>
	

	<div class="container">
		<h1>Registrasi</h1>
		<?php
		    session_start();
		    if (isset($_SESSION['success_message'])) {
		        $successMessage = $_SESSION['success_message'];
		        unset($_SESSION['success_message']);
		    }
		?>

		<?php if (isset($successMessage)) { ?>
		    <div class="alert alert-success alert-lg" role="alert">
		        <?php echo $successMessage; ?>
		    </div>
		<?php } ?>

		<?php
		    if (isset($_GET['error'])) {
		        $error = $_GET['error'];
		?>
		    <div class="alert alert-danger alert-lg" role="alert">
		        <?php echo $error; ?>
		    </div>
		<?php } ?>
		<form action="register_process.php" method="POST">
			<div class="mb-3">
				<label for="username" class="form-label">Username</label>
				<input type="text" class="form-control" id="username" name="username" required>
			</div>
			<div class="mb-3">
				<label for="password" class="form-label">Password</label>
				<input type="password" class="form-control" id="password" name="password" required>
			</div>
			<div class="mb-3">
				<label for="role" class="form-label">Role</label>
				<select class="form-select" id="role" name="role">
					<option value="pembeli">Pembeli</option>
				</select>
			</div>
			<button type="submit" class="btn btn-primary">Daftar</button>
		</form>
		<p>Sudah punya akun? <a href="login.php">Login disini</a></p>
	</div>
</body>
</html>
