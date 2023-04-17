<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
if ($_SESSION['is_admin'] == '1') {
    $scope = "Admin";
}else {
    $scope = "Staff";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Management System - Dashboard</title>
    <style>
        ::-webkit-scrollbar {
        display: none;
        }
        
        *{
        scrollbar-width: none;
        -ms-overflow-style: none;
        }
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container-fluid mt-3">
        <h1 class="text-center mb-4">Student Management System</h1>
        <h5 class="text-center mb-4">Welcome, <?php echo $_SESSION['username']; ?>!  ( <?php echo $scope; ?> )</h5>
        <div class="row">
            <div class="col-sm-12 col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        Student Details
                    </div>
                    <div class="card-body">
                        <a href="studentdetails.php" class="btn btn-primary btn-block">View Student Details</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        Add Student
                    </div>
                    <div class="card-body">
                        <a href="register.php" class="btn btn-primary btn-block">Add New Student</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        User Management
                    </div>
                    <div class="card-body">
                        <a href="adduser.php" class="btn btn-primary btn-block">Add New User</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4 text-center">
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
        <?php require_once "chatbot.html"; ?>
    </div>
</body>
</html>

