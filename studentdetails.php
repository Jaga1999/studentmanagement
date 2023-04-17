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
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<style>
		table, th, td {
  			border: 1px solid black;
  			border-collapse: collapse;
		}
		th, td {
  			padding: 5px;
  			text-align: left;
		}
		a{
			margin-right : 5px;
			border-radius: 5px;
		}
		.btn-group {
			margin-right: 5px;
			margin-bottom: 5px;
		}
		.action-col {
			width: 100px;
			padding: 2px 8px;
			vertical-align: middle;
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
		<h1 class="text-center">Student Details</h1>
		<?php
			function displayAlert($type, $message) {
				$class = $type === 'success' ? 'alert-success' : 'alert-danger';
				?>
				<div id="myAlert" class="alert <?php echo $class;?> alert-dismissible fade show" role="alert">
					<?php echo $message;?>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<script> setTimeout(()=>document.getElementById("myAlert").style.display="none", 3000); </script>
				<?php
			}

			if (isset($_SESSION['alert'])) {
				displayAlert('danger', $_SESSION['alert']);
				unset($_SESSION['alert']);
			}
			if (isset($_SESSION['success_msg'])){
				displayAlert('success', $_SESSION['success_msg']);
				unset($_SESSION['success_msg']);
			}
			if (isset($_SESSION['error_msg'])){
				displayAlert('danger', $_SESSION['error_msg']);
				unset($_SESSION['error_msg']);
			}
			include_once 'dbconnect.php';
			$sql = "SELECT * FROM students";
			$result = mysqli_query($conn, $sql);
			if (mysqli_num_rows($result) > 0) { ?>
			<div class='table-responsive'>
				<table class='table'>
					<thead class='thead-dark'>
						<tr>
							<th>Name</th>
							<th>Date of Birth</th>
							<th>Gender</th>
							<th>Phone Number</th>
							<th>Address</th>
							<th class='action-col'>Actions</th>
						</tr>
					</thead>
					<?php while ($row = mysqli_fetch_assoc($result)) { ?>
					<tr>
						<td><?php echo $row['stu_name']; ?></td>
						<td><?php echo $row['dob']; ?></td>
						<td><?php echo $row['gender']; ?></td>
						<td><?php echo $row['phone']; ?></td>
						<td><?php echo $row['address']; ?></td>
						<td class='action-col'>
							<div class='btn-group' role='group'>
								<a href="viewdetails.php?student_id=<?php echo $row['student_id']; ?>" class='btn btn-info'>View Details</a>
								<a href="editpersonaldetails.php?student_id=<?php echo $row['student_id']; ?>" class='btn btn-primary'>Edit Personal</a>
							</div>
							<div class='btn-group' role='group'>
								<a href="editparentsdetails.php?student_id=<?php echo $row['student_id']; ?>" class='btn btn-primary'>Edit Parents</a>
								<a href="editeducationdetails.php?student_id=<?php echo $row['student_id']; ?>" class='btn btn-primary'>Edit Previous Education</a>
							</div>
						</td>
					</tr> <?php } ?>
				</table>
			</div>
		<div class='col-md-12 text-center'> 
			<a href='index.php' class='btn btn-primary mb-2'>Back</a>
		</div>
		<?php if (mysqli_num_rows($result) == 0) { echo "No students found.";} } mysqli_close($conn); ?>
	</div>
</body>
</html>
