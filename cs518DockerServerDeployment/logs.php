<?php

if(empty($_GET['csusername'])){echo "No logs."; return;}

$username = $_GET['csusername'];

$output = str_replace("\n","<br />",shell_exec('docker logs ODUCS418_'.$username.' 2>&1'));
echo $output;
?>