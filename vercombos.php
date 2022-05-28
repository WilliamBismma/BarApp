<?php
include("header.php");

?>
<div id="content">
	<div class="outer">
		<div class="inner bg-light lter">
		<!--Begin Datatables-->
		<div class="text-center">
		<br>	 
			<a href='combos.php?' class='btn btn-metis-6 btn-lg btn-grad btn-rect'><i class="fa fa-archive"></i>&nbsp;Agregar</a>
			</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="box">
				<header>
					<div class="icons"><i class="fa fa-table"></i></div>
					<h5>Combos</h5>
				</header>	
				 <?php 
					tabla_combos($db); ?>
			</div>
			</div>
		</div>
		<!-- /.row -->
		<!--End Datatables-->

		</div>
	<!-- /.inner -->
	</div>
<!-- /.outer -->
</div>
 
<?php
include("footer.php");
?>
