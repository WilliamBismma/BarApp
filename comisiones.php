<?php
include("header.php");

?>
<div id="content">
	<div class="outer">
		<div class="inner bg-light lter">
		<!--Begin Datatables-->
			<?php if(empty($_GET)){?>
		<div class="text-center">
		<br>	
			<hr>
			<button type='button' class='btn btn-success btn-lg btn-grad btn-rect' data-toggle='modal' data-target='#calcular' data-whatever='@mdo'><i class="fa fa-usd"></i>&nbsp;Calcular Comisiones</button>
					<div class='modal fade' id='calcular' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
					<div class='modal-dialog' role='document'>
					  <div class='modal-content bg-dark text-white'>
						<div class='modal-header'>
						  <h3 class='modal-title text-left' id='exampleModalLabel'>Calcular Comisiones</h3>                    
						</div> 
						<form action='calularcomisiones.php' method='post' enctype='multipart/form-data'>
						<div class='modal-body'>          
						<label></label>     
							<div class='alert alert-danger' role='alert'>
								¿Esta seguro de realizar esta actividad? <br> esta actividad daría por cerrado el bar.
							</div>				 
						</div>                  
						<div class='modal-footer'>
						  <button type='button' class='btn btn-danger btn-grad' data-dismiss='modal'>No</button>
						  <button type='submit' class='btn btn-success btn-grad' id='btnenviar' name='btnenviar'>Si</button>
						</div>
						</form>
					  </div>
					</div>
					</div>
			</div>
			<?PHP } ?>
		<div class="row">
			<div class="col-lg-12">
				<div class="box">
				<header>
					<div class="icons"><i class="fa fa-table"></i></div>
					<h5>Pedidos</h5>
				</header>
					<?php if(!empty($_GET)){?>
			<form action="lib/excelcomi.php" method="post">
				<div class="row col-lg-12">
					<div class="col-lg-4">
						<label for="" class="">Fecha Inicial</label>
						<input type="date" class="form-control" name="fecha1">
					</div>
					<div class="col-lg-4">
						<label for="" class="">Fecha Final</label>
						<input type="date" class="form-control" name="fecha2">
					</div>
					<div class="col-lg-4">
						<label for="" class="">Usuario</label>
						<select name="tipo_doc" id="tipo_doc" class="form-control">
							<option selected>Seleccionar</option>
							<?php					

								$query2 = "SELECT id , nombres, apellidos FROM `tbl_usuarios`";
								$data3 = $db->query($query2);
								while ($val3 = $db -> fetch_array($data3)) 
									{
										Printf ("<option  value=".$val3['nombres'].">".$val3['nombres']." ".$val3['apellidos']."</option>");
									}  		
							?>
						</select>
					</div><br>
					
				</div><br><br><br><br><br>
				<center>
					<button class="btn btn-metis-6 btn-grad btn-rect col-lg-3" type="submit" style="position: absolute; left: 30%">Generar Reporte</button><br><br><br>	
				</center>
			</form><br><br><br>
					
				 <?php 
					}else{tabla_comisiones($db); }?>
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
                    <label for='recipient-name' class='col-form-label'>Mesa:</label>
					<select name='mesa' id='tipo_doc' class='form-control'>
					<option selected></option>
					<?php 
					$mesasdis= $db->Query("SELECT id, mesa, cant_personas FROM tlb_mesas where id not in (SELECT  mesa FROM tbl_pedidos where estado =1) ;");								
					while ($mesas = $db -> fetch_array($mesasdis)) 
					{
						echo "<option  value=".$mesas['id'].">".$mesas['mesa']." (Cantidad de puestos ".$mesas['cant_personas'].")</option>";
					}						
					?>					
					</select>
                    
                </div>
				<?php 
				$perfil=$db->HallaValorUnico("SELECT  perfil FROM tbl_usuarios where id = $id;");
				if($perfil==1){
					?>
					<div class='form-group'>
                    <label for='recipient-name' class='col-form-label'>Meseros:</label>
					<select name='user' id='tipo_doc' class='form-control' required>
					<option selected></option>
					<?php 
					$user= $db->Query("SELECT id,  concat(nombres,' ',  apellidos) as 'Mesero' FROM tbl_usuarios where perfil in (2,3,4);");								
					while ($usr = $db -> fetch_array($user)) 
					{
						echo "<option  value=".$usr[0].">".$usr[1]."</option>";
					}						
					?>					
					</select>
                    
                </div> 
					<?php
				}else{
					?>
				<input type='hidden' name ='user' value='<?php echo $id ?>'>
				<?php
				}?>             
                 <input type='hidden' name ='tbl' value='pedidos'>        
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