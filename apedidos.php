<?php
include("header.php");

?>
<div id="content">
	<div class="outer">
		<div class="inner bg-light lter">
		<!--Begin Datatables-->
		<div class="text-center">
		<br>	 
			<a href='agregarpedido.php' class='btn btn-metis-6 btn-lg btn-grad btn-rect'><i class="fa fa-archive"></i>&nbsp;Agregar</a>
			</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="box">
				<header>
					<div class="icons"><i class="fa fa-table"></i></div>
					<h5>Pedidos</h5>
				</header>
					
					
				 <?php 
					tabla_pedidos($db,$id); ?>
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
