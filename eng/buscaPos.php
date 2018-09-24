<?
include "coneccion.php";
$id=$_GET["id"];
$buscar=$_GET["buscar"];


	
	$dato="";
	$consulta  = "select location_capacities.id, location_capacities.number, rolls.fiber_id from location_capacities left outer join rolls on location_capacities.id=rolls.location_slot  where location_capacities.id_location=$id and location_capacities.deleted_at is null and rolls.deleted_at is null order by number";	
	//echo"$consulta";
	$resultado = mysql_query($consulta) or die("");
	
	$count=1;
	if($buscar!="")
	$hide="<input name=\"location_slot_selected\" type=\"hidden\" value=\"$buscar\">";
	else
	$hide="<input name=\"location_slot_selected\" type=\"hidden\" value=\"\">";
	$dato=" <label for=\"slot\">Tubo:</label>$hide<select class=\"form-control\" id=\"location_slot\" name=\"location_slot\" onChange=\"mostrar(this.value);\"><option value=\"0|0\" >--Selecciona Posicion--</option>";
	while(@mysql_num_rows($resultado)>=$count)
	{		
		
		$res=mysql_fetch_row($resultado);
		if($res[2]!="")
			$lote=$res[2];
		else
			$lote="Libre";
		
		if($buscar==$res[0])
		$dato=$dato."<option value=\"$res[0]|$res[2]\" selected>$res[1] -$lote</option>";
		else
		$dato=$dato."<option value=\"$res[0]|$res[2]\" >$res[1] -$lote</option>";
		$count++;		
	}
	
		echo"$dato";
		
		
	
	
?>