<?php

include('funciones.php');
include("conex.php");
session_start();
$db = new MySQL();
$id = $_SESSION['id'];

header('Content-type:applicaction/xsl');
header('Content-Disposition: attachment; filename=ReporteVentas.xls');

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
</head>
<body>
	<?php 
		tabla_ventasxsl2($db,$id,$_POST['fecha1'],$_POST['fecha2']); 
		$total = $db->HallaValorUnico("SELECT  SUM(a.subtotal)  as 'Sub Total' FROM tbl_pedidos a WHERE estado = 2 AND fecha BETWEEN '".$_POST['fecha1']."' AND '".$_POST['fecha2']."'");
	?>
	
	<div>
		Total: <?php echo $total;?>
	</div>
	
	<?php
		echo "<script>location.replace('../ventas.php')</script>";
	?>
</body>
</html>
