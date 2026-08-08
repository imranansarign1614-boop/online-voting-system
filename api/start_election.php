<?php
include("connect.php");

mysqli_query($connect, "UPDATE elections SET election_status='started' WHERE id=1");

header("location: ../routes/admin_dashboard.php");
?>