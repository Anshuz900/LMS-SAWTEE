<?PHP
	$leave_type = $_GET['leave_type'];
	$connection = @mysqli_connect("localhost", "root", "","lms") or die(mysqli_connect_error());
	$sql1 = "DELETE FROM lms.leave_types WHERE leave_type = '".$leave_type."'";
	$sql2 = "DELETE FROM lms.leave_requests WHERE leave_type = '".$leave_type."'";
	$sql3 = "DELETE FROM lms.leave_statistics WHERE leave_type = '".$leave_type."'";
	echo 	"<script>
				alert(\"Do you really want to delete Leave Type = ".$leave_type."\");
			</script>";
	mysqli_query($connection, $sql1);
	mysqli_query($connection, $sql2);
	mysqli_query($connection, $sql3);
	echo "<script>window.location=\"delete_leave_type.php\";</script>";
	//header ("Location: delete_staff.php"); 
	mysqli_close($connection);

?> 