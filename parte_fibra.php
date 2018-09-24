
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




$parte=$_GET['parte'];

if(  $_POST['agregar']=="Agregar")
{
	$fibra=$_POST['fibra'];
	$parte=$_POST['parte'];
	$longitud=$_POST['longitud'];
	$consulta  = "insert into parte_fibra(id_parte,id_fibra,longitud, created_at) values('$parte', '$fibra', $longitud,now())";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1:$consulta " . mysql_error());
	
					
	echo"<script>alert(\"Fibra agregada\");</script>";
	//echo"<script>parent.location=parent.location;</script>";
					
			
		
}
if(  $_POST['borrar']!="")
{
	$borrar=$_POST['borrar'];
	$parte=$_POST['parte'];
	
	$consulta  = "delete from parte_fibra where id=$borrar";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1:$consulta " . mysql_error());
	
					
	echo"<script>alert(\"Fibra Borrada\");</script>";
	
					
			
		
}

?>
</head>
<BODY MARGINHEIGHT="0" MARGINWIDTH="0" TOPMARGIN="0" RIGHTMARGIN="0" BOTTOMMARGIN="0" LEFTMARGIN="0">
<form name="form1" method="post" action="">
  <table width="379" border="0" align="center" cellpadding="2" cellspacing="4" bgcolor="#FFFFFF">
    <tr>
      <td height="26" class="page-header" style="font-size: 20px;">Partes  </td>
    </tr>
    <tr>
      <td class="sm"><table width="100%" border="0" cellpadding="0">
          
            <?	  
	$query = "select parte, producto  from parte where parte='$parte'";
	$result = mysql_query($query) or print("<option value=\"ERROR\">".mysql_error()."</option>");
	while($res_marca = mysql_fetch_assoc($result)){
         
		 $parte=$res_marca['parte'];
		 $desc=$res_marca['producto'];
		 ?>
           <tr>
		    <td width="18%"  scope="row"><div align="center"  class="sm">No. Parte:</div></td>
            <td  scope="row"><div align="left" class="sm">&nbsp;&nbsp;<? echo"$parte";?></div>              <div align="left" class="sm"></div></td>
			</tr>
			 <tr>
            <td width="18%"  scope="row"><div align="center"  class="sm">Descripcion:</div></td>
            <td  scope="row"><div align="left" class="sm">&nbsp;&nbsp;<? echo"$desc";?></div>              <div align="left" class="sm"></div></td>
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
              <input name="parte" type="hidden" id="parte" value="<? echo"$parte";?>">            <input name="borrar" type="hidden" id="borrar"></td>
          </tr>
          <tr>
            <td width="19%"  scope="row"><div align="center"  class="sm">Fibra</div></td>
            <td width="81%"  scope="row"><div align="center" class="sm">
              <div align="left"><span class="col-sm-6 col-md-4 col-lg-4">
                <select class="form-control" id="fibra" name="fibra" >
                  <option value="0" selected="selected">--Selecciona Fibra--</option>
                  <?	  
	$consulta  = "SELECT * from roll_fibers where deleted_at is null order by fiber_type";
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
            <td  class="sm">
            <div align="center">Longitud</div></td>
            <td  class="sm"><div align="left"><span class="col-sm-6 col-md-4 col-lg-2">
              <input name="longitud" type="text" class="form-control" id="longitud"
                                       value="" size="20" maxlength="20"/>
            </span>(in)</div></td>
          </tr>
          <tr >
            <td  class="sm">&nbsp;</td>
            <td  class="sm"><input name="agregar" type="submit" id="agregar" value="Agregar"></td>
          </tr>
          
      </table></td>
    </tr>
    <tr>
      <td class="sm">Fibras<br>
      <table width="100%" border="0" cellpadding="0">
          <tr>
            <td colspan="4"  scope="row"></td>
          </tr>
          <tr>
            <td width="40%"  scope="row"><div align="center"  class="sm">Fibra</div></td>
            <td width="51%"  scope="row"><div align="center" class="sm">Longitud</div></td>
            <td width="9%"  scope="row">&nbsp;</td>
          </tr>
          <?
	    
	//String grupo= request.getParameter("grupo");
	$query = "select id_fibra, longitud, id from parte_fibra where id_parte='$parte'  order by id_fibra";
	$result = mysql_query($query) or print("<option value=\"ERROR\">".mysql_error()."</option>");
	$color="666666";
	while($res_pago = mysql_fetch_assoc($result)){
		$fibra=$res_pago["id_fibra"];
		$longitud=$res_pago["longitud"];
		
		?>
          <tr bgcolor="#<? echo"$color";?>">
            <td  class="sm style3"><div align="center"><? echo"$fibra";?></div></td>
            <td bgcolor="#<? echo"$color";?>"  class="sm style3"><div align="center"><? echo"$longitud";?></div></td>
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
