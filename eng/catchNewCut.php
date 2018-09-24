<?
// programa para terminar un corte
include "coneccion.php";
$MO= $_POST["MO"];
//$cut_id= $_POST["cut_id"];
$cut_id= $_POST["id_corte"];
$location_id= $_POST["location_id"];
$roll_id= $_POST["roll_id"];
$user_id= $_POST["user_id"];
$hware_begin= $_POST["hware_begin"];
$hware_end= $_POST["hware_end"];
$length= $_POST["length"];
$lengthDefect= $_POST["length_Defect"];
$status= $_POST["status"];
$utilizado=$length+$lengthDefect;



	/*$consulta2  = "SELECT id   FROM cuts where deleted_at is null and location_assigned_id=$location_id and orden=1";
	$resultado2 = mysql_query($consulta2) or die("La consulta fall&oacute;P1: " . mysql_error());
	if(@mysql_num_rows($resultado2)>0)
	{
		$res2=mysql_fetch_row($resultado2);
		$cut_id=$res2[0];
	}*/
	$consulta2  = "SELECT length_consumed, length_defect,length_parcial, length_defect_parcial, roll_id, location_assigned_id  FROM cuts where id=$cut_id ";
	$resultado2 = mysql_query($consulta2) or die("La consulta fall&oacute;P1: " . mysql_error());
	if(@mysql_num_rows($resultado2)>0)
	{
		$res2=mysql_fetch_row($resultado2);
		$parcial=$res2[0];
		$parcial_defect=$res2[1];
		$roll_id=$res2[4];
		$location_id=$res2[5];
	}
	
	$restar=$length-$parcial;
	$restar_defect=$lengthDefect-$parcial_defect;
	$utilizado=$restar+$restar_defect;
	
	$consulta2  = "SELECT count(id)  FROM cut_pause where id_cut=$cut_id and razon_id=0";
	$resultado2 = mysql_query($consulta2) or die("La consulta fall&oacute;P1: " . mysql_error());
	if(@mysql_num_rows($resultado2)>0)
	{
		$res2=mysql_fetch_row($resultado2);
		$pausas=$res2[0];
		if($pausas>0)
			$pausas=1;
	}
	$consulta2  = "SELECT remaining_inches  FROM rolls where id= $roll_id";
	$resultado2 = mysql_query($consulta2) or die("La consulta fall&oacute;P1: " . mysql_error());
	if(@mysql_num_rows($resultado2)>0)
	{
		$res2=mysql_fetch_row($resultado2);
		$restante=$res2[0]-$utilizado;
		/////////
		///////revisar tolerancia y cambiarlo a terminado
		
	}
	$consulta2  = "SELECT id  FROM cut_pause where id_cut=$cut_id and fin is null";
	$resultado2 = mysql_query($consulta2) or die("La consulta fall&oacute;P1: " . mysql_error());
	$count=1;
	while(@mysql_num_rows($resultado2)>=$count)
	{
		$res2=mysql_fetch_row($resultado2);
		$consulta2  =  "update cut_pause set fin=now() where id=$res2[0]";
		$resultado2 = mysql_query($consulta2) or die("Error en operacion1: $consulta2 " . mysql_error());
		$count++;
	}	
//		if($status==0)
			$p_estatus=3;
//		else
//			$p_estatus=0;
		
		$consulta3  =  "update cuts set status=$p_estatus, hardware_init='$hware_begin', hardware_end='$hware_end',  software_end=now(), length_consumed=$length, length_defect=$lengthDefect, orden=0, pausa=$pausas, balance=$restante, length_parcial=$parcial, length_defect_parcial=$parcial_defect where id= $cut_id";
		$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta3 " . mysql_error());
		
		$consulta3  =  "update rolls set remaining_inches=remaining_inches-$utilizado, updated_at=now() where id= $roll_id";
		$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta " . mysql_error());
		
		if($status==1)
		{
			$consulta2  = "SELECT mo, cn, user_id, location_assigned_id, orden, status, created_at, id_cut_type, id_programa, parte, fiber_id  FROM cuts where id=$cut_id ";
			$resultado2 = mysql_query($consulta2) or die("La consulta fall&oacute;P1: " . mysql_error());
			if(@mysql_num_rows($resultado2)>0)
			{
				$res2=mysql_fetch_row($resultado2);
				
				$consulta3  =  "insert into cuts(mo, cn, user_id, location_assigned_id, orden, status, created_at, id_cut_type, id_programa, parte, fiber_id,length_measured) values ('$res2[0]','$res2[1]','$res2[2]','$res2[3]','1','0',now(),'$res2[7]','$res2[8]','$res2[9]','$res2[10]', 0)";
				$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta " . mysql_error());
			}
	}
		
		
		
		$consulta="SELECT cuts.id  FROM cuts inner join cut_type on cut_type.id=cuts.id_cut_type  where cuts.deleted_at is null and cuts.location_assigned_id=$location_id and status=0 order by cuts.fiber_id";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	$contador=1;
	while($res=mysql_fetch_assoc($resultado))
	{	
		$consulta3  =  "update cuts set orden=$contador, updated_at=now() where id=".$res['id'];
		$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta3 " . mysql_error());
		$contador++;
	}
		echo "1";
	

		
?>
                  