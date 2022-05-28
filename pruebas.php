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

								<div class='form-group'>
										<label for='recipient-name' class='col-form-label'>Mesa:</label>
										<select name='mesa' id='tipo_doc' class='form-control'>
										<option selected>Sin Mesa</option>
										<?php 
										$mesasdis= $db->Query("SELECT id, mesa, cant_personas FROM tlb_mesas;");								
										while ($mesas = $db -> fetch_array($mesasdis)) 
										{
											echo "<option  value=".$mesas['id'].">".$mesas['mesa']." (Cantidad de puestos ".$mesas['cant_personas'].")</option>";
										}						
										?>					
										</select>

									</div>
								<!-- /.form-group -->
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
								<!-- /.form-group -->		
								 <div class="span9 row" id="contenido"> 
									 
								 </div>
									
								 <h2 id="total" style="text-align: center">Valor Total $0.0</h2>
								
								 <div class="form-group row">
									<div class="col-lg-6">
										<input type='hidden' name ='tbl' value='agregarcombos'>										
									</div>
										 <button type='button' class='btn btn-danger btn-grad' data-dismiss='modal'>Cancelar</button>
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
	  
	  $('#contenido').append('<div class="form-group" id="row_'+id+'"><label for="autosize" class="control-label col-lg-3">'+nombre+'  Cantidad:</label><div class="col-lg-3"><input class="form-control" type="number" id="producto" min="1" value="1" name="producto_'+id+'" placeholder="Cantidad" onchange="myFunction(this.value,'+id+','+valor+')"></div><label for="autosize" class="control-label col-lg-2">Valor:</label><div class="col-lg-3"><input class="form-control" type="number" id="valor'+id+'" min="1" value="'+valor+'" name="valor'+id+'"  placeholder="Cantidad" readonly><input type="hidden" name ="idproducto_'+id+'" value="'+id+'"><br></div></div>');
	  var pedidos = [1,id,valor];
	  localStorage.setItem('pedidos'+id,JSON.stringify(pedidos));
	  var total= 0;
		for(var i=0, len=localStorage.length; i<len; i++) {
			var key = localStorage.key(i);
			var subtoral = localStorage.getItem(key);
			 subtoral =JSON.parse(subtoral);
			var subtotalvalor = subtoral[2];
			total=total+subtotalvalor;		
			document.getElementById("total").innerHTML = "Valor Total: $"+new Intl.NumberFormat().format(total);
		}
	}else{		
		$("#row_"+id+"").remove();
		localStorage.removeItem('pedidos'+id);
		var total= 0;
		for(var i=0, len=localStorage.length; i<len; i++) {
			var key = localStorage.key(i);
			var subtoral = localStorage.getItem(key);
			 subtoral =JSON.parse(subtoral);
			var subtotalvalor = subtoral[2];
			total=total+subtotalvalor;	
			document.getElementById("total").innerHTML = "Valor Total: $"+new Intl.NumberFormat().format(total);
		}
	}
}
function myFunction(val,id,valor) {
    //alert("el valor cambia por: " + val*valor + "del producto"+ id);
	var valorfina = val*valor;
	document.getElementById("valor"+id).value=valorfina; 
	var pedidos = [val,id,valorfina];
	localStorage.setItem('pedidos'+id,JSON.stringify(pedidos));
	var local = localStorage.length;	
	var total= 0;
	for(var i=0, len=localStorage.length; i<len; i++) {
		var key = localStorage.key(i);
		var subtoral = localStorage.getItem(key);
		 subtoral =JSON.parse(subtoral);
		var subtotalvalor = subtoral[2];
		total=total+subtotalvalor;
		
		document.getElementById("total").innerHTML = "Valor Total: $"+new Intl.NumberFormat().format(total);
	}
	
}
localStorage.clear();
	
</script>
<?php
include("footer.php");
?>
