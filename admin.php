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

//Get Action which is used in switch statement
$action = $_GET['action'];

//DB Variables
$servername = "";
  $username = "";
  $password = "";
  $dbname = "";
  $conn;

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Questions
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="admin.php?action=eq">Edit Question</a></li>
          <li><a href="admin.php?action=fq">Freeze Question</a></li>
          <li><a href="admin.php?action=dq">Delete Question</a></li> 
          </ul>
      </li>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Responses
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="admin.php?action=er">Edit Response</a></li>
          <li><a href="admin.php?action=fr">Freeze Response</a></li>
          <li><a href="admin.php?action=dr">Delete Response</a></li> 
          </ul>
      </li>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Users
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="admin.php?action=up">User Priviledges</a></li>
          <li><a href="admin.php?action=bu">Ban User</a></li>
          <li><a href="admin.php?action=vu">View User</a></li> 
          </ul>
      </li>
      <li><a href="admin.php?action=se">Settings</a></li> 
    </ul>
  </div>
</nav>
	
</body>
</html>

<?php 

if(count($_GET) > 0)
{
	switch ($action) {
    case "fq": echo "<center><h1>Freeze A Question</h1><hr><center>"; searchReturnQuestions("beer");
        break;
    case "eq": echo "<center><h1>Edit A Question</h1><hr><center>"; editQuestion();
        break;
    case "dq": echo "<center><h1>Delete A Question</h1><hr><center>"; deleteQuestion();
        break;
    case "fr": echo "<center><h1>Freeze A Response</h1><hr><center>"; freezeResponse();
        break;
    case "er": echo "<center><h1>Edit A Response</h1><hr><center>"; editResponse();
        break;
    case "dr": echo "<center><h1>Delete A Response</h1><hr><center>"; deleteResponse();
        break;
    case "up": echo "<center><h1>User Priviledges</h1><hr><center>"; editUserPriviledges();
        break;
    case "bu": echo "<center><h1>Ban User</h1><hr><center>"; banUser();
        break;
    case "vu": echo "<center><h1>View User Details</h1><hr><center>"; viewUser();
        break;
    case "se": echo "<center><h1>Settings</h1><hr><center>"; loadSettings();
        break;
    
    default:
        echo "Your favorite color is neither red, blue, nor green!";
}//End switch
} else {
	echo "<center><h1><span class=\"label label-warning\">Welcome to the AdminCP. Please select an action from above.</span></h1></center>";
}

function returnDatabaseConnection()
{
  $servername = "localhost";
  $username = "admin";
  $password = "M0n@rch$";
  $dbname = "slackoverflow";
  $conn = new mysqli($servername, $username, $password, $dbname);
  return $conn;
}

function searchReturnQuestions($searchString)
{
  $conn = returnDatabaseConnection();
  $sql = "SELECT question_title, question, question_id, asker_id, answer_id, user_id, user_name, is_solved, num_upvotes, num_downvotes
          FROM questions 
          join users 
          on asker_id=user_id
          WHERE question_title LIKE '%".$searchString."%'";

        //Store collection of rows in variable called result
        $result = $conn->query($sql);
        echo "Your search returned ".$result->num_rows." results.";
        
        while($row = $result->fetch_assoc()  )//and $count < 5)
            {
              echo "<h1>".$row['question_title']."</h1>
                    <h3>".$row['question']."</h3>";
            }
}

function createSearchForm()
{
    

}

?>
