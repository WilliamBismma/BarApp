<?php 

include('lib/conex.php');

$db = new MySQL();

session_start();
$idSesion = $_SESSION['id'];

$totalventas= $db->HallaValorUnico("SELECT  sum(a.subtotal) FROM tbl_pedidos a where a.id not in (SELECT id_pedido FROM tbl_comisiones) and estado= 2;");
$comisiontotal= $db->query("SELECT idusuario, porcentaje FROM tbl_contratos where  tipo_contrato = 6;");
while ($comi = $db -> fetch_array($comisiontotal)) 
{
	$valorcomision=($totalventas*$comi[1])/100;
	$db->query("INSERT INTO tbl_comisiones(id_pedido, valor, fecha, id_usuario)
						VALUES      ('', '$valorcomision', now(), '$comi[0]' )");	
}

$consulta=$db->query("SELECT a.id,(a.subtotal*(SELECT  b.porcentaje FROM tbl_contratos  b where b.idusuario = a.asesor)/100), now() as 'Fecha', a.asesor
FROM tbl_pedidos a where a.id not in (SELECT id_pedido FROM tbl_comisiones) and estado= 2;");

while ($datos = $db -> fetch_array($consulta)) 
			{
			$db->query("INSERT INTO tbl_comisiones(id_pedido, valor, fecha, id_usuario)
						VALUES      ('$datos[0]', '$datos[1]', '$datos[2]', '$datos[3]')");			
			}
$db->query("truncate table tbl_ingresos;");
$db->query("truncate table tbl_salidas;");

echo "<script>window.location.replace('comisiones.php'); </script>";