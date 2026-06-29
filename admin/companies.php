<?php
session_start();
include("../config.php");

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}

$result = mysqli_query($conn, "SELECT users.name, users.email, companies.* 
FROM companies JOIN users ON companies.user_id = users.id");
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Companies</title>
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
            <h1>All Companies</h1>
            <p>View registered company details</p>
        </div>

        <table>
            <tr>
                <th>HR Name</th><th>Email</th><th>Company</th><th>Industry</th><th>Location</th><th>Website</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($result)){ ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['company_name']; ?></td>
                <td><?php echo $row['industry']; ?></td>
                <td><?php echo $row['location']; ?></td>
                <td><?php echo $row['website']; ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>

</body>
</html>