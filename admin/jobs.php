<?php
session_start();
include("../config.php");

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}

$result = mysqli_query($conn, "SELECT jobs.*, companies.company_name 
FROM jobs JOIN companies ON jobs.company_id = companies.id");
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Jobs</title>
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
            <h1>All Jobs</h1>
            <p>Monitor all company job postings</p>
        </div>

        <table>
            <tr>
                <th>Company</th><th>Title</th><th>Package</th><th>CGPA</th><th>Last Date</th><th>Status</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($result)){ ?>
            <tr>
                <td><?php echo $row['company_name']; ?></td>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['package']; ?></td>
                <td><?php echo $row['eligibility_cgpa']; ?></td>
                <td><?php echo $row['last_date']; ?></td>
                <td><?php echo $row['status']; ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>

</body>
</html>