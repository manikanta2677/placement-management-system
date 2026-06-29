<?php
session_start();
include("../config.php");

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student'){
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$student = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM students WHERE user_id='$user_id'"));
$student_id = $student['id'];

$result = mysqli_query($conn, "SELECT applications.*, jobs.title, companies.company_name
FROM applications
JOIN jobs ON applications.job_id = jobs.id
JOIN companies ON jobs.company_id = companies.id
WHERE applications.student_id='$student_id'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Applications</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="page">
    <div class="sidebar">
        <h2>PlacementPro</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="profile.php">Profile</a>
        <a href="jobs.php">Jobs</a>
        <a href="applications.php">Applications</a>
        <a href="../logout.php">Logout</a>
    </div>

    <div class="content">
        <div class="topbar">
            <h1>My Applications</h1>
            <p>Track your placement application status</p>
        </div>

        <table>
            <tr>
                <th>Company</th>
                <th>Job</th>
                <th>Status</th>
                <th>Applied At</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($result)){ ?>
            <tr>
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