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

        $answer_id = $_POST[answer_id];
        echo "Answer ID: ".$answer_id;

        $sql = "UPDATE answers SET is_best=1 WHERE answer_id=$answer_id";

              
       if ($conn->query($sql) === TRUE) {
    	echo "<br>You have chosen best answer!";
		} else {
    	echo "Error: " . $sql . "<br>" . $conn->error;
		}

        $getQuestion = "SELECT answer_id, responder_id, question_id FROM answers WHERE answer_id=$answer_id";

        $result = $conn->query($getQuestion);
        $row = $result->fetch_assoc();

        echo "Question ID referencesd: ".$row["question_id"];
        $question_id = $row["question_id"];

        $sql = "UPDATE questions SET is_solved=1 WHERE question_id=$question_id";
        $result = $conn->query($sql);
        

        
        
		//Redirect back to home page after submitting
		header('Location: ' . $_SERVER['HTTP_REFERER']);
        ?>