<?php
include("header.php");
$pagina = "mesa";
?>
<div id="content">
	<div class="outer">
		<div class="inner bg-light lter">
		<!--Begin Datatables
		<div class="text-center">-->
			<h3 style="text-align: center">Mesas</h3>
		<br>			
			<!--<button type="button" class="btn btn-metis-6 btn-lg btn-grad btn-rect" data-toggle='modal' data-target='#add' data-whatever='@mdo'>
            <i class="fa fa-archive"></i>&nbsp; Agregar</button>  
			
			</div>-->
		<div class="row">
			<form action="mesasdisponibles.php" method="post">
				<div class="row col-lg-12">
					<div class="col-lg-3"></div>
					<div class="col-lg-4">
						<label for="" class="">Zona</label>
						<select name="zona" required class="form-control">
							<option selected>Seleccionar</option>
						<?php 
						$query2 = $db->query("SELECT id, zona FROM tbl_zonas");
						while($UserDatos = mysqli_fetch_array($query2)){
							echo "<option value='".$UserDatos['id']."'>".$UserDatos['zona']."</option>";
						}
						?>

						</select>
					</div><br>
					<button class="btn btn-metis-6 btn-grad btn-rect col-lg-2" type="submit" style="position: absolute; top: 23px;">Buscar</button>
				</div><br><br><br><br>
					
			</form><br>
			
			<div class="col-lg-12">
				
					<br>
			<?php
			if(!empty($_POST)){
				if($_POST['zona'] == "Seleccionar"){
					$filtro = "";
				}else{
					$filtro = "WHERE zona = '".$_POST['zona']."'";
				}
			}else{
				$filtro = "";
			}
				//echo $filtro;
			$query2 = $db->query("SELECT id, mesa, (SELECT zona FROM tbl_zonas WHERE id = a.zona) AS zonas, cant_personas FROM tlb_mesas AS a $filtro");
			while($UserDatos = mysqli_fetch_array($query2)){
				$mesaestado = $db->HallaValorUnico("SELECT estado FROM tlb_mesas WHERE id = '".$UserDatos['id']."'");
				if($mesaestado == "Libre"){
					$state = "libre";
				}else{
					$state = "ocupado";
				}
			?>
			<center>
				<div class="card col-lg-4">
				  <img class="card-img-top" src="<?php CargaImagen($db, $state, $pagina); ?>" alt="Card image cap" height="100">
				  <div class="card-body">
					<h5 class="card-title"><?php echo $UserDatos['mesa'];?></h5>
					<p class="card-text">Zona: <?php echo $UserDatos['zonas'];?></p>
					<p class="card-text">Cantidad Personas: <?php echo $UserDatos['cant_personas'];?></p>
				  </div>
				  <div class="row">
						<form action="editar.php" method="post">
							<input type='hidden' name ='tbl' value='mesaL'>
							<input type='hidden' name ='id' value='<?php echo $UserDatos['id'];?>'>
							<button class="btn btn-success col-lg-5" type="submit">Libre</button>
						</form>
						<form action="editar.php" method="post">
							<input type='hidden' name ='tbl' value='mesaO'>
							<input type='hidden' name ='id' value='<?php echo $UserDatos['id'];?>'>
							<input type='hidden' name ='mesa' value='<?php echo $UserDatos['mesa'];?>'>
							<input type='hidden' name ='cant_personas' value='<?php echo $UserDatos['cant_personas'];?>'>
							<button class="btn btn-danger col-lg-5" type="submit">Ocupar</button>
						</form>
						</div>
					  </li>
				</div>
			</center>	
			<!--<div class="col-sm-3 row" style="border: solid #000000">
				<br>
  				<ul class="list-unstyled" rel="bg-">
				  	<li>
						<img src="imgpage/Pruebas2-2021-12-22 12:47:48-.jpg" alt="" height="100">
					</li><br>
					<li>
						<div class="col-lg-6">Estado: </div>
					</li><br>
				  	<li>
						<div class="col-lg-6">Estado: </div>
						<div class="col-lg-6">Activa</div>
					</li><br>
					<li>
					  <div class="col-lg-6">
						  <button type='button' class='btn btn-success btn-round btn-grad' data-toggle='modal' data-target='#mde_".$row[0]."' data-whatever='@mdo'>Pedido</button>
					  </div>
					  <div class="col-lg-6">
						  <button type='button' class='btn btn-danger btn-round btn-grad' data-toggle='modal' data-target='#mde_".$row[0]."' data-whatever='@mdo'>Cobrar</button>
				<br>
					  </div>
				<br>
					</li>
				<br>
				</ul>
	  		</div>-->
				 <?php }//tabla_reservas($db); ?>
			</div>
		</div><br><br>
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
