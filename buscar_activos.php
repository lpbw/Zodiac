<?
session_start();
include "coneccion.php";
error_reporting(E_ALL);

$locationU=$_SESSION['location'];

	$consulta  = "SELECT cuts.id,mo, cn, cut_type.nombre, length_measured, locations.name, location_capacities.number, rolls.lote, roll_fibers.fiber_type, rolls.remaining_inches, cuts.status, cuts.parte,cuts.length_consumed, cuts.length_defect,DATE_FORMAT(date_lote, '%m-%d-%Y')  FROM cuts inner join cut_type on cut_type.id=cuts.id_cut_type inner join locations on cuts.location_assigned_id=locations.id left outer join location_capacities on cuts.number_position=location_capacities.id inner join rolls on rolls.id=cuts.roll_id left outer join roll_fibers on cuts.fiber_id=roll_fibers.fiber_type where cuts.deleted_at is null and cuts.location_assigned_id=$locationU and (status=1 or status=2) ";
	//echo"$consulta";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	if(@mysql_num_rows($resultado)>=1)
	{
		$res=mysql_fetch_array($resultado,MYSQL_BOTH);
		$cut_id=$res[0];
		if($res[10]==1)
			$estatus="En proceso";
		else
			$estatus="En pausa";
		
?>
<style type="text/css">
<!--
.style1 {color: #000000}
-->
</style>


                     
                       
                            

                          <script type="text/JavaScript">
<!--
function MM_jumpMenu2(targ,selObj,restore,razon){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"&razon="+razon+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
                          </script>
<div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="retail_length" class="label-success"><? echo"$estatus";?> </label>
                          </div>
						  <div class="col-sm-6 col-md-4 col-lg-3">
                                <label for="retail_length">Tipo de corte:  </label> <? echo"$res[3]";?> l=<? echo"$locationU";?>
                          </div>
						  <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="retail_length">Mo:  </label> <? echo"$res[1]";?>
                          </div>
						  <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="retail_length">CN:  </label> <? echo"$res[2]";?>
                          </div>
						  <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="retail_length">No. Parte:  </label> <? echo"$res[11]";?>
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
                                <label for="guaranteed_length">Roll:</label> <? echo"$res[7] ($res[14])";?>
                               
                            </div>
						  <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="fiber_id">Fibra:</label> <? echo"$res[8]";?>
						  </div>
						   <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="fiber_id">Long:</label> <? echo round($res[12],1);?>
						  </div>
						   <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="fiber_id">Long Defecto:</label> <? echo round($res[13], 1);?>
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
<form name="form3" id="form3">
			  
                            <table width="341" class="table table-striped table-condensed grid">
                            <thead>
							<tr>
							  <th colspan="4" bgcolor="#FFFFFF"><span class="style1">Shorts</span></th>
							  </tr>
							<tr>
                            <th width="78">Longitud</th>
                           
                            <th width="73">Tipo</th>
                            <th width="109">Defecto</th>
                            <th width="109">&nbsp;</th>
							</tr>
                            </thead>
                            <tbody>

                            
                                        
	<?	  
	$consulta  = "SELECT length, type,razon_id,id  FROM shorts where id_cut=$cut_id order by id";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	while($res=mysql_fetch_assoc($resultado))
	{	
		$tipo=$res['type'];
		?>
							<tr>
                                    <td><? echo $res['length'];?></td>
                                 
                                    <td><? if($tipo==0)echo"Normal"; else echo"Defecto";?></td>
                              <td>
                                     <? if($tipo==1){?> <select name="menu1" onchange="MM_jumpMenu('parent',this,0)" class="form-control">
									  <option value="#">Selecciona Defecto</option>
									   <?	  
							$consulta2  = "SELECT * FROM defects order by nombre";
							$resultado2 = mysql_query($consulta2) or die("La consulta fall&oacute;P1: " . mysql_error());
							$count=1;
							while(@mysql_num_rows($resultado2)>=$count)
							{
								$res2=mysql_fetch_row($resultado2);
								if($res['razon_id']==$res2[0])
								echo"<option value=\"cortes_prod.php?defect_id=".$res['id']."&ra=$res2[0]\" selected>$res2[1]</option>";
								else
								echo"<option value=\"cortes_prod.php?defect_id=".$res['id']."&ra=$res2[0]\" >$res2[1]</option>";
								$count=$count+1;
							}	
		
										?>
                                      </select><? }?></td>

                               
                              <td>&nbsp;</td>
							</tr>
                                       <? }?>
									   </tbody>                     
                                                    </table>
  </form>
</div>
<div class="col-lg-12 table-responsive">
<form name="form2" id="form2">
			  
                            <table width="341" class="table table-striped table-condensed grid">
                            <thead>
							<tr>
							  <th colspan="5" bgcolor="#FFFFFF"><span class="style1">Pausas</span></th>
							  </tr>
							<tr>
                            <th width="78">Inicio</th>
                           
                            <th width="73">Fin</th>
                            <th width="109">Razon</th>
                            <th width="109">&nbsp;</th>
							<th width="109">&nbsp;</th>
							</tr>
                            </thead>
                            <tbody>

                            
                                        
	<?	  
	$consulta  = "SELECT id_cut, inicio, fin, razon_id, id, razon,autorized  FROM cut_pause where id_cut=$cut_id order by inicio";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	while($res=mysql_fetch_assoc($resultado))
	{	
		?>
							<tr>
                                    <td><? echo $res['inicio'];?></td>
                                 
                                    <td><? echo $res['fin'];?></td>
                              <td>
                                      <select name="menu1" onchange="MM_jumpMenu('parent',this,0)" class="form-control">
									  <option value="#">Selecciona Razon</option>
									   <?	  
							$consulta2  = "SELECT * FROM down_time_reason where id not in (6,7 ) order by id";
							$resultado2 = mysql_query($consulta2) or die("La consulta fall&oacute;P1: " . mysql_error());
							$count=1;
							while(@mysql_num_rows($resultado2)>=$count)
							{
								$res2=mysql_fetch_row($resultado2);
								
								if($res['razon_id']==$res2[0])
								echo"<option value=\"cortes_prod.php?pause_id=".$res['id']."&ra=$res2[0]\" selected>$res2[1]</option>";
								else if($res2[2]!="1" || $res2[0]=="3")
								echo"<option value=\"cortes_prod.php?pause_id=".$res['id']."&ra=$res2[0]\" >$res2[1]</option>";
								$count=$count+1;
							}	
		
										?> 
                                      </select></td>

                               
                              <td><span class="col-sm-6 col-md-4 col-lg-4">
                                <input name="motivo" type="text" class="form-control" id="motivo"
                                       value="<? echo $res['razon']?>" size="20" maxlength="50" onchange=""/><!-guardaMotivo('parent',this, '<? echo $res['id']?>');->
                              </span></td>
							  <td><? if($res['razon_id']=="3" && $res['autorized']=="0"){?>
                                <a href="autorizar.php?pausa_id=<? echo $res['id'];?>&amp;razon=<? echo $res['razon_id'];?>"><img src="images/mante.png" width="29" height="29" border="0" /></a>
                                <? }?></td>
							</tr>
                                       <? }?>
									   </tbody>                     
                                                    </table>
  </form>
</div>                  
	<?	
	} else
	{ 
?>
	 <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="retail_length" class="label-warning"><? echo"Inactivo";?> </label>
                          </div>
						  
 <div class="col-sm-6 col-md-4 col-lg-3">
                                <label for="retail_length">Tipo de corte:  </label> 
                          </div>
						  <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="retail_length">Mo:  </label> 
                          </div>
						  <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="retail_length">CN:  </label> 
                          </div>
						  <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="remaining_inches">Longitud Prox. :</label> 
							</div>
							<div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="location_id">Lugar:</label> 
                            </div>
							<div class="col-sm-6 col-md-4 col-lg-3">
                                <label for="remaining_inches">Posicion:</label> 
							</div>
                            <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="guaranteed_length">Roll:</label> 
                               
                            </div>
						  <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="fiber_id">Fibra:</label> 
						  </div>
                            
                            
							
							<div class="col-sm-6 col-md-4 col-lg-3">
                                <label for="remaining_inches">Longitud Restante. :</label>
							</div>
                            <div class="col-sm-6 col-md-4 col-lg-4">
                              <label for="slot"></label>
                          </div>

                            <div class="col-sm-6 col-md-12 col-lg-3"></div>
                            <div class="clearfix"></div>
<div class="col-lg-12 table-responsive">
<form name="form2" id="form2">
			  
                            <table width="627" class="table table-striped table-condensed grid">
                            <thead>
							<tr>
							  <th colspan="6" bgcolor="#FFFFFF"><span class="style1">Paro</span></th>
							  </tr>
							<tr>
                            <th width="78">Inicio</th>
                           
                            <th width="73">Fin</th>
                            <th width="109">Trasncurrido</th>
                            <th width="109">Comentario</th>
                            <th width="109">Raz&oacute;n</th>
							<th width="109">Autorizaci&oacute;n</th>
							</tr>
                            </thead>
                            <tbody>

                            
                                        
	<?	  
	$consulta  = "SELECT id, inicio, fin, razon_id,  razon, autorized,TIMESTAMPDIFF(MINUTE, inicio, now()) as d1  FROM cut_pause where location_id=$locationU and fin is null and id_cut=0";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	while($res=mysql_fetch_assoc($resultado))
	{	
		?>
							<tr>
                                    <td><? echo $res['inicio'];?></td>
                                 
                                    <td><? echo $res['fin'];?></td>
                                    <td><? echo $res['d1'];?>min</td>
                              <td>
                                      <span class="col-sm-6 col-md-4 col-lg-4">
                                      <input name="motivo" type="text" class="form-control" id="motivo"
                                       value="<? echo $res['razon']?>" size="20" maxlength="50" />
                                      </span></td>

                               
                              <td><select name="select" onchange="MM_jumpMenu2('parent',this,0,document.form2.motivo.value)" class="form-control">
                                <option value="#">Selecciona Razon</option>
                                <?	  
							$consulta2  = "SELECT * FROM down_time_reason  order by id";
							$resultado2 = mysql_query($consulta2) or die("La consulta fall&oacute;P1: " . mysql_error());
							$count=1;
							while(@mysql_num_rows($resultado2)>=$count)
							{
								$res2=mysql_fetch_row($resultado2);
								if($res['razon_id']==$res2[0])
								echo"<option value=\"cortes_prod.php?paro_id=".$res['id']."&ra=$res2[0]\" selected>$res2[1]</option>";
								else if($res2[2]!="1" || $res2[0]=="3")
								echo"<option value=\"cortes_prod.php?paro_id=".$res['id']."&ra=$res2[0]\" >$res2[1]</option>";
								$count=$count+1;
							}	
		
										?>
                              </select></td>
							  <td><div align="center"><? if($res['razon_id']=="3" && $res['autorized']=="0"){?>
							    <a href="autorizar.php?pausa_id=<? echo $res['id'];?>&razon=<? echo $res['razon_id'];?>"><img src="images/mante.png" width="29" height="29" border="0" /></a><? }else if($res['autorized']!="0" || $res['d1']<=5){?><img src="images/bien.png" width="29" height="29" />
						      <? }?></div></td>
							</tr>
           <? }?>
									   </tbody>                     
                                                    </table>
  </form>
</div>                                 
							
	<? }?>								   