<?
session_start();
include "coneccion.php";

setlocale(LC_TIME, 'spanish');  
$fecha=mb_convert_encoding (strftime("%A %d de %B del %Y"), 'utf-8');

$hora=date("h:i A");

header("Content-type: application/vnd.ms-excel; name='excel'");
header("Pragma: no-cache");
header("Expires: 0");
header("Content-Disposition: filename=reporte_lectra_capacity.xls");
$desde= $_GET["desde"];
$hasta= $_GET["hasta"];
?>

   
<table class="table table-striped table-condensed grid">
                            <thead>
							<tr>
                            <th width="5%" bgcolor="#CCCCCC">MO</th>                  
                            <th width="5%" bgcolor="#CCCCCC">CN</th>
                            <th width="11%" bgcolor="#CCCCCC">usuario</th>
                            <th width="11%" bgcolor="#CCCCCC">Tipo de corte</th>                       
                            <th width="6%" bgcolor="#CCCCCC">Lugar</th>
                            <th width="8%" bgcolor="#CCCCCC">Posicion</th>
                            <th width="6%" bgcolor="#CCCCCC">Rollo</th>
							<th width="6%" bgcolor="#CCCCCC">Fibra</th>					
                            <th width="13%" bgcolor="#CCCCCC">Long. Restante</th>
                           <th width="6%" bgcolor="#CCCCCC">Long</th>
							<th width="12%" bgcolor="#CCCCCC">Long. Defecto</th>
							<th width="6%" bgcolor="#CCCCCC">SW Inicio </th>
							<th width="6%" bgcolor="#CCCCCC">SW Fin </th>
							<th width="6%" bgcolor="#CCCCCC">HW Inicio</th>
							<th width="4%" bgcolor="#CCCCCC">HW Fin</th>
							<th width="6%" bgcolor="#CCCCCC">Duracion</th>
							<th width="6%" bgcolor="#CCCCCC">Pausas</th>
							</tr>
                            </thead>
                            <tbody>

                            
                                        
	<?	  

	
	
	$consulta="SELECT * ,cuts.id as cuts_id, TIMESTAMPDIFF(MINUTE,hardware_init,hardware_end) as tiempo, users.first_name as nombre2  FROM cuts inner join cut_type on cut_type.id=cuts.id_cut_type inner join locations on cuts.location_assigned_id=locations.id left outer join location_capacities on cuts.number_position=location_capacities.id inner join rolls on rolls.id=cuts.roll_id inner join roll_fibers on rolls.fiber_id=roll_fibers.fiber_type inner join users on users.id=cuts.prod_user_id where cuts.deleted_at is null and  status>=3  and DATE_FORMAT(software_init, '%Y-%m-%d')>='".$desde."' and DATE_FORMAT(software_init, '%Y-%m-%d')<='".$hasta."'   order by cuts.location_assigned_id, hardware_end";
	//echo"$consulta";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1:$consulta " . mysql_error());
	while($res=mysql_fetch_assoc($resultado))
	{	
		?>
							<tr>
                                    <td><? echo $res['mo']?></td>
                                 
                                    <td><? echo $res['cn']?></td>
                                    <td><? echo $res['nombre2']?></td>
                                    <td><? echo $res['nombre']?></td>
                                    <td><? echo $res['name']?></td>
                                    <td><? echo $res['number']?></td>
                                    <td><? echo $res['lote']?></td>
									<td><? echo $res['fiber_type']?></td>
                                    <td><? echo $res['remaining_inches']?></td>
									<td><? echo $res['length_consumed']?></td>
									<td><? echo $res['length_defect']?></td>

									<td><? echo $res['software_init']?></td>
									<td><? echo $res['software_end']?></td>
									<td><? echo $res['hardware_init']?></td>
									<td><? echo $res['hardware_end']?></td>
                                    

                                    <td  class="text-center"><? echo $res['tiempo']?></td>
                                    <td  class="text-center"><? echo $res['pausa']?></td>
                              </tr>
                                       <? }?>
									   </tbody>                     
                                                    </table>
      