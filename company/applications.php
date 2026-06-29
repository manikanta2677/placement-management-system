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

if(isset($_GET['id']) && isset($_GET['status'])){
    $app_id = $_GET['id'];
    $status = $_GET['status'];

    mysqli_query($conn, "UPDATE applications 
    JOIN jobs ON applications.job_id = jobs.id
    SET applications.status='$status'
    WHERE applications.id='$app_id' AND jobs.company_id='$company_id'");

    if($status == 'Selected'){
        mysqli_query($conn, "UPDATE students 
        JOIN applications ON students.id = applications.student_id
        SET students.placement_status='Placed'
        WHERE applications.id='$app_id'");
    }

    echo "<script>alert('Application Updated'); window.location.href='applications.php';</script>";
}

$result = mysqli_query($conn, "SELECT applications.*, users.name AS student_name, students.roll_no, students.branch, students.cgpa, jobs.title
FROM applications
JOIN students ON applications.student_id = students.id
JOIN users ON students.user_id = users.id
JOIN jobs ON applications.job_id = jobs.id
WHERE jobs.company_id='$company_id'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Company Applications</title>
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
            <h1>Applications Received</h1>
            <p>Shortlist, select, or reject applicants</p>
        </div>

        <table>
            <tr>
                <th>Student</th>
                <th>Roll No</th>
                <th>Branch</th>
                <th>CGPA</th>
                <th>Job</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($result)){ ?>
            <tr>
                <td><?php echo $row['student_name']; ?></td>
                <td><?php echo $row['roll_no']; ?></td>
                <td><?php echo $row['branch']; ?></td>
                <td><?php echo $row['cgpa']; ?></td>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td>
                    <a href="applications.php?id=<?php echo $row['id']; ?>&status=Shortlisted">Shortlist</a>
                    <a href="applications.php?id=<?php echo $row['id']; ?>&status=Selected">Select</a>
                    <a href="applications.php?id=<?php echo $row['id']; ?>&status=Rejected">Reject</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>

</body>
</html>