<?
session_start();
include "coneccion.php";
include "checar_sesion_admin.php";
$idU=$_SESSION['idU'];
$nombreU=$_SESSION['nombreU'];
$tipoU=$_SESSION['tipoU'];

?>
<!doctype html>
<html lang="es">
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

 <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
		 
  <script src="colorbox/jquery.colorbox-min.js" type="text/javascript"></script>
<link rel="stylesheet" href="colorbox/colorbox.css" />
<link rel="stylesheet" href="pop.css"/>
  <script type="text/javascript">
 
	$(document).ready(function(){
		//$(".iframe1").colorbox({iframe:true,width:"860", height:"500",transition:"fade", scrolling:true, opacity:0.7});
		$(".iframe2").colorbox({iframe:true,width:"600", height:"550",transition:"fade", scrolling:false, opacity:0.7});
		//$(".iframe3").colorbox({iframe:true,width:"420", height:"430",transition:"fade", scrolling:false, opacity:0.7});
		$("#click").click(function(){ 
		$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
			return false;
		});
	});

function myFunction() {
    var popup = document.getElementById("myPopup");
    popup.classList.toggle("show");
}

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
function seleccionaLugar(){
	document.form1.lugar_b.value=document.form2.lugar_b.value;
	

}
function ocultar(){

var btn=document.getElementById('btn1').value;
   if(btn=="-"){
      document.getElementById('btn1').value="+";
	  document.getElementById('lis').style.display="none";
   }else{
      document.getElementById('btn1').value="-";
	  document.getElementById('lis').style.display="block";
   }

}
</script>

<script>
        function textAreaAdjust(o) {
            o.style.height = "1px";
            o.style.height = (25+o.scrollHeight)+"px";
        }
    </script>
