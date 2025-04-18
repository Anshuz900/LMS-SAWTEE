<?php
session_start();
if ($_SESSION['sid'] == session_id() && $_SESSION['user'] == "Staff") {
    $connection = @mysqli_connect("localhost", "root", "", "lms") or die(mysqli_connect_error());
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Program Attendance</title>
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
<script type="text/javascript" src="../jquery.js"></script>
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
        <div id="heading">Program Attendance<hr size="2" color="#FFFFFF" /></div>
        <form action="apply_program_db.php" method="post">
            <label for="program_type"><span>Program Type<span class="required">*</span></span>
                <input type="text" name="program_type" id="program_type" required />
            </label>
            <label for="start_time"><span>Start Time<span class="required">*</span></span>
                <input type="datetime-local" name="start_time" id="start_time" required />
            </label>
            <label for="end_time"><span>End Time<span class="required">*</span></span>
                <input type="datetime-local" name="end_time" id="end_time" required />
            </label>
            <div class="button">
                <label>
                    <input type="submit" value="Submit Request" id="submit" />
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
