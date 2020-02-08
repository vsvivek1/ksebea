<?php 
/**
 *@version		1.0
 *@name			rate_manage_ajax.php
 *@abstract		GST Rate management ajax Backend
 *@author		maheep vm
 *@since		19-06-2017
 **/

@session_start();

require_once __DIR__ . '/../class/class.connection.php';
require_once __DIR__ . '/../class/class.gstRate.php';
require_once __DIR__ . '/../class/class.functionLib.php';

$response = array();
$response['status'] = false;
$response['message'] = 'No operation performed!';

$post = FunctionLibrary::getFormattedMultiArray($_POST);

if(isset($post['getRates']))
{
	$response['html'] = '';
	$dbConnection = new DBConnection();
	$gst = new GSTRate($dbConnection);
	$rates = $gst->getGstRateSlabs(null,false);
	$response['html'] .= '<table width="100%" class="table table-striped table-bordered table-hover" id="rates-list-table">
			<thead>
				<tr>
					<th>Sl No</th>
					<th>CGST Rate</th>
					<th>SGST Rate</th>
					<th>IGST Rate</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>';
	if($rates)
	{
		$sl = 0;
		foreach ($rates as $rate)
		{
			$btnClass = ($rate['is_live']=='t')? 'btn-danger' : 'btn-default';
			$sl++;
			$response['html'] .= 
				'<tr>
					<td>'.$sl.'</td>
					<td>'.$rate['cgst_rate'].'%</td>
					<td>'.$rate['sgst_rate'].'%</td>
					<td>'.$rate['igst_rate'].'%</td>
					<td><button type="button" class="btn '.$btnClass.' edit_btn" value="'.$rate['id'].'">Edit</button></td>		
				</tr>';
		}
	}
	$response['html'] .= '</tbody></table>';
	$response['status'] = true;
	$response['message'] = 'Data retrieval success!';
	echo json_encode($response);
}
elseif(isset($post['rateView']))
{
	$response['html'] = '';
	if(isset($post['rateId']))	// edit a rate
	{
		if(is_numeric($post['rateId']))
		{
			$dbConnection = new DBConnection();
			$gst = new GSTRate($dbConnection);
			$rate = $gst->getGstRateSlabs($post['rateId'],false);
			if($rate)
			{
				$rate = $rate[0];
				if($rate['is_live']=='t')
				{
					$enRadioSelectStatus = 'checked="checked"';
					$disRadioSelectStatus = '';
				}
				else 
				{
					$disRadioSelectStatus = 'checked="checked"';
					$enRadioSelectStatus = '';
				}
				$response['html'] .= '<h4>Edit GST Rate</h4><hr />';
				$response['html'] .= '<div class="row form-group"><div class="col-sm-6" style="text-align:left;">CGST Rate (%)</div>';
				$response['html'] .= '<div class="col-sm-6"><input type="text" class="form-control" id="cgst-rate" value="'.$rate['cgst_rate'].'" max-length="6" disabled readonly /></div></div>';
				$response['html'] .= '<div class="row form-group"><div class="col-sm-6" style="text-align:left;">SGST Rate (%)</div>';
				$response['html'] .= '<div class="col-sm-6"><input type="text" class="form-control" id="sgst-rate" value="'.$rate['sgst_rate'].'" max-length="6" disabled readonly /></div></div>';
				$response['html'] .= '<div class="row form-group"><div class="col-sm-6" style="text-align:left;">IGST Rate (%)</div>';
				$response['html'] .= '<div class="col-sm-6"><input type="text" class="form-control" id="igst-rate" value="'.$rate['igst_rate'].'" max-length="6" disabled readonly /></div></div>';
				$response['html'] .= '<div class="row form-group"><div class="col-sm-6" style="text-align:left;"><p class="form-control-static">Status</p></div>';
				$response['html'] .= '<div class="col-sm-6 radio" style="text-align:left;"><label><input type="radio" class="radio-inline" name="rate_status" value="E" '.$enRadioSelectStatus.' />Enable</label><br /><label><input type="radio" class="radio-inline" name="rate_status" value="D" '.$disRadioSelectStatus.' />Disable</label></div></div>';
				$response['html'] .= '<div class="row form-group">';
				$response['html'] .= '<div class="col-sm-3 col-sm-offset-6"><button class="btn btn-primary" id="save_btn" value="'.$rate['id'].'" >Save</button></div><div class="col-sm-3"><button class="btn btn-default" id="cancel_btn">Cancel</button></div></div>';
				
				$response['status'] = true;
				$response['message'] = 'Check and edit here!';
			}
			else 
			{
				$response['html'] .= '<h4 class="text-danger">Rate not found!</h4>';
				$response['status'] = true;
				$response['message'] = 'Could not find rate!';
			}
		}
		else 
		{
			$response['message'] = 'Invalid rate selected!';
		}
	}
	else 	//add new rate
	{
		$response['html'] .= '<h4>Add New GST Rate</h4><input type="hidden" id="rate_id" value="0" /><hr />';
		$response['html'] .= '<div class="row form-group"><div class="col-sm-6" style="text-align:left;">CGST Rate (%)</div>';
		$response['html'] .= '<div class="col-sm-6"><input type="text" class="form-control" id="cgst-rate" max-length="6" /></div></div>';
		$response['html'] .= '<div class="row form-group"><div class="col-sm-6" style="text-align:left;">SGST Rate (%)</div>';
		$response['html'] .= '<div class="col-sm-6"><input type="text" class="form-control" id="sgst-rate" max-length="6" /></div></div>';
		$response['html'] .= '<div class="row form-group"><div class="col-sm-6" style="text-align:left;">IGST Rate (%)</div>';
		$response['html'] .= '<div class="col-sm-6"><input type="text" class="form-control" id="igst-rate" max-length="6" /></div></div>';
		$response['html'] .= '<div class="row form-group">';
		$response['html'] .= '<div class="col-sm-3 col-sm-offset-6"><button class="btn btn-primary" id="save_btn" value="0" >Save</button></div><div class="col-sm-3"><button class="btn btn-default" id="cancel_btn">Cancel</button></div></div>';
		
		$response['status'] = true;
		$response['message'] = 'Please provide new rate!';
	}
	echo json_encode($response);
}
elseif(isset($post['saveRate'],$post['cgstRate'],$post['sgstRate'],$post['igstRate']))
{
	$sl = 1;
	$msg = '';
	if(!is_numeric($post['saveRate']))
	{
		$msg .= ($sl++) . ') Error in selected Rate!' . "\n";
	}
	if(!is_numeric($post['cgstRate']))
	{
		$msg .= ($sl++) . ') Invalid CGST rate!' . "\n";
	}
	if(!is_numeric($post['sgstRate']))
	{
		$msg .= ($sl++) . ') Invalid SGST rate!' . "\n";
	}
	if(!is_numeric($post['igstRate']))
	{
		$msg .= ($sl++) . ') Invalid IGST rate!' . "\n";
	}
	if(isset($post['rateStatus']))
	{
		if(!($post['rateStatus']=='D' || $post['rateStatus']=='E' ))
			$msg .= ($sl++) . ') Invalid Status selected!' . "\n";
	}
	
	if($msg == '')
	{
		$dbConnection = new DBConnection();
		$gst = new GSTRate($dbConnection);
		if($post['saveRate']!=0)
		{
			$rate = $gst->getGstRateSlabs($post['saveRate'],false);
			if(isset($post['rateStatus']))	
			{
				if($rate)
				{
					$rate = $rate[0];
					if($rate['is_live']=='t' && $post['rateStatus']=='E')
					{
						$response['message'] = 'Rate is already enabled!';
					}
					elseif($rate['is_live']=='f' && $post['rateStatus']=='D')
					{
						$response['message'] = 'Rate is already disabled!';
					}
					else 					//edit process
					{
						$newStatus = ($post['rateStatus']=='D')? false : true;
						if($gst->updateGstRateSlab($post['saveRate'], $post['cgstRate'], $post['sgstRate'], $post['igstRate'], $newStatus))
						{
							$response['status'] = true;
							$response['message'] = 'Rate updated successfully!';
						}
						else 
						{
							$response['message'] = 'Update failed!';
						}
					}
				}
				else 
				{
					$response['message'] = 'Selected rate not found!';
				}
			}
			else
			{
				$response['message'] = 'New status not selected!';
			}
		}
		else 						// add process
		{
			if($gst->saveGstRateSlab($post['cgstRate'], $post['sgstRate'], $post['igstRate']))
			{
				$response['status'] = true;
				$response['message'] = 'Rate saved successfully!';
			}
			else
			{
				$response['message'] = 'Saving failed!';
			}
		}
	}
	else 
	{
		$response['message'] = "Could not save new rate due to following errors:\n" . $msg;
	}
	echo json_encode($response);
}
else 
{
	$response['message'] = 'Invalid data supplied!';
	echo json_encode($response);
}
?>