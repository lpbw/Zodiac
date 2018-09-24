<?

    // Archivos necesarios.

    include "coneccion.php";
   
    //obtiene la hora actual
    $hora=date('H:i:s');
   $dia_semana=date(N)+1;
if($dia_semana==8)
	$dia_semana=1;
	// buscar condicion si es despues de las 12 y antes de las 12:30 tomar el dia anterior
$consultaT  = "SELECT numero FROM turnos where CURTIME()>inicio and CURTIME()<fin and dias like '%".$dia_semana."%'";// 

$resultadoT = mysql_query($consultaT) or die("La consulta fall&oacute;P1: $consultaT " . mysql_error());
if(@mysql_num_rows($resultadoT)>0)
{
	$resT=mysql_fetch_row($resultadoT);
	$turno=$resT[0];
}
 
//buscar pausas a medias, crerrarlas y crear una nueva con el nuevo turno
$consulta4  = "SELECT *  FROM cut_pause where  fin is null order by location_id";
$resultado4 = mysql_query($consulta4) or die("La consulta fall&oacute;P1: " . mysql_error());
while($res4=mysql_fetch_assoc($resultado4))
{
	$consulta  =  "update cut_pause set razon='cierre de turno', autorized=".$res4['autorized'].", razon_id=".$res4['razon_id'].", fin=now() where id=".$res4['id']; //,  razon='$razon', razon_id=$razon_id
	$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
	$consulta  =  "insert into cut_pause(id_cut, inicio, razon_id, turno, location_id, user_id) values(".$res4['id_cut'].", now(), ".$res4['razon_id'].", $turno,".$res4['location_id'].",".$res4['user_id'].")";
	$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
	
}

//turno 1
if($turno=="1" && ($dia_semana=="1" || $dia_semana=="2" || $dia_semana=="3" || $dia_semana=="4" || $dia_semana=="5" ))
{ 
	$consulta4  = "SELECT sum(TIMESTAMPDIFF(MINUTE, inicio, fin)) as d1  FROM cut_pause where  razon_id<>1 and fin is not null and DATE(inicio)=DATE(now()) and turno=$turno group by location_id";
		//echo $consulta4;
	$resultado4 = mysql_query($consulta4) or die("La consulta fall&oacute;P1: " . mysql_error());
	if($res4=mysql_fetch_assoc($resultado4))
	{
		$tiempo_paro=$res4['d1'];
		
	}else
	{
		$tiempo_paro="0"; // tiempo de paro que no es comida ya concluido
	}
}
    /*if($_SESSION['filtro']!=""){
    $filtro=$_SESSION['filtro'];
    }
    else{
    $filtro=0;
    }*/
//echo "tipo: " .$tipoU;


        $pausa_id=$_POST['pausa_id'];
		$razon_id=$_POST['razon_id'];
		$razon=$_POST['razon'];
        if($pausa_id=="")
		{
            $pausa_id=$_GET['pausa_id'];
            $razon_id=$_GET['razon_id'];
			$razon=$_GET['razon'];
		}
        if($pausa_id!="")
        {
            $consulta22  = "SELECT cut_pause.id, inicio, reason, FORMAT(TIME_TO_SEC(timediff(CURTIME(), inicio))/60,0), name , razon_id, id_cut FROM cut_pause inner join down_time_reason on cut_pause.razon_id=down_time_reason.id inner join locations on cut_pause.location_id=locations.id  where cut_pause.id=".$pausa_id;
			$resultado22 = mysql_query($consulta22) or die("La consulta fall&oacute;P1: $consulta22 " . mysql_error());
			if(@mysql_num_rows($resultado22)>0)
			{
				$res22=mysql_fetch_row($resultado22);
				$inicio=$res22[1];
				$razon_name=$res22[2];
				$tiempo=$res22[3];
				$lectra=$res22[4];
				$razon_id=$res22[5];
				$id_cut=$res22[6];
			}else
			{
			$id_cut="0";
			}
			
        }

         $terminado= $_POST["terminado"];
        if($terminado!="")  
        {
			$tipo=$_POST['tipo'];
			$diag=$_POST['diag'];
			$user=$_POST['user'];
			$pass=mysql_real_escape_string($_POST["pass"]);
			$contra = sha1($pass);
			$consulta  = "SELECT * from users where username='$user' and password='$contra' and level_id=5 and deleted_at is null";
            $resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
            if(@mysql_num_rows($resultado)>0)
            {
                $res=mysql_fetch_row($resultado);
              	 $consulta  =  "update cut_pause set razon='".$diag."', autorized=".$res[0].", razon_id=$razon_id, fin=now() where id=".$pausa_id; //,  razon='$razon', razon_id=$razon_id
                $resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
				$consulta  =  "insert into cut_pause(id_cut, inicio, razon_id, turno, location_id, user_id) values($id_cut, now(), 0, $turno,$locationU,$idU)";
                $resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
				echo"<script> window.location=\"cortes_prod.php\";</script>";
            }
            else
            {
                
                echo"<script>alert(\"Usuario Invalido\"); </script>";
            }
		}
		$pasar= $_POST["pasar"];
        if($pasar!="")  
        {
			$tipo=$_POST['tipo'];
			$diag=$_POST['diag'];
			$user=$_POST['user'];
			$pass=mysql_real_escape_string($_POST["pass"]);
			$contra = sha1($pass);
			$consulta  = "SELECT * from users where username='$user' and password='$contra' and level_id=5 and deleted_at is null";
            $resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
            if(@mysql_num_rows($resultado)>0)
            {
                $res=mysql_fetch_row($resultado);
              	 $consulta  =  "update cut_pause set razon='".$diag."', autorized=".$res[0].", razon_id=$razon_id, fin=now() where id=".$pausa_id; 
                $resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
				$consulta  =  "insert into cut_pause(id_cut, inicio, razon_id, turno, location_id, user_id) values($id_cut, now(), 3, $turno,$locationU,$idU)";
                $resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
				echo"<script> window.location=\"cortes_prod.php\";</script>";
            }
            else
            {
                
                echo"<script>alert(\"Usuario Invalido\"); </script>";
            }
		}
		$rechaza= $_POST["rechaza"];
        if($rechaza!="")  
        {
			echo"<script>alert(\"Usuario Invalido\"); </script>";
		}

        $guardar= $_POST["guardar"];
        if($guardar!="")  
        {
            $user=$_POST['user'];
			$pass=mysql_real_escape_string($_POST["pass"]);
			$contra = sha1($pass);
			$consulta  = "SELECT * from users where username='$user' and password='$contra' and level_id=5 and deleted_at is null";
            $resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
            if(@mysql_num_rows($resultado)>0)
            {
                $res=mysql_fetch_row($resultado);
              	 $consulta  =  "update cut_pause set autorized=".$res[0]." where id=".$pausa_id; //,  razon='$razon', razon_id=$razon_id
                $resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
				echo"<script> window.location=\"cortes_prod.php\";</script>";
            }
            else
            {
                
                echo"<script>alert(\"Usuario Invalido\"); </script>";
            }
        }	
		$guardar2= $_POST["guardar2"];
        if($guardar2!="")  
        {
            
				echo"<script>alert(\"Tiempo NO Autorizado\"); window.location=\"cortes_prod.php\";</script>";
            
        }
        
    ?>
   