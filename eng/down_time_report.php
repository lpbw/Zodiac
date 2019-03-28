<?
session_start();
include "coneccion.php";
include "checar_sesion_admin.php";
$idU=$_SESSION['idU'];
$nombreU=$_SESSION['nombreU'];
$tipoU=$_SESSION['tipoU'];
$locationU=$_SESSION['location'];
$desde= $_POST["desde"];
$hasta= $_POST["hasta"];
$lugar_b= $_POST["lugar_b"];
$tipo_b= $_POST["tipo_b"];
$turno_b= $_POST["turno_b"];
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
	
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
	
		  <script>
            $(function() {
                $( "#hasta" ).datepicker({ dateFormat: 'yy-mm-dd' });
                $( "#desde" ).datepicker({ dateFormat: 'yy-mm-dd' });
            });
			</script>	 
  <script src="colorbox/jquery.colorbox-min.js" type="text/javascript"></script>
<link rel="stylesheet" href="colorbox/colorbox.css" />
  <script type="text/javascript">
  $(function(){
    $(".iframe3").live('click',function(e){
         e.preventDefault();
         $.colorbox({
              width:"420", 
              href:$(this).attr('href'),
              height:"430", 
              iframe:true, 
              onClosed:function(){     
                   location.reload(true); 
              } 
         });
    });
});
 $(function(){
    $(".iframe1").live('click',function(e){
         e.preventDefault();
         $.colorbox({
              width:"860", 
              href:$(this).attr('href'),
              height:"500", 
              iframe:true, 
              onClosed:function(){     
                   location.reload(true); 
              } 
         });
    });
});
	$(document).ready(function(){
		//$(".iframe1").colorbox({iframe:true,width:"860", height:"500",transition:"fade", scrolling:true, opacity:0.7});
		$(".iframe2").colorbox({iframe:true,width:"600", height:"210",transition:"fade", scrolling:false, opacity:0.7});
		//$(".iframe3").colorbox({iframe:true,width:"420", height:"430",transition:"fade", scrolling:true, opacity:0.7});
		//$(".iframe3").colorbox({iframe:true,width:"420", height:"430",transition:"fade", scrolling:false, opacity:0.7});
		$("#click").click(function(){ 
		$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
			return false;
		});
	});

	function cerrarV(){
		$.fn.colorbox.close();
	}
function abrir(id)
{
	
$.colorbox({iframe2:true,href:"editar_corte_prod.php?id="+id,width:"420", height:"430",transition:"fade", scrolling:true, opacity:0.7});
	
}
function abrir2(id)
{
	
$.colorbox({iframe2:true,href:"editar_pausa_prod.php?id="+id,width:"820", height:"630",transition:"fade", scrolling:true, opacity:0.7});
	
}
</script>
<script>
        function textAreaAdjust(o) {
            o.style.height = "1px";
            o.style.height = (25+o.scrollHeight)+"px";
        }
		
    </script>
<?

	
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
function buscar()
{
var xmlhttp;
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
    document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
    }
  }
  var tipo=0;
 
xmlhttp.open("GET","buscar_activos.php?id=<? echo"$locationU";?>",true);
xmlhttp.send();
}
function buscarO()
{
var xmlhttp;
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
    document.getElementById("d_pendientes").innerHTML=xmlhttp.responseText;
    }
  }
  var tipo=0;
 
xmlhttp.open("GET","buscar_pendientes.php?id=<? echo"$locationU";?>",true);
xmlhttp.send();
}
function buscarT()
{
var xmlhttp;
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
    document.getElementById("d_terminadas").innerHTML=xmlhttp.responseText;
    }
  }
  var tipo=0;
 
xmlhttp.open("GET","buscar_terminadas.php?id=<? echo"$locationU";?>",true);
xmlhttp.send();
}
</script>
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
-->
</style>
</head>
<body >
<div id="wrapper">
    <!-- Navigation onLoad="timer = setTimeout('auto_reload()',15000);"-->
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
    <? 
	//if($tipoU!="3")
	//	include "menu_f.php"
	//else
		include "menu_f.php"
	?>
    <!-- /.navbar-static-side -->
