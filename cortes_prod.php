<?
session_start();
error_reporting(E_ALL);
include "coneccion.php";
include "checar_sesion_prod.php";
$idU=$_SESSION['idU'];
$nombreU=$_SESSION['nombreU'];
$tipoU=$_SESSION['tipoU'];
$locationU=$_SESSION['location'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Zodiac - Cortes</title>
    <link rel="shortcut icon" href="public/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="public/css/bootstrap/bootstrap.min.css"/>
    <link rel="stylesheet" href="public/css/bootstrap/bootstrap-theme.min.css"/>
    <link rel="stylesheet" href="public/css/font-awesome/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="public/css/metisMenu/metisMenu.min.css"/>
    <link rel="stylesheet" href="public/css/sb-admin-2/sb-admin-2.css"/>
    <link rel="stylesheet" href="public/css/jqueryui/jquery-ui.min.css">
    <link rel="stylesheet" href="public/css/jqueryui/jquery-ui.structure.min.css">
    <link rel="stylesheet" href="public/css/jqueryui/jquery-ui.theme.min.css">
    <link rel="stylesheet" href="public/css/style.css"/>
    <link rel="stylesheet" href="public/css/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css" rel="stylesheet" />
	
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
		 
  <script src="colorbox/jquery.colorbox-min.js" type="text/javascript"></script>
<link rel="stylesheet" href="colorbox/colorbox.css" />
  <script type="text/javascript">
  $(function(){
    $(".iframe3").live('click',function(e){
         e.preventDefault();
         $.colorbox({
              width:"420", 
              href:$(this).attr('href'),
              height:"430", 
              iframe:true, 
              onClosed:function(){     
                   location.reload(true); 
              } 
         });
    });
});
 $(function(){
    $(".iframe1").live('click',function(e){
         e.preventDefault();
         $.colorbox({
              width:"860", 
              href:$(this).attr('href'),
              height:"500", 
              iframe:true, 
              onClosed:function(){     
                   location.reload(true); 
              } 
         });
    });
});
	$(document).ready(function(){
		//$(".iframe1").colorbox({iframe:true,width:"860", height:"500",transition:"fade", scrolling:true, opacity:0.7});
		$(".iframe2").colorbox({iframe:true,width:"600", height:"210",transition:"fade", scrolling:false, opacity:0.7});
		//$(".iframe3").colorbox({iframe:true,width:"420", height:"430",transition:"fade", scrolling:false, opacity:0.7});
		$("#click").click(function(){ 
		$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
			return false;
		});
	});

	function cerrarV(){
		$.fn.colorbox.close();
	}
function abrir(id)
{
	
$.colorbox({iframe2:true,href:"editar_corte_prod.php?id="+id,width:"420", height:"430",transition:"fade", scrolling:true, opacity:0.7});
	
}
function abrir2(id)
{
	
$.colorbox({iframe2:true,href:"editar_pausa_prod.php?id="+id,width:"820", height:"630",transition:"fade", scrolling:true, opacity:0.7});
	
}
</script>
<script>
        function textAreaAdjust(o) {
            o.style.height = "1px";
            o.style.height = (25+o.scrollHeight)+"px";
        }
		
    </script>
<?
$dia_semana=date(N)+1;
		if($dia_semana==8)
			$dia_semana=1;
			
		//echo"$dia_semana ";
		// buscar condicion si es despues de las 12 y antes de las 12:30 tomar el dia anterior
		$consultaT  = "SELECT numero FROM turnos where CURTIME()>inicio and CURTIME()<fin and dias like '%".$dia_semana."%'";// 
		
		$resultadoT = mysql_query($consultaT) or die("La consulta fall&oacute;P1: $consultaT " . mysql_error());
		if(@mysql_num_rows($resultadoT)>0)
		{
			$resT=mysql_fetch_row($resultadoT);
			$turno=$resT[0];
		 }
		 
		 $consultaT  = "SELECT name, estatus FROM locations where id=$locationU";// 		
		$resultadoT = mysql_query($consultaT) or die("La consulta fall&oacute;P1: $consultaT " . mysql_error());
		if(@mysql_num_rows($resultadoT)>0)
		{
			$resT=mysql_fetch_row($resultadoT);
			$locationName=$resT[0];
			$bpass=$resT[1];
		 }
$paro_id= $_GET["paro_id"];
if($paro_id!="")  
{
		$ra= $_GET["ra"];
		$razon= $_GET["razon"];
		$consulta="select count(id) from cut_pause where turno='".$turno."' and razon_id=1 and DATE(inicio)=DATE(now()) and location_id=$locationU";// revisar como buscar la fecha sin hora
		//echo"$consulta";
		$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
		if(@mysql_num_rows($resultado)>0)
		{
			$res2=mysql_fetch_row($resultado);
			$comidas=$res2[0];
		}
		$consulta="select autorization from down_time_reason where id='".$ra."' ";
		//echo"$consulta";
		$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
		if(@mysql_num_rows($resultado)>0)
		{
			$res2=mysql_fetch_row($resultado);
			$autorizar=$res2[0];
		}
		$consulta22  = "SELECT cut_pause.id, TIME_TO_SEC(timediff(now(), inicio))/60, cut_pause.razon_id, down_time_reason.autorization   FROM cut_pause inner join down_time_reason on cut_pause.razon_id=down_time_reason.id where cut_pause.id=".$paro_id;
		$resultado22 = mysql_query($consulta22) or die("La consulta fall&oacute;P1: $consulta22 " . mysql_error());
		if(@mysql_num_rows($resultado22)>0)
		{
			$res22=mysql_fetch_row($resultado22);
			$tiempo=$res22[1];
			$razon_actual=$res22[2];
			$tipo_actual=$res22[2];
			
		}
		/*if($tipo_actual=="1" && $autorizar=="0"){
			echo"<script>alert(\"Han pasado mas de 5 min para catalogar como Set up \");</script>";
		}
		else
		{*/
		if($ra=="6") // si la razon es set up
		{
			
			if($tiempo<=5)
			{
				$ra=6;
				$consulta2  =  "update cut_pause set razon_id=$ra, razon='$razon', autorized=1 where id=".$paro_id;
				$resultado2 = mysql_query($consulta2) or die("Error en operacion1: $consulta2 " . mysql_error());
			}else
			{
				echo"<script>alert(\"Han pasado mas de 5 min para catalogar como Set up \");</script>";
				/*$ra=7;
				$consulta2  =  "update cut_pause set razon_id=$ra, razon='$razon', autorized=1 where id=".$paro_id;
				$resultado2 = mysql_query($consulta2) or die("Error en operacion1: $consulta2 " . mysql_error());*/
			}
			
							
		}else if($autorizar=="1")// si requiere autorizacion 
		{
			$consulta2  =  "update cut_pause set razon_id=$ra, razon='$razon' where id=$paro_id";
			$resultado2 = mysql_query($consulta2) or die("Error en operacion1: $consulta2 " . mysql_error());
			
		}else
		{
			if($ra=="1" && $comidas>=2)
			{
				echo"<script>alert(\"Ya se tienen 2 comidas registradas \");</script>";
			}
			else
			{
				$consulta2  =  "update cut_pause set razon_id=$ra, razon='$razon', autorized=1 where id=$paro_id";
				$resultado2 = mysql_query($consulta2) or die("Error en operacion1: $consulta2 " . mysql_error());
			}
		}
		//}
		
		

	/*echo"<script>parent.tb_remove(); parent.location=\"adm_planes.php\"</script>";*/
}

$pause_id= $_GET["pause_id"];
if($pause_id!="")  
{

		$ra= $_GET["ra"];
		$consulta="select count(id) from cut_pause where turno='".$turno."' and razon_id=1 and DATE(inicio)=DATE(now()) and location_id=$locationU";// revisar como buscar la fecha sin hora
		$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
		if(@mysql_num_rows($resultado)>0)
		{
			$res2=mysql_fetch_row($resultado);
			$comidas=$res2[0];
		}
		$consulta="select autorization from down_time_reason where id='".$ra."' ";
		$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
		if(@mysql_num_rows($resultado)>0)
		{
			$res2=mysql_fetch_row($resultado);
			$autorizar=$res2[0];
		}
		if($autorizar=="1")// si requiere autorizacion 
		{
			$consulta2  =  "update cut_pause set razon_id=$ra, razon='$razon' where id=$pause_id";
			$resultado2 = mysql_query($consulta2) or die("Error en operacion1: $consulta2 " . mysql_error());
			
		}else
		{
			
			if($ra=="1" && $comidas>=2)
			{
				echo"<script>alert(\"Ya se tienen 2 comidas registradas \");</script>";
			}
			else
			{
				$consulta2  =  "update cut_pause set razon_id=$ra, razon='$razon', autorized=1 where id=$pause_id";
				$resultado2 = mysql_query($consulta2) or die("Error en operacion1: $consulta2 " . mysql_error());
			}
			
		}
		//$consulta2  =  "update cut_pause set razon_id=$ra, autorized=1 where id=$pause_id";
		//$resultado2 = mysql_query($consulta2) or die("Error en operacion1: $consulta2 " . mysql_error());
		

	/*echo"<script>parent.tb_remove(); parent.location=\"adm_planes.php\"</script>";*/
}
$defect_id= $_GET["defect_id"];
if($defect_id!="")  
{

		$ra= $_GET["ra"];
		
		$consulta2  =  "update shorts set razon_id=$ra where id=$defect_id";
		$resultado2 = mysql_query($consulta2) or die("Error en operacion1: $consulta2 " . mysql_error());
		

	/*echo"<script>parent.tb_remove(); parent.location=\"adm_planes.php\"</script>";*/
}
$pause_id2= $_GET["pause_id2"];
if($pause_id2!="")  
{

		$ra2= $_GET["ra2"];
		$consulta="select count(id) from cut_pause where turno='".$turno."' and razon_id=1 and DATE(inicio)=DATE(now())  and location_id=$locationU";// revisar como buscar la fecha sin hora
		$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
		if(@mysql_num_rows($resultado)>0)
		{
			$res2=mysql_fetch_row($resultado);
			$comidas=$res2[0];
		}
		$consulta="select autorization from down_time_reason where id='".$ra2."' ";
		$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
		if(@mysql_num_rows($resultado)>0)
		{
			$res2=mysql_fetch_row($resultado);
			$autorizar=$res2[0];
		}
		//$consulta2  =  "update cut_pause set razon='$ra2', autorized=1 where id=$pause_id2";
		//$resultado2 = mysql_query($consulta2) or die("Error en operacion1: $consulta2 " . mysql_error());
		if($autorizar=="1")// si requiere autorizacion 
		{
			$consulta2  =  "update cut_pause set razon_id=$ra2, razon='$razon' where id=$pause_id2";
			$resultado2 = mysql_query($consulta2) or die("Error en operacion1: $consulta2 " . mysql_error());
		}else
		{
			if($ra=="1" && $comidas>=2)
			{
				echo"<script>alert(\"Ya se tienen 2 comidas registradas \");</script>";
			}
			else
			{
				$consulta2  =  "update cut_pause set razon_id=$ra2, razon='$razon', autorized=1 where id=$pause_id2";
				$resultado2 = mysql_query($consulta2) or die("Error en operacion1: $consulta2 " . mysql_error());
			}
		}

	/*echo"<script>parent.tb_remove(); parent.location=\"adm_planes.php\"</script>";*/
}	
	
$terminar= $_POST["terminar"];
if($terminar=="Terminar")  
{
	
		$consulta="select status from cuts where roll_id='".$_POST['location_assigned_id']."' and (status=2 or status=1)";
		$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
		if(@mysql_num_rows($resultado)>0)
		{
			echo"<script>alert(\"Rollo en uso no puede ser terminado \");</script>";
		}
		else
		{
		$consulta="select remaining_inches, guaranteed_length, retail_length from rolls where id='".$_POST['location_assigned_id']."'";
		$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
		$res=mysql_fetch_assoc($resultado);
		$gross=$res['retail_length']*36;//gross
						/*echo"<script>alert(\"GROSS= $gross \");</script>";*/
						$resto=$res['remaining_inches'];
						/*echo"<script>alert(\"resto= $resto \");</script>";*/
						$garantizado=$res['guaranteed_length'];//net
						/*echo"<script>alert(\"Net= $garantizado \");</script>";*/
						$tole_gross=($garantizado+(($gross-$garantizado)*0.007));
						/*echo"<script>alert(\"Tolerancia gross= $tole_gross \");</script>";*/
						$tole_net=($garantizado-($garantizado*0.007));
						/*echo"<script>alert(\"Tolerancia Net= $tole_net \");</script>";*/
						/*echo"<script>alert(\" $tole_gross <= $resto >= $tole_net  \");</script>";*/
						/*if($resto<=$tole_net && $resto>=$tole_gross){
							$estatus=4;
							
						}else{
							$estatus=5;
							
							}*/
						$tolerancia_p=($garantizado*0.007);
						$tolerancia_n=-1*($garantizado*0.007);
						
						if($resto>=$tolerancia_n && $resto<=$tolerancia_p){
							$estatus=4;
						}else{
							$estatus=5;
						}
					
		$consulta2  =  "update rolls set state_id=$estatus, updated_at=now(), finished_at=now(), location_id=0, location_slot=0, finished_by=$idU where id='".$_POST['location_assigned_id']."'";
		$resultado2 = mysql_query($consulta2) or die("Error en operacion1: $consulta2 " . mysql_error());
		echo"<script>alert(\"Rollo Terminado \");</script>";
		}
	/*echo"<script>parent.tb_remove(); parent.location=\"adm_planes.php\"</script>";*/
}	
$asignar= $_POST["asignar"];
if($asignar=="Asignar")  
{
	
		
	
		$consulta2  =  "update cuts set roll_id='".$_POST["rollo_asignar"]."' where id=".$_POST["roll_id"];
		$resultado2 = mysql_query($consulta2) or die("Error en operacion1: $consulta2 " . mysql_error());
		echo"<script>alert(\"Rollo Asigando \");</script>";

	/*echo"<script>parent.tb_remove(); parent.location=\"adm_planes.php\"</script>";*/
}	
?>
<script>
function borrar(id)
{
  if(confirm("Esta seguro de borrar este Corte?"))
  {
       document.form1.borrar.value=id;
	   document.form1.submit();
   }
}
function buscar()
{
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
    }
  }
  var tipo=0;
 
