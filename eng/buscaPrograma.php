<?
include "coneccion.php";
$id=$_GET["id"];
if($id==999999){
 

$dato=" <label for=\"guaranteed_length\">Numero de parte :</label><select class=\"form-control\" id=\"parte\" name=\"parte\"  onChange=\"buscaParte(parte.value)\"><option value=\"0\" disabled=\"true\">--Selecciona Numero de Parte--</option>";
	
	
	//echo"$dato";
	
   
   
}
else{	
	$dato="";
	$consulta  = "SELECT pp.parte,";
	$consulta .= "p.producto ";
	$consulta .= "FROM programa_parte pp ";
	$consulta .= "INNER JOIN parte p ON p.parte=pp.parte ";
	$consulta .= "WHERE programa='$id' ";
	$consulta .= "AND pp.deleted_at IS NULL ";
	$consulta .= "GROUP BY pp.parte, p.producto ";
	$consulta .="ORDER BY pp.parte";
	$resultado = mysql_query($consulta) or die("");
	$count=1;
	while(@mysql_num_rows($resultado)>=$count)
	{		
		
		$res=mysql_fetch_row($resultado);
		
		$dato=$dato."<option id=\"$res[0]\" value=\"$res[0] $res[1]\" ></option>";
		$count++;		
	}
	
		echo"$dato";
		
		
	
	}
?>