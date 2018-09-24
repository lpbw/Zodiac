<?
// programa para terminar un corte
include "coneccion.php";

$location_id= $_POST["location_id"];




	
	$consulta2  = "SELECT users.lang FROM locations inner join users on locations.logged=users.id where locations.id=$location_id";
	$resultado2 = mysql_query($consulta2) or die("La consulta fall&oacute;P1: " . mysql_error());
	if(@mysql_num_rows($resultado2)>0)
	{
		$res2=mysql_fetch_row($resultado2);
		$lang=$res2[0];
		
	}else
	{
	
		$consulta2  = "SELECT lang  FROM languaje where id=1 ";
		$resultado2 = mysql_query($consulta2) or die("La consulta fall&oacute;P1: " . mysql_error());
		if(@mysql_num_rows($resultado2)>0)
		{
			$res2=mysql_fetch_row($resultado2);
			$lang=$res2[0];
			
		}
	}
	
		echo "$lang";
	

		
?>
                  