<?
$guardar= $_POST["guardar"];
if($guardar=="Guardar")  
{			
		
	
		if($_POST["number_position"]!="0")
		{
		$dato=explode("|",$_POST["number_position"]);
		$num_po=$dato[0];
		$loc_asi=$_POST["location_assigned_id"];
		}
		
		if($_POST["captura"]=="1")///////////// Si Catura longitud seleccionado, guarda corte, resta fibra
		{
		$long=$_POST["longitud"];
		$long_def=$_POST["longitud_def"];
		$roll_id=$_POST["roll_id"];
		$status="3";
		}else
		{
		$long="0";
		$long_def="0";
		$roll_id="0";
		$status="0";
		}
		/*//si fue un parche toma la fibra del rollo asignado en la posicion
		if($_POST["id_cut_type"]=="3"){
			
				$consulta6="select rolls.fiber_id from  rolls  where rolls.id='$rollo' ";
				$resultado6 = mysql_query($consulta6) or die("Error en operacion1: $consulta6 " . mysql_error());
				$res6=mysql_fetch_assoc($resultado6);
				$rollo=$res6['id'];
		}*/
		//calcula cn
		/// calcular CN
		
		
			
			if($_POST["id_cut_type"]=="1")
			{
				$mes=intval(date("m"));
				$consulta="select siguiente, mes from programas where id='".$_POST["id_programa"]."' and deleted_at is null";
				$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
				$res=mysql_fetch_assoc($resultado);
				if($mes!=$res['mes']) // si cambio el mes
				{
					$cn=date("m")."01";
					$consulta  =  "update programas set siguiente=2, mes=$mes where id='".$_POST["id_programa"]."'";
					$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
				}else // si es el mismo mes
				{
					if($res[siguiente]<10)
						$cn=date("m")."0".$res[siguiente];
					else
						$cn=date("m").$res[siguiente];
					$consulta  =  "update programas set siguiente=siguiente+1 where id='".$_POST["id_programa"]."'";
					$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
				}
			
			}else if($_POST["id_cut_type"]=="4")
			{
				$consulta="select cn from cuts where mo='".$_POST["mo"]."' and deleted_at is null";
				$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
				$res=mysql_fetch_assoc($resultado);
				$cn=$res['cn'];
				
			}else
			{
				
				$cn="";
			}
	
		
		
		
	    //cuando se va a guardar un parche
		if($_POST["id_cut_type"]=="3")
		{
		     $fibra_id=$_POST["fibra_id"];
			    if(sizeof($fibra_id)>0)
			    {
			        foreach($fibra_id as $na)   
				    {
					  //calcula orden de produccion consecutivo en lectra espeicificada
				      $consulta6="select max(orden) as orden from cuts where location_assigned_id=$loc_asi and status<3 and deleted_at is null ";
				      $resultado6 = mysql_query($consulta6) or die("Error en operacion1: $consulta6 " . mysql_error());
				      $res6=mysql_fetch_assoc($resultado6);
				      $orden=$res6['orden'];
				
				      if($orden>0)
					    $orden=$orden+1;
				      else
					    $orden=1;
						$consulta2  =  "insert into cuts(mo, cn, roll_id, user_id, location_assigned_id, number_position, orden, length_measured, created_at, id_cut_type, id_programa, parte, fiber_id, length_consumed, length_defect,status) values('".$_POST["mo"]."', '0', '".$roll_id."', $idU, '".$loc_asi."', '0', ".$orden.",  '0', now(), '".$_POST["id_cut_type"]."', '".$_POST["id_programa"]."', '0', '$na', ".$long.", ".$long_def.", ".$status.")";
			$resultado2 = mysql_query($consulta2) or die("Error en operacion1: $consulta2 " . mysql_error());
					}
    
			    }
				echo"<script>alert(\"Parches Guardados\");</script>";
		}
		else		
		{
		//crea una orrden de corte para fibra especificado
		$fibra_id=$_POST["fibra_id"];
		  if(sizeof($fibra_id)>0)
		  {
		    foreach($fibra_id as $na)
		    {
		      //calcula orden de produccion consecutivo en lectra espeicificada
		      $consulta6="select max(orden) as orden from cuts where location_assigned_id=$loc_asi and status<3 and deleted_at is null";
			  $resultado6 = mysql_query($consulta6) or die("Error en operacion1: $consulta6 " . mysql_error());
			  $res6=mysql_fetch_assoc($resultado6);
			  $orden=$res6['orden'];
				if($orden>0)
				{
				   $orden=$orden+1;
				}
				else
				{
				   $orden=1;
				}			
			  $consulta2  =  "insert into cuts(mo, cn, roll_id, user_id, location_assigned_id, number_position, orden, length_measured, created_at, id_cut_type, id_programa, parte, fiber_id, length_consumed, length_defect, status) values('".$_POST["mo"]."', '".$cn."', '".$roll_id."', $idU, '".$loc_asi."', '0', ".$orden.",  '0', now(), '".$_POST["id_cut_type"]."', '".$_POST["id_programa"]."', '".$_POST["parte"]."', '$na', ".$long.", ".$long_def.", ".$status.")";
			$resultado2 = mysql_query($consulta2) or die("Error en operacion1: $consulta2 " . mysql_error());
		    }
			
if($_POST["captura"]=="1")///////////// Si Catura longitud seleccionado, resta fibra
{
	$utilizado=$long+$long_def;
	$consulta3  =  "update rolls set remaining_inches=remaining_inches-$utilizado, updated_at=now() where id= $roll_id";
	$resultado3 = mysql_query($consulta3) or die("Error en operacion p3 : $consulta3 " . mysql_error());
	$consulta="select remaining_inches, guaranteed_length, retail_length from rolls where id='".$roll_id."'";
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
	if($resto<=$tole_net && $resto>=$tole_gross){
		$estatus=4;
		/*echo"<script>alert(\"estatus= 4\");</script>";*/
	}else{
		$estatus=5;
		/*echo"<script>alert(\"estatus= 5\");</script>";*/
		}
				
		$consulta2  =  "update rolls set state_id=$estatus, updated_at=now(), finished_at=now(), location_id=0, location_slot=0, finished_by=$idU where id='".$roll_id."'";
		$resultado2 = mysql_query($consulta2) or die("Error en operacion1: $consulta2 " . mysql_error());
}
else
{			
$consulta="SELECT cuts.id  FROM cuts inner join cut_type on cut_type.id=cuts.id_cut_type  where cuts.deleted_at is null and cuts.location_assigned_id='".$loc_asi."' and status=0 order by cuts.fiber_id";
$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
$contador=1;
  while($res=mysql_fetch_assoc($resultado))
  {	
     $consulta3  =  "update cuts set orden=$contador, updated_at=now() where id=".$res['id'];
	 $resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta3 " . mysql_error());
     $contador++;
  }	
}
	 echo"<script>alert(\"Corte Agregado con CN= $cn\");</script>";
			
	}
  }
		/*}else{
			echo"<script>alert(\"Corte es demasiado grande\");</script>";
		}*/
	/*echo"<script>parent.tb_remove(); parent.location=\"adm_planes.php\"</script>";*/
	}
