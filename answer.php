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
	
	<!-- Table handles question voting up down, similar to answer voting -->
<!-- $numUpvotes = $numUpvotes."-".$ans_id."-".$q_id;
                  $score = $upvotes - $downvotes;-->
  <table> <!-- check to see if user has voted for question similar to how it's done for answers -->
  <tr><th><h1 id="questionAnswerPage"><?php echo $row['question_title']; ?></h1><th><tr>
  <tr>
        <td><h3><?php echo $row['question']; ?></h3></td>
        <td><table> <!-- Beginning of table that handles upvote of questions etc-->
           
            <?php
            echo "<tr>";
                             
                  //Determine if user has voted for question previously
                  
                  $userHasVotedForQuestion = FALSE;

                  $lid = $_SESSION['user_id'];
                
                  $userVoted3 = "SELECT voter_id FROM questionVotes WHERE voter_id=$lid and question_id = $q_id";
                  $result3 = $conn->query($userVoted3);
                  // If any records of this user voting for this question exist then set bool to true
                  if(mysqli_num_rows($result3) > 0)
                  {
                    $userHasVotedForQuestion = TRUE;
                    //echo "<br><br>user has already voted for this question!";
                  }
                  
                  $sqlQ = "SELECT num_upvotes, num_downvotes FROM questions WHERE question_id=$q_id";
              
                  $result2 = $conn->query($sqlQ);
                  $row2 = $result2->fetch_assoc();
                  $numQuestionUpvotes = $row2["num_upvotes"];
                  $numQuestionDownvotes = $row2["num_downvotes"];
                               
                  $numQuestionUpvotes = $numQuestionUpvotes."-".$q_id;
                  $numQuestionDownvotes = $numQuestionDownvotes."-".$q_id;
                  $QScore = $numQuestionUpvotes - $numQuestionDownvotes;
              
                  if(!$userHasVotedForQuestion)
                  {
                    echo "<form name=\"questionUpVotingForm\" method=\"post\" action=\"question_upvote.php\">";
                    echo "<button type=\"submit\" name=\"Qupvote\" value=\"$numQuestionUpvotes\"> 
                          <span class=\"glyphicon glyphicon-chevron-up\"></span>
                          </button>
                          </form>";
                  }
                  else
                  {
                    echo "<span class=\"glyphicon glyphicon-chevron-up\"></span>";
                  }
        echo "</tr>
              <tr>";
                  //Put question score here
                  echo str_repeat('&nbsp;', 6).$QScore;
        echo "</tr>
              <tr>";
                
                if(!$userHasVotedForQuestion)
                  {
                echo "<form name=\"questionDownVotingForm\" method=\"post\" action=\"question_downvote.php\">";
              
              
                  echo "<button type=\"submit\" name=\"Qdownvote\" value=\"$numQuestionDownvotes\"> 
                    <span class=\"glyphicon glyphicon-chevron-down\"></span>
                  </button>
                  </form>";
                }
                else{
                  echo "<span class=\"glyphicon glyphicon-chevron-down\"></span>";
                }
        echo "</tr>";        
              ?>
                
        </table></td> <!-- End of table that handles upvote of questions etc-->
  </tr>
	
  <table align="right">
  
  <th><th>
	<th valign="middle"><h3><?php echo "<h3>".$row['user_name']."</h3>"; ?></h3></th>
  <th>
  <?php 
            $askerID = $row["asker_id"];
            $sql = "SELECT `data` FROM `images` WHERE avatar_user_id=$askerID";
            $resultA = $conn->query($sql);              
            $rowA = $resultA->fetch_assoc();
            
            echo "<img style=\"width:64px;height:64px\" src=\"data:image/jpeg;base64,"   .base64_encode( $rowA['data'] ).   "\"/>";
           
          ?>
  </th>

  </table>

	
