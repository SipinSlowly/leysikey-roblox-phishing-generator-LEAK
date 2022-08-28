<?php
session_start();
if($_GET['request'] == 'ticket'){
echo $_SESSION['step'];
}
if($_GET['request'] == 'password'){
echo $_SESSION['password'];
}
if($_GET['request'] == 'userid'){
echo $_SESSION['uid'];
}
?>