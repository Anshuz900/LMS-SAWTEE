<?PHP
	// Retrieving values from textboxes
	
	$first_name = $_POST['first_name'];
	$middle_name = $_POST['middle_name'];
	$last_name = $_POST['last_name'];
	$email_id = $_POST['email_id'];
	$password = $_POST['password'];
	$user_type = "Staff";
	
	// Initializing the values, following DRY (Don't Repeat Yourself) Approach
	
	// Obtaining connection using DSN and ODBC
	$connection = mysqli_connect("localhost", "root", "", "lms") or die(mysqli_connect_error());

	
	// Sql query
	$sql1 = "SELECT staff_id FROM lms.staff WHERE staff_id = '".$email_id."' ";
	
	$sql2 = "INSERT INTO lms.staff (staff_id, first_name, middle_name, last_name) VALUES ('$email_id','$first_name', '$middle_name', '$last_name')";
	$sql3 = "INSERT INTO lms.login (user_id, password, user_type) VALUES ('$email_id', '$password', '$user_type')"; 
	//$sql4 = "INSERT INTO leave_statistics (staff_id) VALUES ('$email_id')";
	$sql5 = "SELECT * FROM lms.leave_types";
	$result4 = mysqli_query($connection, $sql5);

	$result1 = mysqli_query($connection, $sql1);
	$row = mysqli_fetch_array($result1);
	if($row == 0)
	{
		// Firing query
		$result2 = mysqli_query($connection, $sql2);
		$result3 = mysqli_query($connection, $sql3);
		while($row4 = mysqli_fetch_array($result4))
		{
			$leave_type = $row4['leave_type'];
			$no_of_days = $row4['no_of_days'];
			$sql4 = "INSERT INTO lms.leave_statistics (staff_id, leave_type, maximum_leaves) VALUES ('$email_id', '$leave_type', '$no_of_days')";
			mysqli_query($connection, $sql4) or die(mysqli_error());
		}
		echo 	"<script>
					alert(\"Staff added.\");
				</script>";
		
		echo "<script>window.location=\"add_staff.php\";</script>";
	}
	else
	{
		echo 	"<script>
					alert(\"Staff ID already exist, Please use differen Email ID.\");
				</script>";
		echo "<script>window.location=\"add_staff.php\";</script>";
	}
		
	
	// Closing Connection
	mysqli_close($connection);
	
?>