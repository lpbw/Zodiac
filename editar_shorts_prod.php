<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Zodiac</title><meta name="DESCRIPTION" content="">
<meta name="KEYWORDS" content="">
<link rel="stylesheet" href="public/css/style.css"/>
<link rel="stylesheet" href="public/css/font-awesome/css/font-awesome.min.css"/>
<link rel="stylesheet" href="public/css/bootstrap/bootstrap.min.css"/>
    <link rel="stylesheet" href="public/css/bootstrap/bootstrap-theme.min.css"/>
    <link rel="stylesheet" href="public/css/font-awesome/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="public/css/metisMenu/metisMenu.min.css"/>
    <link rel="stylesheet" href="public/css/sb-admin-2/sb-admin-2.css"/>
    <link rel="stylesheet" href="public/css/jqueryui/jquery-ui.min.css">
    <link rel="stylesheet" href="public/css/jqueryui/jquery-ui.structure.min.css">
    <link rel="stylesheet" href="public/css/jqueryui/jquery-ui.theme.min.css">
    <link rel="stylesheet" href="public/css/style.css"/>

<style type="text/css">
<!--
.style3 {color: #FFFFFF}
body {
	background-color: #363638;
}
-->
</style>
<script>
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval("window.location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
</script>
<?
session_start();
include "coneccion.php";


$locationU=$_SESSION['location'];
$id=$_GET['id'];

$pause_id= $_GET["pause_id"];
if($pause_id!="")  
{

		$ra= $_GET["ra"];
		$consulta2  =  "update shorts set razon_id=$ra where id=$pause_id";
		$resultado2 = mysql_query($consulta2) or die("Error en operacion1: $consulta2 " . mysql_error());
		

	/*echo"<script>parent.tb_remove(); parent.location=\"adm_planes.php\"</script>";*/

$consulta2  = "SELECT count(id)  FROM cut_pause where id_cut=$id and razon_id=0";
	$resultado2 = mysql_query($consulta2) or die("La consulta fall&oacute;P1: " . mysql_error());
	if(@mysql_num_rows($resultado2)>0)
	{
		$res2=mysql_fetch_row($resultado2);
		$pausas=$res2[0];
		if($pausas>0)
			$pausas=1;
		else
			$pausas=0;
	}
	$consulta3  =  "update cuts set  pausa=$pausas where id= $id";
		$resultado3 = mysql_query($consulta3) or die("Error en operacion1: $consulta3 " . mysql_error());
		if($pausas=="0")
		echo"<script>parent.location=\"cortes_prod.php\"</script>";
}		
	$consulta  = "SELECT cuts.id,mo, cn, cut_type.nombre, length_measured, locations.name, location_capacities.number, rolls.lote, roll_fibers.fiber_type, rolls.remaining_inches, cuts.status  FROM cuts inner join cut_type on cut_type.id=cuts.id_cut_type left outer join locations on cuts.location_assigned_id=locations.id left outer join location_capacities on cuts.number_position=location_capacities.id inner join rolls on rolls.id=cuts.roll_id inner join roll_fibers on cuts.fiber_id=roll_fibers.fiber_type where cuts.deleted_at is null and cuts.id=$id ";
	//echo"$consulta";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	if(@mysql_num_rows($resultado)>=1)
	{
		$res=mysql_fetch_array($resultado,MYSQL_BOTH);
		$cut_id=$res[0];
		
			$estatus="Terminada";
		
?>

 <body>                    
 <div id="page-wrapper">
        <div >
            <div class="col-lg-12">
                <h1 class="page-header">Cortes</h1>
                

               
                

				
                                     
                        <div class="form-group" id="myDiv">
                            

                         
                        </div>
                      
                            

                          <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="retail_length" class="label-success"><? echo"$estatus";?> </label>
                          </div>
						  <div class="col-sm-6 col-md-4 col-lg-3">
                                <label for="retail_length">Tipo de corte:  </label> <? echo"$res[3]";?>
                          </div>
						  <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="retail_length">Mo:  </label> <? echo"$res[1]";?>
                          </div>
						  <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="retail_length">CN:  </label> <? echo"$res[2]";?>
                          </div>
						  <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="remaining_inches">Longitud Prox. :</label> <? echo"$res[4]";?>
							</div>
							<div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="location_id">Lugar:</label> <? echo"$res[5]";?>
                            </div>
							<div class="col-sm-6 col-md-4 col-lg-3">
                                <label for="remaining_inches">Posicion:</label> <? echo"$res[6]";?>
							</div>
                            <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="guaranteed_length">Roll:</label> <? echo"$res[7]";?>
                               
                            </div>
						  <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="fiber_id">Fibra:</label> <? echo"$res[8]";?>
						  </div>
                            
                            
							
							<div class="col-sm-6 col-md-4 col-lg-3">
                                <label for="remaining_inches">Longitud Restante. :</label> <? echo"$res[9]";?>
							</div>
                            <div class="col-sm-6 col-md-4 col-lg-4">
                              <label for="slot"></label>
                          </div>

                            <div class="col-sm-6 col-md-12 col-lg-3"></div>
                            <div class="clearfix"></div>
                       
<div class="col-lg-12 table-responsive">
<form name="form2" id="form2">
			  
                            <table width="341" class="table table-striped table-condensed grid">
                            <thead>
							<tr>
							  <th colspan="3">Pausas</th>
							  </tr>
							<tr>
                            <th width="78">Inicio</th>
                           
                            <th width="73">Fin</th>
                            <th width="109">Razon</th>
                            </tr>
                            </thead>
                            <tbody>

                            
                                        
	<?	  
	$consulta  = "SELECT id_cut, length, type, razon_id, id  FROM shorts where id_cut=$id order by id";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	while($res=mysql_fetch_assoc($resultado))
	{	
		$tipo=$res['type'];
		?>
							<tr>
                                    <td><? echo $res['length'];?></td>
                                 
                                    <td><? if($tipo==0)echo"Normal"; else echo"Defecto";?></td>
                                    <td>
                                      <select name="menu1" onChange="MM_jumpMenu('parent',this,0)" class="form-control">
									  <option value="#">Selecciona Defecto</option>
									   <?	  
							$consulta2  = "SELECT * FROM defects order by nombre";
							$resultado2 = mysql_query($consulta2) or die("La consulta fall&oacute;P1: " . mysql_error());
							$count=1;
							while(@mysql_num_rows($resultado2)>=$count)
							{
								$res2=mysql_fetch_row($resultado2);
								if($res['razon_id']==$res2[0])
								echo"<option value=\"editar_shorts_prod.php?id=$id&pause_id=".$res['id']."&ra=$res2[0]\" selected>$res2[1]</option>";
								else
								echo"<option value=\"editar_shorts_prod.php?id=$id&pause_id=".$res['id']."&ra=$res2[0]\" >$res2[1]</option>";
								$count=$count+1;
							}	
		
										?> 
                                       
                                      </select>                                    </td>

                               
                              </tr>
                                       <? }?>
									   </tbody>                     
                                                    </table>
  </form>
</div>
                  
	<?	
	} 	?>	</div></div></div>					   
</BODY></HTML>