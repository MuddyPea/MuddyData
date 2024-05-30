<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Ninja";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $username, $hashed_password);
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            header("Location: halaman_input.php");
            exit;
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "Invalid username or password.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(to bottom right, #00c6ff, #0072ff);
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            flex-direction: column;
        }

        .login-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-header h2 {
            margin: 0;
            color: white;
            font-family: 'Times New Roman', Times, serif;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            position: relative;
        }

        .login-form .form-group {
            margin-bottom: 15px;
        }

        .login-form .btn-primary {
            background-color: #002366;
            border-color: #002366;
        }

        .login-form .btn-primary:hover {
            background-color: #001d4c;
            border-color: #001d4c;
        }

        .alert {
            margin-bottom: 15px;
        }

        .login-logo {
            text-align: center;
            margin-top: 20px;
        }

        .login-logo img {
            max-width: 100px;
        }
    </style>
</head>

<body>
    <div class="login-header">
        <h2>SATU DATA DISKOMINFO PRABUMULIH</h2>
    </div>
    <div class="login-container">
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="login.php" method="post" class="login-form">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>
    </div>
    <div class="login-logo">
        <img src="../assets/img/kominfopbm.png" alt="Logo KOMINFO">
    </div>
</body>

</html>