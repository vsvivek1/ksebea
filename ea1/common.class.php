<?php
include_once("head.php");

class common
{
	
	function __construct()
	{
		echo "hi";
	}
	


public static function modal_btn($modalId,$id="id",$class="myButt1",$toolTip="click",$fontAwesome="fa fa-inr fa-5x",
$iStyle="color:white",$style="",$btnClass="btn btn-info btn-lg")

{

//echo "<button type=\"button\"  data-toggle=\"modal\" data-target=\"#$modalId\">Open Modal</button>";
	
 echo  "
 <span data-toggle=\"tooltip\" title=\"$toolTip\"  data-placement=\"right\" >
 <button id=$id
	  class=\"$class\" data-target=\"#$modalId\" data-toggle=\"modal\" style=\"$style \" ><i class=\"$fontAwesome\" style=\"$iStyle\"></i>
	  </button>
	  
	  </span>";
	
	
	
?>	
<?php
}







public static function datePicker($id="",$name="name"){
	
	$res="
	
	
	
	<script src=\"startbootstrap-sb-admin-2-gh-pages/vendor/jquery/jquery.min.js\"></script>
	 <script src=\"bootstrap-datepicker-1.6.4-dist/js/bootstrap-datepicker.js\"></script>
	 <link href=\"bootstrap-datepicker-1.6.4-dist/css/bootstrap-datepicker.css\" rel=\"stylesheet\" type=\"text/css\">
	 
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
<input type=text  id=$id >
	";
	
	return $res;
	

	
}




	
public static function select($qry,$id="id",$name="name")

{
	self::connect();
	$res=pg_query($qry);
	
	$return="<div class=\"row\">
		<div class=\"col-sm-10\">
	<div class=\"form-group\">
        <label>Selects</label>
        <select class=\"form-control\" id=".$id." >
          <option value=\"\">SELECT</option>";
		
		while($row=pg_fetch_array($res))
		
		{
		 $return .="<option value=".$row[0].">".$row[1]."</option>";
		}
		$return .="</select>
        </div>
        </div>
  </div>";
        
  return $return;
	
}	
	
	
	
	
	
	
	
	
	public static function panel($id="id",$panelClass="panel-red",$heading="",$body="",$footer="",$col="col-sm-4 col-sm-offset-4")
	{ 
		
		?>   <div class="row">
			
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
	
	
	
	public  function connect()
	
	{		
	try{	
	$con= pg_connect('host=localhost dbname=ksebea user=postgres password=123456');
} catch (Exception $e) {echo "could not connect";}
	if($con)
	{
		return $con;
	} 		
	else 
	echo "Connection failed";
		//include_once("index.php");
		exit;

	}
	
	
	
	

	
	
	
	}
	
	
	class user extends common
	
	{
		
		
			
	public static function login($uname,$pass)
	
	{
	
	self::connect();
	
	$qry="select * from users where user_name='$uname' and pass_code='$pass' and user_status='1'";
	//echo $qry;
	
	//try{
	$res=pg_query($qry);
	$ar=pg_fetch_assoc($res);
	//print_r($ar[]);
		//}catch (Exception $e) {echo "exception"; }
		
		//echo $ar[user_name],
	if($ar[user_name]==$uname && $ar[pass_code]==$pass)
		{
		$_SESSION['login']=true;
		$_SESSION['user_name']=$ar[user_name];
		$_SESSION['status']=$ar[status];
		
		
		return true;
		
	}
	else 
	{
		
		//echo "login failed";
		
		
		$body="Invalid Login credentials.Login Failed";
		$footer="<a href=index.php>Click Here to Re Login</a>
		
";
		self::panel('Panel-red',"warning",$body,$footer);	
		//include_once("index.php");
		
		return false;
	
}	
		
	}
		
		}
		
class receipts extends common
{
	
	static function category()
	
	{
		
		
		$qry="select head_no,head_name from account_head where head_type='P'";
		
		
		return self::select($qry);
		?>
		
		
		<?php
	}
	
	
	
	}		
		
		

?>