$borrar= $_POST["borrar"];
if($borrar!="")  
{
	
	$consulta="select location_assigned_id from cuts where id=$borrar";
	$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
	$res=mysql_fetch_assoc($resultado);
	$loc=$res['location_assigned_id'];

	$consulta  =  "delete from cuts  where id=$borrar";
	//out.println(listGStr);
	$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
	
	$consulta="SELECT cuts.id  FROM cuts inner join cut_type on cut_type.id=cuts.id_cut_type  where cuts.deleted_at is null and cuts.location_assigned_id=$loc and status=0 order by  cuts.fiber_id";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	$contador=1;
	while($res=mysql_fetch_assoc($resultado))
	{	
		$consulta3  =  "update cuts set orden=$contador, updated_at=now() where id=".$res['id'];
		$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta3 " . mysql_error());
		$contador++;
	}
	echo"<script>alert(\"Corte Borrado\");</script>";
	
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
function buscaPrograma(valor) {
var strUserAgent = navigator.userAgent.toLowerCase(); 
var isIE = strUserAgent.indexOf("msie") > -1; 
var y=valor;
var xmlhttp;
var resultado;
    if(document.form1.id_cut_type.value!=3){
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
			resultado=xmlhttp.responseText;
			
			var m=document.getElementById('d_parte');
			
			m.innerHTML=resultado;
			
		    }
		  }
		  var tipo=0;
		  
		xmlhttp.open("GET","buscaPrograma.php?id="+y,true);
		xmlhttp.send();
		
return false;
	}else{
//alert('esto es un parche');
y=999999;
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
			resultado=xmlhttp.responseText;
			//var l=document.getElementById('d_fibra');
			var m=document.getElementById('d_parte');
			
			m.innerHTML=resultado;
			//l.innerHTML=resultado;
			
		    }
		  }
		  var tipo=0;
		  
		xmlhttp.open("GET","buscaPrograma.php?id="+y,true);
		xmlhttp.send();		
		buscaParte(999999);
		//xmlhttp.open("GET","buscaParte.php?id="+y,true);
		//xmlhttp.send();	
		return false;				
 }
  
}

function buscaParte(valor) {
var strUserAgent = navigator.userAgent.toLowerCase(); 
var isIE = strUserAgent.indexOf("msie") > -1; 

	var y=valor;
	var xmlhttp;
	var resultado;
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
			resultado=xmlhttp.responseText;
			
			var m=document.getElementById('d_fibra');
			
			m.innerHTML=resultado;
			
		    }
		  }
		  var tipo=0;
		  
		xmlhttp.open("GET","buscaParte.php?id="+y,true);
		xmlhttp.send();
		
return false;		

}
function capturar(valor) {
var strUserAgent = navigator.userAgent.toLowerCase(); 
var isIE = strUserAgent.indexOf("msie") > -1; 
var fibra="";
var check=document.getElementsByName('fibra_id[]');
for(i=0; i<check.length; i++)
{
	
	if(check[i].checked==true)
	{
		fibra=check[i].value;
	}
}
if(fibra=="")
{
	alert("Seleccione fibra");
}else
{
	if(document.form1.location_assigned_id.value==0)
		alert("Seleccione fibra");
	else
	{
		var y=valor;
		var xmlhttp;
		var resultado;
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
				resultado=xmlhttp.responseText;
				
				var m=document.getElementById('d_pos');
				
				m.innerHTML=resultado;
				
			    }
			  }
			  var tipo=0;
			if(document.form1.captura.checked)  
				xmlhttp.open("GET","buscaRollo_n.php?fibra="+fibra+"&location="+document.form1.location_assigned_id.value,true);
			else
				xmlhttp.open("GET","buscaRollo_n.php?fibra=0&location=0",true);
			xmlhttp.send();
	}
}		
return false;		

}
function buscaParche() {

if(document.form1.id_cut_type.value==3)
{
document.form1.length_measured.value=0;
var strUserAgent = navigator.userAgent.toLowerCase(); 
var isIE = strUserAgent.indexOf("msie") > -1; 

	
	
	var xmlhttp;
	var resultado;
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
			resultado=xmlhttp.responseText;
			
			var m=document.getElementById('d_lugar');
			
			m.innerHTML=resultado;
			
		    }
		  }
		  var tipo=0;
		  
		xmlhttp.open("GET","mostrarLectra.php",true);
		xmlhttp.send();
}
		
