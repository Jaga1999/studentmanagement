<?php  
include_once 'dbconnect.php';
if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
	$email = $_POST['email'];
    $access_level = $_POST['access_level'];
    $sql = "SELECT * FROM login WHERE username = '$username'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      	$_SESSION['alert'] = "User already exists!";
    } else {
        // hash the password using bcrypt algorithm and default cost (currently 10)
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO login (username, password, email, access_level) VALUES ('$username', '$hashed_password', '$email', '$access_level');";

        if ($conn->query($sql) === TRUE) {
            header('Location: sucess.php?source=adduser');
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Add User</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<style>
		h2 {
			margin-top: 25px;
			margin-bottom: 20px;
			text-align: center;
		}
		form {
			margin: 0 auto;
			max-width: 400px;
		}
		label {
			font-weight: bold;
		}
		::-webkit-scrollbar {
        display: none;
        }
       
    	*{
      		scrollbar-width: none;
      		-ms-overflow-style: none;
    	}
	</style>
</head>
<body>
	<div class="container">
	<h2>Add User</h2>
    <?php
    if(isset($_SESSION['alert'])){ ?>
    	<div id="myAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
			<?php echo $alert_message; ?>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
      	</div>
      	<?php unset($_SESSION['alert']); ?>
      	<script> setTimeout(() => document.getElementById("myAlert").style.display = "none", 3000); </script>
	<?php } ?>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
		<div class="form-group">
			<label for="username">Username:</label>
			<input type="text" class="form-control" id="username" name="username" required>
		</div>
		<div class="form-group">
			<label for="password">Password:</label>
			<input type="password" class="form-control" id="password" name="password" required>
		</div>
		<div class="form-group">
			<label for="retype_password">Retype Password:</label>
			<input type="password" class="form-control" id="retype_password" name="retype_password" required>
			<span id='message' class='alert-danger'></span>
		</div>
		<div class="form-group">
			<label for="email">Email:</label>
			<input type="email" class="form-control" id="email" name="email" required>
		</div>
		<div class="form-group">
			<label for="access_level">Access Level:</label>
			<select class="form-control" id="access_level" name="access_level">
				<?php session_start(); if($_SESSION['is_admin'] == '1') { ?>
					<option value="1">Admin</option>
					<option value="2">Staff</option>
				<?php } else { ?>
					<option value="2">Staff</option>
				<?php } ?>
			</select>
		</div>
		<div class="row">
			<div class="col-md-6 mb-3">
				<button type="submit" class="btn btn-primary btn-block" name="submit" id="submitBtn" disabled>Add User</button>
			</div>
			<div class="col-md-6">
				<a href="<?php
					if (!isset($_SESSION['username'])) {
						echo 'login.php';
					} else {
						echo 'index.php';
					}
				?>" class="btn btn-secondary btn-block">Cancel</a>
			</div>
		</div>
	</form>
	<script>
		var password = document.getElementById("password");
		var retypePassword = document.getElementById("retype_password");
		var message = document.getElementById('message');
		var submitBtn = document.getElementById('submitBtn');

		function validatePassword() {
			if (password.value != retypePassword.value) {
				message.innerHTML = "Passwords do not match!";
				submitBtn.disabled = true;
			} else {
				message.innerHTML = "";
				submitBtn.disabled = false;
			}
		}
		retypePassword.addEventListener('blur', validatePassword);
	</script>
	</div>
</body>
</html>
