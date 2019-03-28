<?

    // Archivos necesarios.
    session_start();
    include "coneccion.php";
    include "checar_sesion_prod.php";

    /*
    $idU = id usuarios en session.
    $nombreU = nombre de usuario.
    $tipoU = tipo de usuario.
    */
    $idU=$_SESSION['idU'];
    $nombreU=$_SESSION['nombreU'];
    $tipoU=$_SESSION['tipoU'];
	$locationU=$_SESSION['location'];
    //obtiene la hora actual
    $hora=date('H:i:s');
   $dia_semana=date(N)+1;
if($dia_semana==8)
	$dia_semana=1;
	// buscar condicion si es despues de las 12 y antes de las 12:30 tomar el dia anterior
$consultaT  = "SELECT numero FROM turnos where CURTIME()>inicio and CURTIME()<fin and dias like '%".$dia_semana."%'";// 

$resultadoT = mysql_query($consultaT) or die("La consulta fall&oacute;P1: $consultaT " . mysql_error());
if(@mysql_num_rows($resultadoT)>0)
{
	$resT=mysql_fetch_row($resultadoT);
	$turno=$resT[0];
 }
    /*if($_SESSION['filtro']!=""){
    $filtro=$_SESSION['filtro'];
    }
    else{
    $filtro=0;
    }*/
