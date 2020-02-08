<?php
session_start();
//require_once __DIR__ .("/../ea1/head.php");
class transaction extends connection


{
	
	
	public static function viewAccountAbstract()
	
	{
		
		$date=transaction::ddmmyyToyymmdd($date1);
		
		$firstDay=transaction::firstDayOfFY($date);
		$lastDay=transaction::lastDayOfFY($date);
		$fy=self::findFinancialYear($date);
		$conn=connection::connect();
		$qry="select acc_head as ACCOUNT_HEAD,sum(income_in_rs) as amount_spent  from transactions where unit='$_SESSION[unit]'   group by acc_head ASC WITH ROLLUP; ";
		
		$tableHead="INCOME DETAILS";
		self::showHorizontalTableForReport($qry,$tableHead);
		
		$qry="select acc_head as ACCOUNT_HEAD,sum(expense_in_rs) as amount_spent  from transactions where unit='$_SESSION[unit]'   group by acc_head ASC WITH ROLLUP;";
		//echo "<P>new</P>";
		$tableHead="EXPENDITURE DETAILS";
		self::showHorizontalTableForReport($qry,$tableHead);
		
	}
	
	
	public static function getNEwUnitTransactionNumber()
	
	{
		
	$conn=connection::connect();
	$qry="select coalesce(max (unit_trans_id)+1,1) as id from transactions where unit='$_SESSION[unit]'";
	
	$conn->query($qry);
	$result =$conn->query($qry);
	$row=$result->fetch_assoc();
	return  $row[id];
	
	
	//echo "ho";	
	}
	
	
	public static function showtransactionForm($trans_id=0)
	{
		if($trans_id>0)
		{
			//qry to get values
			$qry="select * from transactions where trans_id=$trans_id";
			//echo $qry;
			$conn=connection::con();
			$result =$conn->query($qry);
			$row=$result->fetch_assoc();
			
		$amount=($row[income_in_rs]==null) ? $row[expense_in_rs] : 	$row[income_in_rs];
			
			
		}
		?>
		
		<form id=form1>
			<th id=th_ajax_response1></th>
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
	  
	  
	  
	  <tr><td>Transaction ID</td><td id=td_transaction_id><?php transaction::getNewTransactionNumber($trans_id); ?></td></tr>
	  <tr><td>Date</td><td><?php echo bootstrap::datePicker("date","date",$row[date]); ?></td></tr>
	  <tr><td>Amount Rs.</td><td><?php bootstrap::showInput("text","amount","txt_amount",$amount) ?></td></tr>
	  
	  <tr>
		  <td>
			  <select id=sel_transaction_type  name=type_of_transaction class=form-control Style="padding-top:10px">
				<option value=0>SELECT THE TRANSACTION</option>  
			  <option value="expense">Paid to</option>
			  <option value="income">Received From</option>
			  </select>
		</td>
		  
		  <td><?php bootstrap::showInput("text","party","txt_name_of_party",$row[acc_name]) ?></td>
		  
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
		  
		  <tr><td>Description</td><td><?php bootstrap::showInput("text","description","txt_description",$row[description]) ?></td></tr>
		  <tr><td>Attacment</td><td><input name=file type=file accept="image/*" capture="camera"></td></tr>
		  <td><button id=btn_reset class="btn btn-danger"><i class="fa fa-power-off"> Reset </i></button></td>
		  <td>
			  <input type=hidden name=trans_id value=<?php echo $trans_id ?>>
			  
			  <button type="submit"  form=form1 id=btn_save_transaction class="btn btn-success"><i class="fa fa-floppy-o"> Save </i></button></td>
		  </tr>
		  <tr>
		  
		  </tr>
		  
	  
	  </tbody>
	  
	  </table>
	  </form>
	<?php	
	}
	
	
public static function showtransactionFormMobile($trans_id=0)
	{
		if($trans_id>0)
		{
			//qry to get values
			$qry="select * from transactions where trans_id=$trans_id";
			//echo $qry;
			$conn=connection::con();
			$result =$conn->query($qry);
			$row=$result->fetch_assoc();
			
		$amount=($row[income_in_rs]==null) ? $row[expense_in_rs] : 	$row[income_in_rs];
			
			
		}
		?>
		
		<form id=form1>
			<th id=th_ajax_response1></th>
	  
	 <div class=container> 
		 <div class=row>
		 <div class="col-sm-6">Transaction Details</div><div class="col-sm-6">Transaction Values</div>
		 <div class="col-sm-6">Unit</div><div class="col-sm-6" id=td_transaction_id><?php user::unit(); ?></div>
		 <div class="col-sm-6">Transaction ID</div><div class="col-sm-6" ><?php transaction::getNewTransactionNumber($trans_id); ?></div>
		 <div class="col-sm-6">Date</div><div class="col-sm-6" ><?php echo bootstrap::datePicker("date","date",$row[date]); ?></div>
		 <div class="col-sm-6">Amount Rs.</div><div class="col-sm-6" ><?php bootstrap::showInput("text","amount","txt_amount",$amount) ?></div>
		 <div class="col-sm-6"><select id=sel_transaction_type  name=type_of_transaction class=form-control Style="padding-top:10px">
				<option value=0>SELECT THE TRANSACTION</option>  
			  <option value="expense">Paid to</option>
			  <option value="income">Received From</option>
			  </select></div>
			  <div class="col-sm-6" ><?php bootstrap::showInput("text","party","txt_name_of_party",$row[acc_name]) ?></div>
		 
		 
	<div class="col-sm-6">Purpose</div><div class="col-sm-6" id=td_show_account_heads ><?php echo bootstrap::datePicker("date","date",$row[date]); ?></div>
	
	<div class="col-sm-6">Mode</div><div class="col-sm-6" ><select name=mode_of_payment class=form-control id=sel_mode_of_payment>
																				<option value=0 >--Select--</option>
																				  <option value="Cash">Cash</option>
																				  <option value="Cheque">Cheque</option>
																				  <option value="Acc Transfer">Acc Transfer</option>
																				  <option value="PayTm">PayTm</option>
																				  <option value="UPI">UPI</option>
																				  
																				  </select></div>
																		
		
		
		
	<div class="col-sm-6">Description</div><div class="col-sm-6" ><?php bootstrap::showInput("text","description","txt_description",$row[description]) ?></div>
	<div class="col-sm-6">Attacment</div><div class="col-sm-6" >
		<input name=file type=file accept="image/*" capture="camera"><?php bootstrap::showInput("text","description","txt_description",$row[description]) ?>
		</div>

		 
	<div class="col-sm-6"><button id=btn_reset class="btn btn-danger"><i class="fa fa-power-off"> Reset </i></button></div>
	
	<div class="col-sm-6"  ><button type="submit"  
	form=form1 id=btn_save_transaction class="btn btn-success"><i class="fa fa-floppy-o"> Save </i></button>
	<input type=hidden name=trans_id value=<?php echo $trans_id ?>>
	</div>
 
		 
		 
		 </div>
	 
	 </div>
	  
	 	  
		
	  </form>
	<?php	
	}	
	
	
	public static function deleteTransaction($trans_id)
	{
	
		$conn=connection::con();
		$qry="delete from transactions where trans_id=$trans_id";
		$result = $conn->query($qry);
		if($result){
			echo "Transaction Number with Trans_id : $trans_id has been Deleted";
			
		}
		else
		{
			echo "Error in deleting Transaction Number with Trans_id : $trans_id ";
		}	
	}
	
	
	
	
	
