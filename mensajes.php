<?php
include("header.php");
?>
<style>
.mytext{
    border:0;padding:10px;background:whitesmoke;
}
.text{
    width:75%;display:flex;flex-direction:column;
}
.text > p:first-of-type{
    width:100%;margin-top:0;margin-bottom:auto;line-height: 13px;font-size: 12px;
}
.text > p:last-of-type{
    width:100%;text-align:right;color:silver;margin-bottom:-7px;margin-top:auto;
}
.text-l{
    float:left;padding-right:10px;
}        
.text-r{
    float:right;padding-left:10px;
}
.avatar{
    display:flex;
    justify-content:center;
    align-items:center;
    width:25%;
    float:left;
    padding-right:10px;
}
.macro{
    margin-top:5px;width:85%;border-radius:5px;padding:5px;display:flex;
}
.msj-rta{
    float:right;background:whitesmoke;
}
.msj{
    float:left;background:white;
}

.ulchat {
    width:100%;
    list-style-type: none;
    padding:18px;
    
    bottom:32px;
    display:flex;
    flex-direction: column;

}	
.msj:before{
    width: 0;
    height: 0;
    content:"";
    top:-5px;
    left:-14px;
    position:relative;
    border-style: solid;
    border-width: 0 13px 13px 0;
    border-color: transparent #ffffff transparent transparent;            
}
.msj-rta:after{
    width: 0;
    height: 0;
    content:"";
    top:-5px;
    left:14px;
    position:relative;
    border-style: solid;
    border-width: 13px 13px 0 0;
    border-color: whitesmoke transparent transparent transparent;           
}  
input:focus{
    outline: none;
}        
::-webkit-input-placeholder { /* Chrome/Opera/Safari */
    color: #d4d4d4;
}
::-moz-placeholder { /* Firefox 19+ */
    color: #d4d4d4;
}
:-ms-input-placeholder { /* IE 10+ */
    color: #d4d4d4;
}
:-moz-placeholder { /* Firefox 18- */
    color: #d4d4d4;
} 

 
</style>
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
					<h5>Mensajes.</h5>
				</header>
					<div class="col-sm-9 col-sm-offset-3 frame">
					<ul class="ulchat" >
						<?php 
						$perfil=$db->HallaValorUnico("SELECT (SELECT b.perfiles FROM tlb_perfiles b where b.id = a.perfil ) FROM tbl_usuarios a where a.id= '$id';");	
						$cn = $db->query("SELECT a.Mensaje, (SELECT concat(b.nombres,' ', b.apellidos) FROM tbl_usuarios b where b.id = a.remitente) , a.fecha  FROM tbl_mensajes  a where a.destino = 'Todos' or a.destino ='$id'  or a.destino ='$perfil' ;");
						while ($datos = $db -> fetch_array($cn)) 
								{
							?>
						<li style="width:100%;">
                        <div class="msj-rta macro">
                            <div class="text text-r">
                                <p><?php echo $datos[0] ; ?></p>
                                <p><small><?php echo $datos[2] ; ?></small></p>
                            </div>
                        <div class="avatar" style="padding:0px 0px 0px 10px !important"><p><?php echo $datos[1] ; ?></p></div>                                
                  </li>
						<?php									
								}
							
						?>				
				 </ul>				
				</div> 				
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
                <label for='message-text' class='col-form-label'>Destino:</label>
                 <select data-placeholder='Seleccione una destinatario' name='destinatario' class='form-control chzn-select' required>
                                    <option value="" label="Seleccione"></option>
					 				<option value="Todos" label="Todos"></option>
					 				<option value="Meseros" label="Meseros"></option>
					 				<option value="Barra" label="Barra"></option>
					 				<option value="Dj" label="Dj"></option>
					 				<option value="Puerta" label="Puerta"></option>
                                    <?php
                                    $restri = $db->query("SELECT id, concat(nombres,' ', apellidos)  FROM tbl_usuarios where estado = 1;");

                                    while ($restricciones = $db->fetch_array($restri)) {

                                        echo "<option value='$restricciones[0]'>$restricciones[1]</option>";           

                                    }

                                    ?>                                                         

                </select>				
                </div> 
                <div class='form-group'>
                    <label for='recipient-name' class='col-form-label'>Mensaje:</label>
                    <input class='form-control' type='text' name ='mensaje' id='mesa' placeholder='Ingrese el mensaje' required/>
					
                </div>
                <input type='hidden' name ='id' value='<?php echo $id ?>'> 
                 <input type='hidden' name ='tbl' value='mensaje'>        
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