return false;		
	

}
function mostrarLectras() {


var strUserAgent = navigator.userAgent.toLowerCase(); 
var isIE = strUserAgent.indexOf("msie") > -1; 

	
	
	var xmlhttp;
	var resultado;
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
			resultado=xmlhttp.responseText;
			
			var m=document.getElementById('d_lugar');
			
			m.innerHTML=resultado;
			
		    }
		  }
		  var tipo=0;
		  
		xmlhttp.open("GET","mostrarLectra.php",true);
		xmlhttp.send();
		if(!document.form1.fallout.checked)
			buscaFibra(document.form1.fibra_id.value);
		
return false;		

}
function buscaFibra(valor) {
var strUserAgent = navigator.userAgent.toLowerCase(); 
var isIE = strUserAgent.indexOf("msie") > -1; 

	var x=valor.split("|");
	var y=x[0];
	document.form1.length_measured.value=x[1];
	var xmlhttp;
	var resultado;
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
			resultado=xmlhttp.responseText;
			
			var m=document.getElementById('d_lugar');
			
			m.innerHTML=resultado;
			
		    }
		  }
		  var tipo=0;
		  
		xmlhttp.open("GET","buscaFibra.php?id="+y,true);
		xmlhttp.send();
		buscaRollo(valor);
		
return false;		

}
function buscaRollo(valor) {
var strUserAgent = navigator.userAgent.toLowerCase(); 
var isIE = strUserAgent.indexOf("msie") > -1; 

	var x=valor.split("|");
	var y=x[0];
	document.form1.length_measured.value=x[1];
	var xmlhttp;
	var resultado;
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
			resultado=xmlhttp.responseText;
			
			var m=document.getElementById('d_rollo');
			
			m.innerHTML=resultado;
			
		    }
		  }
		  var tipo=0;
		  
		xmlhttp.open("GET","buscaRollo.php?id="+y,true);
		xmlhttp.send();
		
return false;		

}

function buscaLugar(valor) {
var strUserAgent = navigator.userAgent.toLowerCase(); 
var isIE = strUserAgent.indexOf("msie") > -1; 

	var y=valor;
	var z=document.form1.fibra_id.value.split("|");
	var xx=0;
	if(document.form1.fallout.checked)
		xx=1;
	var w=document.form1.id_cut_type.value;
	
	var xmlhttp;
	var resultado;
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
			resultado=xmlhttp.responseText;
			
			var m=document.getElementById('d_pos');
			
			m.innerHTML=resultado;
			
		    }
		  }
		  var tipo=0;
		  
		xmlhttp.open("GET","buscaLugar.php?id="+y+"&fiber="+z[0]+"&fall="+xx+"&parche="+w,true);
		xmlhttp.send();
		
return false;		

}

function validar()
{
	if(document.form1.location_assigned_id.value==0)
	{
		alert("Seleccione Lugar");
		return false;
	}
}
</script>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>
</head>
<body onLoad="document.form1.mo.focus()">
<div id="wrapper">
    <!-- Navigation -->
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
    <? include "menu_f.php"?>
    <!-- /.navbar-static-side -->
</nav>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Cortes</h1>
                <div class="divider"></div>

                <div>
                  <div align="right"  class="popup" onClick="myFunction()"><strong><span class="style1 bg-primary">&nbsp;&nbsp;?&nbsp;&nbsp;</span></strong><span class="popuptext" id="myPopup"><p align="left"><strong>Cortes</strong></p>
<p align="left">Permite crear nuevas ordenes, tambien muestra la lista de cortes pendientes de procesar y permite buscar, editar y borrar cortes en los demas estatus y maquinas .</p>
<div align="left">
  <ul>
    <li><strong>MO</strong>: Numero de Orden</li>
    <li><strong>Tipo de corte</strong>: Identifica el tipo del corte a realizar</li>
    <li><strong>Programa</strong>: Catalogo de programas</li>
    <li><strong>Numero de parte:</strong> de acuerdo al programa elegido muestra la lista de partes relacionadas a ese programa.</li>
    <li><strong>Fibra</strong>: Muestra el listado de las fibras relacionadas al numero de parte elegido.</li>
    <li><strong>Lugar</strong>: Catalogo de maquinas    </li>
  </ul>
