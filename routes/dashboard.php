<?php
    session_start();
    include("../api/connect.php");
    
    if (!isset($_SESSION['userdata'])) {
        header("Location: ../");
    }
    
    $userdata = $_SESSION['userdata'];
    
    $userdata_id = $userdata['id'];
    $data = mysqli_query($connect, "SELECT * FROM users WHERE id='$userdata_id'");
    $userdata = mysqli_fetch_array($data);
    if(!$userdata){
    session_destroy();
    header("Location: ../");
    exit();
    }
    
    $candidates = mysqli_query($connect, "SELECT * FROM users WHERE role=2");
    
    $candidatedata = mysqli_fetch_all($candidates, MYSQLI_ASSOC);
    
    if($userdata['status'] == 0){
        $status = '<b style="color:red">Not Voted</b>';
    } else {
        $status = '<b style="color:green">Voted</b>';
    }
?>
<html>

    <head>
        <title>Online Voting System</title>
        <link rel="stylesheet" href="../css/stylesheet.css">
    </head>

    <body>
        <style>
        #Profile {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            width: 30%;
            float: left;
        }
        #Group {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            width: 60%;
            float: right;
        }
        #votebtn {
            padding: 5px;
            border-radius: 5px;
            background-color: #1e90ff;
            color: white;
            font-size: 15px;
        }
        #mainpanel {
            padding: 10px;
        }
        #voted {
            padding: 5px;
            border-radius: 5px;
            background-color: green;
            color: white;
            font-size: 15px;
        }
        </style>
        <div id = "mainsection">
            <center>
            <div id = "headersection">
                <a href="../"><button id= "backButton"> Back</button></a>
                <a href="../routes/logout.php"><button id="logoutButton">Logout</button></a>
                <h1>Online Voting System</h1>
            </div>
            </center>
            <hr>
            <div id="mainpanel">
                <div id="Profile">
                    <center>
                        <img src="../uploads/<?php echo $userdata['photo']; ?>" height="100" width="100"><br><br>
                    </center>
                    <h3>Name: <?php echo $userdata['name']; ?></h3>
                    <b>Mobile:</b> <?php echo $userdata['mobile']; ?> <br><br>
                    <b>Address:</b> <?php echo $userdata['address']; ?> <br><br>
                    <b>Status:</b> <?php echo $status; ?> <br><br>
                </div>
                <div id="Group">
                    <?php
                    if(mysqli_num_rows($candidates) > 0){
                        for($i=0; $i<count($candidatedata); $i++){
                            ?>
                            <div>
                                <img style="float:right" src="../uploads/<?php echo $candidatedata[$i]['photo']; ?>" height="80" width="80">
                                <b>Candidate Name:</b> <?php echo $candidatedata[$i]['name']; ?><br><br>
                                <form action="../api/vote.php" method="POST">
                                    <input type="hidden" name="gvotes" value="<?php echo $candidatedata[$i]['votes'] ?>">
                                    <input type="hidden" name="gid" value="<?php echo $candidatedata[$i]['id'] ?>">
                                    <?php
                                    if($userdata['status'] == 0){
                                        ?>
                                        <input type="submit" name="votebtn" value="vote" id="votebtn">
                                        <?php
                                    }else {
                                        ?>
                                        <button disabled type="button" name="votebtn" value="vote" id="voted">Voted</button>
                                        <?php
                                    }
                                    ?>                             
                                </form>
                            </div>
                            <hr>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
           
        </div>

    </body>
</html>