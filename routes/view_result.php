<?php
include("../api/connect.php");

$candidates = mysqli_query($connect, "SELECT * FROM users WHERE role=2");
?>

<html>
<head>
    <title>Election Results</title>
    <link rel="stylesheet" href="../css/stylesheet.css">
</head>

<body>

<div id="headersection">
    <a href="admin_dashboard.php">
        <button id="backButton">Back</button>
    </a>

    <center>
        <h1>Election Results</h1>
    </center>
</div>

<hr>

<center>

<table border="1" cellpadding="15">
<tr>
    <th>Candidate Name</th>
    <th>Total Votes</th>
</tr>

<?php
while($candidate=mysqli_fetch_assoc($candidates)){
?>

<tr>
    <td><?php echo $candidate['name']; ?></td>
    <td><?php echo $candidate['votes']; ?></td>
</tr>

<?php
}
?>

</table>

</center>

</body>
</html>