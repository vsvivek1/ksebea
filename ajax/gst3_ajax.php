<?php
@session_start();
require_once __DIR__ . '/../class/common.class.php';
require_once __DIR__ . '/../class/class.connection.php';
require_once __DIR__ . '/../class/class.functionLib.php';
require_once __DIR__ . '/../class/class.hsn.php';
require_once __DIR__ . '/../class/class.gstRate.php';
$con=new DBConnection();

$hsn = new HSNCode($con);
$gstRate=new GSTRate($con);
$post = FunctionLibrary::getFormattedMultiArray($_POST);
switch($post['option']){
case 4:
$result2 = $hsn->searchHsnMasterData($post['hsn'],$post['type']);
	
//print_r($result2);	
	
	
	
	
	
?>
	
	
	<div class="well">
		<script>
		$("#tbl_hsn_govt").DataTable({     responsive: true      }); 
		
		
		
		
		</script>
  <h3 id=h2_edit_hsn_details class="text-success"><?php echo $post["header"] ?></h3>
  <p></p>  
	
	
	 <table width="100%"  class="table table-striped table-bordered table-hover" id="tbl_hsn_govt">
          
          
          <thead>
          <th>HSN number</th><th>Description by GST</th><th>Action</th>
          
          
          </thead>
          
          <tbody> 
		
		<?php
		
		if(count($result2) > 0)
							{
								foreach ($result2 as $row)
								{
								?>	  
									   
						       <tr>
									<td class=td_hsn1> <?php echo $row['hsn_code'];?></td>
						       
						       
							        <td class=td_description_gov1> <?php  echo $row['description']; ?></td>
							       
							       <td><button id=<?php echo $row['hsn_code'] ;?> class="btn btn-primary sel_hsn "> select</button></td>
						       </tr>
						       <?
						       }
						       
						   } 
						   else 
						   
								echo "<tr><td style=\"text-align:center\"colspan=3 class=\"bg-warning text-danger\"><h2>NO Data Found </h2> </td></tr>";
       
       ?>
       </tbody>  
       </table>
       <?php
	
	break;	
	
	case 1:
	?>
	<table width="100%" class="table table-striped table-bordered table-hover" id="tbl_kseb_hsn_codes">
                                <thead>
                                    
                                        <th>Serial</th>
                                        <th>HSN Code</th>
                                        <th>Description KSEBL</th>
                                        <th>UoM</th>
                                        <th>Tax Rate</th>
                                        <th>Saras Acc Code</th>
                                        <th>Edit</th>
                                    
                                </thead>
                                <tbody>
									
									 <?php
								
	$result4 = $hsn->searchHsnCodeData(""); 
	 //print_r($result4);
	 if($result4)
	 {
		 
	 $sl=1;
	 {
	 foreach ($result4 as $result1)
	 {		 
		 ?>
	
				 <tr>
                                        <td><?echo $sl ?></td>
                                        <td><?php echo $result1["hsn_code"]; ?></td>
                                        <td class="td_desc_kseb"><?php echo $result1["description"]; ?></td>
                                        <td><?php echo $result1["unit"]; ?><input type="hidden" id="saved_acc_code" value="<?php echo trim(trim($result1['saras_acc_code'],'{'),'}');?>" /></td>
                                        <td><?php 
                                        echo 'CGST:'. $result1['cgst_rate'].'%<br />' ;
                                        echo 'SGST:'. $result1['sgst_rate'].'%<br />' ;
                                        echo 'IGST:'. $result1['igst_rate'].'%' ;
		 								?></td>
                                        <td class="td_acc_code"><?php echo trim(trim($result1['saras_acc_code'],'{'),'}');?></td>
                                        <td class="center">	
											<button 
												type="button" 
												value='<?php echo $result1["hsn_code"]; ?>'
												class="btn btn-warning btn-lg mod" 
												data-toggle="modal1" 
												data-target="#myModal1">
														Edit
											</button>						
										</td>
                     </tr>	

			<?php
			$sl++;
	}
	}
	}
?>
									
                                   
                                         
                                </tbody>
                            </table>
	<?php
	break;
	
	
	
	
	case 3:
	
	echo "-*-";
//print_r($post);
//	echo "Maheep bro";
	$response = array();
	$response['status'] = false;
	if(strlen($post['des_ksebl'])>1)
	{
		if(strlen($post['des_ksebl'])>3)
		{
			if(isset($post['rates']))
			{
				$accCodeValidated = true;
				$accCodeArray = null;
				if(strlen($post['acc_code'])>0)
				{
					try 
					{
						$accCodeArray = explode(',',trim(trim($post['acc_code']),',')); //echo $accCodeArray;
						$accCodeArray = FunctionLibrary::getFormattedMultiArray($accCodeArray);
						$accCodeArray = array_unique($accCodeArray);
					}
					catch (Exception $e)
					{
						$accCodeValidated = false;
					}
				}
				if($accCodeValidated)
				{
					$saved = $hsn->saveHSNCode($post['hsn'], $post['des_ksebl'], $post['uom'], $post['rates'],$accCodeArray);
					if(!$saved)
					{
						$response['message'] = 'Error in saving data!';
					}
					else 
					{
						$response['status'] = true;
						$response['message'] = 'Saved!';
					}
				}
				else 
				{
					$response['message'] = 'Please provide comma seperated account codes or leave blank!';
				}
			}
			else 
			{
				$response['message'] = 'Rate not selected!';
			}
		}
	
		else 
		{
			$response['message'] = 'Provide a valid description!';
		}
	}
	
	else 
		{
			$response['message'] = 'Provide a valid HSN Code!';
		}
	echo json_encode($response);
	break;
	
	
	
	
	
	
	
	
	
case 2:
	
	
	// need kseb description
	
			$result2 = null;
			if($post['hsn']!="")
			{
			$noHsn=true;
			$result2 = $hsn->searchHsnMasterData($post['hsn']);
			
		
			}			
			$description=($result2)? $result2[0]["description"]:"";
			
			$ratesArray=$gstRate->getGstRateSlabs();
			?>
			
			
			<div class="well" id=div>
				<h5 id=h2_edit_hsn_details class="text-success"><?php echo $post["header"] ?></h5>
		
			<button id=btn_search_hsn 
			class="btn btn-primary"
			 data-toggle="modal"
			 style='<?php if($post['show_btn_search_hsn']==1) echo "display:block"; else echo "display:none"; ?>'
			data-target="#myModal1">
			   Search HSN
			   </button>
			   </h2>
			
			<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example3">
		              
		       <tr>
					<td> HSN Number :</td>
					<td id=td_hsn2> <?php echo $post['hsn'];?> </td>
		      
		       </tr>
		       <tr>
			       <td>Description by GST</td> <td id=td_description_gov2> <?php  echo $description ?></td>
		       </tr>
		       
		       <tr>
		       <td>Description by KSEBL</td><td id=td_description_kseb>
				    <input class="form-control input-lg"  type=text id=txt_ksebl_des value='<?php echo $post['des_ksebl_old'];?>'>
				    </td>
		       </tr>

		       <tr>
		       <td>Unit of Measurement</td><td id=td_uom>
		       <select class=form-control id=txt_uom>
				   <option>--Select--</option>
			       <option>No</option>
			       <option>kg</option>
			       <option>m</option>
			       <option>km</option>
			       <option>Ltr</option>
		       </select></td>
		       </tr>
		       
		       <tr>
		       <td>Saras Account Code</td><td id=td_acc_code>
				    <input class="form-control input-lg"  type=text id=txt_acc_code value='<?php echo $post['acc_code_old'];?>'>
				    </td>
		       </tr>
		       
		       
		       <tr>
				   <td colspan=2 id=td_kseb_rate>
				   
				   <div class="panel panel-info">
					   <div class="panel-heading">GST RATES </div>
					   <DIV CLASS="panel panel-body">
				   <table class="table table-stripped table table-striped" id=tbl_gst_rates> 
			<thead>
			<th>Select</th><th>CGST RATE</th> <th>SGST RATE</th> <th>IGST RATE</th></thead>
			
			<?
			if($ratesArray)
			{
				
				
				foreach ($ratesArray as $rate1)
				{
					echo "<tr>";
					echo "<td><input type=radio name=radio_rate id=$rate1[id]></td>";
					echo "<td>$rate1[cgst_rate] % </td>";
					echo "<td>$rate1[sgst_rate] %</td>";
					echo "<td>$rate1[igst_rate] %</td>";
					echo "</tr>";
				}
				
				
				
			}
			echo "</table>";
			?>
			</DIV>
			
			
				   
			</div>	   
				   		
				  
				   		
				   		
				   <button class="btn btn-success" id=btn_save_hsn_kseb	    style="float: left"><i class="fa fa-floppy-o text-info fa-2x "></i>Save</button>   
		
				<button class="btn btn-danger" id=btn_cancel_edit
				 style="float: right;"><i class="fa fa-times text-info fa-2x " style="text-align:left"></i> Cancel</button>   
				   
				   </td>
				</tr>
		       
		      
		       
		       </table> 
		       
			
			
			
			
			
			
			
			
			<?php
			
break;
}
?>