//echo "tipo: " .$tipoU;

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
	<link rel="stylesheet" href="pop.css"/>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
	<script>
        $(function() {
            $( "#flote" ).datepicker({ dateFormat: 'yy-mm-dd' });
            $( "#desde" ).datepicker({ dateFormat: 'yy-mm-dd' });
        });
        function textAreaAdjust(o) {
            o.style.height = "1px";
            o.style.height = (25+o.scrollHeight)+"px";
        }
        function myFunction() {
            var popup = document.getElementById("myPopup");
            popup.classList.toggle("show");
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
        $pausa_id=$_POST['pausa_id'];
		$razon_id=$_POST['razon_id'];
		$razon=$_POST['razon'];
        if($pausa_id=="")
		{
            $pausa_id=$_GET['pausa_id'];
            $razon_id=$_GET['razon_id'];
			$razon=$_GET['razon'];
		}
        if($pausa_id!="")
        {
            $consulta22  = "SELECT cut_pause.id, inicio, reason, FORMAT(TIME_TO_SEC(timediff(now(), inicio))/60,0), name , razon_id, id_cut FROM cut_pause inner join down_time_reason on cut_pause.razon_id=down_time_reason.id inner join locations on cut_pause.location_id=locations.id  where cut_pause.id=".$pausa_id;
			$resultado22 = mysql_query($consulta22) or die("La consulta fall&oacute;P1: $consulta22 " . mysql_error());
			if(@mysql_num_rows($resultado22)>0)
			{
				$res22=mysql_fetch_row($resultado22);
				$inicio=$res22[1];
				$razon_name=$res22[2];
				$tiempo=$res22[3];
				$lectra=$res22[4];
				$razon_id=$res22[5];
				$id_cut=$res22[6];
			}else
			{
			$id_cut="0";
			}
			
        }


		 $bypass= $_POST["bypass1"];
        if($bypass!="")  
        {
			
			$user=$_POST['user'];
			$pass=mysql_real_escape_string($_POST["pass"]);
			$contra = sha1($pass);
			$consulta  = "SELECT * from users where username='$user' and password='$contra' and level_id=5 and deleted_at is null";
            $resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
            if(@mysql_num_rows($resultado)>0)
            {
                $res=mysql_fetch_row($resultado);
              	 $consulta  =  "update locations set estatus=0 where id=".$locationU; //aplica bypass a maquina a solicitud de mantenimiento.
                $resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
				
				echo"<script> window.location=\"cortes_prod.php\";</script>";
            }
            else
            {
                
                echo"<script>alert(\"Usuario Invalido\"); </script>";
            }
		}
		
         $terminado= $_POST["terminado"];
        if($terminado!="")  
        {
			$tipo=$_POST['tipo'];
			$diag=$_POST['diag'];
			$user=$_POST['user'];
			$pass=mysql_real_escape_string($_POST["pass"]);
			$contra = sha1($pass);
			$consulta  = "SELECT * from users where username='$user' and password='$contra' and level_id=5 and deleted_at is null";
            $resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
            if(@mysql_num_rows($resultado)>0)
            {
                $res=mysql_fetch_row($resultado);
              	 $consulta  =  "update cut_pause set razon='".$diag."', autorized=".$res[0].", razon_id=$tipo, fin=now() where id=".$pausa_id; //,  razon='$razon', razon_id=$razon_id
                $resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
				//$consulta  =  "insert into cut_pause(id_cut, inicio, razon_id, turno, location_id, user_id) values($id_cut, now(), 0, $turno,$locationU,$idU)";
               // $resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
				 $consulta  =  "update locations set estatus=1 where id=".$locationU; //quita bypass a maquina a solicitud de mantenimiento.
                $resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
				echo"<script> window.location=\"cortes_prod.php\";</script>";
            }
            else
            {
                
                echo"<script>alert(\"Usuario Invalido\"); </script>";
            }
		}
		$pasar= $_POST["pasar"];
        if($pasar!="")  
        {
			$tipo=$_POST['tipo'];
			$diag=$_POST['diag'];
			$user=$_POST['user'];
			$pass=mysql_real_escape_string($_POST["pass"]);
			$contra = sha1($pass);
			$consulta  = "SELECT * from users where username='$user' and password='$contra' and level_id=5 and deleted_at is null";
            $resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
            if(@mysql_num_rows($resultado)>0)
            {
                $res=mysql_fetch_row($resultado);
              	 $consulta  =  "update cut_pause set razon='".$diag."', autorized=".$res[0].", razon_id=$tipo, fin=now() where id=".$pausa_id; 
                $resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
				$consulta  =  "insert into cut_pause(id_cut, inicio, razon_id, turno, location_id, user_id) values($id_cut, now(), 3, $turno,$locationU,$idU)";
                $resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
				echo"<script> window.location=\"cortes_prod.php\";</script>";
            }
            else
            {
                
                echo"<script>alert(\"Usuario Invalido\"); </script>";
            }
		}
		$rechaza= $_POST["rechaza"];
        if($rechaza!="")  
        {
			echo"<script>alert(\"Usuario Invalido\"); </script>";
		}

        $guardar= $_POST["guardar"];
        if($guardar!="")  
        {
            $user=$_POST['user'];
			$pass=mysql_real_escape_string($_POST["pass"]);
			$contra = sha1($pass);
			$consulta  = "SELECT * from users where username='$user' and password='$contra' and level_id=5 and deleted_at is null";
            $resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
            if(@mysql_num_rows($resultado)>0)
            {
                $res=mysql_fetch_row($resultado);
              	 $consulta  =  "update cut_pause set autorized=".$res[0]." where id=".$pausa_id; //,  razon='$razon', razon_id=$razon_id
                $resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
				echo"<script> window.location=\"cortes_prod.php\";</script>";
            }
            else
            {
                
                echo"<script>alert(\"Usuario Invalido\"); </script>";
            }
        }	
		$guardar2= $_POST["guardar2"];
        if($guardar2!="")  
        {
            
				echo"<script>alert(\"Tiempo NO Autorizado\"); window.location=\"cortes_prod.php\";</script>";
            
        }
        
    ?>
    <script>
        //Borrar el rollo.
       
     function validar()
	 {
	 	if(document.form1.tipo.value=="3")
		{
			alert("Seleccione tipo");
			document.form1.tipo.focus();
			return false;
		}
	 }
	 function salir()
	 {
	 	document.form1.action="cortes_prod.php";
		document.form1.submit();
	 }
	 function bypass2()
	 {
	 	if(document.form1.user.value=="")
		{
			alert("Escriba Usuario");
			document.form1.user.focus();
			return false;
		}else if(document.form1.pass.value=="")
		{
			alert("Escriba Password");
			document.form1.pass.focus();
			return false;
		}else
		{
		document.form1.action="autorizar.php";
		document.form1.bypass1.value="1";
		document.form1.submit();
		}
	 }
	    
       

        

    </script>	
</head>
<body>
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
        <? include "menu_p.php"?>
        <!-- /.navbar-static-side -->
    </nav>
    <div id="page-wrapper">
        <div class="row">
            <h1 class="page-header">Authorize Down Time  <?//echo"$razon_id";?></h1>
                <div class="divider"></div>
                <div class="divider">Para continuar con la operación de esta maquina se requiere usuario y contraseña de Manteniento para autorizar el tiempo de paro</div>
                <form name="form1" action="" method="post" class="margin-bottom" accept-charset="utf-8">                                                <div class="form-group">
              <div class="col-sm-6 col-md-4 col-lg-12">
              <label for="f_id">Location:</label>
                               <? echo"$lectra";?>
                                <input name="pausa_id" type="hidden" id="pausa_id" value="<? echo"$pausa_id";?>">
                                <input name="razon_id" type="hidden" id="razon_id" value="<? echo"$razon_id";?>">
                                <input name="razon" type="hidden" id="razon" value="<? echo"$razon";?>">
                                <input name="bypass1" type="hidden" id="bypass1">
              </div>

              <div class="col-sm-6 col-md-4 col-lg-12">
                                <label for="retail_length">Reason:</label>
                  <? echo"$razon_name";?></div>
                            <div class="col-sm-6 col-md-4 col-lg-12">
                                <label for="guaranteed_length">Initial Time :</label>
                                <? echo"$inicio";?>                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-12">
                                <label for="remaining_inches">Total Time :</label>
                                <? echo"$tiempo";?>min                            </div>
							<div class="col-sm-6 col-md-4 col-lg-12">
                                <label for="remaining_inches">Diagnosis :</label>
                                Selecciona Razon                            
                  </div>
				  <div class="col-sm-6 col-md-4 col-lg-12">
                                <label for="remaining_inches">Type :</label>
                                <select name="tipo" class="form-control" id="tipo" >
                                  <option value="">Selecciona Razon</option>
                                  <?	  
							$consulta2  = "SELECT * FROM down_time_reason where autorization=1 order by id";
							$resultado2 = mysql_query($consulta2) or die("La consulta fall&oacute;P1: " . mysql_error());
							$count=1;
							while(@mysql_num_rows($resultado2)>=$count)
							{
								$res2=mysql_fetch_row($resultado2);
								if($res2[0]==$razon_id)
								echo"<option value=\"".$res2[0]."\" selected>$res2[1]</option>";
								else 
								echo"<option value=\"".$res2[0]."\" >$res2[1]</option>";
								$count=$count+1;
							}	
		
										?>
                                </select>
				  </div>
			<div class="col-sm-6 col-md-4 col-lg-12">
                                    <label for="retail_length">Diagnosis:</label>
                                    <input type="text" class="form-control" id="diag" name="diag" placeholder="Diagnosis" value="" required/>
              </div>
              <div class="col-sm-6 col-md-4 col-lg-6">
                                    <label for="retail_length">User:</label>
                                    <input type="text" class="form-control" id="user" name="user" placeholder="Nombre de usuario" value="" required/>
              </div>
			 <div class="col-sm-6 col-md-4 col-lg-6">
                                    <label for="retail_length">Password:</label>
                                    <input type="password" class="form-control" id="pass" name="pass" placeholder="Contraseña" value="" required/>
              </div>

             
					
										 
					
                            <div class="col-sm-6 col-md-12 col-lg-3">
                <input name="terminado" type="submit" class="btn red-submit button-form" id="terminado" onClick="return validar();"
                                       value="Finished"/>
              </div>
				 <div class="col-sm-6 col-md-12 col-lg-3">
                                
                                <input name="pasar" type="submit" class="btn red-submit button-form" id="pasar" onClick="return validar();"
                                       value="Not Mine"/>
                </div><div class="col-sm-6 col-md-12 col-lg-3">
                                
                                <input name="rechaza" type="button" class="btn red-submit button-form" id="rechaza"  onClick="salir();"
                                       value="No Authorize"/>
                </div>
				<div class="col-sm-6 col-md-12 col-lg-3">
                                
                                <input name="bypass" type="button" class="btn red-submit button-form" id="bypass"  onClick="bypass2();"
                                       value="Bypass"/>
                </div>
                            <div class="clearfix"></div>
                        </div>
					
</form>
      </div>
    </div>
    </div>




<footer>
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
    
</footer>
</body>
</html>