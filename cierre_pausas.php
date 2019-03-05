<?

    // Archivos necesarios.

    include "coneccion.php";
   
    //obtiene la hora actual
    $hora=date('H:i:s');
   $dia_semana=date(N); // 1= monday
if($dia_semana==8)
	$dia_semana=1;
	// buscar condicion si es despues de las 12 y antes de las 12:30 tomar el dia anterior
$consultaT  = "SELECT numero, id FROM turnos where CURTIME()>inicio and CURTIME()<fin and dias like '%".$dia_semana."%'";// 

$resultadoT = mysql_query($consultaT) or die("La consulta fall&oacute;P1: $consultaT " . mysql_error());
if(@mysql_num_rows($resultadoT)>0)
{
	$resT=mysql_fetch_row($resultadoT);
	$turno=$resT[0];
	$id_turno=$resT[1];
}
 
 $turno_fin=$_GET['turno'];
// $fecha=$_GET['fecha'];
 $fecha=date('Y/m/d');
//buscar pausas a medias, cerrarlas y crear una nueva con el nuevo turno
$consulta4  = "SELECT *  FROM cut_pause where  fin is null order by location_id";
$resultado4 = mysql_query($consulta4) or die("La consulta fall&oacute;P1: " . mysql_error());
while($res4=mysql_fetch_assoc($resultado4))
{
	$consulta  =  "update cut_pause set razon='cierre de turno', autorized=".$res4['autorized'].", razon_id=".$res4['razon_id'].", fin=(now()-INTERVAL 1 MINUTE) where id=".$res4['id']; //, autorized=1 lo puse a como venga
	$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());// SE LE QUITO UN MINUTO
	$consulta  =  "insert into cut_pause(id_cut, inicio, razon_id, turno, location_id, user_id) values(".$res4['id_cut'].", (now()+INTERVAL 1 MINUTE), ".$res4['razon_id'].", $turno,".$res4['location_id'].",".$res4['user_id'].")";
	$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());//SE LE AGREGO UN MINUTO
}

