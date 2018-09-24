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
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
		 
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
	
	$parte= $_POST["name"];
	$producto= $_POST["producto"];
	
	$id=$_POST['id'];
	if($id!="")
	{
	$consulta  =  "update parte set parte='$parte', producto='$producto' where id=$id";
	}
	else
	$consulta  =  "insert into parte(parte, producto, created_at) values('$parte', '$producto', now())";
	//out.println(listGStr);
	$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
	
	if($id!="")
	{
	echo"<script>alert(\"Parte Cambiada\");</script>";
	$id= "";
	
	}
	else
	echo"<script>alert(\"Parte Agregada\");</script>";
	
	/*echo"<script>parent.tb_remove(); parent.location=\"adm_planes.php\"</script>";*/
}	
$borrar= $_POST["borrar"];
if($borrar!="")  
{
	
//if(confirm("Esta seguro de borrar esta parte?"))
 // {	

	$consulta  =  "update parte set deleted_at=now() where id='$borrar'";
	//out.println(listGStr);
	$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
	
	
	echo"<script>alert(\"Bodega Borrada\");</script>";
//}	
	/*echo"<script>parent.tb_remove(); parent.location=\"adm_planes.php\"</script>";*/
}	
if($id!="")
{
	$consulta  = "SELECT *  FROM parte where id='".$_GET['id']."' ";

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
  if(confirm("¿Esta seguro de borrar este programa?"))
  {
       document.form1.borrar.value=id;
	   document.form1.submit();
   }
}
</script>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
body {
	background-color: #3B3B3D;
}
-->
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
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
                <h1 class="page-header">Numero de Parte </h1>
            
                <form action="" method="post" name="form1" class="margin-bottom" id="form1" accept-charset="utf-8">                                                
                  <div class="form-group">
                            
						<div class="col-sm-6 col-md-4 col-lg-4">
                                <label for="remaining_inches">Numero de Parte :</label>
                                <input name="id" type="hidden" id="id" value="<? echo $id; ?>">
                                <input type="text" class="form-control" id="name" name="name"
                                       value=""/ required>
                  </div>
				  <div class="col-sm-6 col-md-4 col-lg-4">
                                <label for="remaining_inches">Descripción del Producto :</label>
                                <input type="text" class="form-control" id="producto" name="producto"
                                       value=""/ required><input name="borrar" type="hidden" id="borrar" value="">
                  </div>
				 
                            
                            <div class="col-sm-6 col-md-12 col-lg-3">
                                <input type="submit" class="btn red-submit button-form" name="guardar"
                                       value="Guardar"/>
                            </div>
                            <div class="clearfix"></div>
                  </div>

          </form>                    </div>

        <div class="col-lg-12 table-responsive">
		<form action="" method="post" name="form2"  id="form2" accept-charset="utf-8">
                                            <table class="table table-striped table-condensed">
                    <thead>
                    <tr><th><div align="right"></div></th>
					  <th>&nbsp;</th>
					  <th colspan="2">
					    <div >
					      <input name="id_parte" type="text" class="form-control" id="id_parte" value="<? echo $_POST['id_parte'];?>">
			            </div></th>
					  <th><div align="left"><span class="col-sm-6 col-md-12 col-lg-3">
					    <input type="submit" class="btn red-submit button-form" name="buscar"
                                       value="Buscar"/>
				      </span></div></th>
					  </thead>
					 <thead>
                    <th>Numero de parte</th>
					 <th>Producto</th>
					  <th>Fibras</th>
					  
                   

                    <th><div align="center">Editar</div></th>
                    <th><div align="center">Eliminar</div></th>
                    </thead>
                    <tbody>
<?	  
	if($_POST['buscar']!="Buscar")
	{
	$consulta  = "SELECT id, parte, producto FROM parte where deleted_at is null order by parte";
	}
	else
	$consulta  = "SELECT id, parte, producto FROM parte where parte like'%".$_POST['id_parte']."%' and deleted_at is null order by parte";
	
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	$count=1;
	while(@mysql_num_rows($resultado)>=$count)
	{
		$res=mysql_fetch_row($resultado);
		
		
		?>
		 <tr>
			<td><? echo"$res[1]"; ?></td>
			<td><? echo"$res[2]"; ?></td>
			<td><a href="parte_fibra.php?parte=<? echo"$res[1]"; ?>" class="style1 iframe3">Editar Fibras</a></td>
			
			<td class="text-center"><a href="partes.php?id=<? echo"$res[0]"; ?>" ><i class="fa fa-pencil-square-o"></i></a></td>
			<td class="text-center"><a href="javascript:borrar('<? echo"$res[0]"; ?>')"><i class="fa fa-times"></i></a></td>
		</tr>
		<?
		$count=$count+1;
	}	
		
		?>
                                        </tbody>
                </table>
				</form>
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
	document.form1.producto.value='<? echo"$res8[2]";?>';
	
	

<? }?>	
    </script>
</footer>
</body>
</html>