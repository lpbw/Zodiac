<?

include "coneccion.php";
$MO= $_POST["MO"];
//$cut_id= $_POST["cut_id"];
$id_corte= $_POST["cut_id"];

$hware_begin= $_POST["hware_begin"];

$length= $_POST["length"];
$lengthDefect= $_POST["length_Defect"];
$short_length_n= $_POST["short_length"];
$short_length_defect_n= $_POST["short_length_defect"];
$short_time_stamp_n= $_POST["short_time_stamp"];
$short_type_n= $_POST["short_type"];
//$utilizado=$length+$lengthDefect;
	//$consulta3  =  "insert into trace (valor) values('$id_corte length= $length lengthDefect= $lengthDefect short_length_n= $short_length_n short_length_defect_n= $short_length_defect_n short_time_stamp_n=$short_time_stamp_n short_type_n=$short_type_n');";
		//$resultado3 = mysql_query($consulta3) or die("Error en operacion p2: $consulta3 " . mysql_error());

	$consulta2  = "SELECT length_consumed, length_defect,length_parcial, length_defect_parcial, roll_id, short_length, short_length_defect, short_time_stamp, short_type,prev_short, prev_short_defect  FROM cuts where id=$id_corte ";
	$resultado2 = mysql_query($consulta2) or die("La consulta fall&oacute;P1: $consulta2" . mysql_error());
	if(@mysql_num_rows($resultado2)>0)
	{
		$res2=mysql_fetch_row($resultado2);
		$parcial=$res2[0];
		$parcial_defect=$res2[1];
		$roll_id=$res2[4];
		$short_length= $res2[5];
		$short_length_defect= $res2[6];
		$short_time_stamp= $res2[7];
		$short_type= $res2[8];
		$prev_short= $res2[9];
		$prev_short_defect= $res2[10];
	}
	
	if($short_time_stamp_n!="0") // si se termino short
	{
		if($short_type_n=="0")//$short_length_n>$short_length// si hubo variacion en la longitud sin defecto
		{
			$short=$short_length_n-$prev_short;
			$type=$short_type_n; //0
			if($short!=0)
			{
			$consulta3  =  "insert into shorts (id_cut, length, type, time) values($id_corte, $short, $type,'$short_time_stamp_n');";
			$resultado3 = mysql_query($consulta3) or die("Error en operacion p2: $consulta3 " . mysql_error());
			$consulta3  =  "update cuts set  prev_short=$short_length_n where id= $id_corte";
			$resultado3 = mysql_query($consulta3) or die("Error en operacion p5: $consulta3 " . mysql_error());
			}
		}
		else if($short_type_n=="1")//$short_length_defect_n>$short_length_defect si hubo variacion en la logitud con defecto
		{
			$short=$short_length_defect_n-$prev_short_defect;
			$type=$short_type_n;//1
			if($short!=0)
			{
			$consulta3  =  "insert into shorts (id_cut, length, type, time) values($id_corte, $short, $type,'$short_time_stamp_n');";
			$resultado3 = mysql_query($consulta3) or die("Error en operacion p2: $consulta3 " . mysql_error());
			$consulta3  =  "update cuts set  prev_short_defect=$short_length_defect_n where id= $id_corte";
			$resultado3 = mysql_query($consulta3) or die("Error en operacion p5: $consulta3 " . mysql_error());
			}
		}
		//$consulta3  =  "update cuts set  prev_short=$short_length_n, prev_short_defect=$short_length_defect_n where id= $id_corte";
		//$resultado3 = mysql_query($consulta3) or die("Error en operacion p5: $consulta3 " . mysql_error());
		
	}
	
	
	$restar=$length-$parcial;
	$restar_defect=$lengthDefect-$parcial_defect;
	$utilizado=$restar+$restar_defect;
	//echo"utilkzado=$utilizado , $restar , $restar_defect";
		
		
	$consulta3  =  "update rolls set remaining_inches=remaining_inches-$utilizado, updated_at=now() where id= $roll_id";
	$resultado3 = mysql_query($consulta3) or die("Error en operacion p3 : $consulta3 " . mysql_error());
		
	$consulta2  = "SELECT remaining_inches  FROM rolls where id= $roll_id";
	$resultado2 = mysql_query($consulta2) or die("La consulta fall&oacute;P4: $consulta2" . mysql_error());
	if(@mysql_num_rows($resultado2)>0)
	{
		$res2=mysql_fetch_row($resultado2);
		$restante=$res2[0]-$utilizado;
		
		
	}
	if($short_time_stamp_n!="0") //guarda ultimo short
	{
	$consulta3  =  "update cuts set  length_consumed=$length, length_defect=$lengthDefect, length_parcial=$parcial, length_defect_parcial=$parcial_defect, balance=$restante, hardware_init='$hware_begin', short_length=$short_length_n, short_length_defect=$short_length_defect_n, short_time_stamp='$short_time_stamp_n', short_type=$short_type_n where id= $id_corte";
	$resultado3 = mysql_query($consulta3) or die("Error en operacion p5: $consulta3 " . mysql_error());	
	}
	else // guarda solo longitudes
	{
	$consulta3  =  "update cuts set  length_consumed=$length, length_defect=$lengthDefect, length_parcial=$parcial, length_defect_parcial=$parcial_defect, balance=$restante, hardware_init='$hware_begin' where id= $id_corte"; //short_length=$short_length_n, short_length_defect=$short_length_defect_n, short_time_stamp='$short_time_stamp_n', short_type=$short_type_n 
	$resultado3 = mysql_query($consulta3) or die("Error en operacion p5: $consulta3 " . mysql_error());	
	}
		echo "1";
	

		
?>
                  