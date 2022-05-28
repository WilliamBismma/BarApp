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
					<h5>Mesas</h5>
				</header>
				 <?php tabla_mesas($db); ?>			
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
                    <input class='form-control' type='text' name ='mesa' id='mesa' placeholder='Ingrese el nombre de la mesa' required/>
                </div>
				<div class='form-group'>
                    <label for='recipient-name' class='col-form-label'>Zona:</label>
					<select name="zona" required class="form-control">
						<option selected>Seleccionar</option>
					<?php 
					$query2 = $db->query("SELECT id, zona FROM tbl_zonas");
					while($UserDatos = mysqli_fetch_array($query2)){
						echo "<option value='".$UserDatos['id']."'>".$UserDatos['zona']."</option>";
					}
					?>
					
					</select>
                </div>
				<div class='form-group'>
                    <label for='recipient-name' class='col-form-label'>Cantidad de Personas:</label>
                    <input class='form-control' type='number' name ='cant_personas' id='cant_personas' placeholder='Ingrese la cantidad de personas' required/>
                </div>
				
               	<input type='hidden' name ='tbl' value='mesas2'>
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