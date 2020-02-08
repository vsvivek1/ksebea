<?php 
/**
 *@version		1.0
 *@name			class.state.php
 *@abstract		State Class
 *@author		maheep vm
 *@since		27-06-2017
 **/

require_once __DIR__ . '/class.connection.php';

class State{
	
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

	public function getStatesList()
	{
		$query = "select * from gst_states order by state_codes::integer asc";
		$result = $this->dbConnection->executeTrans($query);
		if(isset($result['EOF']))
			return null;
		else
			return $result;
	}
	
	public function checkStateCode($stateCode)
	{
		$query = "select count(*) from gst_states where state_codes='".$stateCode."' ";
		$result = $this->dbConnection->executeTrans($query);
		if(isset($result['EOF']))
			return false;
		else 
			return $result[0]['count'];
	}
	
	
}


?>