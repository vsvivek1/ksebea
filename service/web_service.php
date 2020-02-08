<?php
/**
 *@version		1.0
 *@name			web_service.php
 *@abstract		GSTWebService Server Handler
 *@author		maheep vm
 *@since		22-06-2017
 **/

require_once __DIR__ . '/../class/class.service.php';
require_once __DIR__ . '/../class/class.functionLib.php';
require_once __DIR__ . '/../common/common.constants.php';

class GSTWebService
{
	public function __construct()
	{
		@session_start();
	}
	
	public function getGstService($applicationId,$employeeCode,$officeCode,$serviceId,$serviceParamsJson)
	{
		$applicationId = FunctionLibrary::getFormattedString($applicationId);
		$employeeCode = FunctionLibrary::getFormattedString($employeeCode);
		$officeCode = FunctionLibrary::getFormattedString($officeCode);
		$serviceId = FunctionLibrary::getFormattedString($serviceId);

		$_SESSION['user_name'] = $employeeCode;
		$_SESSION['office_code'] = $officeCode;
		$_SESSION['application_id'] = $applicationId;
		
		try 
		{
//			echo $serviceParamsJson;
			$functionLib = new FunctionLibrary();
			$decodedArray = json_decode($serviceParamsJson,true);
//			print_r($decodedArray);
			$sanitisedArray = $functionLib->getFormattedMultiArrayMethod($decodedArray);
//			print_r($sanitisedArray);			
			$serviceParamsJson = json_encode($sanitisedArray);
		}
		catch(Exception $e)
		{
			$serviceParamsJson = json_encode(array());
		}
		if($applicationId && $employeeCode && $officeCode && $serviceId)
		{
			$serviceMgr = new WebServiceManager();
			switch ($serviceId)
			{
				case SERVICE_ID_GET_TAX_RATES:
					$serviceReturn = $serviceMgr->getTaxRates($serviceParamsJson);
					break;
				case SERVICE_ID_GET_CALCULATED_TAX:
					$serviceReturn = $serviceMgr->getCalculatedTaxes($serviceParamsJson);
					break;
				case SERVICE_ID_GET_STATE_CODES:
					$serviceReturn = $serviceMgr->getStateCodes();
					break;
				case SERVICE_ID_SAVE_SUPPLY_INVOICE:
					$serviceReturn = $serviceMgr->saveSupplyInvoice($serviceParamsJson);
					break;
				case SERVICE_ID_GET_ALL_HSN_CODES:
					$serviceReturn = $serviceMgr->getAllHsnCodes();
					break;
				default:
					$serviceReturn = $this->getUnknownRequestResult();
					break;
			}
		}
		else
		{
			$serviceReturn = $this->getUnauthorisedAccessResult();
		}
		return $serviceReturn;
	}
	
	private function getUnauthorisedAccessResult()
	{
		$retArray = array("error_code"=>"1", "message"=>"Unauthorised access!", "data"=>null);
		return json_encode($retArray);
	}
	
	private function getUnknownRequestResult()
	{
		$retArray = array("error_code"=>"2", "message"=>"Unknown service request!", "data"=>null);
		return json_encode($retArray);
	}
	
}

$server = new SoapServer("GstWebService.wsdl");
$server->setClass("GSTWebService");
$server->handle();

?>