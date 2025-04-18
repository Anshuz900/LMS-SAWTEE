<?PHP
	session_start();
	if($_SESSION['sid'] == session_id() && $_SESSION['user'] == "Staff")
	{
		$connection = @mysqli_connect("localhost", "root", "", "lms") or die(mysqli_connect_error());
		$sql = "SELECT * FROM lms.leave_types";
		$result = mysqli_query($connection, $sql);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Apply Half Leave</title>
<style>
body {
	margin: 0;
	background-image: url(../images/bg.gif);
}
</style>
<link href="../style.css" rel="stylesheet" type="text/css" />
<script src="../jquery.js"></script>
<script>
$(document).ready(function(){
	$('input[type="radio"]').click(function(){
		if($(this).val() === "first_half"){
			$(".first_half_leave").show();
			$(".second_half_leave").hide();
			$(".leave_type").show();
			$(".button").show();
		}
		if($(this).val() === "second_half"){
			$(".second_half_leave").show();
			$(".first_half_leave").hide();
			$(".leave_type").show();
			$(".button").show();
		}
	});

	if(!$("input[type=radio][name='half_day_type']:checked").val()){
		$(".first_half_leave").hide();
		$(".second_half_leave").hide();
		$(".leave_type").hide();
		$(".button").hide();
	}
});
</script>
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
		<div id="heading">Apply Half Leave<hr size="2" color="#FFFFFF" /></div>
		<form action="apply_half_leave_db.php" method="post">
			
			<label for="half_day_type"><span>Select Half Day <span class="required">*</span></span>
			        <input type="radio" value="first_half" name="leave_duration" /> First Half
                    <input type="radio" value="second_half" name="leave_duration" /> Second Half

			</label>
			
						<div class="first_half_leave">
				<label for="leave_date"><span>Date (First Half) <span class="required">*</span></span>
					<input type="date" name="leave_date_first" id="leave_date_first" />
				</label>
			</div>

			<div class="second_half_leave">
				<label for="leave_date"><span>Date (Second Half) <span class="required">*</span></span>
					<input type="date" name="leave_date_second" id="leave_date_second" />
				</label>
			</div>

			<div class="button">
				<label>
					<input type="submit" value="Submit Request" id="submit"/>
				</label>
			</div>
		</form>
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
	} else {
		header("Location: ../index.html");
	}
	mysqli_close($connection);
?>
