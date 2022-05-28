<?php
include("header.php");
?>
<div id="content">
	<div class="outer">
		<div class="inner bg-light lter">
		<!--Begin Datatables-->
		<div class="text-center">
		<br>			
			<button type="button" class="btn btn-metis-6 btn-lg btn-grad btn-rect" data-toggle='modal' data-target='#add' data-whatever='@mdo'>
                                <i class="fa fa-archive"></i>&nbsp; Agregar</button>  
			
			</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="box">
				<header>
					<div class="icons"><i class="fa fa-table"></i></div>
					<h5>Productos</h5>
				</header>
				 <?php tabla_productos($db); ?>
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
                    <label for='recipient-name' class='col-form-label'>Nombre:</label>
                    <input class='form-control' type='text' name ='nombrep' id='nombrep' placeholder='Ingrese el nombre del producto' required/>
                </div>
                
				<div class='form-group'>
                	<label for='message-text' class='col-form-label'>Valor Compra:</label>
                	<input class='form-control' type='number' name ='Vcompra' id='Vcompra' placeholder='Ingrese el valor de compra' required/>
                </div>
				
				<div class='form-group'>
                	<label for='message-text' class='col-form-label'>Valor Venta:</label>
                	<input class='form-control' type='number' name ='Vventa' id='Vventa' placeholder='Ingrese el valor de venta' required/>
                </div>
				
				<div class='form-group'>
                	<label for='message-text' class='col-form-label'>Cantidad:</label>
                	<input class='form-control' type='number' name ='cantidad' id='cantidad' placeholder='Ingrese la cantidad disponible' required/>
                </div>
				
				<div class='form-group'>
						<label for='recipient-name' class='col-form-label'>Categoria:</label>
						
						<select name="categoria" id="categoria" class="form-control" required>
							<option selected>Seleccionar</option>
							<?php					

								$query2 = "SELECT id , categoria FROM `tbl_categoria_productos`";
								$data3 = $db->query($query2);
								while ($val3 = $db -> fetch_array($data3)) 
									{
										Printf ("<option  value=".$val3['id'].">".$val3['categoria']."</option>");
									}  		
							?>
						</select>
					</div>
				
				<div class='form-group'>
                	<label for='message-text' class='col-form-label'>Imagen:</label>
                	<input class='form-control' type='file' name ='imagen' id='imagen' required/>
                </div>
                
				<input type='hidden' name ='tbl' value='productos'>        
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
