var url="../ajax/ea_ajax.php";

function isDate(txtDate)
{
    var currVal = txtDate;
    if(currVal == '')
        return false;
    
    var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/; //Declare Regex
    var dtArray = currVal.match(rxDatePattern); // is format OK?
    
    if (dtArray == null) 
        return false;
    
  
	    dtDay = dtArray[1];
	    dtMonth= dtArray[3];
	    dtYear = dtArray[5]      
    
    if (dtMonth < 1 || dtMonth > 12) 
        return false;
    else if (dtDay < 1 || dtDay> 31) 
        return false;
    else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31) 
        return false;
    else if (dtMonth == 2) 
    {
        var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
        if (dtDay> 29 || (dtDay ==29 && !isleap)) 
                return false;
    }
    return true;
}

$(document).on('click','.navbar-collapse',function(e) {
    if( $(e.target).is('a') ) {
        $(this).collapse('hide');
    }
});

$(document).on("click",".delete",function() {

//alert("hi");
 $.ajax({
       url: url,
       type: 'POST',
       data:{trans_id:$(this).val(),option:'deleteTransaction'},
           
        beforeSend: show_ajax_loading_image(),
		complete: stop_ajax_loading_image(),
      
      
       success: function (response) {
         alert(response);
         
            $.ajax({
       url: url,
       type: 'POST',
       data:{option:'btn_edit_transactions'},
       async: false,
       cache: false,
        beforeSend: show_ajax_loading_image(),
		complete: stop_ajax_loading_image(),
          
     
       success: function (response) {
         
         
         $("#div_ajax_response").html(response);
       }
   });
         
         
         
       }
   });
	

});


$(document).on("click",".edit",function() {

//alert("hi");
 $.ajax({
       url: url,
       type: 'POST',
       data:{trans_id:$(this).val(),option:'get_edit_transaction_form'},
           
        beforeSend: show_ajax_loading_image(),
		complete: stop_ajax_loading_image(),
      
      
       success: function (response) {
         //alert(response);
        
        /* 
            $.ajax({
       url: url,
       type: 'POST',
       data:{option:'get_edit_transaction_form'},
       async: false,
       cache: false,
        beforeSend: show_ajax_loading_image(),
		complete: stop_ajax_loading_image(),
          
     
       success: function (response) {
         
         
         //$("#div_ajax_response").html(response);
         $("#div_modal_body").html(response);
         
       }
   });
         
   */     
    $("#div_modal_body").html(response);
    $('#myModal1').modal('toggle');
         
       }
   });
	




});






function validate_feild_for_money(ele)
{
	if(!$.isNumeric($(ele).val())){ alert("Please Enter a valid Amount"); return false; }
	if($(ele).val()<1) { alert("Please Enter a valid Amount"); return false; }

	
	
	}


$(document).on("keyup","#txt_bank_balance","#txt_cash_balance",function() {
	
	
	
	$(this).closest("td").removeClass("has-error");});



$(document).on("click","#btn_save_opening_balance",function() {

//$("#txt_bank_balance").closest("td").removeClass("has-error");
//$("#txt_cash_balance").closest("td").removeClass("has-error");


//validate_feild_for_money($("#txt_bank_balance"));
//validate_feild_for_money($("#txt_cash_balance"));


if(!$.isNumeric($("#txt_bank_balance").val())){ alert("Please Enter a valid Amount"); $("#txt_bank_balance").closest("td").addClass("has-error"); return false; }
if(!$.isNumeric($("#txt_cash_balance").val())){ alert("Please Enter a valid Amount");$("#txt_cash_balance").closest("td").addClass("has-error"); return false; }


if($("#txt_bank_balance").val()<1) { alert("Please Enter a valid Amount");$("#txt_bank_balance").closest("td").addClass("has-error"); return false; }
if($("#txt_cash_balance").val()<1) { alert("Please Enter a valid Amount");$("#txt_cash_balance").closest("td").addClass("has-error"); return false; }

//alert("hi");
 $.ajax({
       url: url,
       type: 'POST',
       data:{
		   date:$("#date_add_opening_balance").val(),
		   option:'btn_save_opening_balance',
		   bank_balance:$("#txt_bank_balance").val(),
		   cash_balance:$("#txt_cash_balance").val()
		   },
           
        beforeSend: show_ajax_loading_image(),
		complete: stop_ajax_loading_image(),
      
      
       success: function (response) {
         //alert(response);
         
         $("#div_modal_body").html(response);
       }
   });
	$('#myModal1').modal('toggle');




}
//$("#txt_bank_balance").val()
);








