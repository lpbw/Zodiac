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
 echo"turno=$turno <br>";
 $turno_fin=$_GET['turno'];
 
$yesterday = date("Y-m-d", time() - 86400);
echo"ayer=$yesterday";


       

        
		
        
    ?>
   