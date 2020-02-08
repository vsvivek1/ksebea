<?php
/**
 *@version		1.0
 *@name			class.service.php
 *@abstract		HSNCode Class
 *@author		maheep vm
 *@since		21-06-2017
**/

require_once __DIR__ . '/class.connection.php';
require_once __DIR__ . '/class.hsn.php';
require_once __DIR__ . '/class.gstRate.php';
require_once __DIR__ . '/class.functionLib.php';
require_once __DIR__ . '/class.state.php';
require_once __DIR__ . '/../common/common.constants.php';
require_once __DIR__ . '/class.supplyInvoice.php';


class WebServiceManager {

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
	
	private function getInvalidParamsResult()
	{
		$retArray = array("error_code"=>"3", "message"=>"Invalid service request parameters!", "data"=>null);
		return $retArray;
	}

	private function getNullResponseResult()
	{
		$retArray = array("error_code"=>"4", "message"=>"No Data or error in server response!", "data"=>null);
		return $retArray;
	}

	private function getCustomErrorResponseResult($error)
	{
		$retArray = array("error_code"=>"5", "message"=>$error, "data"=>null);
		return $retArray;
	}
	
	public function getTaxRates($paramJson)
	{
		$params = json_decode($paramJson,true);
		if(isset($params['transaction_type'],$params['hsn_code'])&&is_array($params['hsn_code']))
		{
			$hsn = new HSNCode($this->dbConnection);
			$resultArray = array();
			foreach ($params['hsn_code'] as $hsnCodeEach)
			{
				$hsnCodes = $hsn->getHsnCodeDetails($hsnCodeEach);
				if($hsnCodes)
				{
					$result = array();
					$result['hsn_code'] = $hsnCodes[0]['hsn_code'];
					$result['description'] = $hsnCodes[0]['description'];
					$result['unit'] = $hsnCodes[0]['unit'];
					if($params['transaction_type']==TRANSACTION_INTRASTATE)
					{
						$result['cgst_rate'] = $hsnCodes[0]['cgst_rate'];
						$result['sgst_rate'] = $hsnCodes[0]['sgst_rate'];
					}
					elseif($params['transaction_type']==TRANSACTION_INTERSTATE)
					{
						$result['igst_rate'] = $hsnCodes[0]['igst_rate'];
					}
					array_push($resultArray, $result);
				}
			}
			if(sizeof($resultArray)==0)
			{
				$retArray = $this->getNullResponseResult();
			}
			else
			{
				$retArray = array("error_code"=>"0", "message"=>"Success", "data"=>$resultArray);
			}
		}
		else
		{
			$retArray = $this->getInvalidParamsResult();
		}
		return json_encode($retArray);
	}
	
	
	public function getCalculatedTaxes($paramJson)
	{
		$params = json_decode($paramJson,true);
		$paramsOk = true;
		if(isset($params['transaction_type'],$params['hsn_data'])&&is_array($params['hsn_data']))
		{
			$hsn = new HSNCode($this->dbConnection);
			$resultArray = array();
			foreach ($params['hsn_data'] as $param)
			{
				if(isset($param['hsn_code'],$param['hsn_value']))
				{
					$hsnCodes = $hsn->getHsnCodeDetails($param['hsn_code']);
					if($hsnCodes)
					{
						$result = array();
						$result['hsn_code'] = $hsnCodes[0]['hsn_code'];
						$result['description'] = $hsnCodes[0]['description'];
						$result['unit'] = $hsnCodes[0]['unit'];
						$result['hsn_value'] = $param['hsn_value'];
						if($params['transaction_type']==TRANSACTION_INTRASTATE)
						{
							$result['cgst_rate'] = $hsnCodes[0]['cgst_rate'];
							$result['sgst_rate'] = $hsnCodes[0]['sgst_rate'];
							$result['cgst_value'] = round($hsnCodes[0]['cgst_rate']*$param['hsn_value']/100,2);
							$result['sgst_value'] = round($hsnCodes[0]['sgst_rate']*$param['hsn_value']/100,2);
						}
						elseif($params['transaction_type']==TRANSACTION_INTERSTATE)
						{
							$result['igst_rate'] = $hsnCodes[0]['igst_rate'];
							$result['igst_value'] = round($hsnCodes[0]['igst_rate']*$param['hsn_value']/100,2);
						}
						array_push($resultArray, $result);
					}
				}
				else 
				{
					$paramsOk = false;
					$retArray = $this->getInvalidParamsResult();
					break;
				}
			}
			if($paramsOk && sizeof($resultArray)==0)
			{
				$retArray = $this->getNullResponseResult();
			}
			elseif (!$paramsOk)
			{
				$retArray = $this->getInvalidParamsResult();
			}
			else
			{
				$retArray = array("error_code"=>"0", "message"=>"Success", "data"=>$resultArray);
			}
		}
		else
		{
			$paramsOk = false;
			$retArray = $this->getInvalidParamsResult();
		}
		return json_encode($retArray);
	}
	