$(document).on("click",".transaction",function() {

//alert("hi");
 $.ajax({
       url: url,
       type: 'POST',
       data:{id:$(this).attr("id"),option:'getDetailsOfThisId'},
           
        beforeSend: show_ajax_loading_image(),
		complete: stop_ajax_loading_image(),
      
      
       success: function (response) {
         //alert(response);
         
         $("#div_modal_body").html(response);
       }
   });
	$('#myModal1').modal('toggle');




});

$(document).on("submit","#form1",function(evt){	 
      evt.preventDefault();
      
      //alert($(this)[0]);
      var formData = new FormData($(this)[0]);
      formData.append("alert","one");
			formData.append("option","save_transaction");
valid=true;

///////////////////////form validations ////////////////////
if(!isDate($("#date").val())){ alert("Please Enter a valid date"); var valid=false; return false;}


if($("#txt_amount").val()==""){ alert("Please Enter a valid Amount");var valid=false; return false;}
if($("#txt_amount").val()<0){ alert("Please Enter a valid Amount"); var valid=false;return false;}
if(!$.isNumeric($("#txt_amount").val())){ alert("Please Enter a valid Amount");var valid=false; return false;}

if($("#sel_transaction_type").val()==0){ alert("Please Select  a valid Transaction Type");var valid=false; return false;}


if($("#txt_name_of_party").val()==""){ alert("Please Enter the Party's Name'"); var valid=false;return false;}

if($("#mode_of_payment").val()==0){ alert("Please Select a Mode of payement'");var valid=false; return false;}

if($("#sel_acc_head").val()==0){ alert("Please Select an account head'");var valid=false; return false;}


if($("#txt_description").val()==""){ alert("Please Enter a Description'");var valid=false; return false;}






//////////////////////////////////////////////////////






			if(valid==true)
			{
		alert("ajax");	
			
  $.ajax({
       url: url,
       type: 'POST',
       data:formData,
       async: false,
       cache: false,
        beforeSend: show_ajax_loading_image(),
		complete: stop_ajax_loading_image(),
       contentType: false,
       enctype: 'multipart/form-data',
       processData: false,
       success: function (response) {
         alert("updated");
         
         $("#div_ajax_response,#th_ajax_response1").html(response);
       }
   });
   
			} else alert("false");
   return false;
 });


function validate_form()

{
	$(".form-control").closest("div").removeClass("has-error");
	$(".form-control").each( function() {
		
		$(this).closest("div").removeClass("has-error");
		
		
		if($(this).val()=="") { alert($(this).attr("id"));
			$(this).closest("div").addClass("has-error"); 
			return false; 
			}
		
		
		                         }
								 
	
	);
	
	return true;
}
	




function show_ajax_loading_image()  
	{
		
	
	$("#id_ajax_loading").css("display","block");
	
	}
	
	
	function stop_ajax_loading_image()
	{
		
		
	$("#id_ajax_loading").hide();
	}	
	
	
	
////////////////////////////////////////////change acount heads when payee or receiver ////////////////////////////////
$(document).on("change","#sel_transaction_type",function(){ 
	
	$.ajax({
       url: url,
       type: 'POST',
       data:{option:$(this).attr("id"),type:$(this).val()},
          
        beforeSend: show_ajax_loading_image(),
		complete: stop_ajax_loading_image(),
          
     
       success: function (response) {
         
         
         $("#td_show_account_heads").html(response);
       }
   });
	
	
	});	

