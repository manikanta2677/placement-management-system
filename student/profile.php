<?php
session_start();
include("../config.php");

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student'){
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if(isset($_POST['update'])){
    $roll = $_POST['roll'];
    $branch = $_POST['branch'];
    $year = $_POST['year'];
    $cgpa = $_POST['cgpa'];
    $skills = $_POST['skills'];
    $phone = $_POST['phone'];

    mysqli_query($conn, "UPDATE students SET 
    roll_no='$roll',
    branch='$branch',
    year='$year',
    cgpa='$cgpa',
    skills='$skills',
    phone='$phone'
    WHERE user_id='$user_id'");

    echo "<script>alert('Profile Updated Successfully'); window.location.href='dashboard.php';</script>";
}

$student = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM students WHERE user_id='$user_id'"));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Profile</title>
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
            <h1>Update Profile</h1>
            <p>Maintain your placement profile details</p>
        </div>

        <form method="POST">
            <input type="text" name="roll" value="<?php echo $student['roll_no']; ?>" placeholder="Roll No" required>
            <input type="text" name="branch" value="<?php echo $student['branch']; ?>" placeholder="Branch" required>
            <input type="text" name="year" value="<?php echo $student['year']; ?>" placeholder="Year" required>
            <input type="number" step="0.01" name="cgpa" value="<?php echo $student['cgpa']; ?>" placeholder="CGPA" required>
            <textarea name="skills" placeholder="Skills"><?php echo $student['skills']; ?></textarea>
            <input type="text" name="phone" value="<?php echo $student['phone']; ?>" placeholder="Phone">
            <button name="update">Update Profile</button>
        </form>
    </div>
</div>

</body>
</html>