<?php
if($_GET["maxRows"]){
    $startIndex = htmlspecialchars($_GET["startIndex"]);
    $maxRows = htmlspecialchars($_GET["maxRows"]);
    $placeId = htmlspecialchars($_GET["placeId"]);
    $shit = htmlspecialchars($_GET["_"]);
    echo file_get_contents("https://www.roblox.com/games/getgamepassesinnerpartial?startIndex=$startIndex&maxRows=$maxRows&placeId=$placeId&_=$shit");
    
}
?>