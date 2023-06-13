<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <?php
            if (isset($_GET['error'])) {
                $error = $_GET['error'];
        ?>
            <div class="alert alert-danger alert-sm" role="alert">
                <?php echo $error; ?>
            </div>
        <?php
            }
        ?>
        <form action="login_process.php" method="POST">
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
                    <option value="admin">Admin</option>
                    <option value="pembeli">Pembeli</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <p class="mt-2">Belum punya akun? <a href="register.php">Daftar disini</a></p>
    </div>
    

    

</body>
</html>
