<?php
require_once("connection.php");
require_once("userclass.php");
session_start();

    $name = $_POST["name"];
    $email = $_POST["email"];
	$phone = $_POST["phone"];
	$address = $_POST["address"];
	
	$password = $_POST["password"];
     
    $passenger=new user();
    $passenger -> createUser($name,$email,$phone,$address,$password, $con);

?>   