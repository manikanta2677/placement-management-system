<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("config.php");

if(isset($_POST['register'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $role = $_POST['role'];

    $check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");

    if(mysqli_num_rows($check) > 0) {
        echo "<script>alert('Email already exists! Please login.'); window.location.href='login.php';</script>";
        exit();
    }

    $insertUser = mysqli_query($conn, "INSERT INTO users(name,email,password,role)
    VALUES('$name','$email','$password','$role')");

    if($insertUser) {

        $user_id = mysqli_insert_id($conn);

        if($role == "student") {
            $roll = $_POST['roll'];
            $branch = $_POST['branch'];
            $cgpa = $_POST['cgpa'];

            mysqli_query($conn, "INSERT INTO students(user_id,roll_no,branch,year,cgpa,skills,phone)
            VALUES('$user_id','$roll','$branch','4th Year','$cgpa','Not Updated','Not Updated')");
        }

        if($role == "company") {
            $company_name = $_POST['company_name'];
            $industry = $_POST['industry'];

            mysqli_query($conn, "INSERT INTO companies(user_id,company_name,industry,location,website)
            VALUES('$user_id','$company_name','$industry','Not Updated','Not Updated')");
        }

        echo "<script>alert('Registration Successful!'); window.location.href='login.php';</script>";
        exit();

    } else {
        echo "<script>alert('Registration Failed!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register | Placement Pro</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="auth-box">
    <div class="logo">Placement Pro</div>
    <p class="subtitle">Create your placement account</p>

    <form method="POST">

        <input class="form-control" type="text" name="name" placeholder="Full Name" required>

        <input class="form-control" type="email" name="email" placeholder="Email Address" required>

        <input class="form-control" type="password" name="password" placeholder="Password" required>

        <select class="form-control" name="role" id="role" onchange="showFields()" required>
            <option value="">Select Role</option>
            <option value="student">Student</option>
            <option value="company">Company</option>
        </select>

        <div id="studentFields" class="hidden">
            <input class="form-control" type="text" name="roll" placeholder="Roll Number">
            <input class="form-control" type="text" name="branch" placeholder="Branch">
            <input class="form-control" type="number" step="0.01" name="cgpa" placeholder="CGPA">
        </div>

        <div id="companyFields" class="hidden">
            <input class="form-control" type="text" name="company_name" placeholder="Company Name">
            <input class="form-control" type="text" name="industry" placeholder="Industry">
        </div>

        <button type="submit" class="btn-main" name="register">Register</button>

        <div class="extra-link">
            Already registered? <a href="login.php">Login</a>
        </div>

    </form>
</div>

<script>
function showFields() {
    let role = document.getElementById("role").value;

    document.getElementById("studentFields").style.display = "none";
    document.getElementById("companyFields").style.display = "none";

    if(role === "student") {
        document.getElementById("studentFields").style.display = "block";
    }

    if(role === "company") {
        document.getElementById("companyFields").style.display = "block";
    }
}
</script>

</body>
</html>