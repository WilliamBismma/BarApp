<?php 

include('lib/conex.php');

$db = new MySQL();



$NumeroVariables = count($_POST);

	$NombreVariables = array_keys($_POST); // obtiene los nombres de las varibles

	$ValoresVariables = array_values($_POST);// obtiene los valores de las varibles

       for($i=0;$i<$NumeroVariables;$i++){ // crea las variables y les asigna el valor

		 ${$NombreVariables[$i]}=$ValoresVariables[$i]; }



if($tbl=='zonas'){
    $db->query("DELETE FROM tbl_zonas 
				WHERE  id = $id ");
    $pagina="zonas.php";
}elseif($tbl=='mesas'){
    $db->query("DELETE FROM tbl_zonas 
				WHERE  id = $id ");
    $pagina="mesas.php";
}elseif($tbl=='tproductos'){
    $db->query("DELETE FROM tbl_tipo_producto 
				WHERE  id = $id ");
    $pagina="tproductos.php";
}elseif($tbl=='usuarios'){
    $db->query("DELETE FROM tbl_usuarios
				WHERE  id = $id ");
    $pagina="usuarios.php";
}elseif($tbl=='Tcontratos'){
    $db->query("DELETE FROM tbl_tipos_contratos
				WHERE  id = $id ");
    $pagina="tipos_contratos.php";
}elseif($tbl=='productos'){
    $db->query("DELETE FROM tbl_productos
				WHERE  id = $id ");
    $pagina="productos.php";
}elseif($tbl=='perfiles'){
    $db->query("DELETE FROM tlb_perfiles
				WHERE  id = $id ");
    $pagina="cargos.php";
}elseif($tbl=='categoria'){
    $db->query("DELETE FROM tbl_categoria_productos
				WHERE  id = $id ");
    $pagina="categoriap.php";
}elseif($tbl=='reservas'){
    $db->query("DELETE FROM tbl_reservas
				WHERE  id = $id ");
    $pagina="reservas.php";
}elseif($tbl=='cajamenor'){
    $db->query("DELETE FROM tbl_caja_menor
				WHERE  id = $id ");
    $pagina="cajamenor.php";
}
elseif($tbl=='productospedido'){
	$tipo=$db->HallaValorUnico("SELECT tipo FROM tbl_detalles_pedido where id = $id ");
	if($tipo==1){
	$cantpedido=$db->HallaValorUnico("SELECT   cantidad FROM tbl_detalles_pedido where id = $id ;");
	$producto=$db->HallaValorUnico("SELECT producto FROM tbl_detalles_pedido where id = $id ;");	
    $db->query("DELETE FROM tbl_detalles_pedido
				WHERE  id = $id ");
	$cantactual=$db->HallaValorUnico("SELECT cantidad FROM tbl_productos where id = '$producto';");
	$cantfinal=$cantactual+$cantpedido;
		$db->query("UPDATE tbl_productos
									SET
									   cantidad = $cantfinal   
									WHERE id = $producto");
	}
	elseif($tipo==2){
	$combo=$db->HallaValorUnico("SELECT producto FROM tbl_detalles_pedido where id = $id ;");
	$productoscombo2=$db->query("SELECT a.id_producto, a.cantidad, (SELECT b.cantidad FROM tbl_productos b where b.id = a.id_producto  ) as 'Cantidadp'  FROM tbl_detalles_combo a where a.id_combo = '$combo';");
					while ($comb2 = $db -> fetch_array($productoscombo2)) 
					{
						$idprod=$comb2[0];
						$cantprod = $comb2[1];
						$existencia= $comb2[2];
						$cantfinalc=$existencia+$cantprod;				
						$db->query("UPDATE tbl_productos
									SET
									   cantidad = $cantfinalc   
									WHERE id = $idprod");
					
					}
		$db->query("DELETE FROM tbl_detalles_pedido
				WHERE  id = $id ");
		
	}

	$totalventaactual=$db->HallaValorUnico("SELECT sum(valor) FROM tbl_detalles_pedido where  id_pedido = '$idpedido';");
			$db->query("UPDATE tbl_pedidos
						SET
						  subtotal = '$totalventaactual'
						WHERE id = '$idpedido'");
	
    $pagina="aproductosp.php?id=$idpedido";
}
elseif($tbl=='mensajes'){
    $db->query("DELETE FROM tbl_mensajes
				WHERE  id = $id ");
	$pagina="mensajes.php";
}
elseif($tbl=='pedido'){
	
	$pedido=$db->query("SELECT producto, cantidad, tipo 
						FROM tbl_detalles_pedido where id_pedido = '$id';");
	/*echo "SELECT producto, cantidad, tipo 
						FROM tbl_detalles_pedido where id_pedido = '$id';";*/
	while ($prodpedidos = $db -> fetch_array($pedido)) 
	{
		$tipo=$prodpedidos[2];
		$cantidad=$prodpedidos[1];
		$producto=$prodpedidos[0];		
		if($tipo==1){
			$cantactual=$db->HallaValorUnico("SELECT cantidad FROM tbl_productos where id = '$producto';");
			$cantfinal=$cantactual+$cantidad;
			$db->query("UPDATE tbl_productos
									SET
									   cantidad = $cantfinal   
									WHERE id = $producto");
			
		}elseif($tipo==2){
			$productoscombo2=$db->query("SELECT a.id_producto, a.cantidad, (SELECT b.cantidad FROM tbl_productos b where b.id = a.id_producto  ) as 'Cantidadp'  FROM tbl_detalles_combo a where a.id_combo = '$produto';");
					while ($comb2 = $db -> fetch_array($productoscombo2)) 
					{
						$idprod=$comb2[0];
						$cantprod = $comb2[1]*$cantidad;
						$existencia= $comb2[2];
						$cantfinalc=$existencia+$cantprod;				
						$db->query("UPDATE tbl_productos
									SET
									   cantidad = $cantfinalc   
									WHERE id = $idprod");					
					}
		
		}
		
	}
   $db->query("DELETE FROM tbl_detalles_pedido
				WHERE  id_pedido = '$id' ");

	$totalventaactual=$db->HallaValorUnico("SELECT sum(valor) FROM tbl_detalles_pedido where  id_pedido = '$id';");
	$db->query("UPDATE tbl_pedidos
						SET
						estado= '3'
						,subtotal = '$totalventaactual'
						WHERE id = '$id'");
	
  $pagina="apedidos.php";
}

echo "<script>window.location.replace('$pagina'); </script>";