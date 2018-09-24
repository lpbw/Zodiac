<?
include "coneccion.php";
$id=$_GET["id"];

	$dato="";
	$consulta  = "select id,name from locations order by name";	
	$resultado = mysql_query($consulta) or die("");
	$count=1;
	$dato=" <label for=\"fiber_id\">Lugar:</label>";
	$dato .= "<select class=\"form-control\" id=\"location_assigned_id\" name=\"location_assigned_id\" onChange=\"buscaLugar()\">";
	$dato .= "<option value=\"0\" selected=\"selected\">--Selecciona Maquina--</option>";
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