<?php
include("header.php");
?>

<style>

	input[type="checkbox"]{
		display: none;
	}
	
	.checkbox label{
		display: inline-block;
		padding: 5px 15px;
		position: relative;
	}
	
	.checkbox label :hover{
		background: rgba(0,116,217,0.1);
	}
	
	[type="checkbox"]:checked + label{
		
		padding: 5px 15px;
		border-radius: 4px;
	}
	
	[type="checkbox"]:checked + .sombra{
		    padding: 5px 15px;
			border-radius: 4px;
			background: #0080ae;
			filter: blur(10px);
			position: absolute;
			width: 80px;
			height: 120px;
	}

</style>

<div id="content">
	<div class="outer">
		<div class="inner bg-light lter">
			<div class="col-lg-4">
				<?php 
				$categorias=$db->query("SELECT id, categoria FROM tbl_categoria_productos");
				while ($cat = $db -> fetch_array($categorias)) 
				{
					?>
				<div class="row">
					<div class="col-lg-12">
					<div class="box">
						<header>
							<h5><?php echo $cat[1]; ?></h5>
							 <div class="toolbar">
							  <nav style="padding: 8px;">
								  <a href="javascript:;" class="btn btn-default btn-xs collapse-box">
									  <i class="fa fa-minus"></i>
								  </a>									 
							  </nav>
							</div>
						</header>
						<div class="body">
							<div class="row">
							<?php $productos= $db->query("SELECT id, nombre, valor_compra, valor_venta, cantidad, imagenes 
														  FROM tbl_productos where categoria = '$cat[0]' ");	
								while ($prod = $db -> fetch_array($productos)) 
									{
									?>
								<div class="col-lg-3">
							<div class="checkbox">
								
                                <input class="uniform" type="checkbox" value="<?php echo $prod['nombre']  ?>" id="checkbox<?php echo $prod['id']  ?>" onClick="validaCheckbox(<?php echo $prod['id'] ?>,'<?php echo $prod['nombre']  ?>',<?php echo $prod['valor_venta'] ?>)" >
								<div class="sombra"></div>
								<label class="checkbox" for="checkbox<?php echo $prod['id']  ?>" style="width: 100%; height: 120px;">
                                    <img src='<?php echo $prod['imagenes']  ?>' height="100" style="position: absolute; left: 0px">
                                </label>
                            </div>
									</div>
										
							<?php
									} 
							?>							
							
							</div>
						</div>
						
					</div>
					</div>	
				</div>
				<?php					
				}
				?>			
			</div>
			<div class="col-lg-8">
			<div class="row">
			<div class="col-lg-12">
					<div class="box">
						<header>
							<h5>Crear Combo</h5>
							<div class="toolbar">
							  <nav style="padding: 8px;">
								  <a href="javascript:;" class="btn btn-default btn-xs collapse-box">
									  <i class="fa fa-minus"></i>
								  </a>									 
							  </nav>
							</div>
						</header>
						<div class="body">
							 <form action='agregar.php' method='post' enctype='multipart/form-data' >

								<div class="form-group">
									<label for="Nombre" class="control-label col-lg-4">Nombre del Combo</label>

									<div class="col-lg-8">
										<input type="text" id="Nombre" name="nombre" placeholder="Nombre del combo" class="form-control"><br>
									</div>
								</div>
								<!-- /.form-group -->

								<div class="form-group">
									<label for="valor" class="control-label col-lg-4">Valor de Combo</label>

									<div class="col-lg-8">
										<input class="form-control" type="number" id="valor" name="valor" min="1000" placeholder="Valor del Combo"><br>
									</div>
								</div>
								<!-- /.form-group -->
								
								<div class="form-group">
									<label for="autosize" class="control-label col-lg-4">Descripcion </label>

									<div class="col-lg-8">
										<textarea id="autosize" class="form-control" name="descripcion" placeholder="Ingrese una descripción"></textarea>
										<br>
									</div>
									
								</div>
								 <div class='form-group'>
									<label for='message-text' class='col-form-label'>Imagen:</label>
									<input class='form-control' type='file' name ='imagen' id='imagen' required/>
								</div>
								 
								 <div class="span9 row" id="contenido"> 
									 
								 </div>
								
								
								 <div class="form-group row">
									<div class="col-lg-6">
										<input type='hidden' name ='tbl' value='agregarcombos'>										
									</div>
										 <button type='button' class='btn btn-danger btn-grad' data-dismiss='modal'>Cancelar</button>
									 	<a href="vercombos.php" class="btn btn-info">Ver Combos</a>
										<button type='submit' class='btn btn-success btn-grad' id='btnenviar' name='btnenviar'>Enviar</button> 
									 
								 </div>
								 </div>
							</form>							
						</div>
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>
</div>
<script>
var contador = 0;
function validaCheckbox(id,nombre,valor)
{
  var checked = checkbox1.checked;
  
  if( $('#checkbox'+id).prop('checked') ) { 
	  
	  $('#contenido').append('<div class="form-group" id="row_'+id+'"><label for="autosize" class="control-label col-lg-4">'+nombre+' precio unidad:'+valor+'</label><div class="col-lg-8"><input class="form-control" type="number" id="producto" min="1" name="producto_'+id+'" placeholder="Cantidad"><input type="hidden" name ="idproducto_'+id+'" value="'+id+'"><br></div></div>');
	}else{		
		$("#row_"+id+"").remove();
	}
}
	
</script>
<?php
include("footer.php");
?>
