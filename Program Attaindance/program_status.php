<?php
session_start();
$staff_id = $_SESSION['staff_id'];

// Database connection
$connection = @mysqli_connect("localhost", "root", "", "lms") or die(mysqli_connect_error());

// Retrieve program applications
$sql = "SELECT program_type, start_time, end_time, status FROM program_applications WHERE staff_id = '$staff_id'";
$result = mysqli_query($connection, $sql) or die(mysqli_error($connection));

if(mysqli_num_rows($result) == 0) {
    echo "<script>
    alert('No Program Applications to Show!');
    window.location='index.php';</script>";
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View Program Applications</title>
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
        <div id="heading">Program Applications<hr size="2" color="#FFFFFF" /></div>
        <div id="table">
            <span><table border="1" bgcolor="#006699">
                <tr>
                    <th width="120px">Program Type</th>
                    <th width="120px">Start Time</th>
                    <th width="120px">End Time</th>
                    <th width="120px">Status</th>
                </tr>
            </table></span>
            <?php
            while($row = mysqli_fetch_array($result)) {
                $program_type = $row['program_type'];
                $start_time = $row['start_time'];
                $end_time = $row['end_time'];
                $status = $row['status'];
                
                echo "<table border=\"1\">
                    <tr>
                        <td width=\"120px\">$program_type</td>
                        <td width=\"120px\">$start_time</td>
                        <td width=\"120px\">$end_time</td>
                        <td width=\"120px\">$status</td>
                    </tr>
                </table>";
            }
            ?>
        </div>
    </div>
    <div id="side_bar">
        <ul>
            <li class="menu_head">Controls</li>
            <li><a href="apply_half_leave.php">Apply Half Leave</a></li>
            <li><a href="apply_leave.php">Apply Leave</a></li>
            <li><a href="apply_leave.php">Program Attaindance</a></li>
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