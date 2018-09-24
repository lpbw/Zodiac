<?

include "coneccion.php";

$cut_id= $_POST["cut_id"];
$status= $_POST["status"];






	$consulta2  = "SELECT id  FROM cut_pause where id_cut=$cut_id and fin is null";
	$resultado2 = mysql_query($consulta2) or die("La consulta fall&oacute;P1: " . mysql_error());
	if(@mysql_num_rows($resultado2)>0)
	{
		$res2=mysql_fetch_row($resultado2);
		if($status=="pause_start")
		{
			$consulta3  =  "update cut_pause set fin=now() where id= $res2[0]";
			$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta " . mysql_error());
			$consulta3  =  "insert into cut_pause(id_cut, inicio) values( $cut_id, now())";
			$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta " . mysql_error());
		
		}else if($status=="pause_refresh")
		{
		
		}else if($status=="pause_end")
		{
			$consulta3  =  "update cuts set status=1 where id= $cut_id";
			$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta " . mysql_error());
			$consulta3  =  "update cut_pause set fin=now() where id= $res2[0]";
			$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta " . mysql_error());
		}
	}else
	{
		if($status=="pause_start")// si llega inicio de pausa y no hay pausas pendientes
		{
			$consulta3  =  "update cuts set status=2 where id= $cut_id";
			$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta " . mysql_error());
			
			$consulta3  =  "insert into cut_pause(id_cut, inicio) values( $cut_id, now())";
			$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta " . mysql_error());
		}
	}	
		
		echo "{1}";
	

		
?>
                  