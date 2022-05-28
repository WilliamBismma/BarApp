<?php

include('funciones.php');
include("conex.php");
session_start();
$db = new MySQL();
$id = $_SESSION['id'];

header('Content-type:applicaction/xsl');
header('Content-Disposition: attachment; filename=ReporteComisiones.xls');

if(!empty($_POST['nombre'])){
$nombre = "a.id_usuario = (SELECT id FROM tbl_usuarios WHERE nombres = '".$_POST['nombre']."') AND ";
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
</head>
<body>
	<?php 
		tabla_comisionesxsl2($db,$id,$_POST['fecha1'],$_POST['fecha2'],$_POST['nombre']);
		$total = $db->HallaValorUnico("SELECT SUM(valor) AS 'Sub Total' FROM tbl_comisiones AS a WHERE $nombre a.fecha BETWEEN '".$_POST['fecha1']."' AND '".$_POST['fecha2']."'");
	
	?>
	
	<div>
		Total: <?php echo $total;?>
	</div>
	
	<?php
		//echo "<script>location.replace('../comisiones.php')</script>";
	?>
</body>
</html>
