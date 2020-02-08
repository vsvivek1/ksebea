<?php 
/**
 *@version		1.0
 *@name			class.connection.php
 *@abstract		DBConnection Class
 *@author		maheep vm
 *@since		15-06-2017
 **/

require_once __DIR__ . '/../lib/adodb/adodb.inc.php';
require_once __DIR__ . '/../lib/adodb/adodb-exceptions.inc.php';
require_once __DIR__ . '/../lib/adodb/tohtml.inc.php';
require_once __DIR__ . '/class.errorLog.php';

@date_default_timezone_set('Asia/Kolkata');

//set_error_handler(create_function('', "throw new Exception(); return true;"));	 
// this will handle  php, adodb & logical errors
class DBConnection
{
	private static $db;
	private $connection;
	private $exitedOnError;

	private static $dbn="saras";
 	private static $usrnm = "saras";
 	private static $passwd = "123";
 	private static $hostnm	= "10.0.1.50";	//mysql.hostinger.in  //localhost
 	
	public function __construct()
	{
		$this->createConnection();
	}
/*	
	private function getConnection()
	{
		if($this->db == null)
		{
			$this->db = new DBConnection();
		}
		return $this->db->connection;
	}
*/	
	private function createConnection()
	{
		try
		{
			$this->connection = ADONewConnection('postgres');  //'mysql'
			if ($this->connection==false)
				die('DATA BASE CONNECTION ERROR');
				else
				{
					$this->connection->debug=false;
					@$this->connection->PConnect(self::$hostnm, self::$usrnm, self::$passwd, self::$dbn);
					//$db->Pconnect('host=localhost   port=5432 dbname='.$dbn.' user=postgres');
					//$db->Pconnect('host=172.16.200.139   port=5432 dbname='.$dbn.' user=postgres');
					$this->connection->SetFetchMode(ADODB_FETCH_ASSOC);
					$this->exitedOnError = false;
				}
		}
		catch (Exception $e)
		{
			die('DATABASE CONNECTION ERROR'); // . $e->msg);
		}
	}
	
	public function beginTrans()
	{
		$this->connection->StartTrans();
		$this->exitedOnError = false;
	}
	
	public function executeTrans($query)
	{
//		echo $query;
		$aryReturn = array();
		try
		{
			if(!$this->exitedOnError)
			{
				$result = $this->connection->Execute($query);
				if ($this->connection->HasFailedTrans())
				{
					$aryReturn['EOF'] = 1;
					$aryReturn['message'] = "Reading Data failed";
				} 
				elseif($result->EOF)
				{
					$aryReturn['EOF'] = 2;
					$aryReturn['message'] = 'No Data';
				}
				elseif($result)
				{
					$aryReturn = $result->getArray();
				}
			}
			else 
			{
				$aryReturn['EOF'] = 1;
				$aryReturn['message'] = 'Already exited on error!';
			}
		}
		catch (Exception $e)
		{
			$this->rollBackTrans();
			$errLog = new ErrorLog($this);
			$errLog->saveErrorLog($e->getMessage());
			$this->exitedOnError = true;
			$aryReturn['EOF'] = 1;
			$aryReturn['message'] = 'Error in operation!';//echo $e->getMessage(); die();
		}
		return $aryReturn;
	}
	
	public function commitTrans()
	{
		$this->connection->CompleteTrans();
		$this->exitedOnError = false;
	}
	
	public function rollBackTrans()
	{
		$this->connection->FailTrans();
		$this->connection->CompleteTrans();
	}
	
	public function closeConnection()
	{
		@pg_close($this->connection);
		$this->connection = false;
		return true;
	}

}

?>
