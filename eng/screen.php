<?
session_start();
include "coneccion.php";

$idU=$_SESSION['idU'];
$nombreU=$_SESSION['nombreU'];
$tipoU=$_SESSION['tipoU'];
$locationU=$_SESSION['location'];
$dia_semana=date(N)+1;
if($dia_semana==8)
	$dia_semana=1;
	// buscar condicion si es despues de las 12 y antes de las 12:30 tomar el dia anterior
$consultaT  = "SELECT numero, FORMAT(TIME_TO_SEC(timediff(curtime(), inicio))/60,0) as d1, inicio, fin FROM turnos where now()>inicio and now()<fin and dias like '%".$dia_semana."%'";// 

$resultadoT = mysql_query($consultaT) or die("La consulta fall&oacute;P1: $consultaT " . mysql_error());
if(@mysql_num_rows($resultadoT)>0)
{
	$resT=mysql_fetch_row($resultadoT);
	$turno=$resT[0];
	$total_turno=$resT[1];
	$inicio_t=$resT[2];
	$fin_t=$resT[3];
 }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
		 
 
  
<script>
        function textAreaAdjust(o) {
            o.style.height = "1px";
            o.style.height = (25+o.scrollHeight)+"px";
        }
		
    </script>
<?

?>

<script type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<script async src="//jsfiddle.net/pmw57/tzYbU/205/embed/"></script>
<style type="text/css">
<!--
a {color: #FFFFFF; }
body {
	background-color: #000000;
}
.style2 {font-size: 24px}
.style7 {font-size: 24px; font-weight: bold; }
.style10 {font-size: 24px; color: #000000; font-weight: bold; }
.style11 {color: #000000}
.style12 {font-size: 36px}
.style13 {color: #FFFFFF}
-->
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="refresh" content="15"></head>
<body >
<div id="wrapper">
    <!-- Navigation onLoad="timer = setTimeout('auto_reload()',15000);"-->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>        </button>
        <a class="navbar-brand" href=""><img class="img-responsive" src="public/images/zodiac.jpg" alt="zodiac logo"/></a>
    </div>
    <!-- /.navbar-header -->
    <? 
	//if($tipoU!="3")
	//	include "menu_f.php"
	//else
		include "menu_s.php"
	?>
    <!-- /.navbar-static-side -->
</nav>
    <div >
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"><span class="huge style13">FSA CONTROL DASHBOARD</span>
                <? //echo"$dia_semana";?></h1>
                <form action="" method="post" name="form1" id="form1">
                           
              <div class="col-lg-12 table-responsive" id="d_pendientes">
			  
                                                                    <table class="table table-striped table-condensed grid">
                            <thead>
							<tr>
                            <th width="7%" height="40"><span class="style12">Machine</span></th>
                           
                            <th width="7%"><span class="style12">Status</span></th>
                            <th width="4%">&nbsp;</th>
                            <th width="20%"><span class="style12">Operator</span></th>
                            <th width="9%"><div align="center"><span class="style12">MO</span></div></th>
                            <th width="16%"><span class="style12">Part Num.  / Program </span></th>
                            <th width="8%"><div align="center"><span class="style12">Run Time  </span></div></th>
                            <th width="6%"><div align="center"><span class="style12">R.T.<br /> 
                            MO </span></div></th>
                            <th width="6%"><div align="center"><span class="style12">Downtime MO  </span></div></th>
                            <th width="8%"><div align="center"><span class="style12">Brake</span></div></th>
                            <th width="8%"><div align="center"><span class="style12">Downtime</span> </div></th>
                            </tr>
                            </thead>
                            <tbody>

                            
                                        
	<?	
	$contado=0;  
	$consulta  = "SELECT locations.id, locations.name, upper(users.first_name) as first_name, upper(users.last_name) as last_name, estatus  FROM locations left outer join users on locations.logged=users.id where locations.deleted_at is null and locations.visible=1 order by locations.name ";
	
	//echo"$consulta";
	
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	while($res=mysql_fetch_assoc($resultado))
	{	
		$bpass=$res['estatus'];
		$consulta4  = "SELECT sum(TIMESTAMPDIFF(MINUTE, inicio, fin)) as d1  FROM cut_pause where location_id=".$res['id']." and razon_id=1 and fin is not null and DATE(inicio)=DATE(now()) and turno=$turno group by location_id";
		//echo $consulta4;
		$resultado4 = mysql_query($consulta4) or die("La consulta fall&oacute;P1: " . mysql_error());
		if($res4=mysql_fetch_assoc($resultado4))
		{
			$tiempo_comida=$res4['d1'];
			
		}else
		{
			$tiempo_comida="0";
		}
		$consulta4  = "SELECT sum(TIMESTAMPDIFF(MINUTE, inicio, fin)) as d1  FROM cut_pause where location_id=".$res['id']." and razon_id<>1 and fin is not null and DATE(inicio)=DATE(now()) and turno=$turno group by location_id";
		//echo $consulta4;
		$resultado4 = mysql_query($consulta4) or die("La consulta fall&oacute;P1: " . mysql_error());
		if($res4=mysql_fetch_assoc($resultado4))
		{
			$tiempo_paro=$res4['d1'];
			
		}else
		{
			$tiempo_paro="0"; // tiempo de paro que no es comida ya concluido
		}
		
		/*$consulta4  = "SELECT sum(TIMESTAMPDIFF(MINUTE, hardware_init, hardware_end)) as d1  FROM cuts where location_assigned_id=".$res['id']."  and software_end is not null and DATE(software_init)=DATE(now()) and turno=$turno group by location_assigned_id";
		//echo $consulta4;
		$resultado4 = mysql_query($consulta4) or die("La consulta fall&oacute;P1: " . mysql_error());
		if($res4=mysql_fetch_assoc($resultado4))
		{
			$tiempo_activo_total=$res4['d1'];
			//echo"pausa=".$pausa;
		}else
		{
			$tiempo_activo_total="";
		}*/
		//busca paro actual y muestra estatus y triempo estatus
		$consulta4  = "SELECT TIMESTAMPDIFF(MINUTE, inicio, now()) as d1, razon_id,reason,autorization  FROM cut_pause left outer join down_time_reason on cut_pause.razon_id=down_time_reason.id where location_id=".$res['id']." and razon_id<>1 and fin is  null and DATE(inicio)=DATE(now()) and turno=$turno ";
		//echo $consulta4;
		$resultado4 = mysql_query($consulta4) or die("La consulta fall&oacute;P1: " . mysql_error());
		if($res4=mysql_fetch_assoc($resultado4))
		{
			$tiempo_paro_parcial=$res4['d1'];
			$estatus_paro=$res4['razon_id'];
			$autorization=$res4['autorization'];
			$razon=$res4['reason'];
			//echo"pausa=".$pausa;
		}else
		{
			$tiempo_paro_parcial="";
			$autorization="";
			$estatus_paro="";
			$razon="";
		}
		$consulta4  = "SELECT TIMESTAMPDIFF(MINUTE, inicio, now()) as d1, razon_id,reason,autorization  FROM cut_pause inner join down_time_reason on cut_pause.razon_id=down_time_reason.id where location_id=".$res['id']." and razon_id=1 and fin is  null and DATE(inicio)=DATE(now()) and turno=$turno ";
		//echo $consulta4;
		$resultado4 = mysql_query($consulta4) or die("La consulta fall&oacute;P1: " . mysql_error());
		if($res4=mysql_fetch_assoc($resultado4))
		{
			$tiempo_paro_parcial_comida=$res4['d1'];
			
			//echo"pausa=".$pausa;
		}else
		{
			$tiempo_paro_parcial_comida="0";
			
		}
		//$tiempo_activo_total=$tiempo_activo_total-$tiempo_paro-$tiempo_comida; // falta sumar orden actual abierta tiempo bueno y restar el muerto actual de la orden
		
		$consulta2  = "SELECT cuts.id,mo, cn, cut_type.nombre, length_measured, locations.name, location_capacities.number, rolls.lote, roll_fibers.fiber_type, rolls.remaining_inches, cuts.status, cuts.parte,cuts.length_consumed, cuts.length_defect,DATE_FORMAT(date_lote, '%m-%d-%Y'), programas.nombre as prog, TIMESTAMPDIFF(MINUTE, cuts.hardware_init, now()) as d1, TIMESTAMPDIFF(MINUTE, cuts.hardware_init, cuts.hardware_end) as d2, cuts.hardware_init, cuts.hardware_end, users.first_name, users.last_name  FROM cuts inner join cut_type on cut_type.id=cuts.id_cut_type inner join locations on cuts.location_assigned_id=locations.id left outer join location_capacities on cuts.number_position=location_capacities.id inner join rolls on rolls.id=cuts.roll_id inner join roll_fibers on cuts.fiber_id=roll_fibers.fiber_type left outer join programas on cuts.id_programa=programas.id left outer join users on locations.logged=users.id where cuts.deleted_at is null and cuts.location_assigned_id=".$res['id']." and cuts.orden=1 and cuts.status<>0 ";
	
		//echo"$consulta2";
		$resultado2 = mysql_query($consulta2) or die("La consulta fall&oacute;P1: " . mysql_error());
		if($res2=mysql_fetch_assoc($resultado2))
		{
			$pausa=0;
			$pausa2=0;
			if($res2['status']==0)
			{
				$estatus="INACTIVE";
				$color="#FF0000";
			}
			else if($res2['status']==1)
			{
				$estatus="RUNNING";
				$color="#33FF00";
			}
			else
			{
				$estatus="IDLE";
				$color="#FFFF00";
			}
			
			$consulta4  = "SELECT sum(TIMESTAMPDIFF(MINUTE, inicio, fin)) as d1  FROM cut_pause where id_cut=".$res2['id']."  and fin is not null group by id_cut";
			//echo $consulta4;
			$resultado4 = mysql_query($consulta4) or die("La consulta fall&oacute;P1: " . mysql_error());
			while($res4=mysql_fetch_assoc($resultado4))
			{
				$pausa=$res4['d1']; //pausas terminadas de este corte
				//echo"pausa=".$pausa;
			}	
			
			$consulta4  = "SELECT TIMESTAMPDIFF(MINUTE, inicio, now()) as d1  FROM cut_pause where id_cut=".$res2['id']."  and fin is null";
			$resultado4 = mysql_query($consulta4) or die("La consulta fall&oacute;P1: " . mysql_error());
			if($res4=mysql_fetch_assoc($resultado4))
			{
				$pausa2=$res4['d1']; //pausa actual hasta el momento
				//echo"pausa2=".$pausa2;
			}else
				$pausa2=0;
			/*if($res2['hardware_init']=='')
			{
				//echo"entra0".$res2['hardware_init'];
				$tiempo_activo="0";
				$tiempo_muerto="0";
				$consulta4  = "SELECT TIMESTAMPDIFF(MINUTE, inicio, fin) as d1  FROM cut_pause where location_id=".$res2['id']." and razon_id<>1 and fin is null and DATE(inicio)=DATE(now()) and turno=$turno group by location_id";
		//echo $consulta4;
				$resultado4 = mysql_query($consulta4) or die("La consulta fall&oacute;P1: " . mysql_error());
				while($res4=mysql_fetch_assoc($resultado4))
				{
					$tiempo_muerto=$res4['d1'];//tiempo difernte a comida
					//echo"pausa=".$pausa;
				}
			}*/
			if($res2['hardware_end']=="")//si el corte actual no ha terminado
			{
				//echo"entra1";
				$tiempo_activo_mo=$res2['d1'];
				$tiempo_muerto=$pausa+$pausa2;
				//$tiempo_activo=$res2['d1']-$tiempo_muerto;
				
			}else if($res2['hardware_end']!="") // si el corte actual termino
			{
				//echo"entra2";
				$tiempo_muerto=$pausa+$pausa2;
				//$tiempo_activo=$res2['d2']-$tiempo_muerto;
				
			}
			$tiempo_activo_total=$total_turno-$tiempo_comida-$tiempo_paro-$tiempo_paro_parcial-$tiempo_paro_parcial_comida;
		?>
							<tr>
                                    <td height="40" class="style2"><span class="style7"><? echo $res['name']?></span></td>
                                 
                                    <td height="40" class="style2"><div align="center"><span class="style7"><? echo $estatus?></span></div></td>
                                    <td height="40" class="style2"><table width="100%" border="0" bgcolor="#FF0000">
                                      <tr>
                                        <td height="40" bgcolor="<? echo"$color";?>" class="style2">&nbsp;</td> 
                                      </tr>
                                    </table></td>
                                    <td height="40" class="style2"><span class="style7"><? echo $res['first_name'] ?> <? echo $res['last_name'] ?></span></td>
                                    <td height="40" class="style2"><div align="center" class="style2"><strong>
                                    <? if($bpass==0){?>
                                    <img src="images/bypass.png" width="50" height="32" />
                                    <? }?>
                                    <? echo $res2['mo']?></strong></div></td>

                                    <td height="40" class="style2"><span class="style7"><? echo $res2['parte']?> / <? echo $res2['prog']?></span></td>
                                


                                    <td height="40" class="style2"><div align="center" class="style2">
                                      <div align="right"><strong><? echo $tiempo_activo_total?> MIN</strong></div>
                                    </div></td>
                                    <td height="40" class="style2"><div align="center" class="style2">
                                      <div align="right"><strong><? echo $tiempo_activo_mo?> MIN</strong></div>
                                    </div></td>
                                    <td height="40" class="style2"><div align="center" class="style2">
                                      <div align="right"><strong><? echo $tiempo_muerto?> MIN</strong></div>
                                    </div></td>
							        <td height="40" class="style2"><div align="center" class="style2">
							          <div align="right"><strong><? echo $tiempo_comida?> MIN</strong></div>
							        </div></td>
							        <td height="40" class="style2"><div align="center" class="style2">
							          <div align="right"><strong><? echo $tiempo_paro?> MIN</strong></div>
							        </div></td>
					          </tr>
                                    <?  
						}else
						{
							if($autorization!="1"){
							$tiempo_activo_total=$total_turno-$tiempo_comida-$tiempo_paro-$tiempo_paro_parcial-$tiempo_paro_parcial_comida;
						?>
							<tr>
                                    <td height="40" class="style2"><span class="style7"><? echo $res['name']?> </span></td>
                                 
                                    <td height="40" class="style2"><div align="center"><span class="style7">INACTIVE</span></div></td>
                                    <td height="40" class="style2"><table width="100%" border="0" bgcolor="#FF0000">
                                      <tr>
                                        <td height="40" bgcolor="#FF0000" class="style2">&nbsp;</td>
                                      </tr>
                                    </table></td>
                                    <td height="40" class="style2"><span class="style7"><? echo $res['first_name'] ?> <? echo $res['last_name'] ?></span></td>
                                    <td height="40" class="style2"><div align="center" class="style2"><strong>
                                    <? if($bpass==0){?>
                                      <img src="images/bypass.png" width="50" height="32" />
                                    <? }?>
                                    <? echo $razon?></strong></div></td>

                                    <td height="40" class="style7">&nbsp;</td>
                                


                                    <td height="40" class="style2"><div align="center" class="style2">
                                      <div align="right"><strong>
                                      <? if($res['first_name']!="")echo "$tiempo_activo_total  MIN";?>
                                        </strong></div>
                                    </div></td>
                                    <td height="40" class="style7"><div align="right"></div></td>
                                    <td height="40" class="style2"><div align="center" class="style2">
                                      <div align="right"><strong><? echo "$tiempo_paro_parcial MIN";?></strong></div>
                                    </div></td>
							        <td height="40" class="style2"><div align="center" class="style2">
							          <div align="right"><strong>
							            <? if($res['first_name']!="")echo "$tiempo_comida MIN";?>
						                </strong></div>
							        </div></td>
							        <td height="40" class="style2"><div align="center" class="style2">
							          <div align="right"><strong>
					                  <? if($res['first_name']!="")echo "$tiempo_paro MIN";?>
						                </strong></div>
							        </div></td>
					          </tr>
							 <? }else{
							 $tiempo_activo_total=$total_turno-$tiempo_comida-$tiempo_paro-$tiempo_paro_parcial-$tiempo_paro_parcial_comida;
							 ?>
							  <tr bgcolor="#FFCC33">
                                    <td height="40" bgcolor="#FFCC33" class="style2"><span class="style10"><? echo $res['name']?> </span></td>
                                 
                                    <td height="40" bgcolor="#FFCC33" class="style2"><div align="center"><span class="style10">INACTIVE</span></div></td>
                                    <td height="40" bgcolor="#FFCC33" class="style2"><table width="100%" border="0" bgcolor="#FF0000">
                                      <tr>
                                        <td height="40" bgcolor="#FF0000" class="style2">&nbsp;</td>
                                      </tr>
                                    </table></td>
                                    <td height="40" bgcolor="#FFCC33" class="style2"><span class="style10"><? echo $res['first_name'] ?> <? echo $res['last_name'] ?></span></td>
                                    <td height="40" bgcolor="#FFCC33" class="style2"><div align="center" class="style2"><strong><span class="style11">
                                    <? if($bpass==0){?>
                                    <img src="images/bypass.png" width="50" height="32" />
                                    <? }?>
                                    <? echo $razon?></span></strong></div></td>

                                    <td height="40" bgcolor="#FFCC33" class="style7">&nbsp;</td>
                                


                                    <td height="40" bgcolor="#FFCC33" class="style2"><div align="center" class="style2">
                                      <div align="right"><strong><span class="style11">
                                      <? if($res['first_name']!="")echo "$tiempo_activo_total  MIN";?>
                                        </span></strong></div>
                                    </div></td>
                                    <td height="40" bgcolor="#FFCC33" class="style7"><div align="right"></div></td>
                                    <td height="40" bgcolor="#FFCC33" class="style2"><div align="center" class="style2">
                                      <div align="right"><strong><span class="style11"><? echo "$tiempo_paro_parcial MIN";?></span></strong></div>
                                    </div></td>
							        <td height="40" bgcolor="#FFCC33" class="style2"><div align="center" class="style2">
							          <div align="right"><strong><span class="style11">
							            <? if($res['first_name']!="")echo "$tiempo_comida MIN";?>
						                </span></strong></div>
							        </div></td>
							        <td height="40" bgcolor="#FFCC33" class="style2"><div align="center" class="style2">
							          <div align="right"><strong><span class="style11">
					                  <? if($res['first_name']!="")echo "$tiempo_paro MIN";?>
						                </span></strong></div>
							        </div></td>
					          </tr>
                                    <? }
					}}?>
									   </tbody>                     
                                                    </table>
              </div>
</form>
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
		/////////////////////////////
		/*buscar();
		window.setInterval(function(){
  		buscar();
		},10000);
		window.setInterval(function(){
  		buscarO();
		},15000);
		window.setInterval(function(){
  		buscarT();
		},16000);*/
		
		/*function auto_reload()
		{
			window.location = 'cortes_prod.php';
		}*/
		//myFunction();
    </script>
</footer>
</body>
</html>