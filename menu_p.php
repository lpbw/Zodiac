 <? $dominio=$_SERVER['HTTP_HOST'];
      $resto= array_pop(explode('/', $_SERVER['PHP_SELF']));
	  $urlcompleta="http://".$dominio."/zodiac/eng/".$resto;
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
        <img src="images/usa.png" alt="usa logo" width="30" height="30" class="img-responsive" align="top"/>
      </a>
  </div>
  
    <!-- /.navbar-top-links -->
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="menu1.php"><i class="fa  fa-fw"></i>Dashboard </a>                                </li>
                <li>
                    <a href="cortes_prod.php"><i class="fa  fa-fw"></i>Cortes </a>                             </li>
                
					<li>
                          <a href="logout.php"><i class="fa  fa-fw"></i> Salir</a>                                    </li>
                
            </ul>
 </div>
        <!-- /.sidebar-collapse -->
    </div>