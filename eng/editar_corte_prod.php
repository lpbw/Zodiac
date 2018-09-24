
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Zodiac</title><meta name="DESCRIPTION" content="">
<meta name="KEYWORDS" content="">
<link rel="stylesheet" href="public/css/style.css"/>
<link rel="stylesheet" href="public/css/font-awesome/css/font-awesome.min.css"/>


<style type="text/css">
<!--
.style3 {color: #FFFFFF}
body {
	background-color: #363638;
}
-->
</style>
<?
session_start();
include "coneccion.php";

$usu=$_SESSION['idU'];
$tipoU=$_SESSION['tipoU'];




$id=$_GET['id'];

if(  $_POST['guardar']=="Guardar Error")
{
	$error=$_POST['error'];
	
	$consulta  = "update cuts set status=4, error='$error' where id=$id";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1:$consulta " . mysql_error());
	
					
	echo"<script>alert(\"Error guardado\");</script>";
	echo"<script>parent.location=\"cortes_prod.php\";</script>";
					
			
		
}
if(  $_POST['reprogramar']=="Reprogramar Orden")
{
	$consulta  = "SELECT * from cuts where id=$id";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	if(@mysql_num_rows($resultado)>=1)
	{
		$res=mysql_fetch_row($resultado);
		
		$consulta6="select max(orden) as orden from cuts where location_assigned_id=$res[9] and status<3 and deleted_at is null ";
		$resultado6 = mysql_query($consulta6) or die("Error en operacion1: $consulta6 " . mysql_error());
		$res6=mysql_fetch_assoc($resultado6);
		$orden=$res6['orden'];
		
		if($orden>0)
			$orden=$orden+1;
		else
			$orden=1;
		$consulta2  =  "insert into cuts(mo, cn, roll_id, user_id, location_assigned_id, number_position, orden, length_measured, created_at, id_cut_type, id_programa, parte) values('$res[1]', '$res[2]', '$res[3]', $usu, '$res[9]', '$res[10]', ".$orden.",  '$res[14]', now(), '$res[18]', '$res[19]', '$res[22]')";
		$resultado2 = mysql_query($consulta2) or die("Error en operacion1: $consulta2 " . mysql_error());
	
	}
					
	echo"<script>alert(\"Orden Reprogramada\");</script>";
	echo"<script>parent.location=\"cortes.php\";</script>";
					
			
		
}
$consulta  = "select error from cuts where id=$id";
	//echo"$consulta";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	if(@mysql_num_rows($resultado)>=1)
	{
		$res=mysql_fetch_array($resultado,MYSQL_BOTH);
		$error=$res[0];
	}
?>
</head>
<BODY MARGINHEIGHT="0" MARGINWIDTH="0" TOPMARGIN="0" RIGHTMARGIN="0" BOTTOMMARGIN="0" LEFTMARGIN="0">
<form name="form22" method="post" action="">
  <table width="379" height="350" border="0" align="center" cellpadding="2" cellspacing="4" bgcolor="#FFFFFF">
    <tr>
      <td height="26" class="page-header" style="font-size: 20px;">Error en Corte   </td>
    </tr>
    <tr>
      <td valign="top" ><table width="100%" border="0" cellpadding="0">
          <tr>
            <td colspan="4"  scope="row"><input name="id_corte" type="hidden" id="id_corte" value="<? echo"$id";?>"></td>
          </tr>
          
          <tr >
            <td width="10%"  >
            <div align="center">Descripción</div></td>
            <td width="87%"  ><div align="left">
              <textarea name="error" cols="30" rows="3" class="form-control" id="error"><?echo"$error";?></textarea>
            </div></td>
            <td width="3%"  >&nbsp;</td>
          </tr>
		  <? if($tipoU=="3"){?>
          <tr >
            <td  >&nbsp;</td>
            <td  ><input name="guardar" class="btn red-submit button-form" type="submit" id="guardar" value="Guardar Error"></td>
            <td  >&nbsp;</td>
          </tr>
         
          <? }
		  if($tipoU=="1" || $tipoU=="2"){?>
		   <tr >
            <td  >&nbsp;</td>
            <td  ><input name="reprogramar" class="btn red-submit button-form" type="submit" id="reprogramar" value="Reprogramar Orden"></td>
            <td  >&nbsp;</td>
          </tr>
		  <? }?>
      </table></td>
    </tr>
  </table>
 
</form></BODY></HTML>
