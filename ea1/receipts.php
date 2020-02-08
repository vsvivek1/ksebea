<?php
session_start();
include_once("common.class.php");
include_once("table.php");

?>


<table>
<tr></tr>



</table>

<?php

$body="<div class=row><div class=\"col-sm-3 \">$common::datePicker(\"id2\"); </div>";

$body+="<div class=\"col-sm-3\">receipts::category()</div>";
$body+="</div>";


echo receipts::category();






//$body="<div class=col-sm-12>";
//$body = receipts::category();
$body=common::datePicker("id2");
common::panel("panel-green","Receipts",$body,$footer,"col-lg-8 col-lg-offset-2");

$panelHeading="head";
$headingRow=array(1,2,3,4);
$qry="select * from users";

table('tbl',$panelHeading,$headingRow,$qry);


?>


<div class=row> 
	<div class="col-sm-8 col-sm-offset-2">
<?php

?>
	</div>
</div>

<?php




?>
