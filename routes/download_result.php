<?php
include("../api/connect.php");

header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=election_results.xls");

$candidates = mysqli_query($connect, "SELECT * FROM users WHERE role=2");

echo "Candidate Name	Total Votes
";

while($candidate=mysqli_fetch_assoc($candidates)){
    echo $candidate['name']."	".$candidate['votes']."
";
}
?>