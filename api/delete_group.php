<?php
session_start();
include("connect.php");

$candidate_id = $_POST['group_id'];

mysqli_query($connect, "DELETE FROM users WHERE id='$candidate_id' AND role=2");

header("Location: ../routes/admin_dashboard.php");
?>