	public static function findFinancialYear($date)
	
{
						if (!empty ($date))
						{
						
						if (date('m',strtotime($date)) <= 3) 	{//Upto march
														$financial_year = (date('Y',strtotime($date))-1) . '-' . date('Y',strtotime($date));
													
													
													
													} else {//After march
																$financial_year = date('Y',strtotime("$date")) . '-' . (date('Y',strtotime($date)) + 1);
															}
						//echo $financial_year;
						return $financial_year;
					}
					else return null;
	
	}
	
	
	public static function firstDayOfFY($date)
	{
		$fy=self::findFinancialYear($date);
		//return $fy;
		//echo $fy;
		//$row=explode("-",$fy);
		//return $row;
		return explode("-",$fy)[0]."-04-01";
				
		}
		
		public static function lastDayOfFY($date)
	{
		$fy=self::findFinancialYear($date);
		return explode("-",$fy)[1]."-03-31";
				
		}
	
	
	
function get_start_of_financial_year($year) {
    // get the first Thursday before 2 Jan of $year
    return date("Y-m-d", strtotime("first day $date"));
}

	
	
	public static function yyddmmToDDMMYY($date1)
	
	{
		
$date=implode("-", array_reverse(explode("-", $date1)));
return $date;
	}
	
		public static function yyddmmToDDMMYY_slash($date1)
	
