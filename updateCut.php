<?
//Inical
include "coneccion.php";
//recibe del contador
$location= $_POST["location_id"];
$locationIP= $_POST["location_IP"];
$error= $_POST["error"];
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
 
if($location!="")// revisa no venga vacio el numero de lctra
{
$consulta  = "SELECT logged, estatus   FROM locations where id=$location and deleted_at is null and logged<>0"; //revisa el estatus de la lectra
$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: $consulta" . mysql_error());
if(@mysql_num_rows($resultado)>0)
{
	$res=mysql_fetch_row($resultado);
	$logged=$res[0];
	$pausas=0;
	$l_estatus=$res[1];
	if($l_estatus=="1")
		$l_estatus="bloqueo";
	else
		$l_estatus="bypass";
	// buscar oreden en pausa en la lectra autorizada, si no esta autorizada no puede iniciar
	$consulta22  = "SELECT id, TIME_TO_SEC(timediff(now(), inicio))/60, razon_id, autorized   FROM cut_pause where location_id=$location and fin is null";
	$resultado22 = mysql_query($consulta22) or die("La consulta fall&oacute;P1: $consulta22 " . mysql_error());
	if(@mysql_num_rows($resultado22)>0)
	{
		$res22=mysql_fetch_row($resultado22);
		$pausa_id=$res22[0];
		$tiempo=$res22[1];
		$razon=$res22[2];
		$autorizada=$res22[3];
		if(($razon=="0" || $razon=="6") && $tiempo<=5) // si es menor a 5 min se autoriza sola como set up
		{
			$razon=6;
			$consulta3  =  "update cut_pause set fin=now(), razon_id=$razon, autorized=1 where id=".$pausa_id;
			$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta3 " . mysql_error());
			$autorizada="1";
		}else if($razon!="0" && $autorizada!="0")// si tiene una razon autorizada
		{
			
			$consulta3  =  "update cut_pause set fin=now() where id=".$pausa_id;
			$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta3 " . mysql_error());
		}
    }
	
	
if($autorizada!="0")
{
		$consulta2  = "SELECT mo,id, roll_id, number_position, now(), fiber_id,length_consumed, length_defect,hardware_init, short_length, short_length_defect, short_time_stamp, short_type   FROM cuts where deleted_at is null and location_assigned_id=$location and orden=1 and roll_id<>0"; // manda ordenes que esten en 0,1 o 2
		$resultado2 = mysql_query($consulta2) or die("La consulta fall&oacute;P1: $consulta2" . mysql_error());
		if(@mysql_num_rows($resultado2)>0)
		{
			$res2=mysql_fetch_row($resultado2);
			
			//buscar remaining del rollo
			$consulta3  = "SELECT remaining_inches from rolls where id=".$res2[2]; // manda ordenes que esten en 0,1 o 2
			$resultado3 = mysql_query($consulta3) or die("La consulta fall&oacute;P1: $consulta3" . mysql_error());
			if(@mysql_num_rows($resultado3)>0)
			{
				$res3=mysql_fetch_row($resultado3);
				$remaining=$res3[0];
			}
			
			$consulta3  =  "update cuts set turno=$turno,status=1, updated_at=now(),  software_init=now(), prod_user_id=$logged where id= $res2[1]";
			$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta3 " . mysql_error());
			
			$consulta3  =  "update locations set ip='$locationIP' where id=$location";
			$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta3 " . mysql_error());
			if($res2[11]=="")
				$res2[11]="0000-00-00 00:00:00";
			$length_consumed=$res2[6];
			$length_defect=$res2[7];
			$short_length=$res2[9];
			$short_length_defect=$res2[10];
			$dif=($length_consumed)-($short_length);
			
			$dif_defect=($length_defect)-($short_length_defect);
			/*if($dif!=0)// si las distancias de los cortos normal y de las actualizaciones no nos las mismas se crea un corto de la resta de la longitud menos el corto
			{
				
				$consulta3  =  "insert into shorts (id_cut, length, type, time,razon_id) values($res2[1], $dif, 0,now(),99);"; //inserta corto
				$resultado3 = mysql_query($consulta3) or die("Error en operacion3: $consulta3 " . mysql_error());
				$consulta3  =  "update cuts set  short_length=$length_consumed,prev_short=$length_consumed, short_time_stamp=now(), short_type=0 where id= $res2[1]";// actualiza distancia de corto
				$resultado3 = mysql_query($consulta3) or die("Error en operacion3: $consulta3 " . mysql_error());
				$consulta2  = "SELECT mo,id, roll_id, number_position, now(), fiber_id,length_consumed, length_defect,hardware_init, short_length, short_length_defect, short_time_stamp, short_type   FROM cuts where deleted_at is null and location_assigned_id=$location and orden=1 and roll_id<>0"; // manda ordenes que esten en 0,1 o 2
				$resultado2 = mysql_query($consulta2) or die("La consulta fall&oacute;P1: $consulta2" . mysql_error());
				if(@mysql_num_rows($resultado2)>0)
				{
					$res2=mysql_fetch_row($resultado2);
				}
			}*/
			/*if($dif_defect!=0)// si las distancias de los cortos defecto y de las actualizaciones no nos las mismas se crea un corto de la resta de la longitud menos el corto
			{
				
				$consulta3  =  "insert into shorts (id_cut, length, type, time,razon_id) values($res2[1], $dif_defect, 1,now(),99);"; //inserta corto
				$resultado3 = mysql_query($consulta3) or die("Error en operacion3: $consulta3 " . mysql_error());
				$consulta3  =  "update cuts set  short_length_defect=$length_defect, prev_short_defect=$length_defect, short_time_stamp=now(), short_type=1 where id= $res2[1]";// actualiza distancia de corto
				$resultado3 = mysql_query($consulta3) or die("Error en operacion3: $consulta3 " . mysql_error());
				$consulta2  = "SELECT mo,id, roll_id, number_position, now(), fiber_id,length_consumed, length_defect,hardware_init, short_length, short_length_defect, short_time_stamp, short_type   FROM cuts where deleted_at is null and location_assigned_id=$location and orden=1 and roll_id<>0"; // manda ordenes que esten en 0,1 o 2
				$resultado2 = mysql_query($consulta2) or die("La consulta fall&oacute;P1: $consulta2" . mysql_error());
				if(@mysql_num_rows($resultado2)>0)
				{
					$res2=mysql_fetch_row($resultado2);
				}
			}*/
			
			//$consulta3  =  "update cuts set status=1, updated_at=now() where id= $res2[1]";
			//$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta " . mysql_error());
			$init=$res2[8];
			if($init=="")
				$init="0000-00-00 00:00:00";
			
			echo "{" . $res2[0] . "," . $res2[1] . "," . $res2[2] . ",".$remaining.",". $logged .",".$res2[3].",".$res2[4].",".$res2[5].",".$res2[6].",".$res2[7].",".$init.",".$res2[9].",".$res2[10].",".$res2[11].",".$res2[12].",".$l_estatus."}";
			$mensaje="{" . $res2[0] . "," . $res2[1] . "," . $res2[2] . ",".$remaining.",". $logged .",".$res2[3].",".$res2[4].",".$res2[5].",".$res2[6].",".$res2[7].",".$init.",".$res2[9].",".$res2[10].",".$res2[11].",".$res2[12].",".$l_estatus."}";
			//$consulta3  =  "insert into trace (valor) values('Entra=$location usuario=$logged $mensaje');";
			//$resultado3 = mysql_query($consulta3) or die("Error en operacion p2: $consulta3 " . mysql_error());
		}else
		{
		$mensaje="$location No Orden disponible $consulta2";
		$mensaje2="No hay Orden";
		$consulta3  =  "insert into trace (valor) values('error=$mensaje location=$location');";
		$resultado3 = mysql_query($consulta3) or die("Error en operacion p2: $consulta3 " . mysql_error());
		echo"0,".$mensaje2.",".$l_estatus." ";
		}
	
}
else
{
	// no hay usuario logeado en maquina
	$mensaje="No User ";
	$consulta3  =  "insert into trace (valor) values('error=$mensaje location=$location');";
		$resultado3 = mysql_query($consulta3) or die("Error en operacion p2: $consulta3 " . mysql_error());
	echo"0,".$mensaje.",".$l_estatus." ";
}
}
else
{
	// no escribio location 
	$mensaje="No location ";
	$consulta3  =  "insert into trace (valor) values('error=$mensaje' );";
		$resultado3 = mysql_query($consulta3) or die("Error en operacion p2: $consulta3 " . mysql_error());
	echo"0,".$mensaje.",0";
}
}else
{
	$mensaje="Paro no autorizado ";
	$consulta3  =  "insert into trace (valor) values('error=$mensaje' );";
		$resultado3 = mysql_query($consulta3) or die("Error en operacion p2: $consulta3 " . mysql_error());
	echo"0,".$mensaje.",0";
}
		if($error!="")
		{
			$date=getdate();
			$consulta3  =  "insert into trace (valor) values('$date error=$error' );";
			$resultado3 = mysql_query($consulta3) or die("Error en operacion p2: $consulta3 " . mysql_error());
		}
?>
                  