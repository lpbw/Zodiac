<?

include "coneccion.php";

$cut_id= $_POST["cut_id"];
$status= $_POST["status"];


		//determina el turno
		$dia_semana=date(N)+1;
		if($dia_semana==8)
			$dia_semana=1;
			// buscar condicion si es despues de las 12 y antes de las 12:30 tomar el dia anterior
		$consultaT  = "SELECT numero FROM turnos where now()>inicio and now()<fin and dias like '%".$dia_semana."%'";// 
		$resultadoT = mysql_query($consultaT) or die("La consulta fall&oacute;P1: $consultaT " . mysql_error());
		if(@mysql_num_rows($resultadoT)>0)
		{
			$resT=mysql_fetch_row($resultadoT);
			$turno=$resT[0];
		 }
		$consultaT  = "SELECT location_assigned_id, user_id FROM cuts where id=$cut_id";// 
		$resultadoT = mysql_query($consultaT) or die("La consulta fall&oacute;P1: $consultaT " . mysql_error());
		if(@mysql_num_rows($resultadoT)>0)
		{
			$resT=mysql_fetch_row($resultadoT);
			$location_id=$resT[0];
			$user_id=$resT[1];
		 }


	$consulta2  = "SELECT id  FROM cut_pause where id_cut=$cut_id and fin is null"; 
	$resultado2 = mysql_query($consulta2) or die("La consulta fall&oacute;P1: " . mysql_error());
	if(@mysql_num_rows($resultado2)>0)
	{
		$res2=mysql_fetch_row($resultado2);
		if($status=="pause_start")// si envian inicio de pausa y ya hay una abierta se cierra y se abre una nueva
		{
			$consulta3  =  "update cut_pause set fin=now() where id= $res2[0]";
			$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta " . mysql_error());
			$consulta3  =  "insert into cut_pause(id_cut, inicio, turno, location_id, user_id, razon_id) values( $cut_id, now(), $turno, $location_id, $user_id, 0)";
			$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta " . mysql_error());
			
		
		}else if($status=="pause_refresh") // si envan refresh no se hace nada
		{
		
		}else if($status=="pause_end") // si se manda fin de pausa se guarda la hora de fin y se actualiza estatus de corte a activo
		{
			$consulta3  =  "update cuts set status=1 where id= $cut_id";
			$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta " . mysql_error());
			$consulta3  =  "update cut_pause set fin=now() where id= $res2[0]";
			$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta " . mysql_error());
		}
	}else
	{
		if($status=="pause_start")// si llega inicio de pausa y no hay pausas pendientes se crea pausa y cambia estatus de corte a pausa
		{
			$consulta3  =  "update cuts set status=2 where id= $cut_id";
			$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta " . mysql_error());
			
			$consulta3  =  "insert into cut_pause(id_cut, inicio, turno, location_id, user_id, razon_id) values( $cut_id, now(), $turno, $location_id, $user_id, 0)";
			$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta " . mysql_error());
		}
	}	
		
		echo "{1}";
	

		
?>
                  