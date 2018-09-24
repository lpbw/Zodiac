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
$guardar= $_POST["guardar"];
if($guardar=="Guardar")  
{			

		/*if($_POST["roll_id"]>0){$rollo=$_POST["roll_id"];}else{ 
			
				$consulta6="select * from rolls where fiber_id='".$_POST["fibra_id"]."' and location_id='".$_POST["location_assigned_id"]."' and location_slot='".$_POST["number_position"]."'";
				$resultado6 = mysql_query($consulta6) or die("Error en operacion1: $consulta6 " . mysql_error());
				$res6=mysql_fetch_assoc($resultado6);
				$rollo=$res6['id'];
			}
			
		$consulta5="select sum(length_measured) as sum from cuts where roll_id=$rollo and status=0 and deleted_at is null ";
		$resultado5 = mysql_query($consulta5) or die("Error en operacion1: $consulta5 " . mysql_error());
		$res5=mysql_fetch_assoc($resultado5);
	*/
		$dato=explode("|",$_POST["number_position"]);
		$rollo=$dato[3];
		
		/*$consulta="select * from rolls where id=$rollo";
		$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
		$res=mysql_fetch_assoc($resultado);
		$total=$res['remaining_inches']-$res5['sum'];
		$actual_location=$res['location_id'];
		$actual_slot=$res['location_slot'];
		if($_POST["length_measured"]<=$total){
		*/
		//calcula orden de produccion consecutivo
			
			$posi=$dato[0];
			if($posi!="0")
			{
				$consulta6="select max(orden) as orden from cuts where location_assigned_id=$posi and status<3 and deleted_at is null ";
				$resultado6 = mysql_query($consulta6) or die("Error en operacion1: $consulta6 " . mysql_error());
				$res6=mysql_fetch_assoc($resultado6);
				$orden=$res6['orden'];
				if($orden>0)
					$orden=$orden+1;
				else
					$orden=1;
			}
			else
			{
				$orden=0;
			}
		/// calcular CN
		$mes=intval(date("m"));
		$consulta="select siguiente, mes from programas where id=".$_POST["id_programa"]." and deleted_at is null";
		$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
		$res=mysql_fetch_assoc($resultado);
		if($mes!=$res['mes']) // si cambio el mes
		{
			$cn=date("m")."01";
			$consulta  =  "update programas set siguiente=2, mes=$mes where id=".$_POST["id_programa"];
			$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
		}else // si es el mismo mes
		{
			if($res[siguiente]<10)
				$cn=date("m")."0".$res[siguiente];
			else
				$cn=date("m").$res[siguiente];
			$consulta  =  "update programas set siguiente=siguiente+1 where id=".$_POST["id_programa"];
			$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
		}
		
		
		
		
		
			$consulta2  =  "insert into cuts(mo, cn, roll_id, user_id, location_assigned_id, number_position, orden, length_measured, created_at, id_cut_type, id_programa, parte) values('".$_POST["mo"]."', '".$cn."', '$rollo', $idU, '".$_POST["location_assigned_id"]."', '".$dato[0]."', ".$orden.",  '".$_POST["length_measured"]."', now(), '".$_POST["id_cut_type"]."', '".$_POST["id_programa"]."', '".$_POST["parte"]."')";
			$resultado2 = mysql_query($consulta2) or die("Error en operacion1: $consulta2 " . mysql_error());
			
					
			echo"<script>alert(\"Corte Agregado con CN= $cn\");</script>";
		/*}else{
			echo"<script>alert(\"Corte es demasiado grande\");</script>";
		}*/
	/*echo"<script>parent.tb_remove(); parent.location=\"adm_planes.php\"</script>";*/
}	
$borrar= $_POST["borrar"];
if($borrar!="")  
{
	
	

	$consulta  =  "update cuts set deleted_at=now() where id=$borrar";
	//out.println(listGStr);
	$resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
	
	
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

</script>
</head>
<body onLoad="timer = setTimeout('auto_reload()',15000);">
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
                <h1 class="page-header">Ordenes Terminadas </h1>
                <form action="" method="post" name="form1" class="margin-bottom" id="form1" accept-charset="utf-8">                        
                       
                            

                </form>            
                <table class="table table-striped table-condensed grid">
                            <thead>
							<tr>
                            <th>MO</th>                  
                            <th>CN</th>
                            <th>Operador</th> 
							<th>Tipo de corte</th>                       
                            <th>Lugar</th>
                            <th>Posicion</th>
                            <th>Rollo</th>
							<th>Fibra</th>					
                            <th>Long. Restante</th>
                           <th>Long</th>
							<th>Long. Defecto</th>
							<th>Inicio</th>
							<th>Fin</th>
							<th>Shorts</th>
							<th>Pausas</th>
							<th>Error</th>
							</tr>
                            </thead>
                            <tbody>

                            
                                        
	<?	  
	$consulta  = "SELECT *  FROM cuts where deleted_at is null and location_assigned_id=$locationU and status<3 order by orden";
	$consulta="SELECT mo, cn,nombre,name, number, lote,fiber_type,FORMAT(remaining_inches/36,2) as remaining_inches,FORMAT(length_consumed/36,2) as length_consumed , FORMAT(length_defect/36,2) as  length_defect, hardware_init, hardware_end , status, cuts.id as cuts_id, users.first_name as nombre2 , pausa FROM cuts inner join cut_type on cut_type.id=cuts.id_cut_type left outer join locations on cuts.location_assigned_id=locations.id left outer join location_capacities on cuts.number_position=location_capacities.id inner join rolls on rolls.id=cuts.roll_id inner join roll_fibers on rolls.fiber_id=roll_fibers.fiber_type inner join users on users.id=cuts.prod_user_id where cuts.deleted_at is null  and status>=3   order by hardware_end desc limit 1, 50"; //and DATE_FORMAT(software_init, '%Y-%m-%d')=curdate()
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	while($res=mysql_fetch_assoc($resultado))
	{	
		?>
							<tr>
                                    <td><? echo $res['mo']?></td>
                                 
                                    <td><? echo $res['cn']?></td>
                                    <td><? echo $res['nombre2']?></td>
									<td><? echo $res['nombre']?></td>
                                    <td><? echo $res['name']?></td>
                                    <td><? echo $res['number']?></td>
                                    <td><? echo $res['lote']?></td>
									<td><? echo $res['fiber_type']?></td>
                                    <td><? echo $res['remaining_inches']?></td>
									<td><? echo $res['length_consumed']?></td>
									<td><? echo $res['length_defect']?></td>

									<td><? echo $res['hardware_init']?></td>
									<td><? echo $res['hardware_end']?></td>
                                    

                                    <td  class="text-center"><a href="editar_shorts_prod_adm.php?id=<? echo $res['cuts_id']; ?>" ><i class="fa fa-pencil-square-o"></i></a></td>
                                    <td  class="text-center" <? if($res['pausa']==1)echo"bgcolor=\"#FFFF66\"";?>><a href="editar_pausa_prod_adm.php?id=<? echo $res['cuts_id']; ?>" ><i class="fa fa-pencil-square-o"></i></a></td>
                                    <td <? if($res['status']==4)echo"bgcolor=\"#FF0000\"";?> class="text-center"><a href="editar_corte_prod.php?id=<? echo $res['cuts_id']; ?>" class="iframe3"><i class="fa fa-pencil-square-o"></i></a></td>
                              </tr>
                                       <? }?>
									   </tbody>                     
                                                    </table>


            </div>
        </div>
    </div>
</div><footer>
   <!-- <script src="public/js/jquery.min.js"></script>-->
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
	function auto_reload()
		{
			window.location = 'terminadas.php';
		}	
    </script>
</footer>
</body>
</html>