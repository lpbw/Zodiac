
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






$id=$_GET['id'];



?>
<script type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
</head>
<BODY MARGINHEIGHT="0" MARGINWIDTH="0" TOPMARGIN="0" RIGHTMARGIN="0" BOTTOMMARGIN="0" LEFTMARGIN="0">
<form name="form1" method="post" action="">
  <table width="379" border="0" align="center" cellpadding="2" cellspacing="4" bgcolor="#FFFFFF">
    <tr>
      <td height="26" class="page-header" style="font-size: 20px;">Pause</td>
    </tr>
    <tr>
      <td class="sm"><br>
        <table width="341" class="table table-striped table-condensed grid">
          <thead>
            <tr>
              <th colspan="4">Pause</th>
            </tr>
            <tr>
              <th width="78">Init</th>
              <th width="73">Finish</th>
              <th width="109">Reazon</th>
              <th width="109">&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            <?	  
	$consulta  = "SELECT id_cut, inicio, fin, razon_id, id, razon  FROM cut_pause where id_cut=$id order by inicio";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	while($res=mysql_fetch_assoc($resultado))
	{	
		?>
            <tr>
              <td><? echo $res['inicio'];?></td>
              <td><? echo $res['fin'];?></td>
              <td><?	  
							$consulta2  = "SELECT * FROM down_time_reason order by id";
							$resultado2 = mysql_query($consulta2) or die("La consulta fall&oacute;P1: " . mysql_error());
							$count=1;
							while(@mysql_num_rows($resultado2)>=$count)
							{
								$res2=mysql_fetch_row($resultado2);
								if($res['razon_id']==$res2[0])
								echo"$res2[1]";
								
								$count=$count+1;
							}	
		
										?></td>
              <td><span class="col-sm-6 col-md-4 col-lg-4">
               <? echo $res['razon']?>
              </span></td>
            </tr>
            <? }?>
          </tbody>
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
