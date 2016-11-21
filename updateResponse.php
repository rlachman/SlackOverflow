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

//establish connection
$conn = returnDatabaseConnection();
//create prepared statement
$stmt = $conn->prepare("UPDATE answers SET answer=? WHERE answer_id=?");
//bind params
$stmt->bind_param("si", $responseBody, $response_id);
//define params
$responseBody = $_POST['responseBody'];
$response_id = $_GET['response_id'];
//execute query
$stmt->execute();

echo "affected rows: ".$stmt->affected_rows;

header('Location: ' . 'admin.php?action=ra');

?>