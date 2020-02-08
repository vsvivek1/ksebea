<?php 
/**
 *@version		1.0
 *@name			class.errorLog.php
 *@abstract		ErrorLog Class
 *@author		maheep vm
 *@since		28-06-2017
 **/

require_once __DIR__ . '/class.connection.php';

class ErrorLog{
	
	private $dbConnection;
	
	public function __construct($dbConnection=null)
	{
		if($dbConnection instanceof DBConnection)
		{
			$this->dbConnection = $dbConnection;
		}
		else 
		{
			$this->dbConnection = new DBConnection();
		}
	}

	public function saveErrorLog($string)
	{
		$msg = base64_encode($string);
		$query = "insert into gst_error_log (message) values ($msg)";
		$this->dbConnection->executeTrans($query);
	}
	
}


?>