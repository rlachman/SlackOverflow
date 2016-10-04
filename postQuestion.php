<?php
		session_start();

		$servername = "localhost";
        $username = "root";
        $password = "odu2017";
        $dbname = "slackoverflow";
        
        $conn = new mysqli($servername, $username, $password, $dbname);
		
		if ($conn->connect_error) {
    	die("Connection failed: " . $conn->connect_error);
		} 
		if(!$conn->connect_error)
		{
			echo "Connection OKAY.";
		}
        
        //Establish connection
        $question_title = $_POST[questionTitle];
        echo "<br>Question Title: ".$question_title;

        $question_body = $_POST[questionBody];
        echo "<br>Question Body: ".$question_body;

        
        $user_id = $_SESSION['user_id'];
        echo "<br>User ID: ".$user_id;
	
        $insert_query = "INSERT INTO questions (question_title,question,asker_id)
        				VALUES ('$question_title','$question_body',$user_id)";

       if ($conn->query($insert_query) === TRUE) {
    	echo "<br>Your question has been posted!";
		} else {
    	echo "Error: " . $insert_query . "<br>" . $conn->error;
		}
        
		//Redirect back to home page after submitting
		header('Location: home.php');
        ?>