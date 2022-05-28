<?php
include("header.php");
$idPedido=$_GET['id'];
$pedido=$db->Query("SELECT  (SELECT  b.mesa FROM tlb_mesas b where b.id =a.mesa)  as 'Mesa', (SELECT concat(c.nombres,' ' ,c.apellidos) FROM tbl_usuarios c where c.id = a.asesor) as 'Asesor',  a.subtotal  FROM tbl_pedidos a where id = '$idPedido';");
$datospedidos = $db->fetch_array($pedido);
?>
<script>

	function envio1(){
		if(document.getElementById("producto").value != "Seleccionar"){
			document.getElementById("envio1").style.display = "block";
		}else{
			document.getElementById("envio1").style.display = "none";
		}
	}
	
	function envio2(){
		if(document.getElementById("combo").value != "Seleccionar"){
			document.getElementById("envio2").style.display = "block";
		}else{
			document.getElementById("envio2").style.display = "none";	
		}
	}
	
</script>
<div id="content">
	<div class="outer">
		<div class="inner bg-light lter">
		<!--Begin Datatables-->
			<br>
			<a href="apedidos.php" class="btn btn-info" style="text-align: left"><i class="fa fa-backward"></i>  Regresar</a>
		<div class="text-center">
		<br>
	   
		<!-- Active/Hover styles -->
		<div class="row">
				<div class="col-lg-12">
				<div class="box">
					<header>
						<div class="icons"><i class="fa fa-th"></i></div>
						<h5>Datos del Pedido</h5>

						<!-- .toolbar -->
						<div class="toolbar">
						  <nav style="padding: 8px;">
							  <a href="javascript:;" class="btn btn-default btn-xs collapse-box">
								  <i class="fa fa-minus"></i>
							  </a>	
						  </nav>
						</div>                <!-- /.toolbar -->

					</header>
					<div id="div-5" class="body">						
							<div class="form-group row">
								<div class="col-lg-3">
									<label for='recipient-name' class='col-form-label'>Mesa:</label>
								</div>
								<!-- /.col-lg-3 -->
								<div class="col-lg-3">
									<label for='recipient-name' class='col-form-label'><?php echo $datospedidos['Mesa'] ?></label>
								</div>
								<div class="col-lg-3">
									<label for='recipient-name' class='col-form-label'>Mesero:</label>
								</div>
								<div class="col-lg-3">
									<label for='recipient-name' class='col-form-label'><?php echo $datospedidos['Asesor'] ?></label>
								</div>
								<!-- /.col-lg-9 -->
							</div>
							<div class="form-group row">
								<div class="col-lg-4">
									<h2><label for='recipient-name' class='col-form-label'>Total Pedido: </label></h2>
								</div>
								<!-- /.col-lg-4 -->
								<div class="col-lg-8">
									<h2><label for='recipient-name' class='col-form-label'>$<?php echo number_format($datospedidos['subtotal'], 2, '.', ',') ?></label></h2>
								</div>
								<!-- /.col-lg-8 -->
							</div>
							<div class="form-group row">
								<form action='agregar.php' method='post' enctype='multipart/form-data'>
								<div class="col-lg-2">
									<label for='recipient-name' class='col-form-label'>Producto </label>
								</div>
								<!-- /.col-lg-5 -->
								<div class="col-lg-2">
									<select name="producto" id="producto" class="form-control" required onClick="envio1()">
									<option selected>Seleccionar</option>
									<?php
										$query1 = "SELECT id, nombre, valor_venta , cantidad  FROM tbl_productos where cantidad > 0;";
										$data1 = $db->query($query1);
										while ($val1 = $db -> fetch_array($data1)) 
											{
												Printf ("<option  value=".$val1['id'].">".$val1['nombre']." (Precio: $".number_format($val1['valor_venta'], 2, '.', ',')." // cantidad disponible:".$val1['cantidad']."  )</option>");
											}  		
									?>
								</select>
								</div>
								<div class="col-lg-2">
									<label for='recipient-name' class='col-form-label'>cantidad </label>
								</div>
								<div class="col-lg-2">
									<input class='form-control' type='number' name ='cantidad' value="1" id='cantidad' placeholder='Ingrese la cantidad' min="1" required/>
									<input type='hidden' name ='tbl' value='productospedido'>
									<input type='hidden' name ='id' value='<?php echo $idPedido ?>'>
								</div>
								<div class="col-lg-2" id="envio1" style="display: none">
									<button type='submit' class='btn btn-metis-6 btn-grad btn-rect' id='btnenviar' name='btnenviar'>Agregar</button> 
								</div>
								</form>
							</div>
							<div class="form-group row">
								<form action='agregar.php' method='post' enctype='multipart/form-data'>
								<div class="col-lg-4">
									<label for='recipient-name' class='col-form-label'>Combo </label>
								</div>
								<!-- /.col-lg-5 -->
								<div class="col-lg-4">
									<select name="combo" id="combo" class="form-control" required onClick="envio2()">
									<option selected>Seleccionar</option>
									<?php
										$query2 = "SELECT id, combo, valor FROM tbl_combo;";
										$data2 = $db->query($query2);
										while ($val2 = $db -> fetch_array($data2)) 
											{
												Printf ("<option  value=".$val2['id'].">".$val2['combo']." (Precio: $".number_format($val2['valor'], 2, '.', ',').")</option>");
											}  		
									?>
								</select>
								<input type='hidden' name ='tbl' value='combopedido'>
								<input type='hidden' name ='id' value='<?php echo $idPedido ?>'>
								</div>							
								<div class="col-lg-2" id="envio2" style="display: none">
									<button type='submit' class='btn btn-metis-6 btn-grad btn-rect' id='btnenviar' name='btnenviar'>Agregar</button>  
								</div>
								</form>
								<!-- /.col-lg-7 -->
							</div>	
					</div>
				</div>
			</div>
		</div> 
			
			</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="box">
				<header>
					<div class="icons"><i class="fa fa-table"></i></div>
					<h5>Productos del Pedido # <?php echo $idPedido ?></h5>
				</header>
					
					
				 <?php 
					tabla_productos_pedido($db,$idPedido); ?>
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