<script>
$('[data-toggle="tooltip"]').tooltip();
</script>
<?php

//include_once("head.php");
//include_once("common.class.php");
include_once("imprest.class.php");


switch ($_POST["option"]){
	
	
	case 1:
	 imprest::select_imprest_type();
	 break;
	
	case 2:
	 imprest::show_permanant_imprest_form();
	 break;
	
	case 3:
	 imprest::show_temporary_imprest_form();
	 break;
	 
	 case 4:
	 imprest::show_recoupment_imprest_form();
	 break;
	
	
	
	
	
	
	
	}
?>
