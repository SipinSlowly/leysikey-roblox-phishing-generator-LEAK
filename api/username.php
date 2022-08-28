<?php
include('stub.php');
$username = all($_GET['username']);
if(isset($_GET['username'])){
    $useridch = $userIdch = file_get_contents("https://api.roblox.com/users/get-by-username?username=$username");
    echo $useridch;
}else{
    die();
}

?>