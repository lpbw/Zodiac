<?

    // Archivos necesarios.
    include "coneccion.php";
    //obtiene la hora actual
    $hora=date('H:i:s');
    $dia_semana=date(N); // 1= monday
    /*if($dia_semana==8)
        $dia_semana=1;*/
     
    /**Crear o modificar log */
    /*function lLog($var)
    {
        $nombre_archivo = "logs.txt";
        if(file_exists($nombre_archivo))
        {
            $mensaje = "El Archivo $nombre_archivo se ha modificado";
        }
        else
        {
            $mensaje = "El Archivo $nombre_archivo se ha creado";
        }
        if($archivo = fopen($nombre_archivo, "a"))
        {
            if(fwrite($archivo, date("d m Y H:m:s"). " ". $mensaje. "\n" .$var))
            {

                echo "Se ha ejecutado correctamente";
            }
            else
            {
                echo "Ha habido un problema al crear el archivo";
            }
            fclose($archivo);
        }
    }*/
    
 
	// buscar condicion si es despues de las 12 y antes de las 12:30 tomar el dia anterior
    $consultaTurno  = "SELECT numero, id FROM turnos WHERE CURTIME()>inicio AND CURTIME()<fin AND dias LIKE '%".$dia_semana."%'";
    $resultadoTurno = mysql_query($consultaTurno) or die("La consultaTurno fallo: $consultaTurno " . mysql_error());
    //echo $consultaTurno;
    if(@mysql_num_rows($resultadoTurno)>0)
    {
        $resTurno=mysql_fetch_row($resultadoTurno);
        $turno=$resTurno[0];
        $id_turno=$resTurno[1];
    }
    
    /**Turno recibido del url */
    $turno_fin=$_GET['turno'];
    $fecha=date('Y/m/d');

    //buscar pausas a medias, cerrarlas y crear una nueva con el nuevo turno
    $consultaPausasCerrar  = "SELECT * FROM cut_pause where fin is null order by location_id";
    $resultadoPausaCerrar = mysql_query($consultaPausasCerrar) or die("La consultaPausasCerrar fallo: $consultaPausasCerrar" . mysql_error());
    while($resPausaCerrar=mysql_fetch_assoc($resultadoPausaCerrar))
    {
        $Updatecutpause  =  "update cut_pause set razon='cierre de turno', autorized=".$resPausaCerrar['autorized'].", razon_id=".$resPausaCerrar['razon_id'].", fin=(now()-INTERVAL 1 MINUTE) where id=".$resPausaCerrar['id']; //, autorized=1 lo puse a como venga
        $resultado = mysql_query($Updatecutpause) or die("Error en Updatecutpause: $Updatecutpause " . mysql_error());// SE LE QUITO UN MINUTO
        $insertcutpause  =  "insert into cut_pause(id_cut, inicio, razon_id, turno, location_id, user_id) values(".$resPausaCerrar['id_cut'].", (now()+INTERVAL 1 MINUTE), ".$resPausaCerrar['razon_id'].", $turno,".$resPausaCerrar['location_id'].",".$resPausaCerrar['user_id'].")";
        $resultado = mysql_query($insertcutpause) or die("Error en insertcutpause: $insertcutpause " . mysql_error());//SE LE AGREGO UN MINUTO
    }

	//turno 1
	if($turno_fin=="1" )
	{ 
		$suma_muerto=0;
		$loc="99";
		
		// inserta horas activas
		$consulta4  = "SELECT FORMAT(sum(TIME_TO_SEC(timediff(fin, inicio))/60),0) as d2, grupo, location_id FROM `cut_pause` inner join down_time_reason on cut_pause.razon_id=down_time_reason.id where turno=1 and year(inicio)=year('".$fecha."') and month(inicio)=month('".$fecha."') and day(inicio)=day('".$fecha."')  AND fin is NOT null group by location_id order by location_id";
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
		
		// inserta horas activas
		$consulta4  = "SELECT FORMAT(sum(TIME_TO_SEC(timediff(fin, inicio))/60),0) as d2, grupo, location_id FROM `cut_pause` inner join down_time_reason on cut_pause.razon_id=down_time_reason.id where turno=3 and year(inicio)=year('".$fecha."') and month(inicio)=month('".$fecha."') and day(inicio)=day('".$fecha."') group by location_id order by location_id";
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
		
		// inserta horas activas
		$consulta4  = "SELECT FORMAT(sum(TIME_TO_SEC(timediff(fin, inicio))/60),0) as d2, grupo, location_id FROM `cut_pause` inner join down_time_reason on cut_pause.razon_id=down_time_reason.id where turno=2 and ((inicio>='".$yesterday." 15:30:00' && inicio<'".$fecha." 00:30:00')) group by location_id order by location_id";
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