<?
session_start();
$idU=$_SESSION['idU'];
include "coneccion.php";
$consulta3  =  "update locations set logged=0, last_login= null where logged= $idU";
$resultado3 = mysql_query($consulta3) or die("Sesion terminada por inactividad<br><br><br><br><a href=\"index.php\"><center>Iniciar sesion</center></a>");

$_SESSION="";
session_destroy();
header("Location: index.php");

?>