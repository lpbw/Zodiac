<?
session_start();
include "coneccion.php";


$locationU=$_SESSION['location'];

	$consulta  = "SELECT cuts.id,mo, cn, cut_type.nombre, length_measured, locations.name, location_capacities.number, rolls.lote, roll_fibers.fiber_type, rolls.remaining_inches, cuts.status, cuts.parte,cuts.length_consumed, cuts.length_defect  FROM cuts inner join cut_type on cut_type.id=cuts.id_cut_type inner join locations on cuts.location_assigned_id=locations.id left outer join location_capacities on cuts.number_position=location_capacities.id inner join rolls on rolls.id=cuts.roll_id left outer join roll_fibers on rolls.fiber_id=roll_fibers.fiber_type where cuts.deleted_at is null and cuts.location_assigned_id=$locationU and (status=1 or status=2) ";
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

                     
                       
                            

                          <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="retail_length" class="label-success"><? echo"$estatus";?> </label>
                          </div>
						  <div class="col-sm-6 col-md-4 col-lg-3">
                                <label for="retail_length">Cut Category:  </label> <? echo"$res[3]";?>
                          </div>
						  <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="retail_length">Mo number:  </label> <? echo"$res[1]";?>
                          </div>
						  <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="retail_length">CN:  </label> <? echo"$res[2]";?>
                          </div>
						  <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="retail_length">Part Number:  </label> <? echo"$res[11]";?>
                          </div>
						  <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="remaining_inches">Average Length:</label> <? echo"$res[4]";?>
							</div>
							<div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="location_id">Location:</label> <? echo"$res[5]";?>
                            </div>
							<div class="col-sm-6 col-md-4 col-lg-3">
                                <label for="remaining_inches">Tube:</label> <? echo"$res[6]";?>
							</div>
                            <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="guaranteed_length">Roll:</label> <? echo"$res[7]";?>
                               
                            </div>
						  <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="fiber_id">Fabric:</label> <? echo"$res[8]";?>
						  </div>
						   <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="fiber_id">Length:</label> <? echo round($res[12],1);?>
						  </div>
						   <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="fiber_id">Defect Length:</label> <? echo round($res[13], 1);?>
						  </div>
                            
                            
							
							<div class="col-sm-6 col-md-4 col-lg-3">
                                <label for="remaining_inches">Remaining Length :</label> <? echo"$res[9]";?>
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
							  <th colspan="4">Pause</th>
							  </tr>
							<tr>
                            <th width="78">Start</th>
                           
                            <th width="73">Finish</th>
                            <th width="109">Reason</th>
                            <th width="109">&nbsp;</th>
							</tr>
                            </thead>
                            <tbody>

                            
                                        
	<?	  
	$consulta  = "SELECT id_cut, inicio, fin, razon_id, id  FROM cut_pause where id_cut=$cut_id order by inicio";
	$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
	while($res=mysql_fetch_assoc($resultado))
	{	
		?>
							<tr>
                                    <td><? echo $res['inicio'];?></td>
                                 
                                    <td><? echo $res['fin'];?></td>
                                    <td>
                                      <select name="menu1" onchange="MM_jumpMenu('parent',this,0)" class="form-control">
									  <option value="#">Choose Reason</option>
									   <?	  
							$consulta2  = "SELECT * FROM down_time_reason order by id";
							$resultado2 = mysql_query($consulta2) or die("La consulta fall&oacute;P1: " . mysql_error());
							$count=1;
							while(@mysql_num_rows($resultado2)>=$count)
							{
								$res2=mysql_fetch_row($resultado2);
								if($res['razon_id']==$res2[0])
								echo"<option value=\"cortes_prod.php?pause_id=".$res['id']."&ra=$res2[0]\" selected>$res2[1]</option>";
								else
								echo"<option value=\"cortes_prod.php?pause_id=".$res['id']."&ra=$res2[0]\" >$res2[1]</option>";
								$count=$count+1;
							}	
		
										?> 
                                      </select>                                    </td>

                               
                                    <td><span class="col-sm-6 col-md-4 col-lg-4">
                                      <input name="motivo" type="text" class="form-control" id="motivo"
                                       value="<? echo $res['razon']?>" size="20" maxlength="50" onchange="guardaMotivo('parent',this, '<? echo $res['id']?>');"/>
                                    </span></td>
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
                                <label for="retail_length">Cut Category:  </label> 
                          </div>
						  <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="retail_length">Mo Number:  </label> 
                          </div>
						  <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="retail_length">CN:  </label> 
                          </div>
						  <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="remaining_inches">Average Length:</label> 
							</div>
							<div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="location_id">Location:</label> 
                            </div>
							<div class="col-sm-6 col-md-4 col-lg-3">
                                <label for="remaining_inches">Tube:</label> 
							</div>
                            <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="guaranteed_length">Roll:</label> 
                               
                            </div>
						  <div class="col-sm-6 col-md-4 col-lg-2">
                                <label for="fiber_id">Fabric:</label> 
						  </div>
                            
                            
							
							<div class="col-sm-6 col-md-4 col-lg-3">
                                <label for="remaining_inches">Remaining Length:</label>
							</div>
                            <div class="col-sm-6 col-md-4 col-lg-4">
                              <label for="slot"></label>
                          </div>

                            <div class="col-sm-6 col-md-12 col-lg-3"></div>
                            <div class="clearfix"></div>
                       
							
	<? }?>								   