<?php
include("header.php");
?>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

	function getlink() {
		var aux = document.createElement("input");
		aux.setAttribute("value","<?php echo  $_SERVER['SERVER_NAME']."/reservausu.php" ?>");
		document.body.appendChild(aux);
		aux.select();
		document.execCommand("copy");
		document.body.removeChild(aux);
		Swal.fire({
		  icon: 'success',
		  title: 'Listo...',
		  text: '¡Link copiado exitosamente!'
		})
	}
	
</script>         
<!-- /#left -->
<div id="content">
	<div class="outer">
	<div class="inner bg-light lter">
	<div class="text-center">
		<ul class="stats_box">
			<li>
			<div class="stat_text">
				<?php $ingresos = $db->HallaValorUnico("SELECT count(id) FROM tbl_ingresos where TIMESTAMPDIFF(MINUTE , fecha, now() )< 720") ?>
					<strong><i class="fa fa-users"></i> <?php echo $ingresos; ?></strong>Ingresos Hoy.
					<span class="percent up"> <i class="fa fa-caret-up"></i></span>
				</div>
			</li>
			<li>
				<div class="stat_text">
					<?php $salidas = $db->HallaValorUnico("SELECT cantidad FROM tbl_salidas where TIMESTAMPDIFF(MINUTE , fecha, now() )< 720");
							if($salidas == null){
								$salidas=0;
							}
					?>
					<strong><i class="fa fa-door-open"></i> <?php echo $salidas; ?></strong>Salidas Hoy
					<span class="percent down"> <i class="fa fa-caret-down"></i></span>
				</div>
			</li>
			<li>
				<div class="stat_text">
					<?php $pendi = $db->HallaValorUnico("SELECT COUNT(id) FROM tbl_pedidos WHERE estado = 1") ?>
					<strong><i class="fa fa-receipt"></i> <?php echo $pendi; ?></strong>Pedidos Pendientes
					<span class="percent up"> <i class="fa fa-caret-up"></i></span>
				</div>
			</li>
			<li>			
				<div class="stat_text">
					<strong><i class="fa fa-users"></i> <?php echo $ingresos-$salidas; ?></strong>Personas en el sitio 
				</div>
			</li>
			<li>			
				<div class="stat_text">
					<?php $totalventas= $db->HallaValorUnico("SELECT  sum(a.subtotal) FROM tbl_pedidos a where a.id not in (SELECT id_pedido FROM tbl_comisiones) and estado= 2;"); ?>
					<strong><i class="fa fa-usd"></i> $<?php echo number_format($totalventas, 0); ?></strong>Ventas del día 
				</div>
			</li>
		</ul>
	</div>
	<button class="btn btn-info col-lg-12" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="¡Link copiado!" onClick="location.href='javascript:getlink();'"><i class="fa fa-files-o me-2" aria-hidden="true" style="color: white"></i>  Copiar URL para reservas de usuarios</button>	
	<br><br>
	<hr>
	<div class="row">
	<div class="col-lg-8">
	<div class="box">
	<header>
	<h5>Canciones</h5>
	</header>
	<div class="body" id="trigo" style="height: 250px;">
	
				 <?php tabla_canciones($db,2); ?>
		
	</div>
	</div>
	</div>
	<div class="col-lg-4">
	<div class="box">
	<div class="body">
	<table class="table table-condensed table-hovered sortableTable">
	<thead>
	<tr>
	<th>ID <i class="fa sort"></i></th>
	<th>Nombre <i class="fa sort"></i></th>
	<th>Cantidad <i class="fa sort"></i></th>
	</tr>
	</thead>
	<tbody>
	<?php
	$cn = $db->query("SELECT a.id, a.nombre, a.cantidad, 
						if(cantidad > (SELECT b.cantidad FROM tbl_alertas_producto b where b.prioridad = 1), if(cantidad > (SELECT b.cantidad FROM tbl_alertas_producto b where b.prioridad = 2),if(cantidad > (SELECT b.cantidad FROM tbl_alertas_producto b where b.prioridad = 3),'','success'),'warning'), 'danger') as 'Color'
						FROM tbl_productos a where cantidad < (SELECT b.cantidad FROM tbl_alertas_producto b where b.prioridad = 3) order by cantidad asc  ;");
	while ($datos = $db -> fetch_array($cn)) 
	{
		?>
		<tr class="<?php echo $datos[3] ?>">
		<td><?php echo $datos[0] ?></td>
		<td><?php echo $datos[1] ?></td>
		<td><?php echo $datos[2] ?></td>
		</tr>
		<?php
	}
		?>	
	</tbody>
	</table>
	</div>
	</div>
	</div>
	</div>
	<hr>
	
	</div>
	<!-- /.inner -->
	</div>
<!-- /.outer -->
</div>
<script>
     setTimeout('document.location.reload()',300000);
</script>
                <!-- /#content -->
<?php
include("footer.php");
?>
