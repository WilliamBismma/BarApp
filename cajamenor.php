<?php
include("header.php");
?>
<div id="content">
	<div class="outer">
		<div class="inner bg-light lter">
		<!--Begin Datatables-->
		<?php if(empty($_GET)){?>
		<div class="text-center">
			

			<button type="button" class="btn btn-metis-6 btn-lg btn-grad btn-rect" data-toggle='modal' data-target='#add' data-whatever='@mdo'>
                                <i class="fa fa-archive"></i>&nbsp; Agregar</button>  
			
			</div>
		<?php } ?>
		<div class="row">
			<div class="col-lg-12">
				<div class="box">
				<header>
					<div class="icons"><i class="fa fa-table"></i></div>
					<h5>Caja Menor / Compras</h5>
				</header>
				<?php if(!empty($_GET)){?>
				<form action="lib/excelp.php" method="post">
				<div class="row col-lg-12">
					<div class="col-lg-6">
						<label for="" class="">Fecha Inicial</label>
						<input type="date" class="form-control" name="fecha1">
					</div>
					<div class="col-lg-6">
						<label for="" class="">Fecha Final</label>
						<input type="date" class="form-control" name="fecha2">
					</div><br><br>
					
				</div><br><br><br><br><br>
				<center>
					<button class="btn btn-metis-6 btn-grad btn-rect col-lg-4" type="submit" style="position: absolute; left: 30%">Generar Reporte</button><br><br><br>	
				</center>
			</form><br><br><br>
					
				 <?php }else{ tabla_cajamenor($db); }?>
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
 <div class='modal fade' id='add' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
        <div class='modal-dialog' role='document'>
        <div class='modal-content bg-dark text-white'>
            <div class='modal-header'>
            <h3 class='modal-title text-left' id='exampleModalLabel'>Agregar</h3>                    
            </div> 
            <form action='agregar.php' method='post' enctype='multipart/form-data'>
            <div class='modal-body'>          
            <label></label>     
                <div class='form-group'>
                    <label for='recipient-name' class='col-form-label'>Producto:</label>
                    <input class='form-control' type='text' name ='producto' id='producto' placeholder='Ingrese el nombre del producto comprado' required/>
                </div>
				
				<div class='form-group'>
					<label for='recipient-name' class='col-form-label'>Tipo de producto:</label>

					<select name="tipo_producto" id="tipo_producto" class="form-control">
						<option selected>Seleccionar</option>
						<?php					

							$query2 = "SELECT id , tipo_producto FROM `tbl_tipo_producto`";
							$data3 = $db->query($query2);
							while ($val3 = $db -> fetch_array($data3)) 
								{
									Printf ("<option  value=".$val3['id'].">".$val3['tipo_producto']."</option>");
								}  		
						?>
					</select>
				</div>
				
				<div class='form-group'>
                    <label for='recipient-name' class='col-form-label'>Valor:</label>
                    <input class='form-control' type='number' name ='valor' id='valor' placeholder='Ingrese el valor del producto comprado' required/>
                </div>
				
				<div class='form-group'>
                    <label for='recipient-name' class='col-form-label'>Fecha de la compra:</label>
                    <input class='form-control' type='date' name ='fecha' id='fecha' required/>
                </div>
				
                 <input type='hidden' name ='tbl' value='cajamenor'>        
            </div>                  
            <div class='modal-footer'>
            <button type='button' class='btn btn-danger btn-grad' data-dismiss='modal'>Cancelar</button>
            <button type='submit' class='btn btn-success btn-grad' id='btnenviar' name='btnenviar'>Enviar</button>
            </div>
            </form>
        </div>
        </div>
        </div>
<?php
include("footer.php");
?>
