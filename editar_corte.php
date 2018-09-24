<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Zodiac</title><meta name="DESCRIPTION" content="">
<meta name="KEYWORDS" content="">
<link rel="stylesheet" href="public/css/style.css"/>
<link rel="stylesheet" href="public/css/font-awesome/css/font-awesome.min.css"/>
<link rel="stylesheet" href="public/css/bootstrap/bootstrap.min.css"/>
    <link rel="stylesheet" href="public/css/bootstrap/bootstrap-theme.min.css"/>
    <link rel="stylesheet" href="public/css/font-awesome/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="public/css/metisMenu/metisMenu.min.css"/>
    <link rel="stylesheet" href="public/css/sb-admin-2/sb-admin-2.css"/>
    <link rel="stylesheet" href="public/css/jqueryui/jquery-ui.min.css">
    <link rel="stylesheet" href="public/css/jqueryui/jquery-ui.structure.min.css">
    <link rel="stylesheet" href="public/css/jqueryui/jquery-ui.theme.min.css">
    <link rel="stylesheet" href="public/css/style.css"/>

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


$locationU=$_SESSION['location'];
$id=$_GET['id'];

//Filtro lugar biene de archivo cortes_p.
$lugar = $_GET['lug'];

//Filtro estatus biene de archivo cortes_p.
 $es = $_GET['es'];
 
$guardar= $_POST["guardar"];
if($guardar=="Guardar")  
{
		$id=$_POST['id'];
		$location= $_POST["location_assigned_id"];
		$lugar_anterior= $_POST["lugar_anterior"];
		$_SESSION['lugar_b'] = $lugar;
		$_SESSION['estatus_b'] = $es;
		if($location!=$lugar_anterior)
		{
			$consulta6="select max(orden) as orden from cuts where location_assigned_id=$location and status<3 and deleted_at is null ";
			$resultado6 = mysql_query($consulta6) or die("Error en operacion1: $consulta6 " . mysql_error());
			$res6=mysql_fetch_assoc($resultado6);
			$orden=$res6['orden'];
			
			if($orden>0)
				$orden=$orden+1;
			else
				$orden=1;
			$consulta2  =  "update cuts set location_assigned_id=$location, number_position=0, orden=$orden where id=$id";
			$resultado2 = mysql_query($consulta2) or die("Error en operacion1: $consulta2 " . mysql_error());
		
		
		
		
	
	$consulta="SELECT cuts.id  FROM cuts inner join cut_type on cut_type.id=cuts.id_cut_type  where cuts.deleted_at is null and cuts.location_assigned_id=$lugar_anterior and status<=2 order by orden";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	$contador=1;
	while($res=mysql_fetch_assoc($resultado))
	{	
		$consulta3  =  "update cuts set orden=$contador, updated_at=now() where id=".$res['id'];
		$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta3 " . mysql_error());
		$contador++;
	}
		}

	/*echo"<script>parent.tb_remove(); parent.location=\"adm_planes.php\"</script>";*/


		echo"<script>parent.location=parent.location</script>";
}		
	$consulta  = "SELECT cuts.id,mo, cn, cut_type.nombre, length_measured, locations.name, location_capacities.number, rolls.lote, roll_fibers.fiber_type, rolls.remaining_inches, cuts.status, cuts.location_assigned_id  FROM cuts inner join cut_type on cut_type.id=cuts.id_cut_type left outer join locations on cuts.location_assigned_id=locations.id left outer join location_capacities on cuts.number_position=location_capacities.id left outer join rolls on rolls.id=cuts.roll_id left outer join roll_fibers on rolls.fiber_id=roll_fibers.fiber_type where cuts.deleted_at is null and cuts.id=$id ";
	//echo"$consulta";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	if(@mysql_num_rows($resultado)>=1)
	{
		$res=mysql_fetch_array($resultado,MYSQL_BOTH);
		$cut_id=$res[0];
		
		
?>

 <body>                    
 <div id="page-wrapper">
        <div >
            <div class="col-lg-12">
                <h1 class="page-header">Corte</h1>
                

               
                

				
                                     
                        <form method="post" name="form2" id="form2">  

                          <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="retail_length" class="label-success"><? echo"$estatus";?> </label>
                                <input name="id" type="hidden" id="id" value="<? echo"$id";?>">
                          </div>
						  <div class="col-sm-6 col-md-4 col-lg-3">
                                <label for="retail_length">Tipo de corte:  </label> <? echo"$res[3]";?>
                          </div>
						  <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="retail_length">Mo:  </label> <? echo"$res[1]";?>
                          </div>
						  <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="retail_length">CN:  </label> <? echo"$res[2]";?>
                          </div>
						  <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="remaining_inches">Longitud Prox. :</label> <? echo"$res[4]";?>
							</div>
			  <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="location_id">Lugar:</label>
                                <input name="lugar_anterior" type="hidden" id="lugar_anterior" value="<? echo"$res[11]";?>">
                                <select class="form-control" id="location_assigned_id" name="location_assigned_id" >
                                  <option value="0" selected="selected">--Selecciona--</option>
                                  <?	  
	$consulta2  = "SELECT id, name FROM locations where deleted_at is null";
	$resultado2 = mysql_query($consulta2) or die("La consulta fall&oacute;P1: " . mysql_error());
	$count2=1;
	while(@mysql_num_rows($resultado2)>=$count2)
	{
		$res2=mysql_fetch_row($resultado2);
		if($res[11]==$res2[0])
		echo"<option value=\"$res2[0]\" selected>$res2[1]</option>";
		else
		echo"<option value=\"$res2[0]\" >$res2[1]</option>";
		$count2=$count2+1;
	}	
		
		?>
                                </select>
							</div>
							<div class="col-sm-6 col-md-4 col-lg-3">
                                <label for="remaining_inches">Posicion:</label> <? echo"$res[6]";?>
							</div>
                            <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="guaranteed_length">Roll:</label> <? echo"$res[7]";?>
                               
                            </div>
						  <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="fiber_id">Fibra:</label> <? echo"$res[8]";?>
						  </div>
                            
                            
							
							<div class="col-sm-6 col-md-4 col-lg-3">
                                <label for="remaining_inches">Longitud Restante. :</label> <? echo"$res[9]";?>
							</div>
                            <div class="col-sm-6 col-md-4 col-lg-4">
                              <label for="slot"></label>
                          </div>

                          <div class="col-sm-6 col-md-12 col-lg-3">
                            <input name="guardar" class="btn red-submit button-form" type="submit" id="guardar" value="Guardar">
                          </div>
                            <div class="clearfix"></div>
                       
<div class="col-lg-12 table-responsive">


</div>
 </form>                 
	<?	
	} 	?>	</div></div></div>					   
</BODY></HTML>