</nav>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Downtime Report  </h1>
                <div class="divider"></div>

                <div class="divider"></div>

				
                                     
                        <div> 
               
              </div>
			  <div></div>
              <form id="form1" name="form1" method="post" action="">
              
              <div class="col-lg-12 table-responsive" id="d_terminadas">
			 
                                                                                                                                        <table class="table table-striped table-condensed grid">
                            <thead>
							<tr>
							  <th colspan="7"><table width="100%" border="0">
                                <tr>
                                  <td><input name="desde" type="text" class="form-control" id="desde"
                                       value="<?echo"$desde";?>" size="10" placeholder="Date From" readonly/>																  </td>
                                  <td><input name="hasta" type="text" class="form-control" id="hasta"
                                       value="<?echo"$hasta";?>" size="10" placeholder="Date To" readonly/></td>
                                  <td><select class="form-control" id="lugar_b" name="lugar_b" style="width:150">
                                    <option value="0" selected="selected">--Select Location--</option>
                                    <? 
	                                $consulta  = "SELECT id, name FROM locations where deleted_at is null";
	                                $resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	                                $count=1;
	                                    while(@mysql_num_rows($resultado)>=$count)
	                                        {
		                                        $res=mysql_fetch_row($resultado);
		                                            if($lugar_b==$res[0])
		                                                echo"<option value=\"$res[0]\" selected>$res[1]</option>";
		                                            else
		                                                echo"<option value=\"$res[0]\" >$res[1]</option>";
		                                                $count=$count+1;
	                                        }	
		
		                          ?>
                                  </select></td>
                                  <td><select class="form-control" id="tipo_b" name="tipo_b" style="width:150">
                                    <option value="0" selected="selected">--Select Downtime Reason--</option>
                                    <? 
	                                $consulta  = "SELECT id, reason FROM down_time_reason order by reason";
	                                $resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	                                $count=1;
	                                    while(@mysql_num_rows($resultado)>=$count)
	                                        {
		                                        $res=mysql_fetch_row($resultado);
		                                            if($tipo_b==$res[0])
		                                                echo"<option value=\"$res[0]\" selected>$res[1]</option>";
		                                            else
		                                                echo"<option value=\"$res[0]\" >$res[1]</option>";
		                                                $count=$count+1;
	                                        }	
		
		                          ?>
                                  </select></td>
                                  <td>
								  <select class="form-control" id="turno_b" name="turno_b" style="width:150">
                                    <option value="0" <? if($_POST['turno_b']=="")echo"selected";?>>--Select Turn--</option>
									<option value="1" <? if($_POST['turno_b']==1)echo"selected";?>>1</option>
									<option value="2" <? if($_POST['turno_b']==2)echo"selected";?>>2</option>
									<option value="3" <? if($_POST['turno_b']==3)echo"selected";?>>3</option>
                                   
                                  </select>
								  </td>
                                  <td><input type="submit" class="btn red-submit button-form" name="buscar" value="Search"/></td>
                                   <td><a href="exportar_down_time_report.php?desde=<?echo"$desde";?>&hasta=<?echo"$hasta"?>&lugar_b=<?echo"$lugar_b"?>&tipo_b=<?echo"$tipo_b"?>&turno_b=<?echo"$turno_b"?>" target="_blank"><img src="images/descarga.png" width="46" height="46" border="0" title="Exportar" /></a></td>
                                </tr>
                              </table>							    
							    
   						      </th>
							  </tr>
							<tr>
                            <th width="5%">Date</th>                  
                            <th width="5%">Loacation</th>
                            <th width="11%">Downtime Reason </th>
                            <th width="11%">Start</th>                       
                            <th width="6%">End</th>
                            <th width="8%">Time</th>
                            <th width="6%">Autorized By</th>
							</tr>
                            </thead>
                            <tbody>

                            
                                        
	<?	  
if($_POST['buscar']=="Search")
{
	if($_POST['lugar_b']!=0){
		$buscar1="cut_pause.location_id=".$_POST['lugar_b']." and";
	}
	if($_POST['tipo_b']!=0){
		$buscar2="razon_id=".$_POST['tipo_b']." and";
	}
	if($_POST['turno_b']!=0){
		$buscar3="turno=".$_POST['turno_b']." and";
	}
	
	//$variable buscarl estaba mal escrita en la consulta.
	$consulta="SELECT  DATE_FORMAT(inicio, '%Y-%m-%d') as inicio, DATE_FORMAT(fin, '%Y-%m-%d') as fin, reason,razon_id,  FORMAT(TIME_TO_SEC(timediff(fin, inicio))/60,0) as d2, locations.name, first_name, last_name, autorized_by FROM `cut_pause` inner join down_time_reason on cut_pause.razon_id=down_time_reason.id inner join locations on cut_pause.location_id=locations.id left outer join users on cut_pause.autorized_by=users.id where $buscar1 $buscar2 $buscar3   DATE_FORMAT(inicio, '%Y-%m-%d')>='".$_POST['desde']."' and DATE_FORMAT(inicio, '%Y-%m-%d')<='".$_POST['hasta']."'  ";
	//echo"$consulta";
	
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1:$consulta " . mysql_error());
	while($res=mysql_fetch_assoc($resultado)){	
	
		?>
							<tr>
                                    <td><? echo $res['inicio']?></td>
                                 
                                    <td><? echo $res['name']?></td>
                                    <td><? echo $res['reason']?></td>
                                    <td><? echo $res['inicio']?></td>
                                    <td><? echo $res['fin']?></td>
                                    <td><? echo $res['d2']?></td>
                                    <td><? echo $res['first_name']?></td>
							  </tr>
                                       <? }}?>
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
		
		
		
    </script>
</footer>
</body>
</html>