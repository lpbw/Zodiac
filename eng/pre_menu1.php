<?
session_start();
include "coneccion.php";
$idU=$_SESSION['idU'];


if($_POST["submit"]!=""){
			$location= $_POST["location"];
			$lang= $_POST["lang"];
			if($location!="0")
			{
					$consulta2  = "SELECT * from locations where logged=$idU and deleted_at is null";//md5()
					$resultado2 = mysql_query($consulta2) or die("Error 1 $consulta <Br>".  mysql_error() );//. mysql_error()
					//echo $consulta;
					if(@mysql_num_rows($resultado2)>=1){
						$res2=mysql_fetch_array($resultado2,MYSQL_BOTH);
						if($res2[0]==$location)
						{
							$_SESSION['location']=$location;
							$consulta3  =  "update locations set logged=$idU where id= $location";
							$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta " . mysql_error());
                   			$consulta3  =  "update users set lang=$lang where id= $idU";
							$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta " . mysql_error());
							echo"<script> window.location=\"cortes_prod.php\"</script>";
						}else
						{
							echo"<script>alert(\"User signed already\");</script>";
							echo"<script> window.location=\"index.php\"</script>";
						}
					}else
					{
				   
						/*$consulta8  = "SELECT username from locations inner join users on locations.logged=users.id where locations.id=$location and locations.deleted_at is null";
						//echo"$consulta8";
						$resultado8 = mysql_query($consulta8) or die("Error 1 $consulta8 <Br>".  mysql_error() );//. mysql_error()
						//echo $consulta;
						if(@mysql_num_rows($resultado8)>=1){
							$res8=mysql_fetch_row($resultado8);
							$nombre="$res8[0]";
							echo"<script>alert(\"$nombre is in this machine\");</script>";
							echo"<script> window.location=\"index.php\"</script>";
						}else
						{*/
							$_SESSION['location']=$location;
							$consulta3  =  "update locations set logged=$idU where id= $location";
							$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta " . mysql_error());
							$consulta3  =  "update users set lang=$lang where id= $idU";
								$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta " . mysql_error());
							echo"<script> window.location=\"cortes_prod.php\"</script>";
					/*	}*/
					}
			} else{
				
					echo"<script>alert(\"Select a Location\");</script>";
				
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
                    <form action="" method="post" accept-charset="utf-8">                    <div class="form-group">
                                               
                                                
                                                <select class="form-control" id="location" name="location">
                                                  <option value="0" selected="selected">--Select Location--</option>
                                                  <?	  
	$consulta  = "SELECT id, name FROM locations where deleted_at is null";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	$count=1;
	while(@mysql_num_rows($resultado)>=$count)
	{
		$res=mysql_fetch_row($resultado);
		
		echo"<option value=\"$res[0]\" >$res[1]</option>";
		$count=$count+1;
	}	
		
		?>
                                                </select>
                                                 </div>
                    
                    <input type="submit" name="submit" value="Continuar" title="Iniciar sesión" class="btn red-submit" />                    
                    <span class="form-group">
                    <input name="lang" type="hidden" id="lang" value="1" />
                    </span>
                    </form>                                    </div>
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