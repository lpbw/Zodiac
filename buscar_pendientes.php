<?
session_start();
include "coneccion.php";


$locationU=$_SESSION['location'];


		
?>

 <table class="table table-striped table-condensed grid">
                            <thead>
							<tr>
                            <th>MO</th>
                           
                            <th>CN</th>
                            <th>Tipo de corte</th>
                            <th>No. Parte</th>
							<th>Long. Aprox.</th>
                            
                            <th>Posicion</th>
                            <th>Rollo</th>
							<th>Fibra</th>
                            <th>Long. Restante</th>
                           
							
							<th>Asignar Rollo</th>
							</tr>
                            </thead>
                            <tbody>

                            
                                        
	<?	 
	$contado=0; 
	$consulta  = "SELECT *  FROM cuts where deleted_at is null and location_assigned_id=$locationU and status<3 order by orden";
	$consulta="SELECT cuts.id,mo, cn, cut_type.nombre, length_measured, locations.name, location_capacities.number, rolls.lote, roll_fibers.fiber_type, rolls.remaining_inches, cuts.status, cuts.parte,(DATE_FORMAT(rolls.date_lote, '%m-%d-%Y'))as creado  
	FROM cuts inner join cut_type on cut_type.id=cuts.id_cut_type inner join locations on cuts.location_assigned_id=locations.id 
	left outer join location_capacities on cuts.number_position=location_capacities.id 
	left outer join rolls on rolls.id=cuts.roll_id 
	left outer join roll_fibers on cuts.fiber_id=roll_fibers.fiber_type 
	where cuts.deleted_at is null and cuts.location_assigned_id=$locationU and status=0 order by orden";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	while($res=mysql_fetch_assoc($resultado))
	{	
		?>
							<tr>
                                    <td><? echo $res['mo']?></td>
                                 
                                    <td><? echo $res['cn']?></td>
                                    <td><? echo $res['nombre']?></td>

                                <!--    <td>1</td>  ESTA ES LA LINEA VIEJA QUE REEMPLAZAMOS   -->

									<td><? echo $res['parte']?></td>
                                    <td><? echo $res['length_measured']?></td>
                                    
                                    <td><? echo $res['number']?></td>
                                    <? if($res['lote']==""){?><td  bgcolor="#FF0000">
									<? }else{?><td><? }echo "{$res['lote']}"." "."{$res['creado']}"; ?></td>
									<td><? echo $res['fiber_type']?></td>
                                    <td><? echo $res['remaining_inches']?></td>
                                    

                                   
                                    <td> <? if($contado==0){?><input name="roll_id" type="hidden" id="roll_id" value="<? echo $res['id'];?>" /><select class="form-control" id="rollo_asignar" name="rollo_asignar" > <option value="0" selected="selected">--Selecciona--</option>
                                  <?	  
	$consulta2  = "SELECT number, fiber_id, lote, rolls.id, remaining_inches FROM `location_capacities` left outer join rolls on location_capacities.id=rolls.location_slot where id_location =$locationU and location_slot<>0  and state_id=3 and rolls.fiber_id='".$res['fiber_type']."' order by number";
	$resultado2 = mysql_query($consulta2) or die("La consulta fall&oacute;P1: " . mysql_error());
	$count2=1;
	while(@mysql_num_rows($resultado2)>=$count2)
	{
		$res2=mysql_fetch_row($resultado2);
		
		echo"<option value=\"$res2[3]\" >$res2[0].- $res2[1] ($res2[2])- $res2[4] in</option>";
		$count2=$count2+1;
	}	
	echo"<option value=\"1\" >Fallout</option>";	
		?>
                                </select>
                                      <input name="asignar" type="submit" class="btn-default" id="asignar" value="Asignar" />
                                      <? }?></td>
							</tr>
                                       <? $contado++;}?>
									   </tbody>                     
                                                    </table>
