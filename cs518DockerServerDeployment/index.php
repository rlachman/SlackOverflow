<?php
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
$HTTPSTATUS_BADREQUEST = 400;
$HTTPSTATUS_OK = 200;
$HTTPSTATUS_NOTFOUND = 404;

$ROOTURI = "http://wsdl-docker.cs.odu.edu:60020";

#$githubURI_usersDirectory = "https://raw.githubusercontent.com/machawk1/ODUCS418/spring2015/users/";
$githubURI_usersDirectory = "https://raw.githubusercontent.com/jbrunelle/ODUCS418F16/master/users/";



// GITHUB CREDENTIALS for API ACCESS
$clientId = "XXXXXXXXXXXx";
$clientSecret = "XXXXXXXXXXXXXXXXx";



	if(isset($_GET['username']) && !empty($_GET["username"])){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $githubURI_usersDirectory.trim($_GET["username"]));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($curl);
		$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		if($httpCode == $HTTPSTATUS_OK) {
			echo $output;
			return;
		}

		http_response_code($HTTPSTATUS_NOTFOUND);

		curl_close($curl);

	}elseif($_POST && isset($_POST['accessToken']) && isset($_POST['repoURI'])){
			$repoName = trim(escapeshellcmd(basename($_POST['repoURI'])));
			$repoName = trim(basename($_POST['repoURI']));
print_R($_POST);
			chdir('/tmp');

			preg_match('/github.com\/(.*)\//',$_POST['repoURI'],$matches);
			$username = $matches[1];

			// Static port on the docker server assigned to students
			$destinationPort = (intval(substr(crc32($username),0,3))+60000);

			$containerId = "ODUCS418_".$username;

			$deleteOldRepoContents = "rm -rf '/tmp/".$username."'";
			$cloneRepo = "cd /tmp; git clone '".trim(str_replace("https://","https://".$_POST['accessToken']."@",$_POST['repoURI']))."' ".$username;
			$killOldInstance = "docker kill ".$containerId;
			$removeOldInstance = "docker rm ".$containerId;


			$launchNewDocker = "cd /tmp/".$username."; docker run -d --name ".$containerId." -p ".$destinationPort.":80 -e MYSQL_PASS=\"5pR1nG2OlS\" -v `pwd`:/app mkelly/lamptest";

			echo "<html><head><script src=\"jquery-1.11.2.min.js\"></script><script src=\"update.js\"></script></head><body>";
			$output = shell_exec($deleteOldRepoContents);
			echo "<ul>";
			echo "<li>Deleting local working copy of repo.</li>";
			$output = shell_exec($cloneRepo);
			echo "<li>Cloning current repo. $output</li>";
			$output = shell_exec($killOldInstance);
			echo "<li>Killing any previous docker instances you've launched.</li>";
			$output = shell_exec($removeOldInstance);
			echo "<li>Removing any previous docker instance.</li>";
			$output = shell_exec($launchNewDocker);
			echo "<li>Launching new docker instance with your code at <a id=\"uri\" href=\"http://wsdl-docker.cs.odu.edu:".$destinationPort."\" target=\"_blank\">http://wsdl-docker.cs.odu.edu:".$destinationPort."</a> in the next 10 seconds.</li>";
			echo "<li>See the <a target=\"_blank\" href=\"http://wsdl-docker.cs.odu.edu:60020/logs.php?csusername=".$username."\">Docker logs</a> for debugging.</a>";
			echo "</ul>";

			$output = shell_exec("find /tmp/".$username." -type d -exec chmod 777 {} \;");

			echo "</body></html>";
			die();
	}elseif(empty($_GET["username"])){
			http_response_code($HTTPSTATUS_BADREQUEST);
	}


	$state = $_GET['csusername'];
	if($_GET && isset($_GET['state'])){$state = $_GET['state'];}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>CS418 Docker deployment system</title>
<link rel="stylesheet" type="text/css" href="cs418deployment.css" />
<script type="text/javascript" src="cs418deployment.js"></script>
<script>
	function authenticateWithGitHub(){
		//alert("hi there " + document.getElementById('csusername').value + "!");
		window.location.href = "https://github.com/login/oauth/authorize?client_id=<?=$clientId ?>&scope=repo&state="+document.getElementById('csusername').value;
	}
</script>
</head>
<body>
<!-- TODO: add license for this code/html -->
<h1>CS418 Docker Deployment System</h1>

<p>This system is setup for students' use in testing the development of their projects for CS418 on a system that uses Docker (which is also used on Demo Day). To use the system:</p>

<dl>
	<dt>Enter your CS user id.</dt>
	<dd>This is used to pull the repository you specified in Assignment 1 from the users directory in the class repository.</dd>

	<dt>Authenticate</dt>
	<dd>This will allow the system to deploy your code from GitHub.</dd>

	<dt>Deploy your code</dt>
	<dd>If authentication is successful, a "Dockerize my code" button will appear. Press it to deploy the code from your master branch.</dd>

	<dt>Access &amp; Test your code</dt>
	<dd>The system will return a URI where your deployed code can be accessed and a means to kill the instance.</dd>
</dl>

<form>
	<label for="csusername">CS Username (press 'tab' to complete):</label>
	<input type="text" value="<?= $state ?>" placeholder="CS username" id="csusername" name="csusername" autocomplete="off" /><br>
	<input type="submit" value="Find my repo" onclick="updateRepoFromCSUsername()" />
</form>




<h2>Source Repository: <span id="srcRepo">none</span></h2>

<?php
		if($_GET && isset($_GET['code'])){

			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL,"https://github.com/login/oauth/access_token");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,
						http_build_query(array(
							'code' => $_GET['code'],
							'client_id' => $clientId,
							'client_secret' => $clientSecret

						))
					);
			curl_setopt($ch, CURLOPT_HTTPHEADER,array("Accept: application/json"));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec ($ch);
			curl_close ($ch);


			$json = json_decode($server_output,true);
			echo print_r($json);
			if(	!$json ||
					!isset($json['access_token']) ||
					strpos($json['access_token'],' ') !== FALSE){echo "Bad access token. <a href='$ROOTURI'>Reload the page.</a> Try again.";die();}

			$accessToken = json_decode($server_output,true)["access_token"];

			if($_COOKIE && isset($_COOKIE['dockerdeploy'])){
				//echo "Already have cookie: ".$_COOKIE['dockerdeploy'];

			}else {
				//echo "setting cookie";
				setcookie("dockerdeploy",$accessToken);
			}

			?>

			<form method="post" action="/" id="deploy">
				<input type="hidden" value="<?=$accessToken ?>" name="accessToken" />
				<input type="hidden" value="" name="repoURI" id="repoURI" />
				<input type="submit" value="Dockerize my code"  />
			</form>
			<?php

	}else {
		echo "<button id=\"githubAuthButton\" disabled=\"disabled\">Authenticate with GitHub</button>";
	}
?>

</body>
</html>
