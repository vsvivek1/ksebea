<?php
session_start();
//include_once("./class/class.php");
require_once __DIR__ .("/../class/class.php");


$login=user::validate_user($_POST[user],$_POST[pass]);

if($login==true)

	{
	
	//header('Location: ./content/home.php');
	require_once __DIR__ ."/home.php";
	
	
	
	}
	else
	
	{
		
		
		//header('Location: ./../index.php');
		//echo "<h2 class=bg-primary>Invalid Login credentials</h2>";
		
		}





?>
