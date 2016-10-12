Hello, <?php 

$input = $_GET["nameEntered"];

print "raw value: " . $input . "<br><br>";

if(empty($input)){
	echo "You have an empty string!";
}
elseif(is_numeric($input)){
	echo "This is a number!";
}

print "<br><br>Here's sanitized input:<br>";
print "escapeshellarg: " . escapeshellarg($input) . "<br>";
print "htmlspecialchars: " . htmlspecialchars($input) . "<br>";
print "mysqli_real_escape_string: " . mysqli_real_escape_string($input) . "<br>";


?>!
