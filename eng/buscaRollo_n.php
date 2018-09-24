<?
include "coneccion.php";
$location=$_GET["location"];
$fibra=$_GET["fibra"];


if(location!="0")
{	
	$dato="";
	$dato=" <label for=\"location_id\">Roll:</label>Set Length <select class=\"form-control\" id=\"roll_id\" name=\"roll_id\" ><option value=\"0\" selected=\"selected\">--Select Roll--</option>";
	$consulta  = "SELECT number, fiber_id, lote, rolls.id FROM `location_capacities` left outer join rolls on location_capacities.id=rolls.location_slot where id_location =$location and location_slot<>0  and state_id=3 and rolls.fiber_id='".$fibra."' order by number";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	$count=1;
	while(@mysql_num_rows($resultado)>=$count)
	{
		$res=mysql_fetch_row($resultado);
		
		$dato=$dato."<option value=\"$res[3]\" >$res[0].- $res[1] ($res[2])</option>";
		$count=$count+1;
	}	
	$dato="$dato </select><br>Length.<input type=\"text\" class=\"form-control\" id=\"longitud\" name=\"longitud\" value=\"\"/><br>Defect Length<input type=\"text\" class=\"form-control\" id=\"longitud_def\" name=\"longitud_def\" value=\"\"/>";
                                       
	/*$consulta  = "select locations.id, locations.name from locations inner join rolls on locations.id=rolls.location_id and rolls.fiber_id='$id' where  rolls.deleted_at is null and locations.deleted_at is null group by  locations.id, locations.name";	
	//echo"$consulta";
	$resultado = mysql_query($consulta) or die("");
	
	$count=1;
	$dato=" <label for=\"fiber_id\">Lugar:</label><select class=\"form-control\" id=\"location_assigned_id\" name=\"location_assigned_id\" onChange=\"buscaLugar(this.value)\"><option value=\"0\" selected=\"selected\">--Selecciona Maquina--</option>";
	while(@mysql_num_rows($resultado)>=$count)
	{		
		
		$res=mysql_fetch_row($resultado);
		if($res[2]!="")
			$lote=$res[2];
		else
			$lote="Libre";
		$dato=$dato."<option value=\"$res[0]\" >$res[1] </option>";
		$count++;		
	}*/
}else
{
	$dato=" <label for=\"location_id\"></label>";
}	
		echo"$dato";
		
		
	
	
?>