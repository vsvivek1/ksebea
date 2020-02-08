<?php 
/**
 *@version		1.0
 *@name			class.gstRate.php
 *@abstract		GSTRate Class
 *@author		maheep vm
 *@since		15-06-2017
 **/

require_once __DIR__ . '/class.connection.php';
require_once __DIR__ . '/class.log.php';

class GSTRate{
	
	private $dbConnection;
	public $log;
	
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
		$this->log = new Log($this->dbConnection);
	}

	public function getGstRateSlabs($slabId=null,$liveOnly=true)
	{
		$andCondition = ($slabId!=null && $liveOnly!=false)? ' and ' : '';
		$whereCondition = ($slabId==null && $liveOnly==false)? '' : ' where ';
		$liveCondition = ($liveOnly)? ' is_live ':'';
		$slabCondition = ($slabId && is_numeric($slabId))? " id=$slabId " : '';
		
		$query = "select * from gst_tax_slabs $whereCondition $slabCondition $andCondition $liveCondition ";
		$result = $this->dbConnection->executeTrans($query); //print_r($result);
		if(isset($result['EOF']))
		{
			return null;
		}
		return $result;
	}
	
	public function saveGstRateSlab($cgstRate,$sgstRate,$igstRate,$replaceTaxSlabWithId=null)
	{
		$cgstRate = (is_numeric($cgstRate))? $cgstRate : "null";
		$sgstRate = (is_numeric($sgstRate))? $sgstRate : "null";
		$igstRate = (is_numeric($igstRate))? $igstRate : "null";
		
		if($replaceTaxSlabWithId)
		{
			if(!is_numeric($replaceTaxSlabWithId))
			{
				return false;
			}
			$query = "select count(*) from gst_tax_slabs where id=$replaceTaxSlabWithId";
			$result = $this->dbConnection->executeTrans($query);
			if(isset($result['EOF']))
			{
				return false;
			}
			if(!$result[0]['count'])
			{
				return false;
			}
			$oldRate = $this->getGstRateSlabs($replaceTaxSlabWithId);
			if($oldRate)
			{
				$this->log->setLogId($oldRate[0]['log_id']);
				$this->log->setReferenceLogId($oldRate[0]['log_id']);
				$this->log->setAction('E');
			}
		}
		$savedLogId = $this->log->saveLog();
		if(!$savedLogId)
		{
			return false;
		}
		$query = "select max(id) as last_id from gst_tax_slabs limit 1";
		$result = $this->dbConnection->executeTrans($query);
		if(isset($result['EOF']))
		{
			return false;
		}
		$nextId = $result[0]['last_id']+1;
		$query = "insert into gst_tax_slabs (id,cgst_rate,sgst_rate,igst_rate,log_id) values ($nextId,$cgstRate,$sgstRate,$igstRate,$savedLogId)";
		$result = $this->dbConnection->executeTrans($query);
		if(isset($result['EOF']))
		{
			if($result['EOF']==1)	//error
				return false;
		}
		if($replaceTaxSlabWithId)
		{
			$query = "update gst_tax_slabs set is_live=false,log_id=$savedLogId where id=$replaceTaxSlabWithId";
			$result = $this->dbConnection->executeTrans($query);
			if(isset($result['EOF']))
			{
				if($result['EOF']==1)	//error
					return false;
			}
		}
		return $nextId;
	}
	
	public function updateGstRateSlab($slabId,$cgstRate,$sgstRate,$igstRate,$status)
	{
		if(is_numeric($slabId)&&is_numeric($cgstRate)&&is_numeric($sgstRate)&&is_numeric($igstRate))
		{
			$rate =	$this->getGstRateSlabs($slabId,false);
			if($rate)
			{
				$rate = $rate[0];
				$this->log->setLogId($rate['log_id']);
				$this->log->setReferenceLogId($rate['log_id']);
				$this->log->setAction('E');
				$savedLogId = $this->log->saveLog();
				if(!$savedLogId)
				{
					return false;
				}
				$liveStatus = ($status)? "true" : "false";
				$query = "update gst_tax_slabs set cgst_rate=$cgstRate,sgst_rate=$sgstRate,igst_rate=$igstRate,log_id=$savedLogId,is_live=$liveStatus where id=$slabId ";
				$result = $this->dbConnection->executeTrans($query);
				if(isset($result['EOF']))
				{
					if($result['EOF']==1)	//error
						return false;
				}
				return true;
			}
			else 
				return false;
		}
		else 
			return false;
	}
	
}


?>