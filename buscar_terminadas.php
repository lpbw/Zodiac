<?
session_start();
include "coneccion.php";

$idU=$_SESSION['idU'];
$locationU=$_SESSION['location'];


		
?>


  
  <table class="table table-striped table-condensed grid">
                            <thead>
							<tr>
                            <th width="5%">MO</th>                  
                            <th width="5%">CN</th>
                            <th width="11%">Tipo de corte</th>                       
                            <th width="6%">No. Parte </th>
                            <th width="8%">Posicion</th>
                            <th width="6%">Rollo</th>
							<th width="6%">Fibra</th>					
                            <th width="13%">Long. Restante</th>
                           <th width="6%">Long</th>
							<th width="12%">Long. Defecto</th>
							<th width="6%">Inicio</th>
							<th width="4%">Fin</th>
							<th width="6%">Shorts</th>
							<th width="6%">Pausas</th>
							<th width="6%">Error</th>
							</tr>
                            </thead>
                            <tbody>

                            
                                        
	<?	  
	$consulta  = "SELECT *  FROM cuts where deleted_at is null and location_assigned_id=$locationU and status<3 order by orden";
	$consulta="SELECT * ,cuts.id as cuts_id,(DATE_FORMAT(rolls.date_lote, '%m-%d-%Y'))as creado  FROM cuts inner join cut_type on cut_type.id=cuts.id_cut_type inner join locations on cuts.location_assigned_id=locations.id left outer join location_capacities on cuts.number_position=location_capacities.id inner join rolls on rolls.id=cuts.roll_id inner join roll_fibers on cuts.fiber_id=roll_fibers.fiber_type where cuts.deleted_at is null and cuts.location_assigned_id=$locationU and status>=3 and prod_user_id=$idU and DATE_FORMAT(software_init, '%Y-%m-%d')=curdate() order by hardware_end";
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
                                    <td><? echo "{$res['lote']}"." "."{$res['creado']}";?></td>
									<td><? echo $res['fiber_type']?></td>
                                    <td><? echo $res['remaining_inches']?></td>
									<td><? echo $res['length_consumed']?></td>
									<td><? echo $res['length_defect']?></td>

									<td><? echo $res['hardware_init']?></td>
									<td><? echo $res['hardware_end']?></td>
                                    

                                    <td  class="text-center"><a href="editar_shorts_prod.php?id=<? echo $res['cuts_id']; ?>" class="iframe1"><i class="fa fa-pencil-square-o"></i></a></td>
                                    <td <? if($res['pausa']==1)echo"bgcolor=\"#FFFF66\"";?> class="text-center"><a href="editar_pausa_prod.php?id=<? echo $res['cuts_id']; ?>" class="iframe1"><i class="fa fa-pencil-square-o"></i></a></td>
                                    <td <? if($res['status']==4)echo"bgcolor=\"#FF0000\"";?> class="text-center"><a href="editar_corte_prod.php?id=<? echo $res['cuts_id']; ?>" class="iframe3"><i class="fa fa-pencil-square-o"></i></a></td>
                              </tr>
                                       <? }?>
									   </tbody>                     
                                                    </table>
