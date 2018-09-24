<?
session_start();
include "coneccion.php";
include "checar_sesion_prod.php";
$idU=$_SESSION['idU'];
$lang=0;//idioma espaniol
$url=$_GET['url'];

$consulta  =  "update users set lang='$lang' where id= '$idU'";
$resultado = mysql_query($consulta) or die("Error en operacion: $consulta " . mysql_error());

echo"<script> window.location='$url'</script>";
?>