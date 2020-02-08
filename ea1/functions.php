<?php
session_start();
function con()

{
	
		//$con= pg_pconnect('host=localhost dbname=sports2015s user=postgres password=""');
	$con=pg_pconnect('host=172.16.1.201 dbname=rmu user=postgres password=""');
	return $con;

}


?>
