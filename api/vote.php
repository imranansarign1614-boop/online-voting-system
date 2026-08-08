<?php
    include("connect.php");
    session_start();
    $votes = $_POST['gvotes'];
    $total_votes = $votes + 1;
    $gid = $_POST['gid'];
    $uid = $_SESSION['userdata']['id'];
    $status_data = mysqli_query($connect, "SELECT * FROM elections LIMIT 1");
    $status_result = mysqli_fetch_assoc($status_data);
    if($status_result['election_status']!='started'){
        echo '
        <script>
        alert("Election is currently stopped!");
        window.location = "../routes/dashboard.php";
        </script>
        ';
        exit();
    }

    $update_votes = mysqli_query($connect, "UPDATE users SET votes = '$total_votes' WHERE id = '$gid'");
    $update_user_status = mysqli_query($connect, "UPDATE users SET status = 1 WHERE id = '$uid'");

    if ($update_votes and $update_user_status) {
        $candidates = mysqli_query($connect, "SELECT * FROM users WHERE role=2");
        $candidatedata = mysqli_fetch_all($candidates, MYSQLI_ASSOC);

        $_SESSION['userdata']['status'] = 1;
        $_SESSION['candidatedata'] = $candidatedata;
        echo '
        <script>
        alert("Voting successfully!");
        window.location = "../routes/dashboard.php";
        </script>
        ';
    } else {
        echo '
        <script>
        alert("Some error occured!");
        window.location = "../routes/dashboard.php";
        </script>
        ';
    }
?>