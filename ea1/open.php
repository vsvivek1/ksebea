<?php
session_start();
include_once("common.class.php");

$login=user::login($_POST[user],$_POST[pass]);

if($login==true)

{
	
	//print_r($_POST);
	include_once("ksebea.php");
	
	
	
	}





?>