	public function getStateCodes()
	{
		$state = new State($this->dbConnection);
		$result = $state->getStatesList();
		if($result==null)
		{
			$retArray = $this->getNullResponseResult();
		}
		else
		{
			$resultArray = array();
			foreach ($result as $st)
			{
				array_push($resultArray,array('state_code'=>$st['state_codes'],'state_short_name'=>$st['state_initials'],'state_name'=>$st['state_name'],'state_type'=>$st['state_type']));
			}
			$retArray = array("error_code"=>"0", "message"=>"Success", "data"=>$resultArray);
		}
		return json_encode($retArray);
	}

	public function saveSupplyInvoice($paramJson)
	{
		$params = json_decode($paramJson,true);
		if(isset($params['transaction_type'], $params['invoice_type'], $params['aru_code'], $params['section_code'], $params['invoice_date'], $params['supply_date'], $params['supply_place'], $params['billing_name'], $params['billing_address'], $params['billing_state_code'], $params['billing_gstin'], $params['invoice_data'], $params['ref_no'])&&is_array($params['invoice_data']))
		{
			$invoice = new GSTSupplyInvoice($this->dbConnection);
			$invoice->setInvoiceHeader($params['transaction_type'], $params['invoice_type'], $params['aru_code'], $params['section_code'], $params['invoice_date']);

			$modeOfTransport = (isset($params['mode_of_transport']))? $params['mode_of_transport'] : null;
			$vehicleNo = (isset($params['vehicle_no']))? $params['vehicle_no'] : null;
			$invoice->setSupplyDetails($params['supply_date'], $params['supply_place'], $modeOfTransport, $vehicleNo);
			
			$shippingName = (isset($params['shipping_name']))? $params['shipping_name'] : $params['billing_name'];
			$shippingAddress = (isset($params['shipping_address']))? $params['shipping_address'] : $params['billing_address'];
			$shippingStateCode = (isset($params['shipping_state_code']))? $params['shipping_state_code'] : $params['billing_state_code'];
			$shippingGSTIN = (isset($params['shipping_gstin']))? $params['shipping_gstin'] : $params['billing_gstin'];
			$invoice->setBillingDetails($params['billing_name'], $params['billing_address'], $params['billing_state_code'], $params['billing_gstin']);
			$invoice->setShippingDetails($shippingName, $shippingAddress, $shippingStateCode, $shippingGSTIN);
			
			if(isset($params['saras_global_id']))
			{
				$invoice->setSarasGlobalId($sarasGlobalId);
			}
			$invoice->setReferenceNo($params['ref_no'],$_SESSION['application_id']);

			$loadingValue = (isset($params['loading_value']))? $params['loading_value'] : null;
			$transportingValue = (isset($params['transporting_value']))? $params['transporting_value'] : null ;
			$invoice->setLoadingTransportingValue($loadingValue, $transportingValue);

			if($invoice->invoiceType == INVOICE_TYPE_TAXABLE_GOODS)
			{
				foreach ($params['invoice_data'] as $item)
				{
					if(isset($item['hsn_code'],$item['item_quantity'],$item['item_rate']))
					{
						$invoice->addGoodsInvoiceItem($item['hsn_code'], $item['item_quantity'], $item['item_rate']);
					}
					else 
					{
						$retArray = $this->getInvalidParamsResult();
					}
				}
			}
			elseif($invoice->invoiceType == INVOICE_TYPE_TAXABLE_SERVICE)
			{
				foreach ($params['invoice_data'] as $item)
				{
					if(isset($item['hsn_code'],$item['item_value']))
					{
						$invoice->addServiceInvoiceItem($item['hsn_code'], $item['item_value']);
					}
					else
					{
						$retArray = $this->getInvalidParamsResult();
					}
				}
			}
			
			
			$error = $invoice->getLastError();
			if(!$error)
			{
				if($invoice->saveInvoice())
				{
					$resultArray = array();
					$resultArray['invoice_no'] = $invoice->invoiceNo;
					$resultArray['invoice_date'] = date('d/m/Y',strtotime($invoice->invoiceDate));
					$retArray = array("error_code"=>"0", "message"=>"Success", "data"=>$resultArray);
				}
				else 
				{
					$error = $invoice->getLastError();
					$retArray = $this->getCustomErrorResponseResult($error);
				}
			}
			else 
			{
				$retArray = $this->getCustomErrorResponseResult($error);
			}
		}
		else
		{
			$retArray = $this->getInvalidParamsResult();
		}
		return json_encode($retArray);
	}
	
	public function getAllHsnCodes()
	{
		$hsn = new HSNCode($this->dbConnection);
		$result = $hsn->searchHsnCodeData('');
		if($result==null)
		{
			$retArray = $this->getNullResponseResult();
		}
		else
		{
			$resultArray = array();
			foreach ($result as $h)
			{
				array_push($resultArray,array('hsn_code'=>$h['hsn_code'],'description'=>$h['description'],'unit'=>$h['unit'],'saras_acc_code'=>explode(',',trim(trim($h['saras_acc_codes'],'{'),'}')),'cgst_rate'=>$h['cgst_rate'],'sgst_rate'=>$h['sgst_rate'],'igst_rate'=>$h['igst_rate']));
			}
			$retArray = array("error_code"=>"0", "message"=>"Success", "data"=>$resultArray);
		}
		return json_encode($retArray);
	}
	
	
}
?>