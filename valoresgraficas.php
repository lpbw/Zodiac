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

            /**Obtener tiempo activo  tabla cierre de turno*/
            $QueryTiempos = "SELECT SUM(tiempo) AS tiempo FROM cierre_turnos WHERE tipo=99 AND DATE_FORMAT(fecha,'%Y-%m-%d')>='$Desde' AND DATE_FORMAT(fecha,'%Y-%m-%d')<='$Hasta' ".$Filtro1.$Filtro2;
            $ResultadoTiempos = mysql_query($QueryTiempos) or die("Error en Tiempos $QueryTiempos".mysql_error());
            $ResulTiempos = mysql_fetch_assoc($ResultadoTiempos);
            $TiempoActivo = str_replace(",","",$ResulTiempos['tiempo']);
            //$TiempoActivo = $ResTiempos['tiempo'];

            /**Tiempos mantenimiento  obtenidos de la tabla  cut_pause*/
            $QueryMtto = "SELECT SUM(TIMESTAMPDIFF(minute,cp.inicio,cp.fin)) AS tiempo FROM cut_pause cp INNER JOIN down_time_reason dt ON cp.razon_id=dt.id WHERE dt.grupo=1 AND DATE_FORMAT(cp.inicio,'%Y-%m-%d') BETWEEN '$Desde' AND '$Hasta' ".$Filtro1.$Filtro2;
            $ResultadoMtto = mysql_query($QueryMtto) or die("Error en Tiempos $QueryMtto".mysql_error());
            $ResulMtto = mysql_fetch_assoc($ResultadoMtto);
            $TiempoMtto = str_replace(",","",$ResulMtto['tiempo']);
            //$TiempoMtto = $ResMtto['tiempo'];

            /**Tiempos operador  obtenidos de la tabla  cut_pause*/
            $QueryOperador = "SELECT SUM(TIMESTAMPDIFF(minute,cp.inicio,cp.fin)) AS tiempo FROM cut_pause cp INNER JOIN down_time_reason dt ON cp.razon_id=dt.id WHERE dt.grupo BETWEEN 2 AND 3 AND DATE_FORMAT(cp.inicio,'%Y-%m-%d') BETWEEN '$Desde' AND '$Hasta' ".$Filtro1.$Filtro2;
            $ResultadoOperador = mysql_query($QueryOperador) or die("Error en Tiempos $QueryOperador".mysql_error());
            $ResulOperador = mysql_fetch_assoc($ResultadoOperador);
            $TiempoOperador = str_replace(",","",$ResulOperador['tiempo']);
            // = $ResulOperador['tiempo'];
            
            $Datos = array($TiempoActivo, $TiempoMtto, $TiempoOperador);
            
            echo json_encode($Datos);
            //echo $TiempoActivo;
        break;
        
        //grafica 2
        case 2:
            $Falla = 0;
            $MttoLectra = 0;
            $MttoIt = 0;
            $Mtto = 0;

            //Cuando filtra por maquina
            if ($Maquina!=0)
            {
                $Filtro1 = "AND location_id=$Maquina ";
            }

            //Cuando filtra por turno
            if ($Turno==0)
            {
                $Filtro2 = "AND cut_pause.turno<>4";
            }
            else {
                $Filtro2 = "AND cut_pause.turno=$Turno";
            }

            $QueryMtto = "SELECT cut_pause.razon_id,FORMAT(TIME_TO_SEC(timediff(fin, inicio))/60,0) as tiempo FROM `cut_pause` inner join down_time_reason on cut_pause.razon_id=down_time_reason.id inner join locations on cut_pause.location_id=locations.id left outer join users on cut_pause.autorized_by=users.id where down_time_reason.grupo=1 AND DATE_FORMAT(inicio, '%Y-%m-%d')>='$Desde' and DATE_FORMAT(inicio, '%Y-%m-%d')<='$Hasta' AND cut_pause.fin<>'' ".$Filtro1.$Filtro2." ORDER BY cut_pause.id";
            $ResultadoMtto = mysql_query($QueryMtto) or die("Error en Mtto $QueryMtto".mysql_error());

            while ($ResMtto = mysql_fetch_assoc($ResultadoMtto))
            {
                $tiempo = str_replace(",","",$ResMtto['tiempo']);
                $Tipo = $ResMtto['razon_id'];
                
                switch ($Tipo)
                {
                    case 3:
                       $Falla = $Falla+$tiempo;
                    break;

                    case 16:
                       $MttoLectra = $MttoLectra+$tiempo;
                    break;

                    case 17:
                       $MttoIt = $MttoIt+$tiempo;
                    break;

                    case 18:
                       $Mtto = $Mtto+$tiempo;
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
            if ($Maquina!=0)
            {
                $Filtro1 = "AND location_id=$Maquina ";
            }

            //Cuando filtra por turno
            if ($Turno==0)
            {
                $Filtro2 = "AND cut_pause.turno<>4";
            }
            else {
                $Filtro2 = "AND cut_pause.turno=$Turno";
            }

            $QuerySetup = "SELECT cut_pause.razon_id,FORMAT(TIME_TO_SEC(timediff(fin, inicio))/60,0) as tiempo FROM `cut_pause` inner join down_time_reason on cut_pause.razon_id=down_time_reason.id inner join locations on cut_pause.location_id=locations.id left outer join users on cut_pause.autorized_by=users.id where DATE_FORMAT(inicio, '%Y-%m-%d')>='$Desde' and DATE_FORMAT(inicio, '%Y-%m-%d')<='$Hasta' AND cut_pause.fin<>'' ".$Filtro1.$Filtro2." ORDER BY cut_pause.id";
            $ResultadoSetup = mysql_query($QuerySetup) or die("Error en Setup $QuerySetup".mysql_error());
            $con=0;
            while ($ResSetup = mysql_fetch_assoc($ResultadoSetup))
            {
                /**Se agrego el str_replace porque se perdian los valores del tiempo ya que traian coma y los tomaba como string */
                $tiempo = str_replace(",","",$ResSetup['tiempo']);
                $Tipo = $ResSetup['razon_id'];
                $con++;
                switch ($Tipo)
                {
                    case 1:
                       $Comida = $Comida+$tiempo;
                    break;

                    case 4:
                       $Enfermeria = $Enfermeria+$tiempo;
                    break;

                    case 7:
                       $Paro5s = $Paro5s+$tiempo;
                    break;

                    case 8:
                       $CambioRollo = $CambioRollo+$tiempo;
                    break;

                    case 11:
                       $Impresion = $Impresion+$tiempo;
                    break;

                    case 20:
                       $Cabezal = $Cabezal+$tiempo;
                    break;

                    case 21:
                       $Banio = $Banio+$tiempo;
                    break;

                    case 23:
                       $EsperandoMo = $EsperandoMo+$tiempo;
                    break;

                    default:
                       # code...
                    break;
                }
                //echo $con."_".$Minutos."\n";
            }

            $Datos = array($Comida, $Enfermeria, $Paro5s,$CambioRollo,$Impresion,$Cabezal,$Banio,$EsperandoMo);
            
            echo json_encode($Datos);
        //echo $QuerySetup;
        break;

        default:
            # code...
        break;
    }

    
?>