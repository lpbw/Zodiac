<?
session_start();
include "coneccion.php";
include "checar_sesion_admin.php";
$idU=$_SESSION['idU'];
$nombreU=$_SESSION['nombreU'];
$tipoU=$_SESSION['tipoU'];
$hora=date('H:i:s');//obtiene la hora actual
if($_SESSION['filtro']!=""){
$filtro=$_SESSION['filtro'];
}
else{
$filtro=0;
}
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
		 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
	 		  <SCRIPT>
            $(function() {
                $( "#flote" ).datepicker({ dateFormat: 'yy-mm-dd' });
                $( "#desde" ).datepicker({ dateFormat: 'yy-mm-dd' });
            });
			</script>
<script>
        function textAreaAdjust(o) {
            o.style.height = "1px";
            o.style.height = (25+o.scrollHeight)+"px";
        }
		function seleccionaLugar(){
			document.form1.lugar_b.value=document.form2.lugar_b.value;
		}

		 $(document).ready(function(){
            
            var fid= $('#f_id').val();
			
            //Si va a editar una fibra.
            if(fid != "")
            {
                $("#fiber_id option").each(function(){
                    if($(this).attr('value') == fid)
                    {
                        $("#id_fiber").val($(this).attr('id'));
                    }
                });
            }
            
            //Selecciona la fibra nueva.
            $('#f_id').on('input',function() {
                var opt = $('option[value="'+$(this).val()+'"]');
                $("#id_fiber").val(opt.attr('id'));
            });
        });
    </script>
<?
$id=$_POST['id'];
if($id=="")
	$id=$_GET['id'];
