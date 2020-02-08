<style>
.myBut{
	background:none;
	display:block;
	padding:10px;
	border:none;
	width:75px;
	height:75px;
	border-radius:50px;
	background-color:blue;
	//margin
	
	
	
	}
	
	.myBut1{
	background:none;
	display:block;
	padding:1px;
	border:none;
	width:30px;
	height:30px;
	border-radius:15px;
	background-color:white;
	//margin
	
	
	
	}


</style>

<script>

$("#btn_add_file_for_imprest").
click(function(){

var newId=$("#ol_upload_documents").find(">li").length+1;
out="<div class=well>";
out=out+"<li><label for=\"fileToUpload\" "+newId+" > <i class=\"fa fa-cloud-upload fa-fw fa-2x text-success\">  </i></label> <input type=\"text\"  id=\"fileToUpload"+newId;
out=out+"\" style=\"display:inline-block\" placeholder=\"Type of Document:\" />	<input type=\"file\" id=\"fileToUpload"+newId+"\" style=\"display:inline-block\" />";
out=out+"<i class=\"fa fa-trash-o fa-1x i_delete_doc\" style=\"color:red;display:inline-block\" title=\"Delete\" data-placement=\"right\" data-toggle=\"tooltip\">  </i></div>  </li> ";

 $("#ol_upload_documents").append(out);

});


$(document).on("click",".i_delete_doc",function()


{
	if(confirm("Do you wanted to remove This Document"))
	{
		$(this).closest(".well").remove();
		alert("Document Removed succesfully");
		
	}
	
	});
</script>

<?php
//include_once("head.php");



class imprest
{
	
	public static function li()
	{?><li><label for=\"fileToUpload\"> <i class=\"fa fa-briefcase\"></i>Upload Work Order :<input type=\"file\" name=\"fileToUpload\" id=\"fileToUpload\"></label> </li>
<?php
	}
	
	
	public function  round_btn($id="id",$class="myBut",$toolTip="click",$fontAwesome="fa fa-inr fa-5x",$iStyle="color:white",$style="")
	 {
		 echo  "<button id=$id
	  class=\"$class\" data-toggle=\"tooltip\" style=\"$style \" title=\"$toolTip\" data-placement=\"left\"><i class=\"$fontAwesome\" style=\"$iStyle\"></i>
	  </button>";
	
		 
		 }
		 

public static function modal_btn($modalId,$id="id",$class="myButt1",$toolTip="click",$fontAwesome="fa fa-inr fa-5x",
$iStyle="color:white",$style="",$btnClass="btn btn-info btn-lg")

{

//echo "<button type=\"button\"  data-toggle=\"modal\" data-target=\"#$modalId\">Open Modal</button>";
	
 echo  "
 <span data-toggle=\"tooltip\" title=\"$toolTip\"  data-placement=\"right\" >
 <button id=$id
	  class=\"$class\" data-target=\"#$modalId\" data-toggle=\"modal\" style=\"$style \" ><i class=\"$fontAwesome\" style=\"$iStyle\"></i>
	  </button>
	  
	  </span>";
	
	
	
?>	
<?php
}





		 
	
	public static function select_imprest_type()
	
	{?>
		
		<div class=row>
			<div class="col-sm-8 col-sm-offset-2">
		
		
				
				<div align="center1" class="well" style="text-align:center">
					<label> <b class="text-info"><h3>Select imprest type :</h3></label>
				<h5>
				<select id=sel_imprest_type>
				<option value=0>Select</option>
				<option value=Permanant>Permanant</option>
				<option value=Temporary>Temperory</option>
				</select>
				</h5>
			</div>
			</div>
			</div>
			
			<div class=row>
			<div class="col-sm-10 col-sm-offset-1">
			<div id=div_permanant ></div>
			<div id=div_temporary></div>
			
			</div>
			</div>
			
			
	
		
	
	
	
	
	<?php 
	}
	
	public static function show_permanant_imprest_form()
	{
		
		{?>
		
		<div class=row>
			<div class="col-sm-10 col-sm-offset-1 well" >
				
				<div align="center" style="margin:auto;text-align:center">
				<label for=txt_area_request_perm_imprest class="text-success" ><h3>Write Your Note here : </h3>
				<textarea cols=63 rows=10 id=txt_area_request_perm_imprest placeholder="Write here ...">	
				</textarea>
				</label>
				
				<button class="btn btn-primary "><p > Submit to Assistant Executive Engineer</p></button>
				</div>
				</div>
	
		
		
		</div>
	
	
	
	
	<?php 
	}
		
	}
	
	
public static function show_temporary_imprest_form()
	{
		
		{?>
		
		<div class=row>
			<div class="col-sm-10  col-sm-offset-1 well" >
				
				<div align="center" style="margin:auto;text-align:center">
				<label for=txt_area_request_temp_imprest class="text-success" ><h3>Write Your Note here : </h3>
				<textarea cols=63 rows=10 id=txt_area_request_temp_imprest placeholder="Write here ...">	
				</textarea>
				</label>
				
				<label for=btn_add_file_for_imprest style="display-inline-block"> Upload Documents :</label>
				
				<?php self::round_btn("btn_add_file_for_imprest","myBut1","Click to Add More documents","fa fa-plus-circle fa-3x","color:blue") ?>
				
				
				
				<ol id="ol_upload_documents" >
			
								
								
								 <div class=well>
				 <li>

						<label for="fileToUpload" > <i class="fa fa-cloud-upload fa-fw fa-2x text-success" >  </i></label>
						
						 <input type="text"  id="fileToUpload" style="display:inline-block" placeholder="Type of Document:" /> 

						
						
						<input type="file" name="fileToUpload" id="fileToUpload" style="display:inline-block" /> 
					
					<i class="fa fa-trash-o fa-1x i_delete_doc" style="color:red;display:inline-block" title="delete" data-placement="right" data-toggle="tooltip">  </i>
					
					</div>
				  </li>
				
				
				
				</ol>
				
				
				<button class="btn btn-primary"><p> Submit to Assistant Executive Engineer</p></button>
				
				
				
				</div>
				</div>
	
		
		
		</div>
	
	
	
	
	<?php 
	}
		
	}
		







	
public static function show_recoupment_imprest_form()
{?>
	
	
	
	
	<ol>
		<li>
<div class=row>
	<div class="col-sm-4 col-sm-offset-4 well" align=center>
		 <?php self::round_btn("btn_add_voucher","myButt1","Click To Add Voucher","fa fa-bank fa-5x","color:green"); 
		 
		 self::modal_btn("myModal","id","myButt1","click","fa fa-inr fa-5x","color:green","color:green","btn btn-info btn-lg");
		 ?>
		 </div>
	
	</div >
		<div class=row>
	
	<div class="col-sm-2 well">Date of purchase</div>
	<div class="col-sm-2 well">Date of Payement</div>
	<div class="col-sm-4 well">Description</div>
	<div class="col-sm-2 well">Amount</div>
	<div class="col-sm-2 well">Type of Expenditure</div>
	
	
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          <p>This is a large modal.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>	
	
			
				
					
</div>
</div>
</li>
</ol>
<?php
}	
	
	
	
	
	
	
	
	}
	
	
	
	

?>
