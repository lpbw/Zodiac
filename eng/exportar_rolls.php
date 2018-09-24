<?
session_start();
include "coneccion.php";

setlocale(LC_TIME, 'spanish');  
$fecha=mb_convert_encoding (strftime("%A %d de %B del %Y"), 'utf-8');
$fib="EMPTY";
$restan=0;
$flag=0;
$hora=date("h:i A");

header("Content-type: application/vnd.ms-excel; name='excel'");
header("Pragma: no-cache");
header("Expires: 0");
header("Content-Disposition: filename=reporte.xls");
?>

   
   <table class="table table-striped table-condensed">
                     
					<th bgcolor="#CCCCCC">Lot number </th>
                        <th bgcolor="#CCCCCC">Fabric</th>
                    <th bgcolor="#CCCCCC">Supplier Gross QTY</th>
                    <th bgcolor="#CCCCCC">Supplier Net QTY</th>
                    <th bgcolor="#CCCCCC">Total used</th>
                    <th bgcolor="#CCCCCC">Remaining QTY</th>
                    <th bgcolor="#CCCCCC">Location</th>
                    <th bgcolor="#CCCCCC">Tube</th>
					<th bgcolor="#CCCCCC">Warehouse</th>
                    <th bgcolor="#CCCCCC">Status</th>
					

                    
                    
	<?	 
	
	$consulta  = "SELECT rolls.id,  lote, fiber_type, retail_length, FORMAT(guaranteed_length/36,2), FORMAT((guaranteed_length-remaining_inches)/36,2), FORMAT(remaining_inches/36,2), locations.name, location_capacities.number, roll_states.description, storage.name, state_id  FROM rolls inner join roll_fibers on rolls.fiber_id=roll_fibers.fiber_type inner join roll_states on rolls.state_id=roll_states.id
left outer join  location_capacities on location_capacities.id=rolls.location_slot  
left outer join locations on location_capacities.id_location=locations.id 
left outer join storage on storage.id=rolls.storage_id
where rolls.deleted_at is null order by fiber_type";

	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1:$consulta " . mysql_error());
	$count=1;
	while(@mysql_num_rows($resultado)>=$count)
	{
		$res=mysql_fetch_row($resultado);
		?>
		 <tr>
			<td><? echo"$res[1]"; ?></td>
			<td><? echo"$res[2]"; ?></td>
			<td><? echo"$res[3]"; ?></td>
			<td><? echo"$res[4]"; ?></td>
			<td><? echo"$res[5]"; ?></td>
			<td><? echo"$res[6]"; ?></td>
			<td><? echo"$res[7]"; ?></td>
			<td><? echo"$res[8]"; ?></td>
			<td><? echo"$res[10]"; ?></td>
			<td><? echo"$res[9]"; ?></td>
			
			
		</tr>
		<?
		$count=$count+1;
	}	
		
		?>
                                        
</table>
      