xmlhttp.open("GET","buscar_activos.php?id=<? echo"$locationU";?>",true);
xmlhttp.send();
}
function buscarO()
{
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("d_pendientes").innerHTML=xmlhttp.responseText;
    }
  }
  var tipo=0;
 
xmlhttp.open("GET","buscar_pendientes.php?id=<? echo"$locationU";?>",true);
xmlhttp.send();
}
function buscarT()
{
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("d_terminadas").innerHTML=xmlhttp.responseText;
    }
  }
  var tipo=0;
 
xmlhttp.open("GET","buscar_terminadas.php?id=<? echo"$locationU";?>",true);
xmlhttp.send();
}
</script>
<script type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
function MM_jumpMenu2(targ,selObj,restore, razon){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"&razon="+razon+"'");
  if (restore) selObj.selectedIndex=0;
}
function guardaMotivo(targ,selObj,ra){ //v3.0
  eval(targ+".location='cortes_prod.php?pause_id2="+ra+"&ra2="+selObj.value+"'");
  
}
//-->
</script>
<script async src="//jsfiddle.net/pmw57/tzYbU/205/embed/"></script>
<style type="text/css">
<!--
a {color: #FFFFFF; }
-->
</style>
</head>
<body >
<div id="wrapper">
    <!-- Navigation onLoad="timer = setTimeout('auto_reload()',15000);"-->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href=""><img class="img-responsive" src="public/images/zodiac.jpg" alt="zodiac logo"/></a>
    </div>
    <!-- /.navbar-header -->
    <? 
	//if($tipoU!="3")
	//	include "menu_f.php"
	//else
		include "menu_p.php"
	?>
    <!-- /.navbar-static-side -->
</nav>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Cortes (<? echo "$locationName";?>) <? if($bpass==0){?><img src="images/bypass.png" width="85" height="56" /><? }?></h1>
                <div class="divider">
                  <div class="form-group" id="myDiv"> </div>
                </div>

                <div class="col-sm-12">
              </div>
                <div class="divider"></div>

				
                                     
                        <form action="" method="post" name="form1" id="form1">
				<div>Terminar Rollo en posición</div>
				<div class="col-sm-6 col-md-4 col-lg-4">
										        <select class="form-control" id="location_assigned_id" name="location_assigned_id" >
                                  <option value="0" selected="selected">--Selecciona--</option>
                                  <?	  
	$consulta  = "SELECT number, fiber_id, lote, rolls.id, FORMAT(rolls.remaining_inches/36,2) as remaining_inches FROM `location_capacities` left outer join rolls on location_capacities.id=rolls.location_slot where id_location =$locationU and location_slot<>0  and state_id=3 order by number";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	$count=1;
	while(@mysql_num_rows($resultado)>=$count)
	{
		$res=mysql_fetch_row($resultado);
		
		echo"<option value=\"$res[3]\" >$res[0].- $res[1] ($res[2]) $res[4]</option>";
		$count=$count+1;
	}	
		
		?>
                                </select>

				</div>
				<div class="col-sm-6 col-md-4 col-lg-4">
				  <input name="terminar" type="submit" class="btn-default" id="terminar" value="Terminar" />
				</div>
				<div class="col-sm-6 col-md-4 col-lg-4"><iframe src="sesionActiva.php" width="150" height="40" scrolling="No"></iframe></div>
				<div class="col-sm-6 col-md-4 col-lg-2">&nbsp;</div>
			  
               <div>Ordenes pendientes</div>           
              <div class="col-lg-12 table-responsive" id="d_pendientes">
			  
                                                                    <table class="table table-striped table-condensed grid">
                            <thead>
							<tr>
                            <th width="5%">MO</th>
                           
                            <th width="5%">CN</th>
                            <th width="7%">Tipo de corte</th>
                            <th width="7%">No.Parte</th>
                            <th width="13%">Long. Aprox.</th>
                            <th width="7%">Lugar</th>
                            <th width="9%">Posicion</th>
                            <th width="6%">Rollo</th>
							<th width="6%">Fibra</th>
                            <th width="8%">Long. Restante</th>
							<th width="27%">Asignar Rollo</th>
							</tr>
                            </thead>
                            <tbody>

                            
                                        
	<?	
	$contado=0;  
	$consulta  = "SELECT *  FROM cuts where deleted_at is null and location_assigned_id=$locationU and status<3 order by orden";
	$consulta="SELECT cuts.id,mo, cn, cut_type.nombre, length_measured, locations.name, location_capacities.number, rolls.lote, roll_fibers.fiber_type, FORMAT(rolls.remaining_inches/36,2) as remaining_inches2, cuts.status, cuts.parte  
	FROM cuts inner join cut_type on cut_type.id=cuts.id_cut_type inner join locations on cuts.location_assigned_id=locations.id 
	left outer join location_capacities on cuts.number_position=location_capacities.id 
	left outer join rolls on rolls.id=cuts.roll_id 
	left outer join roll_fibers on cuts.fiber_id=roll_fibers.fiber_type 
	where cuts.deleted_at is null and cuts.location_assigned_id=$locationU and status=0 order by orden";
	//echo"$consulta";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	while($res=mysql_fetch_assoc($resultado))
	{	
		?>
							<tr>
                                    <td><? echo $res['mo']?></td>
                                 
                                    <td><? echo $res['cn']?></td>
                                    <td><? echo $res['nombre']?></td>

                                    <td><? echo $res['parte']?></td>
                                <!--    <td>1</td>  ESTA ES LA LINEA VIEJA QUE REEMPLAZAMOS   -->


                                    <td><? echo $res['length_measured']?></td>
                                    <td><? echo $res['name']?></td>
                                    <td><? echo $res['number']?></td>
                                    <? if($res['lote']==""){?><td  bgcolor="#FF0000"><? }else{?><td><? } echo $res['lote']?></td>
									<td><? echo $res['fiber_type']?></td>
                                    <td><? echo $res['remaining_inches2']?></td>
                                    <td>
                                 <? if($contado==0){?>
                                 <input name="roll_id" type="hidden" id="roll_id" value="<? echo $res['id'] ;?>" />
                                 <select class="form-control" id="rollo_asignar" name="rollo_asignar" > <option value="0" selected="selected">--Selecciona--</option>
                                  <?	  
	$consulta2  = "SELECT number, fiber_id, lote, rolls.id, FORMAT(rolls.remaining_inches/36,2) as remaining_inches FROM `location_capacities` left outer join rolls on location_capacities.id=rolls.location_slot where id_location =$locationU and location_slot<>0  and state_id=3 and rolls.fiber_id='".$res['fiber_type']."' order by number";
	$resultado2 = mysql_query($consulta2) or die("La consulta fall&oacute;P1: " . mysql_error());
	$count2=1;
	while(@mysql_num_rows($resultado2)>=$count2)
	{
		$res2=mysql_fetch_row($resultado2);
		
		echo"<option value=\"$res2[3]\" >$res2[0].- $res2[1] ($res2[2])$res2[4]</option>";
		$count2=$count2+1;
	}	
	echo"<option value=\"1\" >Fallout</option>";	
		?>
                                </select>
                                      <span class="col-sm-6 col-md-4 col-lg-4">
                                      <input name="asignar" type="submit" class="btn-default" id="asignar" value="Asignar" />
                                      </span>
                                      <?  }?>
                                    </td>
							</tr>
                                       <?
									  $contado++;
									    }?>
									   </tbody>                     
                                                    </table>
              </div>
</form>
              <div> 
                <div align="right"><a href="cambiar_orden.php" class="ui-state-highlight iframe1">Cambiar Orden</a></div>
              </div>
			  <div> Ordenes terminadas</div>
 <div class="col-lg-12 table-responsive" id="d_terminadas">
			 
                                                                    <table class="table table-striped table-condensed grid">
                            <thead>
							<tr>
                            <th width="4%">MO</th>                  
                            <th width="4%">CN</th>
                            <th width="10%">Tipo de corte</th>                       
                            <th width="5%">Lugar</th>
                            <th width="7%">Posicion</th>
                            <th width="5%">Rollo</th>
							<th width="5%">Fibra</th>					
                            <th width="12%">Long. Restante</th>
                           <th width="5%">Long</th>
							<th width="11%">Long. Defecto</th>
							<th width="5%">Inicio</th>
							<th width="14%">Fin</th>
							<th width="4%"><div align="center">Short</div></th>
							<th width="4%">Pausas</th>
							<th width="5%">Justificacion</th>
							</tr>
                            </thead>
                            <tbody>

                            
                                        
	<?	  
	$consulta  = "SELECT *  FROM cuts where deleted_at is null and location_assigned_id=$locationU and status<3 order by orden";
	$consulta="SELECT * ,cuts.id as cuts_id,FORMAT(remaining_inches/36,2) as remaining_inches2,FORMAT(length_consumed/36,2) as length_consumed2 , FORMAT(length_defect/36,2) as  length_defect2  FROM cuts inner join cut_type on cut_type.id=cuts.id_cut_type inner join locations on cuts.location_assigned_id=locations.id left outer join location_capacities on cuts.number_position=location_capacities.id inner join rolls on rolls.id=cuts.roll_id inner join roll_fibers on cuts.fiber_id=roll_fibers.fiber_type where cuts.deleted_at is null and cuts.location_assigned_id=$locationU and status>=3 and prod_user_id=$idU and DATE_FORMAT(software_init, '%Y-%m-%d')=curdate() order by hardware_end";
	
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	while($res=mysql_fetch_assoc($resultado))
	{	
		?>
							<tr>
                                    <td><? echo $res['mo']?></td>
                                 
                                    <td><? echo $res['cn']?></td>
                                    <td><? echo $res['nombre']?></td>
                                    <td><? echo $res['name']?></td>
                                    <td><? echo $res['number']?></td>
                                    <td><? echo $res['lote']?></td>
									<td><? echo $res['fiber_type']?></td>
                                    <td><? echo $res['remaining_inches2']?></td>
									<td><? echo $res['length_consumed2']?></td>
									<td><? echo $res['length_defect2']?></td>

									<td><? echo $res['hardware_init']?></td>
									<td><? echo $res['hardware_end']?></td>
                                    

                                    <td  class="text-center"><a href="editar_shorts_prod.php?id=<? echo $res['cuts_id']; ?>" class="iframe1"><i class="fa fa-pencil-square-o"></i></a></td>
                                    <td <? if($res['pausa']==1)echo"bgcolor=\"#FFFF66\"";?> class="text-center"><a href="editar_pausa_prod.php?id=<? echo $res['cuts_id']; ?>" class="iframe1"><i class="fa fa-pencil-square-o"></i></a></td>
                                    <td <? if($res['status']==4)echo"bgcolor=\"#9966CC\"";?> class="text-center"><a href="editar_corte_prod.php?id=<? echo $res['cuts_id']; ?>" class="iframe3"><i class="fa fa-pencil-square-o"></i></a></td>
                              </tr>
                                       <? }?>
									   </tbody>                     
                                                    </table>
              </div>

          </div>
        </div>
    </div>
</div><footer>
    
    <script src="public/js/bootstrap/bootstrap.min.js"></script>
    <script src="public/js/metisMenu/metisMenu.min.js"></script>
    <script src="public/js/sb-admin-2/sb-admin-2.js"></script>
    <script src="public/js/jquery-ui.min.js"></script>
    <script src="public/js/search.js"></script>
    <script src="public/js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script>tinymce.init({ selector:'textarea' });</script>
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function(){
            $("area[rel^='prettyPhoto']").prettyPhoto();

            $(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'light_square',slideshow:3000, autoplay_slideshow: false});
            $(".gallery:gt(0) a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'fast',slideshow:10000, hideflash: true});

            $("#custom_content a[rel^='prettyPhoto']:first").prettyPhoto({
                custom_markup: '<div id="map_canvas" style="width:260px; height:265px"></div>',
                changepicturecallback: function(){ initialize(); }
            });

            $("#custom_content a[rel^='prettyPhoto']:last").prettyPhoto({
                custom_markup: '<div id="bsap_1259344" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div><div id="bsap_1237859" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6" style="height:260px"></div><div id="bsap_1251710" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div>',
                changepicturecallback: function(){ _bsap.exec(); }
            });
        });
    </script>
    <script  type="text/javascript" charset="utf-8">
        $('.datepick').each(function(){
            $(this).datepicker({ dateFormat: 'yy-mm-dd' });
        });
    </script>



    <script>
        $(function(){
                $('#Recurrent').change(function(){
                    if ($(this).prop('checked')){
                        $('#calArea').prop('disabled', true).animate({
                            opacity: 0
                        });
                            $('#Recurrent').val(1);

                    }
                    else{
                        $('#calArea').prop('disabled', false).animate({
                            opacity: 1
                        });
                        $('#Recurrent').val(0);

                    }
                })
            }
        )
		/////////////////////////////
		buscar();
		window.setInterval(function(){
  		buscar();
		},10000);
		window.setInterval(function(){
  		buscarO();
		},15000);
		window.setInterval(function(){
  		buscarT();
		},16000);
		
		/*function auto_reload()
		{
			window.location = 'cortes_prod.php';
		}*/
		//myFunction();
    </script>
</footer>
</body>
</html>