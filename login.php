<?php
session_start();
include_once 'dbconnect.php';
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM login WHERE username=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // verify the hashed password with the user's input
        if (password_verify($password, $row['password'])) {

            $_SESSION['username'] = $username;

            if ($row['access_level'] == 1) {
                $_SESSION['is_admin'] = 1;
            }else {
                $_SESSION['is_admin'] = 2;
            }
            
            header("Location: index.php");
            exit();
        } else {
            $error_msg = "Invalid password";
        }
    } else {
        $error_msg = "Invalid username";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        h2 {
            margin-top: 50px;
            margin-bottom: 30px;
            text-align: center;
        }

        form {
            margin: 0 auto;
            max-width: 400px;
        }

        label {
            font-weight: bold;
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
        }

        .btn-login {
            display: block;
            margin: 0 auto;
        }

        @media (min-width: 576px) {
            .btn-login {
                width: 100%;
                max-width: 400px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php
        if (isset($error_msg)) {
            echo "<div class='alert alert-danger' role='alert' id='error-message'>$error_msg</div>"; ?>
            <script>setTimeout(() => document.getElementById('error-message')?.remove(), 3000);</script>
        <?php } ?>
        <form method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-login" name="login">Login</button>
            <p class="register-link">Don't have an account? <a href="adduser.php?access_level=2">Register now</a></p>
        </form>
    </div>
    <?php require_once "chatbot.html"; ?>
    
</body>
</html>

