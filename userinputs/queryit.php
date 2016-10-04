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

$sql = "select * from oduScores where opponent = '" . ($_GET["query"]) . "';";

print "running: $sql";


$result = $conn->query($sql);

echo "<html><body>\n";

if ($result->num_rows > 0) {
    echo "<table padding=2 border=1>\n";
    echo "\n";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
	foreach($row as $col){
		echo "<td>" . $col;
	}
    }
} else {
    echo "0 results";
}
$conn->close();
/**/
echo "</table></body></html>";
?>
