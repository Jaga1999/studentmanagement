<!DOCTYPE html>
<html>
<head>
	<title>Registration Successful</title>
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
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<h1>Registration Successful</h1>
		<?php if ($_GET['source'] === 'register'): ?>
		<p class="alert alert-success">Thank you for registering with our Student Management System. Your registration is now complete.</p>
		<?php elseif ($_GET['source'] === 'adduser'): ?>
		<p class="alert alert-success">You can now login to the system using your username and password.</p>
		<?php endif; ?>
		 <form method="post">
            <button type="submit" name="redirectButton" class="btn btn-primary">Continue</button>
        </form>
    </div>
	</div>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
<?php
session_start();
if (isset($_POST['redirectButton'])) {
    if (isset($_SESSION['username'])) {
        header('Location: index.php');
    } else {
        header('Location: login.php');
    }
}
?>