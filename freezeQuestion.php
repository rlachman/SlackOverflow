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
$_SESSION['isAdmin'] = $userRow['is_admin'];
//Do not allow non admins access here!
if(!$_SESSION['isAdmin'])
{
  header('Location: '."home.php");
}



// SET USER ID,NAME,ISGUEST FOR SESSION
$_SESSION['user_id'] = $userRow['user_id'];
$user_name = $userRow['user_name'];
$user_is_guest = $userRow['is_guest'];

//Get Action which is used in switch statement
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
$sql = "SELECT is_frozen FROM questions WHERE question_id=".$question_id.";";

echo count($_GET);

if(count($_GET) < 2)
{
   $freezeQuestionSql = "UPDATE questions SET is_frozen = 1 WHERE question_id=".$question_id.";";
  $conn->query($freezeQuestionSql);
}else{
  $removeFreezeSql = "UPDATE questions SET is_frozen = 0 WHERE question_id=".$question_id.";";
  $conn->query($removeFreezeSql);
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
