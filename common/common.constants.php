<?php
/**
 *@version		1.0
 *@name			common.constants.php
 *@abstract		Constants definitions
 *@author		maheep vm
 *@since		28-06-2017
 **/

if(!defined('APPLICATION_ID_INTERNAL')) define('APPLICATION_ID_INTERNAL', '1');
if(!defined('APPLICATION_ID_SARAS')) define('APPLICATION_ID_SARAS', '2');
if(!defined('APPLICATION_ID_ORUMANET')) define('APPLICATION_ID_ORUMANET', '3');
if(!defined('APPLICATION_ID_SCM')) define('APPLICATION_ID_SCM', '4');

if(!defined('SERVICE_ID_GET_TAX_RATES')) define('SERVICE_ID_GET_TAX_RATES', '1');
if(!defined('SERVICE_ID_GET_CALCULATED_TAX')) define('SERVICE_ID_GET_CALCULATED_TAX', '2');
if(!defined('SERVICE_ID_GET_STATE_CODES')) define('SERVICE_ID_GET_STATE_CODES', '3');
if(!defined('SERVICE_ID_SAVE_SUPPLY_INVOICE')) define('SERVICE_ID_SAVE_SUPPLY_INVOICE', '4');
if(!defined('SERVICE_ID_GET_ALL_HSN_CODES')) define('SERVICE_ID_GET_ALL_HSN_CODES', '5');

if(!defined('TRANSACTION_INTRASTATE')) define('TRANSACTION_INTRASTATE', '1');
if(!defined('TRANSACTION_INTERSTATE')) define('TRANSACTION_INTERSTATE', '2');

if(!defined('INVOICE_TYPE_TAXABLE_GOODS')) define('INVOICE_TYPE_TAXABLE_GOODS', '1');
if(!defined('INVOICE_TYPE_TAXABLE_SERVICE')) define('INVOICE_TYPE_TAXABLE_SERVICE', '2');
	
?>