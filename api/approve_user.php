<?php
session_start();
include("connect.php");

$user_id = $_POST['user_id'];

mysqli_query($connect,
"UPDATE users SET approved=1 WHERE id='$user_id'");

header("location: ../routes/admin_dashboard.php");
?>