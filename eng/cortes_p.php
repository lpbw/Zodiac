<?
session_start();
include "coneccion.php";
include "checar_sesion_admin.php";
$idU=$_SESSION['idU'];
$nombreU=$_SESSION['nombreU'];
$tipoU=$_SESSION['tipoU'];

//filtro lugar.
$lugar = 0;
if($_SESSION['lugar_b'] != "")
{
    $lugar = $_SESSION['lugar_b'];
    $_SESSION['lugar_b'] = 0;
}
elseif($_POST['lugar_b'] != "")
{
    $lugar = $_POST['lugar_b'];
}

//Filtro estatus.
$es = 5;
if($_SESSION['estatus_b'] != "")
{
    $es = $_SESSION['estatus_b'];
    $_SESSION['estatus_b'] = -5;
}

if($_POST['estatus_b'] != "" && $_POST['estatus_b'] != "Status")
{
    $es = $_POST['estatus_b'];
}

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
<script type="text/javascript" src="js/cortes_p.js"></script>
<?
$guardar= $_POST["guardar"];
if($guardar=="Save")  
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
						$consulta2  =  "insert into cuts(mo, cn, roll_id, user_id, location_assigned_id, number_position, orden, length_measured, created_at, id_cut_type, id_programa, parte, fiber_id) values('".$_POST["mo"]."', '0', '0', $idU, '".$loc_asi."', '0', ".$orden.",  '0', now(), '".$_POST["id_cut_type"]."', '".$_POST["id_programa"]."', '0', '$na')";
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
			  $consulta2  =  "insert into cuts(mo, cn, roll_id, user_id, location_assigned_id, number_position, orden, length_measured, created_at, id_cut_type, id_programa, parte, fiber_id) values('".$_POST["mo"]."', '".$cn."', '0', $idU, '".$loc_asi."', '0', ".$orden.",  '0', now(), '".$_POST["id_cut_type"]."', '".$_POST["id_programa"]."', '".$_POST["parte"]."', '$na')";
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
	 echo"<script>alert(\"Cut added  CN= $cn\");</script>";
			
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
$eliminar = $_POST["eliminar"];
            //  echo "<script>alert('$eliminar');</script>";
            if ($eliminar == "Delete") 
            {
                $borrarp = $_POST["borrap"];
                //echo "<script>alert('$borrarp');</script>";
                foreach ($borrarp as $pr) {
                    // echo "<script>alert('$pr');</script>";
                    $consulta="select location_assigned_id from cuts where id=$pr";
                    $resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
                    $res=mysql_fetch_assoc($resultado);
                    $loc=$res['location_assigned_id'];
                    $consulta  =  "delete from cuts  where id=$pr";
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
                }
                echo"<script>alert(\"deleted cuts\");</script>";
            }	
