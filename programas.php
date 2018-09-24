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
		$(".iframe3").colorbox({iframe:true,width:"420", height:"430",transition:"fade", scrolling:true, opacity:0.7});
		$("#click").click(function(){ 
		$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
			return false;
		});
	});

	function cerrarV(){
		$.fn.colorbox.close();
	}
function abrir()
{
	if(document.form1.id_usuario.value>0){
$.colorbox({iframe2:true,href:"nominar.php?id="+document.form1.id_usuario.value,width:"675", height:"400",transition:"fade", scrolling:true, opacity:0.7});
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
$id=$_GET['id'];
$guardar= $_POST["guardar"];
if($guardar=="Guardar")  
{
	
	$name= $_POST["name"];
	
	
	$id=$_POST['id'];
	if($id!="")
		$consulta  =  "update programas set nombre='$name', updated_at=now() where id=$id";
	else
		$consulta  =  "insert into programas(nombre, created_at) values('$name', now())";
	//out.println(listGStr);
	$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
	
	if($id!="")
	echo"<script>alert(\"Programa Cambiado\");</script>";
	else
	echo"<script>alert(\"Programa Agregado\");</script>";
	
	/*echo"<script>parent.tb_remove(); parent.location=\"adm_planes.php\"</script>";*/
}	
$borrar= $_POST["borrar"];
if($borrar!="")  
{
	
	

	$consulta  =  "update programas set deleted_at=now() where id=$borrar";
	//out.println(listGStr);
	$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
	
	
	echo"<script>alert(\"Bodega Borrada\");</script>";
	
	/*echo"<script>parent.tb_remove(); parent.location=\"adm_planes.php\"</script>";*/
}	
if($id!="")
{
	$consulta  = "SELECT *  FROM programas where id='".$_GET['id']."' ";

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
                <h1 class="page-header">Programas</h1>
            
                <form action="" method="post" name="form1" class="margin-bottom" id="form1" accept-charset="utf-8">                                                
                  <div class="form-group">
                            
						<div class="col-sm-6 col-md-4 col-lg-4">
                                <label for="remaining_inches">Programa:</label>
                                <input name="id" type="hidden" id="id" value="<?echo"$id";?>">
                                <input type="text" class="form-control" id="name" name="name"
                                       value=""/ required><input name="borrar" type="hidden" id="borrar">
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
                    <tr><th width="29%">Programa</th>
					
                   

                      <th width="28%"><div align="center">Editar Partes</div></th>
                      <th width="19%"><div align="center">Editar</div></th>
                    <th width="24%"><div align="center">Eliminar</div></th>
                    </thead>
                    <tbody>
<?	  
	$consulta  = "SELECT id, nombre FROM programas where deleted_at is null order by nombre";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	$count=1;
	while(@mysql_num_rows($resultado)>=$count)
	{
		$res=mysql_fetch_row($resultado);
		
		
		?>
		 <tr>
			<td><? echo"$res[1]"; ?></td>
			
			<td class="text-center"><a href="programa_parte.php?prog=<? echo"$res[0]"; ?>" class="style1 iframe3">Editar Partes</a></td>
			<td class="text-center"><a href="programas.php?id=<? echo"$res[0]"; ?>"><i class="fa fa-pencil-square-o"></i></a></td>
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
    <!--<script src="public/js/jquery.min.js"></script>este-->
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