<?php
	session_start();
	if($_SESSION['sid'] == session_id() && $_SESSION['user'] == "admin")
	{
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Leave</title>
<style>
#content_panel form label > span {
	width: 130px;
}
#content_panel form input[type="submit"]{
	margin-left: 195px;
}
</style>
<link href="../style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="container">
  <div id="header">
    <div id="title">Leave Management System</div>
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
    <div id="heading">Hello Admin<hr size="2" color="#FFFFFF" />
</div>
   
  </div>
  <div id="side_bar">
  	<ul>
    	<li class="menu_head">Controls</li>
        <li><a href="add_staff.php">Add Staff</a></li>
        <li><a href="search_staff_for_updation.php">Update Staff</a></li>
        <li><a href="search_staff_for_deletion.php">Delete Staff</a></li>
    	<li><a href="add_leave.php">Add Leave</a></li>
        <li><a href="delete_leave_type.php">Delete Leave</a></li>
        <li><a href="search_staff_to_assign_pc.php">Assign Leave Approver</a></li>
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
?>
