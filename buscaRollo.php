<?
include "coneccion.php";
$id=$_GET["id"];


	
	$dato="";
	$dato=" <label for=\"guaranteed_length\">Rollo:</label> <select class=\"form-control\" id=\"roll_id\" name=\"roll_id\" onChange=\"mostrar2(this.value)\"><option value=\"0\" selected=\"selected\">--Selecciona Rollo--</option>";
	$consulta  = "SELECT rolls.id, roll_fibers.fiber_type, lote, rolls.remaining_inches FROM `rolls` inner join roll_fibers on roll_fibers.fiber_type=rolls.fiber_id where rolls.deleted_at is null and roll_fibers.deleted_at is null and  location_id=0 and location_slot=0 and rolls.fiber_id='$id'";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	$count=1;
	while(@mysql_num_rows($resultado)>=$count)
	{
		$res=mysql_fetch_row($resultado);
		$consulta5="select sum(length_measured) as sum from cuts where roll_id={$res[0]} and status=0 and deleted_at is null ";
		$resultado5 = mysql_query($consulta5) or die("Error en operacion1: $consulta5 " . mysql_error());
		$res5=mysql_fetch_assoc($resultado5);
		if($res5['sum']>0)
			$suma_cortes=$res5['sum'];//cortes programados con es rollo
		else
			$suma_cortes=0;
		$resto=$res[3]-$suma_cortes;
		$dato=$dato."<option value=\"$res[0]|$res[3]|$resto|$res[0]\" >$res[1] - $res[2] - In. $resto</option>";
		$count=$count+1;
	}	
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
	
		echo"$dato";
		
		
	
	
?>