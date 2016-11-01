<?php
require_once("class.user.php");

// SESSION
session_start();
$login = new USER();
if(isset($_GET["home"]))
{
  $from_home = $_GET["home"];
}

// Will login with credentials if form is submitted via button
if(isset($_POST['btn-login']))
{
	$uname = strip_tags($_POST['txt_uname_email']);
	$umail = strip_tags($_POST['txt_uname_email']);
	$upass = strip_tags($_POST['txt_password']);
		
	if($login->doLogin($uname,$umail,$upass))
	{
		$user_is_guest = FALSE;
    $login->redirect('home.php');
	}
	else
	{
		$error = "Incorrect Username or Password.";
	}
}

// By default user is logged in as guest until they sign out and manually enter credentials
if(isset($_POST['btn-guest-login']) or !isset($_GET["home"]))
{
  $uname = "guest";
  $umail = "guest@guest.com";
  $upass = "adminadmin";
    
  if($login->doLogin($uname,$umail,$upass))
  {
    $login->redirect('home.php');
  }
}
/*End of Guest login process*/

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SlackOverflow | Login</title>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
<link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet"> 
<link rel="stylesheet" href="style.css" type="text/css"  />
</head>
<body>

<div class="signin-form">

	<div class="container">
     
        
       <form class="form-signin" method="post" id="login-form" novalidate>
      
        <h2 id="form-signin-heading">SlackOverflow | Sign In</h2><hr />
        
        <div id="error">
        <?php
			if(isset($error))
			{
				?>
                <div class="alert alert-danger">
                   <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?>
                </div>
                <?php
			}
		?>
        </div>
        
        <div class="form-group">
        <input type="text" class="form-control" name="txt_uname_email" placeholder="Your Username" required />
        <span id="check-e"></span>
        </div>
        
        <div class="form-group">
        <input type="password" class="form-control" name="txt_password" placeholder="Your Password" />
        </div>
       
     	<hr />
        
        <div class="form-group">
            <button type="submit" name="btn-login" class="btn btn-default">
                	<i class="glyphicon glyphicon-log-in"></i> &nbsp; Sign In
            </button>
        </div> 
            <button type="submit" name="btn-guest-login" class="btn btn-default">
                  <i class="glyphicon glyphicon-log-in"></i> &nbsp; Guest Access
            </button>
      	<br />
        <br />
            <label class="sign-in-label">No Account? <a class="sign-in-label" href="sign-up.php">Sign Up</a></label>
      </form>

    </div>
    
</div>

<div class="footer">CS418 - Harrison Hornsby & Ryan Lachman.</div>
</body>
</html>