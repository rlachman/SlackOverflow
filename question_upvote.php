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
list($votes,$q_id) = explode("-", $_POST[Qupvote], 2);

$votes = $votes + 1;

echo "num upvotes: ".$votes;
echo "<br>q_id: ".$q_id;

        $sql = "UPDATE questions SET num_upvotes = $votes WHERE question_id=$q_id";
              
       if ($conn->query($sql) === TRUE) {
    	echo "You have updated upvotes ";
		} else {
    	echo "Error: " . $sql . "<br>" . $conn->error;
		}

		//insert vote record into the db
		$sql = "INSERT INTO questionVotes (question_id,voter_id,is_upvote) VALUES ($q_id,$user_id,1)";
		if ($conn->query($sql) === TRUE) {
    	echo "You have inserted a question vote record";
		} else {
    	echo "Error: " . $sql . "<br>" . $conn->error;
		}

			

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>