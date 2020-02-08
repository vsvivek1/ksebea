<?php
/**
 *@version		1.0
*@name			class.log.php
*@abstract		Log Class
*@author		maheep vm
*@since		    16-06-2017
**/

require_once __DIR__ . '/class.connection.php';
require_once __DIR__ . '/../common/common.constants.php';

class Log{
	
	private $dbConnection;
	
	public  $logId;
	public  $referenceLogId;
	public  $action;
	public  $logTime;
	public  $userId;
	public  $officeCode;
	public  $designationId;
	public  $branchId;
	public  $remoteAddr;
	public  $httpXForwardedFor;
	public  $applicationId;
	
	public function __construct($dbConnection=null,$originalLogId=null)
	{
		if($dbConnection instanceof DBConnection)
		{
			$this->dbConnection = $dbConnection;
		}
		else
		{
			$this->dbConnection = new DBConnection();
		}
/*		if(session_id() == '') 
		{
			session_start();
		}
		if(session_status()!=PHP_SESSION_ACTIVE) session_start();
*/		
		@session_start();
		$this->logId = ($originalLogId==null||!is_numeric($originalLogId))? 0 : $originalLogId;
		$this->referenceLogId = ($originalLogId==null||!is_numeric($originalLogId))? 0 : $originalLogId;
		$this->action = ($originalLogId==null)? 'C' : 'E';	//C,E,D
		$this->logTime = date('Y-m-d G:i:s');
		$this->userId = (isset($_SESSION['user_name']))? $_SESSION['user_name']: null;
		$this->officeCode = (isset($_SESSION['office_code']))? $_SESSION['office_code']: null;
		$this->designationId = (isset($_SESSION['designation_id']))? $_SESSION['designation_id']: null;
		$this->branchId = (isset($_SESSION['branch_id']))? $_SESSION['branch_id']: null;
		$this->remoteAddr = (isset($_SERVER['REMOTE_ADDR']))? $_SERVER['REMOTE_ADDR']: null;
		$this->httpXForwardedFor = (isset($_SERVER['HTTP_X_FORWARDED_FOR']))? $_SERVER['HTTP_X_FORWARDED_FOR']: null;
		$this->applicationId = (isset($_SESSION['application_id']))? $_SESSION['application_id']: APPLICATION_ID_INTERNAL;
	}

	public function setLogId($logId)
	{
		$this->logId = $logId;
	}
	
	public function setReferenceLogId($referenceLogId=null)
	{
		$this->referenceLogId = $referenceLogId;
	}
	
	public function setAction($action_C_E_D)
	{
		$this->action = $action_C_E_D;
	}
	
	public function saveLog()
	{
		$query = "select max(id) as last_log_id from gst_log";
		$result = $this->dbConnection->executeTrans($query);
		if(isset($result['EOF']))
		{
			return false;
		}
		else 
		{
			$nextLogId = $result[0]['last_log_id']+1;
			if($this->referenceLogId==0) $this->referenceLogId = $nextLogId; 
			if( ($this->logId > 0) && ($this->action == 'C') )
				$this->setAction('E');
			elseif( ($this->logId == 0) && ($this->action != 'C') )
				$this->setAction('C');
			$act = ($this->action==null)? "null" : "'".$this->action."'";
			$logTm = ($this->logTime==null)? "null" : "'".$this->logTime."'";
			$userID = ($this->userId==null)? "null" : "'".$this->userId."'";
			$offCode = ($this->officeCode==null)? "null" : "'".$this->officeCode."'";
			$desigID = ($this->designationId==null)? "null" : "'".$this->designationId."'";
			$brID = ($this->branchId==null)? "null" : "'".$this->branchId."'";
			$remAddr = ($this->remoteAddr==null)? "null" : "'".$this->remoteAddr."'";
			$httpXAddr = ($this->httpXForwardedFor==null)? "null" : "'".$this->httpXForwardedFor."'";
			$appID = ($this->applicationId==null)? "null" : "'".$this->applicationId."'";
			$query = "insert into gst_log (id,reference_log_id,user_id,action,log_time,office_code,designation_id,branch_id,remote_addr,http_x_forwarded_for,application_id) values ($nextLogId,$this->referenceLogId,$userID,$act,$logTm,$offCode,$desigID,$brID,$remAddr,$httpXAddr,$appID)";
			$result = $this->dbConnection->executeTrans($query);
			if($result['EOF'])
			{
				if($result['EOF']!=1)	//no error
				{
					$this->logId = $nextLogId;
					return $this->logId;
				}
				else
					return false;
			}
			else
			{
				$this->logId = $nextLogId;
				return $this->logId;
			}
		}
	}
	
	public function loadLog($logId)
	{
		$logId = ($logId && is_numeric($logId))? $logId: "null";
		$query = "select * from gst_log where id=$logId limit 1";
		$result = $this->dbConnection->executeTrans($query);
		if(isset($result['EOF']))
		{
			return false;
		}
		$this->logId = $result[0]['id'];
		$this->referenceLogId = $result[0]['reference_log_id'];
		$this->action = $result[0]['action'];
		$this->logTime = $result[0]['log_time'];
		$this->userId = $result[0]['user_id'];
		$this->officeCode = $result[0]['office_code'];
		$this->designationId = $result[0]['designation_id'];
		$this->branchId = $result[0]['branch_id'];
		$this->remoteAddr = $result[0]['remote_addr'];
		$this->httpXForwardedFor = $result[0]['http_x_forwarded_for'];
		$this->applicationId = $result[0]['application_id'];
		return true;
	}

	
}
?>