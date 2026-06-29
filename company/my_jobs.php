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

if(isset($_GET['close'])){
    $job_id = $_GET['close'];

    mysqli_query($conn, "UPDATE jobs SET status='Closed' 
    WHERE id='$job_id' AND company_id='$company_id'");

    echo "<script>alert('Job Closed'); window.location.href='my_jobs.php';</script>";
}

$result = mysqli_query($conn, "SELECT * FROM jobs WHERE company_id='$company_id'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Jobs</title>
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
            <h1>My Posted Jobs</h1>
            <p>Manage job openings posted by your company</p>
        </div>

        <table>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Package</th>
                <th>CGPA</th>
                <th>Last Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($result)){ ?>
            <tr>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td><?php echo $row['package']; ?></td>
                <td><?php echo $row['eligibility_cgpa']; ?></td>
                <td><?php echo $row['last_date']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td>
                    <?php if($row['status'] == 'Open'){ ?>
                        <a href="my_jobs.php?close=<?php echo $row['id']; ?>">Close</a>
                    <?php } else { ?>
                        Closed
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>

</body>
</html>