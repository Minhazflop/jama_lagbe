<?php

require_once("Connection.php");
require_once("userclass.php");
session_start();

$localEmail = $_POST['email'];
$localPassword = $_POST['password'];

$user= new user();
$user ->login($localEmail, $localPassword, $con);
//header("Location: Welcome.php?email=" . $localEmail);
exit();
?>
