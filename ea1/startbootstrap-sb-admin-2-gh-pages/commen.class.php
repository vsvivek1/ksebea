<?php


class common
{
	__construct()
	{
		
	}
	
	
	
	public static connect()
	
	{		
		
	$con= pg_pconnect('host=localhost dbname=ksebea user=postgres password=""');
	if($con)
	{
		return $con;
	} 		
	else 
	echo "Connection failed";
		include_once("index.php");
		exit;

	}
	
	
	
	
	
	public static login($uname,$pass)
	
	{
	
	self::connect();
	
	$qry="select * from users where user_name=$uname and pass_code=$pass and user_status=1"
	$res=pg_query($qry);
	$ar=pg_fetch_assoc($res);
	
	if($ar[user_name]==$uname && pass_code=$pass)
		return true;
	else 
		return false;	
		
		
	}
	
	
	
	}

?>
