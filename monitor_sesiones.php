<?
session_start();
include "coneccion.php";

$consulta  = "SELECT TIMESTAMPDIFF(SECOND,last_login,now()), last_login, NOW(), logged FROM `locations` where logged<>0";
$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
$count=1;
while(@mysql_num_rows($resultado)>=$count)
{
	$res=mysql_fetch_row($resultado);
	
	if($res[0]>200){
		$consulta3  =  "update locations set logged=0, last_login= null where logged= $res[3]";
		$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta " . mysql_error());
	}
	$count=$count+1;
}

?>