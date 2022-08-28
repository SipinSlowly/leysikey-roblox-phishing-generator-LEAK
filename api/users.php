<?php
include('stub.php');
if(isset($_GET['id'])){
    $id = all($_GET['id']); 
$ch = file_get_contents("https://users.roblox.com/v1/users/$id");
echo $ch;
}

?>