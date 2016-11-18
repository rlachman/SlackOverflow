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

//Pagination, Question End point in array
$numberOfQuestionsDisplayedPerPage = 10; // <------ Where number of questions per page gets set
if(count($_GET) > 0)
{
$_SESSION['startPoint'] = $_GET['start'];
$_SESSION['endPoint'] = $_GET['end'];
}
else{//Else set it to some default start and end points
    $_SESSION['startPoint'] = 1;
    $_SESSION['endPoint'] = $numberOfQuestionsDisplayedPerPage;
}

// DEBUG PURPOSES
function debug_to_console($data) {
  if(is_array($data) || is_object($data))
  {
    echo("<script>console.log('PHP: ".json_encode($data)."');</script>");
  } else {
    echo("<script>console.log('PHP: ".$data."');</script>");
  }
}

// PRINT CHECK/X IF Q HAS BEEN ANSWERED
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
  <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">
  <script type="text/javascript" src="jquery-1.11.3-jquery.min.js"></script>
  <link rel="stylesheet" href="style.css" type="text/css"  />
  <title>SlackOverflow - <?php print($userRow['user_email']); ?></title>
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
      <a class="logo" href="home.php">SlackOverflow</a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
      </ul>
      <ul class="nav navbar-nav navbar-right">

        <li class="dropdown">
          <a href="#" id="dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            
            <span class="glyphicon glyphicon-user"></span>&nbsp;Hello 
              <?php 
                  if($user_is_guest == FALSE) {
                    echo $userRow['user_email'];}
                  else{
                    echo " Guest";
                  }

              ?>&nbsp;
              <span class="caret">
              </span>
          </a>
          
          <ul class="dropdown-menu">
            <?php 
                  if($user_is_guest == FALSE) 
                  {
                    echo "<li><a href=\"profile.php\"><span class=\"glyphicon glyphicon-user\"></span>&nbsp;View Profile</a></li>";
                  }
            
            if($user_is_guest == TRUE)
            {
              echo "<li><a href=\"index.php?home=yes\"><span class=\"glyphicon glyphicon-off\"></span>&nbsp;Sign In</a></li>";
            }

            if($auth_user->is_loggedin() and $user_name != "guest")
            {
              echo "<li><a href=\"logout.php?logout=true\"><span class=\"glyphicon glyphicon-log-out\"></span>&nbsp;Sign Out</a></li>";
            }
            ?>
          </ul>
        </li>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</nav>


<div class="clearfix"></div>


<div class="container-fluid" style="margin-top:80px;">
  
    <div class="container">
                     
        <h1 id="secondLevelLinks">
          <a href="home.php"><span class="glyphicon glyphicon-home"></span> Home</a> &nbsp; 
          <a href="ask.php"><span class="glyphicon glyphicon-question-sign"></span> Ask</a>
          <a href="profile.php"><span class="glyphicon glyphicon-user"></span> Profile</a>
          <a href="browse.php"><span class="glyphicon glyphicon-eye-open"></span> Browse</a>
          </h1>
                
        <hr />
<!-- Table that will display questions -->
        <?php
                
        $servername = "localhost";
        $username = "admin";
        $password = "M0n@rch$";
        $dbname = "slackoverflow";
        
        //Establish connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        //Store query into a php variable
        $sql = "SELECT question_title, question, question_id, asker_id, answer_id, user_id, user_name, is_solved, num_upvotes, num_downvotes
                FROM questions 
                join users 
                on asker_id=user_id
                order by num_upvotes-num_downvotes desc";
        //Store collection of rows in variable called result
        $result = $conn->query($sql);
        
        //Pagination Variables
        $numberOfQuestionsTotal = $result->num_rows;
        $numberOfQuestionsOnLastPage = $numberOfQuestionsTotal % 
        $numberOfQuestionsDisplayedPerPage;
        $numberOfPages = ceil($numberOfQuestionsTotal/
        $numberOfQuestionsDisplayedPerPage);
        $questionArray[] = array(""); 
        
                echo "<table class=\"questionTable\"> 
                <th class=\"header\">Previous Questions</th>
                <th class=\"header\">Asker</th>
                <th class=\"header\">Solved</th>
                <th class=\"header\">Score</th>";
    
          if($result->num_rows > 0)
        {
                 //Only display the top 5
                $count = 0;

                 //This puts the resulting row into an array for access

                //Pagination start and end points
                $qStart = $_SESSION['startPoint'];
                if($qStart < 0)
                {
                  $qStart = 1;
                }
                $qEnd = $_SESSION['endPoint'];
                


                echo "Start index:".$qStart.", End Index: ".$qEnd;

            
            while($row = $result->fetch_assoc()  )//and $count < 5)
            { 
              //for use with pagination
              $questionArray[] = $row;
            }

            for($i = $qStart; $i <= $qEnd && !is_null($questionArray[$i]); $i++)
            {
              $row = $questionArray[$i];
              // Store url, user id info in case of redirect to view external users profile
              $_SESSION["user_id_profile"] = $row["asker_id"];
              $_SESSION["user_id_name"] = $row["user_name"];
              $path = 'profile.php?ext_user='.$_SESSION["user_id_profile"].'&ext_user_name='.$_SESSION["user_id_name"];  // change accordingly
              
              //Increment the count
              //$count = $count + 1;

                //Question score
                $QuestionScore = $row["num_upvotes"] - $row["num_downvotes"];
                $solved = is_null($row["is_solved"]);//Pass this variable into method to determine if x or check will print

                    echo "<tr>
                  
                    <td>
                    <a href=\"answer.php?q_id=".$row["question_id"]. "\">
                    ".$row["question_title"]."
                    </a>
                    </td>";
                                       
                    echo "<td><a href=".$path.">".$row["user_name"]."</a></td>";
                    
                    echo "<td>" 
                    .Solved($solved). 
                    "</td>

                    <td>".$QuestionScore."</td>

                    
                                      
                    </tr>";
      }

    }
    echo "</table>";

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    //Pagination below
    $count = 1;
    $start = 1;
    $end = $start + $numberOfQuestionsDisplayedPerPage - 1;
    echo "<ul class=\"pagination\">";
    while($count <= $numberOfPages)
    {
      
      echo "<li><a href=\"browse.php?start=".$start."&end=".$end."\">".$count."</a><li>";
      $start = $count*$numberOfQuestionsDisplayedPerPage + 1;
      $end = $start + $numberOfQuestionsDisplayedPerPage - 1;

      $count++;
    }   
    echo "</ul>";

    $conn->close();
    ?>

    <!--<ul class = "pagination">
   <li><a href = "#">&laquo;</a></li>
   <li><a href = "#">1</a></li>
   <li><a href = "#">2</a></li>
   <li><a href = "#">3</a></li>
   <li><a href = "#">4</a></li>
   <li><a href = "#">5</a></li>
   <li><a href = "#">&raquo;</a></li>
  </ul>-->
 
    <hr>
    <script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>