<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include("config.php");

if(isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) == 1) {

        $user = mysqli_fetch_assoc($result);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['name'] = $user['name'];

        if($user['role'] == 'admin') {
            echo "<script>window.location.href='admin/dashboard.php';</script>";
            exit();
        }

        if($user['role'] == 'student') {
            echo "<script>window.location.href='student/dashboard.php';</script>";
            exit();
        }

        if($user['role'] == 'company') {
            echo "<script>window.location.href='company/dashboard.php';</script>";
            exit();
        }

    } else {
        echo "<script>alert('Invalid Email or Password');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login | Placement Pro</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="auth-box">
    <div class="logo">Placement Pro</div>
    <p class="subtitle">College Placement Management System</p>

    <form method="POST">
        <input class="form-control" type="email" name="email" placeholder="Email Address" required>

        <input class="form-control" type="password" name="password" placeholder="Password" required>

        <button type="submit" class="btn-main" name="login">Login</button>

        <div class="extra-link">
            New user? <a href="register.php">Create Account</a>
        </div>
    </form>
</div>

</body>
</html>