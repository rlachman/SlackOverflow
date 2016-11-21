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

//Get some object id to do something with
$response_id = $_GET['response_id'];

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

function returnOriginal($response_id)
{
  $conn = returnDatabaseConnection();
  $sql = "SELECT answer
          FROM answers
          WHERE answer_id = ".$response_id."";

          //echo $sql;

  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  echo $row['answer'];
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="ckeditor/ckeditor.js"></script>
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="admin.php">SlackOverflow AdminCP</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="home.php">Home</a></li>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Actions
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="admin.php?action=qa">Question Actions</a></li>
          <li><a href="admin.php?action=ra">Response Actions</a></li>
          <li><a href="admin.php?action=ua">User Actions</a></li> 
          </ul>
      </li>
      <li><a href="admin.php?action=se">Settings</a></li> 
    </ul>
  </div>
</nav>

<center><h1>Edit Response</h1></center>

<!-- DISPLAY ORIGINAL HERE -->
<h1>Original:</h1> 
  <?php returnOriginal($response_id); ?>
<hr>
  <h1>Make Changes</h1>
<form class="form" method="post" action="">
<p class="Response Body">
              <textarea  name="responseBody" id="responseBody" placeholder="Enter your question here." rows="4" cols="50"/></textarea>
            <script>
          // Replace the <textarea id="editor1"> with an CKEditor
          // instance, using the "bbcode" plugin, customizing some of the
          // editor configuration options to fit BBCode environment.
          CKEDITOR.replace( 'responseBody', 
          {
            // Add plugins providing functionality popular in BBCode environment.
            extraPlugins: 'bbcode',
            // Remove unused plugins.
            removePlugins: 'filebrowser,format,horizontalrule,pastetext,pastefromword,scayt,showborders,stylescombo,table,tabletools,wsc',
            // Remove unused buttons.
            removeButtons: 'Anchor,BGColor,Font,Strike,Subscript,Superscript',
            // Width and height are not supported in the BBCode format, so object resizing is disabled.
            disableObjectResizing: true,
            // Define font sizes in percent values.
            fontSize_sizes: "30/30%;50/50%;100/100%;120/120%;150/150%;200/200%;300/300%",
            // Strip CKEditor smileys to those commonly used in BBCode.
          });
            </script>
            </p>
<input type="submit" value="Update Response">
</form>
  
</body>