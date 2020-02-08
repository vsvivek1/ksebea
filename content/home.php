<?php
@session_start();
//require_once __DIR__ . '/../class/common.class.php';
//require_once __DIR__ . '/../class/class.connection.php';
//include_once("head.php");
require_once __DIR__ . '/head.php';
//require_once __DIR__ . '/../class/ld.class.php';
//common::con();
?>
<style>
	
@media screen and (max-width: 600px) {
  #div_menu_bar {
    visibility: hidden;
    clear: both;
    float: left;
    margin: 10px auto 5px 20px;
    width: 28%;
    display: none;
  }
}	
	
	
	
	
td{
	text-align:"left"
	
	}


#id_ajax_loading{
position : absolute;
 
  width:100%;
  height:100%;
  background-color:#666;
  
  
  background-position:center;
  z-index:10000000;
  opacity: 0.4;
  filter: alpha(opacity=40); /* For IE8 and earlier */
}
</style>
<script src="../script/ksebea.js">
</script>
<body>
	<div class="container-fluid">
<nav class="navbar navbar-inverse navbar-fixed-top bg-color:blue">
  <div class="container-fluid">
    <div class="navbar-header">
      
			      
			     
			     
			     
			    
			    
	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand bg-pimary text-warning" href="#">EA ACCOUNTING
  	  <i class="fa  fa-2x faa-pulse animated"></i> </a>
    </div>
			     
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
       
    <li class="active navbtn"id=btn_home1><a href="#">HOME<span class="sr-only">(current)</span></a></li>
        <li class="navbtn" id=btn_add_transaction1><a href="#">ADD TRANSACTION</a></li>
        <li class="navbtn"id=btn_add_ob_cb1><a href="#">ADD OPENING/CLOSING BALANCE</a></li>
        <li class="navbtn"id=btn_view_transactions><a href="#">VIEW TRANSACTIONS</a></li>
        <li class="navbtn"id=btn_view_account1><a href="#">VIEW ACCOUNT</a></li>
        <li class="navbtn"id=btn_exit1><a href="#">LOG OUT</a></li>
        
  
      
      </ul>		     
			     
		</div>	     
			     
			     
			     
			      <!--
			      <div class="collapse navbar-collapse" id="myNavbar">
			      
			      
			      <ul class="nav navbar-nav">
			        <li class="active"><a href="#">Home</a></li>
			        
			        <li><a href="#">Page 2</a></li>
			        <li><a href="#">Page 3</a></li>
			      </ul>
			      
			      
			      <ul class="nav navbar-nav navbar-right">
			        <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
			        <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
			      </ul>
			   
			   
			    </div>
			  </div>
      -->
      
      
      
      
    </div>
  </div>
</nav>
</div>

									
	





<div class="container-fluid"> <!---- MAIN div  ----------------------------------------------------------------------------------------------------->
	<div class=row style="padding-top:40px;vertical-align:middle">
			
			
			
			
			<div class="col-sm-3" style="text-align:center" id=div_menu_bar >
				<div class=well style="height: 1000px;background:grey;"> 
						<div class="btn-group btn-group-md btn-group-vertical" style="padding-top:75px">
									<button class="btn btn-primary navbtn" id=btn_home>HOME</button>
									<button class="btn btn-primary navbtn" id=btn_add_transaction>ADD TRANSACTION</button>
									<button class="btn btn-primary navbtn" id=btn_add_ob_cb>ADD OPENING /CLOSING BALANCE</button>
									<button class="btn btn-primary navbtn" id=btn_view_transactions>VIEW TRANSACTIONS</button>
									<!--<button class="btn btn-primary navbtn" id=btn_edit_transactions>EDIT TRANSACTIONS</button>  -->
									<button class="btn btn-primary navbtn" id=btn_view_account>VIEW ACCOUNT</button>
									<button class="btn btn-primary navbtn" id=btn_exit>Log Out</button>
						</div>
			</div>
	</div>
								<div class="col-sm-9 " style="text-align:center" style="padding-top:20px">
									<div id="id_ajax_loading" style="display:none; height:1000px">								    							    
												<i class="fa fa-spinner fa-spin fa-5x" style="color:#D4AF37"></i>
												<i class="fa fa-circle-o-notch fa-spin fa-5x" style="color:#c0c0c0 "></i>
												<i class="fa fa-refresh fa-spin fa-5x" style="color:blue"></i>
												<i class="fa fa-cog fa-spin fa-5x" style="color:blue"></i>
												<i class="fa fa-spinner fa-pulse fa-5x"  style="color:blue"></i>													    
											</div>
									
									
									<div id=div_ajax_resposne_save style="padding-top:20px"> </div>
									<div class="well" id=div_ajax_response style="padding-top:20px;height: 1000px">	
									</div>								

									
										
									
									

	
									
									
	
					
								
								
	</div><!----------------row col 8 ends------  -->
</div><!---- MAIN div ends----------------------------------------------------------------------------------------------------------  -->
</div>

<div class="container-fluid"> <!---- MAIN div  ----------------------------------------------------------------------------------------------------->
	<div class=row style="padding-top:10px;vertical-align:middle;padding-bottom:60px">
		<div class="col-sm-10 col-sm-offset-2" style="text-align:center" id=div_tbl_out>
			
			
			

		</div>					
	</div><!----------------------  -->
</div><!---- MAIN div ends----------------------------------------------------------------------------------------------------------  -->




<div class="container-fluid">
<nav class="navbar navbar-inverse navbar-fixed-bottom">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">
        <i class="fa fa-spanner fa-2x faa-pulse animated"></i>
        
      </a>
    </div>
  </div>
</nav>
</div>






<!--///////////////////////////////////////////MODAL HTML //////////////////////////////////////////////-->

<div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header panel-primary">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title text-primary">Transaction Details</h4>
        </div>
        <div class="modal-body" id=div_modal_body>
          
			<div class="panel-body" style="vertical-align:left;margin:auto" align=cendiv_edit_hsnter id=div_modal_body>
					
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div><!--- modal body -->
    </div>
  </div>













</body>
