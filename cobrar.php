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

$subtotal = $db->HallaValorUnico("SELECT sum(valor) FROM tbl_detalles_pedido where id_pedido = '$id';");
$servicio1=$db->HallaValorUnico("SELECT  porcentaje FROM tbl_parametros where tipo = 'Servicio' and estado = 1;");
$iva=$db->HallaValorUnico("SELECT  porcentaje FROM tbl_parametros where tipo = 'Iva' and estado = 1;");
$totaliva=($subtotal*$iva)/100;
$totalservicio=($subtotal*$servicio1)/100;


if($pago==2){
	if($nvoucher==""){
		echo "<script>alert('Por favor ingrese el codigo de Voucher ! '); </script>";
		echo "<script>window.location.replace('apedidos.php'); </script>";
	}
	else{
		?>
	<h2>Compra: <?php echo $id; ?></h2>
	<table class='table responsive-table'>
		<thead>
		<tr><th>Nombre</th><th>Cantidad</th><th>Valor</th></tr>
		</thead>
		<tbody>
		<?php 
		$query2 = "SELECT (Select b.nombre from tbl_productos b where b.id =  a.producto ), a.cantidad, a.valor
				   FROM tbl_detalles_pedido a where a.id_pedido = '$id'";
		$data3 = $db->query($query2);
		while ($val3 = $db -> fetch_array($data3)) 
		{
			echo "<tr><td>".$val3[0]."</td><td>".$val3[1]."</td><td>$".number_format($val3[2], 2, '.', ',')."</td></tr>";
		} 
		

			?>
		</tbody>
	</table>
    <h2>Subtotal: $<?php echo number_format($subtotal, 2, '.', ','); ?></h2>
	<?php
	 if($servicio==""){	
	 $totalservicio = 0; 
	 }
	?>
	<h2>Servicio: $<?php echo number_format($totalservicio, 2, '.', ','); ?></h2>
    <h2>Iva: $<?php echo number_format($totaliva, 2, '.', ','); ?></h2>
    <?php $total=$totaliva+$totalservicio+$subtotal; ?>
    <h2>Total: $<?php echo number_format($total, 2, '.', ','); ?></h2>
	<?php			
	$db->query("INSERT INTO tbl_pagos(id_pedido, tipo_transaccion, sub_total, servicio, iva, total, fecha, voucher)
								VALUES      ($id, $pago, $subtotal, $totalservicio, $totaliva, $total, now(), '$nvoucher')");
		$db->query("UPDATE tbl_pedidos
					SET    estado = 2
					WHERE  id = '$id';");

		
	}
	
}
else{
	?>
	<h2>Compra: <?php echo $id; ?></h2>
	<table class='table responsive-table'>
		<thead>
		<tr><th>Nombre</th><th>Cantidad</th><th>Valor</th></tr>
		</thead>
		<tbody>
		<?php 
		$query2 = "SELECT (Select b.nombre from tbl_productos b where b.id =  a.producto ), a.cantidad, a.valor
				   FROM tbl_detalles_pedido a where a.id_pedido = '$id'";
		$data3 = $db->query($query2);
		while ($val3 = $db -> fetch_array($data3)) 
		{
			echo "<tr><td>".$val3[0]."</td><td>".$val3[1]."</td><td>$".number_format($val3[2], 2, '.', ',')."</td></tr>";
		} 
		

			?>
		</tbody>
	</table>
    <h2>Subtotal: $<?php echo number_format($subtotal, 2, '.', ','); ?></h2>
	<?php
	 if($servicio==""){	
	 $totalservicio = 0; 
	 }
	?>
	<h2>Servicio: $<?php echo number_format($totalservicio, 2, '.', ','); ?></h2>
    <h2>Iva: $<?php echo number_format($totaliva, 2, '.', ','); ?></h2>
    <?php $total=$totaliva+$totalservicio+$subtotal; ?>
    <h2>Total: $<?php echo number_format($total, 2, '.', ','); ?></h2>
	<?php			
	$db->query("INSERT INTO tbl_pagos(id_pedido, tipo_transaccion, sub_total, servicio, iva, total, fecha, voucher)
								VALUES      ($id, $pago, $subtotal, $totalservicio, $totaliva, $total, now(), '$nvoucher')");
	$db->query("UPDATE tbl_pedidos
					SET    estado = 2
					WHERE  id = '$id';");

			
}
?>
<script type="text/JavaScript">                
	setTimeout(function () {
	   window.location.href = "apedidos.php"; //will redirect to your blog page (an ex: blog.html)
	}, 3000);               
</script>