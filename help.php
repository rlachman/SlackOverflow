<?php

	require_once("session.php");
  require_once("dbconfig.php");
	
	require_once("class.user.php");
	$auth_user = new USER();
	$user_id = $_SESSION['user_session'];
	
	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
  $user_is_guest = $userRow['is_guest'];

  // SQL CONNECTION  
$servername = "localhost";
$username = "admin";
$password = "M0n@rch$";
$dbname = "slackoverflow";
$conn = new mysqli($servername, $username, $password, $dbname);
	
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

            if($auth_user->is_loggedin() and $user_name != "guest" and $user_is_guest == FALSE)
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
          <a href="help.php"><span class="glyphicon glyphicon-book"></span> Help</a>
          <?php if($_SESSION['isAdmin']) echo '<a href="admin.php"><span class="glyphicon glyphicon-cog"></span> AdminCP</a>'; ?>
          </h1>
        <hr />

        <p>
          <H1>FAQ</H1>
          <HR>

          <B>What is SlackOverflow?</B><BR>
          <BLOCKQUOTE>SlackOverflow is a question and answer forum.</BLOCKQUOTE>

          <B>How do I ask a question?</B><BR>
          <BLOCKQUOTE>You must <a href="sign-up.php"> Sign Up</a> to SlackOverflow to ask or answer any questions.</BLOCKQUOTE>

          <B>How do I sign up?</B><BR>
          <BLOCKQUOTE>To sign up you must click the Guest drop down menu on the top right of the page and choose <a href="index.php?home=yes"> Sign In</a>. Once at the <a href="index.php?home=yes"> Sign In</a> window, click <a href="sign-up.php"> Sign Up</a> at the bottom.</BLOCKQUOTE>

          <B>What information is needed to sign up?</B><BR>
          <BLOCKQUOTE>To sign up simply enter a Username, Email, and Password on the <a href="sign-up.php"> Sign Up</a> page.</BLOCKQUOTE>

          <B>All signed up, but how do I ask a question?</B><BR>
          <BLOCKQUOTE>In order to ask a question a member can click <a href="ask.php"> Ask</a> at the top of the page.</BLOCKQUOTE>

          <B>How do I add my profile picture?</B><BR>
          <BLOCKQUOTE>To add a profile image navigate to the profile page via <a href="profile.php"> Profile</a> on the top of the page. Once there, click Choose File. Select an image then click Submit. </BLOCKQUOTE>

          <B>How do I see past questions?</B><BR>
          <BLOCKQUOTE>To see any old question navigate to the browse page by clicking <a href="browse.php"> Browse</a> at the top of the page. As a side note if looking for your past asked questions simply navigate to your <a href="profile.php"> Profile</a>.</BLOCKQUOTE>

          <B>What are these arrows next to the questions and answers?</B><BR>
          <BLOCKQUOTE>Next to each question is an Up or Down arrow. These arrows allow members to vote a question up or down. The higher they are voted up the more they move to the top of the questions/answers list. Vice versa for voting down.</BLOCKQUOTE>
        </p>
        
        <hr />


    </div>

</div>


<script src="bootstrap/js/bootstrap.min.js"></script>

</body>

</html>