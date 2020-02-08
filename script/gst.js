///////////////////////////////////ajax call for key up searching hsn codes ///////////////////////////////////
var url="../ajax/gst3_ajax.php";
//var url="../ajax/gst_ajax1.php";


//$("#tbl_gst_rates").DataTable({     responsive: true      });
$("#tbl_kseb_hsn_codes").DataTable({     responsive: true      });
$("#dataTables-example,dataTables-example2").DataTable({ responsive: true      });



$(document).on("keyup","#search-box",function(){

if($(this).val().length>3)

{
	

		$.ajax({
		type: "POST",
		url: url,
		data:{ keyword : $(this).val(), option :4, hsn:$("#search-box").val(), type:$("input[name='search-type']:checked").val()},
		beforeSend: show_ajax_loading_image(),
		complete: stop_ajax_loading_image(),
		success: function(data){
			
			
			
			
			$("#div_result_search_hsn").html(data);
//			$("#tbl_kseb_hsn_codes").DataTable({     responsive: true      });
			
			//$("#suggesstion-box").css("background","#FFF");
			//$("#suggesstion-box").show();
			//$("#suggesstion-box").html(data);
			//$("#search-box").css("background","#FFF");
		}
		});
	
	}
	});











/////////////////////////////////// END OF ajax call for key up searching hsn codes ///////////////////////////////////



////////////////////////////////////// select hsn code /////////////////////////////////////////////////

$(document).on("click",".sel_hsn", function() {
	
	var hsn=$(this).closest('td').siblings('td.td_hsn1').html();
	var des_gst=$(this).closest('td').siblings('td.td_description_gov1').html();
	
	
	//alert(hsn);
	
	//$(document).each(alert($(this).attr("id")));
	
	$("#td_hsn2").html(hsn);
	$("#td_description_gov2").html(des_gst);
	$('#myModal1').modal('toggle');
	$('#btn_search_hsn').hide();
	
	//alert(hsn);
	
	
	})



//////////////////////////////////////  end select hsn code /////////////////////////////////////////////////








	
	function load_saved_data2(){
	
	$.ajax({
						type: "POST",
						url: url,
						data:{ keyword : "", option :1, hsn:$("#search-box").val(), type:$("input[name='search-type']:checked").val()},
						beforeSend: show_ajax_loading_image(),
							complete: stop_ajax_loading_image(),
						success: function(data){
							
							$("#div_gst_table_ksebl_entry").html(data);
							$("#tbl_kseb_hsn_codes").DataTable({     responsive: true      });
	
						}
						});
	
	
	
	}
	
	
	
	
	
	
function load_saved_data(){
	
	$.ajax({
						type: "POST",
						url: url,
						data:{ keyword : "", option :1, hsn:$("#search-box").val(), type:$("input[name='search-type']:checked").val()},
						beforeSend: show_ajax_loading_image(),
							complete: stop_ajax_loading_image(),
						success: function(data){
							$("#suggesstion-box").css("background","#FFF");
							$("#suggesstion-box").show();
							$("#suggesstion-box").html(data);
							$("#search-box").css("background","#FFF");
							
						}
						});
	
	
	
	}
	
		


function show_ajax_loading_image()  
	{
		
	$("#id_ajax_loading").css("display","block");
	
	}
	
	
	function stop_ajax_loading_image()
	{
				
	$("#id_ajax_loading").hide(1000);
	}
	
	$(document).ready(function(){



	load_saved_data();
		});



$(document).on("click","#btn_clear_hsn",function(){
	
	$("#search-box").val("");
	$("#div_result_search_hsn").html("");
	
	
	});

$(document).on("click","#btn_cancel_edit",function(){
	
	
	$("#div_edit_hsn").html("");
	
	
	//alert($("#h2_edit_hsn_details").html());
	
	 $("#add_new_hsn").show();
	 
	 $(".mod").attr("disabled",false); 
	//$("#btn_search_hsn").show();

	
	}



);



//$("#btn_clear_hsn").click(function(){alert("hi");});

//alert("j")	;

$(document).on("click",".mod,#add_new_hsn",function(){	

	///alert($(this).attr("class"));
	//alert($(this).attr("id"));
	var show_btn_search_hsn=1;
	if($(this).attr("id")=="add_new_hsn")
	{ 
		var header="ADD NEW HSN ";
		var hsn="";
		$("#add_new_hsn").hide();
		$(".mod").attr("disabled",true);
		
		
		} 
	
	
	else if($(this).hasClass("mod"))
	{
		var header="EDIT HSN DETAILS";
		$("#td_hsn").html($(this).val());
		var hsn=$(this).val();
		
		var des_ksebl_old=$(this).closest("td").siblings("td.td_desc_kseb").html();
		var acc_code_old = $(this).closest("td").siblings("td.td_acc_code").html();
		
	 show_btn_search_hsn=0;
	$("#add_new_hsn").hide();
	//$("#btn_search_hsn").hide();
	} 
	

	$.ajax({
			
		type: "POST",
		url: url,
		data:{ keyword : "", option :2,
			show_btn_search_hsn:show_btn_search_hsn,
			 hsn:hsn,header: header,
			des_ksebl_old:des_ksebl_old,
			acc_code_old:acc_code_old},
		beforeSend: show_ajax_loading_image(),
		complete: stop_ajax_loading_image(),
		success: function(data){
					
			$("#div_edit_hsn").html(data);
//			$("#tbl_gst_rates").DataTable({  responsive: true      });
			
			
			$("#btn_save_hsn_kseb").attr('disabled',false);
			$("#add_new_hsn").show();
			
			
		}
		});
	
	
	});	
	
	
$(document).on("click","#btn_save_hsn_kseb",function(){	

	
	var hsn=$("#td_hsn2").html().trim();
	var des_ksebl=$("#txt_ksebl_des").val().trim();
	var uom=$("#txt_uom").val();
	var rates=$("input[name=radio_rate]:checked").attr("id");
	var acc_code=$('#txt_acc_code').val().trim();


if(hsn=="") {alert("Please Provide a Valid HSN");return; }
if(des_ksebl=="") {alert("Please Provide a Valid Description");return; }
if(uom=="--Select--") {alert("Please Provide a Valid Unit of Measurement ");return; }
if(typeof rates== typeof undefined) {alert("Please select a Rate");return; }


	$.ajax({
			
		type: "POST",
		url: url,
		data:{
			  hsn : hsn,
			  option :3, 
			  uom:uom,
			  rates:rates,
			  des_ksebl:des_ksebl,
			  acc_code:acc_code
			  },
		beforeSend: show_ajax_loading_image(),
		complete: stop_ajax_loading_image(),
		success: function(data){
			try{
				data1=data.split("-*-");
				response = JSON.parse(data1[1])
				if(response['status']==true)	//IF SAVE SUCCESS RELOAD SUGGESSTION BOX///
				{
///////  copied code from search-box keyup event START //////

 load_saved_data2();
 
$("#div_edit_hsn").html("");
					
//////  copied code from search-box keyup event  END //////di

				}
				alert(response['message']);
			}
			catch(e)
			{
				alert('Error in server response!');
			}
			
		}
		});
	
	
	});	
		
	
	
	
	
	
	function 
selectContractor(val) {
	
$("#search-box").val(val);
$("#suggesstion-box").hide();
}
