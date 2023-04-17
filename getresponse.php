<?php
include 'dbconnect.php';

// Check if username and password were provided
if (isset($_POST["username"]) && isset($_POST["password"])) {
  $c_username = $_POST["username"];
  $c_password = $_POST["password"];

  // prepare query using prepared statement
  $stmt = mysqli_prepare($conn, "SELECT * FROM c_login WHERE c_username=? AND c_password=?");
  mysqli_stmt_bind_param($stmt, "ss", $c_username, $c_password);

  // execute query
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if (mysqli_num_rows($result) > 0) {
    // Successfully logged in
    echo "success";
  } else {
    // Login failed
    echo "fail";
  }
  mysqli_stmt_close($stmt);
}

// Check if a question was provided
if (isset($_GET["q"])) {
    $q = $_GET["q"];
    $response = "";
  
    if ($q != "") {
      // prepare query using prepared statement
      $search = "%$q%";
      $stmt = mysqli_prepare($conn, "SELECT answer FROM faq WHERE question LIKE ?");
      mysqli_stmt_bind_param($stmt, "s", $search);
  
      // execute query
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
  
      if (mysqli_num_rows($result) > 0) {
        // fetch answer from database
        $row = mysqli_fetch_assoc($result);
        $response = $row['answer'];
      } else {
        $noresponse = "Sorry, I'm still learning. Hence my responses are limited. Ask something else.";
        $response = $noresponse;
      }
      mysqli_stmt_close($stmt);
    }
  
    echo $response;
  }
  

// close database connection
mysqli_close($conn);
?>