	{
		
$date=implode("/", array_reverse(explode("-", $date1)));
return $date;
	}
	
	public static function ddmmyyToyymmdd($date1)
	{
		
$date=implode("-", array_reverse(explode("/", $date1)));
return $date;
	}
	public static function is_data_inserted($qry)
{
$conn=connection::con();
	$result = $conn->query($qry);
	$row = $result->fetch_assoc();
if($row['count']>0) return true;
else return false;	
	
	
}
	
	
	public static function showHorizontalTableForReport($qry,$tableHead="")
	
	{
		$conn=connection::con();
		$result =$conn->query($qry);
		
		
		
		echo "<table class='table table-hovered table-stripped table-bordered'>";
		
		echo "<caption class='bg-info text-center'>$tableHead</caption>";
		//$row=$result->fetch_assoc;
		
		$sl=0;
		while($row = $result->fetch_assoc())
		{
			if($sl==0)
			{
						$sl++;
						$key=array_keys($row);
						foreach ($key as $td)
						{
							echo "<th class=bg-primary>";
							echo strtoupper($td);
							echo "</th>";
						}
			
			
			}
		
		echo "<tr>";
			foreach ($row as $rw)
			{
				echo "<td>";
				echo $rw;
				echo "</td>";
				
				
			}
		
			
			echo "</tr>";
			
			}
		
		
		echo "</table>";
		
		
		
		
		
		
		
	}
	
	
	
	
	public static function transactionEditDelete($qry)
	{
		$conn=connection::con();
		$result =$conn->query($qry);
		
		
		
		echo "<table class='table table-hovered table-stripped table-bordered'>";
		
		//$row=$result->fetch_assoc;
		
		$sl=0;
		while($row = $result->fetch_assoc())
		{
			if($sl==0)
			{
						$sl++;
						$key=array_keys($row);
						foreach ($key as $td)
						{
							echo "<th class=bg-primary>";
							echo strtoupper($td);
							echo "</th>";
						}
			echo "<th colspan=2 class='bg-primary text-center'>ACTION</th>";
			
			}
		
		echo "<tr>";
			foreach ($row as $rw)
			{
				echo "<td>";
				echo $rw;
				echo "</td>";
				
				
			}
			echo "<td><button class='btn btn-warning edit' value=$row[trans_id]>Edit</button></td>";
			echo "<td><button class='btn btn-danger delete' value=$row[trans_id]>Delete</button></td>";
			
			
			echo "</tr>";
			
			}
		
		
		echo "</table>";
		
		
		
	
		
		
	}
	
	
	
	
	
	public static function addOpeningBalance($date1,$bank_balance,$cash_balance)
	{
		
		$date=transaction::ddmmyyToyymmdd($date1);
		
		$firstDay=transaction::firstDayOfFY($date);
		$lastDay=transaction::lastDayOfFY($date);
		$fy=self::findFinancialYear($date);
		
		//echo $fy;
		
		$qry="select count(trans_id) as count from transactions
		 where date between '$firstDay' and '$lastDay' and acc_head='Opening_bank_balance'
		 and unit='$_SESSION[unit]'
		  ";
		//echo $qry;
		if(self::is_data_inserted($qry))
				{
			echo "<h2 class=bg-danger>Opening bank Balance has been updated for the financial Year $fy</h2>";
			
			$qry="select trans_id,unit,date,description,income_in_rs,acc_head from transactions 
			where date between '$firstDay' and '$lastDay' 
			and (acc_head='Opening_bank_balance' )
			and unit='$_SESSION[unit]'
			 ";
			transaction::transactionEditDelete($qry);
		}
		else
		{ //insert
			/////////////////////////////bank balance////////////////////////////////
			
			$acc_head="Opening_bank_balance";
			$description="Opening_bank_balance";
			$income=$bank_balance;
			$qry="insert into transactions 
			
			(unit,date,description,income_in_rs,acc_head)
			values
			
			('$_SESSION[unit]','$date','$description',$income,'$acc_head')";
			
			//echo $qry;
			
			$conn=connection::con();
		$result = $conn->query($qry);
		if($result)
		{
			echo "<h2 class=bg-primary>Opening bank Balance has been updated</h2>";
		}else
		{
			echo "<h2 class=bg-danger>Transaction failed</h2>";
		}
			
		}
		
		/////////////////////////////cash balance////////////////////////////////
		$qry="select count(trans_id) as count from transactions
		 where date between '$firstDay' and '$lastDay' and acc_head='Opening_cash_balance'
		 and unit='$_SESSION[unit]'
		  ";
		//echo $qry;
		if(self::is_data_inserted($qry))
				{
			echo "<h2 class=bg-danger>Opening bank Balance has been updated for the financial Year $fy</h2>";
			
			$qry="select trans_id,unit,date,description,income_in_rs,acc_head from transactions 
			where date between '$firstDay' and '$lastDay' 
			and (acc_head='Opening_cash_balance' )
			and unit='$_SESSION[unit]'
			 ";
			transaction::transactionEditDelete($qry);
		}else
		{	
			$acc_head="Opening_cash_balance";
			$description="Opening_cash_balance";
			$income=$cash_balance;
			$qry="insert into transactions 
			
			(unit,date,description,income_in_rs,acc_head)
			values
			
			('$_SESSION[unit]','$date','$description',$income,'$acc_head')";
			
			$conn=connection::con();
		$result = $conn->query($qry);
		if($result)
		{
			echo "<h2 class=bg-success>Opening Cash Balance has been updated</h2>";
		}else
		{
			echo "<h2 class=bg-danger>Transaction failed</h2>";
		}
	}	
			
		}
		
	
	
	
	
