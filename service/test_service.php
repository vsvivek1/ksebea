<?php
require_once __DIR__ . '/../class/class.functionLib.php';

$applicationId = '0';
$employeeCode = '1064380';
$officeCode = '1103';
$serviceId = '0';
$serviceParams = array();
$serviceParamsText = "array('username'=>'maheep','password'=>'password')";
$request = '';
$response = '';
if(isset($_POST))
{
	$applicationId = (isset($_POST['application_id']))? $_POST['application_id'] : $applicationId;
	$employeeCode = (isset($_POST['employee_code']))? $_POST['employee_code'] : $employeeCode;
	$officeCode = (isset($_POST['office_code']))? $_POST['office_code'] : $officeCode;
	$serviceId = (isset($_POST['service_id']))? $_POST['service_id'] : $serviceId;
	$serviceParamsText = (isset($_POST['service_params']))? $_POST['service_params'] : $serviceParamsText;
	$request = (isset($_POST['request_query']))? htmlentities($_POST['request_query']) : $request;
	
	try{
		if(isset($_POST['service_params']))
			@eval('$serviceParams = ' .$_POST['service_params'] . ';') ;
	}
	catch (Exception $e)
	{
		$serviceParams = $_POST['service_params'];
	}
	try {
		$client = new SoapClient("GstWebService.wsdl",array('trace' => 1, 'cache_wsdl'=>WSDL_CACHE_NONE));
	//	$params = array("username" => "maheep","password" => "password");
	//	print_r($serviceParams);
		$response = $client->getGstService($applicationId,$employeeCode,$officeCode,$serviceId,json_encode($serviceParams));
	}
	catch (Exception $e)
	{
		$response = 'Exception: ' . $e->__toString();
	}
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="../lib/bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="../lib/jquery/jquery-2.1.1.js"></script>
		<script type="text/javascript" src="../lib/bootstrap/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container-fluid">
			<h1>GST WebService Testing Tool</h1>
			<hr />
			<div class="row">
				<div class="col-sm-10 col-sm-offset-1">
					<div class="panel panel-primary">
						<div class="panel-heading">Test WSDL</div>
						<div class="panel-body">
							<form class="form" method="post" action="test_service.php">
								<div class="form-group row">
									<div class="col-sm-6"><p class="form-control-static text-warning">Application ID</p></div>
									<div class="col-sm-6"><input type="text" class="form-control" id="application-id" name="application_id" value="<?php echo $applicationId;?>" /></div>
								</div>
								<div class="form-group row">
									<div class="col-sm-6"><p class="form-control-static text-warning">Employee Code</p></div>
									<div class="col-sm-6"><input type="text" class="form-control" id="employee-code" name="employee_code" value="<?php echo $employeeCode;?>" /></div>
								</div>
								<div class="form-group row">
									<div class="col-sm-6"><p class="form-control-static text-warning">Office Code</p></div>
									<div class="col-sm-6"><input type="text" class="form-control" id="office-code" name="office_code" value="<?php echo $officeCode;?>" /></div>
								</div>
								<div class="form-group row">
									<div class="col-sm-6"><p class="form-control-static text-warning">Service ID</p></div>
									<div class="col-sm-6"><input type="text" class="form-control" id="service-id" name="service_id" value="<?php echo $serviceId;?>" /></div>
								</div>
								<div class="form-group row">
									<div class="col-sm-6"><p class="form-control-static text-warning">Service Parameters Array</p></div>
									<div class="col-sm-6"><textarea class="form-control" id="service-params" name="service_params" ><?php echo $serviceParamsText;?></textarea></div>
								</div>
								<div class="form-group row">
									<div class="col-sm-2"><h4>Request</h4></div>
									<div class="col-sm-10"><div class="alert alert-success" style="min-height: 50px;" id="request-div"><?php echo $request;?></div></div>
									<input type="hidden" name="request_query" id="request-query" value="<?php echo $request;?>" />
								</div>
								<div class="form-group row">
									<div class="col-sm-6 col-sm-offset-6"><div class="col-sm-6"><button type="submit" class="btn btn-primary" id="btn-test">Test</button></div><div class="col-sm-6"><button type="reset" class="btn btn-default" id="btn-clear">Clear</button></div></div>
								</div>
								<hr />
								<div class="form-group row">
									<div class="col-sm-2"><h4>Response</h4></div>
									<div class="col-sm-10"><div class="alert alert-warning" style="min-height: 50px;" id="response-div"><?php echo $response;?></div></div>
								</div>
							</form>	
						</div>
					</div>
				</div>
			</div>
			<h4>Available Functions</h4>
<?php
	$functions = $client->__getFunctions();
	foreach ($functions as $function)
	{
		echo $function . '<br />';
	}
?>			
			<hr />
			<h4>Sample Code in PHP</h4>
			<p>
			$client = new SoapClient('http://localhost/saras/gst/service/GstWebService.wsdl',array('trace' => 1, 'cache_wsdl'=>WSDL_CACHE_NONE));<br />
			$applicationId = '1';<br />
			$employeeCode = '1064380';<br />
			$officeCode = '1103';<br />
			$serviceId = '1';<br />
			$paramsArray = array('key1' => 'value1','key2' => 'value2', ...);<br />
			$serviceParamsJSON = json_encode($paramsArray);<br />
			$response = $client->getGstService($applicationId,$employeeCode,$officeCode,$serviceId,$serviceParamsJSON);<br />
			print_r(json_decode($response));<br />
			</p>
			<hr />
		</div>
		<script type="text/javascript">
			$(document).on('change','#application-id,#employee-code,#office-code,#service-id,#service-params',function(){
				var requestStr = '$client->getGstService("'+$('#application-id').val()+'","'+$('#employee-code').val()+'","'+$('#office-code').val()+'","'+$('#service-id').val()+'",json_encode('+($('#service-params').val()?$('#service-params').val():'null')+'));'
				$('#request-div').html(requestStr);
				$('#request-query').val(requestStr);
			});
		</script>
	</body>
</html>
