<?php
    include("connect.php");

    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $address = $_POST['address'];
    $photo = $_FILES['photo']['name'];
    $tmpname = $_FILES['photo']['tmp_name'];
    $role = $_POST['role'];

    if ($password == $confirm_password) {
        move_uploaded_file($tmpname, "../uploads/$photo");
        $sql = "INSERT INTO users (name,mobile,password,address,photo,role,status,votes,approved) VALUES ('$name','$mobile','$password','$address','$photo','$role',0,0,0)";
        $insert = mysqli_query($connect, $sql);
        if ($insert) {
            echo '
            <script>
            alert("Registration successful!");
            window.location = "../index.html";
            </script>
            ';
        } else {
            echo '
            <script>
            alert("Some error occured!");
            window.location = "../routes/registration.html";
            </script>
            ';
        }
    } else {
        echo '
        <script>
        alert("Passwords do not match!");
        window.location = "../routes/registration.html";
        </script>
        ';
    }
?>