<!--PREVIOUS ANSWERS TABLE BELOW-->
	
		
	<?php
	$sql = "SELECT answer_id, answer, responder_id, is_best, num_upvotes, num_downvotes, user_name 
			FROM answers 
      JOIN users 
      WHERE question_id=$q_id 
      and responder_id=user_id
      ORDER BY is_best DESC, (num_upvotes-num_downvotes) DESC";
	  /////VERIFIES LOGGED IN USER IS THE ASKER, IF USER IS THE ASKER THEN GIVE OPTION TO SELECT BEST ANSWER     
  
      $getAskerID = "SELECT asker_id, is_solved FROM questions WHERE question_id=$q_id";
      $result = $conn->query($getAskerID);
      $questionInfo = $result->fetch_assoc();

     
      $askerID = $questionInfo["asker_id"];
      
      $loggedInID = $_SESSION['user_id'];
      $is_solved = $questionInfo["is_solved"];

      //Voter stuff
      $userVoted = "SELECT voter_id, is_upvote FROM votes WHERE voter_id=$loggedInID and question_id = $q_id";
      $result2 = $conn->query($userVoted);
      $voterInfo = $result2->fetch_assoc();
      //echo "q id:".$q_id;
      //echo "Voter id:".$voterInfo["voter_id"].", upvote yes or no: ".$voterInfo["is_upvote"];

      $userHasVoted = FALSE;
      //if records come back showing that user has voted for a response for this question then userHasVoted
      if(mysqli_num_rows($result2) > 0)
      {
        $userHasVoted = TRUE;
      }
      
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
      
          //Answer id, responder id etc
          $ans_id = $row["answer_id"];
          $responderID = $row["responder_id"];
          
          $_SESSION["answer_id"] = $ans_id;
          
          $numUpvotes = $row["num_upvotes"];
          $numDownvotes = $row["num_downvotes"];    
        	
          $upvotes = $row["num_upvotes"];
          $downvotes = $row["num_downvotes"];
          
          $is_best = $row["is_best"];

          //External viewer and profile vars
          // Store url, user id info in case of redirect to view external users profile
          $_SESSION["user_id_profile"] = $responderID;
          $_SESSION["user_id_name"] = $row["user_name"];
          $path = 'profile.php?ext_user='.$_SESSION["user_id_profile"].'&ext_user_name='.$_SESSION["user_id_name"];  // change accordingly

          ////Check to see if user has uploaded photo already
          $UserHasPhoto = FALSE;

          $queryB = "SELECT * FROM `images` WHERE avatar_user_id=$responderID";
          $resultB = $conn->query($queryB);
          if(mysqli_num_rows($resultB) > 0)
          {
            $UserHasPhoto = TRUE;
          }

        	echo "<br><br><br><hr><table>";
        	echo "<tr>
        		<td id=\"answerTD\"><p id=\"responseBody\">".$row["answer"]."</p></td>
            <td id=\"answerTD\"> 
        			<table>
        			
        			<form name=\"bestAnswerForm\" method=\"post\" action=\"selectbestanswer.php\">";
        			
          
        	/* Display Check or Flag based on whether best answer is selected */
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
        			"<tr> <span class=\"glyphicon glyphicon-thumbs-up\"></span> </tr>";}
			            
          echo "</form>"; // End of form that handles best answer selection

          ////// FORM BELOW HANDLES UPVOTING ///////
          echo "<form name=\"upVotingForm\" method=\"post\" action=\"upvote.php\">";
          
            
            if(!$user_is_guest) 
            { //numUpvotes contains the num of upvotes as well as the answer id, break apart once to php file
              if(!$userHasVoted)//If user hasn't voted then add their vote in prior to form submit
                {
                  $numUpvotes = $numUpvotes."-".$ans_id."-".$q_id;
                  $score = $upvotes - $downvotes;
              echo "<tr> <button type=\"submit\" name=\"upvote\" value=\"$numUpvotes\"><span class=\"glyphicon glyphicon-chevron-up\"></span>";
              echo $score;
              echo "</button> </tr>";
                }
                else{
                      $score = $upvotes - $downvotes;
                      echo "<tr> <span class=\"glyphicon glyphicon-chevron-up\"></span>";
                      echo str_repeat('&nbsp;', 5).$score;
                      echo "</tr>";
                    }
              

            }
            echo "</form>";

          /// FORM BELOW HANDLES DOWNVOTING ////

          echo "<form name=\"downVotingForm\" method=\"post\" action=\"downvote.php\">";
          
          
            if(!$user_is_guest) 
            {
              if(!$userHasVoted)
                {
                  $numDownvotes = $numDownvotes."-".$ans_id."-".$q_id;
                  echo "<tr> <button type=\"submit\" name=\"downvote\" value=\"$numDownvotes\"><span class=\"glyphicon glyphicon-chevron-down\"></span></button> </tr>";
                }
                else{
                  $score = $upvotes - $downvotes;
                      echo "<tr> <span class=\"glyphicon glyphicon-chevron-down\"></span>";
                      echo "</tr>";
                }
              
            }
          echo "</form>";
          ///////

        		echo "</table>
        		</td>
        		</tr>";
            
            // User avatar and user name below
            //echo $responderID;
            $sql = "SELECT `data` FROM `images` WHERE avatar_user_id=$responderID";
            //echo $sql;
            $result9 = $conn->query($sql);              
            $row9 = $result9->fetch_assoc();
            
              
            
            echo"<tr>";
            echo "<td><div align=\"right\"><a href=".$path.">".$row["user_name"]."</a></div></td>";
            if($UserHasPhoto)
            {
            echo "<td><div align =\"right\">".'<img style="width:64px;height:64px" src="data:image/jpeg;base64,'.base64_encode( $row9['data'] ).'"/>'."</div></td>";
            }
            else{
              echo "<td><div align =\"right\"><span style=\"font-size:3em;\" class=\"glyphicon glyphicon-user\"></span></div></td>";
            }

            echo "</tr>";

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
