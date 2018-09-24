<?
session_start();


if ($_SESSION['idU']=="" || !$_SESSION['idU'] ){

	include "index.php";

exit();

}else
{
	if($_SESSION['tipoU']=="3" )
	{
	echo"<script>alert(\"Aplicacion no permitida\");</script>";
	$_SESSION="";
	session_destroy();
	header("Location: index.php");
	include "index.php";
	exit();
	}
}

?>