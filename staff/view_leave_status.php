<?PHP
	session_start();
	if($_SESSION['sid'] == session_id() && $_SESSION['user'] == "Staff")
	{	
		$staff_id = $_SESSION['staff_id'];
		
		$connection = @mysqli_connect("localhost", "root", "","lms") or die(mysqli_connect_error());
		
		$sql = "SELECT * FROM lms.leave_requests WHERE staff_id = '".$staff_id."' AND leave_status = 'Pending'";
		
		$result = mysqli_query($connection, $sql);
		
		if(mysqli_num_rows($result)==0)
		{
			echo 	"<script>
					alert(\"No Leave History to Show!\");
					window.location=\"view_leave_history.php\";</script>";
		}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View Leave Status</title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-image: url(../images/bg.gif);
}
</style>
<link href="../style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="container">
  <div id="header">
    <div id="title">SOUTH ASIA WATCH ON TRADE, ECONOMICS AND ENVIRONMENT</div>
    <div id="quick_links">
      <ul>
        <li><a class="home" href="index.php">Home</a></li>
        <li>|</li>
        
        <li><a class="logout" href="../logout.php">Logout</a></li>
        <li>|</li>
        <li><a class="greeting" href="#">Hi <?php echo $_SESSION['user']; ?></a></li>
      </ul>
    </div>
  </div>
  <div id="content_panel">
    <div id="heading">Applied Leave Status<hr size="2" color="#FFFFFF" ice:repeating=""/></div>
    <div id="table">
    	<span><table border="1" bgcolor="#006699" >
				<tr>
					<th width="120px">Leave Type</th>
					<th width="120px">Start Date</th>
					<th width="120px">End Date</th>
					<th width="120px">No. of Days</th>
					<th width="120px">Date Applied</th>
					<th width="120px">Status</th>
				</tr>
			</table></span>
     <?PHP
		while($row = mysqli_fetch_array($result))
		{
			$leave_type = $row['leave_type'];
			$start_date = $row['start_date'];
			$end_date = $row['end_date'];
			$no_of_days = $row['days_requested'];
			$date_applied = $row['date_applied'];
			$status = $row['leave_status'];
			
			echo "<table border=\"1\">
					<tr>
						<td width=\"120px\">".$leave_type."</td>
						<td width=\"120px\">".$start_date."</td>
						<td width=\"120px\">".$end_date."</td>
						<td width=\"120px\">".$no_of_days."</td>
						<td width=\"120px\">".$date_applied."</td>
						<td width=\"120px\">".$status."</td>
					</tr>
				</table>";
		}
	?>
    </table>
    </label>
  </div>
  </div>
  <div id="side_bar">
  	<ul>
    	    <li class="menu_head">Controls</li>
		    <li><a href="apply_half_leave.php">Apply Half Leave</a></li>
            <li><a href="apply_leave.php">Apply Leave</a></li>
            <li><a href="apply_program.php">Program Attaindance</a></li>
            <li><a href="view_leave_history.php">View Leave History</a></li>
            <li><a href="view_leave_status.php">View Leave Status</a></li>
            <li><a href="program_status.php">View Program Status</a></li>
            <li><a href="view_profile.php">View Profile</a></li>				
    </ul>
  </div>
  <div id="footer">
    <p style="color:white;" align="center"><br />Leave Management System</p>
    <p style="color:white;" align="center"><br />&copy;2025 SAWTEE, P.O. Box: 19366, Tukucha Marg, Baluwatar, Kathmandu, Nepal</p>
    <p style="color:white;" align="center"><br />Tel: +977 1 4544438 / 4524360, Fax: +977 1 4544570, Email: sawtee@sawtee.org</p>
  </div>
</div>
</body>
</html>
<?php
	}
	else
	{
		header("Location: ../index.html");
	}
	mysqli_close($connection);
?>
