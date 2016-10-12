<?php
$servername = "localhost";
//$username = "admin";
//$password = "M0n@rch$";
$username = "root";
$password = "";
$dbname = "mysqltest";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

/**/

$id = trim($_GET["userID"]);
$opp = trim($_GET["userOpp"]);
$vis = trim($_GET["userVis"]);
$odu = trim($_GET["userOdu"]);
$date = trim($_GET["userDate"]);

if(!is_numeric($id)){
	print "key/id " + $id + " is not a number!<br>";
}
if(!is_numeric($vis)){
	print "visitor score " + $vis + " is not a number!<br>";
}
if(!is_numeric($odu)){
	print "odu score " + $odu + " is not a number!<br>";
}

$sql = "insert into oduScores values (" .  mysqli_real_escape_string($conn, $id) . ", '"
	.  mysqli_real_escape_string($conn, $opp) . "', "
	.  mysqli_real_escape_string($conn, $vis) . ", "
	.  mysqli_real_escape_string($conn, $odu) . ", '"
	.  mysqli_real_escape_string($conn, $date) .  "');";

print "insert query: $sql<br><br>";

$result = $conn->query($sql);


$sql = "select * from oduScores;";
$result = $conn->query($sql);

echo "<html><body>\n";

if ($result->num_rows > 0) {
    echo "<table padding=2 border=1>\n";
    echo "<tr><th>ID<th>opponent<th>visitor points<th>odu points<th>date\n";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["id"] . "<td>" . $row["opponent"] . "<td>" . $row["visitorPoints"] . "<td>" . $row["oduPoints"] . "<td>" . $row["notes"] . "\n";
    }
} else {
    echo "0 results";
}
$conn->close();
/**/
echo "</table></body></html>";
?>
