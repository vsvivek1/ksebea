<?php 
/**
 *@version		1.0
 *@name			class.supplyInvoice.php
 *@abstract		GSTSupplyInvoice Class
 *@author		maheep vm
 *@since		28-06-2017
 **/

require_once __DIR__ . '/class.connection.php';
require_once __DIR__ . '/class.log.php';
require_once __DIR__ . '/class.hsn.php';
require_once __DIR__ . '/class.functionLib.php';
require_once __DIR__ . '/class.gstRate.php';
require_once __DIR__ . '/class.state.php';
require_once __DIR__ . '/../common/common.constants.php';

class GSTSupplyInvoice{

	private $lastError;
	private $dbConnection;
	public $log;
	
	public $id;
	public $invoiceType;
	public $tranactionType;
	public $aruCode;
	public $sectionCode;
	public $yearMonth;
	public $slNo;
	public $invoiceNo;
	public $invoiceDate;
	public $modeOfTransport;
	public $vehicleNo;
	public $supplyDate;
	public $supplyPlace;
	public $billingName;
	public $billingAddress;
	public $billingStateCode;
	public $billingGstin;
	public $shippingName;
	public $shippingAddress;
	public $shippingStateCode;
	public $shippingGstin;
	public $sarasGlobalId;
	public $taxableValue;
	public $cgstValue;
	public $sgstValue;
	public $igstValue;
	public $loadingValue;
	public $transportingValue;
	public $refNo;
	public $logId;
	public $itemDetails;

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
		$this->lastError = null;
		$this->itemDetails = array();
	}
	
	public function getLastError()
	{
		return $this->lastError;
	}
	
	public function setInvoiceHeader($transactionType, $invoiceType, $aruCode, $officeCode, $invoiceDate)
	{
		if($transactionType==TRANSACTION_INTERSTATE || $transactionType==TRANSACTION_INTRASTATE)
		{
			$this->tranactionType = $transactionType;
		}
		else 
		{
			$this->lastError = 'Unknown transaction type!';
		}
		if($invoiceType==INVOICE_TYPE_TAXABLE_GOODS || $invoiceType==INVOICE_TYPE_TAXABLE_SERVICE)
		{
			$this->invoiceType = $invoiceType;
		}
		else
		{
			$this->lastError = 'Unknown invoice type!';
		}
		if(strlen($aruCode)==4)
		{
			$this->aruCode = $aruCode;
		}
		else 
		{
			$this->lastError = 'Invalid ARU Code!';
		}
		if(strlen($officeCode)==4)
		{
			$this->sectionCode = $officeCode;
		}
		else
		{
			$this->lastError = 'Invalid Section Code!';
		}
		$funLib = new FunctionLibrary();
		$invoiceDate = $funLib->convertDateTimeStringToSqlTimestamp($invoiceDate,'d/m/Y');
		if($invoiceDate)
		{
			$this->invoiceDate = $invoiceDate;
			$this->yearMonth = $funLib->getYearMonthFromDateTime($invoiceDate);
		}
		else 
		{
			$this->lastError = 'Invalid timestamp of invoice date!';
		}
	}
	
	public function setSupplyDetails($supplyDate, $supplyPlace, $modeOfTransport, $vehicleNo=null)
	{
		$funLib = new FunctionLibrary();
		$supplyDate = $funLib->convertDateTimeStringToSqlTimestamp($supplyDate,'d/m/Y');
		if($supplyDate)
		{
			$this->supplyDate = $supplyDate;
		}
		else
		{
			$this->lastError = 'Invalid timestamp of supply date!';
		}
		try 
		{
			$this->supplyPlace = substr($supplyPlace, 0,20);
			$this->modeOfTransport = substr($modeOfTransport, 0, 20);
			$this->vehicleNo = substr($vehicleNo, 0, 15);
		}
		catch (Exception $e)
		{
			$this->lastError = 'Error in supply details!';
		}
	}
	
	public function setBillingDetails($billingName, $billingAddress, $billingStateCode, $billingGSTIN)
	{
		try
		{
			$this->billingName = substr($billingName, 0,50);
			$this->billingAddress = substr($billingAddress, 0, 180);
			$this->billingGstin = substr($billingGSTIN, 0, 25);
		}
		catch (Exception $e)
		{
			$this->lastError = 'Error in billing details!';
		}
		$state = new State($this->dbConnection);
		if($state->checkStateCode($billingStateCode))
		{
			$this->billingStateCode = $billingStateCode;
		}
		else 
		{
			$this->lastError = 'Invalid billing state code!';
		}
	}
	
	public function setShippingDetails($shippingName, $shippingAddress, $shippingStateCode, $shippingGSTIN)
	{
		try
		{
			$this->shippingName = substr($shippingName, 0,50);
			$this->shippingAddress = substr($shippingAddress, 0, 180);
			$this->shippingGstin = substr($shippingGSTIN, 0, 25);
		}
		catch (Exception $e)
		{
			$this->lastError = 'Error in shipping details!';
		}
		$state = new State($this->dbConnection);
		if($state->checkStateCode($shippingStateCode))
		{
			$this->shippingStateCode = $shippingStateCode;
		}
		else
		{
			$this->lastError = 'Invalid shipping state code!';
		}
	}
	
	public function setSarasGlobalId($sarasGlobalId)
	{
		try
		{
			$this->sarasGlobalId = substr($sarasGlobalId, 0,25);
		}
		catch (Exception $e)
		{
			$this->lastError = 'Error in saras Global ID!';
		}
	}
	
	public function setReferenceNo($refNo,$appId)
	{
		try
		{
			$cnt = 999;
			$query = "select count(*) from gst_supply_invoices i inner join gst_log l on l.id=i.log_id where i.ref_no='".$refNo."' and l.application_id='".$appId."'";
			$result = $this->dbConnection->executeTrans($query);
			if(!isset($result['EOF']))
				$cnt =  $result[0]['count'];
			if($cnt==0)
				$this->refNo = substr($refNo, 0,25);
			else 
				$this->lastError = "The reference number is already in use!";
		}
		catch (Exception $e)
		{
			$this->lastError = 'Error in reference number!';
		}
	}

	public function setLoadingTransportingValue($loadingValue, $transportingValue)
	{
		if($loadingValue)
		{
			if(is_numeric($loadingValue))
			{
				$this->loadingValue = $loadingValue;
			}
			else
			{
				$this->lastError = 'Invalid loading charge!';
			}
		}
		if($transportingValue)
		{
			if(is_numeric($transportingValue))
			{
				$this->transportingValue = $transportingValue;
			}
			else
			{
				$this->lastError = 'Invalid transporting charge!';
			}
		}
	}
	
	public function addGoodsInvoiceItem($itemHsnCode, $itemQuantity, $itemRate)
	{
		try 
		{
			$itemHsnCode = substr($itemHsnCode, 0, 15);
		}
		catch (Exception $e)
		{
			$this->lastError = 'Error in HSN Code!';
		}
		if(is_numeric($itemQuantity)&&is_numeric($itemRate))
		{
			$hsn = new HSNCode($this->dbConnection);
			$hsnDetails = $hsn->getHsnCodeDetails($itemHsnCode);
			if($hsnDetails)
			{
				$itemCgstValue = 0;
				$itemSgstValue = 0;
				$itemIgstValue = 0;
				$detailArray = array();
				$itemValue = round($itemQuantity * $itemRate,2);
				$itemSlabId = $hsnDetails[0]['tax_slab_id'];
				if($this->tranactionType == TRANSACTION_INTRASTATE)
				{
					$itemCgstValue = round($itemValue * $hsnDetails[0]['cgst_rate']/100, 2);
					$itemSgstValue = round($itemValue * $hsnDetails[0]['sgst_rate']/100, 2);
				}
				elseif($this->tranactionType == TRANSACTION_INTERSTATE)
				{
					$itemIgstValue = round($itemValue * $hsnDetails[0]['igst_rate']/100, 2);
				}
				else 
				{
					$this->lastError = 'Transaction type not set before adding item in invoice!';
				}
				$detailArray['id'] = null;
				$detailArray['invoice_id'] = null;
				$detailArray['item_hsn_code'] = $itemHsnCode;
				$detailArray['item_quantity'] = $itemQuantity;
				$detailArray['item_rate'] = $itemRate;
				$detailArray['item_value'] = $itemValue;
				$detailArray['item_tax_slab_id'] = $itemSlabId;
				$detailArray['item_cgst_value'] = $itemCgstValue;
				$detailArray['item_sgst_value'] = $itemSgstValue;
				$detailArray['item_igst_value'] = $itemIgstValue;
				$detailArray['log_id'] = null;
				$funLib = new FunctionLibrary();
				if(in_array($detailArray['item_hsn_code'], $funLib->array_column($this->itemDetails, 'item_hsn_code')))
				{
					$this->lastError = 'Duplicate HSN code(s) in item details!';
				}
				
				array_push($this->itemDetails, $detailArray);

				$this->taxableValue += $itemValue;
				$this->cgstValue += $itemCgstValue;
				$this->sgstValue += $itemSgstValue;
				$this->igstValue += $itemIgstValue;
			}
			else 
			{
				$this->lastError = 'Invalid HSN Code(' . $itemHsnCode . ')!';
			}
		}
		else 
		{
			$this->lastError = 'Invalid Item quantity/rate for HSN Code ' . $itemHsnCode . ' !';
		}
	}

	public function addServiceInvoiceItem($itemHsnCode, $itemValue)
	{
		try
		{
			$itemHsnCode = substr($itemHsnCode, 0, 15);
		}
		catch (Exception $e)
		{
			$this->lastError = 'Error in HSN Code!';
		}
		if(is_numeric($itemValue))
		{
			$hsn = new HSNCode($this->dbConnection);
			$hsnDetails = $hsn->getHsnCodeDetails($itemHsnCode);
			if($hsnDetails)
			{
				$itemCgstValue = 0;
				$itemSgstValue = 0;
				$itemIgstValue = 0;
				$detailArray = array();
				$itemValue = round($itemValue,2);
				$itemSlabId = $hsnDetails[0]['tax_slab_id'];
				if($this->tranactionType == TRANSACTION_INTRASTATE)
				{
					$itemCgstValue = round($itemValue * $hsnDetails[0]['cgst_rate']/100, 2);
					$itemSgstValue = round($itemValue * $hsnDetails[0]['sgst_rate']/100, 2);
				}
				elseif($this->tranactionType == TRANSACTION_INTERSTATE)
				{
					$itemIgstValue = round($itemValue * $hsnDetails[0]['igst_rate']/100, 2);
				}
				else
				{
					$this->lastError = 'Transaction type not set before adding item in invoice!';
				}
				$detailArray['id'] = null;
				$detailArray['invoice_id'] = null;
				$detailArray['item_hsn_code'] = $itemHsnCode;
				$detailArray['item_quantity'] = null;
				$detailArray['item_rate'] = null;
				$detailArray['item_value'] = $itemValue;
				$detailArray['item_tax_slab_id'] = $itemSlabId;
				$detailArray['item_cgst_value'] = $itemCgstValue;
				$detailArray['item_sgst_value'] = $itemSgstValue;
				$detailArray['item_igst_value'] = $itemIgstValue;
				$detailArray['log_id'] = null;
				$funLib = new FunctionLibrary();
				if(in_array($detailArray['item_hsn_code'], $funLib->array_column($this->itemDetails, 'item_hsn_code')))
				{
					$this->lastError = 'Duplicate HSN code(s) in item details!';
				}
		
				array_push($this->itemDetails, $detailArray);
		
				$this->taxableValue += $itemValue;
				$this->cgstValue += $itemCgstValue;
				$this->sgstValue += $itemSgstValue;
				$this->igstValue += $itemIgstValue;
			}
			else
			{
				$this->lastError = 'Invalid HSN Code(' . $itemHsnCode . ')!';
			}
		}
		else
		{
			$this->lastError = 'Invalid Item quantity/rate for HSN Code ' . $itemHsnCode . ' !';
		}
	}
	
	public function saveInvoice()
	{
		if($this->lastError || !$this->sectionCode || !$this->taxableValue || !sizeof($this->itemDetails || !$this->supplyDate || !$this->billingName || !$this->refNo))
		{
			return false;
		}
		$insInvoiceType = ($this->invoiceType)? $this->invoiceType :  "null";
		$insTranactionType = ($this->tranactionType)? $this->tranactionType :  "null";
		$insAruCode = ($this->aruCode)? "'" .  $this->aruCode . "'" : "null";
		$insSectionCode = ($this->sectionCode)? "'" .  $this->sectionCode . "'" : "null";
		$insYearMonth = ($this->yearMonth)? "'" .  $this->yearMonth . "'" : "null";
		$insInvoiceDate = ($this->invoiceDate)? "'" .  $this->invoiceDate . "'" : "null";
		$insModeOfTransport = ($this->modeOfTransport)? "'" .  $this->modeOfTransport . "'" : "null";
		$insVehicleNo = ($this->vehicleNo)? "'" .  $this->vehicleNo . "'" : "null";
		$insSupplyDate = ($this->supplyDate)? "'" .  $this->supplyDate . "'" : "null";
		$insSupplyPlace = ($this->supplyPlace)? "'" .  $this->supplyPlace . "'" : "null";
		$insBillingName = ($this->billingName)? "'" .  $this->billingName . "'" : "null";
		$insBillingAddress = ($this->billingAddress)? "'" .  $this->billingAddress . "'" : "null";
		$insBillingStateCode = ($this->billingStateCode)? "'" .  $this->billingStateCode . "'" : "null";
		$insBillingGstin = ($this->billingGstin)? "'" .  $this->billingGstin . "'" : "null";
		$insShippingName = ($this->shippingName)? "'" .  $this->shippingName . "'" : "null";
		$insShippingAddress = ($this->shippingAddress)? "'" .  $this->shippingAddress . "'" : "null";
		$insShippingStateCode = ($this->shippingStateCode)? "'" .  $this->shippingStateCode . "'" : "null";
		$insShippingGstin = ($this->shippingGstin)? "'" .  $this->shippingGstin . "'" : "null";
		$insSarasGlobalId = ($this->sarasGlobalId)? "'" .  $this->sarasGlobalId . "'" : "null";
		$insTaxableValue = ($this->taxableValue)? $this->taxableValue :  "null";
		$insCgstValue = ($this->cgstValue)? $this->cgstValue :  "null";
		$insSgstValue = ($this->sgstValue)? $this->sgstValue :  "null";
		$insIgstValue = ($this->igstValue)? $this->igstValue :  "null";
		$insLoadingValue = ($this->loadingValue)? $this->loadingValue :  "null";
		$insTransportingValue = ($this->transportingValue)? $this->transportingValue :  "null";
		$insRefNo = ($this->refNo)? "'" .  $this->refNo . "'" : "null";
		
		foreach ($this->itemDetails as $item)
		{
			if(!array_key_exists('id',$item)||!array_key_exists('invoice_id',$item)||!array_key_exists('item_hsn_code',$item)||!array_key_exists('item_quantity',$item)||!array_key_exists('item_rate',$item)||!array_key_exists('item_value',$item)||!array_key_exists('item_tax_slab_id',$item)||!array_key_exists('log_id',$item))
			{
				$this->lastError = 'Invalid item details or items not added in invoice!';
				return false;
			}
		}
		
		$this->dbConnection->beginTrans();
		$query = "select max(sl_no) as last_sl_no from gst_supply_invoices where aru_code='".$this->aruCode."' and section_code='".$this->sectionCode."' and year_month='".$this->yearMonth."' ";
		$result = $this->dbConnection->executeTrans($query);
		if(isset($result['EOF']))
		{
			$this->lastError = 'Could not get last invoice number!';
			$this->dbConnection->rollBackTrans();
			return false;
		}
		$this->slNo = $result[0]['last_sl_no']+1;
		if($this->slNo>99999)
		{
			$this->lastError = 'Maximun number of invoices exceeded for the month!';
			$this->dbConnection->rollBackTrans();
			return false;
		}

		$query = "select max(id) as last_id from gst_supply_invoices ";
		$result = $this->dbConnection->executeTrans($query);
		if(isset($result['EOF']))
		{
			$this->lastError = 'Could not get last id from the record!';
			$this->dbConnection->rollBackTrans();
			return false;
		}
		$this->id = $result[0]['last_id']+1;
		
//		$this->invoiceNo = $this->aruCode . $this->sectionCode . $this->yearMonth . str_pad($this->slNo, 5, "0", STR_PAD_LEFT);
		$this->invoiceNo = $this->id;
		
		$this->logId = $this->log->saveLog();
		if(!$this->logId)
		{
			$this->lastError = 'Could not save log!';
			$this->dbConnection->rollBackTrans();
			return false;
		}
		$query = "insert into gst_supply_invoices 
				(id, invoice_type, tranaction_type, aru_code, section_code, year_month, sl_no, invoice_no, invoice_date, mode_of_transport, vehicle_no, supply_date, supply_place, billing_name, billing_address, billing_state_code, billing_gstin, shipping_name, shipping_address, shipping_state_code, shipping_gstin, saras_global_id, taxable_value, cgst_value, sgst_value, igst_value, loading_value, transporting_value, ref_no, log_id
		) values 
				($this->id, $insInvoiceType, $insTranactionType, $insAruCode, $insSectionCode, $insYearMonth, $this->slNo, '".$this->invoiceNo."', $insInvoiceDate, $insModeOfTransport, $insVehicleNo, $insSupplyDate, $insSupplyPlace, $insBillingName, $insBillingAddress, $insBillingStateCode, $insBillingGstin, $insShippingName, $insShippingAddress, $insShippingStateCode, $insShippingGstin, $insSarasGlobalId, $insTaxableValue, $insCgstValue, $insSgstValue, $insIgstValue, $insLoadingValue, $insTransportingValue, $insRefNo, $this->logId
				)";
		$result = $this->dbConnection->executeTrans($query);
		if(isset($result['EOF']))
		{
			if($result['EOF']==1)	//error
			{
				$this->lastError = 'Error while saving invoice!';
				$this->dbConnection->rollBackTrans();
				return false;
			}
		}
		foreach ($this->itemDetails as $item)
		{
			$item['invoice_id'] = $this->id;
			$item['log_id'] = $this->logId;
			
			$insItemHsnCode = ($item['item_hsn_code'])? "'" . $item['item_hsn_code'] . "'" : "null";
			$insItemQuantity = ($item['item_quantity'])? $item['item_quantity'] : "null";
			$insItemRate = ($item['item_rate'])? $item['item_rate'] : "null";
			$insItemValue = ($item['item_value'])? $item['item_value'] : "null";
			$insItemTaxSlabId = ($item['item_tax_slab_id'])? $item['item_tax_slab_id'] : "null";
				
			$query = "select max(id) as last_id from gst_supply_invoice_details ";
			$result = $this->dbConnection->executeTrans($query);
			if(isset($result['EOF']))
			{
				$this->lastError = 'Could not get last id from the details record!';
				$this->dbConnection->rollBackTrans();
				return false;
			}
			$item['id'] = $result[0]['last_id']+1;
			$insItemId = $item['id'];
			
			$query = "insert into gst_supply_invoice_details 
					(id, invoice_id, item_hsn_code, item_quantity, item_rate, item_value, item_tax_slab_id, log_id
					) values 
					($insItemId,$this->id,$insItemHsnCode,$insItemQuantity,$insItemRate,$insItemValue,$insItemTaxSlabId,$this->logId) ";
			$result = $this->dbConnection->executeTrans($query);
			if(isset($result['EOF']))
			{
				if($result['EOF']==1)	//error
				{
					$this->lastError = 'Error while saving invoice!';
					$this->dbConnection->rollBackTrans();
					return false;
				}
			}
		}
		$this->dbConnection->commitTrans();
		return true;
	}
	
}

?>