//////////////////////////////////////////////////////////////////////////	
	
	
	
	
	
	
////////////////////////////////////submit form///////////////////////////////////////////////////
var url="../ajax/ea_ajax.php";







$(document).on("click",".navbtn",function(){	 
      
     
     //alert($(this).attr("id"));
     switch ($(this).attr("id"))
     {
		case "btn_home":
		case "btn_home1":
		
		var option="btn_home";
		var id=0;
		
		break;
		
		
		
		case "btn_add_transaction": 
		case "btn_add_transaction1": 
		  var option="btn_add_transaction"; break;
		
		
		case "btn_add_ob_cb": 
		case "btn_add_ob_cb1": 
		
		var option="btn_add_ob_cb"; break;
		
		case "btn_view_account":
		case "btn_view_account1":
		var option="btn_view_account"; break;
		
		case "btn_view_transactions":
		case "btn_view_transactions1":
		var option="btn_view_transactions"; break;
		
		case "btn_exit": 
		case "btn_exit1": 
		var option="btn_exit"; break;
		
		case "btn_edit_transactions":
		case "btn_edit_transactions1":
		 var option="btn_edit_transactions"; break;
	}
		 	 
		 
	 //alert(data1);   
   $.ajax({
       url: url,
       type: 'POST',
       data:{option:$(this).attr("id"),id},
       async: false,
       cache: false,
        beforeSend: show_ajax_loading_image(),
		complete: stop_ajax_loading_image(),
          
     
       success: function (response) {
         
         
         $("#div_ajax_response").html(response);
       }
   });
 
 });



//////////////////////////////btn reset on form transaaction////////////////////////////////

function reset_feilds(){
	$("input").val("");
	$("select").val($("select option:first").val());
	
	}

$(document).on("click","#btn_reset",reset_feilds);








//////////////////////////////end of btn reset on form transaaction////////////////////////////////


function ajax(data){
	
	   $.ajax({
       url: url,
       type: 'POST',
       data:data,
       async: false,
       cache: false,
        beforeSend: show_ajax_loading_image(),
		complete: stop_ajax_loading_image(),
       contentType: false,
       enctype: 'multipart/form-data',
       processData: false,
       success: function (response) {
         //alert(response);
         
         $("#div_tbl_out").html(response);
       }
   });
	
	
	
	}




//////////////////////////////submit form///////////////////////////////////
$(document).on("submit","form",function(evt){	 
      evt.preventDefault();
      
      //alert($(this)[0]);
      var formData = new FormData($(this)[0]);
      formData.append("alert","one");
      
      ajax(formData);

   return false;
 });





//////////////////////////////////////////end submit form transactions//////////////////////////









////////////////////////////////////End submit form///////////////////////////////////////////////////

	
	
	
	
	
	
	
	
/////////////////////////////////// add new window for upload voucher ////////////////////////////




$(document).on("click","#btn_add_file_for_imprest",function(){
	


var newId=$("#ol_upload_documents").find(">li").length+1;
out="<div class=well>";
out=out+"<li><label for=\"fileToUpload\" "+newId+" > <i class=\"fa fa-cloud-upload fa-fw fa-2x text-success\">  </i></label> <input type=\"text\"  id=\"fileToUpload"+newId;
out=out+"\" style=\"display:inline-block\" placeholder=\"Type of Document:\" />	<input type=\"file\" id=\"fileToUpload"+newId+"\" style=\"display:inline-block\" />";
out=out+"<i class=\"fa fa-trash-o fa-1x i_delete_doc\" style=\"color:red;display:inline-block\" title=\"Delete\" data-placement=\"right\" data-toggle=\"tooltip\">  </i></div>  </li> ";

 $("#ol_upload_documents").append(out);

});


$(document).on("click",".i_delete_doc",function()


{
	if(confirm("Do you wanted to remove This Document"))
	{
		$(this).closest(".well").remove();
		alert("Document Removed succesfully");
		
	}
	
	});

