<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

include_once 'dbconnect.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $required_fields = ['name', 'dob', 'gender', 'email', 'phone', 'address', 'parent_name', 'occupation', 'parent_phone', 'parent_email', 'institution_name', 'course_name', 'year_of_passing', 'grade_obtained', 'board'];
    $valid_input = true;

    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $valid_input = false;
            break;
        }
    }

    if ($valid_input) {
        $insert_student_query = "INSERT INTO students (stu_name, dob, gender, email, phone, address) VALUES ('{$_POST['name']}', '{$_POST['dob']}', '{$_POST['gender']}', '{$_POST['email']}', '{$_POST['phone']}', '{$_POST['address']}')";
        $conn->query($insert_student_query);
        $student_id = mysqli_insert_id($conn);

        $insert_parent_query = "INSERT INTO parents (par_name, occupation, par_phone, par_email, student_id) VALUES ('{$_POST['parent_name']}', '{$_POST['occupation']}', '{$_POST['parent_phone']}', '{$_POST['parent_email']}', $student_id)";
        $conn->query($insert_parent_query);

        $insert_education_query = "INSERT INTO education (institution_name, course_name, year_of_passing, grade_obtained, board, student_id) VALUES ('{$_POST['institution_name']}', '{$_POST['course_name']}', '{$_POST['year_of_passing']}', '{$_POST['grade_obtained']}', '{$_POST['board']}', $student_id)";
        $conn->query($insert_education_query);

        header("Location: sucess.php?source=register");
        exit;
    } else {
        $error_msg = "All fields are required.";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Multi-Level Form Example</title>
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
</head>

<body>
    <div class="container my-5">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Registration</h4>
                        <?php
                            if (isset($error_msg)) {
                                echo "<div class='alert alert-danger' role='alert' id='error-message'>$error_msg</div>"; ?>
                                <script>setTimeout(() => document.getElementById('error-message')?.remove(), 3000);</script>
                        <?php } ?>
                        <hr />
                        <div class="progress mb-3">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 0%">
                            </div>
                        </div>
                        <form id="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" >
                            <fieldset id="step1" data-progress="0">
                                <h4 class="card-title">Personal Details</h4>
                                <div class="form-group">
                                    <label for="name">Name:</label>
                                    <input type="text" class="form-control" id="name" name="name" required />
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label for="dob">Date of Birth:</label>
                                    <input type="date" class="form-control" id="dob" name="dob" required />
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label for="gender">Gender:</label>
                                    <select class="form-control" id="gender" name="gender" required>
                                        <option value="">Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" id="email" name="email" required />
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone Number:</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" required />
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label for="address">Address:</label>
                                    <textarea class="form-control" id="address" name="address" required></textarea>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <button class="btn btn-primary next-step btn-block" data-step="step2">
                                    Next
                                </button>
                                
                            </fieldset>
                            <fieldset id="step2" data-progress="33" style="display: none">
                                <h4 class="card-title">Parents Details</h4>
                                <div class="form-group">
                                    <label for="parent_name">Name:</label>
                                    <input type="text" class="form-control" id="parent_name" name="parent_name" required />
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label for="occupation">Occupation:</label>
                                    <input type="text" class="form-control" id="occupation" name="occupation" required />
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label for="parent_phone">Phone Number:</label>
                                    <input type="tel" class="form-control" id="parent_phone" name="parent_phone" required />
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label for="parent_email">Email:</label>
                                    <input type="email" class="form-control" id="parent_email" name="parent_email" required />
                                    <div class="invalid-feedback"></div>
                                </div>
                                <button class="btn btn-primary next-step btn-block" data-step="step3">
                                    Next
                                </button>
                                <button class="btn btn-secondary prev-step mr-3 btn-block" data-step="step1">
                                    Back
                                </button>
                            </fieldset>
                            <fieldset id="step3" style="display: none" data-progress="66">
                                <h4 class="card-title">Previous Education</h4>
                                <div class="form-group">
                                    <label for="institution_name">Institution Name:</label>
                                    <input type="text" class="form-control" id="institution_name" name="institution_name"
                                        required />
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label for="course_name">Course Name/Class:</label>
                                    <input type="text" class="form-control" id="course_name" name="course_name" required />
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label for="year_of_passing">Year Of Passing:</label>
                                    <input type="text" class="form-control" id="year_of_passing" name="year_of_passing" required />
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label for="grade_obtained">Percentage/Grade:</label>
                                    <input type="text" class="form-control" id="grade_obtained" name="grade_obtained" required />
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label for="board">Board/University:</label>
                                    <input type="text" class="form-control" id="board" name="board" required />
                                    <div class="invalid-feedback"></div>
                                </div>
                                <button type="submit" class="btn btn-success submit-form btn-block" value="submit">
                                    Submit
                                </button>
                                <button class="btn btn-secondary prev-step mr-3 btn-block" data-step="step2">
                                    Back
                                </button>
                                    
                            </fieldset>
                        </form>
                        <div class="d-flex justify-content-center ">
                            <button class="btn btn-danger mt-2 btn-block" onclick="window.location.href='index.php'">
                              Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>
</body>

</html>