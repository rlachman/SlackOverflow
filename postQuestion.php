<?php
		function bb2html($text)
        {
                $bbcode = array("<", ">",
                "[list]", "[*]", "[/list]", 
                "[img]", "[/img]", 
                "[b]", "[/b]", 
                "[u]", "[/u]", 
                "[i]", "[/i]",
                '[color="', "[/color]",
                "[size=\"", "[/size]",
                '[url="', "[/url]",
                "[mail=\"", "[/mail]",
                "[code]", "[/code]",
                "[quote]", "[/quote]",
                '"]');
                $htmlcode = array("&lt;", "&gt;",
                "<ul>", "<li>", "</ul>", 
                "<img src=\"", "\">", 
                "<b>", "</b>", 
                "<u>", "</u>", 
                "<i>", "</i>",
                "<span style=\"color:", "</span>",
                "<span style=\"font-size:", "</span>",
                '<a href="', "</a>",
                "<a href=\"mailto:", "</a>",
                "<code>", "</code>",
                "<table width=100% bgcolor=lightgray><tr><td bgcolor=white>", "</td></tr></table>",
                '">');
        $newtext = str_replace($bbcode, $htmlcode, $text);
        $newtext = nl2br($newtext);//second pass
  return $newtext;
}
        session_start();

		$servername = "localhost";
        $username = "admin";
        $password = "M0n@rch$";
        $dbname = "slackoverflow";
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        $stmt = $conn->prepare("INSERT INTO `questions` (`question_title`, `question`, `asker_id`, `tags`) VALUES (?,?,?,?)");
        $stmt->bind_param("ssss", $question_title, $question_body, $user_id, $question_tags);
		
		if ($conn->connect_error) {
    	die("Connection failed: " . $conn->connect_error);
		} 
		if(!$conn->connect_error)
		{
			echo "Connection OKAY.";
		}

        $response = $_POST['g-recaptcha-response'];
        echo $response;
        $qTitle = $_POST[questionTitle];
        $qBody = $_POST[questionBody];
        $secret_key = "6Lctxw0UAAAAABxFZ-xcOPBHYdJCp3tob6SiI0sY";
        
        if(!empty($response))
        {
            
            echo "<br>Inside the IF statement <br>Response: ".$response;
            $api_url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response='.$response;
            echo "<br>Api url: ".$api_url."<br>";
            $response = @file_get_contents($api_url);
            $data = json_decode($response, true);

            if($data['success'] == true)
            {
                echo "<br>Success returned true from Google, Returned bool: ".$data['success'];
                // process comment here
                $success = true;
            }
            else if($data['success'] == false)
            {
                echo "<br>Success returned true from Google,  Returned bool: ".$data['success'];
                $success = false;
            }
        }
        else //if response is empty
        {
            echo "Not inside the if statement";
            $success = false;
        }
        
        //Establish connection
        $question_title = htmlspecialchars($qTitle);//htmlspecialchars($qTitle);//addslashes($_POST[questionTitle]);
        //echo "<br>Question Title: ".$question_title;

        $question_body = bb2html($qBody);//htmlspecialchars($qBody);//addslashes($_POST[questionBody]);
        //echo "<br>Question Body: ".$question_body;

        
        $user_id = $_SESSION['user_id'];

        $question_tags = $_POST[questionTags];
        //echo "<br>User ID: ".$user_id;
        if($success==true and !empty($success)) 
            {
                $stmt->execute();
                echo "<br>Inserted!!";
            }
            else{
                echo "<br>Not Inserted!!!";
            }
	
        header('Location: home.php');

        ?>