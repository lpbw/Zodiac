<?

include "coneccion.php";
$MO= $_POST["MO"];
//$cut_id= $_POST["cut_id"];
$id_corte= $_POST["id_corte"];

$hware_begin= $_POST["hware_begin"];

$length= $_POST["length"];
$lengthDefect= $_POST["length_Defect"];
//$utilizado=$length+$lengthDefect;


	$consulta2  = "SELECT length_consumed, length_defect,length_parcial, length_defect_parcial, roll_id  FROM cuts where id=$id_corte ";
	$resultado2 = mysql_query($consulta2) or die("La consulta fall&oacute;P1: " . mysql_error());
	if(@mysql_num_rows($resultado2)>0)
	{
		$res2=mysql_fetch_row($resultado2);
		$parcial=$res2[0];
		$parcial_defect=$res2[1];
		$roll_id=$res2[4];
	}
	
	
	
	
	$restar=$length-$parcial;
	$restar_defect=$lengthDefect-$parcial_defect;
	$utilizado=$restar+$restar_defect;
	//echo"utilkzado=$utilizado , $restar , $restar_defect";
		
		
	$consulta3  =  "update rolls set remaining_inches=remaining_inches-$utilizado, updated_at=now() where id= $roll_id";
	$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta " . mysql_error());
		
	$consulta2  = "SELECT remaining_inches  FROM rolls where id= $roll_id";
	$resultado2 = mysql_query($consulta2) or die("La consulta fall&oacute;P1: " . mysql_error());
	if(@mysql_num_rows($resultado2)>0)
	{
		$res2=mysql_fetch_row($resultado2);
		$restante=$res2[0]-$utilizado;
		
		
	}
	$consulta3  =  "update cuts set  length_consumed=$length, length_defect=$lengthDefect, length_parcial=$parcial, length_defect_parcial=$parcial_defect, balance=$restante, hardware_init='$hware_begin' where id= $id_corte";
	$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta3 " . mysql_error());	
		echo "1";
	

		
?>
                  