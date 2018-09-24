
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




$prog=$_GET['prog'];

if(  $_POST['agregar']=="Agregar")
{
	$parte=$_POST['parte'];
	$prog=$_POST['prog'];

	$consulta  = "insert into programa_parte(programa,parte, created_at) values('$prog', '$parte', now())";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1:$consulta " . mysql_error());
	
					
	echo"<script>alert(\"Parte agregada\");</script>";
	//echo"<script>parent.location=parent.location;</script>";
					
			
		
}
if(  $_POST['borrar']!="")
{
	$borrar=$_POST['borrar'];
	$parte=$_POST['parte'];
	
	$consulta  = "delete from programa_parte where id=$borrar";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1:$consulta " . mysql_error());
	
					
	echo"<script>alert(\"Parte Borrada\");</script>";
	
					
			
		
}

?>
</head>
<BODY MARGINHEIGHT="0" MARGINWIDTH="0" TOPMARGIN="0" RIGHTMARGIN="0" BOTTOMMARGIN="0" LEFTMARGIN="0">
<form name="form1" method="post" action="">
  <table width="379" border="0" align="center" cellpadding="2" cellspacing="4" bgcolor="#FFFFFF">
    <tr>
      <td height="26" class="page-header" style="font-size: 20px;">Programa  </td>
    </tr>
    <tr>
      <td class="sm"><table width="100%" border="0" cellpadding="0">
          
            <?	  
	$query = "select nombre  from programas where id='$prog'";
	$result = mysql_query($query) or print("<option value=\"ERROR\">".mysql_error()."</option>");
	while($res_marca = mysql_fetch_assoc($result)){
         
		 $nombre=$res_marca['nombre'];
		 
		 ?>
           <tr>
		    <td width="18%"  scope="row"><div align="center"  class="sm">Programa:</div></td>
            <td  scope="row"><div align="left" class="sm">&nbsp;&nbsp;<? echo"$nombre";?></div>              <div align="left" class="sm"></div></td>
			</tr>
            <?     
     }	
	
?>
        
         
      </table></td>
    </tr>
    <tr>
      <td class="sm"><table width="100%" border="0" cellpadding="0">
          <tr>
            <td colspan="3"  scope="row"> Agregar Fibra
              <input name="prog" type="hidden" id="prog" value="<? echo"$prog";?>">            <input name="borrar" type="hidden" id="borrar"></td>
          </tr>
          <tr>
            <td width="19%"  scope="row"><div align="center"  class="sm">Fibra</div></td>
            <td width="81%"  scope="row"><div align="center" class="sm">
              <div align="left"><span class="col-sm-6 col-md-4 col-lg-4">
                <select class="form-control" id="parte" name="parte" >
                  <option value="0" selected="selected">--Selecciona Parte--</option>
                  <?	  
	$consulta  = "SELECT * from parte where deleted_at is null order by parte";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	$count=1;
	while(@mysql_num_rows($resultado)>=$count)
	{
		$res=mysql_fetch_row($resultado);
		
		echo"<option value=\"$res[1]\" >$res[1]</option>";
		$count=$count+1;
	}	
		
		?>
                </select>
                </span></div>
            </div></td>
          </tr>
          <tr >
            <td  class="sm">&nbsp;</td>
            <td  class="sm"><input name="agregar" type="submit" id="agregar" value="Agregar"></td>
          </tr>
          
      </table></td>
    </tr>
    <tr>
      <td class="sm">Partes<br>
      <table width="100%" border="0" cellpadding="0">
          <tr>
            <td colspan="4"  scope="row"></td>
          </tr>
          <tr>
            <td width="40%"  scope="row"><div align="center"  class="sm">Partes</div></td>
           
            <td width="9%"  scope="row">&nbsp;</td>
          </tr>
          <?
	    
	//String grupo= request.getParameter("grupo");
	$query = "select programa, parte, id from programa_parte where programa='$prog'  order by parte";
	$result = mysql_query($query) or print("<option value=\"ERROR\">".mysql_error()."</option>");
	$color="666666";
	while($res_pago = mysql_fetch_assoc($result)){
		$parte=$res_pago["parte"];
		
		
		?>
          <tr bgcolor="#<? echo"$color";?>">
            <td  class="sm style3"><div align="center"><? echo"$parte";?></div></td>
            
            <td bgcolor="#<? echo"$color";?>"  class="sm style3"><div align="center"><a href="javascript:borrar('<? echo $res_pago["id"]; ?>')"><i class="fa fa-times"></i></a></div></td>
          </tr>
          <?
		
		
	   if($color=="666666")
			 	$color="363638";
			else
				$color="666666";
	  
			
	}

?>
      </table></td></tr>
  </table>
  <script>
  function borrar(id)
  {
  	if(confirm("Esta seguro de borrar esta fibra?"))
  	{
  	document.form1.borrar.value=id;
	document.form1.submit();
	}
  }
  </script>
</form></BODY></HTML>
