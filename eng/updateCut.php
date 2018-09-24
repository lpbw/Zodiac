<?

include "coneccion.php";
$location= $_POST["location_id"];
$locationIP= $_POST["location_IP"];

$consulta  = "SELECT logged   FROM locations where id=$location and deleted_at is null and logged<>0";
$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: $consulta" . mysql_error());
if(@mysql_num_rows($resultado)>0)
{
	$res=mysql_fetch_row($resultado);
	$logged=$res[0];
	$pausas=0;
	// buscar oredenes en pausa en la lectra
	$consulta22  = "SELECT count(pausa)   FROM cuts where location_assigned_id=$location and deleted_at is null and pausa=2";
	$resultado22 = mysql_query($consulta22) or die("La consulta fall&oacute;P1: $consulta22 " . mysql_error());
	if(@mysql_num_rows($resultado22)>0)
	{
	$res22=mysql_fetch_row($resultado22);
	$pausas=$res22[0];
     }
	
	//if($pausas==0)
	//{
		$consulta2  = "SELECT mo,id, roll_id, number_position, now(), fiber_id,length_consumed, length_defect,hardware_init   FROM cuts where deleted_at is null and location_assigned_id=$location and orden=1 and roll_id<>0"; // manda ordenes que esten en 0,1 o 2
		$resultado2 = mysql_query($consulta2) or die("La consulta fall&oacute;P1: $consulta2" . mysql_error());
		if(@mysql_num_rows($resultado2)>0)
		{
			$res2=mysql_fetch_row($resultado2);
			
			$consulta3  =  "update cuts set status=1, updated_at=now(),  software_init=now(), prod_user_id=$logged where id= $res2[1]";
			$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta3 " . mysql_error());
			
			$consulta3  =  "update locations set ip='$locationIP' where id=$location";
			$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta3 " . mysql_error());
			
			//$consulta3  =  "update cuts set status=1, updated_at=now() where id= $res2[1]";
			//$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta " . mysql_error());
			$init=$res2[8];
			if($init=="")
				$init="0000-00-00 00:00:00";
			
			echo "{" . $res2[0] . "," . $res2[1] . "," . $res2[2] . ",". $logged .",".$res2[3].",".$res2[4].",".$res2[5].",".$res2[6].",".$res2[7].",".$init."}";
		}else
		{
		$mensaje="No Orden disponible";
		echo"{0,".$mensaje."}";
		}
	//}else
	//{
	//	echo"{'Pausa pendiente',0,0,0,0}";
	//}
// {MO,id,roll_id,user_id,posicion de carrusel} 
        
	//busca la siguiente orden en la cola de la maquina y regresa los datos(numero_orden, tipo_cirte,), si no hay orden o no hay suficiente material mandar error
        //valida que hay alguien logeado en la maquina por eso recibe user_id
}
else
{
	// no hay usuario logeado en maquina
	$mensaje="No User";
	echo"{0,".$mensaje."}";
}

		
?>
                  