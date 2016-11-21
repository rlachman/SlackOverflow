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
$user_id = $_GET['user_id'];

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
$sql = "SELECT is_admin FROM users WHERE user_id=".$user_id.";";
$is_admin = $conn->query($sql);

if(!$is_admin)
{
   $makeAdminSql = "UPDATE users SET is_admin = 1 WHERE user_id=".$user_id.";";
  $conn->query($makeAdminSql);
}else{
  $removeAdminSql = "UPDATE users SET is_admin = 0 WHERE user_id=".$user_id.";";
  $conn->query($removeAdminSql);
}

header('Location: ' . $_SERVER['HTTP_REFERER']);


?>
