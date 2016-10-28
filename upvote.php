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

$numUpvotes = $_POST[upvote];
echo "num upvotes: ".$numUpvotes;

        $sql = "UPDATE answers SET num_upvotes = $numUpvotes WHERE answer_id=$answer_id";
              
       if ($conn->query($sql) === TRUE) {
    	//echo "You have updated upvotes ";
		} else {
    	//echo "Error: " . $sql . "<br>" . $conn->error;
		}

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>