<?php
require_once("session.php");
require_once("class.user.php");

// SESSION
$auth_user = new USER();
$user_id = $_SESSION['user_session'];

// SQL CONNECTION  
$servername = "localhost";
$username = "admin";
$password = "M0n@rch$";
$dbname = "slackoverflow";
$conn = new mysqli($servername, $username, $password, $dbname);
  
// GET ROW FOR LOGGED IN USER
  $stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
  $stmt->execute(array(":user_id"=>$user_id));
  
  $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

// ADDITIONAL SESSION VARIABLES
$_SESSION['user_id'] = $userRow['user_id'];
$_SESSION['user_name'] = $userRow['user_name'];
$user_is_guest = $userRow['is_guest'];

// GET QUESTION ID FROM PREVIOUS PAGE
$q_id = $_GET["q_id"];
echo "       ".$q_id;
$sql = "SELECT question_title, question, question_id, asker_id, answer_id, user_id, user_name, is_solved FROM questions join users on asker_id=user_id
			WHERE question_id=$q_id";
    
    //Store collection of rows in variable called result
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
        
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
                  if($user_is_guest == FALSE) 
                  {
                    echo $userRow['user_email'];
                  }
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

<body>
	
	<h1 id="questionAnswerPage"><?php echo $row['question_title']; ?></h1>
	<h3 id="questionAnswerPage"><?php echo $row['question']; ?></h1>
	<h4>asked by <?php echo $row['user_name']; ?></h3>

	
<!--PREVIOUS ANSWERS TABLE BELOW-->
	
		
	<?php
	$sql = "SELECT answer_id, answer, responder_id, is_best, num_upvotes, num_downvotes, user_name 
			FROM answers JOIN users WHERE question_id=$q_id and responder_id=user_id";
	  /////VERIFIES LOGGED IN USER IS THE ASKER, IF USER IS THE ASKER THEN GIVE OPTION TO SELECT BEST ANSWER     
  
      $getAskerID = "SELECT asker_id, is_solved FROM questions WHERE question_id=$q_id";
      $result = $conn->query($getAskerID);
      $questionInfo = $result->fetch_assoc();
  
     
      $askerID = $questionInfo["asker_id"];
      $loggedInID = $_SESSION['user_id'];
      $is_solved = $questionInfo["is_solved"];
      
    if($askerID == $loggedInID)
    {
    $isAsker = TRUE;
    }
    else{
      $isAsker = FALSE;
    }
    
		    //Store collection of rows in variable called result
        //if session user id != asker id then hide choose best answer glyph
        //if response has been selected as best answer then set color to green
              
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc())
        {
                
          $ans_id = $row["answer_id"];
          echo $ans_id.$num_upvotes.$num_downvotes;
          $numUpvotes = $row["num_upvotes"];
          $numDownvotes = $row["num_downvotes"];      
        	$is_best = $row["is_best"];
        	        	
        	echo "<hr><table>";
        	echo "<tr>
        		<td id=\"answerTD\"><p id=\"responseBody\">".$row["answer"]."</p></td>
        		<td id=\"answerTD\"> 
        			<table>
        			
        			<form name=\"bestAnswerForm\" method=\"post\" action=\"selectbestanswer.php\">";
        			
          
        	//Best answer not chosen yet, SHOULD SHOW GREY CHECK FOR ASKER
          if($isAsker == TRUE and $is_solved == TRUE and $is_best == TRUE) {echo		 
        			"<tr> 
        				<span style=\"color: #93af92;\" class=\"glyphicon glyphicon-check\"></span>
        			</tr>";}
        	
          //allow asker to select best answer if not selected already
          if($isAsker == TRUE and $is_solved == FALSE AND $is_best == FALSE) {echo		 
        			"<tr> 
        				<button type=\"submit\" name=\"answer_id\" value=\"$ans_id\"><span class=\"glyphicon glyphicon-check\"></span></button>
        			</tr>";}
        	
          //Non asker needs to be able to see the best answer which is chosen by asker.
        	if($isAsker == FALSE and $is_best == TRUE) {echo		 
        			"<tr> <span class=\"glyphicon glyphicon-flag\"></span> </tr>";}
			                
          
        
                  //<button type=\"submit\" name=\"downvote\" value=\"$num_downvotes\"><span class=\"glyphicon glyphicon-chevron-down\"></span></button>


          echo "</form>";

          //FORM THAT HANDLES VOTING
          echo "<form name=\"votingForm\" method=\"post\" action=\"voting.php\">";
          //Upvote for non asker
          //before upvote submit grab upvote number from db and add one to it
          $numUpvotesTotal = $numUpvotes + 1;
          $numDownvotesTotal = $numDownvotes + 1;

$votingPacket = array( 1 -> $numUpvotesTotal, 2 -> $numDownvotesTotal, 3 -> $ans_id );

          if(!$user_is_guest) {echo "<tr> <button type=\"submit\" name=\"upvote\" value=\"$numUpvotesTotal\"><span class=\"glyphicon glyphicon-chevron-up\"></span></button> </tr>
                                      <tr> <button type=\"submit\" name=\"downvote\" value=\"$numDownvotesTotal\"><span class=\"glyphicon glyphicon-chevron-down\"></span></button> </tr>";
        }
          echo "</form>";
          ///////

        		echo "</table>
        		</td>
        		</tr>
            Num Up: ".$numUpvotes." | Num Down: ".$numDownvotes." | Tags: random, php";
        	echo"<tr>
        			<td><div align=\"right\">".$row["user_name"]."</div>
        		</tr>
        	";
        	echo"</table>";
      }
        
        
        if ($conn->query($sql) === FALSE) {
    	    	echo "Error: " . $insert_query . "<br>" . $conn->error;
		}
	
    ?>
	</table>

	<hr>

<!--LOGGED IN USERS RESPONSE ENTRY BELOW-->
	<h3>Your Response:</h3>

	<form class="form" method="post" action="postAnswer.php">
	<p class="Answer Body">
        <textarea  name="answerBody" id="answerBody" placeholder="Enter your answer here." rows="4" cols="50"/></textarea>
    </p>

    <input type="hidden" name="questionID" id="questionID" value="<?php echo $q_id ?>"/>

    <?php
    if($_SESSION['user_name'] != "guest")
              {
                echo "
                <p class=\"submit\">
                <input type=\"submit\" value=\"Post Response\">
                ";
              }
              else{
                echo "<label>Guests can't answer a question. You must sign in.</label>";
              }
    ?>

    
    </p>
    
    </form>


<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