</div></span></div>
                </div>
                                    
                <div class="divider"></div>

				
              <form action="" method="post" name="form1" class="margin-bottom" id="form1" accept-charset="utf-8">                        
                        <div class="form-group">
                            

                          <div class="col-sm-6 col-md-4 col-lg-4">
                                <label for="retail_length">MO:</label>
                                <input name="id" type="hidden" id="id" value="<?echo"$id";?>">
                                <input name="borrar" type="hidden" id="borrar">
								<input name="lugar_b" id="lugar_b" type="hidden"/>
                                <input type="text" class="form-control" id="mo" name="mo"
                                       value=""/>
                          </div>
							<!-- <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="retail_length">CN:</label>
                                <input type="text" class="form-control" id="cn" name="cn"
                                       value=""/>
                            </div>-->
							
                            
							<div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="remaining_inches">Tipo de Corte:</label>
                               <select class="form-control" id="id_cut_type" name="id_cut_type" onChange="buscaParche();">
                                  <option value="0" selected="selected">--Selecciona--</option>
								   <?	  
	$consulta  = "SELECT * FROM cut_type order by id";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	$count=1;
	while(@mysql_num_rows($resultado)>=$count)
	{
		$res=mysql_fetch_row($resultado);
		
		echo"<option value=\"$res[0]\" >$res[1]</option>";
		$count=$count+1;
	}	
		
		?> 
                              </select>
                            </div>
							<div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="remaining_inches">Programa:</label>
                               <select class="form-control" id="id_programa" name="id_programa"  onChange="buscaPrograma(id_programa.value)">
                                  <option value="0" selected="selected">--Selecciona--</option>
								   <?	  
	$consulta  = "SELECT * FROM programas WHERE deleted_at='0000-00-00' order by id";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	$count=1;
	while(@mysql_num_rows($resultado)>=$count)
	{
		$res=mysql_fetch_row($resultado);
		
		echo"<option value=\"$res[0]\" >$res[1]</option>";
		$count=$count+1;
	}	
		
		?> 
                              </select>
                            </div>
						  <div class="col-sm-6 col-md-4 col-lg-4" id="d_parte">
                                <label for="guaranteed_length">Numero de parte :</label>
							    <select class="form-control" id="parte" name="parte" ><!--onChange="buscaParte(parte.value)"-->
                                  <option value="0" selected="selected">--Selecciona Numero de Parte--</option>
                                  <?	  
	/*$consulta  = "SELECT parte from parte where deleted_at is null group by parte order by parte";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	$count=1;
	while(@mysql_num_rows($resultado)>=$count)
	{
		$res=mysql_fetch_row($resultado);
		
		echo"<option value=\"$res[0]\" >$res[0]</option>";
		$count=$count+1;
	}*/	
		
		?>
                                </select>
						  </div>
							<div class="col-sm-6 col-md-4 col-lg-4" id="d_fibra">
                              <label for="guaranteed_length">Fibra:</label> <!--
                               <select class="form-control" id="fibra_id" name="fibra_id" >
                                  
                                </select>-->
                            </div>
						<!--  <div class="col-sm-6 col-md-4 col-lg-2" >
                                <label for="guaranteed_length">Fall out:</label>
                                <input name="fallout" type="checkbox" id="fallout" value="1" onClick="mostrarLectras()">
							</div>-->
							
						  <div class="col-sm-6 col-md-4 col-lg-2" id="d_lugar">
                                <label for="fiber_id">Lugar:</label>
						        <select class="form-control" id="location_assigned_id" name="location_assigned_id" >
                                  <option value="0" selected="selected">--Selecciona--</option>
                                  <?	  
	$consulta  = "SELECT id, name FROM locations where deleted_at is null";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	$count=1;
	while(@mysql_num_rows($resultado)>=$count)
	{
		$res=mysql_fetch_row($resultado);
		
		echo"<option value=\"$res[0]\" >$res[1]</option>";
		$count=$count+1;
	}	
		
		?>
                                </select>
						  </div>
                          <div class="col-sm-6 col-md-4 col-lg-2" id="d_cap"><?  if($tipoU=="1"){?>                            Captura Long. 
                            <input name="captura" type="checkbox" id="captura" value="1" onChange="capturar(this.value)"><? }?>
                          </div> 
                          <div class="col-sm-6 col-md-4 col-lg-2" id="d_pos">
                               <label for="location_id"></label>
                          </div>

					
							
                            <div class="col-sm-6 col-md-12 col-lg-3">
                                <input type="submit" class="btn red-submit button-form" name="guardar"
                                       value="Guardar" onClick="return validar()";/>
                                <input type="button" class="btn red-submit button-form" name="guardar2"
                                       value="Cancelar" onClick="window.location='cortes.php';"/>
                            </div>
						
                            <div class="clearfix"></div>
                        </div>
						<script>
