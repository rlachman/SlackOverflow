<?php

  // SQL CONNECTION  
$servername = "localhost";
$username = "admin";
$password = "M0n@rch$";
$dbname = "slackoverflow";
$conn = new mysqli($servername, $username, $password, $dbname);

$targetId = $_GET['id'];

  if (isset($_POST['submit'])){
  

  if(isset($_POST['use_gravatar']) and $_POST['use_gravatar'] == 1)//insert 0 into db
  {
    $choice = 0;
    $sql = "UPDATE users SET use_gravatar='$choice' WHERE user_id='$targetId'";
    echo $sql;
    $conn->query($sql);
    //echo "Use Gravatar: <h1>".$_POST['use_gravatar'].'</h1>';
  }
  else//insert 1 into db
  {
    
    $choice = 1;
    $sql = "UPDATE users SET use_gravatar='$choice' WHERE user_id='$targetId'";
    echo $sql;
    $conn->query($sql);
  }
}


//Redirect back to home page after submitting
		header('Location: ' . $_SERVER['HTTP_REFERER']);
?>