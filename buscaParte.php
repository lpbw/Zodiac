<?
include "coneccion.php";
$id=$_GET["id"];
//echo $id;
if($id==999999){
	  $dato="";
	//$consulta  = "select distinct id_fibra, longitud , id_parte from parte_fibra where deleted_at is null order by id_fibra";
	$consulta  = "select id, lote, fiber_id, remaining_inches from rolls where state_id in (3,2) and deleted_at is null order by fiber_id";	
	//echo"$consulta";
	$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
	
	$count=1;
	
	//$dato="<select multiple='multiple' class='form-control' name='fibra_id[]' id='fibra_id' size='10'><optgroup label='Fibra'>";
	$dato="<select multiple='multiple' class='form-control' name='roll_id' id='fibroll_idra_id' size='5'><optgroup label='Rollo'>";
	while(@mysql_num_rows($resultado)>=$count)
	{		
	
		$res=mysql_fetch_row($resultado);
		$dato=$dato."<option value='$res[0]|$res[2]'>$res[2] / $res[1] - ($res[3] in)</option>";
		$count++;		
		
	}
	$dato=$dato."</optgroup></select><br>Long.<input type=\"text\" class=\"form-control\" id=\"longitud\" name=\"longitud\" value=\"\"/><br>Long. Defecto<input type=\"text\" class=\"form-control\" id=\"longitud_def\" name=\"longitud_def\" value=\"\"/>";
		echo"$dato"; 
}
else{
	$dato="";
	$consulta  = "select id_fibra, longitud from parte_fibra   where id_parte='$id' and deleted_at is null order by id_fibra";	
	//echo"$consulta";
	$resultado = mysql_query($consulta) or die("");
	
	$count=1;
	$dato=" <label for=\"guaranteed_length\">Fibra:</label><ul id='fibra_id'>";
	while(@mysql_num_rows($resultado)>=$count)
	{		
		
		$res=mysql_fetch_row($resultado);
		$dato=$dato."<li><input type=\"checkbox\" name=\"fibra_id[]\" value=\"$res[0]\" />$res[0] - ($res[1] in)</li>";
		$count++;		
	}
	$dato="$dato </ul>";
		echo"$dato";
		
	
	
}
?>asdasd