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

$student_id = $_GET['student_id'];
include_once 'dbconnect.php';

$sql = "SELECT * FROM students WHERE student_id = $student_id";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
  $row = $result->fetch_assoc();
} else {
  $_SESSION['error_msg'] = "Error: Student not found";
  header("Location: studentdetails.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $_POST['name'];
  $date_of_birth = $_POST['date_of_birth'];
  $gender = $_POST['gender'];
  $email = $_POST['email'];
  $phone_number = $_POST['phone_number'];
  $address = $_POST['address'];

  $sql = "UPDATE students SET stu_name = '$name', dob = '$date_of_birth', gender = '$gender', email = '$email', phone = '$phone_number', address = '$address' WHERE student_id = $student_id";

  if ($conn->query($sql) === TRUE) {
    $_SESSION['success_msg'] = "Student's personal details updated successfully";
    header("Location: studentdetails.php");
        exit();
  } else {
    echo "Error updating record: " . $conn->error;
  }
}
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Personal Details</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    form {
      max-width: 400px;
      margin: 0 auto;
    }
    h1 {
      text-align: center;
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
    <h1>Edit Personal Details</h1>
    <?php
        if (isset($error_msg)) {
            echo "<div class='alert alert-danger' role='alert' id='error-message'>$error_msg</div>"; ?>
            <script>setTimeout(() => document.getElementById('error-message')?.remove(), 3000);</script>
    <?php } ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?student_id=" . $student_id; ?>">
      <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control" name="name" value="<?php echo $row['stu_name']; ?>" required>
      </div>

      <div class="form-group">
        <label for="date_of_birth">Date of Birth:</label>
        <input type="date" class="form-control" name="date_of_birth" value="<?php echo $row['dob']; ?>" required>
      </div>

      <div class="form-group">
        <label for="gender">Gender:</label><br>
        <input type="radio" name="gender" value="male" <?php if($row['gender'] == 'male') echo 'checked'; ?> required> Male
        <input type="radio" name="gender" value="female" <?php if($row['gender'] == 'female') echo 'checked'; ?> required> Female
      </div>

      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" name="email" value="<?php echo $row['email']; ?>" required>
      </div>

      <div class="form-group">
        <label for="phone_number">Phone Number:</label>
        <input type="tel" class="form-control" name="phone_number" value="<?php echo $row['phone']; ?>" required>
      </div>

      <div class="form-group">
        <label for="address">Address:</label>
        <textarea class="form-control" name="address" required><?php echo $row['address']; ?></textarea>
      </div>

      <button type="submit" class="btn btn-primary btn-block">Save</button>
      <a href="studentdetails.php?student_id=<?php echo $student_id; ?>" class="btn btn-secondary btn-block mb-2">Cancel</a>
    </form>
  </div>
</body>
</html>
