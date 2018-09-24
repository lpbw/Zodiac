<?
include "coneccion.php";
$id=$_GET["id"];


	
	$dato="";
	$consulta  = "select locations.id, locations.name from locations inner join rolls on locations.id=rolls.location_id and rolls.fiber_id='$id' where  rolls.deleted_at is null and locations.deleted_at is null group by  locations.id, locations.name";	
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
	}
	
		echo"$dato";
		
		
	
	
?>