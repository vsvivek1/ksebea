<?php
session_start();
?>


<?php
include_once("../class/class.php");

function is_data_inserted($qry)
{
$conn=connection::con();
	$result = $conn->query($qry);
	$row = $result->fetch_assoc();
	
	//echo $qry;
if($row['count']>0) return true;
else return false;	
	
	
}

//print_r($_SESSION);
if($_SESSION['login']==true)
{
switch($_POST['option']){


case "get_edit_transaction_form":

transaction::showtransactionForm($_POST[trans_id]);
//transaction::showtransactionFormMobile($_POST[trans_id]);
break;





case "btn_edit_transactions":
$qry="select trans_id,date,description,income_in_rs,expense_in_rs,acc_name 
from transactions where unit='$_SESSION[unit]'";
//echo $qry;
transaction::transactionEditDelete($qry);
break;





case "deleteTransaction":

transaction::deleteTransaction($_POST[trans_id]);

break;

	
	
case "getDetailsOfThisId":

transaction::getSavedTransactionDetails($_POST[id]);

break;
	
	
case "btn_save_opening_balance" :

//transaction::firstDayOfFY($date);

transaction::addOpeningBalance($_POST[date],$_POST[bank_balance],$_POST[cash_balance]);
//echo $_POST[date];

break;

	
case "btn_view_account":
case "btn_view_account1":

transaction::viewAccountAbstract();
break;	
	
	
	
	
	case "save_transaction":
//print_r($_POST);
$date1=$_POST['date'];
$date=implode("-", array_reverse(explode("/", $date1)));
//echo "<h2 class=bg-warning>thsis is date $date</h2>";

//print_r($_FILES);


$_POST[date]=($_POST[date] == null) ? "" : $_POST[date];
$_POST[amount]=($_POST[amount] == null) ? 0 : $_POST[amount];
$_POST[type_of_transaction]=($_POST[type_of_transaction] == null) ? "NOT_DEFINED" : $_POST[type_of_transaction];
$_POST[party]=($_POST[party] == null) ? "UN_KNOWN" : $_POST[party];
$_POST[acc_head]=($_POST[acc_head] == null) ? "ACC_HEAD" : $_POST[acc_head];
$_POST[mode_of_payment]=($_POST[mode_of_payment] == null) ? "mode_of_payment" : $_POST[mode_of_payment];
$_POST[description]=($_POST[description] == null) ? "NO_DESCRIPTION_PROVIDED" : $_POST[description];


$_POST[trans_id]=($_POST[trans_id] == null) ? 0 : $_POST[trans_id];




if(!($_FILES['file']['name'])=="")
{
$photo = addslashes(file_get_contents($_FILES['file']['tmp_name'])); //SQL Injection defence!
$photo_name = addslashes($_FILES['file']['name']);
}
$photo=($photo==null) ? "":$photo;
$photo_name=($photo==null) ? "":$photo_name;

//echo $photo_name;	
	
if($_POST[type_of_transaction]=='expense')
	$type="expense_in_rs"; 
else 
	$type="income_in_rs"; 
	
	$qry="select count(trans_id) as count from transactions where 
	trans_id=$_POST[trans_id]";
	//echo $qry;
	if(is_data_inserted($qry))
		{
		/// code for update
		
$setdate=($_POST[date] =="") ? "" : "date='".$date."',";
$set_amount=($_POST[amount] ==0) ? "" : "$type=$_POST[amount],";



$set_party=($_POST[party] == "UN_KNOWN") ? "" : "acc_name='".$_POST[party]."',";
$set_acc_head=($_POST[acc_head] == "ACC_HEAD") ? "" : "acc_head='".$_POST[acc_head]."',";
$set_mode_of_payment=($_POST[mode_of_payment] == "mode_of_payment") ? "" : "mode_of_payement='".$_POST[mode_of_payment]."',";
$set_description=($_POST[description] =="NO_DESCRIPTION_PROVIDED") ?  "": "description='".$_POST[description]."'," ;
$set_photo=($photo=="") ? "":"photo=='".$photo."',";
$set_photo_name=($photo=="") ? "": "photo_name=='".$photo_name."'";
		
		
				
		echo "<h2 class=bg-danger>Updating transaction ....</h2>";
		
		$qry="update transactions 
		
		set 
		
		trans_id=$_POST[trans_id],
		$setdate
		$set_amount
		$set_party
		$set_acc_head
		$set_mode_of_payment
		$set_description
		$set_photo
		$set_photo_name
		unit='$_SESSION[unit]'
		
		where trans_id=$_POST[trans_id]
		";
		
		$conn=connection::con();
		$result = $conn->query($qry);
		if($result)
		{
			echo "<h2 class=bg-success>Transaction has been updated</h2>";
			$qry="select trans_id,date,description,income_in_rs,expense_in_rs,acc_name 
			from transactions where unit='$_SESSION[unit]'";
				//echo $qry;
				transaction::transactionEditDelete($qry);
		}else
		{
			echo "<h2 class=bg-danger>Transaction failed</h2>";
		}
		
		
	}else
		
		{
			
			$qry="insert into transactions

(
unit,
date,
description,
mode_of_payement,
$type,
acc_head,
acc_name,
photo,
photo_name

)
values
(
'$_SESSION[unit]',
'$date',
'$_POST[description]',
'$_POST[mode_of_payment]',

'$_POST[amount]',
'$_POST[acc_head]',
'$_POST[party]',
'$photo',
'$photo_name'

)			";
			
	//echo $qry;
	
	
			$conn=connection::con();
			$result = $conn->query($qry);
			//transaction::getSavedTransactionDetails(1);
			if($result)
			
		{
			echo "<h2 class=bg-success>The Transaction has been saved succesfully.</h2>";
			
				transaction::viewAccount();
			} else
			{
				echo "<h2 class=bg-danger>Saving transaction failed</h2>";
			}
			
			//code for insert
		}
	
	
	//print_r($_POST);
	
	
	
	break;
	
	
	
	
	case "sel_transaction_type":
	
	
	accountHeads::ShowAccountHeads($_POST['type']);
	
	break;
	
	
	
	
	case "btn_home":
	case "btn_home1":
	
	//$fy=transaction::findFinancialYear("");
	
	//echo $fy;
	$qry="select * from transactions";
	
	//transaction::transactionEditDelete($qry);
	
	
	
	?>
	<!--
		<div class="btn-group btn-group-lg btn-group-vertical">
									<button class="btn btn-primary navbtn" id=btn_home>HOME</button>
									<button class="btn btn-info navbtn" id=btn_add_transaction>ADD TRANSACTION</button>
									<button class="btn btn-success navbtn" id=btn_add_ob_cb>ADD OPENING /CLOSING BALANCE</button>
									<button class="btn btn-default navbtn" id=btn_view_transactions>VIEW TRANSACTIONS</button>
									<button class="btn btn-warning navbtn" id=btn_view_account>VIEW ACCOUNT</button>
									<button class="btn btn-danger navbtn" id=btn_exit>Log Out</button>
		</div>
	
	-->
	
	<div class="btn-group btn-group-lg btn-group-vertical">
									<button class="btn btn-primary navbtn" id=btn_home>HOME</button>
									<button class="btn btn-primary navbtn" id=btn_add_transaction>ADD TRANSACTION</button>
									<button class="btn btn-primary navbtn" id=btn_add_ob_cb>ADD OPENING /CLOSING BALANCE</button>
									<button class="btn btn-primary navbtn" id=btn_view_transactions>VIEW TRANSACTIONS</button>
									<button class="btn btn-primary navbtn" id=btn_view_account>VIEW ACCOUNT</button>
									<button class="btn btn-primary navbtn" id=btn_exit>Log Out</button>
		</div>
	<?php
	
	
	
	
	
	
	
	break;
	
	
	
	
	
	
	
	case "btn_add_transaction": 
	case "btn_add_transaction1": 
	//transaction::getSavedTransactionDetails(1);
	//$id=transaction::getlastTransactionNumber();
	//transaction::getSavedTransactionDetails(7);
	  
	  echo $_POST[btn_add_transaction];
	  
	 // transaction::showtransactionFormMobile($_POST[trans_id]);
	  //exit;
	  ?>
	  <style>
	  .table td, 
.table th {
    white-space: nowrap;
    width: 1%;
}
	  
	  </style>
	  <form id=form1>
	  <table class="table table-bordered table-striped table-hover text-primary text-lg">
	  <thead>
	  <th>
	  Transaction Details
	   <th>
	  Transaction Values
	  </th></th>
	  
	  </thead>
	  <tbody>
	  <tr><td>Unit</td><td id=td_unit><?php user::unit(); ?></td></tr>
	  
	  
	  
	  <tr><td>Transaction ID</td><td id=td_transaction_id><?php transaction::getNewTransactionNumber(); ?></td></tr>
	  <tr><td>Date</td><td><?php echo bootstrap::datePicker("date","date"); ?></td></tr>
	  <tr><td>Amount Rs.</td><td><?php bootstrap::showInput("text","amount","txt_amount") ?></td></tr>
	  
	  <tr>
		  <td>
			  <select id=sel_transaction_type  name=type_of_transaction class=form-control Style="padding-top:10px">
				<option value=0>SELECT THE TRANSACTION</option>  
			  <option value="expense">Paid to</option>
			  <option value="income">Received From</option>
			  </select>
		</td>
		  
		  <td><?php bootstrap::showInput("text","party","txt_name_of_party") ?></td>
		  
		 </tr>
	  <tr><td>Purpose</td><td id=td_show_account_heads></td></tr>
	  <tr><td>Mode</td><td>
		  
		  <select name=mode_of_payment class=form-control id=sel_mode_of_payment>
				<option value=0 >--Select--</option>
		  <option value="Cash">Cash</option>
		  <option value="Cheque">Cheque</option>
		  <option value="Acc Transfer">Acc Transfer</option>
		  <option value="PayTm">PayTm</option>
		  <option value="UPI">UPI</option>
		  
		  </select></td></tr>
		  
		  <tr><td>Description</td><td><?php bootstrap::showInput("text","description","txt_description") ?></td></tr>
		  <tr><td>Attacment</td><td><input name=file accept="image/*" capture="camera" type=file></td></tr>
		  <td><button id=btn_reset class="btn btn-danger"><i class="fa fa-power-off"> Reset </i></button></td>
		  <td><button type="submit" form=form1 id=btn_save_transaction class="btn btn-success"><i class="fa fa-floppy-o"> Save </i></button></td>
		  </tr>
		  <tr>
		  
		  </tr>
		  
	  
	  </tbody>
	  
	  </table>
	  </form>
	  <?php
	  
	  
	  
	   break;
	   
	   
	case "btn_add_ob_cb":
	case "btn_add_ob_cb1":
	
	
	/// check whther opening cash and bank balances are added alrady
	
	
	//$date=transaction::ddmmyyToyymmdd($date1);
		
		$date=date("Y/m/d");
		
		//echo $date;
		$firstDay=transaction::firstDayOfFY($date);
		$lastDay=transaction::lastDayOfFY($date);
		$fy=transaction::findFinancialYear($date);
		$conn=connection::connect();
	
	$qry="select count(trans_id) from transactions where date between '$firstday' and '$lastday' and unit='$_SESSION[unit]'
	
	and acc_head='Opening_bank_balance'";
	
	//echo $qry;
	
	
	?>
	
	
	
	  <table class="table table-bordered table-striped table-hover" style="padding:20px">
		  
		    <thead>
	  <th class="bg-primary text-center"colspan=2>
	  ADD OPENING BALANCE FOR FY <?php echo transaction::findFinancialYear(date('Y-m-d')); ?> 
	  
	   </th>
	  
	  </thead>
	  <tbody>
	  <tr><td>DATE</td><td><?php echo bootstrap::datePicker("date_add_opening_balance","date"); ?></td></tr>
	  
	  <?php 
	  $b=0;
	  $qry="select count(trans_id) from transactions where date between '$firstday' and '$lastday' and unit='$_SESSION[unit]'
	
	and acc_head='Opening_bank_balance'";
	  if(!transaction::is_data_inserted($qry))
	{
	  ?>
	  
	  <tr><td>BANK BALANCE</td><td><?php bootstrap::showInput("text","bankbalance","txt_bank_balance"); ?></td></tr>
	 <?php
 } else "<tr><td COLSPAN=2 CLASS=bg-danger>OPENING BALANCE HAS BEEN UPDATED</td></tr>";
 $b=1;
 
 
	 ?>
	 
	 
	 
	   <?php 
	  $qry="select count(trans_id) from transactions where date between '$firstday' and '$lastday' and unit='$_SESSION[unit]'
	
	and acc_head='Opening_bank_balance'";
	  if(!transaction::is_data_inserted($qry))
	{
	  ?>
	  <tr><td>CASH BALANCE</td><td><?php bootstrap::showInput("text","bankbalance","txt_cash_balance"); ?></td></tr>
	  <?php
 } else "<tr><td COLSPAN=2 CLASS=bg-danger>OPENING BALANCE HAS BEEN UPDATED</td></tr>";
 
 $b++;
 
	 if(!$b==2)
	 {
	 ?>
	 
	 
	  <tr><td COLSPAN=2><button class="btn btn-success" id=btn_save_opening_balance>Save</button></tr>
	  
	  <?php
  }
	  ?>
	  
	  </tbody>
	  
	  </table>
	  
	  <!--
	  <table class="table table-bordered table-striped table-hover" style="padding:20px">
		  
		    <thead>
	  <th>
	  ADD CLOSING BALANCE
	  
	   </th>
	  
	  </thead>
	  <tbody>
	  <tr><td>DATE</td><td><?php //common::showDatePicker(); ?></td></tr>
	  
	  
	  
	  <tr><td>BANK BALANCE</td><td><?php //common::showInputTextBox(); ?></td></tr>
	  <tr><td>CASH BALANCE</td><td><?php //common::showInputTextBox(); ?></td></tr>
	  <tr><td COLSPAN=2><button class="btn btn-success" id=btn_save_closing_balance>Save</button></tr>
	  
	  
	  
	  </tbody>
	  -->
	  </table>
	  
	  
	  
	  
	  
	  
	  <?php
	  
	
	
	
	
	 echo $_POST['option'];
	  break;
	 
	 
	case "btn_view_transactions":
	case "btn_view_transactions1":
	
	 $con=new connection();
	 
	//echo $_POST['option'];
	transaction::viewAccount();
	
	
	
	 break;
	
	
	case "btn_exit": 
	session_destroy();
		if (headers_sent()) {
    die("Redirect failed. <a href=./../index.php> Please click on this link: </a> to Re login");
}
else{
    //exit(header("Location: ./../index.php"));
    die("Redirect failed. <a href=./../index.php> Please click on this link: </a> to Re login");
}
	//include_once("./../index.php");

	//header("location:./../index.php");
	//exit;
	//echo $_POST['option'];
	break;
	
	
	
	
	
	
	}


}
else 
echo "<h2 class=bg-danger>Your session has expired <a href=./../index.php>Click here</a> to Re login</h2>";
?>
