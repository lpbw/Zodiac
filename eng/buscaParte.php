



<?
include "coneccion.php";
$id=$_GET["id"];
//echo $id;
if($id==999999){
	   $dato="";
	$consulta  = "select distinct id_fibra, longitud from parte_fibra where deleted_at is null order by id_fibra";	
	//echo"$consulta";
	$resultado = mysql_query($consulta) or die("");
	
	$count=1;
	
	$dato="<select multiple='multiple' class='form-control' name='fibra_id[]' id='fibra_id' size='10'><optgroup label='Fibra'>";
	while(@mysql_num_rows($resultado)>=$count)
	{		
	
		$res=mysql_fetch_row($resultado);
		$dato=$dato."<option value='$res[0]'>$res[0] - ($res[1] in)</option>";
		$count++;		
		
	}
	$dato=$dato."</optgroup></select>";
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
?>