	public static function viewAccount()
	{
$conn=self::con();

$qry="select * from transactions where unit='$_SESSION[unit]' ";
//echo $qry;
$result = mysqli_query($conn,$qry);
?>
<div class="panel panel-info">
	<div class="panel-heading font-large">KSEBEA Transactions </div>
	<div class="panel-body">
<table class="table table-striped table-bordered table-hover" id="tbl_view_accounts">
	<caption class=bg-primary style="text-align:center"><h4>View Account Details</h4> </caption>
	<thead>
	<th>Transid</th><th>Date</th><th>Description</th><th>Income</th><th>Expense</th><th>ACC Head</th>
	</thead>
	<tbody>
<?php	
	
	
	
	
while($row=$result->fetch_assoc())
{
	echo "<tr class='transaction' id=$row[trans_id]>";
	echo "<td>$row[trans_id]</td>";
	echo "<td>".self::yyddmmToDDMMYY($row[date])."</td>";
	echo "<td>$row[description]</td>";
	echo "<td>$row[income_in_rs]</td>";
	echo "<td>$row[expense_in_rs]</td>";
	echo "<td>$row[acc_head]</td>";
	echo "</tr>";
}

?>
</tbody>
</table>
</div>
</div>	
<script>
		$("#tbl_view_accounts").DataTable({     responsive: true      }); 
		
		
		
		
		</script>
<?php
}
	
	
	
	public static function getNewTransactionNumber($trans_id=0)
	
	{
		
		if($trans_id==0)
		{
		
		$conn=self::con();
		$qry="select COALESCE(max(trans_id) +1,1) as trans_id from transactions ";
		///echo $qry;
		//$result = $conn->query($qry);
		$result = mysqli_query($conn,$qry);
		$row=$result->fetch_assoc();
		//$row = mysqli_fetch_assoc($result);
		
		echo $row[trans_id];
		return;
	}else
	
	{
		echo $trans_id;
		return;
		
	}
		}
		
		
		public static function getlastTransactionNumber()
	
