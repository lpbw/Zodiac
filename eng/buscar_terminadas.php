<?
session_start();
include "coneccion.php";

$idU=$_SESSION['idU'];
$locationU=$_SESSION['location'];


		
?>


  
  <table class="table table-striped table-condensed grid">
                            <thead>
							<tr>
                            <th width="5%">MO Number</th>                  
                            <th width="5%">CN</th>
                            <th width="11%">Cut Category</th>                       
                            <th width="6%">Part Number</th>
                            <th width="8%">Tube</th>
                            <th width="6%">Roll</th>
							<th width="6%">Fabric</th>					
                            <th width="13%">Remaining Length</th>
                           <th width="6%">Length</th>
							<th width="12%">defect Length</th>
							<th width="6%">Start</th>
							<th width="4%">Finish</th>
							<th width="6%">Pause</th>
							<th width="6%">Error</th>
							</tr>
                            </thead>
                            <tbody>

                            
                                        
	<?	  
	$consulta  = "SELECT *  FROM cuts where deleted_at is null and location_assigned_id=$locationU and status<3 order by orden";
	$consulta="SELECT * ,cuts.id as cuts_id  FROM cuts inner join cut_type on cut_type.id=cuts.id_cut_type inner join locations on cuts.location_assigned_id=locations.id left outer join location_capacities on cuts.number_position=location_capacities.id inner join rolls on rolls.id=cuts.roll_id inner join roll_fibers on rolls.fiber_id=roll_fibers.fiber_type where cuts.deleted_at is null and cuts.location_assigned_id=$locationU and status>=3 and prod_user_id=$idU and DATE_FORMAT(software_init, '%Y-%m-%d')=curdate() order by hardware_end";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	while($res=mysql_fetch_assoc($resultado))
	{	
		?>
							<tr>
                                    <td><? echo $res['mo']?></td>
                                 
                                    <td><? echo $res['cn']?></td>
                                    <td><? echo $res['nombre']?></td>
                                    <td><? echo $res['parte']?></td>
                                    <td><? echo $res['number']?></td>
                                    <td><? echo $res['lote']?></td>
									<td><? echo $res['fiber_type']?></td>
                                    <td><? echo $res['remaining_inches']?></td>
									<td><? echo $res['length_consumed']?></td>
									<td><? echo $res['length_defect']?></td>

									<td><? echo $res['hardware_init']?></td>
									<td><? echo $res['hardware_end']?></td>
                                    

                                    <td <? if($res['pausa']==1)echo"bgcolor=\"#FFFF66\"";?> class="text-center"><a href="editar_pausa_prod.php?id=<? echo $res['cuts_id']; ?>" class="iframe1"><i class="fa fa-pencil-square-o"></i></a></td>
                                    <td <? if($res['status']==4)echo"bgcolor=\"#FF0000\"";?> class="text-center"><a href="editar_corte_prod.php?id=<? echo $res['cuts_id']; ?>" class="iframe3"><i class="fa fa-pencil-square-o"></i></a></td>
                              </tr>
                                       <? }?>
									   </tbody>                     
                                                    </table>