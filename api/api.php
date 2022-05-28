<?php 

include('../lib/conex.php');
$db = new MySQL();


//capturamos el json
$data = json_decode(file_get_contents('php://input'), true);
//creamos la svariables
$action=$data["action"];
$user=$data["user"];
$pass=$data["pass"];
$idusr=$data["idusr"];
$asesor=$data["asesor"];
$cancion=$data["cancion"];
$artista=$data["artista"];
$mensaje=$data["mensaje"];
$img=$data["img"];
$idcancion=$data["idcancion"];

/**recoger VARIABLES POR POST **/
	$NumeroVariables = count($_POST);
	$NombreVariables = array_keys($_POST); // obtiene los nombres de las varibles
	$ValoresVariables = array_values($_POST);// obtiene los valores de las varibles
       for($i=0;$i<$NumeroVariables;$i++){ // crea las variables y les asigna el valor
	    ${$NombreVariables[$i]}=$ValoresVariables[$i]; }



if($action=="login"){
	$pass1= Enc('enc', $pass);	
	$cn = $db->query("SELECT count(a.id), a.nombres,  (SELECT b.perfiles FROM tlb_perfiles b where b.id = a.perfil), a.id FROM tbl_usuarios a where a.usuario = '".$user."' and a.pass = '".$pass1."';");
	$count=$db->fetch_array($cn);
	if($count[0]>0){
		$logo=$db->HallaValorUnico("SELECT url FROM tbl_media where tipo='logo';");
		$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
		$logofinal= $link."/".$logo;
		$consulta["Login"] = "1";
		$consulta["Id"] = $count[3];
		$consulta["Nombre"] = $count[1];			
		$consulta["Perfil"] = $count[2];
		$consulta["Logo"] = $logofinal;
		$json["user"][] = $consulta;
		echo json_encode($json);
	}else{
		$consulta["Login"] = "2";
		$consulta["Nombre"] = "Datos Incorrectos";			
		$consulta["Perfil"] = "";
		$json["user"][] = $consulta;
		echo json_encode($json);
	}
	
}
elseif($action=="datos"){
	$cn = $db->query("SELECT count(id), a.nombres, a.apellidos, (SELECT c.tipo_doc FROM tbl_tipos_documentos c where c.id = a.tipo_doc), a.documento, (SELECT b.perfiles FROM tlb_perfiles b where b.id = a.perfil), a.telefono,
	a.direccion, a.usuario,  a.correo FROM tbl_usuarios a where id = '$idusr';");
	$count=$db->fetch_array($cn);
	if($count[0]>0){
		$consulta["Nombres"] = $count[1];
		$consulta["Apellidos"] = $count[2];
		$consulta["Tipo_Documento"] = $count[3];			
		$consulta["Documento"] = $count[4];
		$consulta["Perfil"] = $count[5];
		$consulta["Telefono"] = $count[6];
		$consulta["Direccion"] = $count[7];
		$consulta["Usuario"] = $count[8];
		$consulta["Correo"] = $count[9];
		$json["user"][] = $consulta;
		echo json_encode($json);
	}else{
		$consulta["Datos"] = "No Existen Datos";
		$consulta["Nombre"] = "No Existen Datos";			
		$consulta["Perfil"] = "No Existen Datos";
		$json["user"][] = $consulta;
		echo json_encode($json);
	}
	
	
}
elseif($action=="ingresos"){
	
	 $db->query("INSERT INTO tbl_ingresos(documento, carnetcovid, fecha, estado, img) VALUES  ('$datos', '$carnetcovid', now(), 1, '$img');");
	 $consul=$db->HallaValorUnico("SELECT id FROM tbl_ingresos where documento = '$datos';");
	if($consul>0){	
		echo "Exitoso";		
	}else{		
		echo "Intente de nuevo";
	}
	//echo "INSERT INTO tbl_ingresos(documento, carnetcovid, fecha, estado) 				VALUES      ('$datos', '$carnetcovid', now(), 1);";
	
}
elseif($action=="salidas"){
	
	 $cn=$db->query("SELECT  id, cantidad FROM tbl_salidas where TIMESTAMPDIFF(MINUTE , fecha, now() )< 720");
	$count=$db->fetch_array($cn);
	if($count[0]>0){
		$total=$cant+$count[1];
		$db->query("UPDATE tbl_salidas
					SET
					  cantidad = $total
					WHERE id = $count[0]");		
		echo "Exitoso";		
	}else{
		$db->query("INSERT INTO tbl_salidas(fecha, cantidad)
					VALUES      (now(), '$cant')");
		
		echo "Exitoso";
	}
	
}
elseif($action=="cambioP"){
	$passencode = Enc('enc',$passC);
	$db->query("UPDATE tbl_usuarios SET pass = '$passencode' WHERE id = '$iduser'");			
	echo "ok";
}
elseif($action=="combos"){
	$cn = $db->query("SELECT id , combo, valor, descripcion , imagen  FROM tbl_combo where estado = 1;");
	while ($datos = $db -> fetch_array($cn)) 
			{
				$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
		        $imagencombo= $link."/".$datos[4];
				$consulta["id"] = $datos[0];
				$consulta["combo"] = $datos[1];
				$consulta["valor"] = $datos[2];			
				$consulta["descripcion"] = $datos[3];
				$consulta["imagen"] = $imagencombo;
		
				$productos = $db->query("SELECT  (Select b.nombre from tbl_productos b where b.id = a.id_producto ), a.cantidad 
				FROM tbl_detalles_combo a where id_combo = '$datos[0]'");
				foreach ($consulta["productos"] as $i => $value) { unset($consulta["productos"]); }

				while ($produc = $db -> fetch_array($productos)) 
				{
					$productoscombo["producto"] = $produc[0];
					$productoscombo["cantidad_combo"] = $produc[1];						
					$consulta["productos"][] = $productoscombo;					
				}
				
				$json["combo"][] = $consulta;
			}
		echo json_encode($json);
}
elseif($action=="productos"){
	$cn = $db->query("SELECT id, nombre, valor_venta, imagenes, cantidad
						FROM tbl_productos where cantidad > 1;");
	while ($datos = $db -> fetch_array($cn)) 
			{
				$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
		        $imagenproduct= $link."/".$datos[3];
				$consulta["id"] = $datos[0];
				$consulta["nombre"] = $datos[1];
				$consulta["valor"] = $datos[2];	
				$consulta["cantidad"] = $datos[4];	
				$consulta["imagen"] = $imagenproduct;
				$json["productos"][] = $consulta;
			}
		echo json_encode($json);
}
elseif($action=="mesas"){
	
	$cn = $db->query("SELECT id, mesa
					  FROM tlb_mesas;");
	while ($datos = $db -> fetch_array($cn)) 
			{				
				$consulta["mesa"] = $datos[1];			
				$json["mesas"][] = $consulta;
			}
		echo json_encode($json);
}
elseif($action=="crearpedido"){
	 $mesa=$db->HallaValorUnico("SELECT id FROM tlb_mesas where mesa = '$nombremesa';");
	
	 $db->query("INSERT INTO tbl_pedidos(mesa, fecha, asesor, estado)
	 			VALUES      ( '$mesa', now(), '$asesor', 1);");	
	if($mesa!=""){
		$db->query("UPDATE tlb_mesas
					SET
					   estado = 'Ocupado'
					   WHERE id = $mesa;");	
	}
	
	 $consul=$db->HallaValorUnico("SELECT id FROM tbl_pedidos where asesor = '$asesor' and estado = 1 order by id desc  ;");
	
	if($consul>0){	
		echo $consul;		
	}else{		
		echo 0;
	}
}
elseif($action=="detalle_pedido"){
	if($tipo==1){
		//producto
		$vventa=$db->HallaValorUnico("SELECT  valor_venta FROM tbl_productos where id = '$idporducto';");
		$cantactual=$db->HallaValorUnico("SELECT cantidad FROM tbl_productos where id = '$idporducto';");
		$nombre=$db->HallaValorUnico("SELECT nombre FROM tbl_productos where id = '$idporducto';");
		$cantfinal=$cantactual-$cantidad;
		$valorfinal=$vventa*$cantidad;
		if($cantfinal<0){
			
		echo "No Existen productos suficientes para ese pedido producto: ".$nombre;		
			
		}else{
			
			$db->query("INSERT INTO tbl_detalles_pedido(id_pedido, producto, cantidad, valor, tipo)
			VALUES      ('$idpedido', '$idporducto', '$cantidad', '$valorfinal', 1)");
			
			$db->query("UPDATE tbl_productos
						SET
						   cantidad = $cantfinal   
						WHERE id = $idporducto");
			echo 1;
		}
	}elseif($tipo==2){
		//combo
		$disponible=TRUE;
		$nombre=$db->HallaValorUnico("SELECT combo FROM tbl_combo where id = '$idporducto';");
		$productoscombo=$db->query("SELECT a.id_producto, a.cantidad, (SELECT b.cantidad FROM tbl_productos b where b.id = a.id_producto  ) as 'Cantidadp'  FROM tbl_detalles_combo a where a.id_combo = '$idporducto' order by Cantidadp asc;");
		while ($comb = $db -> fetch_array($productoscombo)) 
		{
			$idprod=$comb[0];
			$cantprod = $comb[1]*$cantp;
			$existencia= $comb[2];
			$cantfinalc=$existencia-$cantprod;
			if($cantfinalc<0){	
				$disponible=FALSE;
				echo "No Existen productos suficientes para ese pedido combo: ".$nombre;
				
			}


		}
		if($disponible){
		$valorcombo=$db->HallaValorUnico("SELECT valor FROM tbl_combo where id = '$idporducto';");
		$valorfinal=$valorcombo*$cantidad;
		$db->query("INSERT INTO tbl_detalles_pedido(id_pedido, producto, cantidad, valor, tipo)
				VALUES      ('$idpedido', '$idporducto', '$cantidad', '$valorfinal', 2)");

			$productoscombo2=$db->query("SELECT a.id_producto, a.cantidad, (SELECT b.cantidad FROM tbl_productos b where b.id = a.id_producto  ) as 'Cantidadp'  FROM tbl_detalles_combo a where a.id_combo = '$idporducto';");
			while ($comb2 = $db -> fetch_array($productoscombo2)) 
			{
				$idprod=$comb2[0];
				$cantprod = $comb2[1]*$cantidad;
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
			echo 1;
		}
	}
	
	 $totalventaactual=$db->HallaValorUnico("SELECT sum(valor) FROM tbl_detalles_pedido where  id_pedido = '$idpedido';");
			$db->query("UPDATE tbl_pedidos
						SET
						  subtotal = '$totalventaactual'
						WHERE id = '$idpedido'");

}
elseif($action=="verpedidos"){
	
	//$cn = $db->query("SELECT a.id, a.subtotal, (SELECT  b.mesa FROM tlb_mesas b where b.id= a.mesa)   FROM tbl_pedidos a where asesor = '$asesor' and estado = 1 and a.subtotal > 0;");
	$cn = $db->query("SELECT a.id, IFNULL(a.subtotal, 0), IFNULL((SELECT  b.mesa FROM tlb_mesas b where b.id= a.mesa),'No registra'), (Select count(c.id) from tbl_detalles_pedido c where c.id_pedido = a.id )  
	FROM tbl_pedidos a where asesor = '$asesor' and estado = 1 order by a.id desc");
	while ($datos = $db -> fetch_array($cn)) 
			{
			
				$consulta["id"] = $datos[0];
				$consulta["mesa"] = $datos[2];
				$consulta["subtotal"] = $datos[1];
				$consulta["cantidad"] = $datos[3];
		
				$productos = $db->query("SELECT a.id as 'ID', if( tipo=1, (SELECT b.nombre  FROM tbl_productos b where b.id = a.producto), (SELECT c.combo  FROM tbl_combo c where c.id = a.producto)) as 'Producto' , a.cantidad as 'Cantidad', concat('$',FORMAT(a.valor,2))  as 'Valor'
				FROM tbl_detalles_pedido a where a.id_pedido =  '$datos[0]'");
		
				foreach ($consulta["productos"] as $i => $value) { unset($consulta["productos"]); }

				while ($produc = $db -> fetch_array($productos)) 
				{
					$productoscombo["producto"] = $produc[1];
					$productoscombo["cantidad"] = $produc[2];	
					$productoscombo["valor"] = $produc[3];	
					$consulta["productos"][] = $productoscombo;					
				}
				
				$json["pedidos"][] = $consulta;
			}
		echo json_encode($json);
}
elseif($action=="mensajes"){
	

	$perfil=$db->HallaValorUnico("SELECT (SELECT b.perfiles FROM tlb_perfiles b where b.id = a.perfil ) FROM tbl_usuarios a where a.id= '$asesor';");
	
	$cn = $db->query("SELECT a.Mensaje, (SELECT concat(b.nombres,' ', b.apellidos) FROM tbl_usuarios b where b.id = a.remitente) , a.fecha  FROM tbl_mensajes  a where a.destino = 'Todos' or a.destino ='$asesor'  or a.destino ='$perfil' order by a.fecha desc ;");
	while ($datos = $db -> fetch_array($cn)) 
			{
			
				$consulta["Mensaje"] = $datos[0];
				$consulta["remitente"] = $datos[1];
				$consulta["fecha"] = $datos[2];
				$json["mensajes"][] = $consulta;
			}
		echo json_encode($json);
}
elseif($action=='canciones'){
	
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
	echo "ok";
}
elseif($action=='crearmensaje'){
	
			$db->query("INSERT INTO tbl_mensajes(remitente, destino, Mensaje, fecha)
						VALUES      ($asesor, '$destinatario', '$mensaje', now()) ;");
				
	
    $pagina="mensajes.php";
	
}
elseif($action=="destinatario"){
	
	$cn = $db->query("SELECT id, concat(nombres,' ', apellidos)  FROM tbl_usuarios where estado = 1;");
	
	$consulta["id"] = "Todos";
	$consulta["nombre"] = "Todos";
	$json["destinatarios"][] = $consulta;
	$consulta["id"] = "Meseros";
	$consulta["nombre"] = "Meseros";
	$json["destinatarios"][] = $consulta;
	$consulta["id"] = "Barra";
	$consulta["nombre"] = "Barra";
	$json["destinatarios"][] = $consulta;
	$consulta["id"] = "Dj";
	$consulta["nombre"] = "Dj";
	$json["destinatarios"][] = $consulta;
	$consulta["id"] = "Puerta";
	$consulta["nombre"] = "Puerta";
	$json["destinatarios"][] = $consulta;
	
	while ($datos = $db -> fetch_array($cn)) 
			{				
				$consulta["id"] = $datos[0];
				$consulta["nombre"] = $datos[1];
		$json["destinatarios"][] = $consulta;
				
			}
	
		echo json_encode($json);
}
elseif($action=="clientes"){
	
	$ingresos = $db->HallaValorUnico("SELECT count(id) FROM tbl_ingresos where TIMESTAMPDIFF(MINUTE , fecha, now() )< 720");
	$salidas = $db->HallaValorUnico("SELECT cantidad FROM tbl_salidas where TIMESTAMPDIFF(MINUTE , fecha, now() )< 720");
	$clientes = $ingresos-$salidas;
	echo $clientes;
}
elseif($action=="mispedidos"){
	
	$pedidos = $db->HallaValorUnico("SELECT count(a.id) FROM tbl_pedidos a where a.id not in (SELECT id_pedido FROM tbl_comisiones) and estado= 2 and asesor = '$asesor';");
	
	echo $pedidos;
}
elseif($action=="vercanciones"){
	
	
	$cn = $db->query("SELECT id, artista, cancion FROM tbl_canciones where  estado = 1;");
	while ($datos = $db -> fetch_array($cn)) 
			{
			
				$consulta["id"] = $datos[0];
				$consulta["artista"] = $datos[1];
				$consulta["cancion"] = $datos[2];
				$json["canciones"][] = $consulta;
			}
		echo json_encode($json);
}
elseif($action=="estadocancion"){
	$cn = $db->query("UPDATE tbl_canciones
						SET
						  estado = 2
						WHERE id = '$idcancion';");
		echo "ok";
}




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