<?php
include_once("head.php");
include_once("common.class.php");


?>
<style>
#id_ajax_loading{
	
	position:fixed;
	margin:auto;
	text-align:center;
	vertical-align:middle;
	
			       width: 100%;
			        height:100%;
			        margin-top:20%;
			         opacity: 1;
			          z-index:100;
			          display:none;"
	
	
	
	}	
	
	
li
{
	padding:10px;
	
	}
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


.more{
	//background-image:url("more.png");
	width:100px;
	height:100px;
	
	}

.btn-circle {
  width: 20px;
  height: 20px;
  text-align: center;
  padding: 6px 0;
  font-size: 12px;
  line-height: 1.428571429;
  border-radius: 15px;
}
</style>
<script>
$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();
	
	$(document.body).on('ready','[data-toggle="tooltip"]' ,function(){ $(this).tooltip()});
	 
	$("#ul_show_more").hide();
	
	$("#btn_show_options").click(
	
	function() {$("#ul_show_more").slideToggle();
	
	//$("#btn_show_options").attr("id","btn_hide_options");
	
}
	
	);
	
	
	/*
	$("#btn_hide_options").click(
	
	function() {$("#ul_show_more").hide();
	
	$("#btn_hide_options").attr("id","btn_show_options");
	
}
	
	);
	
	*/
	
	function show_ajax_loading_image()  
	{
		
	
	$("#id_ajax_loading").css("display","block");
	
	}
	
	
	function stop_ajax_loading_image()
	{
		
		
	$("#id_ajax_loading").hide(1000);
	}
	
	
	
	
	
	
/////////////////////////////////////////////////////////////////request imprest button click////////////////////////////////////
$("#btn_request_imprest").click(function(){

$.ajax({
    url: "imprest_ajax.php",
    cache: false,
     type:'POST',
    data:{option:1},
    beforeSend: show_ajax_loading_image(),
    complete: stop_ajax_loading_image(),
    success: function(html){ $('#div_ajax_out').html(html);   }
    
    
});	
	
	
	
});
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function load(html)

{
	$('#div_ajax_out').html(html);
}

////////////////////////////////////////////////////////////////////////////////////////////// select_imprest_type//////////////////////////////////////
$(document).on("change","#sel_imprest_type",function () {

				if($(this).val()=="Permanant")
					var option=2; 
				else if($(this).val()=="Temporary") 
					var option=3; 
				
				else if ($(this).val()==0) 
					{alert("Please select Imprest Type"); return;}
	
					$.ajax({
				    url: "imprest_ajax.php",
				    cache: false,
				     type:'POST',
				    data:{option:option},
				    beforeSend: show_ajax_loading_image(),
				    complete: stop_ajax_loading_image(),
				    success: function(html){ $('#div_permanant').html(html);   }
				
    
    
    }
);}
);

//////////////////////////////////////////////////////////////////////////////////////////////////////////


/////////////////////////////////// add voucher ////////////////////////////

$(document).on("click","#btn_add_voucher",function () {

				
	
					$.ajax({
				    url: "imprest_ajax.php",
				    cache: false,
				     type:'POST',
				    data:{option:option},
				    beforeSend: show_ajax_loading_image(),
				    complete: stop_ajax_loading_image(),
				    success: function(html){ $('#div_permanant').html(html);   }
				
    
    
    }
);}
);




/////////////////////////////////////////////////////////////////////////



/////////////////////////////////////////////////////////////////////////////////RECOUPMENT OF IMPREST //////////////////////////////////////
$(document).on("click","#btn_recoup_imprest",function () {

				
	
					$.ajax({
				    url: "imprest_ajax.php",
				    cache: false,
				     type:'POST',
				    data:{option:4},
				    beforeSend: show_ajax_loading_image(),
				    complete: stop_ajax_loading_image(),
				    success: function(html){ $('#div_ajax_out').html(html);   }
				
    
    
    }
);}
);

//////////////////////////////////////////////////////////////////////////////////////////////////////////











});



</script>

 <?php
	 function round_btn($id="id",$class="myBut",$toolTip="click",$fontAwesome="fa fa-inr fa-5x",$iStyle="color:white")
	 {
		 echo  "<button id=$id
	  class=\"$class\" data-toggle=\"tooltip\" title=\"$toolTip\" data-placement=\"left\"><i class=\"$fontAwesome\" style=\"$iStyle\"></i>
	  </button>";
	
		 
		 }
	 ?>

<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">
        <i class="fa fa-ksebl fa-2x faa-pulse animated"></i>
        
      </a>
    </div>
  </div>
</nav>




<div class=row style="padding:100px">
<div class="col-sm-2">hhh </div>
	<div class="col-sm-8">
	
	
			<div id="id_ajax_loading">
						    
						    
						<img  src="loading.gif" style="margin:auto" alt="Updating ..."  />
			
			</div>	
	
	
	
		
		<?php common::panel("div_ajax_out","panel-red","<h1>Imprest <div style=\"text-align:right;display:inline-block\"><span  class=\"fa fa-ksebl fa-1x faa-pulse animated   \"></span></div></h1>","","Regional IT Unit Kozhikode","col-sm-12") ?>
		
	
	
	</div>


</div>
			<div class="col-sm-2">
				<div>
	
					<?php round_btn("btn_show_options","myBut","Show Options","fa fa-angle-double-down fa-5x","color:red") ?>	 
	 

				
				<div>
					<ul id=ul_show_more style="list-style: none;">
						
						
						<li>
							<?php round_btn("btn_request_imprest","myBut","Request Imprest","fa fa-inr fa-3x","color:red") ?>	
						
						</li>
						<li>
							<?php round_btn("btn_recoup_imprest","myBut","ReCoupment of Imprest","fa fa-balance-scale fa-3x","color:red") ?>	
					
					
						<li>
							<?php round_btn("btn_show_options","myBut","Closing of Imprest","fa fa-power-off fa-3x","color:red") ?>	
						</li>
					
					
					</ul>
					
					
				</div>
	</div> 


</div>
</div>



</div>



