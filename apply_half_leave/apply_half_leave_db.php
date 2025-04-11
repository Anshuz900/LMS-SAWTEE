<?php
session_start();

$staff_id = $_SESSION['staff_id'];
$leave_duration = $_POST['leave_duration'] ?? '';
$leave_date = $_POST['leave_date'] ?? '';

$status = "Pending";

$connection = @mysqli_connect("localhost", "root", "", "lms") or die(mysqli_connect_error());


// Determine half-day type and set leave type accordingly
if ($leave_duration == "first_half") {
  $half_day_type = "First Half";
  $leave_type = "First Half Leave";
} 
else {
  $half_day_type = "Second Half";
  $leave_type = "Second Half Leave";
}

// Leave balance check (optional, depending on usage)
$sql = "SELECT * FROM lms.leave_statistics WHERE staff_id = '$staff_id' AND leave_type = '$leave_type'";
$result = mysqli_query($connection, $sql);
 
//-----------------------*********---------------------
// change != to ==
if (mysqli_num_rows($result) != 0) {
    echo "<script>
            alert('Leave type not found or not eligible.');
            window.location='apply_half_leave.php';
          </script>";
    exit();
}

$row = mysqli_fetch_assoc($result);
$maximum_leaves = (float)$row['maximum_leaves'];
$leaves_taken = (float)$row['leaves_taken'];

$leave_balance = $maximum_leaves - $leaves_taken;

//-----------------------*********---------------------
// change > to <

if ($leave_balance > 0.5) {
    echo "<script>
            alert('Insufficient Leave Balance. Request Denied.');
            window.location='apply_half_leave.php';
          </script>";
    exit();
}

// Check for duplicate half-day leave on same date
$check_sql = "SELECT * FROM lms.leave_requests 
              WHERE staff_id = '$staff_id' 
              AND start_date = '$leave_date' 
              AND end_date = '$leave_date' 
              AND half_day_type = '$half_day_type'";
$check_result = mysqli_query($connection, $check_sql);

// Ensure the leave date is not in the past and no existing leave on the same day
$current_date = date("Y-m-d");

if (mysqli_num_rows($check_result) > 0) {
    echo "<script>
            alert('You have already requested a half-day leave for this date and time slot.');
            window.location='apply_half_leave.php';
          </script>";
    exit();
}

// Deduct 0.5 day from leaves_taken
$new_leaves_taken = $leaves_taken + 0.5;

$update_balance_sql = "UPDATE leave_statistics 
                       SET leaves_taken = '$new_leaves_taken' 
                       WHERE staff_id = '$staff_id' AND leave_type = '$leave_type'";
mysqli_query($connection, $update_balance_sql) or die(mysqli_error($connection));

// Insert half-day leave request
$insert_sql = "INSERT INTO lms.leave_requests 
               (staff_id, leave_type, start_date, end_date, date_applied, leave_status, half_day_type)
               VALUES 
               ('$staff_id', '$leave_type', '$leave_date', '$leave_date', '0.5', NOW(), '$status', '$half_day_type')";
mysqli_query($connection, $insert_sql);

echo "<script>
        alert('Half Day Leave Request Submitted Successfully.');
        window.location='apply_half_leave.php';
      </script>";

mysqli_close($connection);
?>
