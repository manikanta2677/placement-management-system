<?php
session_start();
include("../config.php");

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}

$result = mysqli_query($conn, "SELECT applications.*, users.name AS student_name, jobs.title, companies.company_name
FROM applications
JOIN students ON applications.student_id = students.id
JOIN users ON students.user_id = users.id
JOIN jobs ON applications.job_id = jobs.id
JOIN companies ON jobs.company_id = companies.id");
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Applications</title>
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
            <h1>All Applications</h1>
            <p>View all student job applications</p>
        </div>

        <table>
            <tr>
                <th>Student</th><th>Company</th><th>Job</th><th>Status</th><th>Applied At</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($result)){ ?>
            <tr>
                <td><?php echo $row['student_name']; ?></td>
                <td><?php echo $row['company_name']; ?></td>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td><?php echo $row['applied_at']; ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>

</body>
</html>