	{
		$conn=self::con();
		$qry="select COALESCE(max(trans_id),1) as trans_id from transactions ";
		///echo $qry;
		//$result = $conn->query($qry);
		$result = mysqli_query($conn,$qry);
		$row=$result->fetch_assoc();
		//$row = mysqli_fetch_assoc($result);
		
		//echo $row[trans_id];
		return $row[trans_id];
		
		}
	
	
	public static function getSavedTransactionDetails($trans_id)
	{
		
		$conn=self::con();
		
		$qry="select * from transactions where trans_id=$trans_id";
		$result = mysqli_query($conn,$qry);
		$row=$result->fetch_assoc();
		?>
		<div class="panel panel-success">
	<div class="panel-heading font-large">Transaction  </div>
	<div class="panel-body">
		<table class="table table-hover table-bordered table-stripped" id=tbl_saved_txn>
			<th>Details</th><th>Values</th>
		<tr class=text-success><td>Trns_id</td><td><?php echo $row[trans_id]; ?></td></tr>
		<tr class=text-success><td>Unit</td><td><?php echo $row[unit]; ?></td></tr>
		<tr class=text-success><td>Date</td><td><?php echo $row[date]; ?></td></tr>
		<tr class=text-success><td>Description</td><td><?php echo $row[description]; ?></td></tr>
		<tr class=text-success><td>Mode of Payement</td><td><?php echo $row[mode_of_payement]; ?></td></tr>
		<tr class=text-success><td>Income</td><td><?php echo $row[income_in_rs]; ?></td></tr>
		<tr class=text-success><td>Expense</td><td><?php echo $row[expense_in_rs]; ?></td></tr>
		<tr class=text-success><td>Account head</td><td><?php echo $row[acc_head]; ?></td></tr>
		<tr class=text-success><td colspan=2 style="text-align:center">Photo</td></tr>
		<tr class=text-success><td colspan=2 style="text-align:center">
			
	<?php echo '<img width=400px height=400px src="data:image/jpeg;base64,'.base64_encode( $row['photo'] ).'"/>'; ?>
		
		</td></tr>
		
		</table>
		</div>
		</div>
		<?php
		
		
	}
	
	}

class bootstrap extends connection

{
	public function __construct()
	
	{
		require_once __DIR__ .("/../ea1/head.php");
	}
	
	public static function panel($id="id",$panelClass="panel-red",$heading="",$body="",$footer="",$style,$col="col-sm-4 col-sm-offset-4")
	{ 
		
		?>   <div class="row" style=<?php echo $style ?>>
			
                <div class="<?php echo $col?> ">
                    <div class="panel <?php echo $panelClass?>">
                        <div class="panel-heading">
                            <?php echo $heading?>
                        </div>
                        <div class="panel-body" id=<?php echo $id; ?>>
								<?php echo $body?>
                        </div>
                        <div class="panel-footer">
                            <?php echo $footer?>
                        </div>
                    </div>
				</div>
			
                    
                    <?php
	}
	
public static function showInput($type="text",$name="name",$id="id",$value="",$label="")

{
	?>
	<!--<div class="form-group has-error">
		  <label for="<?php echo $id?>"><?php echo $label?></label> -->
		  <input type="<?php echo $type?>" class="form-control" id=<?php echo $id?> value="<?php echo $value?>" name="<?php echo $name?>" >
	<!--</div> -->

<?php

}


public static function datePicker($id="",$name="name",$value=""){
	
	
	$date=transaction::yyddmmToDDMMYY_slash($value);
	$res="
	
	
	
	<script src=\"startbootstrap-sb-admin-2-gh-pages/vendor/jquery/jquery.min.js\"></script>
	 <script src=\"../ea1/bootstrap-datepicker-1.6.4-dist/js/bootstrap-datepicker.js\"></script>
	 <link href=\"../ea1/bootstrap-datepicker-1.6.4-dist/css/bootstrap-datepicker.css\" rel=\"stylesheet\" type=\"text/css\">
	 
<script type=\"text/javascript\">
	
	
	
$(document.body).on('focus', \"#".$id."\" ,function(){ $(this).datepicker(
	
	{
        format: \"dd/mm/yyyy\",
        todayBtn: true,
        clearBtn: true,
        daysOfWeekHighlighted: \"0,6\",
         autoclose: true
    }	
	
	);});
