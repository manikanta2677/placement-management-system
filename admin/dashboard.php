<?php
session_start();
include("../config.php");

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}

$students = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM students"))['total'];
$companies = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM companies"))['total'];
$jobs = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM jobs"))['total'];
$applications = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM applications"))['total'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="page">
    <div class="sidebar">
        <h2>PlacementPro</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="students.php">Students</a>
        <a href="companies.php">Companies</a>
        <a href="jobs.php">Jobs</a>
        <a href="applications.php">Applications</a>
        <a href="../logout.php">Logout</a>
    </div>

    <div class="content">
        <div class="topbar">
            <h1>Admin Dashboard</h1>
            <p>Welcome, <?php echo $_SESSION['name']; ?></p>
        </div>

        <div class="cards">
            <div class="card"><h3>Total Students</h3><p><?php echo $students; ?></p></div>
            <div class="card"><h3>Total Companies</h3><p><?php echo $companies; ?></p></div>
            <div class="card"><h3>Total Jobs</h3><p><?php echo $jobs; ?></p></div>
            <div class="card"><h3>Applications</h3><p><?php echo $applications; ?></p></div>
        </div>
    </div>
</div>

</body>
</html>