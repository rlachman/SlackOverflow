<?php
		session_start();

		$servername = "localhost";
        $username = "admin";
        $password = "M0n@rch$";
        $dbname = "slackoverflow";
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        $stmt = $conn->prepare("INSERT INTO `questions` (`question_title`, `question`, `asker_id`) VALUES (?,?,?)");
        $stmt->bind_param("sss", $question_title, $question_body, $user_id);
		
		if ($conn->connect_error) {
    	die("Connection failed: " . $conn->connect_error);
		} 
		if(!$conn->connect_error)
		{
			echo "Connection OKAY.";
		}

        $qTitle = $_POST[questionTitle];
        $qBody = $_POST[questionBody];
        
        //Establish connection
        $question_title = htmlspecialchars($qTitle);//addslashes($_POST[questionTitle]);
        //echo "<br>Question Title: ".$question_title;

        $question_body = htmlspecialchars($qBody);//addslashes($_POST[questionBody]);
        //echo "<br>Question Body: ".$question_body;

        
        $user_id = $_SESSION['user_id'];
        //echo "<br>User ID: ".$user_id;
        $stmt->execute();
	
        header('Location: home.php');

        ?>