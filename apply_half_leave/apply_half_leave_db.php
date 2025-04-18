<?php
session_start();
$staff_id = $_SESSION['staff_id'];
$leave_duration = $_POST['leave_duration'] ?? '';
$leave_date = $_POST['leave_date'] ?? '';
$status = "Pending";

// Database connection
$connection = @mysqli_connect("localhost", "root", "", "lms") or die(mysqli_connect_error());

// Determine half-day type and set leave type accordingly
if ($leave_duration == "first_half") {
    $half_day_type = "First Half";
    $leave_type = "First Half Leave";
} else {
    $half_day_type = "Second Half";
    $leave_type = "Second Half Leave";
}

// Leave balance check
$sql4 = "SELECT * FROM leave_statistics WHERE staff_id = '$staff_id' AND leave_type = '$leave_type'";
$result4 = mysqli_query($connection, $sql4) or die(mysqli_error($connection));
$maximum_leaves = 3; // Maximum leaves per month
$leaves_taken = 0;
$current_month = date("Y-m");

// Calculate total leaves accumulated
$total_leaves_accumulated = $maximum_leaves * (date("n") - 1); // Assuming leaves accumulate monthly

if ($row4 = mysqli_fetch_assoc($result4)) {
    $leaves_taken = (int)$row4['leaves_taken'];
}
$new_leaves_taken = $leaves_taken + 0.5; // Half-day leave
$balance_leaves = $total_leaves_accumulated - $leaves_taken;

echo "Total leaves accumulated: $total_leaves_accumulated\n";
echo "Leaves taken: $leaves_taken\n";
echo "New leaves taken: $new_leaves_taken\n";
echo "Balance leaves: $balance_leaves\n";

if ($new_leaves_taken > $total_leaves_accumulated) {
    echo "<script>
    alert('You have already taken " . $leaves_taken . " leaves. You can only request " . $balance_leaves . " more.');
    window.location=\"apply_half_leave.php\";</script>";
} else {
    // Check for existing leave on the same day
    $check_sql = "SELECT * FROM leave_requests WHERE staff_id = '$staff_id' AND start_date = '$leave_date' AND end_date = '$leave_date'";
    $check_result = mysqli_query($connection, $check_sql) or die(mysqli_error($connection));
    $current_date = date("Y-m-d");

    echo "Leave date: $leave_date\n";
    echo "Current date: $current_date\n";
    echo "Number of existing leave requests on the same date: " . mysqli_num_rows($check_result) . "\n";

    if (mysqli_num_rows($check_result) == 0) {
        if ($leave_date >= $current_date) {
            // Insert half-day leave
            $insert_sql = "INSERT INTO leave_requests (staff_id, leave_type, start_date, end_date, no_of_days, date_applied, leave_status, half_day_type) 
            VALUES ('$staff_id', '$leave_type', '$leave_date', '$leave_date', '0.5', '$current_date', '$status', '$half_day_type')";
            mysqli_query($connection, $insert_sql) or die(mysqli_error($connection));
            echo "<script>
            alert('Half Leave Request Submitted Successfully.');
            window.location=\"apply_half_leave.php\";</script>";
        } else {
            echo "<script>
            alert('The leave date is in the past.');
            window.location=\"apply_half_leave.php\";</script>";
        }
    } else {
        echo "<script>
        alert('You have already applied for leave on this date.');
        window.location=\"apply_half_leave.php\";</script>";
    }
}
mysqli_close($connection);
?>
