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
    <title>Zodiac - Rollos</title>
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
	<link rel="stylesheet" href="pop.css"/>
<script>
        function textAreaAdjust(o) {
            o.style.height = "1px";
            o.style.height = (25+o.scrollHeight)+"px";
        }
function myFunction() {
    var popup = document.getElementById("myPopup");
    popup.classList.toggle("show");
}

    </script>
<?
$id=$_GET['id'];

if($id!="")
{
	$consulta  = "SELECT *  FROM rolls where id='".$_GET['id']."' and rolls.deleted_at is null ";

	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	if(@mysql_num_rows($resultado)>=1)
	{
		$res8=mysql_fetch_array($resultado,MYSQL_BOTH);
		
	}
}
$guardar= $_POST["guardar"];
if($guardar=="Guardar")  
{
	$fiber_id= $_POST["fiber_id"];
	
	$lote= $_POST["lote"];
	$retail_length= $_POST["retail_length"];
	$guaranteed_length= $_POST["guaranteed_length"];
	$remaining_inches= $_POST["remaining_inches"];
	$location_id= $_POST["location_id"];
	$location_slot= $_POST["location_slot"];
	$slot=explode("|",$location_slot);
	$state_id= $_POST["state_id"];
	$storage= $_POST["storage"];
	$id= $_POST["id"];
	$pulgadas=$remaining_inches*36;
	$guaranteed=$guaranteed_length*36;
	if($id!="")
		$consulta  =  "update rolls  set lote='$lote', fiber_id='$fiber_id', retail_length='$retail_length', guaranteed_length='$guaranteed', remaining_inches='$remaining_inches', location_id='$location_id', location_slot='$slot[0]', state_id='$state_id', updated_at=now(), storage_id=$storage where id=$id";
	else
		$consulta  =  "insert into rolls( lote, fiber_id, retail_length, guaranteed_length, remaining_inches, location_id, location_slot, state_id, created_at, storage_id) values('$lote', '$fiber_id','$retail_length','$guaranteed','$pulgadas','$location_id','$slot[0]','$state_id',now(),$storage)";
	//out.println(listGStr);
	$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
	//$id_roll=  mysql_insert_id();
	
	if($id!="" && $slot[0]!="0"){
		$consulta  =  "update cuts set location_assigned_id='$location_id', number_position='$slot[0]', updated_at=now() where roll_id=$id and status=0";
		$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
		
		$consulta6="select max(orden) as orden from cuts where location_assigned_id=$location_id and status<3 and deleted_at is null ";
		$resultado6 = mysql_query($consulta6) or die("Error en operacion1: $consulta6 " . mysql_error());
		$res6=mysql_fetch_assoc($resultado6);
		$orden=$res6['orden'];
		
		if($orden>0)
			$orden=$orden+1;
		else
			$orden=1;	
		$consulta  = "SELECT id FROM cuts where location_assigned_id='$location_id' and number_position='$slot[0]' and status=0 and orden=0 and deleted_at is null order by id";
		$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
		$count=1;
		while(@mysql_num_rows($resultado)>=$count)
		{
			$res=mysql_fetch_row($resultado);
			$consulta3  =  "update cuts set orden=$orden, updated_at=now() where id=".$res[0];
			$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta3 " . mysql_error());
			$orden++;
			$count=$count+1;
		}	
	}
	if($id!="")
	echo"<script>alert(\"Rollo Cambiado\");</script>";
	else
	echo"<script>alert(\"Rollo Agregado\");</script>";
	
	/*echo"<script>parent.tb_remove(); parent.location=\"adm_planes.php\"</script>";*/
}
$borrar= $_POST["borrar"];
if($borrar!="")  
{
	
	

	$consulta  =  "delete from rolls where id=$borrar";
	//out.println(listGStr);
	$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
	
	
	echo"<script>alert(\"Rollo Borrado\");</script>";
	
	/*echo"<script>parent.tb_remove(); parent.location=\"adm_planes.php\"</script>";*/
}	
?>
<script>
function borrar(id)
{
  if(confirm("¿Esta seguro de borrar este rollo?"))
  {
       document.form1.borrar.value=id;
	   document.form1.submit();
   }
}
function buscaPos(valor, valor2) {
document.form1.location_slot_selected.value=valor2;

document.form1.storage.value=0;
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
			
			var m=document.getElementById('posiciones');
			
			m.innerHTML=resultado;
			
		    }
		  }
		  var tipo=0;
		  
		xmlhttp.open("GET","buscaPos.php?id="+y+"&buscar="+valor2,true);
		xmlhttp.send();
		
