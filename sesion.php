<?
session_start();
include "coneccion.php";
//$idU=$_SESSION['idU'];
$_COOKIE['Test'];
if($_COOKIE['Test']!="valor"){
$value="valor";
setcookie("Test", $value, time()+15);  /* expira en una hora */
echo "cookie creada:".$_COOKIE['Test'];
}else{
echo "cookie expiro";
}
//$locationU=$_SESSION['location'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML><head>
<script>
function auto_reload()
{
	location.reload();
}
</script>
</head>

<BODY onLoad="timer = setTimeout('auto_reload()',10000);">

</BODY>

</HTML>
