<?php
session_start();
include("../config.php");

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'company'){
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$company = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM companies WHERE user_id='$user_id'"));
$company_id = $company['id'];

if(isset($_POST['post'])){
    $title = $_POST['title'];
    $description = $_POST['description'];
    $package = $_POST['package'];
    $cgpa = $_POST['cgpa'];
    $last_date = $_POST['last_date'];

    mysqli_query($conn, "INSERT INTO jobs(company_id,title,description,package,eligibility_cgpa,last_date)
    VALUES('$company_id','$title','$description','$package','$cgpa','$last_date')");

    echo "<script>alert('Job Posted Successfully'); window.location.href='my_jobs.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Post Job</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="page">
    <div class="sidebar">
        <h2>PlacementPro</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="post_job.php">Post Job</a>
        <a href="my_jobs.php">My Jobs</a>
        <a href="applications.php">Applications</a>
        <a href="../logout.php">Logout</a>
    </div>

    <div class="content">
        <div class="topbar">
            <h1>Post New Job</h1>
            <p>Create a new placement opportunity</p>
        </div>

        <form method="POST">
            <input type="text" name="title" placeholder="Job Title" required>
            <textarea name="description" placeholder="Job Description" required></textarea>
            <input type="text" name="package" placeholder="Package Ex: 6 LPA" required>
            <input type="number" step="0.01" name="cgpa" placeholder="Eligibility CGPA" required>
            <input type="date" name="last_date" required>
            <button name="post">Post Job</button>
        </form>
    </div>
</div>

</body>
</html>