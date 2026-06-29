<?php
session_start();
include("../config.php");

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}

$result = mysqli_query($conn, "SELECT users.name, users.email, students.* 
FROM students 
JOIN users ON students.user_id = users.id");
?>

<!DOCTYPE html>
<html>
<head>
<title>Students</title>
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
<h1>All Students</h1>
<p>Manage registered student records</p>
</div>

<table>
<tr>
<th>Name</th><th>Email</th><th>Roll No</th><th>Branch</th><th>Year</th><th>CGPA</th><th>Status</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>
<tr>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['email']; ?></td>
<td><?php echo $row['roll_no']; ?></td>
<td><?php echo $row['branch']; ?></td>
<td><?php echo $row['year']; ?></td>
<td><?php echo $row['cgpa']; ?></td>
<td><?php echo $row['placement_status']; ?></td>
</tr>
<?php } ?>

</table>
</div>
</div>

</body>
</html>