<?php
session_start();
$staff_id = $_SESSION['staff_id'];
$program_type = $_POST['program_type'] ?? '';
$start_time = $_POST['start_time'] ?? '';
$end_time = $_POST['end_time'] ?? '';
$status = "Pending";

// Database connection
$connection = @mysqli_connect("localhost", "root", "", "lms") or die(mysqli_connect_error());

// Insert program application
$insert_sql = "INSERT INTO program_applications (staff_id, program_type, start_time, end_time, status) 
VALUES ('$staff_id', '$program_type', '$start_time', '$end_time', '$status')";
mysqli_query($connection, $insert_sql) or die(mysqli_error($connection));

echo "<script>
alert('Program Application Submitted Successfully.');
window.location=\"apply_program.php\";</script>";

mysqli_close($connection);
?>