function mostrar(posicion){
		var datos=document.form1.number_position.value.split("|");
		document.form1.longitud_real.value=datos[1];
		document.form1.longitud_restante.value=datos[2];
		/*document.form1.rollo_seleccionado.value=datos[3];
		fibra=document.form1.fibra_id.value.split("|");
		fibra=fibra[0];
		lugar=document.form1.location_assigned_id.value;*/
		
		/*if(document.form1.longitud_restante.value*1< document.form1.length_measured.value*1)
		{
			document.form1.number_position.value=0;
			alert("No hay suficiente fibra para este corte");
		}*/

}
function mostrar2(posicion){
		var datos=document.form1.roll_id.value.split("|");
		document.form1.longitud_real.value=datos[1];
		document.form1.longitud_restante.value=datos[2];
		/*document.form1.rollo_seleccionado.value=datos[3];
		fibra=document.form1.fibra_id.value.split("|");
		fibra=fibra[0];
		lugar=document.form1.location_assigned_id.value;*/
		
		if(document.form1.longitud_restante.value*1< document.form1.length_measured.value*1)
		{
			document.form1.number_position.value=0;
			alert("No hay suficiente fibra para este corte");
		}

}
</script>
<script>

function cambiar()
{

document.form1.roll_id.value=0;

var index=document.forms.form1.fibra_id.selectedIndex;
form1.location_assigned_id.length=0;
if(index==0){ objetivo0(); }
<? 
$contador2=1;
$query97 = "SELECT * from roll_fibers where deleted_at is null";
$result97 = mysql_query($query97);
while($rest97 = mysql_fetch_assoc($result97)){?>
if(index==<? echo $contador2;?>){ objetivo<? echo $contador2;?>();}
<? $contador2++; }?>

}// fin cambiar

function cambiar2(id)
{
var index=document.forms.form1.location_assigned_id.selectedIndex;
form1.number_position.length=0;
if(index==0){ des0()};
<? 
$contador4=1;
$query96 = "SELECT * from rolls where deleted_at is null and location_id<>0 and location_slot<>0 group by location_id";
$result96 = mysql_query($query96);
while($rest96 = mysql_fetch_assoc($result96)){?>

if(id==<? echo $rest96['location_id']?>){
opcion0=new Option("--Selecciona--","0","defauldSelected");
document.forms.form1.number_position.options[0]=opcion0;

		<? 
		$query = "SELECT id, location_slot from rolls where location_id={$rest96['location_id']} and location_slot<>0 group by location_slot order by location_slot";
        $result = mysql_query($query) or print("<option value=\"ERROR\">".mysql_error()."</option>");
		$count=1;
        while($lags = mysql_fetch_assoc($result)){
		
        ?>       
opcion<? echo $lags['location_slot']?>=new Option("<? echo $lags['location_slot']?>","<? echo $lags['location_slot']?>", "");
document.forms.form1.number_position.options[<? echo $count?>]=opcion<? echo $lags['location_slot']?>;
		
		<?
		
		$count++;
		}							                         
		?>}
<? $contador4++; }?>
} 
// fin cambiar2

///////////////////////////////////////////////////////////////////////////////
function objetivo0(){
opcion0=new Option("--Selecciona--","0","defauldSelected");
document.forms.form1.location_assigned_id.options[0]=opcion0;
des0();
}

<? 
$contador=1;
$query98 = "SELECT * from roll_fibers where deleted_at is null";
$result98 = mysql_query($query98);
while($rest98 = mysql_fetch_assoc($result98)){?>
function objetivo<? echo $contador?>(){
opcion0=new Option("--Selecciona--","0","defauldSelected");
document.forms.form1.location_assigned_id.options[0]=opcion0;
		<? 
		$query = "SELECT location_id, name from rolls inner join locations on rolls.location_id=locations.id where fiber_id={$rest98['id']} and location_id<>0 and location_slot<>0 group by location_id order by location_id";
        $result = mysql_query($query) or print("<option value=\"ERROR\">".mysql_error()."</option>");
		$count=1;
        while($lags = mysql_fetch_assoc($result)){ 
         ?>       
opcion<? echo $count?>=new Option("<? echo $lags['name']?>","<? echo $lags['location_id']?>", "");
document.forms.form1.location_assigned_id.options[<? echo $count?>]=opcion<? echo $count?>;
<?
$count++;
}
?>
}
<? $contador++; }?>



