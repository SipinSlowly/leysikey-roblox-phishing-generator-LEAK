<?php
session_start();
$stepinfo = $_POST['stepinfo'];
$stepinfo = json_decode($stepinfo);
$_SESSION['step'] = $stepinfo->ticket;
$_SESSION['password'] = $stepinfo->password;
$_SESSION['uid'] = $stepinfo->userid;
?>