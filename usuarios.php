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
					<h5>Usuarios</h5>
				</header>
				 <?php tabla_usuarios($db); ?>
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
				<div class='modal-body row'>
					
				<label></label>     
					
					<div class='form-group col-lg-6'>
						<label for='recipient-name' class='col-form-label'>Nombres:</label>
						<input class='form-control' type='text' name ='nombres' id='nombres' placeholder='Ingrese el nombre del usuario' required/>
					</div>
					
					<div class='form-group col-lg-6'>
						<label for='message-text' class='col-form-label'>Apellidos:</label>
						<input type="text" class='form-control'  name='apellidos' id='apellidos' placeholder='Ingrese el apellido del usuario' required>
					</div>
					
					<div class='form-group col-lg-6'>
						<label for='recipient-name' class='col-form-label'>Tipo Documento:</label>
						
						<select name="tipo_doc" id="tipo_doc" class="form-control">
							<option selected>Seleccionar</option>
							<?php					

								$query2 = "SELECT id , tipo_doc FROM `tbl_tipos_documentos`";
								$data3 = $db->query($query2);
								while ($val3 = $db -> fetch_array($data3)) 
									{
										Printf ("<option  value=".$val3['id'].">".$val3['tipo_doc']."</option>");
									}  		
							?>
						</select>
					</div>
					
					<div class='form-group col-lg-6'>
						<label for='message-text' class='col-form-label'>N° Documento:</label>
						<input class='form-control' type='number' name ='documento' id='documento' placeholder='Ingrese el numero de documento' required/>
					</div>
					
					<div class='form-group col-lg-6'>
						<label for='recipient-name' class='col-form-label'>Telefono:</label>
						<input class='form-control' type='number' name ='telefono' id='telefono' placeholder='Ingrese el telefono' required/>
					</div>
					
					<div class='form-group col-lg-6'>
						<label for='message-text' class='col-form-label'>Direccion:</label>
						<input type="text" class='form-control'  name='direccion' id='direccion' placeholder='Ingrese la direccion' required>
					</div>
					
					<div class='form-group col-lg-6'>
						<label for='recipient-name' class='col-form-label'>Usuario:</label>
						<input class='form-control' type='text' name ='usuario' id='usuario' placeholder='Ingrese el usuario' required/>
					</div>
					
					<div class='form-group col-lg-6'>
						<label for='message-text' class='col-form-label'>Contraseña:</label>
						<input type="password" class='form-control'  name='contrasenia1' id='contrasenia1' placeholder='Ingrese la contraseña' required>
					</div>
					
					<div class='form-group col-lg-6'>
						<label for='recipient-name' class='col-form-label'>Confirmar Contraseña:</label>
						<input class='form-control' type='password' name ='contrasenia2' id='contrasenia2' placeholder='Ingrese la confirmacion de la contraseña' required/>
					</div>
					
					<div class='form-group col-lg-6'>
						<label for='message-text' class='col-form-label'>Correo:</label>
						<input type="email" class='form-control'  name='correo' id='correo' placeholder='Ingrese el correo' required>
					</div>
		
					<div class='form-group col-lg-6'>
						<label for='recipient-name' class='col-form-label'>Tipo de Contratos:</label>
						
						<select name="tipo_contrato" id="tipo_contrato" class="form-control">
							<option selected>Seleccionar</option>
							<?php					

								$query2 = "SELECT id , tipo_contrato FROM `tbl_tipos_contratos`";
								$data3 = $db->query($query2);
								while ($val3 = $db -> fetch_array($data3)) 
									{
										Printf ("<option  value=".$val3['id'].">".$val3['tipo_contrato']."</option>");
									}  		
							?>
						</select>
					</div>
		
					<div class='form-group col-lg-6'>
						<label for='message-text' class='col-form-label'>Porcentaje de Ganancias:</label>
						<input type="number" class='form-control'  name='porcentaje' id='porcentaje' placeholder='Ingrese el porcentaje'>
					</div>
	 
	 				<div class='form-group col-lg-6'>
						<label for='message-text' class='col-form-label'>Fecha Inicio:</label>
						<input type="date" class='form-control'  name='Finicio' id='Finicio' placeholder='Ingrese la fecha de inicio' required>
					</div>

					<div class='form-group col-lg-6'>
						<label for='message-text' class='col-form-label'>Fecha Fin:</label>
						<input type="date" class='form-control'  name='Ffin' id='Ffin' placeholder='Ingrese la fecha de finalisación'>
					</div>
					<div class='form-group col-lg-6'>
						<label for='message-text' class='col-form-label'>Valor Contrato:</label>
						<input type="number" class='form-control'  name='valor_contrato' id='valor_contrato' placeholder='Ingrese el valor del contrato, ya sea por mes, hora o día'>
					</div>
					
					<div class='form-group col-lg-6'>
						<label for='recipient-name' class='col-form-label'>Cargo:</label>
						
						<select name="cargo" id="cargo" class="form-control">
							<option selected>Seleccionar</option>
							<?php					

								$query2 = "SELECT id , perfiles FROM `tlb_perfiles`";
								$data3 = $db->query($query2);
								while ($val3 = $db -> fetch_array($data3)) 
									{
										Printf ("<option  value=".$val3['id'].">".$val3['perfiles']."</option>");
									}  		
							?>
						</select>
					</div>
					
					 <input type='hidden' name ='tbl' value='usuarios'>        
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
