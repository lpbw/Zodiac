<?

    // Archivos necesarios.
    session_start();
    include "coneccion.php";
    include "checar_sesion_admin.php";

    /*
    $idU = id usuarios en session.
    $nombreU = nombre de usuario.
    $tipoU = tipo de usuario.
    */
    $idU=$_SESSION['idU'];
    $nombreU=$_SESSION['nombreU'];
    $tipoU=$_SESSION['tipoU'];

    //obtiene la hora actual
    $hora=date('H:i:s');
   
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
        $id=$_POST['id'];
        if($id=="")
            $id=$_GET['id'];
            $posi=$_GET['posi'];
        if($id!="")
        {
            $consulta  = "SELECT id,";
            $consulta .= "lote,";
            $consulta .= "substring(fiber_id,3),";
            $consulta .= "retail_length,";
            $consulta .= "FORMAT(guaranteed_length/36,2),";
            $consulta .= "FORMAT(remaining_inches/36,2),";
            $consulta .= "location_id,";
            $consulta .= "location_slot,";
            $consulta .= "state_id,";
            $consulta .= "storage_id ";
            $consulta .= "FROM rolls "; 
            $consulta .= "WHERE id='".$id."' ";
            $consulta .= "and rolls.deleted_at is null";
            $resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1:$consulta " . mysql_error());
            if(@mysql_num_rows($resultado)>=1)
            {
                $res8=mysql_fetch_array($resultado,MYSQL_BOTH);	
            }
        }

        $guardar= $_POST["guardar"];
        if($guardar=="Guardar")  
        {  
            
            //guarda en una variable de sesion el lugar que tiene el filtro.
            $_SESSION['filtro']= $_POST["lugar_b"];

            //nombre de la fibra.
            $fiber_id= $_POST["id_fiber"];
            
            //fecha de el lote.
            $flote= $_POST["flote"];

            //numero de lote.
            $lote= $_POST["lote"];

            //gross.
            $retail_length= $_POST["retail_length"];

            //Net.
            $guaranteed_length= $_POST["guaranteed_length"];

            //pulgadas restantes.
            $remaining_inches= $_POST["remaining_inches"];

            //maquina.
            $location_id= $_POST["location_id"];

            //posicion en la maquina.
            $location_slot= $_POST["location_slot"];

            //separa el arreglo.
            $slot=explode("|",$location_slot);
 			//convierte los pies de pulgadas restantes en pulgadas.
                $pulgadas=$remaining_inches*36;

                //convierte los pies de NET en pulgadas.
                $guaranteed=$guaranteed_length*36;
            //estatus de la fibra.
            $state_id= $_POST["state_id"];
			$state_id2= $_POST["state_id2"];
			echo "tipo: " .$tipoU. "state: " .$state_id;
            //Valida que el estatus del rollo no sea 0
            if ($state_id == "0") {
                echo "<script>alert('Estado del rollo no seleccionado');</script>";
            }
            else
            {
			if ($state_id2 == "5" && $tipoU=="2") {
				echo "<script>alert('No puede hacer cambios en Rollo terminado fuera de rango');</script>";
			}else
			{
                //almacen
                $storage= $_POST["storage"];
                $id= $_POST["id"];

               

                //revisa que no este ocupado el tubo.
                if($id!="")
                {
                    $and2="and rolls.id<>$id";
                }
                else
                {
                    $and2="";
                }
                
                $consulta  = "SELECT id ";
                $consulta .= "FROM rolls ";
                $consulta .= "WHERE location_id='$location_id' ";
                $consulta .= "AND location_slot='$slot[0]' ";
                $consulta .= "AND location_id<>0 $and2";
                $resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1:$consulta " . mysql_error());
                $count=1;

                //Si la posicion esta ocupada.
                if(@mysql_num_rows($resultado)>0)
                {
                    echo"<script>alert(\"Posicion Ocupada\");</script>";
                }
                else
                {
                    $consulta  = "SELECT rolls.id,";
                    $consulta .= "locations.name,";
                    $consulta .= "storage.name,";
                    $consulta .= "location_capacities.number ";
                    $consulta .= "FROM rolls ";
                    $consulta .= "LEFT OUTER JOIN locations ON rolls.location_id=locations.id ";
                    $consulta .= "LEFT OUTER JOIN storage ON rolls.storage_id=storage.id ";
                    $consulta .= "LEFT OUTER JOIN location_capacities ON location_capacities.id=rolls.location_slot ";
                    $consulta .= "WHERE rolls.lote='$lote' $and2 ";
                    $resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: $consulta" . mysql_error());
                    $count=1;

                    //Revisa lote duplicado.
                    if(@mysql_num_rows($resultado)>0)
                    {
                        $res=mysql_fetch_row($resultado);
                        echo"<script>alert(\"Lote duplicado en ".$res[1]." ".$res[2]." ".$res[3]."\");</script>";
                    }
                    else
                    {
                        //Si el id no esta vacio.
                        if($id!="")
                        {
                            
                            /*
                            Si el estatus del rollo es 
                            4=Terminado o 
                            5=Terminado fuera de tolerancia
                            */
                            if($state_id==4 || $state_id==5)  
                            {
                                $consulta="select status from cuts where roll_id=$id and (status=2 or status=1)";
                                $resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
                                
                                //si encuentra un resultado esta ocupado
                                if(@mysql_num_rows($resultado)>0)
                                {
                                    echo"<script>alert(\"Rollo en uso no puede ser terminado \");</script>";
                                }
                                else
                                {
                                    //aqui cambio location_id=0, location_slot=0
                                   // $pulgadas=$remaining_inches;
                                   // $guaranteed=$guaranteed_length;
                                    $tolerancia_p=($guaranteed_length*0.007);
									$tolerancia_n=-1*($guaranteed_length*0.007);
									
                                    if($pulgadas>=$tolerancia_n && $pulgadas<=$tolerancia_p){
                                        $estatus=4;
                                    }else{
                                        $estatus=5;
                                    }
                                    //Actualizar rollos.
                                    $consulta  =  "UPDATE rolls ";
                                    $consulta .= "SET lote='$lote',";
                                    $consulta .= " fiber_id='$fiber_id',";
                                    $consulta .= "retail_length='$retail_length',";
                                    $consulta .= "guaranteed_length='$guaranteed',";
                                    $consulta .= "remaining_inches='$pulgadas',";
                                    $consulta .= "location_id=0,";
                                    $consulta .= "location_slot=0,";
                                    $consulta .= "state_id='$estatus',";
                                    $consulta .= "updated_at=now(),";
                                    $consulta .= "storage_id=$storage,";
                                    $consulta .= "Update_by='$idU'";
                                    $consulta .= "WHERE id=$id";
									//echo"$consulta";
                                    $resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
                            
                
                                   // $consulta="select remaining_inches, guaranteed_length, retail_length from rolls where id=$id";
                                   // $resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
                                   // $res=mysql_fetch_assoc($resultado);
                                    
                                    //gross
                                   /* $gross=$res['retail_length']*36;
                                    $resto=$res['remaining_inches'];
                                    //net
                                    $garantizado=$res['guaranteed_length'];
                                    $tole_gross=($garantizado+(($gross-$garantizado)*0.007));
                                    $tole_net=($garantizado-($garantizado*0.007));*/
									
									
								    /*if($resto<=$tole_net && $resto>=$tole_gross){
                                        $estatus=4;
                                    }else{
                                        $estatus=5;
                                    }*/
                                
                                  /*  $consulta2  = "update rolls ";
                                    $consulta2 .= "set state_id=$estatus,";
                                    $consulta2 .= "updated_at=now(),";
                                    $consulta2 .= "finished_at=now(),";
                                    $consulta2 .= "location_id=0,";
                                    $consulta2 .= "location_slot=0,";
                                    $consulta2 .= "finished_by=$idU,";
                                    $consulta2 .= "Update_by='$idU' ";
                                    $consulta2 .= "WHERE id=$id";
									echo"$consulta2";
                                    $resultado2 = mysql_query($consulta2) or die("Error en operacion2: $consulta2 " . mysql_error());*/
                                    
                                    echo"<script>alert(\"Rollo Terminado \");</script>";
                                }
                                
                            }
                            else
                            {
                                $consulta  =  "update rolls ";
                                $consulta .= "set lote='$lote',";
                                $consulta .= "fiber_id='$fiber_id',";
                                $consulta .= "retail_length='$retail_length',";
                                $consulta .= "guaranteed_length='$guaranteed',";
                                $consulta .= "remaining_inches='$pulgadas',";
                                $consulta .= "location_id='$location_id',";
                                $consulta .= "location_slot='$slot[0]',";
                                $consulta .= "state_id='$state_id',";
                                $consulta .= "updated_at=now(),";
                                $consulta .= "storage_id=$storage,";
                                $consulta .= "Update_by='$idU' ";
                                $consulta .= "WHERE id=$id";
								//echo"$consulta";
                                //$pulgadas=$remaining_inches;
                               // $guaranteed=$guaranteed_length;
                                $resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
                        
                            }

                        }
                        else
                        {
                            $consulta  = "INSERT INTO rolls (lote,";
                            $consulta .= "fiber_id,";
                            $consulta .= "retail_length,";
                            $consulta .= "guaranteed_length,";
                            $consulta .= "remaining_inches,";
                            $consulta .= "location_id,";
                            $consulta .= "location_slot,";
                            $consulta .= "state_id,";
                            $consulta .= "created_at,";
                            $consulta .= "storage_id,";
                            $consulta .= "Update_by,";
                            $consulta .= "date_lote) ";
                            $consulta .= "VALUES ('$lote',";
                            $consulta .= "'$fiber_id',";
                            $consulta .= "'$retail_length',";
                            $consulta .= "'$guaranteed',";
                            $consulta .= "'$pulgadas',";
                            $consulta .= "'$location_id',";
                            $consulta .= "'$slot[0]',";
                            $consulta .= "'$state_id',";
                            $consulta .= "now(),";
                            $consulta .= "$storage,";
                            $consulta .= "$idU,";
                            $consulta .="'$flote $hora')";
                            $resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
                            echo"<script>alert(\"Rollo Agregado\");</script>";
                        }
                        //Si id no esta vacio ni la posicion esta vacia.
                        if($id!="" && $slot[0]!="0")
                        {
                            //Actualiza corte
                            $consulta  =  "UPDATE cuts ";
                            $consulta .= "SET location_assigned_id='$location_id',";
                            $consulta .= "number_position='$slot[0]',";
                            $consulta .= "updated_at=now() ";
                            $consulta .= "WHERE roll_id=$id "; 
                            $consulta .= "AND status=$state_id";
                            $resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
                
                            //Encuentra el consecuitvo maximo.
                            $consulta6 = "SELECT max(orden) AS orden ";
                            $consulta6 .= "FROM cuts ";
                            $consulta6 .= "WHERE location_assigned_id=$location_id "; 
                            $consulta6 .= "AND status<3 ";
                            $consulta6 .= "AND deleted_at IS NULL";
                            $resultado6 = mysql_query($consulta6) or die("Error en operacion1: $consulta6 " . mysql_error());
                            $res6=mysql_fetch_assoc($resultado6);
                            $orden=$res6['orden'];
                
                            if($orden>0)
                            {
                                $orden=$orden+1;
                            }	
                            else
                            {
                                $orden=1;	
                                $consulta  = "SELECT id ";
                                $consulta .= "FROM cuts ";
                                $consulta .= "WHERE location_assigned_id='$location_id' ";
                                $consulta .= "AND number_position='$slot[0]' ";
                                $consulta .= "AND status=0 ";
                                $consulta .= "AND orden=0 ";
                                $consulta .= "AND deleted_at IS NULL ORDER BY id";
                                $resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
                                $count=1;
                                while(@mysql_num_rows($resultado)>=$count)
                                {
                                    $res=mysql_fetch_row($resultado);
                                    $consulta3  =  "UPDATE cuts set orden=$orden, updated_at=now() WHERE id=".$res[0];
                                    $resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta3 " . mysql_error());
                                    $orden++;
                                    $count=$count+1;
                                }	

                            }

                            if($id!="")
                            echo"<script>alert(\"Rollo Cambiado\");</script>";
                            else
                            echo"<script>alert(\"Rollo Agregado\");</script>";
                            $id="";
                        }

                    }
                    
                }    

            }
			}
            	
                
        }

        $borrar= $_POST["borrar"];
        if($borrar!="")  
        {
            $consulta  = "SELECT id, mo FROM cuts WHERE roll_id='$borrar' ";
            $resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
            if(@mysql_num_rows($resultado)>0)
            {
                $res=mysql_fetch_row($resultado);
                echo"<script>alert(\"No se puede borrar este Rollo , asigando a MO $res[1]\");</script>";
            }
            else
            {
                $consulta  =  "DELETE FROM rolls WHERE id=$borrar";
                $resultado = mysql_query($consulta) or die("Error en operacion1: $consulta " . mysql_error());
                echo"<script>alert(\"Rollo Borrado\");</script>";
            }
        }	
        if($id!="")
        {
            $consulta  = "SELECT id,";
            $consulta .= "lote,";
            $consulta .= "substring(fiber_id,3),";
            $consulta .= "retail_length,";
            $consulta .= "REPLACE(FORMAT(guaranteed_length/36,2), ',', ''),";
            $consulta .= "REPLACE(FORMAT(remaining_inches/36,2), ',', ''),";
            $consulta .= "location_id,";
            $consulta .= "location_slot,";
            $consulta .= "state_id,";
            $consulta .= "storage_id ";
            $consulta .= "FROM rolls ";
            $consulta .= "WHERE id='".$id."' ";
            $consulta .= "AND rolls.deleted_at is null ";
            $resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
            if(@mysql_num_rows($resultado)>=1)
            {
                $res8=mysql_fetch_array($resultado,MYSQL_BOTH);
                
            }
        }
    ?>
    <script>
        //Borrar el rollo.
        function borrar(id)
        {
            if(confirm("¿Esta seguro de borrar este rollo?"))
            {
                document.form1.borrar.value=id;
                document.form1.submit();
            }
        }
        
        //Editar
        function editar(id)
        {
        
            document.form1.id.value=id;
            document.form1.submit();
        
        }
        
        //buscar
        function buscaPos(valor, valor2)
        {
            document.form1.location_slot_selected.value=valor2;
            document.form1.storage.value=0;
            var strUserAgent = navigator.userAgent.toLowerCase(); 
            var isIE = strUserAgent.indexOf("msie") > -1; 
            var y=valor;
            var xmlhttp;
            var resultado;
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
                    resultado=xmlhttp.responseText;  
                    var m=document.getElementById('posiciones');
                    m.innerHTML=resultado;
                
                }
            }
                var tipo=0;
                xmlhttp.open("GET","buscaPos.php?id="+y+"&buscar="+valor2,true);
                xmlhttp.send();
            return false;		
        }
        
        //validar
        function validar()
        {
            var tubo=document.form1.location_slot.value.split("|");
            var tubo2=document.form1.location_slot_selected.value;
            
            var fiberid = $('#id_fiber').val();
            if(fiberid == "")
            {
                alert("Seleccione Fibra");
                document.form1.fiber_id.focus();
                return false;
            }else if(document.form1.retail_length.value=="")
            {
                alert("Escriba Longitud del proveedor");
                document.form1.retail_length.focus();
                return false;
            }else if(document.form1.guaranteed_length.value=="")
            {
                alert("Escriba Longitud garantizada");
                document.form1.guaranteed_length.focus();
                return false;
            }else if(document.form1.remaining_inches.value=="")
            {
                alert("Pulgadas Restantes");
                document.form1.remaining_inches.focus();
                return false;
            }else if(document.form1.location_id.value!="0" && document.form1.location_slot.value=="0|0")
            {
                alert("Seleccione Posicion en la maquina");
                document.form1.location_slot.focus();
                return false;
            }else if(document.form1.location_id.value!="0" && document.form1.location_slot.value!="0|0" && tubo[1]!="" && tubo2!=tubo[0])
            {
                alert("Esa posicion esta ocupada");
                document.form1.location_slot.focus();
                return false;
            }
            else if(document.form1.location_id.value=="0" && document.form1.storage.value=="0")
            {
                alert("Seleccione almacen o Maquina");
                document.form1.storage.focus();
                return false;
            }else if(document.form1.state_id.value=="0")
            {
                alert("Seleccione Estado del rollo");
                document.form1.state_id.focus();
                return false;
            }else if(document.form1.lote.value=="" )
            {
                alert("Escriba Lote");
                document.form1.lote.focus();
                return false;
            }
            else if(document.form1.location_id.value!="0" && document.form1.location_slot.value!="0|0" && document.form1.storage.value!="0")
            {
                alert("No se puede  estar en maquina y en almacen");
                document.form1.lote.focus();
                return false;
            } else if((document.form1.location_anterior.value=="0" ) && (document.form1.state_id.value=="4" || document.form1.state_id.value=="5" || document.form1.state_id.value==""))
            {
                alert("Debes cambiar estatus a En Produccion");
                document.form1.lote.focus();
                return false;
            }
        }

        function sele_bodega(valor)
        {
            if(valor!="0")
            {
                document.form1.location_id.value="0";
                document.form1.location_slot.value="0";	
            }
        }

        function seleccionaLugar(){
            document.form1.lugar_b.value=document.form2.lugar_b.value;
            

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
        <? include "menu_f.php"?>
        <!-- /.navbar-static-side -->
    </nav>
    <div id="page-wrapper">
        <div class="row">
            <h1 class="page-header">Rollos</h1>
                <div class="divider"></div>
                <div align="right"  class="popup" onClick="myFunction()" style="cursor:pointer;">
                    <strong>
                        <span class="style1 bg-primary">
                            &nbsp;&nbsp;?&nbsp;&nbsp;
                        </span>
                    </strong>
                    <span class="popuptext" id="myPopup">
                    <p align="left">
                        <strong>
                            Rollos
                        </strong>
                    </p>
                    <p align="left">
                        Permite agregar nuevos rollos al sistema, tambien muestra la lista de rollos no terminados y permite filtrar por Lugar y almacen .
                    </p>
                    <div align="left">
                        <ul>
                            <li>
                                <strong>
                                    MO
                                </strong>
                                : Numero de Orden
                            </li>
                            <li>
                                <strong>
                                    Tipo de corte
                                </strong>
                                    : Identifica el tipo del corte a realizar
                            </li>
                            <li><strong>Programa</strong>: Catalogo de programas</li>
                            <li><strong>Numero de parte:</strong> de acuerdo al programa elegido muestra la lista de partes relacionadas a ese programa.</li>
                            <li><strong>Fibra</strong>: Muestra el listado de las fibras relacionadas al numero de parte elegido.</li>
                            <li><strong>Lugar</strong>: Catalogo de maquinas    </li>
                        </ul>
                    </div>
                </div>
                                    
                <div class="divider"></div>
            <form name="form1" action="" method="post" class="margin-bottom" accept-charset="utf-8">                                                <div class="form-group">
              <div class="col-sm-6 col-md-4 col-lg-4">
              <label for="f_id">Fibra:</label>
                                <input name="id" type="hidden" id="id" value="<? echo"$id";?>">
                                <input name="borrar" type="hidden" id="borrar">
								<input name="lugar_b" type="hidden" id="lugar_b" value="<? echo $_POST["lugar_b"];?>">
                                
                                <input type="text" name="fiber_id" list="fiber_id" id="f_id" class="form-control" require>
                                <datalist id="fiber_id">
                                    <?	
                                    $consulta  = "SELECT id,";
                                    $consulta .= "substring(fiber_type,3) AS ftype,";
                                    $consulta .= "fiber_type ";
                                    $consulta .= "FROM roll_fibers ";
                                    $consulta .= "WHERE deleted_at is null ";
                                    $consulta .= "ORDER BY fiber_type";
                                    $resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
                                    while($fiber = mysql_fetch_assoc($resultado))
									{
									?>
										<option id="<? echo $fiber['fiber_type']?>" value="<? echo $fiber['ftype']?>" ></option>
									<?
									}
									?>
                                </datalist>
                                <input type="hidden" value="" name="id_fiber" id="id_fiber"/>
              </div>

                            <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="retail_length">Gross:</label>
                                (Yardas)
                                <input type="text" class="form-control" id="retail_length" name="retail_length"
                                       value=""/>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="guaranteed_length">Net:</label>
                                (Yardas)
                                <input type="text" class="form-control" id="guaranteed_length" name="guaranteed_length"
                                       value=""/>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="remaining_inches">Real Restantes:</label>
                                ( Yardas)
                                <input type="text" class="form-control" id="remaining_inches" name="remaining_inches" 
                                       value=""/>
                            </div>
              <div class="col-sm-6 col-md-4 col-lg-4">
                                <label for="location_id">Maquina:</label>
                                
                                <input name="location_anterior" type="hidden" id="location_anterior">
                                <select class="form-control" id="location_id" name="location_id" onChange="buscaPos(location_id.value, '0');">
                                  <option value="0" selected="selected">--Selecciona Lugar--</option>
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
              <div class="col-sm-6 col-md-4 col-lg-2" id="posiciones">
                                <label for="slot">Tubo:</label>
                                <input name="location_slot_selected" type="hidden" value="">
                                
                                <select class="form-control" id="location_slot" name="location_slot">
                                </select>
              </div>

              <div class="col-sm-6 col-md-3 col-lg-3">
                                <label for="state_id">Estado:</label>
                                <input name="state_id2" type="hidden" value="">
                                <select class="form-control" id="state_id" name="state_id">
                                  <option value="0" selected="selected">--Selecciona Estado--</option>
                                  <?	  
	$consulta  = "SELECT id, description FROM roll_states where deleted_at is null and (id=2 or id=3 or id=4) ";
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
					 <div class="col-sm-6 col-md-3 col-lg-3">
                                <label for="location_id">Almacen:</label>
                                
                                <select class="form-control" id="storage" name="storage" onChange="sele_bodega(this.value)">
                                  <option value="0" selected="selected">--Selecciona Almacen--</option>
                                  <?	  
	$consulta  = "SELECT id, name FROM storage where deleted_at is null";
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
					 		<div class="col-sm-6 col-md-3 col-lg-3">
                                <label for="retail_length">Numero Lote:</label>
                                <input type="text" class="form-control" id="lote" name="lote"
                                       value=""/>
                            </div>
								<div class="col-sm-6 col-md-3 col-lg-3">
                                <label for="guaranteed_length">Fecha Lote:</label>
                                <input name="flote" type="text" class="form-control" id="flote"
                                       value="<? echo"$flote"; ?>" size="10" placeholder="Fecha Lote"  />
			 </div>
										 
					
              <div class="col-sm-6 col-md-12 col-lg-3">
                <input type="submit" class="btn red-submit button-form" name="guardar"
                                       value="Guardar" onClick="return validar();"/>
              </div>
				 <div class="col-sm-6 col-md-12 col-lg-3">
                                
                                <input type="button" class="btn red-submit button-form" name="guardar2"
                                       value="Cancelar" onClick="window.location='rollos.php';"/>
                </div>
                            <div class="clearfix"></div>
                        </div>
					
</form>
                                        </div>
<form name="form2" action="" method="post" class="margin-bottom" accept-charset="utf-8">
        <div class="col-lg-12 table-responsive">
                                            <table class="table table-striped table-condensed">
                     <thead>
					<tr><th colspan="3">
                      <select class="form-control" id="lugar_b" name="lugar_b"  style="width:150" onChange="seleccionaLugar()">
                        <option value="<? echo $filtro; ?>" >--Selecciona Lugar--</option>
                        <?	  
	$consulta  = "SELECT id, name FROM locations where deleted_at is null";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	$count=1;
	while(@mysql_num_rows($resultado)>=$count)
	{
		$res=mysql_fetch_row($resultado);
		if($res[0]==$_POST['lugar_b'] || $res[0]==$_GET['lugar_b'])
		{
		echo"<option value=\"$res[0]\" selected>$res[1]</option>";
		if($res[0]==$_POST['lugar_b'])
			$lugar_b=$_POST['lugar_b'];
		if($res[0]==$_GET['lugar_b'])
			$lugar_b=$_GET['lugar_b'];
		}
		else
		echo"<option value=\"$res[0]\" >$res[1]</option>";
		$count=$count+1;
	}	
		
		?>
                      </select>
                    </th>
                    <th colspan="3">
                      <select class="form-control" id="almacen_b" name="almacen_b" onChange="sele_bodega(this.value)" style="width:150">
                        <option value="0" >--Selecciona Almacen--</option>
                        <?	  
	$consulta  = "SELECT id, name FROM storage where deleted_at is null";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	$count=1;
	while(@mysql_num_rows($resultado)>=$count)
	{
		$res=mysql_fetch_row($resultado);
		if($res[0]==$_POST['almacen_b'])
		echo"<option value=\"$res[0]\" selected>$res[1]</option>";
		else
		echo"<option value=\"$res[0]\" >$res[1]</option>";
		
		$count=$count+1;
	}	
		
		?>
                      </select>
                    </th>
                    <th colspan="3"><input name="lote_b" type="text" class="form-control" id="lote_b" value="<? echo $_POST['lote_b'];?>" size="15" placeholder="Fibra" ></th>
                    <th>&nbsp;</th>
                    <th><span class="col-sm-6 col-md-12 col-lg-3">
                      <input type="submit" class="btn red-submit button-form" name="buscar" value="Buscar"/>
                    </span></th>
                    <th><a href="exportar_rolls.php" target="_blank"><img src="images/descarga.png" width="46" height="46" border="0" title="Exportar"></a></th> <th><a href="exportar_rolls_suma.php" target="_blank"><img src="images/descarga.png" width="46" height="46" border="0" title="Exportar_Sumarizado"></a></th>
					</thead>
					<thead>
					<th>Lote</th>
                    <th>Fibra</th>
                    <th>Long. de proveedor</th>
                    <th>Long. garantizada</th>
                    <th>Total usado</th>
                    <th>Long. restante</th>
                    <th>Lugar</th>
                    <th>Tubo</th>
					<th>Almacen</th>
                    <th>Estado</th>
					<th>Actualizado por:</th>

                    <th>Editar</th>
                    <th>Eliminar</th>
                    </thead>
                    <tbody>
	<?	 
	if($_POST['buscar']!="Buscar" )
	{ 
	if($_POST['lugar_b']!="0" && $_POST['lugar_b']!="")
	{
		$buscarr=" location_capacities.id_location=".$lugar_b." and ";
		$orden=" order by locations.name, location_capacities.number ";//$orden=" order by location_capacities.number ";
	}
	$consulta  = "SELECT rolls.id,  lote, fiber_type, retail_length, FORMAT(guaranteed_length/36,2), FORMAT((guaranteed_length-remaining_inches)/36,2), FORMAT(remaining_inches/36,2), locations.name, location_capacities.number, roll_states.description, storage.name, state_id, u.username,DATE_FORMAT(date_lote, '%m-%d-%Y')  FROM rolls inner join roll_fibers on rolls.fiber_id=roll_fibers.fiber_type inner join roll_states on rolls.state_id=roll_states.id
left outer join  location_capacities on location_capacities.id=rolls.location_slot  
left outer join locations on location_capacities.id_location=locations.id 
left outer join storage on storage.id=rolls.storage_id
LEFT OUTER JOIN users u ON rolls.Update_by=u.id
where $buscarr rolls.deleted_at is null  and rolls.state_id<4 order by locations.name, location_capacities.number";
//echo"1 $consulta";
}
else
{
$buscarr="";
if($_POST['lote_b']!="")
	$buscarr="$buscarr fiber_id like'%".$_POST['lote_b']."%' and ";
if($_POST['lugar_b']!="0" && $_POST['lugar_b']!="")
{
	$buscarr="$buscarr location_capacities.id_location=".$lugar_b." and ";
	$orden=" order by locations.name, location_capacities.number ";//$orden=" order by location_capacities.number ";
}
if($_POST['almacen_b']!="0")
{
	$buscarr="$buscarr rolls.storage_id=".$_POST['almacen_b']." and ";
	$orden=" order by locations.name, location_capacities.number ";//$orden=" order by rolls.fiber_id ";
}
$consulta  = "SELECT rolls.id,  lote, fiber_type, retail_length, FORMAT((guaranteed_length)/36,2), FORMAT((guaranteed_length-remaining_inches)/36,2), FORMAT(remaining_inches/36,2), locations.name, location_capacities.number, roll_states.description, storage.name, state_id, u.username,DATE_FORMAT(date_lote, '%m-%d-%Y')  FROM rolls inner join roll_fibers on rolls.fiber_id=roll_fibers.fiber_type inner join roll_states on rolls.state_id=roll_states.id
left outer join  location_capacities on location_capacities.id=rolls.location_slot  
left outer join locations on location_capacities.id_location=locations.id 
left outer join storage on storage.id=rolls.storage_id
LEFT OUTER JOIN users u ON rolls.Update_by=u.id
where $buscarr  rolls.deleted_at is null and rolls.state_id<4 $orden";
//echo"2 $consulta";
}
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1:$consulta " . mysql_error());
	$count=1;
	while(@mysql_num_rows($resultado)>=$count)
	{
		$res=mysql_fetch_row($resultado);
		
		
		?>
		 <tr>
			<td><? echo"$res[1] $res[13]"; ?></td>
			<td><? echo"$res[2]"; ?></td>
			<td><? echo"$res[3]"; ?></td>
			<td><? echo"$res[4]"; ?></td>
			<td><? echo"$res[5]"; ?></td>
			<td><? echo"$res[6]"; ?></td>
			<td><? echo"$res[7]"; ?></td>
			<td><? echo"$res[8]"; ?></td>
			<td><? echo"$res[10]"; ?></td>
			<td><? echo"$res[9]"; ?></td>
			<td><? echo"$res[12]"; ?></td>
			<td class="text-center"><?  if($res[11]<4){?><a href="javascript:editar(<? echo"$res[0]"; ?>);"><i class="fa fa-pencil-square-o"></i></a><? }?></td>
			<td class="text-center"><? if($res[11]<4){?><a href="javascript:borrar(<? echo"$res[0]"; ?>);"><i class="fa fa-times"></i></a><? }?></td>
		</tr>
		<?
		$count=$count+1;
	}	
		
		?>
                                        </tbody>
                </table>
      </div>
</form>  
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
		
<? if($id!=""){?>
	document.form1.fiber_id.value='<? echo"$res8[2]";?>';
	document.form1.retail_length.value='<? echo"$res8[3]";?>';
	document.form1.guaranteed_length.value='<? echo"$res8[4]";?>';
	document.form1.remaining_inches.value='<? echo"$res8[5]";?>';
	document.form1.location_id.value='<? echo"$res8[6]";?>';
	document.form1.location_anterior.value='<? echo"$res8[6]";?>';
	buscaPos('<? echo"$res8[6]";?>','<? echo"$res8[7]";?>');
	
	document.form1.state_id.value='<? echo"$res8[8]";?>';
	document.form1.state_id2.value='<? echo"$res8[8]";?>';
	document.form1.storage.value='<? echo"$res8[9]";?>';
	document.form1.lote.value='<? echo"$res8[1]";?>';
	//document.form1.location_slot.value='<? echo"$res8[7]";?>';
	

<? }?>		
    </script>
    
</footer>
</body>
</html>