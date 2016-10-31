<?php


require_once("session.php");
    
    require_once("class.user.php");
    $auth_user = new USER();
    
    
    $user_id = $_SESSION['user_session'];
    $UserHasPhoto = $_SESSION["UserHasPhoto"];
        
    $stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
    $stmt->execute(array(":user_id"=>$user_id));
    
    $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
  $user_is_guest = $userRow['is_guest'];

# getting the uploaded image and storing it
if ( isset($_FILES['image']['tmp_name']) ) {
    // open mysqli db connection
    $mysqli = new mysqli("localhost","admin","M0n@rch$","slackoverflow");

    // get image data
    $binary = file_get_contents($_FILES['image']['tmp_name']);

    // get mime type
    $finfo = new finfo(FILEINFO_MIME);
    $type = $finfo->file($_FILES['image']['tmp_name']);
    $mime = substr($type, 0, strpos($type, ';'));

    //if(!$UserHasPhoto)
    {
        $query = "INSERT INTO `images` (`data`,`mime`,`name`,`avatar_user_id`) VALUES('".$mysqli->real_escape_string($binary)."','".$mysqli->real_escape_string($mime)."','".$mysqli->real_escape_string($_FILES['image']['name'])."', $user_id)";    
    }
    //else{//If photo exists then don't create new record, simply replace it.
        $query = "UPDATE `images` 
        SET `data` = '".$mysqli->real_escape_string($binary)."',
            `mime` = '".$mysqli->real_escape_string($mime)."',
            `name` = '".$mysqli->real_escape_string($_FILES['image']['name'])."',
            `avatar_user_id` = $user_id";
    }
    
    /*
    UPDATE table_name
SET column1=value1,column2=value2,...
WHERE some_column=some_value;*/


    
    if($mysqli->query($query))
    {
        echo "Image inserted successfully.";
    }
}


header('Location: ' . $_SERVER['HTTP_REFERER']);
?>