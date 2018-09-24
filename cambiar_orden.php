<?
session_start();
include "coneccion.php";
include "checar_sesion_prod.php";
$idU=$_SESSION['idU'];
$nombreU=$_SESSION['nombreU'];
$tipoU=$_SESSION['tipoU'];
$locationU=$_SESSION['location'];

$cambiar=$_POST["cambiar"];
if($cambiar=="Cambiar")
{
	$cortes= $_POST["cortes"];
	if(sizeof($cortes)>0)
	{
		 $consulta  = "SELECT orden, cuts.id,cuts.mo, roll_fibers.fiber_type  FROM cuts left outer join rolls on cuts.roll_id=rolls.id left outer join roll_fibers on rolls.fiber_id=roll_fibers.fiber_type where cuts.deleted_at is null and location_assigned_id=$locationU and (status=1 or status=2) order by orden";
		$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
		if(@mysql_num_rows($resultado)>0)	
			$contador=2;
		else
			$contador=1;
		foreach($cortes as $a)
		{
			$consulta  = "update cuts set orden=$contador where id=$a";
			$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1:$consulta " . mysql_error());
			$contador++;
		}
	}
	echo"<script>parent.location=parent.location;</script>";
}
?>
<html>
<head>
<link href="images/textos.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Ordenar Partidas</title>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
  
  <!-- drag and drop jquery-->
  <style>
  #sortable { list-style-type: none; margin: 0; padding: 0; width: 90%; }
  #sortable li { margin: 0 5px 5px 5px; padding: 5px; height: 1.5em; text-align: left; }
  #sortable span { margin-right: 5px; display: inline-block}
  html>body #sortable li { height: 1.5em; line-height: 1.2em; }
  .ui-state-highlight { height: 1.5em; line-height: 1.2em; }
  </style>
  <script>
  $(document).ready(function(){
    $( "#sortable" ).sortable({
      placeholder: "ui-state-highlight"
    });
    $( "#sortable" ).disableSelection();
    $( "#sortable" ).sortable({ axis: "y" });
  $('li').attr('class','ui-state-default texto_info_negro_c');
							 });
  </script>
</head>

<body onLoad="MM_preloadImages('images/b_inicio_r.jpg','images/b_empresa_r.jpg','images/b_productos_r.jpg','images/b_industrias_r.jpg','images/b_contacto_r.jpg','images/carrito_r.jpg')">
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
<div  style="margin-top:10px; width:100%;" align="center" >

    <ul id="sortable">
    <?
	  
   
   $consulta  = "SELECT orden, cuts.id,cuts.mo, roll_fibers.fiber_type  FROM cuts left outer join rolls on cuts.roll_id=rolls.id left outer join roll_fibers on cuts.fiber_id=roll_fibers.fiber_type where cuts.deleted_at is null and location_assigned_id=$locationU and status=0 order by orden";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	while($res=mysql_fetch_assoc($resultado))
	{	?>
        <li>
        <span id="partida<? echo $res['id'];?>" ><? echo $res['orden'];?></span>
        <input name="cortes[]" type="hidden" value="<? echo $res['id'];?>"/>
        <? echo $res['mo']; ?>
        <span id="cantidad<? echo $res['id'];?>" style="float: right" >[<? echo $res['fiber_type'];?>]</span>
        </li>
    <? } ?>
</ul>
    <input type="submit" value="Cambiar" name="cambiar" />
    <input type="submit" value="Reset" name="reset" />
</div>
</form>
</body>
</html>