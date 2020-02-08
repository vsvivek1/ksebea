<?php 
/**
 *@version		1.0
 *@name			class.hsn.php
 *@abstract		HSNCode Class
 *@author		maheep vm
 *@since		15-06-2017
 **/

require_once __DIR__ . '/class.connection.php';
require_once __DIR__ . '/class.log.php';

class HSNCode{
	
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

	public function searchHsnMasterData($searchKey,$type=1)
	{
		$searchKey = trim($searchKey);
		if($type==1)
		{
			$query = "select * from gst_hsn_master where hsn_code like '".$searchKey."%'";
		}
		else 
		{
			$query = "select * from gst_hsn_master where lower(description) like lower('%".$searchKey."%')";
		}
		$result = $this->dbConnection->executeTrans($query); //print_r($result);
		if(isset($result['EOF']))
			return null;
		else
			return $result;
	}

	
	public function searchHsnCodeData($searchKey,$type=1)
	{
		$searchKey = trim($searchKey);
		if($type==1)
		{
			$query = "select c.*,s.cgst_rate,s.sgst_rate,s.igst_rate from gst_hsn_codes c inner join gst_tax_slabs s on c.tax_slab_id=s.id where c.hsn_code like '".$searchKey."%'";
		}
		else
		{
			$query = "select c.*,s.cgst_rate,s.sgst_rate,s.igst_rate from gst_hsn_codes c inner join gst_tax_slabs s on c.tax_slab_id=s.id where lower(c.description) like lower('%".$searchKey."%')";
		}
		$result = $this->dbConnection->executeTrans($query); //print_r($result);
		if(isset($result['EOF']))
			return null;
			else
				return $result;
	}
	
	
	public function saveHSNCode($hsnCode,$hsnDescription,$unitOfMeasurement,$taxSlabId,$sarasAccCodeArray=null)
	{
		$hsnCode = trim($hsnCode);
		$hsnDescription = trim($hsnDescription);
		$unitOfMeasurement = trim($unitOfMeasurement);
		$taxSlabId = trim($taxSlabId);
		$taxSlabId = ($taxSlabId && is_numeric($taxSlabId))? $taxSlabId: 'null';
		$sarasAccCode = ($sarasAccCodeArray)? '{'. implode(',', $sarasAccCodeArray) . '}' : "{}";
		$query = "select count(*) from gst_hsn_codes where hsn_code='".$hsnCode."'";
		$result = $this->dbConnection->executeTrans($query);
		if(isset($result['EOF']))
		{
			return false;
		}
		$oldHsn = $this->getHsnCodeDetails($hsnCode);
		if($oldHsn)
		{
			$this->log->setLogId($oldHsn[0]['log_id']);
			$this->log->setReferenceLogId($oldHsn[0]['log_id']);
			$this->log->setAction('E');
		}
		$savedLogId = $this->log->saveLog();
		if(!$savedLogId)
		{
			return false;
		}
		if($result[0]['count']>0)
		{
			$query = "update gst_hsn_codes set 
						description='".$hsnDescription."',
						unit='".$unitOfMeasurement."',
						tax_slab_id=$taxSlabId,
						saras_acc_code='".$sarasAccCode."',
						log_id=".$savedLogId."
						where hsn_code='".$hsnCode."'";
		}
		else 
		{
			$query = "select max(id) as last_id from gst_hsn_codes";
			$result = $this->dbConnection->executeTrans($query);
			if(isset($result['EOF']))
			{
				return false;
			}
			$nextId = $result[0]['last_id']+1;	
			$query = "insert into gst_hsn_codes (id,hsn_code,description,unit,tax_slab_id,saras_acc_code,log_id) values (".$nextId.",'".$hsnCode."','".$hsnDescription."','".$unitOfMeasurement."',$taxSlabId,'".$sarasAccCode."',$savedLogId)";
		}
		$result = $this->dbConnection->executeTrans($query);//return json_encode($result);
		if(isset($result['EOF']))
		{
			if($result['EOF']!=1)	//no error
				return true;
			else 
				return false;
		}
		return true;
	}
	
	public function getHsnCodeDetails($hsnCode)
	{
		$hsnCode = trim($hsnCode);
		$query = "select c.*,s.cgst_rate,s.sgst_rate,s.igst_rate,c.tax_slab_id as tax_slab_id from gst_hsn_codes c inner join gst_tax_slabs s on c.tax_slab_id=s.id where c.hsn_code ='".$hsnCode."'";
		$result = $this->dbConnection->executeTrans($query);
		if(isset($result['EOF']))
			return null;
		else
			return $result;
	}

	public function getLastHsnEntry($count)
	{
		$count = (is_numeric($count))? round(trim($count),0) : '0';
		$query = "select c.*,s.cgst_rate,s.sgst_rate,s.igst_rate from gst_hsn_codes c inner join gst_tax_slabs s on c.tax_slab_id=s.id order by c.id desc limit $count";
		$result = $this->dbConnection->executeTrans($query);
		if(isset($result['EOF']))
			return null;
		else
			return $result;
	}
	
	
}


?>