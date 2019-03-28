<?
session_start();
include "coneccion.php";
include "checar_sesion_admin.php";
$idU=$_SESSION['idU'];
$nombreU=$_SESSION['nombreU'];
$tipoU=$_SESSION['tipoU'];
$desde= $_POST["desde"];
$hasta= $_POST["hasta"];
$lote= $_POST["lote"];
$fibra= $_POST["fibra"];
$mo= $_POST["mo"];
$id_cut_type= $_POST["id_cut_type"];
$operador= $_POST["operador"];
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
	<link rel="stylesheet" href="pop.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
	
  
		  <script>
            $(function() {
                $( "#hasta" ).datepicker({ dateFormat: 'yy-mm-dd' });
                $( "#desde" ).datepicker({ dateFormat: 'yy-mm-dd' });
            });
			function myFunction() {
    var popup = document.getElementById("myPopup");
    popup.classList.toggle("show");
}

			</script>		 
  <script src="colorbox/jquery.colorbox-min.js" type="text/javascript"></script>
<link rel="stylesheet" href="colorbox/colorbox.css" />
<script type="text/javascript">
	$(document).ready(function(){
		$(".iframe1").colorbox({iframe:true,width:"860", height:"500",transition:"fade", scrolling:true, opacity:0.7});
		$(".iframe2").colorbox({iframe:true,width:"600", height:"210",transition:"fade", scrolling:false, opacity:0.7});
		$(".iframe3").colorbox({iframe:true,width:"420", height:"430",transition:"fade", scrolling:false, opacity:0.7});
		$("#click").click(function(){ 
		$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
			return false;
		});
	});

	function cerrarV(){
		$.fn.colorbox.close();
	}
	</script>

<?


