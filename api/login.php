<?php
session_start();
include("connect.php");

$mobile = $_POST['mobile'];
$password = $_POST['password'];
$role = $_POST['role'];

$check = mysqli_query($connect, "SELECT * FROM users WHERE mobile='$mobile' AND password='$password' AND role='$role'");

if (mysqli_num_rows($check) > 0) {

    $userdata = mysqli_fetch_array($check);

    if($userdata['approved']==0){
        echo '
        <script>
        alert("Your account is waiting for admin approval!");
        window.location = "../";
        </script>
        ';
        exit();
    }

    if($userdata['role'] == 0){

        $_SESSION['admin'] = $userdata;
        header("location: ../routes/admin_dashboard.php");

    } else {

        $_SESSION['userdata'] = $userdata;

        $groups = mysqli_query($connect, "SELECT * FROM users WHERE role=2");
        $groupdata = mysqli_fetch_all($groups, MYSQLI_ASSOC);

        $_SESSION['groupdata'] = $groupdata;

        header("location: ../routes/dashboard.php");
    }

}
else{
    echo '
    <script>
    alert("Invalid credentials or user not found!");
    window.location = "../";
    </script>
    ';
}
?>