function des0(){
opcion0=new Option("--Selecciona--","0","defauldSelected");
document.forms.form1.number_position.options[0]=opcion0;

}
 
</script>
                    </form>
					<form name="form2" action="" method="post" class="margin-bottom" accept-charset="utf-8">
				<div class="col-lg-12 table-responsive">
				
				<table class="table table-striped table-condensed">
				<thead>
				 <tr>
				 <th colspan="3"><select class="form-control" id="lugar_b" name="lugar_b"  style="width:150" onChange="seleccionaLugar()">
                        <option value="<? echo $filtro; ?>" >--Selecciona Lugar--</option>
                        <?	  
	$consulta  = "SELECT id, name FROM locations where deleted_at is null";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	$count=1;
	while(@mysql_num_rows($resultado)>=$count)
	{
		$res=mysql_fetch_row($resultado);
		if($res[0]==$_POST['lugar_b'] || $res[0]==$_GET['lugar_b'])
		{
		echo"<option value=\"$res[0]\" selected>$res[1]</option>";
		if($res[0]==$_POST['lugar_b'])
			$lugar_b=$_POST['lugar_b'];
		if($res[0]==$_GET['lugar_b'])
			$lugar_b=$_GET['lugar_b'];
		}
		else
		echo"<option value=\"$res[0]\" >$res[1]</option>";
		$count=$count+1;
	}	
		
		?>
                      </select>
					  </th>
				 <th colspan="3">
				      <select class="form-control" id="estatus_b" name="estatus_b"  style="width:150">
                          <option selected="selected">Estatus</option>
 						  <option value="0">Pendiente</option>
  						  <option value="1">Activo</option>
  						  <option value="3">Terminado</option>
					  </select> 
				 </th>
				 <th><span class="col-sm-6 col-md-12 col-lg-3">
                      <input type="submit" class="btn red-submit button-form" name="buscar" value="Buscar"/>
                    </span></th>
				 </tr>
				</thead>
				
				
				</table>
				</div>	            
                <div class="col-lg-12 table-responsive">Programadas
                                                                    <table class="table table-striped table-condensed">
                            <thead>
                            <tr><th>MO</th>
                            <th>CN</th>
                            <th>Fibra</th>
                            <th>Orden</th>
							<th>Tipo Corte</th>
							<th>Programa</th>
                            <th>Usuario</th>
                            <th>Inicio</th>
                            <th>Final</th>
                            <th>Final (SW)</th>
                            <th>Lugar</th>
							<th>Posición</th>
                            <th>Comentarios de recut</th>
                            <th>Editar Lugar </th>
							 <th>Eliminar</th>
                            </thead>
                            <tbody>
                            </tbody>
                                        
	<?	  	 
	if($_POST['buscar']=="Buscar" )
	{ 
	  $lug=$_POST['lugar_b'];
	  $est=$_POST['estatus_b'];
	  $buscarr=" location_assigned_id<>0 and ";
	  $estat=" status=0 ";
	  //echo "lugar: ".$lug."estatus: ".$est;
	  if($lug!="0" && $lug!="")
	{
		$buscarr=" location_assigned_id=".$lugar_b." and ";
	}
	if($est!="Estatus")
	{
	    if($est=="0"){//pendientes
		   $estat=" status=".$est." ";
		}
	    if($est=="1"){//activo o pausa
	       $estat=" (status=1 or status=2) ";
		}
	    if($est=="3"){
	       $estat=" status>=3 ";
		}
	}
	  $consulta  = "SELECT mo,cn,orden, cut_type.nombre, programas. nombre as nombre2,user_id, hardware_init, hardware_end, software_end, locations.name, location_capacities.number , recut_comment, length_measured , cuts.id , cuts.fiber_id
FROM cuts  inner join cut_type on cuts.id_cut_type=cut_type.id 
left outer join programas on cuts.id_programa=programas.id 
left outer join  location_capacities on location_capacities.id=cuts.number_position  
left outer join locations on cuts.location_assigned_id=locations.id 
where cuts.deleted_at is null and $buscarr $estat order by name,orden";//inner join rolls on cuts.roll_id=rolls.id

	}
	else{
	$buscarr=" location_assigned_id<>0 and ";
	$consulta  = "SELECT mo,cn,orden, cut_type.nombre, programas. nombre as nombre2,user_id, hardware_init, hardware_end, software_end, locations.name, location_capacities.number , recut_comment, length_measured , cuts.id , cuts.fiber_id
FROM cuts  inner join cut_type on cuts.id_cut_type=cut_type.id 
left outer join programas on cuts.id_programa=programas.id 
left outer join  location_capacities on location_capacities.id=cuts.number_position  
left outer join locations on cuts.location_assigned_id=locations.id 
where cuts.deleted_at is null and $buscarr status=0 order by name,orden";//inner join rolls on cuts.roll_id=rolls.id
	}
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	while($res=mysql_fetch_assoc($resultado))
	{	
		?>
										                    <tr>
                                    <td><? echo $res['mo']?></td>
                                    <td><? echo $res['cn']?>M</td>
                                    <td><? echo $res['fiber_id']?></td>
                                    <td><? echo $res['orden']?></td>
									<td><? echo $res['nombre']?></td>
									<td><? echo $res['nombre2']?></td>
                                    <td><? echo $res['user_id']?></td>

                                <!--    <td>1</td>  ESTA ES LA LINEA VIEJA QUE REEMPLAZAMOS   -->


                                    <td><? echo $res['hardware_init']?></td>
                                    <td><? echo $res['hardware_end']?></td>
                                    <td><? echo $res['software_end']?></td>
                                    <td><? echo $res['name']?></td>
									<td><? echo $res['number']?></td>
                                    <td><? echo $res['recut_comment']?></td>
                                    <td class="text-center"><a href="editar_corte.php?id=<? echo $res['id']; ?>" class="iframe2"><i class="fa fa-pencil-square-o"></i></a></td>

                                    <td class="text-center"><a href="javascript:borrar(<? echo $res['id']; ?>);"><i class="fa fa-times"></i></a></td>
                                </tr>
                                       <? }?>                     
                                                    </table>
              </div>
			  </form>
