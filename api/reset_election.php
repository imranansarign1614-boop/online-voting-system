<?php
session_start();
include("connect.php");

// Reset all group votes
mysqli_query($connect, "UPDATE users SET votes=0 WHERE role=2");

// Reset voter status
mysqli_query($connect, "UPDATE users SET status=0 WHERE role=1");

// Stop election
mysqli_query($connect, "UPDATE elections SET election_status='stopped' WHERE id=1");

//Reset current logged-in user session
if(isset($_SESSION['userdata'])){
    $_SESSION['userdata']['status'] = 0;
}

header("location: ../routes/admin_dashboard.php");
?>