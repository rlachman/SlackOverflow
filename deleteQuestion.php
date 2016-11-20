<?php

require_once("session.php");
require_once("dbconfig.php");
require_once("class.user.php");

// SESSION
$auth_user = new USER();
$user_id = $_SESSION['user_session'];

// USER VALIDATION
$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
$stmt->execute(array(":user_id"=>$user_id));
$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

// SET USER ID,NAME,ISGUEST FOR SESSION
$_SESSION['user_id'] = $userRow['user_id'];
$user_name = $userRow['user_name'];
$user_is_guest = $userRow['is_guest'];

//Ensure user completing this action is ADMIN!!!
/*if(!$isAdmin){
	header("Location: home.php");
}*/


//Get Question ID to be deleted
$question_id = $_GET['question_id'];

//DB Variables
$servername = "";
  $username = "";
  $password = "";
  $dbname = "";
  $conn;

function returnDatabaseConnection()
{
  $servername = "localhost";
  $username = "admin";
  $password = "M0n@rch$";
  $dbname = "slackoverflow";
  $conn = new mysqli($servername, $username, $password, $dbname);
  return $conn;
}

$conn = returnDatabaseConnection();

//SQL Query to delete attached answer votes because of FK constraint
$sql = "DELETE FROM votes WHERE question_id = ".$question_id.";";
$conn->query($sql);
if ($conn->query($sql) === TRUE) {
    echo "Answer vote records deleted successfully";
} else {
    echo "Error deleting answer vote records: " . $conn->error;
}

//SQL Query to delete attached votes because of FK constraint
$sql = "DELETE FROM questionVotes WHERE question_id = ".$question_id.";";
$conn->query($sql);
if ($conn->query($sql) === TRUE) {
    echo "Vote records deleted successfully";
} else {
    echo "Error deleting vote records: " . $conn->error;
}

//SQL Query to delete attached responses because of FK constraint
$sql = "DELETE FROM answers WHERE question_id = ".$question_id.";";
$conn->query($sql);
if ($conn->query($sql) === TRUE) {
    echo "Response records deleted successfully";
} else {
    echo "Error deleting response records: " . $conn->error;
}

//SQL Query to delete question
$sql = "DELETE FROM questions WHERE question_id = ".$question_id.";";
$conn->query($sql);

if ($conn->query($sql) === TRUE) {
    echo "Question Record deleted successfully";
} else {
    echo "Error deleting question record: " . $conn->error;
}

header('Location: ' . $_SERVER['HTTP_REFERER']);


?>