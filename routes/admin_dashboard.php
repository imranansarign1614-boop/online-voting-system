<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../");
}
include("../api/connect.php");

$admin_id = $_SESSION['admin']['id'];
$query = mysqli_query($connect, "SELECT * FROM users WHERE id='$admin_id'");
$pending_users = mysqli_query($connect, "SELECT * FROM users WHERE approved=0");
$admin = mysqli_fetch_array($query);
if(!$admin){
    session_destroy();
    header("Location: ../");
    exit();
}

$data = mysqli_query($connect, "SELECT * FROM elections LIMIT 1");
$result = mysqli_fetch_assoc($data);
$election = $result['election_status'];

?>

<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/stylesheet.css">

    <style>

        .admin-box{
            background:#b2bec3;
            width:95%;
            padding:25px;
            margin:auto;
            border-radius:10px;
            text-align:center;
        }

        .button-row{
            display:flex;
            justify-content:center;
            align-items:center;
            gap:15px;
            flex-wrap:wrap;
            margin-top:25px;
        }

        .button-row form{
            margin:0;
        }

        .btn{
            padding:12px 20px;
            border:none;
            border-radius:8px;
            cursor:pointer;
            color:white;
            font-size:16px;
        }

        .reset{
            background:orange;
        }

        .start{
            background:green;
        }

        .stop{
            background:red;
        }

        .result{
            background:blue;
        }

        .report{
           background:purple;
       }
    </style>
</head>

<body>

<div id="headersection">
     <a href="../"><button id= "backButton"> Back</button></a>
     <a href="../routes/logout.php"><button id="logoutButton">Logout</button></a>

    <center>
        <h1>Admin Panel - Online Voting System</h1>
    </center>
</div>

<hr>                               

<div class="admin-box">

    <h2>
        Election Status :
        <?php
        if($election=='started'){
            echo "<span style='color:green;'>STARTED</span>";
        }
        else{
            echo "<span style='color:red;'>STOPPED</span>";
        }
        ?>
    </h2>

    <div class="button-row">

        <form action="../api/reset_election.php" method="POST">
            <button 
                class="btn reset" 
                type="submit"
                onclick="return confirm('Are you sure you want to reset election?')"
            >
                Reset Election
            </button>
        </form>

        <form action="../api/start_election.php" method="POST">
            <button class="btn start" type="submit">
                Start Election
            </button>
        </form>

        <form action="../api/stop_election.php" method="POST">
            <button class="btn stop" type="submit">
                Stop Election
            </button>
        </form>

        <form action="view_result.php" method="POST">
            <button class="btn result" type="submit">
                View Results
            </button>
        </form>

        <form action="download_result.php" method="POST">
            <button class="btn report" type="submit">
                Download Result Report
            </button>
        </form>

    </div>

</div>

<div style="display:flex; justify-content:space-between; margin:20px;">

    <div style="width:30%; background:white; padding:20px; border-radius:10px;">
        <h2>Admin Details</h2>

        <img 
            src="../uploads/<?php echo $admin['photo']; ?>" 
            height="120" 
            width="120"
        ><br><br>

        <b>Name:</b> <?php echo $admin['name']; ?><br><br>
        <b>Mobile:</b> <?php echo $admin['mobile']; ?><br><br>
        <b>Address:</b> <?php echo $admin['address']; ?><br><br>
    </div>
    <div style="width:60%; background:white; padding:20px; border-radius:10px;">

        <h2>Registered Candidates</h2>

        <?php
        $groups = mysqli_query($connect,"SELECT * FROM users WHERE role='2'");
        
        while($group=mysqli_fetch_assoc($groups)){
        ?>

        <div style="border:1px solid gray; padding:15px; margin-bottom:15px; border-radius:10px;">

            <img 
                src="../uploads/<?php echo $group['photo']; ?>" 
                height="80" 
                width="80"
                style="float:right"
            >

            <b>Candidate Name:</b>
            <?php echo $group['name']; ?><br><br>

            <b>Total Votes:</b>
            <?php echo $group['votes']; ?><br><br>

            <form action="../api/delete_group.php" method="POST">
                <input type="hidden" name="group_id" value="<?php echo $group['id']; ?>">
                <button type="submit" style="background:red; color:white; padding:10px; border:none; border-radius:5px; cursor:pointer;" onclick="return confirm('Delete this candidate?')">
                    Remove Candidate
                </button>
            </form>
        </div>
        <?php 
        } 
        ?>
    </div>
</div>
<div style="background:white; padding:20px; border-radius:10px; margin:20px;">

<h2>Pending User Approvals</h2>

<?php
while($user=mysqli_fetch_assoc($pending_users)){
?>

<div style="
border:1px solid gray;
padding:15px;
margin-bottom:15px;
border-radius:10px;
">

<img
src="../uploads/<?php echo $user['photo']; ?>"
height="80"
width="80"
style="float:right"
>

<b>Name:</b>
<?php echo $user['name']; ?><br><br>

<b>Mobile:</b>
<?php echo $user['mobile']; ?><br><br>

<b>Address:</b>
<?php echo $user['address']; ?><br><br>

<form action="../api/approve_user.php" method="POST">

<input
type="hidden"
name="user_id"
value="<?php echo $user['id']; ?>"
>

<button
type="submit"
style="
background:green;
color:white;
padding:10px;
border:none;
border-radius:5px;
cursor:pointer;
"
>
Approve User
</button>

</form>

</div>

<?php
}
?>

</div>

</body>
</html>