?>
 <script>
            function ValidaBorrar(){
                //console.log("entro");
                var resp = confirm("You want to delete the selected programs");
                if (resp == true) {
                    //console.log("si");
                    return true;
                }else{
                    //console.log("no");
                    return false;
                }
            }
        </script>
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
                <h1 class="page-header">Cuts</h1>
                <div class="divider"></div>

                <div class="col-sm-12">
                                    </div>
                <div class="divider"></div>

				
              <form action="" method="post" name="form1" class="margin-bottom" id="form1" accept-charset="utf-8">                        
                        <div class="form-group">
                            

                          <div class="col-sm-6 col-md-4 col-lg-4">
                                <label for="retail_length">MO number:</label>
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
                                <label for="remaining_inches">Cutting Category:</label>
                               <select class="form-control" id="id_cut_type" name="id_cut_type" onChange="buscaParche();">
                                  <option value="0" selected="selected">--Select--</option>
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
                                <label for="remaining_inches">Program:</label>
                                <input type="text" name="fiber_id" list="id_pro" id="id_p" class="form-control" require>
                                        <datalist id="id_pro">
                                            <?	
                                            $consulta  = "SELECT * FROM programas WHERE deleted_at='0000-00-00' order by id";
                                            $resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
                                            $count=1;
                                            while(@mysql_num_rows($resultado)>=$count)
                                            {
                                                $res=mysql_fetch_row($resultado);
                                            ?>
                                                <option id="<? echo $res[0]?>" value="<? echo $res[1]?>" ></option>
                                            <?
                                                 $count=$count+1;
                                            }
                                            ?>
                                        </datalist>
                                        <input type="hidden" value="" name="id_programa" id="id_programa"/>
                            </div>
						  <div class="col-sm-6 col-md-4 col-lg-4" id="d_parte">
                                <label for="guaranteed_length">Part Number :</label>
							    <input type="text" name="nparte" list="id_parte" id="nparte" class="form-control" require>
							            <datalist id="id_parte">
                                        </datalist>
                                        <input type="hidden" value="" name="parte" id="parte"/>
						  </div>
							<div class="col-sm-6 col-md-4 col-lg-4" id="d_fibra">
                               <label for="guaranteed_length">Fabric:</label> <!--
                               <select class="form-control" id="fibra_id" name="fibra_id" >
                                  
                                </select>-->
                            </div>
						<!--  <div class="col-sm-6 col-md-4 col-lg-2" >
                                <label for="guaranteed_length">Fall out:</label>
                                <input name="fallout" type="checkbox" id="fallout" value="1" onClick="mostrarLectras()">
							</div>-->
							
						  <div class="col-sm-6 col-md-4 col-lg-2" id="d_lugar">
                                <label for="fiber_id">Location:</label>
						        <select class="form-control" id="location_assigned_id" name="location_assigned_id" >
                                  <option value="0" selected="selected">--Select--</option>
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
                             <div class="col-sm-6 col-md-4 col-lg-2" id="d_cap">
                               <? if($tipoU=="1"){?>                           
                               Captura Long. 
                            <input name="captura" type="checkbox" id="captura" value="1" onChange="capturar(this.value)"><?}?>
                          </div> 
                          <div class="col-sm-6 col-md-4 col-lg-2" id="d_pos">
                               <label for="location_id"></label>
                          </div>
                            <div class="col-sm-6 col-md-4 col-lg-2" id="d_pos">
                              
                            </div>

							
							
                            <div class="col-sm-6 col-md-12 col-lg-3">
                                <input type="submit" class="btn red-submit button-form" name="guardar"
                                       value="Save" onClick="return validar()";/>
                                <input type="button" class="btn red-submit button-form" name="guardar2"
                                       value="Cancel" onClick="window.location='cortes.php';"/>
                            </div>
							
                            <div class="clearfix"></div>
                        </div>
						<script>
