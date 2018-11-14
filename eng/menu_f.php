 <? $dominio=$_SERVER['HTTP_HOST'];
      $resto= array_pop(explode('/', $_SERVER['PHP_SELF']));
	  $urlcompleta="http://".$dominio."/".$resto;
	  //echo $urlcompleta;
 ?>  
 <ul class="nav navbar-top-links navbar-right">
 		
        <!-- /.dropdown -->
 <li class="dropdown pull-right">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="#"><i class="fa fa-user fa-fw"></i> <? echo"$nombreU";?></a>
                </li>
                <li><a href="#"><i class="fa fa-cog fa-fw"></i> Configurar</a>
                </li>
                <li class="divider"></li>
                <li> <a href="logout.php">Salir</a>                </li>
            </ul>
            <!-- /.dropdown-user -->
   </li>
        <!-- /.dropdown -->	
 </ul>  
 <div align="right">
       <br style="line-height:0.2px;">
      <a href="cambio_idioma.php?url=<? echo $urlcompleta ?>">
        <img src="images/mxn.png" alt="mexico logo" width="30" height="30" class="img-responsive" align="top"/>
      </a>
  </div>
  
    <!-- /.navbar-top-links -->
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="menu.php"><i class="fa  fa-fw"></i>Dashboard </a>                                </li>
                <li>
                    <a href="cortes.php"><i class="fa -cart fa-fw"></i>Cuts </a>                             </li>
                <li>
                    <a href="rollos.php"><i class="fa  fa-fw"></i>Rolls</a>                                </li>
				<li>
                    <a href="rollos_terminados.php"><i class="fa  fa-fw"></i>Finished Rolls</a>                                </li>
                <li>
                    <a href="historial.php"><i class="fa  fa-fw"></i>Record	of Rolls</a>                         </li>

                 <li>
                    <a href="terminadas.php"><i class="fa  fa-fw"></i>Finished MOs</a>                         </li>  
					 <li>
                        <a href="reporteejecutivo.php"><i class="fa  fa-fw"></i>Executive report</a>                         
                    </li>  
					 
					 <? if($tipoU=="1"){?>
					 <li>
                    <a href="lectra_capacity.php"><i class="fa  fa-fw"></i>Lectra Capacity</a>                         </li>  
                      <!--<li>
                          <a href="levels"><i class="fa fa-align-justify fa-fw"></i> Niveles</a>                             </li>-->
                      <li>
                          <a href="lugares.php"><i class="fa  fa-fw"></i> Location</a>                       </li>
					<!-- <li>
                          <a href="posiciones.php"><i class="fa  fa-fw"></i> Tube</a>                       </li>-->
					<li>
                          <a href="bodegas.php"><i class="fa  fa-fw"></i> Warehouse</a>                       </li>
					  <li>
                          <a href="programas.php"><i class="fa  fa-fw"></i>Programs</a>                       </li>
                      <!--<li>
                          <a href="privs"><i class="fa fa-star fa-fw"></i> Privilegios</a>                       </li>-->
                      <li>
                          <a href="proveedores.php"><i class="fa  fa-fw"></i> Supplier</a>                      </li>
                      <? }?>
					  <li>
                          <a href="usuarios.php"><i class="fa  fa-fw"></i> Users</a>                        </li>
                      <li>
                          <a href="razones.php"><i class="fa  fa-fw"></i> Reasons</a>                                           </li>
					 <li>
                          <a href="defectos.php"><i class="fa  fa-fw"></i> Defects</a>                                           </li>
                     <!-- <li>
                          <a href="states"><i class="fa fa-arrows-h fa-fw"></i> Estados</a>                                    </li>-->
					   

                      <li>
                          <a href="partes.php"><i class="fa  fa-fw"></i> Part Number</a>                      </li>
					  <li>
                          <a href="fibras.php"><i class="fa  fa-fw"></i> Fabric</a>                      </li>
					 
					<li>
                          <a href="logout.php"><i class="fa  fa-fw"></i> Exit</a>                                    </li>
                
            </ul>
 </div>
        <!-- /.sidebar-collapse -->
    </div>