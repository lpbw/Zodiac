<?php
    session_start();
    include "coneccion.php";
    include "checar_sesion_admin.php";
    $Hoy = date('Y-m-d');
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
        <!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
        <!-- <script src="https://code.highcharts.com/highcharts.js"></script> -->
        <!-- [if lt IE 9]> -->
        <!-- <script src="https://code.highcharts.com/modules/oldie.js"></script> -->
        <!--[endif]-->
        
        
        <script>
           
            //funcion para el popup.
            // function myFunction()
            // {
            //     var popup = document.getElementById("myPopup");
            //     popup.classList.toggle("show");
            // }
           

 
            $(document).ready(function(){
                //calendario
                $('.datepicker').datepicker({dateFormat: 'yy-mm-dd'});
            });

        </script>
        <!-- <style>
        .loader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('images/cargando.gif') 50% 50% no-repeat rgb(249,249,249);
    opacity: 1;
    display: none;
}
        </style> -->
    </head>
    <body>
        <!-- <div class="loader"></div> -->
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
                    <h1 class="page-header">Dead time executive report</h1>
                    <div class="divider">
                    </div>
                    <div align="right"  class="popup" >
                        <strong>
                            <span class="style1 bg-primary" onClick="myFunction()" style="cursor:pointer;">
                                &nbsp;&nbsp;?&nbsp;&nbsp;
                            </span>
                        </strong>
                        <!-- <span class="popuptext" id="myPopup">
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
                                    <li>
                                        <strong>
                                             Programa
                                        </strong>
                                            : Catalogo de programas
                                    </li>
                                    <li>
                                        <strong>
                                            Numero de parte:
                                        </strong> 
                                            de acuerdo al programa elegido muestra la lista de partes relacionadas a ese programa.
                                    </li>
                                    <li>
                                        <strong>
                                            Fibra
                                        </strong>
                                            : Muestra el listado de las fibras relacionadas al numero de parte elegido.
                                    </li>
                                    <li>
                                        <strong>
                                            Lugar
                                        </strong>
                                            : Catalogo de maquinas
                                    </li>
                                </ul>
                            </div>
                        </span> -->
                    </div>
                    
                    <!-- fecha desde -->
                    <div class="col-sm-6 col-md-3 col-lg-3">
                        <label for="desde">
                            From:
                        </label>
                        <input class="datepicker form-control" data-date-format="mm/dd/yyyy" value="<? echo $Hoy?>" id="desde" name="desde" readonly/>
                    </div>

                    <!-- hasta -->
                    <div class="col-sm-6 col-md-3 col-lg-3">
                        <label for="hasta">
                            To:
                        </label>
                        <input class="datepicker form-control" data-date-format="mm/dd/yyyy" value="<? echo $Hoy?>" id="hasta" name="hasta" readonly/>
                    </div>

                    <!-- Maquina(lectras) -->
                    <div class="col-sm-6 col-md-2 col-lg-2">
                        <label for="maquina">
                            Lectra:
                        </label>
                        <select class="form-control" id="maquina" name="maquina">
                            <option value="0" selected="selected">--All--</option>
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
                        <input type="hidden" name="ta" id="ta" value="0">
                    </div>

                    <!-- turno -->
                    <div class="col-sm-6 col-md-2 col-lg-2">
                        <label for="turno">
                            Turn:
                        </label>
                        <select class="form-control" id="turno" name="turno">
                            <option value="0" selected="selected">--All--</option>
                            <option value="1" >First Turn</option>
                            <option value="2" >Second shift</option>
                            <option value="3" >Third shift</option>
                        </select>
                    </div>
                    
                    <!-- boton buscar -->
                    <div class="col-sm-6 col-md-2 col-lg-2">
                        <input type="button" class="btn red-submit button-form" name="buscar" value="Search" onclick="Buscar();"/>
                    </div>


                    <div class="col-sm-12 col-md-12 col-lg-12">
                        
                    </div>

                    <!-- grafica 1 -->
                    <div class="col-sm-6 col-md-4 col-lg-4" >
                        <label for="myChart1"><b> Total time</b></label> 
                        <canvas id="myChart1"></canvas>
                    </div>

                    <!-- grafica 2 -->
                    <div class="col-sm-6 col-md-4 col-lg-4">
                        <label for="myChart2"><b> Maintenance</b></label> 
                        <canvas id="myChart2"></canvas>
                    </div>

                    <!-- grafica 3 -->
                    <div class="col-sm-6 col-md-4 col-lg-4">
                       <label for="myChart3"><b> Operator Time</b></label> 
                        <canvas id="myChart3"></canvas>
                    </div>	       

										<!-- tabla de totales -->
                    <div class="col-sm-12 col-md-12 col-lg-12">
											<label><b> Total time</b></label> 
											<table class="table table-striped table-condensed">
												<thead>
													<th>From</th>
													<th>To</th>
													<th>active</th>
													<th>Maintenance</th>
													<th>Operator</th>
												</thead>
												<tbody>
													<tr id="tabletotal">
														
													</tr>
												</tbody>
											</table>
                    </div>

										<!-- tabla de mantenimientos -->
                    <div class="col-sm-12 col-md-12 col-lg-12">
											<label><b> Maintenance</b></label> 
											<table class="table table-striped table-condensed">
												<thead>
													<th>From</th>
													<th>To</th>
													<th>FAILURE</th>
													<th>Paro Mtto. Lectra</th>
													<th>Paro Mtto. IT</th>
													<th>Paro Mtto</th>
												</thead>
												<tbody>
													<tr id="tablemantenimiento">
														
													</tr>
												</tbody>
											</table>
                    </div>

										<!-- tabla de operador -->
                    <div class="col-sm-12 col-md-12 col-lg-12">
											<label><b> Operador</b></label> 
											<table class="table table-striped table-condensed">
												<thead>
													<th>From</th>
													<th>To</th>
													<th>Eat</th>
													<th>Nurcering</th>
													<th>Stop for 5's</th>
													<th>Roll change</th>
													<th>Impression in process</th>
													<th>Head marking</th>
													<th>Bath room</th>
													<th>Waiting  MO</th>
												</thead>
												<tbody>
													<tr id="tableoperador">
														
													</tr>
												</tbody>
											</table>
                    </div>

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

            <!-- grafica -->
            <script>

                //Tiempo completo
                var ctx = document.getElementById("myChart1");
                var myChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ["Active", "Maintenance", "Operator"],
                        datasets: [{
                            label: "Total time",
                            data: [0,0,0],
                            backgroundColor: [
                                'rgba(118, 183, 102, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 99, 132, 1)'
                            ],
                            borderColor: [
                                'rgba(118, 183, 102, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255,99,132,1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                                showAllTooltips: true,
                                legend: {
                                    labels: {
                                        // This more specific font property overrides the global property
                                        fontColor: 'white'
                                    }
                                }
                    }
                });

                //manteniemiento
                var ctx2 = document.getElementById("myChart2");
                var myChart2 = new Chart(ctx2, {
                    type: 'pie',
                    data: {
                        labels: ["Failure", "Stop Mtto. Lectra", "Stop Mtto. IT","Stop Mtto."],
                        datasets: [{
                            label: "Maintenance",
                            data: [0,0,0,0],
                            backgroundColor: [
                                'rgba(118, 183, 102, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(194, 0, 0, 1)'
                            ],
                            borderColor: [
                                'rgba(118, 183, 102, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(194, 0, 0, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                                legend: {
                                    labels: {
                                        // This more specific font property overrides the global property
                                        fontColor: 'white'
                                    }
                                }
                    }
                });
                
                //operadores y setup
                var ctx3 = document.getElementById("myChart3");
                var myChart3 = new Chart(ctx3, {
                    type: 'pie',
                    data: {
                        labels: ["Eat.","Nurcering","Stop for 5's","Roll change","Impression in process", "Head marking","Bath room","Waiting  MO"],
                        datasets: [{
                            label: "Tiempo Total",
                            data: [0,0,0,0,0,0,0,0],
                            backgroundColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(118, 183, 102, 1)',
                                'rgba(25, 82, 173, 1)',
                                'rgba(182, 26, 167, 1)',
                                'rgba(231, 225, 54, 1)',
                                'rgba(232, 186, 227, 1)'
                            ],
                            borderColor: [
                                'rgba(255,99,132,1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(118, 183, 102, 1)',
                                'rgba(25, 82, 173, 1)',
                                'rgba(182, 26, 167, 1)',
                                'rgba(231, 225, 54, 1)',
                                'rgba(232, 186, 227, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                                legend: {
                                    labels: {
                                        // This more specific font property overrides the global property
                                        fontColor: 'white'
                                    }
                                }
                    }
                });
                    
                // Actualilzar
                function Buscar()
                {
                    // $(".loader").show();
                   var Desde = $("#desde").val();
                   var Hasta = $("#hasta").val();
                   var Maquina = $("#maquina").val();
                   var Turno =$("#turno").val();
                   var parametros = {
                        "desde" : Desde,
                        "hasta" : Hasta,
                        "maquina" : Maquina,
                        "turno" : Turno
                    };
                    //buscar grafica 1
                    $.ajax({
                        type: 'POST',
                        url: "valoresgraficas.php?grafica=1",
                        data: parametros,
                        dataType: 'json',
                        cache: false,
                        beforeSend: function( xhr ) {
                            
                        }
                    })
                    .done(function( response ) {
                        //alert(response);
                         myChart.data.showAllTooltips = false;
                        myChart.data.labels=["Active ("+response[0]+")", "Mantenance ("+response[1]+")", "Operator ("+response[2]+")"];
                        myChart.data.datasets[0].data=[response[0],response[1],response[2]];
                        myChart.update();
												$('#tabletotal').html("<td>"+Desde+"</td><td>"+Hasta+"</td><td>"+response[0]+"</td><td>"+response[1]+"</td><td>"+response[2]+"</td>");
                        // $(".loader").hide(4000);
                    });
                   
                   //buscar grafica 2
                    $.ajax({
                        type: 'POST',
                        url: "valoresgraficas.php?grafica=2",
                        data: parametros,
                        dataType: 'json',
                        cache: false,
                        beforeSend: function( xhr ) {
                            
                        }
                    })
                    .done(function( response ) {
                        //alert(response);
                        myChart2.data.labels=["Failure("+response[0]+")", "Stop Mtto. Lectra ("+response[1]+")", "Stop Mtto. IT ("+response[2]+")","Stop Mtto ("+response[3]+")"];
                        myChart2.data.datasets[0].data=[response[0],response[1],response[2],response[3]];
                        myChart2.update();
												$('#tablemantenimiento').html("<td>"+Desde+"</td><td>"+Hasta+"</td><td>"+response[0]+"</td><td>"+response[1]+"</td><td>"+response[2]+"</td><td>"+response[3]+"</td>");
                        // $(".loader").hide(4000);
                    });
                    
                    //buscar grafica 3
                    $.ajax({
                        type: 'POST',
                        url: "valoresgraficas.php?grafica=3",
                        data: parametros,
                        dataType: 'json',
                        cache: false,
                        beforeSend: function( xhr ) {
                            
                        }
                    })
                    .done(function( response ) {
                        //alert(response);
                        myChart3.data.labels=["Eat ("+response[0]+")","Nurcering ("+response[1]+")","stop for 5's ("+response[2]+")","Roll change ("+response[3]+")","Impression in process ("+response[4]+")", "Head marking ("+response[5]+")","Bath room ("+response[6]+")","Waiting  MO ("+response[7]+")"]
                        myChart3.data.datasets[0].data=[response[0],response[1],response[2],response[3],response[4],response[5],response[6],response[7]];
                        myChart3.update();
												$('#tableoperador').html("<td>"+Desde+"</td><td>"+Hasta+"</td><td>"+response[0]+"</td><td>"+response[1]+"</td><td>"+response[2]+"</td><td>"+response[3]+"</td><td>"+response[4]+"</td><td>"+response[5]+"</td><td>"+response[6]+"</td><td>"+response[7]+"</td>");
                        // $(".loader").hide(4000);
                    });

                }
            </script>
        </footer>
    </body>
</html>