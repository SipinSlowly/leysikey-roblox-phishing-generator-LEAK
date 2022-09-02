<?php
function checkerusername($user){
    $ch = file_get_contents("https://api.roblox.com/users/get-by-username?username=$user");
    $json = json_decode($ch, true);
if($ch == '{"success":false,"errorMessage":"User not found"}'){
    $error = "Username doesn't exist!";
    return $error;
}else{
    $userId = $json["Id"];
    $ch1 = file_get_contents("https://users.roblox.com/v1/users/$userId");
    $json1 = json_decode($ch1, true);
if($json1["isBanned"] == "true"){
    $error = "User is banned";
    return $error;
}if($json1["name"] == "Roblox"){
    $error = "Error 69";
    return $error;
}  else{
return "success";
}
}
}
echo checkerusername("roblox");
?>