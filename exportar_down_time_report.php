<?
    session_start();
    include "coneccion.php";
    include "checar_sesion_admin.php";

    setlocale(LC_TIME, 'spanish');  
    $fecha=mb_convert_encoding (strftime("%A %d de %B del %Y"), 'utf-8');

    $hora=date("h:i A");

    header("Content-type: application/vnd.ms-excel; name='excel'");
    header("Pragma: no-cache");
    header("Expires: 0");
    header("Content-Disposition: filename=down_time_report.xls");

    $idU=$_SESSION['idU'];
    $nombreU=$_SESSION['nombreU'];
    $tipoU=$_SESSION['tipoU'];
    $locationU=$_SESSION['location'];
    $desde= $_GET["desde"];
    $hasta= $_GET["hasta"];
    $lugar_b= $_GET["lugar_b"];
    $tipo_b= $_GET["tipo_b"];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Zodiac - Cortes</title>
        <style type="text/css">
            a {color: #FFFFFF; }
        </style>
    </head>

    <body >		 
        <table class="table table-striped table-condensed grid">
            <thead>
                <tr>
                    <th width="5%">Fecha</th>                  
                    <th width="5%">Ubicación</th>
                    <th width="11%">Tipo Paro </th>
                    <th width="11%">Inicio</th>                       
                    <th width="6%">Fin</th>
                    <th width="8%">Tiempo</th>
                    <th width="6%">Autorizo</th>
                </tr>
            </thead>
            <tbody>                             
                <?	  
                    if($_GET['lugar_b']!="0"){
                        $buscar1="cut_pause.location_id=".$_GET['lugar_b']." AND";
                    }
                    if($_GET['tipo_b']!="0"){
                        $buscar2="razon_id=".$_GET['tipo_b']." AND";
                    }
                    if($_GET['turno_b']!="0"){
                        $buscar3="cut_pause.turno=".$_GET['turno_b']." AND";
                    }else{
                        $buscar3="cut_pause.turno<>4 AND";
                    }
                    //$variable buscarl estaba mal escrita en la consulta.
                    $consulta="SELECT  DATE_FORMAT(inicio, '%Y-%m-%d') as inicio, DATE_FORMAT(fin, '%Y-%m-%d') as fin, reason,razon_id,  FORMAT(TIME_TO_SEC(timediff(fin, inicio))/60,0) as d2, locations.name, first_name, last_name, autorized_by FROM `cut_pause` inner join down_time_reason on cut_pause.razon_id=down_time_reason.id inner join locations on cut_pause.location_id=locations.id left outer join users on cut_pause.autorized_by=users.id where $buscar1 $buscar2 $buscar3   DATE_FORMAT(inicio, '%Y-%m-%d')>='".$_GET['desde']."' and DATE_FORMAT(inicio, '%Y-%m-%d')<='".$_GET['hasta']."'  ";
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
                <?  }
                ?>
            </tbody>                     
        </table>
    </body>
</html>