<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">HSN Details</h4>
      </div>
      <div class="modal-body well">
        
       
       <table class="table">
       <tr>
       <td> HSN number</td><td id=td_hsn></td></tr>
       
       <td>Description by Govt</td> <td id=td_description_gov></td></tr>
       <td>Description by KSEBL</td><td id=td_description_kseb> <input type=text id=txt_ksebl_description_modal value=""></td></tr>
       <td>Unit of Measurement</td><td id=td_uom>
       <select type=text id=txt_uom>
	       <option>No</option>
	       <option>kg</option>
	       <option>m</option>
	       <option>km</option>
       </select></td></tr>
       
       <tr><td colspan=2 id=td_kseb_rate></td></tr>
       
      
       
       </table> 
       
        
        
        
      </div>
    
      
      <div class="modal-footer">
		  <button type="button"  id=btn_save_hsn_kseb  class="btn btn-primary" data-dismiss="modal" disabled>Save</button>
        <button type="button"  class="btn btn-default" data-dismiss="modal">Cancel</button>
        
      </div>
     <!--  END OF Modal --> 
    
    
    
    </div>

  </div>
</div>
