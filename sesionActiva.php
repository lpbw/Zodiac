<?
session_start();
include "coneccion.php";
$idU=$_SESSION['idU'];
$locationU=$_SESSION['location'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML><head>

</head>
<script>
function auto_reload()
{
	window.location = 'sesionActiva.php';
}
</script>
<BODY onLoad="timer = setTimeout('auto_reload()',100000);">
<?

if($_SESSION['idU']!='' && $_SESSION['idU']!="0")
{
	$consulta3  =  "update locations set last_login=now() where id= $locationU";
	$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta " . mysql_error());
	echo"+Activo+";
}else
{
	echo"-Inactivo-";
}
?>

</BODY>
</HTML>
