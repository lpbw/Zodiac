<?
session_start();
include "coneccion.php";

setlocale(LC_TIME, 'spanish');  
$fecha=mb_convert_encoding (strftime("%A %d de %B del %Y"), 'utf-8');

$hora=date("h:i A");

header("Content-type: application/vnd.ms-excel; name='excel'");
header("Pragma: no-cache");
header("Expires: 0");
header("Content-Disposition: filename=historial.xls");
$idU=$_SESSION['idU'];
$nombreU=$_SESSION['nombreU'];
$tipoU=$_SESSION['tipoU'];
$desde= $_POST["desde"];
$hasta= $_POST["hasta"];
$lote= $_POST["lote"];
$fibra= $_POST["fibra"];
$mo= $_POST["mo"];
$id_cut_type= $_POST["id_cut_type"];
$operador= $_POST["operador"];
?>

                                             <table class="table table-striped table-condensed grid">
                            <thead>
							<tr>
                            <th bgcolor="#999999">MO</th>                  
                            <th bgcolor="#999999">CN</th>
                            <th bgcolor="#999999">Tipo de corte</th>                       
                            <th bgcolor="#999999">Lugar</th>
                            <th bgcolor="#999999">Posicion</th>
                            <th bgcolor="#999999">Rollo</th>
							<th bgcolor="#999999">Fibra</th>					
                            <th bgcolor="#999999">Net</th>
                            <th bgcolor="#999999">Gross</th>
                            <th bgcolor="#999999">Total Used </th>
                           <th bgcolor="#999999">Long</th>
							<th bgcolor="#999999">Long. Defecto</th>
							<th bgcolor="#999999">Long. Total</th>
							<th bgcolor="#999999">Inicio</th>
							<th bgcolor="#999999">Fin</th>
							<th bgcolor="#999999">Operador</th>
							</tr>
                            </thead>
                            <tbody>

                            
                                        
	<?	  

	if($_POST['lote']!="")
		$lote_b="and rolls.lote='".$_POST['lote']."'";
	else
		$lote_b="";	
	if($_POST['fibra']!="")
		$fibra_b="and rolls.fiber_id='".$_POST['fibra']."'";
	else
		$fibra_b="";
	if($_POST['desde']!="" && $_POST['hasta']!="")
		$fecha_b="and DATE_FORMAT(software_init, '%Y-%m-%d')>='".$desde."' and DATE_FORMAT(software_init, '%Y-%m-%d')<='".$hasta."'";
	else
		$fecha_b="";
	if($_POST['mo']!="")
		$mo_b="and cuts.mo='".$_POST['mo']."'";
	else
		$mo_b="";
	if($_POST['id_cut_type']!="0")
		$cut_b="and cuts.id_cut_type='".$_POST['id_cut_type']."'";
	else
		$cut_b="";
	if($_POST['operador']!="0")
		$operador_b="and cuts.prod_user_id='".$_POST['operador']."'";
	else
		$operador_b="";	
	$consulta="SELECT mo, cn, nombre,name, number, lote, fiber_type, FORMAT(retail_length/36,2) as retail_length, FORMAT(guaranteed_length/36,2) as guaranteed_length,FORMAT(balance/36,2) as balance, FORMAT(length_consumed/36,2) as length_consumed, FORMAT(length_defect/36,2) as length_defect,  hardware_init, hardware_end, status  ,cuts.id as cuts_id , users.first_name as nombre2 FROM cuts inner join cut_type on cut_type.id=cuts.id_cut_type inner join locations on cuts.location_assigned_id=locations.id left outer join location_capacities on cuts.number_position=location_capacities.id inner join rolls on rolls.id=cuts.roll_id inner join roll_fibers on rolls.fiber_id=roll_fibers.fiber_type inner join users on users.id=cuts.prod_user_id where cuts.deleted_at is null  $lote_b $fibra_b $fecha_b $mo_b $cut_b $operador_b order by hardware_end desc";
	//echo"$consulta";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	while($res=mysql_fetch_assoc($resultado))
	{	
		$totalused=$res['length_consumed']+$res['length_defect'];
		?>
							<tr>
                                    <td><? echo $res['mo']?></td>
                                 
                                    <td><? echo $res['cn']?></td>
                                    <td><? echo $res['nombre']?></td>
                                    <td><? echo $res['name']?></td>
                                    <td><? echo $res['number']?></td>
                                    <td><? echo $res['lote']?></td>
									<td><? echo $res['fiber_type']?></td>
                                    <td><? echo $res['retail_length']?></td>
                                    <td><? echo $res['guaranteed_length']?></td>
                                    <td><? echo $res['balance']?></td>
									<td><? echo $res['length_consumed']?></td>
									<td><? echo $res['length_defect']?></td>
									<td><? echo $totalused?></td>
									<td><? echo $res['hardware_init']?></td>
									<td><? echo $res['hardware_end']?></td>
                                    

                                    <td><? echo $res['nombre2']?></td>
                              </tr>
                                       <? }?>
									   </tbody>                     
</table>
                   