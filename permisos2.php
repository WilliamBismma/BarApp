<?php 

include('lib/conex.php');

$db = new MySQL();

session_start();
$idSesion = $_SESSION['id'];

$NumeroVariables = count($_POST);

	$NombreVariables = array_keys($_POST); // obtiene los nombres de las varibles

	$ValoresVariables = array_values($_POST);// obtiene los valores de las varibles

       for($i=0;$i<$NumeroVariables;$i++){ // crea las variables y les asigna el valor

		 ${$NombreVariables[$i]}=$ValoresVariables[$i]; }

$conteo= count($opcionesmenu);
$permisos= "1";
for ($i = 0; $i < $conteo; $i++){	
	$permisos= $permisos.",".$opcionesmenu[$i];	
}
$contar = $db->HallaValorUnico("SELECT count(id) FROM tbl_permisos where perfil = '$perfil';");
if($contar>0){
	$db->query("UPDATE tbl_permisos
			SET
			   permisos = '$permisos'
			WHERE perfil = '$perfil'");	
}else{
	$db->query("INSERT INTO tbl_permisos(
				   perfil
				  ,permisos
				) VALUES (
				   '$perfil'  -- perfil - IN int(11)
				  ,'$permisos'  -- permisos - IN varchar(2000)
				)");
}
echo "<script>window.location.replace('cargos.php'); </script>";
