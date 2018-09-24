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
    <title>Zodiac - Lugares</title>
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
<script>
        function textAreaAdjust(o) {
            o.style.height = "1px";
            o.style.height = (25+o.scrollHeight)+"px";
        }
    </script>
<?
$id=$_GET['id'];




$guardar= $_POST["guardar"];
if($guardar=="Guardar")  
{
	
	$lugar= $_POST["lugar"];
	$capacity= $_POST["capacity"];
	$capacity2= $_POST["capacity2"];
	$estatus= $_POST["estatus"];
	$visible= $_POST["visible"];
	$cuantos=$capacity-$capacity2;
	$id=$_POST['id'];
	if($id!="")
	$consulta  =  "update locations set name='$lugar', capacity='$capacity', updated_at= now(), estatus=$estatus, visible='$visible' where id=$id";
	else
	$consulta  =  "insert into locations(name, capacity, created_at, estatus) values('$lugar','$capacity', now(), $estatus)";
	$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
	$id_loca = mysql_insert_id();
	//se agrego el for
	for ($i=1;$i<=$capacity;$i++){
	 $consulta2  =  "insert into location_capacities(id_location, number, created_at) values('$id_loca', '$i', now())";
	 $resultado2 = mysql_query($consulta2) or die("Error en operacion2: $consulta2 " . mysql_error());
	}
	if($id!=""){
	echo"$cuantos";
		if($cuantos!=0)
		{
			if($cuantos<0)//quitar
			{
				for ($i=$capacity+1;$i<=$capacity2;$i++){
				 $consulta2  =  "delete from location_capacities where id_location=$id and number=$i";
				 //echo"$consulta2"; 
				 $resultado2 = mysql_query($consulta2) or die("Error en operacion2: $consulta2 " . mysql_error());
				}
			}else
			{
				if($cuantos>0)//poner
				{
					for ($i=$capacity2+1;$i<=$capacity;$i++){
					 $consulta2  =  "insert into location_capacities(id_location, number, created_at) values('$id', '$i', now())";
					// echo"$consulta2";
					 $resultado2 = mysql_query($consulta2) or die("Error en operacion2: $consulta2 " . mysql_error());
					}
				}
			}
		}
	}
	
	//echo"<script>alert(\"$cuantos Posiciones Agregadas\");</script>";
	//out.println(listGStr);
	
	
	if($id!="")
	echo"<script>alert(\"Lugar Cambiado\");</script>";
	else
	echo"<script>alert(\"Lugar Agregado\");</script>";
	
	$id="";
	/*echo"<script>parent.tb_remove(); parent.location=\"adm_planes.php\"</script>";*/
}	
$borrar= $_POST["borrar"];
if($borrar!="")  
{
	
	

	$consulta  =  "update locations set deleted_at=now() where id=$borrar";
	//out.println(listGStr);
	$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
	$consulta  =  "update location_capacities set deleted_at=now() where id_location=$borrar";
	//out.println(listGStr);
	$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
	
	echo"<script>alert(\"Lugar Borrado\");</script>";
	
	/*echo"<script>parent.tb_remove(); parent.location=\"adm_planes.php\"</script>";*/
}	
if($id!="")
{
	$consulta  = "SELECT *  FROM locations where id='".$_GET['id']."' ";

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
  if(confirm("¿Esta seguro de borrar este lugar?"))
  {
       document.form1.borrar.value=id;
	   document.form1.submit();
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
                <h1 class="page-header">Lugares</h1>
            
                <form action="" method="post" name="form1" class="margin-bottom" id="form1" accept-charset="utf-8">                                                
                  <div class="form-group">
                            
						<div class="col-sm-6 col-md-4 col-lg-4">
                                <label for="remaining_inches">Lugar:</label>
                                <input name="id" type="hidden" id="id" value="<?echo"$id";?>">
                                <input type="text" class="form-control" id="lugar" name="lugar"
                                       value=""/ required>
                  </div>
				  <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="remaining_inches">Capacidad:</label>
                                <input name="borrar" type="hidden" id="borrar">
                                <input name="capacity2" type="hidden" id="capacity2">
                                <input type="number" class="form-control" id="capacity" name="capacity" step="1" min="1"
                                       value=""/ required>
                  </div>
				   <div class="col-sm-6 col-md-4 col-lg-4">
                                <label for="fiber_id">Estatus:</label>
                                
                                <select class="form-control" id="estatus" name="estatus">
								<option value="" >--Selecciona Bloqueo--</option>
								<option value="1" >Bloqueo Activo</option>
								<option value="0" >Bloqueo Inactivo</option>
                     </select>
                    </div>
					 <div class="col-sm-6 col-md-4 col-lg-4">
                                <label for="fiber_id">Visible:</label>
                                
                                <select class="form-control" id="visible" name="visible">
								<option value="" >--Selecciona--</option>
								<option value="1" >Visible</option>
								<option value="0" >No Visible</option>
                     </select>
                    </div>
                            
                            <div class="col-sm-6 col-md-12 col-lg-3">
                                <input type="submit" class="btn red-submit button-form" name="guardar"
                                       value="Guardar"/>
                            </div>
                            <div class="clearfix"></div>
                  </div>

          </form>                    </div>

        <div class="col-lg-12 table-responsive">
                                            <table class="table table-striped table-condensed">
                    <thead>
                    <tr><th>Lugar</th>
					<th><div align="center">Capacidad</div></th>
                   
                    <th><div align="center">Estatus</div></th>
                    <th><div align="center">Visible</div></th>
                    <th><div align="center">Editar</div></th>
                    <th><div align="center">Eliminar</div></th>
                    </thead>
                    <tbody>
<?	  
	$consulta  = "SELECT id, name, capacity, ip,estatus, visible FROM locations where deleted_at is null order by name";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	$count=1;
	while(@mysql_num_rows($resultado)>=$count)
	{
		$res=mysql_fetch_row($resultado);
		
		
		?>
		 <tr>
			<td><? echo"$res[1]"; ?></td>
			<td><div align="center"><? echo"$res[2]"; ?></div></td>
			<td class="text-center"><? if($res[4]=="0")echo"Inactivo"; else echo"Activo"?></td>
			<td class="text-center"><? if($res[5]=="0")echo"No visible"; else echo"Visible"?></td>
			<td class="text-center"><a href="lugares.php?id=<? echo"$res[0]"; ?>"><i class="fa fa-pencil-square-o"></i></a></td>
			<td class="text-center"><a href="javascript:borrar('<? echo"$res[0]"; ?>')"><i class="fa fa-times"></i></a></td>
		</tr>
		<?
		$count=$count+1;
	}	
		
		?>
                                        </tbody>
                </table>
      </div>

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
	document.form1.lugar.value='<? echo"$res8[1]";?>';
	document.form1.capacity.value='<? echo"$res8[2]";?>';
	document.form1.capacity2.value='<? echo"$res8[2]";?>';
	document.form1.estatus.value='<? echo"$res8[9]";?>';
	document.form1.visible.value='<? echo"$res8[10]";?>';
	
	

<? }?>
    </script>
	
</footer>
</body>
</html>