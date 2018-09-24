<?
include "coneccion.php";
$id=$_GET["id"];
$fiber=$_GET["fiber"];
$fall=$_GET["fall"];
$parche=$_GET["parche"];


	
	$dato="";
	if($fall=="1")
	{
		$dato=" <label for=\"location_id\">Posición:</label> <select class=\"form-control\" id=\"number_position\" name=\"number_position\" onChange=\"mostrar(this.value);\"> <option value=\"1|10000|10000|1\" selected=\"selected\">--Fallout roll--</option></select>";
	}
	else
	{
		if($parche=="3")
		$consulta  = "select location_capacities.id, location_capacities.number, rolls.remaining_inches, rolls.fiber_id, rolls.id from location_capacities inner join rolls on location_capacities.id=rolls.location_slot where rolls.location_id='$id'  and rolls.deleted_at is null order by number";
		else
		$consulta  = "select location_capacities.id, location_capacities.number, rolls.remaining_inches, rolls.fiber_id, rolls.id from location_capacities inner join rolls on location_capacities.id=rolls.location_slot where rolls.location_id='$id' and rolls.fiber_id='$fiber' and rolls.deleted_at is null order by number";
		//echo"$consulta";
		$resultado = mysql_query($consulta) or die("");
		
		$count=1;
		$dato=" <label for=\"location_id\">Posicion:</label> <select class=\"form-control\" id=\"number_position\" name=\"number_position\" onChange=\"mostrar(this.value);\"> <option value=\"0\" selected=\"selected\">--Selecciona Posicion--</option>";
		while(@mysql_num_rows($resultado)>=$count)
		{		
			
			$res=mysql_fetch_row($resultado);
				$consulta5="select sum(length_measured) as sum from cuts where roll_id={$res[4]} and status=0 and deleted_at is null ";
				//echo"$consulta5";
				$resultado5 = mysql_query($consulta5) or die("Error en operacion1: $consulta5 " . mysql_error());
				$res5=mysql_fetch_assoc($resultado5);
				if($res5['sum']>0)
					$suma_cortes=$res5['sum'];//cortes programados con es rollo
				else
					$suma_cortes=0;
			$resto=$res[2]-$suma_cortes;
			
			$dato=$dato."<option value=\"$res[0]|$res[2]|$resto|$res[4]\" >$res[1] - ($res[3]- $resto in)</option>";
			$count++;		
		}
	}
	
		echo"$dato";
		
		
	
	
?>