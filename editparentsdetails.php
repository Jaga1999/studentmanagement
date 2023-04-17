<?php
session_start();

if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit();
}
if ($_SESSION['is_admin'] != 1) {
  $_SESSION['alert'] = "You are not authorized to access this page.";
  header("Location: studentdetails.php");
  exit();
}
include_once 'dbconnect.php';

if (isset($_POST['submit'])) {
  $student_id = $_POST['student_id'];
  $name = $_POST['name'];
  $occupation = $_POST['occupation'];
  $email = $_POST['email'];
  $phone = $_POST['phone_number'];

  $query = "UPDATE parents SET par_name=?, occupation=?, par_email=?, par_phone=? WHERE student_id=?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("sssss", $name, $occupation, $email, $phone, $student_id);
  $result = $stmt->execute();

  if ($result) {
    $_SESSION['success_msg'] = "Parents details updated successfully";
    header("Location: studentdetails.php");
    exit();
  } else {
    $error_msg = "Error updating parents details: " . $conn->error;
  }
}

$student_id = $_GET['student_id'];
$query = "SELECT parents.*, students.stu_name FROM parents INNER JOIN students ON parents.student_id=students.student_id WHERE parents.student_id=?";
$stmt = $conn->prepare($query);
if (!$stmt) {
  die("Error: " . $conn->error);
}
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
  $_SESSION['error_msg'] = "Parents details not found";
  header("Location: studentdetails.php");
  exit();
}

$row = $result->fetch_assoc();
$name = $row['par_name'];
$occupation = $row['occupation'];
$email = $row['par_email'];
$phone = $row['par_phone'];
$student_name = $row['stu_name'];
?>

<!DOCTYPE html>
<html>

<head>
  <title>Edit Parent Details</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    form {
      max-width: 400px;
      margin: 0 auto;
    }

    h1,
    h2 {
      text-align: center;
    }

    ::-webkit-scrollbar {
      display: none;
    }

    *{
      scrollbar-width: none;
      -ms-overflow-style: none;
    }
  </style>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
  <div class="container">
    <h1>Edit Parent Details</h1>
    <h2>Student: <?php echo $student_name ?> </h2>
    <?php
    if (isset($error_msg)) {
      echo "<div class='alert alert-danger' role='alert' id='error-message'>$error_msg</div>"; ?>
      <script>
        setTimeout(() => document.getElementById('error-message')?.remove(), 3000);
      </script>
    <?php } ?>
    <form method="post">
      <input type="hidden" name="student_id" value="<?php echo $student_id ?>">
      <div class="form-group">
        <label for="name">Parent Name:</label>
        <input type="text" class="form-control" name="name" value="<?php echo $name ?>">
      </div>
      <div class="form-group">
        <label for="occupation">Occupation:</label>
        <input type="text" class="form-control" name="occupation" value="<?php echo $occupation ?>">
      </div>
      <div class="form-group">
        <label for="phone_number">Phone Number:</label>
        <input type="text" class="form-control" name="phone_number" value="<?php echo $phone ?>">
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" name="email" value="<?php echo $email ?>">
      </div>
      <button type="submit" class="btn btn-primary btn-block" name="submit">Save</button>
      <a href="studentdetails.php?student_id=<?php echo $student_id; ?>" class="btn btn-secondary btn-block mb-2">Cancel</a>
    </form>
  </div>
</body>

</html>