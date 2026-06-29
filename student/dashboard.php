<?php
session_start();
include("../config.php");

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student'){
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$result = mysqli_query($conn, "SELECT users.name, users.email, students.* 
FROM students JOIN users ON students.user_id = users.id 
WHERE users.id='$user_id'");

$student = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
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
            <h1>Student Dashboard</h1>
            <p>Welcome, <?php echo $student['name']; ?></p>
        </div>

        <table>
            <tr><th>Name</th><td><?php echo $student['name']; ?></td></tr>
            <tr><th>Email</th><td><?php echo $student['email']; ?></td></tr>
            <tr><th>Roll No</th><td><?php echo $student['roll_no']; ?></td></tr>
            <tr><th>Branch</th><td><?php echo $student['branch']; ?></td></tr>
            <tr><th>Year</th><td><?php echo $student['year']; ?></td></tr>
            <tr><th>CGPA</th><td><?php echo $student['cgpa']; ?></td></tr>
            <tr><th>Skills</th><td><?php echo $student['skills']; ?></td></tr>
            <tr><th>Phone</th><td><?php echo $student['phone']; ?></td></tr>
            <tr><th>Placement Status</th><td><?php echo $student['placement_status']; ?></td></tr>
        </table>
    </div>
</div>

</body>
</html>