if($id!="")
{
	$consulta  = "SELECT id, lote, fiber_id, retail_length, FORMAT(guaranteed_length/36,2), FORMAT(remaining_inches/36,2), location_id, location_slot, state_id,storage_id  FROM rolls where id='".$id."' and rolls.deleted_at is null ";

	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	if(@mysql_num_rows($resultado)>=1)
	{
		$res8=mysql_fetch_array($resultado,MYSQL_BOTH);
		
	}
}
$guardar= $_POST["guardar"];
if($guardar=="Save")  
{
	$_SESSION['filtro']= $_POST["lugar_b"];
	//echo "location: " .$_POST["location_id"];
	//echo "tubo: " .$_POST["location_slot"];
	//nombre de la fibra.
	$fiber_id= $_POST["id_fiber"];
	$flote= $_POST["flote"];
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
    //Valida que el estatus del rollo no sea 0
    if ($state_id == "0") {
        echo "<script>alert('State of roll not selected');</script>";
    }
    else
    {
	//revisa que no este ocupado el tubo
if($id!="")
		$and2="and rolls.id<>$id";
	else
		$and2="";
	$consulta  = "SELECT id FROM rolls where location_id='$location_id' and location_slot='$slot[0]' and location_id<>0 $and2";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	$count=1;
	if(@mysql_num_rows($resultado)>0)
	{
		echo"<script>alert(\"Occupied Position\");</script>";
	}
	else
	{
			$consulta  = "SELECT rolls.id, locations.name, storage.name, location_capacities.number FROM rolls left outer join locations on rolls.location_id=locations.id left outer join storage on rolls.storage_id=storage.id left outer join location_capacities on location_capacities.id=rolls.location_slot where rolls.lote='$lote' $and2 ";
			$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
			$count=1;
			if(@mysql_num_rows($resultado)>0)
			{
				$res=mysql_fetch_row($resultado);
				echo"<script>alert(\"Duplicated lot at ".$res[1]." ".$res[2]." ".$res[3]."\");</script>";
			}
			else
			{
		if($id!="")
		{
			
			if($state_id==4 || $state_id==5)  
				{
					
						$consulta="select status from cuts where roll_id=$id and (status=2 or status=1)";
						$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
						if(@mysql_num_rows($resultado)>0)
						{
							echo"<script>alert(\"Roll in use can not be finished \");</script>";
						}
						else
						{//aqui cambio location_id=0, location_slot=0
						$pulgadas=$remaining_inches;
						$guaranteed=$guaranteed_length;
						$consulta  =  "update rolls  set lote='$lote', fiber_id='$fiber_id', retail_length='$retail_length', guaranteed_length='$guaranteed', remaining_inches='$pulgadas', location_id=0, location_slot=0, state_id='$state_id', updated_at=now(), storage_id=$storage, Update_by='$idU' where id=$id";
						
						$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
			
						$consulta="select remaining_inches, guaranteed_length from rolls where id=$id";
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
					
					
						$consulta2  =  "update rolls set state_id=$estatus, updated_at=now(), finished_at=now(), location_id=0, location_slot=0, finished_by=$idU, Update_by='$idU' where id=$id";
						$resultado2 = mysql_query($consulta2) or die("Error en operacion1: $consulta2 " . mysql_error());
						
						echo"<script>alert(\"Finished Roll \");</script>";
						}
					/*echo"<script>parent.tb_remove(); parent.location=\"adm_planes.php\"</script>";*/
				}else
				{
			$consulta  =  "update rolls  set lote='$lote', fiber_id='$fiber_id', retail_length='$retail_length', guaranteed_length='$guaranteed', remaining_inches='$pulgadas', location_id='$location_id', location_slot='$slot[0]', state_id='$state_id', updated_at=now(), storage_id=$storage, Update_by='$idU' where id=$id";
			$pulgadas=$remaining_inches;
			$guaranteed=$guaranteed_length;
			$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
			
				}
					
			
		}
		else
		{
			$consulta  =  "insert into rolls( lote, fiber_id, retail_length, guaranteed_length, remaining_inches, location_id, location_slot, state_id, created_at, storage_id, Update_by,date_lote) values('$lote', '$fiber_id','$retail_length','$guaranteed','$pulgadas','$location_id','$slot[0]','$state_id',now(),$storage,$idU,'$flote $hora')";
	//out.println(listGStr);
		$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
		}
	//$id_roll=  mysql_insert_id();
    }
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
		echo"<script>alert(\"Roll changed\");</script>";
		else
		echo"<script>alert(\"Roll Added\");</script>";
		$id="";
	}
	}
	/*echo"<script>parent.tb_remove(); parent.location=\"adm_planes.php\"</script>";*/
}
$borrar= $_POST["borrar"];
if($borrar!="")  
{
	
	
		$consulta  = "SELECT id, mo FROM cuts where roll_id='$borrar' ";
		$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
		if(@mysql_num_rows($resultado)>0)
		{
			$res=mysql_fetch_row($resultado);
			echo"<script>alert(\"Roll asigned to MO can´t be deleted ,  MO $res[1]\");</script>";
		}else
		{
			$consulta  =  "delete from rolls where id=$borrar";
			$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
			echo"<script>alert(\"Roll Deleted\");</script>";
		}
	
	
	
	/*echo"<script>parent.tb_remove(); parent.location=\"adm_planes.php\"</script>";*/
}	
if($id!="")
{
	$consulta  = "SELECT id, lote, substring(fiber_id,3), retail_length, FORMAT(guaranteed_length/36,2), FORMAT(remaining_inches/36,2), location_id, location_slot, state_id,storage_id  FROM rolls where id='".$id."' and rolls.deleted_at is null ";

	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	if(@mysql_num_rows($resultado)>=1)
	{
		$res8=mysql_fetch_array($resultado,MYSQL_BOTH);
		
	}
}
?>
<script>
function borrar(id)
{
  if(confirm("¿Are you shure to delete this roll?"))
  {
       document.form1.borrar.value=id;
	   document.form1.submit();
   }
}
function editar(id)
{
  
       document.form1.id.value=id;
	   document.form1.submit();
   
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
		alert("Select Fiber");
		document.form1.fiber_id.focus();
		return false;
	}else if(document.form1.retail_length.value=="")
	{
		alert("Write Supplier Gross QTY");
		document.form1.retail_length.focus();
		return false;
	}else if(document.form1.guaranteed_length.value=="")
	{
		alert("Write Supplier Net QTY");
		document.form1.guaranteed_length.focus();
		return false;
	}else if(document.form1.remaining_inches.value=="")
	{
		alert("Write Remainning QTY");
		document.form1.remaining_inches.focus();
		return false;
	}else if(document.form1.location_id.value!="0" && document.form1.location_slot.value=="0|0")
	{
		alert("Select Location");
		document.form1.location_slot.focus();
		return false;
	}else if(document.form1.location_id.value!="0" && document.form1.location_slot.value!="0|0" && tubo[1]!="" && tubo2!=tubo[0])
	{
		alert("Position not available");
		document.form1.location_slot.focus();
		return false;
	}
	else if(document.form1.location_id.value=="0" && document.form1.storage.value=="0")
	{
		alert("Select Location or Warehouse");
		document.form1.storage.focus();
		return false;
	}else if(document.form1.state_id.value=="0")
	{
		alert("Select roll status");
		document.form1.state_id.focus();
		return false;
	}else if(document.form1.lote.value=="" )
	{
		alert("Write lot number");
		document.form1.lote.focus();
		return false;
	}
	else if(document.form1.location_id.value!="0" && document.form1.location_slot.value!="0|0" && document.form1.storage.value!="0")
	{
		alert("Just select one warehouse or location");
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
                <h1 class="page-header">Rolls</h1>
            
                <form name="form1" action="" method="post" class="margin-bottom" accept-charset="utf-8">                                                <div class="form-group">
              <div class="col-sm-6 col-md-4 col-lg-4">
                                <label for="fiber_id">Fabric:</label>
                                
                                <input name="id" type="hidden" id="id" value="<? echo"$id";?>">
                                <input name="borrar" type="hidden" id="borrar">
								<input name="lugar_b" type="hidden" id="lugar_b" value="<? echo $_POST["lugar_b"];?>">
                                <input type="text" name="fiber_id" list="fiber_id" id="f_id" class="form-control" require>
                                <datalist id="fiber_id">
                                    <?	
                                    $consulta  = "SELECT id,";
                                    $consulta .= "substring(fiber_type,3) AS ftype,";
                                    $consulta .= "fiber_type ";
                                    $consulta .= "FROM roll_fibers ";
                                    $consulta .= "WHERE deleted_at is null ";
                                    $consulta .= "ORDER BY fiber_type";
                                    $resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
                                    while($fiber = mysql_fetch_assoc($resultado))
									{
									?>
										<option id="<? echo $fiber['fiber_type']?>" value="<? echo $fiber['ftype']?>" ></option>
									<?
									}
									?>
                                </datalist>
                                <input type="hidden" value="" name="id_fiber" id="id_fiber"/>
              </div>

                            <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="retail_length">Gross:</label>
                                (Yards)
                                <input type="text" class="form-control" id="retail_length" name="retail_length"
                                       value=""/>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="guaranteed_length">Net:</label>
                                (Yards)
                                <input type="text" class="form-control" id="guaranteed_length" name="guaranteed_length"
                                       value=""/>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="remaining_inches">Real remaining:</label>
                                ( Yards)
                                <input type="text" class="form-control" id="remaining_inches" name="remaining_inches" 
                                       value=""/>
                            </div>
              <div class="col-sm-6 col-md-4 col-lg-4">
                                <label for="location_id">Location:</label>
                                
                                <select class="form-control" id="location_id" name="location_id" onChange="buscaPos(location_id.value, '0');">
                                  <option value="0" selected="selected">--Select Location--</option>
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
              <div class="col-sm-6 col-md-4 col-lg-2" id="posiciones">
                                <label for="slot">Tube:</label>
                                <input name="location_slot_selected" type="hidden" value="">
                                <select class="form-control" id="location_slot" name="location_slot">
                                </select>
              </div>

                            <div class="col-sm-6 col-md-4 col-lg-4">
                                <label for="state_id">Status:</label>
                                
                                <select class="form-control" id="state_id" name="state_id">
                                  <option value="0" selected="selected">--Select Status--</option>
                                  <?	  
	$consulta  = "SELECT id, description FROM roll_states where deleted_at is null and (id=2 or id=3 or id=4)";
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
					 <div class="col-sm-6 col-md-4 col-lg-4">
                                <label for="location_id">Warehouse:</label>
                                
                                <select class="form-control" id="storage" name="storage" onChange="sele_bodega(this.value)">
                                  <option value="0" selected="selected">--Select Warehouse--</option>
                                  <?	  
	$consulta  = "SELECT id, name FROM storage where deleted_at is null";
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
					 		<div class="col-sm-6 col-md-4 col-lg-4">
                                <label for="retail_length">Lot Number:</label>
                                <input type="text" class="form-control" id="lote" name="lote"
                                       value=""/>
                            </div>
							
								<div class="col-sm-6 col-md-3 col-lg-3">
                                <label for="guaranteed_length">Fecha Lote:</label>
                                <input name="flote" type="text" class="form-control" id="flote"
                                       value="<? echo"$flote"; ?>" size="10" placeholder="Fecha Lote"  />
			 </div>
						
              <div class="col-sm-6 col-md-12 col-lg-3">
                                <input type="submit" class="btn red-submit button-form" name="guardar"
                                       value="Save" onClick="return validar();"/>
                                
                </div>
				 <div class="col-sm-6 col-md-12 col-lg-3">
                                
                                <input type="button" class="btn red-submit button-form" name="guardar2"
                                       value="Cancel" onClick="window.location='rollos.php';"/>
                </div>
                            <div class="clearfix"></div>
                        </div>
</form>
                                        </div>
<form name="form2" action="" method="post" class="margin-bottom" accept-charset="utf-8">
        <div class="col-lg-12 table-responsive">
                                            <table class="table table-striped table-condensed">
                     <thead>
					<tr><th colspan="3">
                      <select class="form-control" id="lugar_b" name="lugar_b"  style="width:150" onChange="seleccionaLugar()"> 
                        <option value="<? echo $filtro; ?>" >--Select Location--</option>
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
                      <select class="form-control" id="almacen_b" name="almacen_b" onChange="sele_bodega(this.value)" style="width:150">
                        <option value="0" >--Select Warehouse--</option>
                        <?	  
	$consulta  = "SELECT id, name FROM storage where deleted_at is null";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	$count=1;
	while(@mysql_num_rows($resultado)>=$count)
	{
		$res=mysql_fetch_row($resultado);
		if($res[0]==$_POST['almacen_b'])
		echo"<option value=\"$res[0]\" selected>$res[1]</option>";
		else
		echo"<option value=\"$res[0]\" >$res[1]</option>";
		
		$count=$count+1;
	}	
		
		?>
                      </select>
                    </th>
                    <th colspan="3"><input name="lote_b" type="text" class="form-control" id="lote_b" value="<? echo $_POST['lote_b'];?>" size="15" placeholder="Fabric" ></th>
                    <th>&nbsp;</th>
                    <th><span class="col-sm-6 col-md-12 col-lg-3">
                      <input type="submit" class="btn red-submit button-form" name="buscar" value="Search"/>
                    </span></th>
                    <th><a href="exportar_rolls.php" target="_blank"><img src="images/descarga.png" width="46" height="46" border="0" title="Exportar"></a></th><th><a href="exportar_rolls_suma.php" target="_blank"><img src="images/descarga.png" width="46" height="46" border="0" title="Exportar_Sumarizado"></a></th>
					</thead>
					<thead>
					  <th>Lot number </th>
                        <th>Fabric</th>
                    <th>Supplier Gross QTY</th>
                    <th>Supplier Net QTY</th>
                    <th>Total used</th>
                    <th>Remaining QTY</th>
                    <th>Location</th>
                    <th>Tube</th>
					<th>Warehouse</th>
                    <th>Status</th>
					<th>Update By:</th>

                    <th>Edit</th>
                    <th>Delete</th>
                    </thead>
                    <tbody>
	<?	 
	if($_POST['buscar']!="Search" )
	{ 
	if($_POST['lugar_b']!="0" && $_POST['lugar_b']!="")
	{
		$buscarr=" location_capacities.id_location=".$lugar_b." and ";
		$orden=" order by locations.name, location_capacities.number ";//$orden=" order by location_capacities.number ";
	}
	$consulta  = "SELECT rolls.id,  lote, fiber_type, retail_length, FORMAT(guaranteed_length/36,2), FORMAT((guaranteed_length-remaining_inches)/36,2), FORMAT(remaining_inches/36,2), locations.name, location_capacities.number, roll_states.description, storage.name, state_id, u.username,DATE_FORMAT(date_lote, '%m-%d-%Y')  FROM rolls inner join roll_fibers on rolls.fiber_id=roll_fibers.fiber_type inner join roll_states on rolls.state_id=roll_states.id
left outer join  location_capacities on location_capacities.id=rolls.location_slot  
left outer join locations on location_capacities.id_location=locations.id 
left outer join storage on storage.id=rolls.storage_id
LEFT OUTER JOIN users u ON rolls.Update_by=u.id
where $buscarr rolls.deleted_at is null  and rolls.state_id<4 order by locations.name, location_capacities.number";
//echo"1 $consulta";
}
else
{
$buscarr="";
if($_POST['lote_b']!="")
	$buscarr="$buscarr fiber_id like'%".$_POST['lote_b']."%' and ";
if($_POST['lugar_b']!="0" && $_POST['lugar_b']!="")
{
	$buscarr="$buscarr location_capacities.id_location=".$_POST['lugar_b']." and ";
	$orden=" order by locations.name, location_capacities.number ";//$orden=" order by location_capacities.number ";
}
if($_POST['almacen_b']!="0")
{
	$buscarr="$buscarr rolls.storage_id=".$_POST['almacen_b']." and ";
	$orden=" order by locations.name, location_capacities.number ";//$orden=" order by rolls.fiber_id ";
}
$consulta  = "SELECT rolls.id,  lote, fiber_type, retail_length, FORMAT((guaranteed_length)/36,2), FORMAT((guaranteed_length-remaining_inches)/36,2), FORMAT(remaining_inches/36,2), locations.name, location_capacities.number, roll_states.description, storage.name, state_id, u.username,DATE_FORMAT(date_lote, '%m-%d-%Y')  FROM rolls inner join roll_fibers on rolls.fiber_id=roll_fibers.fiber_type inner join roll_states on rolls.state_id=roll_states.id
left outer join  location_capacities on location_capacities.id=rolls.location_slot  
left outer join locations on location_capacities.id_location=locations.id 
left outer join storage on storage.id=rolls.storage_id
LEFT OUTER JOIN users u ON rolls.Update_by=u.id
where $buscarr  rolls.deleted_at is null and rolls.state_id<4 $orden";
//echo"2 $consulta";
}
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1:$consulta " . mysql_error());
	$count=1;
	while(@mysql_num_rows($resultado)>=$count)
	{
		$res=mysql_fetch_row($resultado);
		
		
		?>
		 <tr>
			<td><? echo"$res[1] $res[13]" ; ?></td>
			<td><? echo"$res[2]"; ?></td>
			<td><? echo"$res[3]"; ?></td>
			<td><? echo"$res[4]"; ?></td>
			<td><? echo"$res[5]"; ?></td>
			<td><? echo"$res[6]"; ?></td>
			<td><? echo"$res[7]"; ?></td>
			<td><? echo"$res[8]"; ?></td>
			<td><? echo"$res[10]"; ?></td>
			<td><? echo"$res[9]"; ?></td>
			<td><? echo"$res[12]"; ?></td>
			<td class="text-center"><?  if($res[11]<4){?><a href="javascript:editar(<? echo"$res[0]"; ?>);"><i class="fa fa-pencil-square-o"></i></a><? }?></td>
			<td class="text-center"><? if($res[11]<4){?><a href="javascript:borrar(<? echo"$res[0]"; ?>);"><i class="fa fa-times"></i></a><? }?></td>
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
		
<? if($id!=""){?>
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