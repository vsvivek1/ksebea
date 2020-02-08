<?php
session_start();
include_once("./class/class.php");

$login=user::validate_user($_POST[user],$_POST[pass]);

if($login==true)

{
	
	//header('Location: ./content/home.php');
	require_once __DIR__ ."./content/home.php";
	
	
	
	}





?>
