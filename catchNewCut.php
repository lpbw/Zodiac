<?
// programa para terminar un corte
	include "coneccion.php";

	/**Crear o modificar log */
    function lLog($var)
    {
        $nombre_archivo = "logs_catchNewCut.txt";
        if(file_exists($nombre_archivo))
        {
			$mensaje = "\r\n \r\n El Archivo $nombre_archivo se ha modificado";
        }
        else
        {
			$mensaje = "\r\n \r\n El Archivo $nombre_archivo se ha creado";
        }
        if($archivo = fopen($nombre_archivo, "a"))
        {
            if(fwrite($archivo, date("d m Y H:m:s"). " ". $mensaje. "\n " .$var))
            {

                //echo "Se ha ejecutado correctamente";
            }
            else
            {
                //echo "Ha habido un problema al crear el archivo";
            }
            fclose($archivo);
        }
	}
	
	/*$MO= $_POST["MO"];
	//$cut_id= $_POST["cut_id"];
	$cut_id= $_POST["id_corte"];
	$location_id= $_POST["location_id"];
	$roll_id= $_POST["roll_id"];
	$user_id= $_POST["user_id"];
	$hware_begin= $_POST["hware_begin"];//fecha y hora inicio proceso
	$hware_end= $_POST["hware_end"];//fecha y hora fin proceso
	$length= $_POST["length"];//cuanto marco el contador de fibra buena
	$lengthDefect= $_POST["length_Defect"];//cuanto marco el contador de fibra mala
	$status= $_POST["status"];//0 o 1    1=corte parcial, 0 =corte normal.
	$defectSwitch=$_POST["defectSwitch"];//0 o 1
	$utilizado=$length+$lengthDefect;*/

	//test
	$MO= 3487142;
	//$cut_id= $_POST["cut_id"];
	$cut_id= 40280;
	$location_id= 8;
	$roll_id= 8702;
	$user_id= 88;
	$hware_begin= "";//fecha y hora inicio proceso
	$hware_end= "";//fecha y hora fin proceso
	$length= 100;//cuanto marco el contador de fibra buena
	$lengthDefect= 0;//cuanto marco el contador de fibra mala
	$status= 0;//0 o 1    1=corte parcial, 0 =corte normal.
	$defectSwitch=0;//0 o 1
	$utilizado=$length+$lengthDefect;

	/*$consulta2  = "SELECT id   FROM cuts where deleted_at is null and location_assigned_id=$location_id and orden=1";
	$resultado2 = mysql_query($consulta2) or die("La consulta fall&oacute;P1: " . mysql_error());
	if(@mysql_num_rows($resultado2)>0)
	{
		$res2=mysql_fetch_row($resultado2);
		$cut_id=$res2[0];
	}*/

	// busca pausas no autorizadas.
	$consulta22  = "SELECT count(id) FROM cut_pause where location_id1=$location_id  and autorized=0";// id_cut=$cut_id
	//$resultado22 = mysql_query($consulta22) or die(" $consulta22 " . mysql_error());
	$resultado22 = mysql_query($consulta22);
	if (mysql_error()) {
		lLog("Error 1: $consulta22 " . mysql_error() );
	}
	else {
		if(@mysql_num_rows($resultado22)>0)
		{
			$res22=mysql_fetch_row($resultado22);
			$pausas=$res22[0];
     	}
	}
	$pausas="0";
	if($pausas=="0")
	{
		$consulta3  =  "insert into trace (valor) values('catchnew $cut_id length= $length lengthDefect= $lengthDefect defectSwitch=$defectSwitch');";
			//$resultado3 = mysql_query($consulta3) or die("Error en operacion p2: $consulta3 " . mysql_error());
		$consulta2  = "SELECT length_consumed1, length_defect,length_parcial, length_defect_parcial, roll_id, location_assigned_id,short_length, short_length_defect, short_time_stamp, short_type, prev_short, prev_short_defect  FROM cuts where id=$cut_id ";
		//$resultado2 = mysql_query($consulta2) or die("$consulta2" . mysql_error());
		$resultado2 = mysql_query($consulta2);
		if (mysql_error()) {
			lLog("Error 2: $consulta2 " . mysql_error() );
		}
		else {
			if(@mysql_num_rows($resultado2)>0)
			{
				$res2=mysql_fetch_row($resultado2);
				$parcial=$res2[0];
				$parcial_defect=$res2[1];
				$roll_id=$res2[4];
				$location_id=$res2[5];
				$short_length=$res2[6];
				$short_length_defect=$res2[7];
				$shot_time=$res2[8];
				$short_type=$res2[9];
				$prev_short=$res2[10];
				$prev_short_defect=$res2[11];
			}	
		}
	
		/////////////captura de ultimo corte
		/*$type="";	
		if($length>$short_length)// si hubo variacion en la longitud sin defecto
		{
			$short=$length-$short_length;
			$type=$defectSwitch; //0
		}
		else if($length_defect>$short_length_defect)// si hubo variacion en la logitud con defecto
		{
			$short=$short_length_defect-$short_length_defect;
			$type=$defectSwitch;//1
		}
		else if($short_length==0 || $short_length_defect==0)// si hubo variacion en la logitud con defecto
		{
			$short=$length;
			$type=$defectSwitch;//1
		}*/
		if($defectSwitch=="0"){
			$short=$length-$prev_short;
		}else if($defectSwitch=="1"){
			$short=$lengthDefect-$prev_short_defect;
		}
		if($short!="0"){
			$consulta3  =  "insert into shorts (id_cut, length, type, time) values($cut_id, $short, $defectSwitch,'$hware_end');";
			//$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta " . mysql_error());
			$resultado3 = mysql_query($consulta3);
			if (mysql_error()) {
				lLog("Error 3: $consulta3 " . mysql_error() );
			}
		}
		///////////////////////////////////		
	
		$restar=$length-$parcial;
		$restar_defect=$lengthDefect-$parcial_defect;
		$utilizado=$restar+$restar_defect;
		
		$consulta2  = "SELECT count(id)  FROM cut_pause where id_cut=$cut_id and razon_id=0";
		//$resultado2 = mysql_query($consulta2) or die("$consulta2 " . mysql_error());
		$resultado2 = mysql_query($consulta2);
		if (mysql_error()) {
			lLog("Error 4: $consulta2 " . mysql_error() );
		}else {
			if(@mysql_num_rows($resultado2)>0)
			{
				$res2=mysql_fetch_row($resultado2);
				$pausas=$res2[0];
				if($pausas>0){
					$pausas=1;
				}
			}
		}
	
		$consulta2  = "SELECT remaining_inches  FROM rolls where id= $roll_id";
		//$resultado2 = mysql_query($consulta2) or die("$consulta2 " . mysql_error());
		$resultado2 = mysql_query($consulta2);
		if (mysql_error()) {
			lLog("Error 5: $consulta2 " . mysql_error() );
		}else {
			if(@mysql_num_rows($resultado2)>0)
			{
				$res2=mysql_fetch_row($resultado2);
				$restante=$res2[0]-$utilizado;
				
				if($roll_id=="1")
					$restante="100000";
				/////////
				///////revisar tolerancia y cambiarlo a terminado
				
			}
		}
	
		$consulta2  = "SELECT id  FROM cut_pause where id_cut=$cut_id and fin is null";// si hay alguna pausa terminarla
		//$resultado2 = mysql_query($consulta2) or die("$consulta2 " . mysql_error());
		$resultado2 = mysql_query($consulta2);
		if (mysql_error()) {
			lLog("Error 6: $consulta2 " . mysql_error() );
		}else {
			$count=1;
			while(@mysql_num_rows($resultado2)>=$count)
			{
				$res2=mysql_fetch_row($resultado2);
				$consulta2  =  "update cut_pause set fin=now() where id=$res2[0]";
				//$resultado2 = mysql_query($consulta2) or die("Error en operacion1: $consulta2 " . mysql_error());
				$resultado2 = mysql_query($consulta2);
				if (mysql_error()) {
					lLog("Error 7: $consulta2 " . mysql_error() );
				}
				$count++;
			}
		}
		
		//		if($status==0)
			$p_estatus=3; // estatus terminado
		//		else
		//			$p_estatus=0;
		
		$consulta3  =  "update cuts set status=$p_estatus, hardware_init='$hware_begin', hardware_end='$hware_end',  software_end=now(), length_consumed=$length, length_defect=$lengthDefect, orden=0, pausa=$pausas, balance=$restante, length_parcial=$parcial, length_defect_parcial=$parcial_defect where id= $cut_id";
		//$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta3 " . mysql_error()); //actializa a terinado rl corte y datos de cierre
		$resultado3 = mysql_query($consulta3);
		if (mysql_error()) {
			lLog("Error 8: $consulta3 " . mysql_error() );
		}

		if($roll_id=="1") // si es un rollo de fallout se resetea su remanente
		{
			$restante="100000"; 
			$consulta3  =  "update rolls set remaining_inches=$restante, updated_at=now() where id= $roll_id";
			//$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta " . mysql_error());
			$resultado3 = mysql_query($consulta3);
			if (mysql_error()) {
				lLog("Error 9: $consulta3 " . mysql_error() );
			}
		}else  // se resta al rollo lo utilizado
		{
			$consulta3  =  "update rolls set remaining_inches=remaining_inches-$utilizado, updated_at=now() where id= $roll_id";
			//$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta " . mysql_error());
			$resultado3 = mysql_query($consulta3);
			if (mysql_error()) {
				lLog("Error 10: $consulta3 " . mysql_error() );
			}
		}
		if($status==1) // es corte parcial se genera un nuevo corte con mismo MO
		{
			$consulta2  = "SELECT mo, cn, user_id, location_assigned_id, orden, status, created_at, id_cut_type, id_programa, parte, fiber_id  FROM cuts where id=$cut_id ";
			//$resultado2 = mysql_query($consulta2) or die("$consulta2 " . mysql_error());
			$resultado2 = mysql_query($consulta2);
			if (mysql_error()) {
				lLog("Error 11: $consulta2 " . mysql_error() );
			}else{
				if(@mysql_num_rows($resultado2)>0)
				{
					$res2=mysql_fetch_row($resultado2);
					
					$consulta3  =  "insert into cuts(mo, cn, user_id, location_assigned_id, orden, status, created_at, id_cut_type, id_programa, parte, fiber_id,length_measured) values ('$res2[0]','$res2[1]','$res2[2]','$res2[3]','1','0',now(),'$res2[7]','$res2[8]','$res2[9]','$res2[10]', 0)";
					//$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta " . mysql_error());
					$resultado3 = mysql_query($consulta3);
					if (mysql_error()) {
						lLog("Error 12: $consulta3 " . mysql_error() );
					}
				}
			}
			
		}
		
		//determina el turno
		$dia_semana=date(N)+1;
		if($dia_semana==8)
			$dia_semana=1;
			// buscar condicion si es despues de las 12 y antes de las 12:30 tomar el dia anterior
		$consultaT  = "SELECT numero FROM turnos where now()>inicio and now()<fin and dias like '%".$dia_semana."%'";// 
		//$resultadoT = mysql_query($consultaT) or die(" $consultaT " . mysql_error());
		$resultadoT = mysql_query($consultaT);
		if (mysql_error()) {
			lLog("Error 13: $consultaT " . mysql_error() );
		}else {
			if(@mysql_num_rows($resultadoT)>0)
			{
				$resT=mysql_fetch_row($resultadoT);
				$turno=$resT[0];
			}
		}
			
		// se inicia pausa de inactividad por temino de corte
		$consulta3  =  "insert into cut_pause(id_cut, inicio, turno, location_id, user_id, razon_id) values( 0, now(), $turno, $location_id, $user_id, 0)";
		//$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta " . mysql_error());
		$resultado3 = mysql_query($consulta3);
		if (mysql_error()) {
			lLog("Error 14: $consulta3 " . mysql_error() );
		}
		// se buscan cortes restantes y se reordena
		$consulta="SELECT cuts.id  FROM cuts inner join cut_type on cut_type.id=cuts.id_cut_type  where cuts.deleted_at is null and cuts.location_assigned_id=$location_id and status=0 order by cuts.fiber_id";
		//$resultado = mysql_query($consulta) or die("$consulta " . mysql_error());
		$resultado = mysql_query($consulta);
		if (mysql_error()) {
			lLog("Error 15: $consulta " . mysql_error() );
		}
		$contador=1;
		while($res=mysql_fetch_assoc($resultado))
		{	
			$consulta3  =  "update cuts set orden=$contador, updated_at=now() where id=".$res['id'];
			//$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta3 " . mysql_error());
			$resultado3 = mysql_query($consulta3);
			if (mysql_error()) {
				lLog("Error 16: $consulta3 " . mysql_error() );
			}
			$contador++;
		}
		echo "1";
	}
	else
	{
		echo "Hay $pausas pausas";
	}	

		
?>
                  