return false;		

}

function validar()
{
	var tubo=document.form1.location_slot.value.split("|");
	var tubo2=document.form1.location_slot_selected.value;
	
	//var tubo2=document.form1.location_slot_selected.value.split("|");
	if(document.form1.fiber_id.value=="0")
	{
		alert("Seleccione Fibra");
		document.form1.fiber_id.focus();
		return false;
	}else if(document.form1.retail_length.value=="")
	{
		alert("Escriba Longitud del proveedor");
		document.form1.retail_length.focus();
		return false;
	}else if(document.form1.guaranteed_length.value=="")
	{
		alert("Escriba Longitud garantizada");
		document.form1.guaranteed_length.focus();
		return false;
	}else if(document.form1.remaining_inches.value=="")
	{
		alert("Pulgadas Restantes");
		document.form1.remaining_inches.focus();
		return false;
	}else if(document.form1.location_id.value!="0" && document.form1.location_slot.value=="0|0")
	{
		alert("Seleccione Posicion en la maquina");
		document.form1.location_slot.focus();
		return false;
	}else if(document.form1.location_id.value!="0" && document.form1.location_slot.value!="0|0" && tubo[1]!="" && tubo2!=tubo[0])
	{
		alert("Esa posicion esta ocupada");
		document.form1.location_slot.focus();
		return false;
	}
	else if(document.form1.location_id.value=="0" && document.form1.storage.value=="0")
	{
		alert("Seleccione almacen o Maquina");
		document.form1.storage.focus();
		return false;
	}else if(document.form1.state_id.value=="0")
	{
		alert("Seleccione Estado del rollo");
		document.form1.state_id.focus();
		return false;
	}else if(document.form1.lote.value=="" )
	{
		alert("Escriba Lote");
		document.form1.lote.focus();
		return false;
	}
	else if(document.form1.location_id.value!="0" && document.form1.location_slot.value!="0|0" && document.form1.storage.value!="0")
	{
		alert("No se puede  estar en maquina y en almacen");
		document.form1.lote.focus();
		return false;
	}
}
function sele_bodega(valor)
{
	if(valor!="0")
	{
		document.form1.location_id.value="0";
		document.form1.location_slot.value="0";	
	}
}
</script>
</head>
<body><div id="wrapper">
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
                <h1 class="page-header">Rollos Terminados </h1>
            <div class="divider"></div>

                <div>
                  <div align="right"  class="popup" onClick="myFunction()"><strong><span class="style1 bg-primary">&nbsp;&nbsp;?&nbsp;&nbsp;</span></strong><span class="popuptext" id="myPopup">
<p align="left"><strong>Rollos Terminados </strong></p>
<p align="left">Listado de rollos en estatus de terminado, permite filtrarlos por fibra o lote.</p>
<p align="left">&nbsp;</p>
                </div>
                                    
                <div class="divider"></div>
            
                <form name="form1" action="" method="post" class="margin-bottom" accept-charset="utf-8">
            </form>
      </div>
<form name="form2" action="" method="post" class="margin-bottom" accept-charset="utf-8">
<table>
 <thead>
  <th>
    <span class="col-sm-12 col-md-6 col-lg-4">
      <input name="fib" type="text" class="form-control" id="fib" value=""  placeholder="Fibra" />
    </span>
	    <span class="col-sm-12 col-md-6 col-lg-4">
	  <input name="lot" type="text" class="form-control" id="lot" value=""  placeholder="Lote" />
    </span>
	    <span class="col-sm-12 col-md-6 col-lg-4">
      <input type="submit" class="btn red-submit button-form" name="buscar" value="Buscar"/>
    </span>
  </th>
  <th>

  </th>
 </thead>
</table>

        <div class="col-lg-12 table-responsive">
                                            <table class="table table-striped table-condensed">
                    
					<thead>
					<th>Lote</th>
                    <th>Fibra</th>
                    <th>Long. de proveedor</th>
                    <th>Long. garantizada</th>
                    <th>Total usado</th>
                    <th>Long Restante</th>
                    <th>Lugar</th>
                    <th>Tubo</th>
					<th>Almacen</th>
                    <th>Estado</th>
					<th>Terminado por</th>

                    <th>Editar</th>
                    </thead>
                    <tbody>
	<?	 
		$consulta  = "SELECT rolls.id,  lote, fiber_type, retail_length, FORMAT(guaranteed_length/36,2), FORMAT((guaranteed_length-remaining_inches)/36,2), FORMAT(remaining_inches/36,2), locations.name, location_capacities.number, roll_states.description, storage.name, rolls.state_id, u.first_name  FROM rolls inner join roll_fibers on rolls.fiber_id=roll_fibers.fiber_type inner join roll_states on rolls.state_id=roll_states.id
