<?php
require_once("session.php");
require_once("class.user.php");

// SESSION
$auth_user = new USER();
$user_id = $_SESSION['user_session'];

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
			echo "Connection OKAY.";
		}

$numUpvotes = $_POST[upvote];
        echo "num upvotes: ".$numUpvotes;

        $numDownvotes = $_POST[downvote];
        echo "num Downvotes: ".$numDownvotes;

        $sql = "UPDATE answers SET num_upvotes = $numUpvotes, num_downvotes = $numDownvotes WHERE answer_id=$answer_id";
              
       if ($conn->query($sql) === TRUE) {
    	echo "<br>You have chosen best answer!";
		} else {
    	echo "Error: " . $sql . "<br>" . $conn->error;
		}

        

echo "Voting page";


?>