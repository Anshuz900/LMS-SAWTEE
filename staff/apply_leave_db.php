<?PHP

	session_start();
	$staff_id = $_SESSION['staff_id'];
	$leave_duration = $_POST['leave_duration'];
	$leave_type = $_POST['leave_type'];
	$leave_date = $_POST['leave_date'];
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];
	$no_of_days = isset($_POST['days_requested']) ? (int)$_POST['days_requested'] : 0;

	$status = "Pending";
	
	$connection = @mysqli_connect("localhost", "root", "","lms") or die(mysqli_connect_error());
	
	$sql4 = "SELECT * FROM lms.leave_statistics WHERE staff_id = '".$staff_id."' AND leave_type = '".$leave_type."'";
	$result4 = mysqli_query($connection, $sql4) or die(mysqli_connect_error());
	while($row4 = mysqli_fetch_array($result4))
	{
		$maximum_leaves = (int)$row4['maximum_leaves'];
        $leaves_taken = (int)$row4['leaves_taken'];

	}
	$new = (int)$leaves_taken + (int)$no_of_days;
	$balance_leaves = (int)$maximum_leaves - (int)$leaves_taken;

	
	if($no_of_days > $maximum_leaves)
	{
		echo	"<script>
				alert('Maximum ".$maximum_leaves." Days Allowed.');
				window.location=\"apply_leave.php\";</script>";
	}
	if($new > $maximum_leaves)
	{
		echo	"<script>
				alert('You have already taken " .$leaves_taken." leaves, Now you only request only for ".$balance_leaves." days');
				window.location=\"apply_leave.php\";</script>";
	}
	else
	{
	
		if($leave_duration == "one_day")
		{
			$sql = "SELECT * FROM lms.leave_requests WHERE start_date = '".$leave_date."' AND end_date = '".$leave_date."' AND staff_id = '".$staff_id."'";
			$result = mysqli_query($connection, $sql) or die(mysqli_error());
			if(mysqli_num_rows($result) == 0 )
			{
				$sql3 = "INSERT INTO lms.leave_requests VALUES ('".$staff_id."', '".$leave_type."', '".$leave_date."', '".$leave_date."', '1', '".date("Y-m-d")."', '".$status."')";
				mysqli_query($connection, $sql3) or die(mysqli_error());
			echo	"<script>
					alert(\"Leave Request Submitted.\");
					window.location=\"apply_leave.php\";</script>";
			}
			else
			{
				echo	"<script>
					alert(\"You have already taken a leave for these days !.\");
					window.location=\"apply_leave.php\";</script>";
			}
		}
		
		else if($leave_duration == "multiple_days")
		{
			$sql1 = "SELECT start_date, end_date FROM lms.leave_requests WHERE  '".$start_date."' BETWEEN start_date AND end_date AND staff_id = '".$staff_id."'";
		
			$sql2 = "SELECT start_date, end_date FROM lms.leave_requests WHERE  '".$end_date."' BETWEEN start_date AND end_date AND staff_id = '".$staff_id."'";
		
			$result1 = mysqli_query($connection, $sql1) or die(mysqli_error());
			$result2 = mysqli_query($connection, $sql2) or die(mysqli_error());
		
			if(mysqli_num_rows($result1) == 0 && mysqli_num_rows($result2) == 0)
			{
				
				$sql3 = "INSERT INTO lms.leave_requests VALUES ('".$staff_id."', '".$leave_type."', '".$start_date."', '".					$end_date."', '".$no_of_days."', '".date("Y-m-d")."', '".$status."')";
				mysqli_query($connection, $sql3) or die(mysqli_error());
			echo	"<script>
					alert(\"Leave Request Submitted.\");
					window.location=\"apply_leave.php\";</script>";
			}
			else
			{
				echo	"<script>
							alert(\"You have already taken a leave for these days !.\");
							window.location=\"apply_leave.php\";</script>";
			}
		}
	}
	
	mysqli_close($connection);
	
	
?>