left outer join  location_capacities on location_capacities.id=rolls.location_slot  
left outer join locations on rolls.location_id=locations.id 
left outer join storage on storage.id=rolls.storage_id
left outer join users u on rolls.finished_by=u.id
where rolls.deleted_at  is null and state_id>=4 
order by finished_at desc limit 0, 30";

	if($_POST['buscar']=="Buscar"){
	$lote=$_POST['lot'];
	$fibra=$_POST['fib'];
	   if($lote!=""){
	     $consulta  = "SELECT rolls.id,  lote, fiber_type, retail_length, FORMAT(guaranteed_length/36,2), FORMAT((guaranteed_length-remaining_inches)/36,2), FORMAT(remaining_inches/36,2), locations.name, location_capacities.number, roll_states.description, storage.name, rolls.state_id, u.first_name  FROM rolls inner join roll_fibers on rolls.fiber_id=roll_fibers.fiber_type inner join roll_states on rolls.state_id=roll_states.id
left outer join  location_capacities on location_capacities.id=rolls.location_slot  
left outer join locations on rolls.location_id=locations.id 
left outer join storage on storage.id=rolls.storage_id
left outer join users u on rolls.finished_by=u.id
where rolls.deleted_at  is null and state_id>=4 
and lote like '%$lote%'
order by finished_at limit 0, 30";
	   }//if lote

if($fibra!=""){
	     $consulta  = "SELECT rolls.id,  lote, fiber_type, retail_length, FORMAT(guaranteed_length/36,2), FORMAT((guaranteed_length-remaining_inches)/36,2), FORMAT(remaining_inches/36,2), locations.name, location_capacities.number, roll_states.description, storage.name, rolls.state_id, u.first_name  FROM rolls inner join roll_fibers on rolls.fiber_id=roll_fibers.fiber_type inner join roll_states on rolls.state_id=roll_states.id
left outer join  location_capacities on location_capacities.id=rolls.location_slot  
left outer join locations on rolls.location_id=locations.id 
left outer join storage on storage.id=rolls.storage_id
left outer join users u on rolls.finished_by=u.id
where rolls.deleted_at  is null and state_id>=4 
and fiber_type like '%$fibra%'
order by finished_at desc limit 0, 30";
	   }//if fibra
	   	   
	}//if buscar

		
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1:$consulta " . mysql_error());
	$count=1;
	while(@mysql_num_rows($resultado)>=$count)
	{
		$res=mysql_fetch_row($resultado);
		
		
		?>
		 <tr>
			<td><? echo"$res[1]"; ?></td>
			<td><? echo"$res[2]"; ?></td>
			<td><? echo"$res[3]"; ?></td>
			<td><? echo"$res[4]"; ?></td>
			<td><? echo"$res[5]"; ?></td>
			<td><? echo"$res[6]"; ?></td>
			<td><? echo"$res[7]"; ?></td>
			<td><? echo"$res[8]"; ?></td>
			<td><? echo"$res[10]"; ?></td>
			<td <? if($res['11']==5)echo"bgcolor=\"#FF0000\"";?>><? echo"$res[9]"; ?></td>
			<td><? echo"$res[12]"; ?></td>
			<td class="text-center"><a href="rollos.php?id=<? echo"$res[0]"; ?>"><i class="fa fa-pencil-square-o"></i></a></td>
			</tr>
		<?
		$count=$count+1;
	}	

		?>
                                        </tbody>
                </table>
      </div>
</form>  
    </div>
</div><footer>
    <script src="public/js/jquery.min.js"></script>
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
		
<? if($_GET['id']!=""){?>
	document.form1.fiber_id.value='<? echo"$res8[2]";?>';
	document.form1.retail_length.value='<? echo"$res8[3]";?>';
	document.form1.guaranteed_length.value='<? echo"$res8[4]";?>';
	document.form1.remaining_inches.value='<? echo"$res8[5]";?>';
	document.form1.location_id.value='<? echo"$res8[6]";?>';
	buscaPos('<? echo"$res8[6]";?>','<? echo"$res8[7]";?>');
	
	document.form1.state_id.value='<? echo"$res8[8]";?>';
	document.form1.storage.value='<? echo"$res8[9]";?>';
	document.form1.lote.value='<? echo"$res8[1]";?>';
	//document.form1.location_slot.value='<? echo"$res8[7]";?>';
	

<? }?>		
    </script>
   



    
</footer>
</body>
</html>