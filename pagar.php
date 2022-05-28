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

$disponible = $db->HallaValorUnico("SELECT count(id) FROM tbl_nomina where idusuario  = '$idusr' and fecha = '$fecha';");


if($disponible<1){
	$valor=$db->HallaValorUnico("SELECT valor FROM tbl_comisiones   where fecha = '$fecha' and id_usuario = '$idusr';");
	$db->query("INSERT INTO tbl_nomina(idusuario, fecha, valor, concepto)
			VALUES      ('$idusr', '$fecha', '$valor', 'Comisiones día $fecha')");
	echo "<script>alert('Pago registrado'); </script>";
	
}else{

	echo "<script>alert('A este usuaruo ya se le pago en esta fecha: $fecha ! '); </script>";
}

echo "<script>window.location.replace('comisiones.php'); </script>";