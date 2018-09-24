<?
ini_set('error_reporting', E_ALL);

include "coneccion.php";



	if(is_uploaded_file($_FILES['file']['tmp_name'])){
		$allowedExtensions = array("xls","xlsx");
		$varr=explode(".", strtolower($_FILES['file']['name']));
		$ext=$varr[1];
		$query="delete from parte";
		$ejecuta=mysql_query($query)or die("Error al insertar l�nea $i:".mysql_error());
		$query="delete from roll_fibers";
		$ejecuta=mysql_query($query)or die("Error al insertar l�nea $i:".mysql_error());
		$query="delete from parte_fibra";
		$ejecuta=mysql_query($query)or die("Error al insertar l�nea $i:".mysql_error());				
		$i=0;
		if(in_array($ext, $allowedExtensions)){
			$nombre=$tipo."_".date('Y-m-d').".$ext";
			if(move_uploaded_file($_FILES['file']['tmp_name'],"archivos/$nombre")){
				require_once('Classes/PHPExcel.php');
				if($ext=='xlsx'){
					require_once('Classes/PHPExcel/Reader/Excel2007.php');
					$objReader = new PHPExcel_Reader_Excel2007();
				}else{
					require_once('Classes/PHPExcel/Reader/Excel5.php');
					$objReader = new PHPExcel_Reader_Excel5();
				}
				
				$objPHPExcel = $objReader->load("archivos/$nombre");
				$objPHPExcel->setActiveSheetIndex(0);
				$i=2;
				$k=0;
				while($objPHPExcel->getActiveSheet()->getCell("A".$i)->getValue() != ''){
					$parte=$objPHPExcel->getActiveSheet()->getCell("A".$i)->getValue();
					$parte_name=str_replace("'", " ", $objPHPExcel->getActiveSheet()->getCell("B".$i)->getValue());
					$fibra=$objPHPExcel->getActiveSheet()->getCell("C".$i)->getValue();
					$fibra_name=str_replace("'", " ", $objPHPExcel->getActiveSheet()->getCell("D".$i)->getValue());
					$cantidad=$objPHPExcel->getActiveSheet()->getCell("E".$i)->getValue();
					$tiempo=$objPHPExcel->getActiveSheet()->getCell("F".$i)->getValue();
					$consulta  = "SELECT id FROM parte where parte='$parte' ";	
					$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: ". mysql_error());
					$count=1;
					if(@mysql_num_rows($resultado)>0)
					{
					}
					else
					{	
						$query="insert into parte(parte, producto, created_at) VALUES('$parte','$parte_name',now())";
						$ejecuta=mysql_query($query)or die("Error al insertar l�nea $i:".mysql_error());
						
					}
					$consulta  = "SELECT id FROM roll_fibers where fiber_type='$fibra' ";	
					$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: ". mysql_error());
					
					if(@mysql_num_rows($resultado)>0)
					{
					}
					else
					{	
						$query="insert into roll_fibers(fiber_type, text, provider_id, format, chara, created_at) VALUES('$fibra','$fibra_name',0,'','',now())";
						$ejecuta=mysql_query($query)or die("Error al insertar l�nea $i:".mysql_error());
						
					}
					$query="insert into parte_fibra(id_parte, id_fibra, longitud, estandar,  created_at) VALUES('$parte','$fibra',$cantidad,$tiempo,now())";
					$ejecuta=mysql_query($query)or die("Error al insertar l�nea $i:".mysql_error());
					$i++;
				}//while
				
				
					echo "<script> alert(\"Confirmación de Importacion\");</script>";
			}//if mover archivo
		}//if extension
		else
			echo"<script>alert(\"Solo se permiten archivos con extensión $ext\");</script>";
	}else
		echo"<script>alert(\"No se ha podido subir el archivo\");</script>";
	echo"<script>window.location='importar_partes.php';</script>";

?>