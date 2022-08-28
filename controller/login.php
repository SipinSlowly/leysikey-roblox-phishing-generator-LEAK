<?php
session_start();
error_reporting(0);
include("../web/setup/setup.php");
include("../web/setup/database.php");
include("../includes/functions.php");
if($_SESSION["controller"]){
header("Location: login");
}else{
if($_SERVER["REQUEST_METHOD"] == "POST"){
  if($_POST["token"]){
  $controller = htmlspecialchars($_POST["token"]);
  $check = pdoQuery($db, "SELECT `controller` FROM `east` WHERE `controller`=?", [htmlspecialchars($controller)])->fetchColumn();
  if($check){
    $_SESSION["controller"] = "$controller";
    header("Location: index.php");
  }else{
      $error = htmlspecialchars("Invalid Controller Token!");
  }
  }
}
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?= $siteName; ?> - Controller</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= $mainpfp; ?>">
    <link rel="stylesheet" type="text/css" href="new/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="new/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="new/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <link rel="stylesheet" type="text/css" href="new/vendor/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="new/vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" type="text/css" href="new/vendor/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="new/css/util.css">
    <link rel="stylesheet" type="text/css" href="new/css/main.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </head>
  <body>
    <div class="limiter">
      <div class="container-login100" style="background-image: url('<?= $mainpfp; ?>');">
        <div class="wrap-login100 p-t-190 p-b-30">
          <form class="login100-form validate-form" method="POST">
            <?php
            if($error){
              echo "<script>Swal.fire( 'Failure', '$error', 'error' )</script>";
            }
            ?>
                          <span class="login100-form-title p-t-20 p-b-45"> <?= $siteName; ?> </span>
            <div class="wrap-input100 validate-input m-b-10" data-validate="Token is required">
              <input class="input100" type="text" name="token" placeholder="<?= $controllerpath; ?>-A1B2C3E4F5">
              <span class="focus-input100"></span>
              <span class="symbol-input100">
                <i class="fa fa-lock"></i>
              </span>
            </div>
            <div class="container-login100-form-btn p-t-10">
              <input type="submit" name="submit" class="login100-form-btn" value="Login">
            </div>
            <div class="text-center w-full p-t-25 p-b-230"></div>
          </form>
        </div>
      </div>
    </div>
    <script src="new/vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="new/vendor/bootstrap/js/popper.js"></script>
    <script src="new/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="new/vendor/select2/select2.min.js"></script>
    <script src="new/js/main.js"></script>
  </body>
</html>