function mostrar(posicion){
		var datos=document.form1.number_position.value.split("|");
		document.form1.longitud_real.value=datos[1];
		document.form1.longitud_restante.value=datos[2];

}
function mostrar2(posicion){
		var datos=document.form1.roll_id.value.split("|");
		document.form1.longitud_real.value=datos[1];
		document.form1.longitud_restante.value=datos[2];
		
		
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
                          <option selected="selected">Status</option>
 						  <option value="0" <? echo $es==0?"selected":"";?>>Pending</option>
  						  <option value="1" <? echo $es==1?"selected":"";?>>Active</option>
  						  <option value="3" <? echo $es==3?"selected":"";?>>Finished</option>
					  </select> 
				 </th>
				 <th><span class="col-sm-6 col-md-12 col-lg-3">
                      <input type="submit" class="btn red-submit button-form" name="buscar" value="Search"/>
                    </span></th>
					<!-- borrar seleccionados -->
					<th>
                        <span class="col-sm-12 col-md-6 col-lg-6">
                            <input type="submit" class="btn red-submit button-form" name="eliminar" id="eliminar" value="Delete" onclick="return ValidaBorrar();"/>
                        </span>
                    </th>
				 </tr>
				</thead>
				
				
				</table>
				</div>	            
                <div class="col-lg-12 table-responsive">Programed MO
                    <table class="table table-striped table-condensed">
                            <thead>
                            <tr><th>MO number</th>
                            <th>CN</th>
                            <th>Fabric</th>
                            <th>Sequence</th>
							<th>cutting Category</th>
							<th>Program</th>
                            <th>User</th>
                            <th>Start</th>
                            <th>Finish</th>
                            <th>Finish (SW)</th>
                            <th>Location</th>
							<th>Position</th>
                            <th>Recut's Comme	nts</th>
                            <th>Edit Location</th>
							 <th>Delete</th>
                            </thead>
                            <tbody>
                            </tbody>                          
	<?	  	 
	if($_POST['buscar']=="Search" || $lugar != 0 || $es != "Status")
	{ 
	  $lug=$_POST['lugar_b'];
      $est=$_POST['estatus_b'];
      if($lugar != 0)
    {
        $lug = $lugar;
    }
        if($es != "Status")
    {
        $est = $es;
    }
	  $buscarr=" location_assigned_id<>0 and ";
	  $estat=" status=0 ";
	  //echo "lugar: ".$lug."estatus: ".$est;
	  if($lug!="0" && $lug!="")
	{
		$buscarr=" location_assigned_id=".$lugar_b." and ";
	}
	if($est!="Status")
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
    $consulta  = "SELECT mo,";
    $consulta .= "cn,";
    $consulta .= "orden,";
    $consulta .= "cut_type.nombre,";
    $consulta .= "programas.nombre AS nombre2,";
    $consulta .= "user_id,";
    $consulta .= "hardware_init,";
    $consulta .= "hardware_end,";
    $consulta .= "software_end,";
    $consulta .= "locations.name,";
    $consulta .= "location_capacities.number,";
    $consulta .= "recut_comment,";
    $consulta .= "length_measured,";
    $consulta .= "cuts.id,";
    $consulta .= "cuts.fiber_id ";
    $consulta .= "FROM cuts ";
    $consulta .= "INNER JOIN cut_type ON cuts.id_cut_type=cut_type.id "; 
    $consulta .= "LEFT OUTER JOIN programas ON cuts.id_programa=programas.id "; 
    $consulta .= "LEFT OUTER JOIN location_capacities ON location_capacities.id=cuts.number_position "; 
    $consulta .= "LEFT OUTER JOIN locations ON cuts.location_assigned_id=locations.id "; 
    $consulta .= "WHERE cuts.deleted_at IS NULL AND $buscarr $estat ORDER BY orden";
   
	}
	else{
        $buscarr=" location_assigned_id<>0 and ";
        $consulta  = "SELECT mo,";
        $consulta .= "cn,";
        $consulta .= "orden,";
        $consulta .= "cut_type.nombre,";
        $consulta .= "programas.nombre AS nombre2,";
        $consulta .= "user_id,";
        $consulta .= "hardware_init,";
        $consulta .= "hardware_end,";
        $consulta .= "software_end,";
        $consulta .= "locations.name,";
        $consulta .= "location_capacities.number,";
        $consulta .= "recut_comment,";
        $consulta .= "length_measured,";
        $consulta .= "cuts.id,";
        $consulta .= "cuts.fiber_id ";
        $consulta .= "INNER JOIN cut_type ON cuts.id_cut_type=cut_type.id ";
        $consulta .= "LEFT OUTER JOIN programas ON cuts.id_programa=programas.id ";
        $consulta .= "LEFT OUTER JOIN location_capacities ON location_capacities.id=cuts.number_position "; 
        $consulta .= "LEFT OUTER JOIN locations ON cuts.location_assigned_id=locations.id ";
        $consulta .= "WHERE cuts.deleted_at IS NULL AND $buscarr status=0 ORDER BY orden";
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
                                    <td class="text-center"><a href="editar_corte.php?id=<? echo $res['id']; ?>&lug=<? echo $lug; ?>&es=<? echo $es; ?>" class="iframe2"><i class="fa fa-pencil-square-o"></i></a></td>

                                    <td class="text-center">
										<input type="checkbox" name="borrap[]" value="<? echo $res['id']; ?>"/>
										<!-- <a href="javascript:borrar(<? echo $res['id']; ?>);">
											<i class="fa fa-times"></i>
										</a> -->
									</td>
                                </tr>
                                       <? }?>                     
                                                    </table>
                    	</div>
			  		</form>
                <div class="col-lg-12 table-responsive">
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