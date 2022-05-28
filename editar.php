<?php 

include('lib/conex.php');

$db = new MySQL();



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
	
    $db->query("UPDATE tbl_zonas
				SET
				   zona = '$zona' 
				  ,descripcion = '$descripcion' 
        		WHERE id = $id ");
    $pagina="zonas.php";
	
}elseif($tbl=='perfiles'){
	
    $db->query("UPDATE tlb_perfiles
				SET
				   perfiles = '$perfiles' 
        		WHERE id = $id ");
    $pagina="cargos.php";
	
}elseif($tbl=='tproductos'){
	
    $db->query("UPDATE tbl_tipo_producto
				SET
				   tipo_producto = '$Nproducto' 
        		WHERE id = $id ");
    $pagina="tproductos.php";
	
}elseif($tbl=='cajamenor'){
	
    $db->query("UPDATE tbl_caja_menor
				SET
				   producto = '$producto' 
				  ,tipo_producto = '$tipo_producto' 
				  ,valor = '$valor' 
				  ,fecha = '$fecha' 
        		WHERE id = $id ");
    $pagina="cajamenor.php";
	
}elseif($tbl=='canciones'){
	
    $db->query("UPDATE tbl_canciones
				SET
				   estado = '2' 
        		WHERE id = $id ");
	if($ubi == 1){
    	$pagina="pcancion.php";
	}else{
		$pagina="index.php";
	}
}elseif($tbl=='parametro'){
	
    $db->query("UPDATE tbl_parametros
				SET
				   porcentaje = '$porcentaje',
				   estado = '$estado'
        		WHERE id = $id ");
    $pagina="servicios.php";
	
}elseif($tbl=='reservas'){
	
	if(empty($fecha)){
		$fecha = $FA;	
	}
	
    $db->query("UPDATE tbl_reservas SET
				    nombre = '$nombre'
				   ,cedula = '$cedula'
				   ,fecha = '$fecha'
				   ,cant_personas ='$can_personas'
				   ,observaciones = '$observaciones'
				   ,estado = '$est'
				 WHERE id = '$id'
				");
	
    $pagina="reservas.php";
	
}elseif($tbl=='categoria'){
	
    $db->query("UPDATE tbl_categoria_productos
				SET
				   categoria = '$categoria' 
        		WHERE id = $id ");
    $pagina="categoriap.php";
	
}elseif($tbl=='mesas'){
	
    $db->query("UPDATE tlb_mesas
				SET
				   mesa = '$mesa'
				  ,zona = '$zonas'
				  ,cant_personas = '$cant_personas'
        		WHERE id = $id ");
    $pagina="mesasdisponibles.php";
	
}elseif($tbl=='Tcontratos'){
	
    $db->query("UPDATE tbl_tipos_contratos
				SET
				   tipo_contrato = '$contrato'
				  ,concepto = '$concepto'
        		WHERE id = $id ");
    $pagina="tipos_contratos.php";
	
}elseif($tbl=='imagen'){
	
	if(!empty($_FILES)){
		$tiempo = date('Y-m-d H:i:s');

		$nombre = $_FILES["imagen"]['name'];
		$ext = pathinfo($nombre, PATHINFO_EXTENSION);
		$BaseName = pathinfo($nombre, PATHINFO_FILENAME);
		$ruta = 'imgpage/'.$BaseName.'-'.$tiempo.'-'.$_SESSION['id'].'.'.$ext;
		$guardado = $_FILES['imagen']['tmp_name'];
		
		unlink("$urlimagen");

		move_uploaded_file($guardado, 'imgpage/'.$BaseName.'-'.$tiempo.'-'.$_SESSION['id'].'.'.$ext);
	}
	
	//echo "<script>alert('$ruta')</script>";
	
   $db->query("UPDATE tbl_media
				SET
				   url = '$ruta'
        		WHERE id = $id ");
    $pagina="imagenes.php";
	
}elseif($tbl=='productos'){
	
	$img = $_FILES["imagen"]['name'];
	
	if(!empty($img)){
		$tiempo = date('Y-m-d H:i:s');

		$nombre = $_FILES["imagen"]['name'];
		$ext = pathinfo($nombre, PATHINFO_EXTENSION);
		$BaseName = pathinfo($nombre, PATHINFO_FILENAME);
		$ruta = 'imagenes/'.$BaseName.'-'.$tiempo.'-'.$_SESSION['id'].'.'.$ext;
		$guardado = $_FILES['imagen']['tmp_name'];
		
		if($ext == "jpge" || $ext == "png" || $ext == "jpg"){
			
			unlink("$urlimagen");
			move_uploaded_file($guardado, 'imagenes/'.$BaseName.'-'.$tiempo.'-'.$_SESSION['id'].'.'.$ext);
			$db->query("UPDATE tbl_productos SET
					  nombre = '$nombrep'
					  ,valor_compra ='$Vcompra'
					  ,valor_venta = '$Vventa'
					  ,cantidad = '$cantidad'
					  ,imagenes = '$ruta'
					  ,categoria = '$categoria'
					  WHERE id = '$id'
					  ");
		}else{
			echo "<script>alert('El formato de la imagen debe ser PNG, JPGE o JPG nombre = $nombre')</script>";
		}
		
	}else{
		$db->query("UPDATE tbl_productos SET
					  nombre = '$nombrep'
					  ,valor_compra ='$Vcompra'
					  ,valor_venta = '$Vventa'
					  ,cantidad = '$cantidad'
					  ,imagenes = '$urlimagen'
					  ,categoria = '$categoria'
					  WHERE id = '$id'
					  ");
	}
	
	//echo "<script>alert('$ruta')</script>";
	
    $pagina="productos.php";
	
}elseif($tbl=='usuarios'){
	
	/*$cor = $db->HallaValorUnico("SELECT id FROM tbl_usuarios WHERE correo = '$correo' OR usuario = '$usuario'");
	if(empty($cor)){*/
		if($contrasenia1 == $contrasenia2){
	$pass1= Enc('enc', $contrasenia1);
	$db->query("UPDATE tbl_usuarios SET
					  nombres = '$nombres'
					  ,apellidos = '$apellidos'
					  ,tipo_doc = '$tipo_doc'
					  ,documento = '$documento'
					  ,perfil = '$cargo'
					  ,telefono = '$telefono'
					  ,direccion = '$direccion'
					  ,usuario = '$usuario'
					  ,pass = '$pass1'
					  ,correo = '$correo'
				WHERE id = '$id'
				");
			$db->query("UPDATE tbl_contratos SET
						   tipo_contrato = '$tipo_contrato'
						  ,fechainicio = '$Finicio'
						  ,fechafin = '$Ffin'
						  ,porcentaje = '$porcentaje' 
						  ,valor_contrato = '$valor_contrato'
						WHERE idusuario = '$id'
						");
			}else{
			echo "<script>alert('Las contraseñas no coinciden')</script>";
		}
	/*}else{
		echo "<script>alert('El usuario o el correo ya estan registrados en el sistema')</script>";
	}*/
    $pagina="usuarios.php";

	
}elseif($tbl=='mesaL'){
	
     $db->query("UPDATE tlb_mesas
				SET
				   estado = 'Libre' 
        		WHERE id = $id ");
    $pagina="mesasdisponibles.php";
	
}elseif($tbl=='mesaO'){
	
    $db->query("UPDATE tlb_mesas
				SET
				   estado = 'Ocupado' 
        		WHERE id = $id ");
    $pagina="agregarpedido.php?id=$id&mesa=$mesa&Np=$cant_personas";
	
}
elseif($tbl=='mensajes'){
	
    $db->query("UPDATE tbl_mensajes
				SET
				   destino = '$destinatario' 
				  ,Mensaje = '$mensaje'
				WHERE id = $id ");
	
    $pagina="mensajes.php";
	
}
elseif($tbl=='alertas'){
	
    $db->query("UPDATE tbl_alertas_producto
				SET
				   cantidad = '$Nproducto' 				  
				WHERE id = $id ");
	
    $pagina="alertas.php";
	
}

echo "<script>window.location.replace('$pagina'); </script>";