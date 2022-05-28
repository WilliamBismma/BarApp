<?php
include("header.php");
?>
<div id="content">
	<div class="outer">
		<div class="inner bg-light lter">
		<!--Begin Datatables-->
		
		<div class="row">
			<div class="col-lg-12">
				<div class="box">
				<header>
					<div class="icons"><i class="fa fa-table"></i></div>
					<h5>Ingresos</h5>
				</header>
				 <?php tabla_ingresos($db); ?>
			</div>
			</div>
		</div>		
		<!-- /.row -->
		<!--End Datatables-->
		<hr>
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
					<strong><i class="fa fa-users"></i> <?php echo $ingresos-$salidas; ?></strong>Personas en el sitio
				</div>
			</li>		
		</ul>
	</div>
		</div>
	<!-- /.inner -->
	</div>
<!-- /.outer -->
</div>
<?php
include("footer.php");
?>