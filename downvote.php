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
            echo "Connection OKAY.<br>";
        }

$numDownvotes = $_POST[downvote];
echo ", num Downvotes: ".$numDownvotes."<br>";

        $sql = "UPDATE answers SET num_downvotes = $numDownvotes WHERE answer_id=$answer_id";
              
       if ($conn->query($sql) === TRUE) {
        echo "You have updated downvotes";
        } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        }

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>