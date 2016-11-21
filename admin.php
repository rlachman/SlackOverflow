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
	
</body>
</html>

<?php 

if(count($_GET) > 0)
{
  $action = $_GET['action'];
	switch ($action) {
    case "qa": echo "<center><h1>Questions</h1><hr><center>"; questionActions();
        break;
    case "ra": echo "<center><h1>Responses</h1><hr><center>"; responseActions();
        break;
    case "ua": echo "<center><h1>Users</h1><hr><center>"; userActions();
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

function questionActions()
{
  returnQuestions();
}

function responseActions()
{
  returnResponses();
}

function userActions()
{
  returnUsers();
}

function returnQuestions()

{
  $conn = returnDatabaseConnection();
  $sql = "SELECT question_title, question, question_id, asker_id, answer_id, user_id, user_name, is_solved, num_upvotes, num_downvotes
          FROM questions 
          join users 
          on asker_id=user_id";

        //Store collection of rows in variable called result
        $result = $conn->query($sql);
        //echo "Your search returned ".$result->num_rows." results.";
        echo '<div class="container">
            <table class="table">
                <th>Q Id</th><th>Question Title</th><th>Asker</th><th>Edit</th><th>Del</th><th>Freeze</th>';
        while($row = $result->fetch_assoc()  )//and $count < 5)
            {
              echo '<tr>
                      <td>'.$row['question_id'].'</td>
                      <td>'.$row['question_title'].'</td>
                      <td>'.$row['user_name'].'</td>
                      <td>
                        <a href="editQuestion.php?question_id='.$row['question_id'].'"><span class="label label-primary">Edit</span></a>
                      </td>
                      <td>
                        <a href="deleteQuestion.php?question_id='.$row['question_id'].'"><span class="label label-danger">Del</span></a>
                      </td>
                      <td>
                        <span class="label label-info">Frz</span>
                      </td>
                    </tr>';

            }
        echo '<table></div>';
}

function returnResponses()
{
  $conn = returnDatabaseConnection();
  $sql = "SELECT answer_id, answer, responder_id, is_best, num_upvotes, num_downvotes, user_name 
      FROM answers 
      INNER JOIN users
      ON responder_id = user_id
      order by answer_id DESC";

        //Store collection of rows in variable called result
        $result = $conn->query($sql);
        //echo "Your search returned ".$result->num_rows." results.";
        echo '<div class="container">
            <table class="table">
                <th>Resp. Id</th><th>Response</th><th>Responder</th><th>Edit</th><th>Del</th><th>Freeze</th>';
        while($row = $result->fetch_assoc())
            {
              echo '<tr>
                      <td>'.$row['answer_id'].'</td>
                      <td>'.$row['answer'].'</td>
                      <td>'.$row['user_name'].'</td>
                      <td>
                      <a href="editResponse.php?response_id='.$row['answer_id'].'"><span class="label label-primary">Edit</span></a>
                      </td>
                      <td><a href="deleteResponses.php?response_id='.$row['answer_id'].'"><span class="label label-danger">Del</span></a></td>
                      <td><span class="label label-info">Frz</span></td>
                                            </td>
                    </tr>';

            }
        echo '<table></div>';
}

function returnUsers()
{
  $conn = returnDatabaseConnection();
  $sql = "SELECT user_id, user_name, user_email, is_admin
      FROM users 
      ORDER BY user_name asc";

        //Store collection of rows in variable called result
        $result = $conn->query($sql);
        //echo "Your search returned ".$result->num_rows." results.";
        echo '<div class="container">
            <table class="table">
                <th>User Id</th><th>Username</th><th>User Email</th><th>Q Posts</th><th>Q Score</th><th>Admin I/O</th><th>Make Admin</th><th>Delete</th>';
        while($row = $result->fetch_assoc())
            {
              echo '<tr>
                      <td>'.$row['user_id'].'</td>
                      <td><a href="profile.php?ext_user='.$row['user_id'].'&ext_user_name='.$row['user_name'].'">'.$row['user_name'].'</a></td>
                      <td>'.$row['user_email'].'</td>
                      <td>'.getNumberOfQuestionsAsked($row['user_id']).'</td>
                      <td>'.getUserQScore($row['user_id']).'</td>
                      <td>'.$row['is_admin'].'</td>
                      <td>
                      <a href="makeAdmin.php?user_id='.$row['user_id'].'"><span class="label label-primary">Admin</span></a>
                      <a href="makeAdmin.php?user_id='.$row['user_id'].'&revoke=yes"><span class="label label-primary">Revoke</span></a>
                      </td>
                      <td><span class="label label-danger">Del</span></td>
                                                                  </td>
                    </tr>';

            }
        echo '<table></div>';
}

function getNumberOfQuestionsAsked($asker_id)
{
  $conn = returnDatabaseConnection();
  $sql = "SELECT question_id, question
      FROM questions
      WHERE asker_id=".$asker_id.";";
      return mysqli_num_rows($conn->query($sql));
}

function getUserQScore($user_id)
{
 $conn = returnDatabaseConnection();
  $sql = "SELECT num_upvotes, num_downvotes
      FROM questions
      WHERE asker_id=".$user_id.";";
      
      $result = $conn->query($sql);
      $score = 0;

      while($row = $result->fetch_assoc())
      {
          $score = $row['num_upvotes'] - $row['num_downvotes'];
      }

      return $score;
}

?>
