<?php
require_once("session.php");
require_once("class.user.php");

// SESSION
$auth_user = new USER();
$user_id = $_SESSION['user_session'];
$answer_id = $_SESSION["answer_id"];

// SQL CONNECTION  
$servername = "localhost";
$username = "admin";
$password = "M0n@rch$";
$dbname = "slackoverflow";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    	die("Connection failed: " . $conn->connect_error);
		} 
		if(!$conn->connect_error)
		{
			//echo "Connection OKAY.<br>";
		}
list($votes, $ans_id) = explode("-", $_POST[upvote], 2);

$votes = $votes + 1;

echo "num upvotes: ".$votes;
echo "<br>ans id: ".$ans_id;

        $sql = "UPDATE answers SET num_upvotes = $votes WHERE answer_id=$ans_id";
              
       if ($conn->query($sql) === TRUE) {
    	//echo "You have updated upvotes ";
		} else {
    	//echo "Error: " . $sql . "<br>" . $conn->error;
		}

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>