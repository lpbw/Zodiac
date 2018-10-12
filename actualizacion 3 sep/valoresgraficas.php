<?php
    include "coneccion.php";
    $TiempoActivo = 0;
    $TiempoMtto = 0;
    $TiempoOperador = 0;

    $QueryTiempos = "SELECT tiempo,grupo FROM cierre_turnos";
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
    
    echo $Datos;
?>