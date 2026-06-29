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
$cgpa = $student['cgpa'];

if(isset($_GET['apply'])){
    $job_id = $_GET['apply'];

    $check = mysqli_query($conn, "SELECT * FROM applications WHERE student_id='$student_id' AND job_id='$job_id'");

    if(mysqli_num_rows($check) > 0){
        echo "<script>alert('You have already applied for this job');</script>";
    } else {
        mysqli_query($conn, "INSERT INTO applications(student_id,job_id) VALUES('$student_id','$job_id')");
        echo "<script>alert('Applied Successfully'); window.location.href='applications.php';</script>";
    }
}

$result = mysqli_query($conn, "SELECT jobs.*, companies.company_name 
FROM jobs JOIN companies ON jobs.company_id = companies.id 
WHERE jobs.status='Open'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Available Jobs</title>
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
            <h1>Available Jobs</h1>
            <p>Apply only to jobs where you meet the eligibility criteria</p>
        </div>

        <table>
            <tr>
                <th>Company</th>
                <th>Title</th>
                <th>Description</th>
                <th>Package</th>
                <th>Required CGPA</th>
                <th>Last Date</th>
                <th>Action</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($result)){ ?>
            <tr>
                <td><?php echo $row['company_name']; ?></td>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td><?php echo $row['package']; ?></td>
                <td><?php echo $row['eligibility_cgpa']; ?></td>
                <td><?php echo $row['last_date']; ?></td>
                <td>
                    <?php if($cgpa >= $row['eligibility_cgpa']){ ?>
                        <a href="jobs.php?apply=<?php echo $row['id']; ?>">Apply</a>
                    <?php } else { ?>
                        Not Eligible
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>

</body>
</html>