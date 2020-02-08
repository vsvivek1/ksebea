<?php
include_once("head.php");

function datatables($panelHeading="",$id="id",$headingRow=array(1,2,3,4,5),
$contentRow=array(array(1,2,3,4,5),array(1,2,3,4,5),array(1,2,3,4,5),array(1,2,3,4,5)  ),$panel="panel-yellow" )
{
?>


<!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class='<?php echo "panel $panel";?>'
                        <div class="panel-heading">
                            <?php echo $panelHeading ;?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="<?php echo $id ;?>">
                                <thead>
                                    <tr>
										
										<?php
										
										foreach ($headingRow as $r)
										
									
									{
										echo "<th>$r</th>";
									}
										?>
                                        
                                    </tr>
                                </thead>
                               
                               
                                <tbody>
									<?php 
									
									//print_r($contentRow);
									foreach ($contentRow as $row)
									{
										//print_r($row);
                                    echo "<tr class=\"odd gradeX1\">";
                                    
                                      
                                        foreach ($row as $ar)
                                        {
											
											echo "<td>$ar</td>";
											
											
										}
                                       
                                    echo "</tr>";
                                   }  ?> 
                                </tbody>
                            </table>
                           
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->


           
            <script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js1"></script>
   
   <script>
    $(document).ready(function() {
        $("#<?php echo $id ;?>").DataTable({
            responsive: true
        });
    });
    </script>
<?php



}
datatables("Table");
?>
