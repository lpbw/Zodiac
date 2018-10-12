<?php
    include "coneccion.php";

    $Grafica = $_GET['grafica'];

    //Variables recibidas
    $Desde = $_POST['desde'];
    $Hasta = $_POST['hasta'];
    $Maquina = $_POST['maquina'];
    $Turno = $_POST['turno'];

    switch ($Grafica)
    {
        //grafica 1
        case 1:
            $TiempoActivo = 0;
            $TiempoMtto = 0;
            $TiempoOperador = 0;

            //Cuando filtra por maquina
            if ($Maquina==0)
            {
                $Filtro1 = "";
            }
            else {
                $Filtro1 = "AND location_id=$Maquina ";
            }

            //Cuando filtra por turno
            if ($Turno==0)
            {
                $Filtro2 = "AND turno<>4";
            }
            else {
                $Filtro2 = "AND turno=$Turno";
            }

            $QueryTiempos = "SELECT tiempo,grupo FROM cierre_turnos WHERE fecha>='$Desde' AND fecha<='$Hasta' ".$Filtro1.$Filtro2;
            $ResultadoTeimpos = mysql_query($QueryTiempos) or die("Error en Tiempos $QueryTiempos".mysql_error());
            
            while ($ResTiempos = mysql_fetch_assoc($ResultadoTeimpos))
            {
                $Grupo = $ResTiempos['grupo'];

                switch ($Grupo)
                {
                    case 0:
                        $TiempoActivo = $TiempoActivo+$ResTiempos['tiempo'];
                    break;
                    
                    case 1:
                        $TiempoMtto = $TiempoMtto+$ResTiempos['tiempo'];
                    break;

                    case 2:
                        $TiempoOperador = $TiempoOperador+$ResTiempos['tiempo'];
                    break;

                    case 3:
                        $TiempoOperador = $TiempoOperador+$ResTiempos['tiempo'];
                    break;

                    default:
                        # code...
                    break;
                }
            }
            
            $Datos = array($TiempoActivo, $TiempoMtto, $TiempoOperador);
            
            echo json_encode($Datos);
        break;
        
        //grafica 2
        case 2:
            $Falla = 0;
            $MttoLectra = 0;
            $MttoIt = 0;
            $Mtto = 0;

            //Cuando filtra por maquina
            if ($Maquina==0)
            {
                $Filtro1 = "";
            }
            else {
                $Filtro1 = "AND location_id=$Maquina ";
            }

            //Cuando filtra por turno
            if ($Turno==0)
            {
                $Filtro2 = "AND turno<>4";
            }
            else {
                $Filtro2 = "AND turno=$Turno";
            }

            $QueryMtto = "SELECT tiempo,tipo FROM cierre_turnos WHERE grupo=1 AND fecha>='$Desde' AND fecha<='$Hasta' ".$Filtro1.$Filtro2;
            $ResultadoMtto = mysql_query($QueryMtto) or die("Error en Mtto $QueryMtto".mysql_error());

            while ($ResMtto = mysql_fetch_assoc($ResultadoMtto))
            {
               $Tipo = $ResMtto['tipo'];

               switch ($Tipo)
               {
                    case 3:
                       $Falla = $Falla+$ResMtto['tiempo'];
                    break;

                    case 16:
                       $MttoLectra = $MttoLectra+$ResMtto['tiempo'];
                    break;

                    case 17:
                       $MttoIt = $MttoIt+$ResMtto['tiempo'];
                    break;

                    case 18:
                       $Mtto = $Mtto+$ResMtto['tiempo'];
                    break;

                    default:
                       # code...
                    break;
               }
            }
            
            $Datos = array($Falla, $MttoLectra, $MttoIt,$Mtto);
            
            echo json_encode($Datos);
        break;
        
        //grafica 3
        case 3:
            $Impresion = 0;
            $CambioRollo = 0;
            $Paro5s = 0;
            $Banio = 0;
            $Enfermeria = 0;
            $Cabezal = 0;
            $Comida = 0;
            $EsperandoMo = 0;

            //Cuando filtra por maquina
            if ($Maquina==0)
            {
                $Filtro1 = "";
            }
            else {
                $Filtro1 = "AND location_id=$Maquina ";
            }

            //Cuando filtra por turno
            if ($Turno==0)
            {
                $Filtro2 = "AND turno<>4";
            }
            else {
                $Filtro2 = "AND turno=$Turno";
            }

            $QuerySetup = "SELECT tiempo,tipo FROM cierre_turnos WHERE grupo>=2 AND grupo<=3 AND fecha>='$Desde' AND fecha<='$Hasta' ".$Filtro1.$Filtro2;
            $ResultadoSetup = mysql_query($QuerySetup) or die("Error en Setup $QuerySetup".mysql_error());

            while ($ResSetup = mysql_fetch_assoc($ResultadoSetup))
            {
               $Tipo = $ResSetup['tipo'];

               switch ($Tipo)
               {
                    case 1:
                       $Comida = $Comida+$ResSetup['tiempo'];
                    break;

                    case 4:
                       $Enfermeria = $Enfermeria+$ResSetup['tiempo'];
                    break;

                    case 7:
                       $Paro5s = $Paro5s+$ResSetup['tiempo'];
                    break;

                    case 8:
                       $CambioRollo = $CambioRollo+$ResSetup['tiempo'];
                    break;

                    case 11:
                       $Impresion = $Impresion+$ResSetup['tiempo'];
                    break;

                    case 20:
                       $Cabezal = $Cabezal+$ResSetup['tiempo'];
                    break;

                    case 21:
                       $Banio = $Banio+$ResSetup['tiempo'];
                    break;

                    case 23:
                       $EsperandoMo = $EsperandoMo+$ResSetup['tiempo'];
                    break;

                    default:
                       # code...
                    break;
               }
            }

            $Datos = array($Comida, $Enfermeria, $Paro5s,$CambioRollo,$Impresion,$Cabezal,$Banio,$EsperandoMo);
            
            echo json_encode($Datos);
        break;

        default:
            # code...
        break;
    }

    
?>