$borrar= $_POST["borrar"];
if($borrar!="")  
{
	
	

	$consulta  =  "update rolls set deleted_at=now() where id=$borrar";
	//out.println(listGStr);
	$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
	
	
	echo"<script>alert(\"Rollo Borrado\");</script>";
	
	/*echo"<script>parent.tb_remove(); parent.location=\"adm_planes.php\"</script>";*/
}	
?>
<script>
function borrar(id)
{
  if(confirm("¿Esta seguro de borrar esta fibra?"))
  {
       document.form1.borrar.value=id;
	   document.form1.submit();
   }
}
function exportar()
{
document.form1.action="exportar_historial.php";
document.form1.target="_blank"; 
document.form1.submit();
document.form1.action="";
document.form1.target=""; 
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
                <h1 class="page-header">Historial Rollos</h1>
            
                <form name="form1" id="form1"action="" method="post" class="margin-bottom" accept-charset="utf-8">                                                <div class="form-group">
              <div class="col-sm-6 col-md-4 col-lg-4">
                                <label for="guaranteed_length">Lote:</label>
                                <span class="col-sm-6 col-md-4 col-lg-4">
                                <input type="text" class="form-control" id="lote" name="lote"
                                       value="<?echo"$lote";?>"/ >
                  </span>              
			</div>
			 <div class="col-sm-6 col-md-4 col-lg-4">
                                <label for="guaranteed_length">Fibra:</label>
                                <span class="col-sm-6 col-md-4 col-lg-4">
                                <input type="text" class="form-control" id="fibra" name="fibra"
                                       value="<?echo"$fibra";?>"/ >
                  </span>              
			</div>
			 <div class="col-sm-6 col-md-4 col-lg-4">
                                <label for="guaranteed_length">MO:</label>
                                <span class="col-sm-6 col-md-4 col-lg-4">
                                <input type="text" class="form-control" id="mo" name="mo"
                                       value="<?echo"$mo";?>"/ >
                  </span>              
			</div>
			 <div class="col-sm-6 col-md-4 col-lg-4">
                                <label for="guaranteed_length">Desde:</label>
                                <input name="desde" type="text" class="form-control" id="desde"
                                       value="<?echo"$desde";?>" size="10" placeholder="Fecha Desde"  />
			 </div>
			 <div class="col-sm-6 col-md-4 col-lg-4">
                                <label for="guaranteed_length">Hasta:</label>
                                <input name="hasta" type="text" class="form-control" id="hasta"
                                       value="<?echo"$hasta";?>" size="10" placeholder="Fecha Hasta">
			 </div>
			
			 <div class="col-sm-6 col-md-4 col-lg-4">
                                <label for="guaranteed_length">Tipo Corte:</label>
                                <span class="col-sm-6 col-md-4 col-lg-4">
                                <select class="form-control" id="id_cut_type" name="id_cut_type" >
                                  <option value="0" selected="selected">--Selecciona--</option>
                                  <?	  
	$consulta  = "SELECT * FROM cut_type order by id";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	$count=1;
	while(@mysql_num_rows($resultado)>=$count)
	{
		$res=mysql_fetch_row($resultado);
		
		if($id_cut_type==$res[0])
			echo"<option value=\"$res[0]\" selected>$res[1] </option>";
		else
			echo"<option value=\"$res[0]\" >$res[1]</option>";
		$count=$count+1;
	}	
		
		?>
                                </select>
                                </span></div>
								
				<div class="col-sm-6 col-md-4 col-lg-4">
                                <label for="guaranteed_length">Operador:</label>
                                <span class="col-sm-6 col-md-4 col-lg-4">
                                <select class="form-control" id="operador" name="operador" >
                                  <option value="0" selected="selected">--Selecciona--</option>
                                  <?	  
	$consulta  = "SELECT id, first_name, last_name FROM users order by first_name";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	$count=1;
	while(@mysql_num_rows($resultado)>=$count)
	{
		$res=mysql_fetch_row($resultado);
		if($operador==$res[0])
			echo"<option value=\"$res[0]\" selected>$res[1] $res[2]</option>";
		else
			echo"<option value=\"$res[0]\" >$res[1] $res[2]</option>";
		$count=$count+1;
	}	
		
		?>
                                </select>
                                </span></div>				
                  <div class="col-sm-6 col-md-12 col-lg-3">
                                <input type="submit" class="btn red-submit button-form" name="buscar"
                                       value="Buscar"/>
                  <a href="javascript:exportar()" target="_blank"><img src="images/descarga.png" width="46" height="46" border="0" title="Exportar" /></a>                  </div>
					
                            <div class="clearfix"></div>
                        </div>

                    </form>                    </div>

        <div class="col-lg-12 table-responsive">
                                             <table class="table table-striped table-condensed grid">
                            <thead>
							<tr>
                            <th>MO</th>                  
                            <th>CN</th>
                            <th>Tipo de corte</th>                       
                            <th>Lugar</th>
                            <th>Posicion</th>
                            <th>Rollo</th>
							<th>Fibra</th>					
                            <th>Net</th>
                            <th>Gross</th>
                            <th>Total Used </th>
                           <th>Long</th>
							<th>Long. Defecto</th>
							<th>Long. Total</th>
							<th>Inicio</th>
							<th>Fin</th>
							<th>Operador</th>
							<th>Error</th>
							</tr>
                            </thead>
                            <tbody>

                            
                                        
	<?	  
if($_POST['buscar']!="")
{	
	if($_POST['lote']!="")
		$lote_b="and rolls.lote='".$_POST['lote']."'";
	else
		$lote_b="";	
	if($_POST['fibra']!="")
		$fibra_b="and rolls.fiber_id='".$_POST['fibra']."'";
	else
		$fibra_b="";
	if($_POST['desde']!="" && $_POST['hasta']!="")
		$fecha_b="and DATE_FORMAT(software_init, '%Y-%m-%d')>='".$desde."' and DATE_FORMAT(software_init, '%Y-%m-%d')<='".$hasta."'";
	else
		$fecha_b="";
	if($_POST['mo']!="")
		$mo_b="and cuts.mo='".$_POST['mo']."'";
	else
		$mo_b="";
	if($_POST['id_cut_type']!="0")
		$cut_b="and cuts.id_cut_type='".$_POST['id_cut_type']."'";
	else
		$cut_b="";
	if($_POST['operador']!="0")
		$operador_b="and cuts.prod_user_id='".$_POST['operador']."'";
	else
		$operador_b="";	
	$consulta="SELECT mo, cn, nombre,name, number, lote, fiber_type, FORMAT(retail_length,2) as retail_length, FORMAT(guaranteed_length/36,2) as guaranteed_length,FORMAT(balance/36,2) as balance, FORMAT(length_consumed/36,2) as length_consumed, FORMAT(length_defect/36,2) as length_defect,  hardware_init, hardware_end, status  ,cuts.id as cuts_id , users.first_name as nombre2 FROM cuts inner join cut_type on cut_type.id=cuts.id_cut_type inner join locations on cuts.location_assigned_id=locations.id left outer join location_capacities on cuts.number_position=location_capacities.id inner join rolls on rolls.id=cuts.roll_id inner join roll_fibers on rolls.fiber_id=roll_fibers.fiber_type inner join users on users.id=cuts.prod_user_id where cuts.deleted_at is null  $lote_b $fibra_b $fecha_b $mo_b $cut_b $operador_b order by hardware_end desc";
	//echo"$consulta";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	while($res=mysql_fetch_assoc($resultado))
	{	
		$totalused=$res['length_consumed']+$res['length_defect'];
		?>
							<tr>
                                    <td><? echo $res['mo']?></td>
                                 
                                    <td><? echo $res['cn']?></td>
                                    <td><? echo $res['nombre']?></td>
                                    <td><? echo $res['name']?></td>
                                    <td><? echo $res['number']?></td>
                                    <td><? echo $res['lote']?></td>
									<td><? echo $res['fiber_type']?></td>
                                    <td><? echo $res['guaranteed_length']?></td>
                                    <td><? echo $res['retail_length']?></td>
                                    <td><? echo $res['balance']?> </td>
									<td><? echo $res['length_consumed']?></td>
									<td><? echo $res['length_defect']?></td>
									<td><? echo $totalused?></td>
									<td><? echo $res['hardware_init']?></td>
									<td><? echo $res['hardware_end']?></td>
                                    

                                    <td><? echo $res['nombre2']?></td>
                                    <td <? if($res['status']==4)echo"bgcolor=\"#FF0000\"";?> class="text-center"><a href="editar_corte_prod.php?id=<? echo $res['cuts_id']; ?>" class="iframe3"><i class="fa fa-pencil-square-o"></i></a></td>
                              </tr>
                                       <? }}?>
									   </tbody>                     
                                                    </table>
      </div>

    </div>
</div><footer>
   
    <script src="public/js/bootstrap/bootstrap.min.js"></script>
    <script src="public/js/metisMenu/metisMenu.min.js"></script>
    <script src="public/js/sb-admin-2/sb-admin-2.js"></script>
    <script src="public/js/jquery-ui.min.js"></script>
   
   
    
    
    
   
   



   
</footer>
</body>
</html>