//turno 1
if($turno_fin=="1" )
{ 
	$suma_muerto=0;
	$loc="99";
	$consulta4  = "SELECT  reason,razon_id,  FORMAT(sum(TIME_TO_SEC(timediff(fin, inicio))/60),0) as d2, grupo, location_id FROM `cut_pause` inner join down_time_reason on cut_pause.razon_id=down_time_reason.id where turno=1 and year(inicio)=year('".$fecha."') and month(inicio)=month('".$fecha."') and day(inicio)=day('".$fecha."') group by location_id, razon_id order by location_id";
		//echo $consulta4;
	$resultado4 = mysql_query($consulta4) or die("La consulta fall&oacute;P1: " . mysql_error());
	while($res4=mysql_fetch_assoc($resultado4))
	{
		
		$consulta  =  "insert into cierre_turnos(turno,fecha, tipo,tiempo, location_id, grupo) values(".$turno_fin.", '".$fecha."',  ".$res4['razon_id'].",".$res4['d2'].",".$res4['location_id'].",".$res4['grupo'].")";
		$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
		
	}
	// inserta horas activas
	$consulta4  = "SELECT    FORMAT(sum(TIME_TO_SEC(timediff(fin, inicio))/60),0) as d2, grupo, location_id FROM `cut_pause` inner join down_time_reason on cut_pause.razon_id=down_time_reason.id where turno=1 and year(inicio)=year('".$fecha."') and month(inicio)=month('".$fecha."') and day(inicio)=day('".$fecha."') group by location_id order by location_id";
		echo $consulta4;
	$resultado4 = mysql_query($consulta4) or die("La consulta fall&oacute;P1: " . mysql_error());
	while($res4=mysql_fetch_assoc($resultado4))
	{		
		$activo=540-$res4['d2'];
	$consulta  =  "insert into cierre_turnos(turno,fecha, tipo,tiempo, location_id, grupo) values(".$turno_fin.", '".$fecha."',  99,".$activo.",".$res4['location_id'].",0)";
	$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
	}
	
}
if($turno_fin=="3" )
{ 
	$suma_muerto=0;
	$consulta4  = "SELECT  reason,razon_id,  FORMAT(sum(TIME_TO_SEC(timediff(fin, inicio))/60),0) as d2, grupo, location_id FROM `cut_pause` inner join down_time_reason on cut_pause.razon_id=down_time_reason.id where turno=3 and year(inicio)=year('".$fecha."') and month(inicio)=month('".$fecha."') and day(inicio)=day('".$fecha."') group by location_id, razon_id order by location_id";
		//echo $consulta4;
	$resultado4 = mysql_query($consulta4) or die("La consulta fall&oacute;P1: " . mysql_error());
	while($res4=mysql_fetch_assoc($resultado4))
	{
		$consulta  =  "insert into cierre_turnos(turno,fecha, tipo,tiempo, location_id, grupo) values(".$turno_fin.", '".$fecha."',  ".$res4['razon_id'].",".$res4['d2'].",".$res4['location_id'].",".$res4['grupo'].")";
		$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
		$suma_muerto=$suma_muerto+$res4['d2'];
	}
	// inserta horas activas
	$consulta4  = "SELECT    FORMAT(sum(TIME_TO_SEC(timediff(fin, inicio))/60),0) as d2, grupo, location_id FROM `cut_pause` inner join down_time_reason on cut_pause.razon_id=down_time_reason.id where turno=3 and year(inicio)=year('".$fecha."') and month(inicio)=month('".$fecha."') and day(inicio)=day('".$fecha."') group by location_id order by location_id";
		echo $consulta4;
	$resultado4 = mysql_query($consulta4) or die("La consulta fall&oacute;P1: " . mysql_error());
	while($res4=mysql_fetch_assoc($resultado4))
	{		
		$activo=360-$res4['d2'];
	$consulta  =  "insert into cierre_turnos(turno,fecha, tipo,tiempo, location_id, grupo) values(".$turno_fin.", '".$fecha."',  99,".$activo.",".$res4['location_id'].",0)";
	$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
	}
}
if($turno_fin=="2" )
{ 

/// calcular para el lapso de 12 a 12:30 de la ma�ana 
//calcular para el lapso de 3:30 a 12
$suma_muerto=0;
$yesterday = date("Y-m-d", time() - 86400);
	$consulta4  = "SELECT  reason,razon_id,  FORMAT(sum(TIME_TO_SEC(timediff(fin, inicio))/60),0) as d2, grupo, location_id FROM `cut_pause` inner join down_time_reason on cut_pause.razon_id=down_time_reason.id where turno=2 and ((inicio>='".$yesterday." 15:30:00' && inicio<'".$fecha." 00:30:00')) group by location_id, razon_id order by location_id";
		echo $consulta4;
	$resultado4 = mysql_query($consulta4) or die("La consulta fall&oacute;P1: " . mysql_error());
	while($res4=mysql_fetch_assoc($resultado4))
	{
		$consulta  =  "insert into cierre_turnos(turno,fecha, tipo,tiempo, location_id, grupo) values(".$turno_fin.", '$yesterday',  ".$res4['razon_id'].",".$res4['d2'].",".$res4['location_id'].",".$res4['grupo'].")";
		$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
		$suma_muerto=$suma_muerto+$res4['d2'];
	}
	
	// inserta horas activas
	$consulta4  = "SELECT    FORMAT(sum(TIME_TO_SEC(timediff(fin, inicio))/60),0) as d2, grupo, location_id FROM `cut_pause` inner join down_time_reason on cut_pause.razon_id=down_time_reason.id where turno=2 and ((inicio>='".$yesterday." 15:30:00' && inicio<'".$fecha." 00:30:00')) group by location_id order by location_id";
		echo $consulta4;
	$resultado4 = mysql_query($consulta4) or die("La consulta fall&oacute;P1: " . mysql_error());
	while($res4=mysql_fetch_assoc($resultado4))
	{		
		$activo=540-$res4['d2'];
	$consulta  =  "insert into cierre_turnos(turno,fecha, tipo,tiempo, location_id, grupo) values(".$turno_fin.", '".$fecha."',  99,".$activo.",".$res4['location_id'].",0)";
	$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
	}
}
if($turno_fin=="4" )
{ 


$suma_muerto=0;
$yesterday = date("Y-m-d", time() - 172800);
	$consulta4  = "SELECT  reason,razon_id,  FORMAT(sum(TIME_TO_SEC(timediff(fin, inicio))/60),0) as d2, grupo, location_id FROM `cut_pause` inner join down_time_reason on cut_pause.razon_id=down_time_reason.id where turno=4 and and (inicio>='".$yesterday." 11:30:00' && inicio<='".$fecha." 06:00:00') group by location_id, razon_id order by location_id";
		echo $consulta4;
	$resultado4 = mysql_query($consulta4) or die("La consulta fall&oacute;P1: " . mysql_error());
	while($res4=mysql_fetch_assoc($resultado4))
	{
		$consulta  =  "insert into cierre_turnos(turno,fecha, tipo,tiempo, location_id, grupo) values(".$turno_fin.", '$yesterday',  ".$res4['razon_id'].",".$res4['d2'].",".$res4['location_id'].",".$res4['grupo'].")";
		$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
		$suma_muerto=$suma_muerto+$res4['d2'];
	}
	
	// inserta horas activas
	$consulta4  = "SELECT    FORMAT(sum(TIME_TO_SEC(timediff(fin, inicio))/60),0) as d2, grupo, location_id FROM `cut_pause` inner join down_time_reason on cut_pause.razon_id=down_time_reason.id where turno=4 and (inicio>='".$yesterday." 11:30:00' && inicio<='".$fecha." 06:00:00')  group by location_id order by location_id";
		echo $consulta4;
	$resultado4 = mysql_query($consulta4) or die("La consulta fall&oacute;P1: " . mysql_error());
	while($res4=mysql_fetch_assoc($resultado4))
	{		
		$activo=2550-$res4['d2'];
	$consulta  =  "insert into cierre_turnos(turno,fecha, tipo,tiempo, location_id, grupo) values(".$turno_fin.", '".$fecha."',  99,".$activo.",".$res4['location_id'].",0)";
	$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
	}
}
   


       

        
		
        
    ?>
   