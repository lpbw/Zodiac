<?

session_start();
include "coneccion.php";



if($_POST["submit"]!=""){
			$login= mysql_real_escape_string($_POST["username"]);
			$pass=mysql_real_escape_string($_POST["password"]);
			$lang=$_POST["lang"];;
			$contra = sha1($pass);
			//////////revisa sesiones
			$consulta  = "SELECT TIMESTAMPDIFF(SECOND,last_login,now()), last_login, NOW(), logged FROM `locations` where logged<>0";
			$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
			$count=1;
			while(@mysql_num_rows($resultado)>=$count)
			{
				$res=mysql_fetch_row($resultado);
				
				if($res[0]>200){
					$consulta3  =  "update locations set logged=0, last_login= null where logged= $res[3]";
					$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta " . mysql_error());

				}
				$count=$count+1;
			}
			
			
			$consulta  = "SELECT * from users where username='$login' and password='$contra' and deleted_at is null";//md5()
			$resultado = mysql_query($consulta) or die("Error 1 $consulta <Br>".  mysql_error() );//. mysql_error()
			//echo $consulta;
			if(@mysql_num_rows($resultado)>=1){
                    $res=mysql_fetch_array($resultado,MYSQL_BOTH);
					 $idU=$_SESSION['usuario']['id'];
				    $_SESSION['usuario']=$res;
                    $_SESSION['idU']=$_SESSION['usuario']['id'];
					$_SESSION['nombreU']=$_SESSION['usuario']['first_name']." ".$_SESSION['usuario']['last_name'];
					$_SESSION['tipoU']=$_SESSION['usuario']['level_id'];
					
						if($_SESSION['tipoU']=="1" || $_SESSION['tipoU']=="2"){	
							if($lang==3){/*cuando no se ha elegido idioma*/
						   
						     //consulta de nuevo el usuario con el campo leng actualizado.
							$consulta5  = "SELECT * from users where username='$login' and password='$contra' and deleted_at is null";
			                $resultado5 = mysql_query($consulta5) or die("Error 1 $consulta5 <Br>".  mysql_error() );//. mysql_error()
							 $res5=mysql_fetch_assoc($resultado5);
							 //final de consulta
						   
						   }else{
							$consulta3  =  "update users set lang='$lang' where id= '$idU'";
							$resultado3 = mysql_query($consulta3) or die("Error en operacion3: $consulta3 " . mysql_error());
							
							//consulta de nuevo el usuario con el campo leng actualizado.
							$consulta5  = "SELECT * from users where username='$login' and password='$contra' and deleted_at is null";
			                $resultado5 = mysql_query($consulta5) or die("Error 1 $consulta5 <Br>".  mysql_error() );//. mysql_error()
							 $res5=mysql_fetch_assoc($resultado5);
							 //final de consulta
							 
							 }//fin de comparacion de idioma.
							 	
							if($res5['lang']=="1"){
							echo"<script> window.location=\"eng/menu.php\"</script>";
							}else{
							echo"<script> window.location=\"menu.php\"</script>";
							}
						}else{
						if($_SESSION['tipoU']=="4")
						{
							echo"<script> window.location=\"screen.php\"</script>";
						}
						else
						{
							if($lang==3){
						   
						     //consulta de nuevo el usuario con el campo leng actualizado.
							$consulta5  = "SELECT * from users where username='$login' and password='$contra' and deleted_at is null";
			                $resultado5 = mysql_query($consulta5) or die("Error 1 $consulta5 <Br>".  mysql_error() );//. mysql_error()
							 $res5=mysql_fetch_assoc($resultado5);
							 //final de consulta
							 
						   }else{
							$consulta4  =  "update users set lang='$lang' where id= '$idU'";
							$resultado4 = mysql_query($consulta4) or die("Error en operacion1: $consulta4 " . mysql_error());	
							
							//consulta de nuevo el usuario con el campo leng actualizado.
							$consulta5  = "SELECT * from users where username='$login' and password='$contra' and deleted_at is null";
			                $resultado5 = mysql_query($consulta5) or die("Error 1 $consulta5 <Br>".  mysql_error() );//. mysql_error()
							 $res5=mysql_fetch_assoc($resultado5);
							 //final de consulta
							 }
							 
							if($res5['lang']=="0"){
							echo"<script> window.location=\"pre_menu1.php\"</script>";
							}else{
							echo"<script> window.location=\"pre_menu1.php\"</script>";
							}
							
						}
						}
			} else{
				
					echo"<script>alert(\"Usuario o password invalido\");</script>";
				
			}

}

?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Zodiac - Iniciar sesión</title>
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

</head>
<body><div class="jumbotron login-window">
    <div class="container">
        <div class="row">
            <div id="formulario_login">
              <div id="campos_login">
                    <img src="public/images/zodiac2.jpg" class="img-responsive center-block margin-bottom" alt="zodiac logo"/>
                    <form action="index.php" method="post" accept-charset="utf-8">                    <div class="form-group">
                                                <input type="text" name="username" value="" placeholder="Nombre de usuario" class="form-control" id="username"  />                    </div>
                    <div class="form-group">
                                                <input type="password" name="password" value="" placeholder="Contraseña" class="form-control" id="password"  />                        
<input type="hidden" name="token" value="cf9cc6b1e3dac94c4ce6cf18274b6c02" />
<input name="lang" type="hidden" id="lang" value="0" />
                    </div>
						<div align="center">
					<select  name="lang" id="lang">
					 <option value="3">--Selecciona Idioma--</option>
                      <?	  
	                    $consulta  = "SELECT id, lang, idioma,language FROM languaje";
	                    $resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	                    $count=1;
	                     while($res=mysql_fetch_assoc($resultado))
	                     {
	                       ?>
    	                    <option value="<? echo $res['lang']?>"><? echo $res['idioma']?></option>
	                       <?
	                     } 
		               ?>    
                    </select>
					</div><br>
                    <input type="submit" name="submit" value="Iniciar sesión" title="Iniciar sesión" class="btn red-submit" />                    </form>                                    
                    <!--<div align="center"><a href="eng/index.php">English Version </a></div>-->
              </div>
                </div>
            </div>
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
    </script>
</footer>
</body>
</html>