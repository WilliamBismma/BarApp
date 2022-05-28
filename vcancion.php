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
						<h5>Canciones</h5>
					</header>
					 <?php tabla_canciones($db,1); ?>
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
