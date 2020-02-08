<?php


switch($_POST['option']){
	
	
	
	case 1:
	?>
	
	<style>
.frmSearch {border: 1px solid #F0F0F0;background-color:#CCFFFF;margin: 2px 0px;padding:40px;}
#country-list{float:left;list-style:none;margin:0;padding:0;width:190px;}
#country-list li{padding: 10px; background:#FAFAFA;border-bottom:#F0F0F0 1px solid;}
#country-list li:hover{background:#F0F0F0;}
<?php echo '#'.$_POST[sugBox].'';?>{padding: 10px;border: #F0F0F0 1px solid;}
</style>
<script src="../bootstrap/jquery.js"></script>
<script>function 
selectContractor(val) {
	
$(<?php echo '"#'.$_POST[inp].'"';?>).val(val);
$(<?php echo '"#'.$_POST[sugBox].'"';?>).hide();
}
</script>
<ul id="country-list">
	<li onClick="selectContractor('<?php echo $row["name"]; ?>');">pasu kala</li>	

</ul>
<?php	
	break;
	
	
	
	
	}
?>