</script>
<input type=text class=form-control  id=$id  name=$name value=$date>
	";
	
	return $res;
	

	
}	
	
	
	
	
	}



 class connection{
	 
	 
	 
	public function __construct()
	{
		require_once __DIR__ .("/../ea1/head.php");
	}
	
	 
	 
	 
public static  function connect()

{
	
	
	
	if($_SERVER[HTTP_HOST]=="localhost")
	{
								$servername="localhost";
								$username="root";
								$password="";
								$dbname="ksebea";
	} else
	{
	

								$servername="mysql.hostinger.in";
								$username="u619046258_ea";
								$password="idea@1234";
								$dbname="u619046258_ea";	
								
								/*
								$servername="localhost";
								$username="root";
								$password="";
								$dbname="ksebea";	
								*/		
								
								
							}
// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";

}	 
	 
public static function con()
{

															if($_SERVER[HTTP_HOST]=="localhost")
	{
								$servername="localhost";
								$username="root";
								$password="";
								$dbname="ksebea";
	} else
	{
	

								$servername="mysql.hostinger.in";
								$username="u619046258_ea";
								$password="idea@1234";
								$dbname="u619046258_ea";	
								
								/*
								$servername="localhost";
								$username="root";
								$password="";
								$dbname="ksebea";	
								*/		
								
								
							}	
// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);
return $conn;
}	 
	 
	 
	 
	 }
	 
	class user extends bootstrap{
		
		public static function validate_user($loginName,$secret)
		{
			
			
			
			
								if($_SERVER[HTTP_HOST]=="localhost")
	{
								$servername="localhost";
								$username="root";
								$password="";
								$dbname="ksebea";
	} else
	{
	

								$servername="mysql.hostinger.in";
								$username="u619046258_ea";
								$password="idea@1234";
								$dbname="u619046258_ea";	
								
								/*
								$servername="localhost";
								$username="root";
								$password="";
								$dbname="ksebea";	
								*/		
								
								
							}	
			
			
			if ($conn->connect_error) {
										    die("Connection failed: " . $conn->connect_error);
									  }
									  else
							{
								$qry="select * from users where login_name='$loginName' and password='$secret'";
								$conn = new mysqli($servername, $username, $password,$dbname);
								$result = $conn->query($qry);
	//echo $qry;
									if ($result->num_rows > 0) 
								
										{
							   
											$row = $result->fetch_assoc(); 
							                if($row["login_name"]==$loginName and $row["password"]==$secret and $row["live"]=='yes')
							                  {
			///login is true
												
												$_SESSION['login']=true;
												$_SESSION['user']=$row["login_name"];
												$_SESSION['menus']=$row["menus"];
												$_SESSION['unit']=$row["unit"];
												//$_SESSION['user']=$row["menus"];
												return true;
												
												}
			
												
    
    
    
    
											}
											else {
 
		
		//echo "login failed";
		
		$x=1;
		
						require_once __DIR__ ."./../content/head.php";
				//require_once __DIR__ ."./class/class.php";
								$body="Invalid Login credentials.Login Failed";
								$footer="<a href=./../index.php>Click Here to Re Login</a>";
								
								// panel($id="id",$panelClass="panel-red",$heading="",$body="",$footer="",$col="col-sm-4 col-sm-offset-4")
								
								bootstrap::panel("id",'panel panel-red',"warning",$body,$footer,"padding:150px");	
								
								
								
								//include_once __DIR__ .("./../index.php");
								//header('Location: ./../index.php?login=false');
								
								
								
								//echo "<h2 class=bg-danger>Invalid Login credentials.Login Failed</h2>";
								
								//echo "<h2 class=bg-info><a href=./../index.php>Click Here to Re Login</h2>";
								
								
								return false;
	
	
												}
											$conn->close();
											}
		
		
		
		
									}
					public static function unit()
					{
						
						//print_r($_SESSION);
						echo $_SESSION["unit"];
						return;
					}				
									
									
		
			}
	 
	 
	 
	 
	 
	 class accountHeads extends connection
	 {
/*		 
$acc_head_id;
$account_head_type;
$account_head_name;
$current_status;
$modified_on;
$modified_by;
 */
 
 public static function ShowAccountHeads($type="income")


 {
	 

								if($_SERVER[HTTP_HOST]=="localhost")
	{
								$servername="localhost";
								$username="root";
								$password="";
								$dbname="ksebea";
	} else
	{
	

								$servername="mysql.hostinger.in";
								$username="u619046258_ea";
								$password="idea@1234";
								$dbname="u619046258_ea";	
								
								/*
								$servername="localhost";
								$username="root";
								$password="";
								$dbname="ksebea";	
								*/		
								
								
							}
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
//$conn = new mysqli($servername, $username, $password);
	
	if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
	
	 
	 $qry="select * from account_heads where account_head_type='$type'";
	 
	 //echo $qry;
	 //$result =$conn->query($qry);
	 
	 $result = mysqli_query($conn,$qry);
 
 
 
 if (mysqli_num_rows($result) > 0)
  {
	 //echo "success";
 } //else echo "failed";
 
 
 
 
 
 
	 
//	  if ($result->num_rows > 0) {
    // output data of each row
    ?><select name=acc_head id=sel_acc_head class=form-control> <option value=0>--select--</option>
    <?php
    while($row = mysqli_fetch_assoc($result)) {
		
        echo "<option>$row[account_head_name]</option>";
    }
//}


?>
</select>
<?php


$conn->close();
	 
 }
 
		 
		 
		 }








?>
