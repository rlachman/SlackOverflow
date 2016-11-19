<?php
		session_start();

		$servername = "localhost";
        $username = "admin";
        $password = "M0n@rch$";
        $dbname = "slackoverflow";
        
        $conn = new mysqli($servername, $username, $password, $dbname);
		
		if ($conn->connect_error) {
    	die("Connection failed: " . $conn->connect_error);
		} 
		if(!$conn->connect_error)
		{
			echo "Connection OKAY.";
		}

        $stmt = $conn->prepare("INSERT INTO `answers` (`answer`, `responder_id`, `question_id`) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $answer_body, $user_id, $q_id);
        
        //Establish connection
        $aBody = $_POST[answerBody];
        $answer_body = $aBody;// htmlspecialchars($aBody);//addslashes($_POST[answerBody]);
        //$answer_body = mysql_real_escape_string($answer_body);
        echo "<br>Answer Body: ".$answer_body;

        $q_id = $_POST[questionID];
        echo "<br>Question ID: ".$q_id;
        
        $user_id = $_SESSION['user_id'];
        echo "<br>User ID: ".$user_id."<br>";

        $stmt->execute();
	
        /*$insert_query = "INSERT INTO `answers` (`answer`, `responder_id`, `question_id`) VALUES ('$answer_body',$user_id, $q_id)";
        
                       
       if ($conn->query($insert_query) === TRUE) {
    	echo "<br>Your question has been posted!";
		} else {
    	echo "Error: " . $insert_query . "<br>" . $conn->error;
		}*/

        
        
		//Redirect back to home page after submitting
		header('Location: ' . $_SERVER['HTTP_REFERER']);
        ?>