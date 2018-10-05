<?php
    session_start();
    include "coneccion.php";
    include "checar_sesion_admin.php";
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
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script> -->
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <!-- [if lt IE 9]> -->
        <script src="https://code.highcharts.com/modules/oldie.js"></script>
        <!--[endif]-->
        
        
        <script>
            //funcion para el popup.
            function myFunction()
            {
                var popup = document.getElementById("myPopup");
                popup.classList.toggle("show");
            }
            
            $(document).ready(function(){

                //calendario
                $('.datepicker').datepicker();

                // grafica 1
                Highcharts.chart('container1',{
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie'
                    },
                    title: {
                        text: 'Tiempo Completo'
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: false
                            },
                            events:{
                                click: function (event) {
                                    var name = event.point.name;
                                    alert(name);
                                    // add your redirect code and u can get data using event.point
                                }
                            },
                            showInLegend: false
                        }
                    },
                series:
                [{
                    name: 'Brands',
                    colorByPoint: true,
                    data: [{
                        name: 'Chrome',
                        y: 61.41,
                        sliced: true,
                        selected: true
                    }, {
                        name: 'Internet Explorer',
                        y: 11.84
                    }, {
                        name: 'Firefox',
                        y: 10.85
                    }, {
                        name: 'Edge',
                        y: 4.67
                    }, {
                        name: 'Safari',
                        y: 4.18
                    }, {
                        name: 'Other',
                        y: 7.05,
                }]
            }]
            });
           

            // grafica 2
                Highcharts.chart('container2',{
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie'
                    },
                    title: {
                        text: 'Mantenimiento'
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: false
                            },
                            events:{
                                click: function (event) {
                                    var name = event.point.name;
                                    alert(name);
                                    // add your redirect code and u can get data using event.point
                                }
                            },
                            showInLegend: false
                        }
                    },
                series:
                [{
                    name: 'Brands',
                    colorByPoint: true,
                    data: [{
                        name: 'Chrome',
                        y: 61.41,
                        sliced: true,
                        selected: true
                    }, {
                        name: 'Internet Explorer',
                        y: 11.84
                    }, {
                        name: 'Firefox',
                        y: 10.85
                    }, {
                        name: 'Edge',
                        y: 4.67
                    }, {
                        name: 'Safari',
                        y: 4.18
                    }, {
                        name: 'Other',
                        y: 7.05,
                }]
            }]
            });

            // grafica 3
                Highcharts.chart('container3',{
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie'
                    },
                    title: {
                        text: 'Tiempo Operador'
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: false
                            },
                            events:{
                                click: function (event) {
                                    var name = event.point.name;
                                    alert(name);
                                    // add your redirect code and u can get data using event.point
                                }
                            },
                            showInLegend: false
                        }
                    },
                series:
                [{
                    name: 'Brands',
                    colorByPoint: true,
                    data: [{
                        name: 'Chrome',
                        y: 61.41,
                        sliced: true,
                        selected: true
                    }, {
                        name: 'Internet Explorer',
                        y: 11.84
                    }, {
                        name: 'Firefox',
                        y: 10.85
                    }, {
                        name: 'Edge',
                        y: 4.67
                    }, {
                        name: 'Safari',
                        y: 4.18
                    }, {
                        name: 'Other',
                        y: 7.05,
                }]
            }]
            });


            });
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
                    <h1 class="page-header">Reporte ejecutivo de tiempos muertos</h1>
                    <div class="divider">
                    </div>
                    <div align="right"  class="popup" >
                        <strong>
                            <span class="style1 bg-primary" onClick="myFunction()" style="cursor:pointer;">
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
                        </span>
                    </div>

                    <!-- Maquina(lectras) -->
                    <div class="col-sm-6 col-md-3 col-lg-3">
                        <label for="location_id">
                            Maquina:
                        </label>
                        <select class="form-control" id="location_id" name="location_id">
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
                    
                    <!-- fecha desde -->
                    <div class="col-sm-6 col-md-3 col-lg-3">
                        <label for="desde">
                            Desde:
                        </label>
                        <input class="datepicker form-control" data-date-format="mm/dd/yyyy" value="" id="desde" name="desde" readonly />
                    </div>

                    <!-- hasta -->
                    <div class="col-sm-6 col-md-3 col-lg-3">
                        <label for="hasta">
                            Hasta:
                        </label>
                        <input class="datepicker form-control" data-date-format="mm/dd/yyyy" value="" id="hasta" name="hasta" readonly/>
                    </div>

                    <!-- turno -->
                    <div class="col-sm-6 col-md-3 col-lg-3">
                        <label for="turno">
                            Turno:
                        </label>
                        <select class="form-control" id="turno" name="turno">
                            <option value="0" selected="selected">--Selecciona Turno--</option>
                           
                        </select>
                    </div>

                    <div class="col-sm-12 col-md-12 col-lg-12">
                        
                    </div>

                    <!-- grafica 1 -->
                    <div class="col-sm-6 col-md-4 col-lg-4">
                        <div id="container1"></div>
                    </div>

                    <!-- grafica 2 -->
                    <div class="col-sm-6 col-md-4 col-lg-4">
                        <div id="container2"></div>
                    </div>

                    <!-- grafica 3 -->
                    <div class="col-sm-6 col-md-4 col-lg-4">
                       <div id="container3"></div>
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
        </footer>
    </body>
</html>