<?php 

include('lib/conex.php');

$db = new MySQL();

session_start();
$idSesion = $_SESSION['id'];

$NumeroVariables = count($_GET);

	$NombreVariables = array_keys($_GET); // obtiene los nombres de las varibles

	$ValoresVariables = array_values($_GET);// obtiene los valores de las varibles

       for($i=0;$i<$NumeroVariables;$i++){ // crea las variables y les asigna el valor

		 ${$NombreVariables[$i]}=$ValoresVariables[$i]; }

if($tipo=='combos'){
	$estado=$db->HallaValorUnico("SELECT  estado FROM tbl_combo where id= '$id';");
	if($estado==1){
		 $db->query("UPDATE tbl_combo
				SET
				   estado = 0 
				WHERE id = '$id'");
	}elseif($estado==0){
		$db->query("UPDATE tbl_combo
				SET
				   estado = 1 
				WHERE id = '$id'");		
	}   
    $pagina="vercombos.php";
}

echo "<script>window.location.replace('$pagina'); </script>";
