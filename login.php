<?php
session_start();
include "db.php";

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_unset(); 
    session_destroy(); 
    header("Location: login.php");
    exit();
}

if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$error = "";
$message = "";
$mode = isset($_GET['mode']) ? $_GET['mode'] : 'login';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if (isset($_POST['register_btn'])) {
        $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
        if (mysqli_num_rows($check) > 0) {
            $error = "Username already taken!";
        } else {
            $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
            if (mysqli_query($conn, $sql)) {
                $message = "Registration successful! You can now login.";
                $mode = "login"; 
            } else {
                $error = "Registration failed!";
            }
        }
    } else if (isset($_POST['login_btn'])) {
        $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $_SESSION['username'] = strtoupper($username);
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid username or password!";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo ($mode == 'register') ? 'Sign Up' : 'Login'; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h2><?php echo ($mode == 'register') ? 'Create Account' : 'Login Form'; ?></h2>

    <div class="container">
        <?php if ($error != ""): ?>
            <p style="color:red; text-align:center;"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if ($message != ""): ?>
            <p style="color:green; text-align:center;"><?php echo $message; ?></p>
        <?php endif; ?>

        <form method="POST">
            <label>Username:</label>
            <input type="text" name="username" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <?php if ($mode == 'register'): ?>
                <button type="submit" name="register_btn">Sign Up</button>
                <p style="text-align:center; margin-top:15px;">
                    Already have an account? <a href="login.php?mode=login" style="background:none; color:#3498db; padding:0; text-decoration: underline;">Login</a>
                </p>
            <?php else: ?>
                <button type="submit" name="login_btn">Login</button>
                <p style="text-align:center; margin-top:15px;">
                    Don't have an account? <a href="login.php?mode=register" style="background:none; color:#3498db; padding:0; text-decoration: underline;">Sign Up</a>
                </p>
            <?php endif; ?>
        </form>
    </div>

</body>
</html>