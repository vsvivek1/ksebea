<?php
session_start();
include_once("common.class.php");

session_destroy();
$footer="<a href=index.php>Click Here to Re Login</a>";
common::panel("panel-yellow","Notice","You have successfully loged out",$footer)

?>
