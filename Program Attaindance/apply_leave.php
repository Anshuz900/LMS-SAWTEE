<?php
session_start();
$staff_id = $_SESSION['staff_id'];
$leave_duration = $_POST['leave_duration'] ?? '';
$leave_date = $_POST['leave_date'] ?? '';
$status = "Pending";
$program_attendance = $_POST['program_attendance'] ?? ''; // New field for program attendance
$connection = @mysqli_connect("localhost", "root", "", "lms") or die(mysqli_connect_error());

// Determine half-day type and set leave type accordingly
if ($leave_duration == "first_half") {
    $half_day_type = "First Half";
    $leave_type = "First Half Leave";
} elseif ($leave_duration == "second_half") {
    $half_day_type = "Second Half";
    $leave_type = "Second Half Leave";
} else {
    $half_day_type = "";
    $leave_type = "Full Day Leave";
}

// Leave balance check (optional, depending on usage)
$sql4 = "SELECT * FROM lms.leave_statistics WHERE staff_id = '$staff_id' AND leave_type = '$leave_type'";
$result4 = mysqli_query($connection, $sql4);

// Check for existing leave on the same day
$check_sql = "SELECT * FROM lms.leave_requests 
              WHERE staff_id = '$staff_id' 
              AND start_date = '$leave_date' 
              AND end_date = '$leave_date'";
$check_result = mysqli_query($connection, $check_sql) or die(mysqli_error($connection));

// Ensure the leave date is not in the past and no existing leave on the same day
$current_date = date("Y-m-d");
if ($leave_date >= $current_date && mysqli_num_rows($check_result) == 0) {
    // Insert leave or program attendance
    $insert_sql = "INSERT INTO lms.leave_requests 
                   (staff_id, leave_type, start_date, end_date, date_applied, leave_status, half_day_type, program_attendance)
                   VALUES 
                   ('$staff_id', '$leave_type', '$leave_date', '$leave_date', '$current_date', '$status', '$half_day_type', '$program_attendance')";
    mysqli_query($connection, $insert_sql) or die(mysqli_error($connection));
    echo "<script>
            alert('Request Submitted Successfully.');
            window.location=\"apply_half_leave.php\";
          </script>";
} else {
    echo "<script>
            alert('You have already applied for leave on this date or the date is in the past.');
            window.location=\"apply_half_leave.php\";
          </script>";
}

mysqli_close($connection);
?>