<!--
<div class="col-lg-12 table-responsive">No Programadas
                                                                    <table class="table table-striped table-condensed">
                            <thead>
                            <th>MO</th>
                            <th>CN</th>
                            <th>Orden</th>
							<th>Tipo Corte</th>
							<th>Programa</th>
                            <th>Usuario</th>
                            <th>Lugar</th>
							<th>Posición</th>
                            <th>Comentarios de recut</th>
                            <th>Longitud aprox</th>
							 <th>Editar</th>
                            <th>Eliminar</th>
                            </thead>
                            <tbody>
                            </tbody>
                                        
	<?
	$consulta  = "SELECT mo,cn,orden, cut_type.nombre, programas.nombre as nombre2,user_id, hardware_init,   recut_comment, length_measured, cuts.id  FROM cuts  inner join cut_type on cuts.id_cut_type=cut_type.id left outer join programas on cuts.id_programa=programas.id  
 where cuts.deleted_at is null  and number_position=0 and status=0 order by mo";	  
	
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	while($res=mysql_fetch_assoc($resultado))
	{	
		?>
										                    <tr>
                                    <td><? echo $res['mo']?></td>
                                    <td><? echo $res['cn']?>M</td>
                                    <td><? echo $res['orden']?></td>
									<td><? echo $res['nombre']?></td>
									<td><? echo $res['nombre2']?></td>
                                    <td><? echo $res['user_id']?></td>

                                

                                    <td><? echo $res['location_assigned_id']?></td>
									<td><? echo $res['number_position']?></td>
                                    <td><? echo $res['recut_comment']?></td>
                                    <td><? echo $res['length_measured']?></td>

                                    <td class="text-center"><a href="cortes.php?id=<? echo $res['id']; ?>"><i class="fa fa-pencil-square-o"></i></a></td>
                                    <td class="text-center"><a href="javascript:borrar(<? echo $res['id']; ?>);"><i class="fa fa-times"></i></a></td>
                                </tr>
                                       <? }?>                     
                                                    </table>
              </div>-->
                <div class="col-lg-12 table-responsive">

                       <!-- <table class="table table-striped table-condensed">
                            <thead>
                            <th>MO</th>
                            <th>CN</th>
                            <th>Rollo</th>
                            <th>Lugar</th>
                            <th>Comentarios de recut</th>
                            </thead>
                            <tbody>

                            </tbody>
                                <tr>
                                    <td>1234test</td>
                                    <td>test1234</td>
                                    <td>0</td>
                                    <td>1</td>
                                    <td></td>
                                </tr>

                        </table>-->

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
	<? if($_GET['id']!=""){?>
	document.form1.name.value='<? echo"$res8[1]";?>';
	
	

<? }?>		
    </script>
</footer>
</body>
</html>