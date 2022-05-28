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

function Enc($action, $string) {
    $output = false; 
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'G30syefbko';
    $secret_iv = 'AfHggGh78o03Rg1'; 
    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
 
    if( $action == 'enc' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
        
	}
    else if( $action == 'dec' ){
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
   
	}
 
    return $output;
}



if($tbl=='zonas'){
    $db->query("INSERT INTO tbl_zonas(
				  zona
				  ,descripcion
				) VALUES (
				   '$zona'  -- zona - IN varchar(100)
				  ,'$descripcion'  -- descripcion - IN varchar(200)
				) ");
    $pagina="zonas.php";
}
elseif($tbl=='mesas'){
	
    $db->query("INSERT INTO tlb_mesas(
				   mesa
				  ,zona
				) VALUES (
				   '$mesa'  -- zona - IN varchar(100)
				  ,'$zona'  -- descripcion - IN varchar(200)
				) ");
	
    $pagina="mesasdisponibles.php";
	
}
elseif($tbl=='tproductos'){
	
    $db->query("INSERT INTO tbl_tipo_producto(
				   tipo_producto
				) VALUES (
				   '$Nproducto'
				) ");
	
    $pagina="tproductos.php";
	
}elseif($tbl=='cajamenor'){
	
    $db->query("INSERT INTO tbl_caja_menor(
				    producto
				   ,tipo_producto
				   ,valor
				   ,fecha
				) VALUES (
				   '$producto'
				  ,'$tipo_producto'
				  ,'$valor'
				  ,'$fecha'
				) ");
	
    $pagina="cajamenor.php";
	
}
elseif($tbl=='canciones'){
	
    $db->query("INSERT INTO tbl_canciones(
				   cancion
				  ,artista
				  ,estado
				) VALUES (
				   '$cancion'
				  ,'$artista'
				  ,1
				) ");
	$db->query("INSERT INTO tbl_mensajes(remitente, destino, Mensaje, fecha)
						VALUES      (1, 'Dj', '$cancion-$artista', now()) ;");
	
    $pagina="pcancion.php";
	
}
elseif($tbl=='perfiles'){
	
    $db->query("INSERT INTO tlb_perfiles(
				   perfiles
				) VALUES (
				   '$perfiles' 
				) ");
	
    $pagina="cargos.php";
	
}
elseif($tbl=='mesas2'){
	
    $db->query("INSERT INTO tlb_mesas(
				   mesa,
				   zona,
				   cant_personas,
				   estado
				) VALUES (
				   '$mesa',
				   '$zona',
				   '$cant_personas',
				   'Libre'
				) ");
	
    $pagina="mesasdisponibles.php";
	
}
elseif($tbl=='reservas'){
	
    $db->query("INSERT INTO tbl_reservas(
				    nombre
				   ,cedula
				   ,fecha
				   ,cant_personas
				   ,observaciones
				   ,estado
				) VALUES (
				    '$nombre' 
				   ,'$cedula'
				   ,'$fecha'
				   ,'$can_personas'
				   ,'$observaciones'
				   ,'$est'
				) ");
	
    $pagina="reservas.php";
	
}
elseif($tbl=='reservasusu'){
	
    $db->query("INSERT INTO tbl_reservas(
				    nombre
				   ,cedula
				   ,fecha
				   ,cant_personas
				   ,observaciones
				   ,estado
				) VALUES (
				    '$nombre' 
				   ,'$cedula'
				   ,'$fecha'
				   ,'$can_personas'
				   ,'$observaciones'
				   ,'$est'
				) ");
	
    $pagina="reservausu.php?confir=1";
	
}
elseif($tbl=='categoria'){
	
    $db->query("INSERT INTO tbl_categoria_productos(
				   categoria
				) VALUES (
				   '$categoria' 
				) ");
	
    $pagina="categoriap.php";
	
}
elseif($tbl=='Tcontratos'){
	
    $db->query("INSERT INTO tbl_tipos_contratos(
				  tipo_contrato
				  ,concepto
				) VALUES (
				   '$contrato'
				  ,'$concepto'
				) ");
    $pagina="tipos_contratos.php";
	
}
elseif($tbl=='productos'){
	
	if(!empty($_FILES)){
		$tiempo = date('Y-m-d');

		$nombre = $_FILES["imagen"]['name'];
		$ext = pathinfo($nombre, PATHINFO_EXTENSION);
		$BaseName = pathinfo($nombre, PATHINFO_FILENAME);
		$ruta = 'imagenes/'.$BaseName.'-'.$tiempo.'-'.$_SESSION['id'].'.'.$ext;
		$guardado = $_FILES['imagen']['tmp_name'];
		
		if($ext == "jpge" || $ext == "png" || $ext == "jpg"){
			move_uploaded_file($guardado, 'imagenes/'.$BaseName.'-'.$tiempo.'-'.$_SESSION['id'].'.'.$ext);
			$db->query("INSERT INTO tbl_productos(
					  nombre
					  ,valor_compra
					  ,valor_venta
					  ,cantidad
					  ,imagenes
					  ,categoria
					) VALUES (
					   '$nombrep'
					  ,'$Vcompra'
					  ,'$Vventa'
					  ,'$cantidad'
					  ,'$ruta'
					  ,'$categoria'
					) ");
		}else{
			echo "<script>alert('El formato de la imagen debe ser PNG, JPGE o JPG')</script>";
		}
		
	}
	
    
    $pagina="productos.php";
	
}
elseif($tbl=='usuarios'){
	
	$cor = $db->HallaValorUnico("SELECT id FROM tbl_usuarios WHERE correo = '$correo' OR usuario = '$usuario'");
	if(empty($cor)){
		if($contrasenia1 == $contrasenia2){
			$pass1= Enc('enc', $contrasenia1);
			$db->query("INSERT INTO tbl_usuarios(
						  nombres
						  ,apellidos
						  ,tipo_doc
						  ,documento
						  ,perfil
						  ,telefono
						  ,direccion
						  ,usuario
						  ,pass
						  ,correo
						  ,estado
						) VALUES (
						   '$nombres'
						  ,'$apellidos'
						  ,'$tipo_doc'
						  ,'$documento'
						  ,'$cargo'
						  ,'$telefono'
						  ,'$direccion'
						  ,'$usuario'
						  ,'$pass1'
						  ,'$correo'
						  ,'1'
						) ");

			$id = $db->HallaValorUnico("SELECT id FROM tbl_usuarios WHERE correo = '$correo'");

			$db->query("INSERT INTO tbl_contratos(
						   idusuario
						  ,tipo_contrato
						  ,fechainicio
						  ,fechafin
						  ,porcentaje
						  ,valor_contrato
						) VALUES (
						   '$id'
						  ,'$tipo_contrato'
						  ,'$Finicio'
						  ,'$Ffin'
						  ,'$porcentaje'
						  ,'$valor_contrato'
						) ");
		}else{
			echo "<script>alert('Las contraseñas no coinciden')</script>";
		}
	}else{
		echo "<script>alert('El usuario o el correo ya estan registrados en el sistema')</script>";
	}
    $pagina="usuarios.php";
	
}
elseif($tbl=='pedidos'){	
			$db->query("INSERT INTO tbl_pedidos(mesa, fecha, asesor, estado)
				  VALUES      ('$mesa', now(), '$user', 1)");
	
			$prod ="producto_";
			$val="valor";
			$idpedido=$db->HallaValorUnico("SELECT id FROM tbl_pedidos where asesor = '$user' and estado = 1 order by id desc limit 1");
			foreach($_POST as $campo => $valor){
				if (strpos($campo, 'idproducto_') !== false) { //PAY ATTENTION TO !==, not !=
					$cantp=${$prod.$valor};					
					$cantactual=$db->HallaValorUnico("SELECT cantidad FROM tbl_productos where id = '$valor';");
					$cantfinal=$cantactual-$cantp;
					if($cantfinal<0){
						$vventa=$db->HallaValorUnico("SELECT  valor_venta FROM tbl_productos where id = '$valor';");
						$totalventaproducto=$vventa*$cantactual;
						$db->query("INSERT INTO tbl_detalles_pedido(id_pedido, producto, cantidad, valor, tipo)
						VALUES      ('$idpedido', '$valor', '$cantactual', '$vventa', 1)");
						$db->query("UPDATE tbl_productos
									SET
									   cantidad = 0   
									WHERE id = $valor");
					}else{
						$db->query("INSERT INTO tbl_detalles_pedido(id_pedido, producto, cantidad, valor, tipo)
						VALUES      ('$idpedido', '$valor', '$cantp', '${$val.$valor}', 1)");
						$db->query("UPDATE tbl_productos
									SET
									   cantidad = $cantfinal   
									WHERE id = $valor");
					}
					
				}
				elseif (strpos($campo, 'idcombo_') !== false) { //PAY ATTENTION TO !==, not !=
					$combo="combo_";
					$val="valorc";
					$cantp=${$combo.$valor};
					//queda pendeinte lo del combo, para verificar que si tiene la cantidad de productos.
					$productoscombo=$db->query("SELECT a.id_producto, a.cantidad, (SELECT b.cantidad FROM tbl_productos b where b.id = a.id_producto  ) as 'Cantidadp'  FROM tbl_detalles_combo a where a.id_combo = '$valor' order by Cantidadp asc;");
					while ($comb = $db -> fetch_array($productoscombo)) 
					{
						$idprod=$comb[0];
						$cantprod = $comb[1]*$cantp;
						$existencia= $comb[2];
						$cantfinalc=$existencia-$cantprod;
						if($cantfinalc<0){
							$db->query("DELETE FROM tbl_pedidos WHERE id = $idpedido ");
							echo "<script>alert('No existen suficientes productos para el combo '); </script>";
							echo "<script>window.location.replace('agregarpedido.php'); </script>";							
						}
						
							
					}
					//parte dos de combos
					$valorfinal=${$val.$valor}*$cantp;
					$db->query("INSERT INTO tbl_detalles_pedido(id_pedido, producto, cantidad, valor, tipo)
						VALUES      ('$idpedido', '$valor', '$cantp', '$valorfinal', 2)");
					
					$productoscombo2=$db->query("SELECT a.id_producto, a.cantidad, (SELECT b.cantidad FROM tbl_productos b where b.id = a.id_producto  ) as 'Cantidadp'  FROM tbl_detalles_combo a where a.id_combo = '$valor';");
					while ($comb2 = $db -> fetch_array($productoscombo2)) 
					{
						$idprod=$comb2[0];
						$cantprod = $comb2[1]*$cantp;
						$existencia= $comb2[2];
						$cantfinalc=$existencia-$cantprod;	
						if($cantfinalc<0){
							
						}else{
						$db->query("UPDATE tbl_productos
									SET
									   cantidad = $cantfinalc   
									WHERE id = $idprod");
						}
					}
					
					
					
					
				}
				}
	        $totalventaactual=$db->HallaValorUnico("SELECT sum(valor) FROM tbl_detalles_pedido where  id_pedido = '$idpedido';");
			$db->query("UPDATE tbl_pedidos
						SET
						  subtotal = '$totalventaactual'
						WHERE id = '$idpedido'");	
			

	
   $pagina="apedidos.php";
	
}
elseif($tbl=='productospedido'){
			$valor_venta=$db->HallaValorUnico("SELECT  valor_venta FROM tbl_productos where id = '$producto'");
			$totalventa=$valor_venta*$cantidad;
			$cantactual=$db->HallaValorUnico("SELECT cantidad FROM tbl_productos where id = '$producto';");
			$cantfinal=$cantactual-$cantidad;
			if($cantfinal<0){				
				echo "<script>alert('No existen suficientes productos ! '); </script>";
				echo "<script>window.location.replace('aproductosp.php?id=$id'); </script>";					
			}
			else{
			$db->query("INSERT INTO tbl_detalles_pedido(id_pedido, producto, cantidad, valor, tipo)
						VALUES      ('$id', '$producto', '$cantidad', '$totalventa', 1)");	
	
			$totalventaactual=$db->HallaValorUnico("SELECT sum(valor) FROM tbl_detalles_pedido where  id_pedido = '$id';");
			$db->query("UPDATE tbl_pedidos
						SET
						  subtotal = '$totalventaactual'
						WHERE id = '$id'");	
				
			$db->query("UPDATE tbl_productos
									SET
									   cantidad = $cantfinal   
									WHERE id = $producto");
			}
			
   $pagina="aproductosp.php?id=$id";
	
}
elseif($tbl=='combopedido'){
			$idpedido=$db->HallaValorUnico("SELECT valor FROM tbl_combo where id = '$combo'");
			$totalventa=$idpedido*1;
			$almacenar=TRUE;
	        $productoscombo=$db->query("SELECT a.id_producto, a.cantidad, (SELECT b.cantidad FROM tbl_productos b where b.id = a.id_producto  ) as 'Cantidadp'  FROM tbl_detalles_combo a where a.id_combo = '$combo' order by Cantidadp asc;");
	  
					while ($comb = $db -> fetch_array($productoscombo)) 
					{
						$idprod=$comb[0];
						$cantprod = $comb[1]*$cantp;
						$existencia= $comb[2];
						$cantfinalc=$existencia-$cantprod;
						if($cantfinalc<0){							
						 $almacenar=FALSE;							
						}					
							
					}
	  
	        if($almacenar){
				$db->query("INSERT INTO tbl_detalles_pedido(id_pedido, producto, cantidad, valor,tipo)
						VALUES      ('$id', '$combo', '1', '$totalventa',2)");
				$productoscombo2=$db->query("SELECT a.id_producto, a.cantidad, (SELECT b.cantidad FROM tbl_productos b where b.id = a.id_producto  ) as 'Cantidadp'  FROM tbl_detalles_combo a where a.id_combo = '$combo';");
					while ($comb2 = $db -> fetch_array($productoscombo2)) 
					{
						$idprod=$comb2[0];
						$cantprod = $comb2[1];
						$existencia= $comb2[2];
						$cantfinalc=$existencia-$cantprod;						
						$db->query("UPDATE tbl_productos
									SET
									   cantidad = $cantfinalc   
									WHERE id = $idprod");						
					}
				
				
			}else{
				echo "<script>alert('No existen suficientes productos para el combo '); </script>";
							echo "<script>window.location.replace('agregarpedido.php'); </script>";
			}
	
			
			
			$totalventaactual=$db->HallaValorUnico("SELECT sum(valor) FROM tbl_detalles_pedido where  id_pedido = '$id';");
			$db->query("UPDATE tbl_pedidos
						SET
						  subtotal = '$totalventaactual'
						WHERE id = '$id'");	
	
   $pagina="aproductosp.php?id=$id";
	
}
elseif($tbl=='agregarcombos'){
	
	if(!empty($_FILES)){
		$tiempo = date('Y-m-d');

		$nombrei = $_FILES["imagen"]['name'];
		$ext = pathinfo($nombrei, PATHINFO_EXTENSION);
		$BaseName = pathinfo($nombrei, PATHINFO_FILENAME);
		$ruta = 'imgcombos/'.$BaseName.'-'.$tiempo.'-'.$_SESSION['id'].'.'.$ext;
		$guardado = $_FILES['imagen']['tmp_name'];
		
		if($ext == "jpge" || $ext == "png" || $ext == "jpg"){
			move_uploaded_file($guardado, 'imgcombos/'.$BaseName.'-'.$tiempo.'-'.$_SESSION['id'].'.'.$ext);
			$db->query("INSERT INTO tbl_combo(combo, valor, descripcion, imagen)
						VALUES      ('$nombre', $valor, '$descripcion', '$ruta')");
			$prod ="producto_";
			$idcombo=$db->HallaValorUnico("SELECT id FROM tbl_combo where combo = '$nombre';");
			foreach($_POST as $campo => $valor){
				if (strpos($campo, 'idproducto_') !== false) { //PAY ATTENTION TO !==, not !=
					$db->query("INSERT INTO tbl_detalles_combo(id_combo, id_producto, cantidad)
								VALUES      ($idcombo, $valor, ${$prod.$valor})");	
				}	
				}
		}else{
			echo "<script>alert('El formato de la imagen debe ser PNG, JPGE o JPG')</script>";
		}
		
	}
  $pagina="vercombos.php";
}
elseif($tbl=='mensaje'){
	
			$db->query("INSERT INTO tbl_mensajes(remitente, destino, Mensaje, fecha)
						VALUES      ($id, '$destinatario', '$mensaje', now()) ;");
				
	
    $pagina="mensajes.php";
	
}

echo "<script>window.location.replace('$pagina'); </script>";

