<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
} 
if ($_SESSION['is_admin'] != 1){
    $_SESSION['alert']= "You are not authorized to access this page.";
    header("Location: studentdetails.php");
    exit();
}

include_once 'dbconnect.php';

if (isset($_POST['submit'])) {
    $eduid = $_POST['eduid'];
    $institutionname = $_POST['institutionname'];
    $coursename = $_POST['coursename'];
    $yearofpassing = $_POST['yearofpassing'];
    $grade = $_POST['grade'];
    $board = $_POST['board'];

    $query = "UPDATE education SET institution_name=?, course_name=?, year_of_passing=?, grade_obtained=?, board=? WHERE student_id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssss", $institutionname, $coursename, $yearofpassing, $grade, $board, $eduid);
    $result = $stmt->execute();

    if ($result) {
        $_SESSION['success_msg'] = "Education details updated successfully";
        header("Location: studentdetails.php");
        exit();
    } else {
        $error_msg = "Error updating education details: " . $conn->error;
    }
}

$student_id = $_GET['student_id'];
$query = "SELECT education.*, students.stu_name FROM education INNER JOIN students ON education.student_id=students.student_id WHERE education.student_id=?";
$stmt = $conn->prepare($query);
if(!$stmt) {
    die("Error: " . $conn->error);
}
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    $_SESSION['error_msg'] = "Education details not found";
    header("Location: studentdetails.php");
    exit();
}

$row = $result->fetch_assoc();
$student_name = $row['stu_name'];
$institutionname = $row['institution_name'];
$coursename = $row['course_name'];
$yearofpassing = $row['year_of_passing'];
$grade = $row['grade_obtained'];
$board = $row['board'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Education Details</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
    form {
      max-width: 400px;
      margin: 0 auto;
    }
    h1,h2 {
      text-align: center;
    }
    ::-webkit-scrollbar {
        display: none;
    }
    *{
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
  </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4"><?php echo $page_title; ?></h1>
        <h2 class="mb-3">Student: <?php echo $student_name ?> </h2>
        <?php
        if (isset($error_msg)) {
            echo "<div class='alert alert-danger' role='alert' id='error-message'>$error_msg</div>"; ?>
            <script>setTimeout(() => document.getElementById('error-message')?.remove(), 3000);</script>
        <?php } ?>
        <form method="post">
            <input type="hidden" name="eduid" value="<?php echo $student_id; ?>">
            <div class="form-group">
                <label for="institutionname">Institution Name:</label>
                <input type="text" class="form-control" name="institutionname" value="<?php echo $institutionname; ?>" required>
            </div>

            <div class="form-group">
                <label for="coursename">Course Name:</label>
                <input type="text" class="form-control" name="coursename" value="<?php echo $coursename; ?>" required>
            </div>

            <div class="form-group">
                <label for="yearofpassing">Year of Passing:</label>
                <input type="text" class="form-control" name="yearofpassing" value="<?php echo $yearofpassing; ?>" required>
            </div>

            <div class="form-group">
                <label for="grade">Grade:</label>
                <input type="text" class="form-control" name="grade" value="<?php echo $grade; ?>" required>
            </div>

            <div class="form-group">
                <label for="board">Board:</label>
                <input type="text" class="form-control" name="board" value="<?php echo $board; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block" name="submit">Save</button>
            <a href="studentdetails.php?student_id=<?php echo $student_id; ?>" class="btn btn-secondary btn-block mb-2">Cancel</a>
        </form>
    </div>
</body>
</html>