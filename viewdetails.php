<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Student Details</title>
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
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<?php
if(isset($_GET["student_id"]) && !empty(trim($_GET["student_id"]))) {
    include_once 'dbconnect.php';
    $sql = "SELECT * FROM students LEFT JOIN parents ON students.student_id = parents.student_id LEFT JOIN education ON students.student_id = education.student_id WHERE students.student_id = ?;";
    
    if($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $param_id);
        
        $param_id = trim($_GET["student_id"]);
        
        if($stmt->execute()) {
            $result = $stmt->get_result();
            
            if($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                
                ?>
                <div class="container mt-5">
                    <div class="row">
                        <div class="col-sm-12 col-md-4">
                            <h2>Student Details</h2>
                            <div class="table-responsive">
                                <table class="table">
                                    <tr><td><b>Name:</b></td><td><?php echo $row["stu_name"]; ?></td></tr>
                                    <tr><td><b>Date of Birth:</b></td><td><?php echo $row["dob"]; ?></td></tr>
                                    <tr><td><b>Gender:</b></td><td><?php echo $row["gender"]; ?></td></tr>
                                    <tr><td><b>Email:</b></td><td><?php echo $row["email"]; ?></td></tr>
                                    <tr><td><b>Phone Number:</b></td><td><?php echo $row["phone"]; ?></td></tr>
                                    <tr><td><b>Address:</b></td><td><?php echo $row["address"]; ?></td></tr>
                                </table>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4">
                            <h2>Parent Details</h2>
                            <div class="table-responsive">
                                <table class="table">
                                    <tr><td><b>Parent Name:</b></td><td><?php echo $row["par_name"]; ?></td></tr>
                                    <tr><td><b>Occupation:</b></td><td><?php echo $row["occupation"]; ?></td></tr>
                                    <tr><td><b>Parent Phone:</b></td><td><?php echo $row["par_phone"]; ?></td></tr>
                                    <tr><td><b>Parent Email:</b></td><td><?php echo $row["par_email"]; ?></td></tr>
                                </table>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4">
                            <h2>Education Details</h2>
                            <div class="table-responsive">
                                <table class="table">
                                    <tr><td><b>Institution Name:</b></td><td><?php echo $row["institution_name"]; ?></td></tr>
                                    <tr><td><b>Course/Class Name:</b></td><td><?php echo $row["course_name"]; ?></td></tr>
                                    <tr><td><b>Year of Passing:</b></td><td><?php echo $row["year_of_passing"]; ?></td></tr>
                                    <tr><td><b>Percentage/Grade Obtained:</b></td><td><?php echo $row["grade_obtained"]; ?></td></tr>
                                    <tr><td><b>Board/University:</b></td><td><?php echo $row["board"] . "</td></tr>"; ?></td></tr>
                                </table>
                            </div>
                        </div>
                    <div class='col-md-12 text-center'> 
                        <a href='studentdetails.php' class='btn btn-primary'>Back</a>
                    </div>
                </div>
            </div>
            <?php } else { ?>
               <p>No records found.</p>
           <?php }
        } else { 
            echo "Error: " . $conn->error;
        }
        $stmt->close();
    }
    $conn->close();
}?>
</body>
</html>