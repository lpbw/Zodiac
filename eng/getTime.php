<?

include "coneccion.php";

	$consulta2  = "SELECT now()   FROM cuts where deleted_at is null  limit 1,1";
	$resultado2 = mysql_query($consulta2) or die("La consulta fall&oacute;P1: " . mysql_error());
	if(@mysql_num_rows($resultado2)>0)
	{
		$res2=mysql_fetch_row($resultado2);
		$fecha=$res2[0];
	}
		echo "$fecha";
	

		
?>
                  