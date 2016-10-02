<?php

	require_once("session.php");
	
	require_once("class.user.php");
	$auth_user = new USER();
	
	
	$user_id = $_SESSION['user_session'];
	
	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

  $_SESSION['user_id'] = $userRow['user_id'];

function debug_to_console($data) {
    if(is_array($data) || is_object($data))
  {
    echo("<script>console.log('PHP: ".json_encode($data)."');</script>");
  } else {
    echo("<script>console.log('PHP: ".$data."');</script>");
  }
}

function printCheck()
    {
      return "<span class='glyphicon glyphicon-ok'></span>";
    }
  function printX()
    {
      return "<span class='glyphicon glyphicon-remove'></span>";
    }
  function Solved($solved)
  {
   
    if($solved == 1)
    {
      return printX();
    }
    else{
      return printCheck();
    }
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
<script type="text/javascript" src="jquery-1.11.3-jquery.min.js"></script>
<link rel="stylesheet" href="style.css" type="text/css"  />
<title>welcome - <?php print($userRow['user_email']); ?></title>
</head>

<body>

<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="http://localhost">SlackOverflow</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="http://www.google.com">Some Tab Link</li>
            <li><a href="http://www.google.com">Some Lower Level Tab Link</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			  <span class="glyphicon glyphicon-user"></span>&nbsp;Hello <?php echo $userRow['user_email']; ?>&nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="profile.php"><span class="glyphicon glyphicon-user"></span>&nbsp;View Profile</a></li>
                <li><a href="logout.php?logout=true"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>


    <div class="clearfix"></div>
    	
    
<div class="container-fluid" style="margin-top:80px;">
	
    <div class="container">
       	             
        <h1>
          <a href="home.php"><span class="glyphicon glyphicon-home"></span> Home</a> &nbsp; 
          <a href="profile.php"><span class="glyphicon glyphicon-user"></span> Profile</a>
          <a href="profile.php"><span class="glyphicon glyphicon-eye-open"></span> Browse</a>
          <button type="button" id="myBtn"><span class="glyphicon glyphicon-pencil"></span></button>
        </h1>
                
       	<hr />
        
        <p class="h2">User Home Page</p>
        
        <!-- Post question form below-->
        <?php echo "User ID: ".$_SESSION['user_id']; ?>
        <h2>Enter your question</h2>
          <form class="form" method="post" action="postQuestion.php">
            <p class="Question Title">
              <input type="text" name="questionTitle" id="questionTitle" placeholder="Your Question's Title" />
            </p>

            <p class="Question Body">
              <textarea  name="questionBody" id="questionBody" placeholder="Enter your question here." rows="4" cols="50"/></textarea>
            </p>

            <p class="submit">
                <input type="submit" value="Post Question">

          </form>

              <hr>

              



        <!-- Table that will display questions -->
        <?php
                
        $servername = "localhost";
        $username = "root";
        $password = "odu2017";
        $dbname = "slackoverflow";
        
        //Establish connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        //Store query into a php variable
        $sql = "SELECT question, question_id, asker_id, answer_id, user_id, user_name, is_solved FROM questions join users on asker_id=user_id";
        //Store collection of rows in variable called result
        $result = $conn->query($sql);



        echo "<table id=\"questionTable\"> 
                <th>Question</th>
                <th>Asker</th>
                <th>Solved</th>";
        
  

        if($result->num_rows > 0)
        {
                  //This puts the resulting row into an array for access
            while($row = $result->fetch_assoc())
            {          
                $solved = is_null($row["is_solved"]);//Pass this variable into method to determine if x or check will print

                    echo "<tr>
                    <td>".$row["question"] ."</td>
                    <td>".$row["user_name"] ."</td>";
                    echo "<td>" .Solved($solved). "</td>
                                       
                    </tr>";
            }
        }
        echo "</table>";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

        $conn->close();
?>
<hr>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>