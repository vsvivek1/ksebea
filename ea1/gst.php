<?php
include_once("header.php");
?>

<style>
#body{width:610px;}
.divTop {border: 1px solid #A0B0C0;background-color:#00000;margin: 2px 0px;padding:40px;}



.frmSearch {border: 1px solid #80F0F0;background-color:#88FFFF;margin: 2px 0px;padding:30px;}
.rmu {border: 1px solid #A0B0C0;background-color:#DDFFFF;margin: 2px 0px;padding:40px;}
country-list{float:left;list-style:none;margin:0;padding:0;width:190px;}
country-list li{padding: 10px; background:#FAFAFA;border-bottom:#F0F0F0 1px solid;}
country-list li:hover{background:#F0F0F0;}
search-box{padding: 10px;border: #F0F0F0 1px solid;}
.div_box {margin-top:15px;margin-bottom:15px;background-color:#FFE4C4;z-index:50}
.div_footer_nav{position: fixed;bottom:0;right:30;left:30;width: 300px;border: 3px solid #73AD21}
</style>



<script>
	$(document).on("keyup",function(){

		$.ajax({
			option:2,
		type: "POST",
		url: "gst_ajax.php",
		data:{ keyword : $(this).val(), option :1, hsn:$("#search-box").val()},
		beforeSend: function(){
			$("#search-box").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
		},
		success: function(data){
			$("#suggesstion-box").css("background","#FFF");
			$("#suggesstion-box").show();
			$("#suggesstion-box").html(data);
			$("#search-box").css("background","#FFF");
		}
		});
	});



$(document).on("click","#btn_clear_hsn",function(){alert("hi");});
//$("#btn_clear_hsn").click(function(){alert("hi");});

//alert("j")	;

</script>
<div class="container-fluid">
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">
        <i class="fa fa-ksebl fa-2x faa-pulse animated"></i>
        
      </a>
    </div>
  </div>
</nav>
</div>

<div class="container-fluid">
<div class=row style="padding:100px">
<div class="col-sm-2">hhh </div>
	<div class="col-sm-8">
	
	<i class=text-primary>HSN code</i> <input  id=search-box type=text>
	
	<button  id="btn_clear_hsn"  class="btn btn-danger">Clear</button>
			<div id="suggesstion-box"></div>
	</div>
	
	<div class="panel panel-primary"  id=div_sell_tender_notice>
	<div class="panel-heading font-large">GST HSN CODES</div>
	<div class="panel-body">

			
				<div id=div_search_box></div>  				
				
				<div id=div_list_purchased_contractors></div>
					
			</div>
			</div>
			 
	
	
	
	
	
	
	<div class="col-sm-2">hhh </div>
	</div>
	</div>
	


<div class="container-fluid">
<nav class="navbar navbar-inverse navbar-fixed-bottom">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">
        <i class="fa fa-ksebl fa-2x faa-pulse animated"></i>
        
      </a>
    </div>
  </div>
</nav>
</div>
