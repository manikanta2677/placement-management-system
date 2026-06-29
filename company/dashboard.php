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

$jobs = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM jobs WHERE company_id='$company_id'"))['total'];
$applications = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM applications 
JOIN jobs ON applications.job_id=jobs.id 
WHERE jobs.company_id='$company_id'"))['total'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Company Dashboard</title>
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
            <h1>Company Dashboard</h1>
            <p>Welcome, <?php echo $company['company_name']; ?></p>
        </div>

        <div class="cards">
            <div class="card"><h3>Total Jobs Posted</h3><p><?php echo $jobs; ?></p></div>
            <div class="card"><h3>Applications Received</h3><p><?php echo $applications; ?></p></div>
        </div>
    </div>
</div>

</body>
</html>