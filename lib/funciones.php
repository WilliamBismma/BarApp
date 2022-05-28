<?php 

function Enc($action, $string) {
    $output = false; 
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'G30syefbko';
    $secret_iv = 'AfHggGh78o03Rg1'; 
    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
 
    if( $action == 'enc' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
        
	}
    else if( $action == 'dec' ){
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
   
	}
 
    return $output;
}

function tabla_zonas($db) {

    $consulta="SELECT id as 'ID', zona as 'Zona', descripcion as 'Descripción', '' as 'Herramientas' FROM tbl_zonas;";   

    //creamos el arreglo que contiene el nombre de los campos

    $Campos=array();

    $val= $db->query($consulta);

    //$val = mysqli_query($this->conexion,$consulta);

    //contamos las columnas

    $NumCampos =mysqli_num_fields($val);

     /* Obtener la información del campo de cada columna */

     while ($finfo = $val->fetch_field()) {

         $Campos[]= $finfo->name;        

     }

     //se inicia la tabla (aquí se pueden agregar diseños)   

     



     echo "<div id='collapse4' class='body'>";

     echo "<table id='DataTablesClientes' class='table table-bordered table-condensed table-hover table-striped'>";

     //se crea el encabezado de la tabla

     echo "<thead>";

     echo "<tr>";

     for ($i=0;$i<$NumCampos;$i++){

         Printf ("<th scope='col'><center>%s</center></th>",$Campos[$i]);

     } 

     echo "</tr>";

     echo "</thead>";

     echo "<tbody>";

     echo "<tr>";



     //SE CREA 

       while($row = mysqli_fetch_array($val))

    {	

   for ($i=0;$i<$NumCampos;$i++)

         {         
          if($i==3 ){
            $queryint = $db->query("SELECT zona, descripcion FROM tbl_zonas where id = '".$row[0]."';");
            $data = $db -> fetch_array($queryint);
            $resp = "<td><center><button type='button' class='btn btn-primary btn-round btn-grad ' data-toggle='modal' data-target='#md_".$row[0]."' data-whatever='@mdo'><i class='fa fa-edit'></i></button>              
                    <div class='modal fade' id='md_".$row[0]."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                    <div class='modal-dialog' role='document'>
                    <div class='modal-content bg-dark text-white'>
                        <div class='modal-header'>
                        <h3 class='modal-title text-left' id='exampleModalLabel'>Editar</h3>                    
                        </div> 
                        <form action='editar.php' method='post' enctype='multipart/form-data'>
                        <div class='modal-body'>          
                        <label></label>     
                            <div class='form-group'>
                                <label for='recipient-name' class='col-form-label'>Nombre:</label>
                                <input class='form-control' type='text' name ='zona' id='zona' placeholder='Ingrese una Zona' value='".$data[0]."' />
                            </div>
                            <div class='form-group'>
                            <label for='message-text' class='col-form-label'>Descripción:</label>
                            <textarea class='form-control'  name='descripcion' id='descripcion' placeholder='Ingrese Descripción' required>".$data[1]."</textarea>
                            </div> 
                           
                            <input type='hidden' name='id' value='".$row[0]."'>
                            <input type='hidden' name ='tbl' value='zonas'>        
                        </div>                  
                        <div class='modal-footer'>
                        <button type='button' class='btn btn-danger btn-grad' data-dismiss='modal'>Cancelar</button>
                        <button type='submit' class='btn btn-success btn-grad' id='btnenviar' name='btnenviar'>Enviar</button>
                        </div>
                        </form>
                    </div>
                    </div>
                    </div>
					
					 <button type='button' class='btn btn-danger btn-round btn-grad' data-toggle='modal' data-target='#mde_".$row[0]."' data-whatever='@mdo'><i class='fa fa-trash'></i></button>
					<div class='modal fade' id='mde_".$row[0]."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
					<div class='modal-dialog' role='document'>
					  <div class='modal-content bg-dark text-white'>
						<div class='modal-header'>
						  <h3 class='modal-title text-left' id='exampleModalLabel'>Eliminar</h3>                    
						</div> 
						<form action='eliminar.php' method='post' enctype='multipart/form-data'>
						<div class='modal-body'>          
						<label></label>     
							<div class='alert alert-danger' role='alert'>
								¿Esta seguro de eliminar esta actividad?.
							</div>     
							<input type='hidden' name='id' value='".$row[0]."'>
							<input type='hidden' name ='tbl' value='zonas'>        
						</div>                  
						<div class='modal-footer'>
						  <button type='button' class='btn btn-danger btn-grad' data-dismiss='modal'>No</button>
						  <button type='submit' class='btn btn-success btn-grad' id='btnenviar' name='btnenviar'>Si</button>
						</div>
						</form>
					  </div>
					</div>
					</div>		</center>			
                    </td>
                    ";     

             echo $resp;



           }else{  



            Printf ("<td><center>%s</center></td>",$row[$i]);          



        }   

                

 

         }      

        

     echo "</tr>";

    }

     echo "</tbody>";

     echo "</table>";    

     echo "</div>";

}

function tabla_cajamenor($db) {

    $consulta="SELECT id as 'ID', producto as 'Producto', (SELECT tipo_producto FROM tbl_tipo_producto WHERE id = a.tipo_producto) as 'Tipo Producto', valor AS 'Valor', fecha AS 'Fecha', '' as 'Herramientas' FROM tbl_caja_menor as a;";   

    //creamos el arreglo que contiene el nombre de los campos

    $Campos=array();

    $val= $db->query($consulta);

    //$val = mysqli_query($this->conexion,$consulta);

    //contamos las columnas

    $NumCampos =mysqli_num_fields($val);

     /* Obtener la información del campo de cada columna */

     while ($finfo = $val->fetch_field()) {

         $Campos[]= $finfo->name;        

     }

     //se inicia la tabla (aquí se pueden agregar diseños)   

     



     echo "<div id='collapse4' class='body'>";

     echo "<table id='DataTablesClientes' class='table table-bordered table-condensed table-hover table-striped'>";

     //se crea el encabezado de la tabla

     echo "<thead>";

     echo "<tr>";

     for ($i=0;$i<$NumCampos;$i++){

         Printf ("<th scope='col'><center>%s</center></th>",$Campos[$i]);

     } 

     echo "</tr>";

     echo "</thead>";

     echo "<tbody>";

     echo "<tr>";



     //SE CREA 

       while($row = mysqli_fetch_array($val))

    {	

   for ($i=0;$i<$NumCampos;$i++)

         {         
          if($i==5 ){
            $queryint = $db->query("SELECT producto as 'Producto', (SELECT tipo_producto FROM tbl_tipo_producto WHERE id = a.tipo_producto) as 'Tipo Producto', valor AS 'Valor', fecha AS 'Fecha', tipo_producto FROM tbl_caja_menor as a where id = '".$row[0]."';");
			   	
			$optiontp = "";
			$query2 = "SELECT id , tipo_producto FROM tbl_tipo_producto";
			$data3 = $db->query($query2);
			while ($val3 = $db -> fetch_array($data3)) 
			{
				$optiontp = $optiontp."<option  value=".$val3['id'].">".$val3['tipo_producto']."</option>";
			}
			  
            $data = $db -> fetch_array($queryint);
            $resp = "<td><center><button type='button' class='btn btn-primary btn-round btn-grad ' data-toggle='modal' data-target='#md_".$row[0]."' data-whatever='@mdo'><i class='fa fa-edit'></i></button>              
                    <div class='modal fade' id='md_".$row[0]."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
						<div class='modal-dialog' role='document'>
							<div class='modal-content bg-dark text-white'>
								<div class='modal-header'>
								<h3 class='modal-title text-left' id='exampleModalLabel'>Editar</h3>                    
								</div> 
								<form action='editar.php' method='post' enctype='multipart/form-data'>
								<div class='modal-body'>          
									<label></label>     
									<div class='form-group'>
										<label for='recipient-name' class='col-form-label'>Producto:</label><br>
										<input class='form-control' type='text' name ='producto' id='producto' placeholder='Ingrese el nombre del producto comprado' value='".$data[0]."' required/>
									</div><br>

									<div class='form-group '>
										<label for='recipient-name' class='col-form-label'>Tipo de producto:</label><br>

										<select name='tipo_producto' id='tipo_producto' class='form-control'>
											<option value='".$data[4]."'> ".$data[1]." </option>
											$optiontp
										</select>
									</div><br>

									<div class='form-group '>
										<label for='recipient-name' class='col-form-label'>Valor:</label><br>
										<input class='form-control' type='number' name ='valor' id='valor' placeholder='Ingrese el valor del producto comprado' value='".$data[2]."' required/>
									</div><br>

									<div class='form-group'>
										<label for='recipient-name' class='col-form-label'>Fecha de la compra:</label><br>
										<input class='form-control' type='date' name ='fecha' id='fecha' required value='".$data[3]."'/>
									</div><br>

									<input type='hidden' name='id' value='".$row[0]."'>
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
					
					 <button type='button' class='btn btn-danger btn-round btn-grad' data-toggle='modal' data-target='#mde_".$row[0]."' data-whatever='@mdo'><i class='fa fa-trash'></i></button>
					<div class='modal fade' id='mde_".$row[0]."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
					<div class='modal-dialog' role='document'>
					  <div class='modal-content bg-dark text-white'>
						<div class='modal-header'>
						  <h3 class='modal-title text-left' id='exampleModalLabel'>Eliminar</h3>                    
						</div> 
						<form action='eliminar.php' method='post' enctype='multipart/form-data'>
						<div class='modal-body'>          
						<label></label>     
							<div class='alert alert-danger' role='alert'>
								¿Esta seguro de eliminar esta actividad?.
							</div>     
							<input type='hidden' name='id' value='".$row[0]."'>
							<input type='hidden' name ='tbl' value='cajamenor'>        
						</div>                  
						<div class='modal-footer'>
						  <button type='button' class='btn btn-danger btn-grad' data-dismiss='modal'>No</button>
						  <button type='submit' class='btn btn-success btn-grad' id='btnenviar' name='btnenviar'>Si</button>
						</div>
						</form>
					  </div>
					</div>
					</div>		</center>			
                    </td>
                    ";     

             echo $resp;



           }else{  



            Printf ("<td><center>%s</center></td>",$row[$i]);          



        }   

                

 

         }      

        

     echo "</tr>";

    }

     echo "</tbody>";

     echo "</table>";    

     echo "</div>";

}

function tabla_tproductos($db) {

    $consulta="SELECT id as 'ID', tipo_producto as 'Tipo de Producto', '' as 'Herramientas' FROM tbl_tipo_producto;";   

    //creamos el arreglo que contiene el nombre de los campos

    $Campos=array();

    $val= $db->query($consulta);

    //$val = mysqli_query($this->conexion,$consulta);

    //contamos las columnas

    $NumCampos =mysqli_num_fields($val);

     /* Obtener la información del campo de cada columna */

     while ($finfo = $val->fetch_field()) {

         $Campos[]= $finfo->name;        

     }

     //se inicia la tabla (aquí se pueden agregar diseños)   

     



     echo "<div id='collapse4' class='body'>";

     echo "<table id='DataTablesClientes' class='table table-bordered table-condensed table-hover table-striped'>";

     //se crea el encabezado de la tabla

     echo "<thead>";

     echo "<tr>";

     for ($i=0;$i<$NumCampos;$i++){

         Printf ("<th scope='col'><center>%s</center></th>",$Campos[$i]);

     } 

     echo "</tr>";

     echo "</thead>";

     echo "<tbody>";

     echo "<tr>";



     //SE CREA 

       while($row = mysqli_fetch_array($val))

    {	

   for ($i=0;$i<$NumCampos;$i++)

         {         
          if($i==2 ){
            $queryint = $db->query("SELECT id, tipo_producto FROM tbl_tipo_producto where id = '".$row[0]."';");
            $data = $db -> fetch_array($queryint);
            $resp = "<td><center><button type='button' class='btn btn-primary btn-round btn-grad ' data-toggle='modal' data-target='#md_".$row[0]."' data-whatever='@mdo'><i class='fa fa-edit'></i></button>              
                    <div class='modal fade' id='md_".$row[0]."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                    <div class='modal-dialog' role='document'>
                    <div class='modal-content bg-dark text-white'>
                        <div class='modal-header'>
                        <h3 class='modal-title text-left' id='exampleModalLabel'>Editar</h3>                    
                        </div> 
                        <form action='editar.php' method='post' enctype='multipart/form-data'>
                        <div class='modal-body'>          
                        <label></label>     
							<div class='form-group'>
								<label for='recipient-name' class='col-form-label'>Tipo de Producto:</label>
								<input class='form-control' type='text' name ='Nproducto' id='Nproducto' placeholder='Ingrese el tipo de producto' value='".$data[1]."' required/>
							</div> 
                           
                            <input type='hidden' name='id' value='".$row[0]."'>
                            <input type='hidden' name ='tbl' value='tproductos'>        
                        </div>                  
                        <div class='modal-footer'>
                        <button type='button' class='btn btn-danger btn-grad' data-dismiss='modal'>Cancelar</button>
                        <button type='submit' class='btn btn-success btn-grad' id='btnenviar' name='btnenviar'>Enviar</button>
                        </div>
                        </form>
                    </div>
                    </div>
                    </div>
					
					 <button type='button' class='btn btn-danger btn-round btn-grad' data-toggle='modal' data-target='#mde_".$row[0]."' data-whatever='@mdo'><i class='fa fa-trash'></i></button>
					<div class='modal fade' id='mde_".$row[0]."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
					<div class='modal-dialog' role='document'>
					  <div class='modal-content bg-dark text-white'>
						<div class='modal-header'>
						  <h3 class='modal-title text-left' id='exampleModalLabel'>Eliminar</h3>                    
						</div> 
						<form action='eliminar.php' method='post' enctype='multipart/form-data'>
						<div class='modal-body'>          
						<label></label>     
							<div class='alert alert-danger' role='alert'>
								¿Esta seguro de eliminar esta actividad?.
							</div>     
							<input type='hidden' name='id' value='".$row[0]."'>
							<input type='hidden' name ='tbl' value='tproductos'>        
						</div>                  
						<div class='modal-footer'>
						  <button type='button' class='btn btn-danger btn-grad' data-dismiss='modal'>No</button>
						  <button type='submit' class='btn btn-success btn-grad' id='btnenviar' name='btnenviar'>Si</button>
						</div>
						</form>
					  </div>
					</div>
					</div>		</center>			
                    </td>
                    ";     

             echo $resp;



           }else{  



            Printf ("<td><center>%s</center></td>",$row[$i]);          



        }   

                

 

         }      

        

     echo "</tr>";

    }

     echo "</tbody>";

     echo "</table>";    

     echo "</div>";

}

function tabla_tpedidos($db) {

    $consulta="SELECT a.id as 'Id',(SELECT  b.mesa FROM tlb_mesas b where b.id =a.mesa)  as 'Mesa'
	, (SELECT concat(c.nombres,' ' ,c.apellidos) FROM tbl_usuarios c where c.id = a.asesor) as 'Asesor', (SELECT d.estado FROM tbl_estados_pedidos d where d.id =a.estado) as 'Estado', a.subtotal  as 'Sub Total', fecha AS Fecha
		FROM tbl_pedidos a;";   

    //creamos el arreglo que contiene el nombre de los campos

    $Campos=array();

    $val= $db->query($consulta);

    //$val = mysqli_query($this->conexion,$consulta);

    //contamos las columnas

    $NumCampos =mysqli_num_fields($val);

     /* Obtener la información del campo de cada columna */

     while ($finfo = $val->fetch_field()) {

         $Campos[]= $finfo->name;        

     }

     //se inicia la tabla (aquí se pueden agregar diseños)   

     



     echo "<div id='collapse4' class='body'>";

     echo "<table id='DataTables2' class='table table-bordered table-condensed table-hover table-striped'>";

     //se crea el encabezado de la tabla

     echo "<thead>";

     echo "<tr>";

     for ($i=0;$i<$NumCampos;$i++){

         Printf ("<th scope='col'><center>%s</center></th>",$Campos[$i]);

     } 

     echo "</tr>";

     echo "</thead>";

     echo "<tbody>";

     echo "<tr>";



     //SE CREA 

       while($row = mysqli_fetch_array($val))

    {	

   for ($i=0;$i<$NumCampos;$i++)

         {    

            Printf ("<td><center>%s</center></td>",$row[$i]);            

         }      

        

     echo "</tr>";

    }

     echo "</tbody>";

     echo "</table>";    

     echo "</div>";

}

function tabla_canciones($db,$val) {
	$ubi = $val;
	if($ubi == 2){
		$limit = "LIMIT 5";
	}
    $consulta="SELECT id as 'ID', cancion as 'Canción', artista as 'Artista', '' as 'Herramientas' FROM tbl_canciones WHERE estado = 1 $limit;";

    //creamos el arreglo que contiene el nombre de los campos

    $Campos=array();

    $val= $db->query($consulta);

    //$val = mysqli_query($this->conexion,$consulta);

    //contamos las columnas

    $NumCampos =mysqli_num_fields($val);

     /* Obtener la información del campo de cada columna */

     while ($finfo = $val->fetch_field()) {

         $Campos[]= $finfo->name;        

     }

     //se inicia la tabla (aquí se pueden agregar diseños)   

     



     echo "<div id='collapse4' class='body'>";

     echo "<table id='DataTables2' class='table table-bordered table-condensed table-hover table-striped'>";

     //se crea el encabezado de la tabla

     echo "<thead>";

     echo "<tr>";

     for ($i=0;$i<$NumCampos;$i++){

         Printf ("<th scope='col'><center>%s</center></th>",$Campos[$i]);

     } 

     echo "</tr>";

     echo "</thead>";

     echo "<tbody>";

     echo "<tr>";



     //SE CREA 

       while($row = mysqli_fetch_array($val))

    {	

   for ($i=0;$i<$NumCampos;$i++)

         {         
          if($i==3 ){
            $queryint = $db->query("SELECT zona, descripcion FROM tbl_zonas where id = '".$row[0]."';");
            $data = $db -> fetch_array($queryint);
            $resp = "
			<td><center>
				<form method='POST' action='editar.php'>
					<input type='hidden' name='id' value='".$row[0]."'>
					<input type='hidden' name='ubi' value='".$ubi."'>
					<input type='hidden' name ='tbl' value='canciones'>  
					<button type='submit' class='btn btn-primary btn-round btn-grad ' title='Colocada'><i class='fa fa-eye'></i></button>
				</form>
			</td>
                    ";     

             echo $resp;



           }else{  



            Printf ("<td><center>%s</center></td>",$row[$i]);          



        }   

                

 

         }      

        

     echo "</tr>";

    }

     echo "</tbody>";

     echo "</table>";    

     echo "</div>";

}

function tabla_reservas($db) {

    $consulta="SELECT id as 'ID', nombre as 'Nombre', cedula as 'Cedula', fecha AS 'Fecha', cant_personas AS 'N° Personas', observaciones AS 'Observaciones', '' as 'Herramientas' FROM tbl_reservas;";   

    //creamos el arreglo que contiene el nombre de los campos

    $Campos=array();

    $val= $db->query($consulta);

    //$val = mysqli_query($this->conexion,$consulta);

    //contamos las columnas

    $NumCampos =mysqli_num_fields($val);

     /* Obtener la información del campo de cada columna */

     while ($finfo = $val->fetch_field()) {

         $Campos[]= $finfo->name;        

     }

     //se inicia la tabla (aquí se pueden agregar diseños)   

     



     echo "<div id='collapse4' class='body'>";

     echo "<table id='DataTablesClientes' class='table table-bordered table-condensed table-hover table-striped'>";

     //se crea el encabezado de la tabla

     echo "<thead>";

     echo "<tr>";

     for ($i=0;$i<$NumCampos;$i++){

         Printf ("<th scope='col'><center>%s</center></th>",$Campos[$i]);

     } 

     echo "</tr>";

     echo "</thead>";

     echo "<tbody>";

     echo "<tr>";



     //SE CREA 

       while($row = mysqli_fetch_array($val))

    {	

   for ($i=0;$i<$NumCampos;$i++)

         {         
          if($i==6){
            $queryint = $db->query("SELECT nombre as 'Nombre', cedula as 'Cedula', fecha AS 'Fecha', cant_personas AS 'N° Personas', observaciones AS 'Observaciones', estado FROM tbl_reservas where id = '".$row[0]."';");
            $data = $db -> fetch_array($queryint);
            $resp = "<td><center><button type='button' class='btn btn-primary btn-round btn-grad ' data-toggle='modal' data-target='#md_".$row[0]."' data-whatever='@mdo'><i class='fa fa-edit'></i></button>              
                    <div class='modal fade' id='md_".$row[0]."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                    <div class='modal-dialog' role='document'>
                    <div class='modal-content bg-dark text-white'>
                        <div class='modal-header'>
                        <h3 class='modal-title text-left' id='exampleModalLabel'>Editar</h3>                    
                        </div> 
                        <form action='editar.php' method='post' enctype='multipart/form-data'>
                        <div class='modal-body'>          
                        <label></label>     
                            <div class='form-group'>
								<label for='recipient-name' class='col-form-label'>Nombre:</label><br>
								<input class='form-control' type='text' name ='nombre' id='nombre' placeholder='Ingrese el nombre del usuario' value='".$data[0]."' required/>
							</div><br>
							<div class='form-group'>
								<label for='recipient-name' class='col-form-label'>Cedula:</label><br>
								<input class='form-control' type='number' name ='cedula' id='cedula' placeholder='Ingrese el numero de cedula' value='".$data[1]."' required/>
							</div><br>
							<div class='form-group'>
								<label for='recipient-name' class='col-form-label'>Fecha y Hora:</label><br>
								<input class='form-control' type='datetime-local' name ='fecha' id='fecha' placeholder='Ingrese la fecha y hora de la reserva'/>
							</div><br>
							<div class='form-group'>
								<label for='recipient-name' class='col-form-label'>Cantidad de Personas:</label><br>
								<input class='form-control' type='text' name ='can_personas' id='can_personas' placeholder='Ingrese la cantidad de personas' value='".$data[3]."' required/>
							</div><br>
							<div class='form-group'>
								<label for='recipient-name' class='col-form-label'>Observaciones:</label><br>
								<input class='form-control' type='text' name ='observaciones' id='observaciones' placeholder='Ingrese observaciones de la reserva' value='".$data[4]."' required/>
							</div><br>
							
							<div class='form-group'>
								<label for='recipient-name' class='col-form-label'>Estado:</label><br>
								<select name='est' class='form-control'>
									<option>".$data[5]."</option>
									<option>Confirmado</option>
									<option>Pendiente</option>
									<option>Cancelado</option>
								</select>
							</div>

							<input type='hidden' name ='tbl' value='reservas'>
							<input type='hidden' name ='FA' value='".$data[2]."'>
                           
                            <input type='hidden' name='id' value='".$row[0]."'>
                        </div>                  
                        <div class='modal-footer'>
                        <button type='button' class='btn btn-danger btn-grad' data-dismiss='modal'>Cancelar</button>
                        <button type='submit' class='btn btn-success btn-grad' id='btnenviar' name='btnenviar'>Enviar</button>
                        </div>
                        </form>
                    </div>
                    </div>
                    </div>
					
					 <button type='button' class='btn btn-danger btn-round btn-grad' data-toggle='modal' data-target='#mde_".$row[0]."' data-whatever='@mdo'><i class='fa fa-trash'></i></button>
					<div class='modal fade' id='mde_".$row[0]."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
					<div class='modal-dialog' role='document'>
					  <div class='modal-content bg-dark text-white'>
						<div class='modal-header'>
						  <h3 class='modal-title text-left' id='exampleModalLabel'>Eliminar</h3>                    
						</div> 
						<form action='eliminar.php' method='post' enctype='multipart/form-data'>
						<div class='modal-body'>          
						<label></label>     
							<div class='alert alert-danger' role='alert'>
								¿Esta seguro de eliminar esta actividad?.
							</div>     
							<input type='hidden' name='id' value='".$row[0]."'>
							<input type='hidden' name ='tbl' value='reservas'>        
						</div>                  
						<div class='modal-footer'>
						  <button type='button' class='btn btn-danger btn-grad' data-dismiss='modal'>No</button>
						  <button type='submit' class='btn btn-success btn-grad' id='btnenviar' name='btnenviar'>Si</button>
						</div>
						</form>
					  </div>
					</div>
					</div>	</center>				
                    </td>
                    ";     

             echo $resp;



           }else{  



            Printf ("<td><center>%s</center></td>",$row[$i]);          



        }   

                

 

         }      

        

     echo "</tr>";

    }

     echo "</tbody>";

     echo "</table>";    

     echo "</div>";

}

function tabla_categoraisp($db) {

    $consulta="SELECT id as 'ID', categoria as 'Categoria', '' as 'Herramientas' FROM tbl_categoria_productos;";   

    //creamos el arreglo que contiene el nombre de los campos

    $Campos=array();

    $val= $db->query($consulta);

    //$val = mysqli_query($this->conexion,$consulta);

    //contamos las columnas

    $NumCampos =mysqli_num_fields($val);

     /* Obtener la información del campo de cada columna */

     while ($finfo = $val->fetch_field()) {

         $Campos[]= $finfo->name;        

     }

     //se inicia la tabla (aquí se pueden agregar diseños)   

     



     echo "<div id='collapse4' class='body'>";

     echo "<table id='DataTablesClientes' class='table table-bordered table-condensed table-hover table-striped'>";

     //se crea el encabezado de la tabla

     echo "<thead>";

     echo "<tr>";

     for ($i=0;$i<$NumCampos;$i++){

         Printf ("<th scope='col'><center>%s</center></th>",$Campos[$i]);

     } 

     echo "</tr>";

     echo "</thead>";

     echo "<tbody>";

     echo "<tr>";



     //SE CREA 

       while($row = mysqli_fetch_array($val))

    {	

   for ($i=0;$i<$NumCampos;$i++)

         {         
          if($i==2){
            $queryint = $db->query("SELECT categoria FROM tbl_categoria_productos where id = '".$row[0]."';");
            $data = $db -> fetch_array($queryint);
            $resp = "<td><center><button type='button' class='btn btn-primary btn-round btn-grad ' data-toggle='modal' data-target='#md_".$row[0]."' data-whatever='@mdo'><i class='fa fa-edit'></i></button>              
                    <div class='modal fade' id='md_".$row[0]."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                    <div class='modal-dialog' role='document'>
                    <div class='modal-content bg-dark text-white'>
                        <div class='modal-header'>
                        <h3 class='modal-title text-left' id='exampleModalLabel'>Editar</h3>                    
                        </div> 
                        <form action='editar.php' method='post' enctype='multipart/form-data'>
                        <div class='modal-body'>          
                        <label></label>     
                            <div class='form-group'>
                                <label for='recipient-name' class='col-form-label'>Categoria:</label>
                                <input class='form-control' type='text' name ='categoria' id='categoria' placeholder='Ingrese una categoria' value='".$data[0]."' />
                            </div>
                           
                            <input type='hidden' name='id' value='".$row[0]."'>
                            <input type='hidden' name ='tbl' value='categoria'>        
                        </div>                  
                        <div class='modal-footer'>
                        <button type='button' class='btn btn-danger btn-grad' data-dismiss='modal'>Cancelar</button>
                        <button type='submit' class='btn btn-success btn-grad' id='btnenviar' name='btnenviar'>Enviar</button>
                        </div>
                        </form>
                    </div>
                    </div>
                    </div>
					
					 <button type='button' class='btn btn-danger btn-round btn-grad' data-toggle='modal' data-target='#mde_".$row[0]."' data-whatever='@mdo'><i class='fa fa-trash'></i></button>
					<div class='modal fade' id='mde_".$row[0]."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
					<div class='modal-dialog' role='document'>
					  <div class='modal-content bg-dark text-white'>
						<div class='modal-header'>
						  <h3 class='modal-title text-left' id='exampleModalLabel'>Eliminar</h3>                    
						</div> 
						<form action='eliminar.php' method='post' enctype='multipart/form-data'>
						<div class='modal-body'>          
						<label></label>     
							<div class='alert alert-danger' role='alert'>
								¿Esta seguro de eliminar esta actividad?.
							</div>     
							<input type='hidden' name='id' value='".$row[0]."'>
							<input type='hidden' name ='tbl' value='categoria'>        
						</div>                  
						<div class='modal-footer'>
						  <button type='button' class='btn btn-danger btn-grad' data-dismiss='modal'>No</button>
						  <button type='submit' class='btn btn-success btn-grad' id='btnenviar' name='btnenviar'>Si</button>
						</div>
						</form>
					  </div>
					</div>
					</div>		</center>			
                    </td>
                    ";     

             echo $resp;



           }else{  



            Printf ("<td><center>%s</center></td>",$row[$i]);          



        }   

                

 

         }      

        

     echo "</tr>";

    }

     echo "</tbody>";

     echo "</table>";    

     echo "</div>";

}

function tabla_cargos($db) {

    $consulta="SELECT id as 'ID', perfiles as 'Cargo / Puesto', '' as 'Herramientas' FROM tlb_perfiles WHERE id NOT LIKE '%1%';";   

    //creamos el arreglo que contiene el nombre de los campos

    $Campos=array();

    $val= $db->query($consulta);

    //$val = mysqli_query($this->conexion,$consulta);

    //contamos las columnas

    $NumCampos =mysqli_num_fields($val);

     /* Obtener la información del campo de cada columna */

     while ($finfo = $val->fetch_field()) {

         $Campos[]= $finfo->name;        

     }

     //se inicia la tabla (aquí se pueden agregar diseños)   

     



     echo "<div id='collapse4' class='body'>";

     echo "<table id='DataTablesClientes' class='table table-bordered table-condensed table-hover table-striped'>";

     //se crea el encabezado de la tabla

     echo "<thead>";

     echo "<tr>";

     for ($i=0;$i<$NumCampos;$i++){

         Printf ("<th scope='col'><center>%s</center></th>",$Campos[$i]);

     } 

     echo "</tr>";

     echo "</thead>";

     echo "<tbody>";

     echo "<tr>";



     //SE CREA 

       while($row = mysqli_fetch_array($val))

    {	

   for ($i=0;$i<$NumCampos;$i++)

         {         
          if($i==2){
            $queryint = $db->query("SELECT perfiles FROM tlb_perfiles where id = '".$row[0]."';");
            $data = $db -> fetch_array($queryint);
            $resp = "<td><center>
					
					<a href='permisos.php?idperfil=".$row[0]."' class='btn btn-metis-2 btn-round btn-grad' title='Gestionar Permisos'><i class='fa fa-universal-access' ></i></a>
					
					</center>			
                    </td>
                    ";     

             echo $resp;



           }else{  



            Printf ("<td><center>%s</center></td>",$row[$i]);          



        }   

                

 

         }      

        

     echo "</tr>";

    }

     echo "</tbody>";

     echo "</table>";    

     echo "</div>";

}

function tabla_mesas($db) {

    $consulta="SELECT id as 'ID', mesa as 'Mesa', (select b.zona from tbl_zonas b where a.zona= b.id ) as 'Zona' , cant_personas AS 'Cantidad Personas','' as 'Herramientas'
				FROM tlb_mesas a;";   

    //creamos el arreglo que contiene el nombre de los campos

    $Campos=array();

    $val= $db->query($consulta);

    //$val = mysqli_query($this->conexion,$consulta);

    //contamos las columnas

    $NumCampos =mysqli_num_fields($val);

     /* Obtener la información del campo de cada columna */

     while ($finfo = $val->fetch_field()) {

         $Campos[]= $finfo->name;        

     }

     //se inicia la tabla (aquí se pueden agregar diseños)   

     



     echo "<div id='collapse4' class='body'>";

     echo "<table id='DataTablesClientes' class='table table-bordered table-condensed table-hover table-striped'>";

     //se crea el encabezado de la tabla

     echo "<thead>";

     echo "<tr>";

     for ($i=0;$i<$NumCampos;$i++){

         Printf ("<th scope='col'><center>%s</center></th>",$Campos[$i]);

     } 

     echo "</tr>";

     echo "</thead>";

     echo "<tbody>";

     echo "<tr>";



     //SE CREA 

       while($row = mysqli_fetch_array($val))

    {	

   for ($i=0;$i<$NumCampos;$i++)

         {         
          if($i==4 ){
            $queryint = $db->query("SELECT a.mesa, a.zona, (select b.zona from tbl_zonas b where a.zona= b.id ) as 'Zona', cant_personas AS 'CantidadPersonas' FROM tlb_mesas a where a.id = '".$row[0]."';");
			  
			$query2 = "SELECT id, zona FROM tbl_zonas";
			$data3 = $db->query($query2);
			while ($val3 = $db -> fetch_array($data3)) 
			{
				$optiontp = $optiontp."<option  value=".$val3['id'].">".$val3['zona']."</option>";
			}
			  
            $data = $db -> fetch_array($queryint);
            $resp = "<td><center><button type='button' class='btn btn-primary btn-round btn-grad ' data-toggle='modal' data-target='#md_".$row[0]."' data-whatever='@mdo'><i class='fa fa-edit'></i></button>              
                    <div class='modal fade' id='md_".$row[0]."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                    <div class='modal-dialog' role='document'>
                    <div class='modal-content bg-dark text-white'>
                        <div class='modal-header'>
                        <h3 class='modal-title text-left' id='exampleModalLabel'>Editar</h3>                    
                        </div> 
                        <form action='editar.php' method='post' enctype='multipart/form-data'>
                        <div class='modal-body'>          
                        <label></label>     
                            <div class='form-group'>
                                <label for='recipient-name' class='col-form-label'>Nombre:</label><br>
                                <input class='form-control' type='text' name ='mesa' id='mesa' placeholder='Ingrese el nombre de la mesa' value='".$data[0]."' /><br>
                            </div> 
							<div class='form-group'>
								<label for='recipient-name' class='col-form-label'>Tipo de Contratos:</label></br>

								<select name='zonas' id='zonas' class='form-control'>
									<option value='".$data[1]."' selected>".$data[2]."</option>
									$optiontp
								</select><br>
							</div>
							<div class='form-group'>
                                <label for='recipient-name' class='col-form-label'>Cantidad de Persoans:</label><br>
                                <input class='form-control' type='text' name ='cant_personas' id='cant_personas' placeholder='Ingrese el nombre de la mesa' value='".$data[3]."' /><br>
                            </div> 
                            <input type='hidden' name='id' value='".$row[0]."'>
                            <input type='hidden' name ='tbl' value='mesas'>        
                        </div>                  
                        <div class='modal-footer'>
                        <button type='button' class='btn btn-danger btn-grad' data-dismiss='modal'>Cancelar</button>
                        <button type='submit' class='btn btn-success btn-grad' id='btnenviar' name='btnenviar'>Enviar</button>
                        </div>
                        </form>
                    </div>
                    </div>
                    </div>
					
					 <button type='button' class='btn btn-danger btn-round btn-grad' data-toggle='modal' data-target='#mde_".$row[0]."' data-whatever='@mdo'><i class='fa fa-trash'></i></button>
					<div class='modal fade' id='mde_".$row[0]."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
					<div class='modal-dialog' role='document'>
					  <div class='modal-content bg-dark text-white'>
						<div class='modal-header'>
						  <h3 class='modal-title text-left' id='exampleModalLabel'>Eliminar</h3>                    
						</div> 
						<form action='eliminar.php' method='post' enctype='multipart/form-data'>
						<div class='modal-body'>          
						<label></label>     
							<div class='alert alert-danger' role='alert'>
								¿Esta seguro de eliminar esta actividad?.
							</div>     
							<input type='hidden' name='id' value='".$row[0]."'>
							<input type='hidden' name ='tbl' value='mesas'>        
						</div>                  
						<div class='modal-footer'>
						  <button type='button' class='btn btn-danger btn-grad' data-dismiss='modal'>No</button>
						  <button type='submit' class='btn btn-success btn-grad' id='btnenviar' name='btnenviar'>Si</button>
						</div>
						</form>
					  </div>
					</div>
					</div>		</center>			
                    </td>
                    ";     

             echo $resp;



           }else{  



            Printf ("<td><center>%s</center></td>",$row[$i]);          



        }   

                

 

         }      

        

     echo "</tr>";

    }

     echo "</tbody>";

     echo "</table>";    

     echo "</div>";

}

function tabla_usuarios($db) {

    $consulta="SELECT a.id as 'ID', a.nombres as 'Nombres', a.apellidos as 'Apellidos' , documento AS 'Numero Documento', correo AS 'Correo', usuario AS 'Usuario', '' as 'Herramientas' FROM tbl_usuarios AS a;";   

    //creamos el arreglo que contiene el nombre de los campos

    $Campos=array();

    $val= $db->query($consulta);

    //$val = mysqli_query($this->conexion,$consulta);

    //contamos las columnas

    $NumCampos =mysqli_num_fields($val);

     /* Obtener la información del campo de cada columna */

     while ($finfo = $val->fetch_field()) {

         $Campos[]= $finfo->name;        

     }

     //se inicia la tabla (aquí se pueden agregar diseños)   

     



     echo "<div id='collapse4' class='body'>";

     echo "<table id='DataTablesClientes' class='table table-bordered table-condensed table-hover table-striped'>";

     //se crea el encabezado de la tabla

     echo "<thead>";

     echo "<tr>";

     for ($i=0;$i<$NumCampos;$i++){

         Printf ("<th scope='col'><center>%s</center></th>",$Campos[$i]);

     } 

     echo "</tr>";

     echo "</thead>";

     echo "<tbody>";

     echo "<tr>";



     //SE CREA 

       while($row = mysqli_fetch_array($val))

    {	

   for ($i=0;$i<$NumCampos;$i++)

         {         
          if($i==6){
            $queryint = $db->query("SELECT us.*,tc.*,(SELECT tipo_doc FROM tbl_tipos_documentos WHERE id = us.tipo_doc) AS 'Tipo Doc', 
									(SELECT tipo_contrato FROM tbl_tipos_contratos WHERE id = tc.tipo_contrato) AS 'Tipo Con',
									(SELECT perfiles FROM tlb_perfiles WHERE id = us.perfil) AS 'Perfil' 
									FROM tbl_usuarios AS us 
									INNER JOIN tbl_contratos AS tc ON us.id = tc.idusuario where us.id = '".$row[0]."';");
            $data = $db -> fetch_array($queryint);
			$optiontd = "";
			$optiontc = "";
	     	$optiontp = "";
			
			$query2 = "SELECT id , tipo_doc FROM `tbl_tipos_documentos`";
			$data3 = $db->query($query2);
			while ($val3 = $db -> fetch_array($data3)) 
			{
				$optiontd = $optiontd."<option  value=".$val3['id'].">".$val3['tipo_doc']."</option>";
			}
			
			$query2 = "SELECT id , tipo_contrato FROM `tbl_tipos_contratos`";
			$data3 = $db->query($query2);
			while ($val3 = $db -> fetch_array($data3)) 
			{
				$optiontc = $optiontc."<option  value=".$val3['id'].">".$val3['tipo_contrato']."</option>";
			}
			 
			$query2 = "SELECT id , perfiles FROM `tlb_perfiles`";
			$data3 = $db->query($query2);
			while ($val3 = $db -> fetch_array($data3)) 
			{
				$optiontp = $optiontp."<option  value=".$val3['id'].">".$val3['perfiles']."</option>";
			}
			  
			$despass=Enc('dec', $data[9]);
            $resp = "<td><button type='button' class='btn btn-primary btn-round btn-grad ' data-toggle='modal' data-target='#md_".$row[0]."' data-whatever='@mdo'><i class='fa fa-edit'></i></button>              
                    
					<div class='modal fade' id='md_".$row[0]."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
						<div class='modal-dialog' role='document'>
							<div class='modal-content bg-dark text-white'>
								<div class='modal-header'>
									<h3 class='modal-title text-left' id='exampleModalLabel'>Editar</h3>                    
								</div> 
								<form action='editar.php' method='post' enctype='multipart/form-data'>
									<div class='modal-body row'>          
										<label></label>     
										
										<div class='form-group col-lg-6'>
											<label for='recipient-name' class='col-form-label'>Nombres:</label></br>
											<input class='form-control' type='text' name ='nombres' id='nombres' placeholder='Ingrese el nombre del usuario' required value='".$data[1]."'/>
										</div>

										<div class='form-group col-lg-6'>
											<label for='message-text' class='col-form-label'>Apellidos:</label></br>
											<input type='text' class='form-control'  name='apellidos' id='apellidos' placeholder='Ingrese el apellido del usuario' required value='".$data[2]."'>
										</div>

										<div class='form-group col-lg-6'>
											<label for='recipient-name' class='col-form-label'>Tipo Documento:</label></br>

											<select name='tipo_doc' id='tipo_doc' class='form-control'>
												<option selected value='".$data[3]."'>".$data[19]."</option>
													$optiontd
											</select>
										</div>

										<div class='form-group col-lg-6'>
											<label for='message-text' class='col-form-label'>N° Documento:</label></br>
											<input class='form-control' type='number' name ='documento' id='documento' placeholder='Ingrese el numero de documento' value='".$data[4]."' required/>
										</div>

										<div class='form-group col-lg-6'>
											<label for='recipient-name' class='col-form-label'>Telefono:</label></br>
											<input class='form-control' type='number' name ='telefono' id='telefono' placeholder='Ingrese el telefono' value='".$data[6]."' required/>
										</div>

										<div class='form-group col-lg-6'>
											<label for='message-text' class='col-form-label'>Direccion:</label></br>
											<input type='text' class='form-control'  name='direccion' id='direccion' placeholder='Ingrese la direccion' value='".$data[7]."' required>
										</div>

										<div class='form-group col-lg-6'>
											<label for='recipient-name' class='col-form-label'>Usuario:</label></br>
											<input class='form-control' type='text' name ='usuario' id='usuario' placeholder='Ingrese el usuario' value='".$data[8]."' required/>
										</div>

										<div class='form-group col-lg-6'>
											<label for='message-text' class='col-form-label'>Contraseña:</label></br>
											<input type='password' class='form-control'  name='contrasenia1' id='contrasenia1' placeholder='Ingrese la contraseña' value='".$despass."' required>
										</div>

										<div class='form-group col-lg-6'>
											<label for='recipient-name' class='col-form-label'>Confirmar Contraseña:</label></br>
											<input class='form-control' type='password' name ='contrasenia2' id='contrasenia2' placeholder='Ingrese la confirmacion de la contraseña' value='".$despass."' required/>
										</div>

										<div class='form-group col-lg-6'>
											<label for='message-text' class='col-form-label'>Correo:</label></br>
											<input type='email' class='form-control'  name='correo' id='correo' placeholder='Ingrese el correo' value='".$data[11]."' required>
										</div>

										<div class='form-group col-lg-6'>
											<label for='recipient-name' class='col-form-label'>Tipo de Contratos:</label></br>

											<select name='tipo_contrato' id='tipo_contrato' class='form-control'>
												<option selected value='".$data[14]."'>".$data[20]."</option>
												$optiontc
											</select>
										</div>

										<div class='form-group col-lg-6'>
											<label for='message-text' class='col-form-label'>Porcentaje de Ganancias:</label></br>
											<input type='number' class='form-control'  name='porcentaje' id='porcentaje' placeholder='Ingrese el porcentaje' value='".$data[17]."' required>
										</div>

										<div class='form-group col-lg-6'>
											<label for='message-text' class='col-form-label'>Fecha Inicio:</label></br>
											<input type='date' class='form-control'  name='Finicio' id='Finicio' placeholder='Ingrese la fecha de inicio' value='".$data[15]."' required>
										</div>

										<div class='form-group col-lg-6'>
											<label for='message-text' class='col-form-label'>Fecha Fin:</label></br>
											<input type='date' class='form-control'  name='Ffin' id='Ffin' placeholder='Ingrese la fecha de finalisación' value='".$data[16]."'>
										</div>
										
										<div class='form-group col-lg-6'>
											<label for='message-text' class='col-form-label'>Valor Contrato:</label></br>
											<input type='number' class='form-control'  name='valor_contrato' id='valor_contrato' placeholder='Ingrese el valor del contrato' value='".$data[18]."'>
										</div>

										<div class='form-group col-lg-6'>
											<label for='recipient-name' class='col-form-label'>Cargo:</label></br>

											<select name='cargo' id='cargo' class='form-control'>
												<option selected value='".$data[5]."'>".$data[21]."</option>
												$optiontp
											</select>
										</div>

										<input type='hidden' name='id' value='".$row[0]."'>
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
					
					<button type='button' class='btn btn-danger btn-round btn-grad' data-toggle='modal' data-target='#mde_".$row[0]."' data-whatever='@mdo'><i class='fa fa-trash'></i></button>
					<div class='modal fade' id='mde_".$row[0]."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
					<div class='modal-dialog' role='document'>
					  <div class='modal-content bg-dark text-white'>
						<div class='modal-header'>
						  <h3 class='modal-title text-left' id='exampleModalLabel'>Eliminar</h3>                    
						</div> 
						<form action='eliminar.php' method='post' enctype='multipart/form-data'>
						<div class='modal-body'>          
						<label></label>     
							<div class='alert alert-danger' role='alert'>
								¿Esta seguro de eliminar esta actividad?.
							</div>     
							<input type='hidden' name='id' value='".$row[0]."'>
							<input type='hidden' name ='tbl' value='usuarios'>        
						</div>                  
						<div class='modal-footer'>
						  <button type='button' class='btn btn-danger btn-grad' data-dismiss='modal'>No</button>
						  <button type='submit' class='btn btn-success btn-grad' id='btnenviar' name='btnenviar'>Si</button>
						</div>
						</form>
					  </div>
					</div>
					</div>		</center>			
                    </td>
                    ";     

             echo $resp;



           }else{  



            Printf ("<td><center>%s</center></td>",$row[$i]);          



        }   

                

 

         }      

        

     echo "</tr>";

    }

     echo "</tbody>";

     echo "</table>";    

     echo "</div>";

}

function tabla_contratos($db) {

    $consulta="SELECT a.id as 'ID', (SELECT nombres FROM tbl_usuarios WHERE id = a.idusuario) as 'Usuario', (SELECT tipo_contrato FROM tbl_tipos_contratos WHERE id = a.tipo_contrato) as 'Tipo Contrato', a.fechainicio AS 'Fecha Inicial', a.fechafin AS 'Fecha Final', a.porcentaje AS 'Porcentaje' FROM tbl_contratos AS a;";   

    //creamos el arreglo que contiene el nombre de los campos

    $Campos=array();

    $val= $db->query($consulta);

    //$val = mysqli_query($this->conexion,$consulta);

    //contamos las columnas

    $NumCampos =mysqli_num_fields($val);

     /* Obtener la información del campo de cada columna */

     while ($finfo = $val->fetch_field()) {

         $Campos[]= $finfo->name;        

     }

     //se inicia la tabla (aquí se pueden agregar diseños)   

     



     echo "<div id='collapse4' class='body'>";

     echo "<table id='DataTablesClientes' class='table table-bordered table-condensed table-hover table-striped'>";

     //se crea el encabezado de la tabla

     echo "<thead>";

     echo "<tr>";

     for ($i=0;$i<$NumCampos;$i++){

         Printf ("<th scope='col'><center>%s</center></th>",$Campos[$i]);

     } 

     echo "</tr>";

     echo "</thead>";

     echo "<tbody>";

     echo "<tr>";



     //SE CREA 

       while($row = mysqli_fetch_array($val))

    {	

   for ($i=0;$i<$NumCampos;$i++){         
		Printf ("<td><center>%s</center></td>",$row[$i]);          
	 }      

        

     echo "</tr>";

    }

     echo "</tbody>";

     echo "</table>";    

     echo "</div>";

}

function tabla_tipos_contratos($db) {

    $consulta="SELECT id as 'ID', tipo_contrato as 'Tipo Contrato', concepto as 'Concepto' FROM tbl_tipos_contratos;";   

    //creamos el arreglo que contiene el nombre de los campos

    $Campos=array();

    $val= $db->query($consulta);

    //$val = mysqli_query($this->conexion,$consulta);

    //contamos las columnas

    $NumCampos =mysqli_num_fields($val);

     /* Obtener la información del campo de cada columna */

     while ($finfo = $val->fetch_field()) {

         $Campos[]= $finfo->name;        

     }

     //se inicia la tabla (aquí se pueden agregar diseños)   

     



     echo "<div id='collapse4' class='body'>";

     echo "<table id='DataTablesClientes' class='table table-bordered table-condensed table-hover table-striped'>";

     //se crea el encabezado de la tabla

     echo "<thead>";

     echo "<tr>";

     for ($i=0;$i<$NumCampos;$i++){

         Printf ("<th scope='col'><center>%s</center></th>",$Campos[$i]);

     } 

     echo "</tr>";

     echo "</thead>";

     echo "<tbody>";

     echo "<tr>";



     //SE CREA 

       while($row = mysqli_fetch_array($val))

    {	

   for ($i=0;$i<$NumCampos;$i++)

         {         
          if($i==3 ){
            $queryint = $db->query("SELECT tipo_contrato, concepto FROM tbl_tipos_contratos where id = '".$row[0]."';");
            $data = $db -> fetch_array($queryint);
            $resp = "<td><center><button type='button' class='btn btn-primary btn-round btn-grad ' data-toggle='modal' data-target='#md_".$row[0]."' data-whatever='@mdo'><i class='fa fa-edit'></i></button>              
                    <div class='modal fade' id='md_".$row[0]."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                    <div class='modal-dialog' role='document'>
                    <div class='modal-content bg-dark text-white'>
                        <div class='modal-header'>
                        <h3 class='modal-title text-left' id='exampleModalLabel'>Editar</h3>                    
                        </div> 
                        <form action='editar.php' method='post' enctype='multipart/form-data'>
                        <div class='modal-body'>          
                        <label></label>     
                            <div class='form-group'>
                                <label for='recipient-name' class='col-form-label'>Tipo Contrato:</label>
                                <input class='form-control' type='text' name ='contrato' id='contrato' placeholder='Ingrese una Zona' value='".$data[0]."' />
                            </div>
                            <div class='form-group'>
                            <label for='message-text' class='col-form-label'>Concepto:</label>
                            <textarea class='form-control'  name='concepto' id='concepto' placeholder='Ingrese Descripción' required>".$data[1]."</textarea>
                            </div> 
                           
                            <input type='hidden' name='id' value='".$row[0]."'>
                            <input type='hidden' name ='tbl' value='Tcontratos'>        
                        </div>                  
                        <div class='modal-footer'>
                        <button type='button' class='btn btn-danger btn-grad' data-dismiss='modal'>Cancelar</button>
                        <button type='submit' class='btn btn-success btn-grad' id='btnenviar' name='btnenviar'>Enviar</button>
                        </div>
                        </form>
                    </div>
                    </div>
                    </div>
					
					 <button type='button' class='btn btn-danger btn-round btn-grad' data-toggle='modal' data-target='#mde_".$row[0]."' data-whatever='@mdo'><i class='fa fa-trash'></i></button>
					<div class='modal fade' id='mde_".$row[0]."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
					<div class='modal-dialog' role='document'>
					  <div class='modal-content bg-dark text-white'>
						<div class='modal-header'>
						  <h3 class='modal-title text-left' id='exampleModalLabel'>Eliminar</h3>                    
						</div> 
						<form action='eliminar.php' method='post' enctype='multipart/form-data'>
						<div class='modal-body'>          
						<label></label>     
							<div class='alert alert-danger' role='alert'>
								¿Esta seguro de eliminar esta actividad?.
							</div>     
							<input type='hidden' name='id' value='".$row[0]."'>
							<input type='hidden' name ='tbl' value='Tcontratos'>        
						</div>                  
						<div class='modal-footer'>
						  <button type='button' class='btn btn-danger btn-grad' data-dismiss='modal'>No</button>
						  <button type='submit' class='btn btn-success btn-grad' id='btnenviar' name='btnenviar'>Si</button>
						</div>
						</form>
					  </div>
					</div>
					</div>		</center>			
                    </td>
                    ";     

             echo $resp;



           }else{  



            Printf ("<td><center>%s</center></td>",$row[$i]);          



        }   

                

 

         }      

        

     echo "</tr>";

    }

     echo "</tbody>";

     echo "</table>";    

     echo "</div>";

}

function tabla_imagenes($db) {

    $consulta="SELECT id as 'ID', '' as 'Imagen', tipo AS 'Tipo Imagen',ubicacion AS 'Ubicacion', '' as 'Herramientas' FROM tbl_media;";   

    //creamos el arreglo que contiene el nombre de los campos

    $Campos=array();

    $val= $db->query($consulta);

    //$val = mysqli_query($this->conexion,$consulta);

    //contamos las columnas

    $NumCampos =mysqli_num_fields($val);

     /* Obtener la información del campo de cada columna */

     while ($finfo = $val->fetch_field()) {

         $Campos[]= $finfo->name;        

     }

     //se inicia la tabla (aquí se pueden agregar diseños)   

     



     echo "<div id='collapse4' class='body'>";

     echo "<table id='DataTablesClientes' class='table table-bordered table-condensed table-hover table-striped'>";

     //se crea el encabezado de la tabla

     echo "<thead>";

     echo "<tr>";

     for ($i=0;$i<$NumCampos;$i++){

         Printf ("<th scope='col'><center>%s</center></th>",$Campos[$i]);

     } 

     echo "</tr>";

     echo "</thead>";

     echo "<tbody>";

     echo "<tr>";



     //SE CREA 

       while($row = mysqli_fetch_array($val))

    {	

   for ($i=0;$i<$NumCampos;$i++)

         {         
	   	  
	   
          if($i==4){
            $queryint = $db->query("SELECT url, tipo, ubicacion FROM tbl_media where id = '".$row[0]."';");
            $data = $db -> fetch_array($queryint);
            $resp = "<td><center><button type='button' class='btn btn-primary btn-round btn-grad ' data-toggle='modal' data-target='#md_".$row[0]."' data-whatever='@mdo'><i class='fa fa-edit'></i></button>              
                    <div class='modal fade' id='md_".$row[0]."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
						<div class='modal-dialog' role='document'>
							<div class='modal-content bg-dark text-white'>
								<div class='modal-header'>
								<h3 class='modal-title text-left' id='exampleModalLabel'>Editar</h3>                    
								</div> 
								<form action='editar.php' method='post' enctype='multipart/form-data'>
									<div class='modal-body'>          
									<label></label>     
										<div class='form-group'>
											<label for='recipient-name' class='col-form-label'>Imgagen:</label></br>
											<input class='form-control' type='file' name ='imagen' id='imagen' placeholder='Ingrese una Zona'/>
											<input class='form-control' type='hidden' name ='urlimagen' id='urlimagen' value='".$data[0]."'/>
										</div></br>

										<input type='hidden' name='id' value='".$row[0]."'>
										<input type='hidden' name ='tbl' value='imagen'>
									</div>                  
									<div class='modal-footer'>
									<button type='button' class='btn btn-danger btn-grad' data-dismiss='modal'>Cancelar</button>
									<button type='submit' class='btn btn-success btn-grad' id='btnenviar' name='btnenviar'>Enviar</button>
									</div>
								</form>
							</div>
						</div>
                    </div>
							</center>	
                    </td>
                    ";     

             echo $resp;



           }elseif($i==1){
            $queryint = $db->query("SELECT url FROM tbl_media where id = '".$row[0]."';");
            $data = $db -> fetch_array($queryint);
            $resp = "<td><center><img src='".$data[0]."' alt='' width='100'></center></td>";
             echo $resp;

           }else{  
            Printf ("<td><center>%s</center></td>",$row[$i]);          
        }   

                

 

         }      

        

     echo "</tr>";

    }

     echo "</tbody>";

     echo "</table>";    

     echo "</div>";

}

function tabla_servicios($db) {

    $consulta="SELECT id as 'ID', tipo as 'Tipo', porcentaje AS 'Porcentaje', '' AS 'Estado', '' as 'Herramientas' FROM tbl_parametros;";   

    //creamos el arreglo que contiene el nombre de los campos

    $Campos=array();

    $val= $db->query($consulta);

    //$val = mysqli_query($this->conexion,$consulta);

    //contamos las columnas

    $NumCampos =mysqli_num_fields($val);

     /* Obtener la información del campo de cada columna */

     while ($finfo = $val->fetch_field()) {

         $Campos[]= $finfo->name;        

     }

     //se inicia la tabla (aquí se pueden agregar diseños)   

     



     echo "<div id='collapse4' class='body'>";

     echo "<table id='DataTablesClientes' class='table table-bordered table-condensed table-hover table-striped'>";

     //se crea el encabezado de la tabla

     echo "<thead>";

     echo "<tr>";

     for ($i=0;$i<$NumCampos;$i++){

         Printf ("<th scope='col'><center>%s</center></th>",$Campos[$i]);

     } 

     echo "</tr>";

     echo "</thead>";

     echo "<tbody>";

     echo "<tr>";



     //SE CREA 

       while($row = mysqli_fetch_array($val))

    {	

   for ($i=0;$i<$NumCampos;$i++)

         {         
	   	  
	   
          if($i==4){
            $queryint = $db->query("SELECT url, tipo, ubicacion FROM tbl_media where id = '".$row[0]."';");
            $data = $db -> fetch_array($queryint);
            $resp = "<td><center><button type='button' class='btn btn-primary btn-round btn-grad ' data-toggle='modal' data-target='#md_".$row[0]."' data-whatever='@mdo'><i class='fa fa-edit'></i> </button>  </center>	            
                    <div class='modal fade' id='md_".$row[0]."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
						<div class='modal-dialog' role='document'>
							<div class='modal-content bg-dark text-white'>
								<div class='modal-header'>
								<h3 class='modal-title text-left' id='exampleModalLabel'>Editar</h3>                    
								</div> 
								<form action='editar.php' method='post' enctype='multipart/form-data'>
									<div class='modal-body'>          
									<label></label>     
										<div class='form-group'>
											<label for='recipient-name' class='col-form-label'>Porcentaje:</label></br>
											<input class='form-control' type='number' name ='porcentaje' id='porcentaje' placeholder='Por favor ingrese un porcentaje' value='".$row[2]."'/> <br>
											<label for='recipient-name' class='col-form-label'>Estado:</label></br>
											<select class='form-control' name='estado'>
												<option>Seleccionar</option>
												<option value='1'>Activo</option>
												<option value='2'>Inactivo</option>
											</select>
										</div></br>

										<input type='hidden' name='id' value='".$row[0]."'>
										<input type='hidden' name ='tbl' value='parametro'>
									</div>                  
									<div class='modal-footer'>
									<button type='button' class='btn btn-danger btn-grad' data-dismiss='modal'>Cancelar</button>
									<button type='submit' class='btn btn-success btn-grad' id='btnenviar' name='btnenviar'>Enviar</button>
									</div>
								</form>
							</div>
						</div>
                    </div>
							
                    </td>
                    ";     

             echo $resp;



           }elseif($i==3){
            $queryint = $db->query("SELECT estado FROM tbl_parametros where id = '".$row[0]."';");
            $data = $db -> fetch_array($queryint);
			if($data[0] == "1"){
            	$resp = "<td><center>Activo</center></td>";
			}else{
				$resp = "<td><center>Inactivo</center></td>";
			}
             echo $resp;

           }else{  
            Printf ("<td><center>%s</center></td>",$row[$i]);          
        }   

                

 

         }      

        

     echo "</tr>";

    }

     echo "</tbody>";

     echo "</table>";    

     echo "</div>";

}

function tabla_productos($db) {

    $consulta="SELECT id as 'ID', nombre as 'Nombre', valor_compra as 'Valor Compra', valor_venta AS 'Valor Venta', cantidad AS 'Cantidad', (SELECT categoria FROM tbl_categoria_productos WHERE id = a.categoria) AS 'Categoria', '' AS 'Imagen','' as 'Herramientas' FROM tbl_productos AS a;";   

    //creamos el arreglo que contiene el nombre de los campos

    $Campos=array();

    $val= $db->query($consulta);

    //$val = mysqli_query($this->conexion,$consulta);

    //contamos las columnas

    $NumCampos =mysqli_num_fields($val);

     /* Obtener la información del campo de cada columna */

     while ($finfo = $val->fetch_field()) {

         $Campos[]= $finfo->name;        

     }

     //se inicia la tabla (aquí se pueden agregar diseños)   

     



     echo "<div id='collapse4' class='body'>";

     echo "<table id='DataTablesClientes' class='table table-bordered table-condensed table-hover table-striped'>";

     //se crea el encabezado de la tabla

     echo "<thead>";

     echo "<tr>";

     for ($i=0;$i<$NumCampos;$i++){

         Printf ("<th scope='col'><center>%s</center></th>",$Campos[$i]);

     } 

     echo "</tr>";

     echo "</thead>";

     echo "<tbody>";

     echo "<tr>";



     //SE CREA 

       while($row = mysqli_fetch_array($val))

    {	

   for ($i=0;$i<$NumCampos;$i++)

         {         
          if($i==7){
            $queryint = $db->query("SELECT nombre as 'Nombre', valor_compra as 'Valor Compra', valor_venta AS 'Valor Venta', cantidad AS 'Cantidad', (SELECT categoria FROM tbl_categoria_productos WHERE id = a.categoria) AS 'Categoria', imagenes FROM tbl_productos AS a where id = '".$row[0]."';");
            $data = $db -> fetch_array($queryint);
			  
			$valor1 = $db->query("SELECT (SELECT id FROM tbl_categoria_productos WHERE id = a.categoria) AS 'Categoria' FROM tbl_productos AS a where id = '".$row[0]."';");
            $valor = $db -> fetch_array($valor1);
			  
			$categoria = "";
			$query2 = "SELECT id , categoria FROM `tbl_categoria_productos`";
			$data3 = $db->query($query2);
			while ($val3 = $db -> fetch_array($data3)) 
			{
				$categoria = $categoria."<option  value=".$val3['id'].">".$val3['categoria']."</option>";
			}  	
			  
            $resp = "<td><button type='button' class='btn btn-primary btn-round btn-grad ' data-toggle='modal' data-target='#md_".$row[0]."' data-whatever='@mdo'><i class='fa fa-edit'></i></button>              
                    <div class='modal fade' id='md_".$row[0]."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                    <div class='modal-dialog' role='document'>
                    <div class='modal-content bg-dark text-white'>
                        <div class='modal-header'>
                        <h3 class='modal-title text-left' id='exampleModalLabel'>Editar</h3>                    
                        </div> 
                        <form action='editar.php' method='post' enctype='multipart/form-data'>
                        <div class='modal-body'>          
                        <label></label>     
						
                            <div class='form-group'>
								<label for='recipient-name' class='col-form-label'>Nombre:</label><br>
								<input class='form-control col-lg-12' type='text' name ='nombrep' id='nombrep' placeholder='Ingrese el nombre del producto'  value='".$data[0]."'/>
							</div><br>

							<div class='form-group'>
								<label for='message-text' class='col-form-label'>Valor Compra:</label><br>
								<input class='form-control col-lg-12' type='number' name ='Vcompra' id='Vcompra' placeholder='Ingrese el valor de compra'  value='".$data[1]."'/>
							</div><br>

							<div class='form-group'>
								<label for='message-text' class='col-form-label'>Valor Venta:</label><br>
								<input class='form-control col-lg-12' type='number' name ='Vventa' id='Vventa' placeholder='Ingrese el valor de venta'  value='".$data[2]."'/>
							</div><br>

							<div class='form-group'>
								<label for='message-text' class='col-form-label'>Cantidad:</label><br>
								<input class='form-control col-lg-12' type='number' name ='cantidad' id='cantidad' placeholder='Ingrese la cantidad disponible'  value='".$data[3]."'/>
							</div><br>

							<div class='form-group'>
								<label for='recipient-name' class='col-form-label'>Categoria:</label><br>

								<select name='categoria' id='categoria' class='form-control col-lg-12' >
									<option selected value='".$valor[0]."'>".$data[4]."</option>
									$categoria
								</select>
							</div><br>

							<div class='form-group'>
								<label for='message-text' class='col-form-label'>Imagen:</label><br>
								<input class='form-control col-lg-12' type='file' name ='imagen' id='imagen' />
								<input class='form-control col-lg-12' type='hidden' name ='urlimagen' id='urlimagen'  value='".$data[5]."'/>
							</div><br>
                           
                            <input type='hidden' name='id' value='".$row[0]."'>
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
					
					 <button type='button' class='btn btn-danger btn-round btn-grad' data-toggle='modal' data-target='#mde_".$row[0]."' data-whatever='@mdo'><i class='fa fa-trash'></i></button>
					<div class='modal fade' id='mde_".$row[0]."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
					<div class='modal-dialog' role='document'>
					  <div class='modal-content bg-dark text-white'>
						<div class='modal-header'>
						  <h3 class='modal-title text-left' id='exampleModalLabel'>Eliminar</h3>                    
						</div> 
						<form action='eliminar.php' method='post' enctype='multipart/form-data'>
						<div class='modal-body'>          
						<label></label>     
							<div class='alert alert-danger' role='alert'>
								¿Esta seguro de eliminar esta actividad?.
							</div>     
							<input type='hidden' name='id' value='".$row[0]."'>
							<input type='hidden' name ='tbl' value='productos'>        
						</div>                  
						<div class='modal-footer'>
						  <button type='button' class='btn btn-danger btn-grad' data-dismiss='modal'>No</button>
						  <button type='submit' class='btn btn-success btn-grad' id='btnenviar' name='btnenviar'>Si</button>
						</div>
						</form>
					  </div>
					</div>
					</div>					
                    </td>
                    ";     

             echo $resp;



           }elseif($i==6){
            $queryint = $db->query("SELECT imagenes FROM tbl_productos where id = '".$row[0]."';");
            $data = $db -> fetch_array($queryint);
            $resp = "<td><center><img src='".$data[0]."' alt='' width='100'></center></td>";
             echo $resp;

           }else{  

            Printf ("<td><center>%s</center></td>",$row[$i]);          

        }   

                

 

         }      

        

     echo "</tr>";

    }

     echo "</tbody>";

     echo "</table>";    

     echo "</div>";

}

function tabla_pedidos($db,$id) {
	
    $perfil=$db->HallaValorUnico("SELECT  perfil FROM tbl_usuarios where id = $id;");
	if($perfil==1){
	$consulta="SELECT a.id as 'Id',(SELECT  b.mesa FROM tlb_mesas b where b.id =a.mesa)  as 'Mesa'
	, (SELECT concat(c.nombres,' ' ,c.apellidos) FROM tbl_usuarios c where c.id = a.asesor) as 'Asesor', (SELECT d.estado FROM tbl_estados_pedidos d where d.id =a.estado) as 'Estado', a.subtotal  as 'Sub Total', '' as 'Herramientas'
		FROM tbl_pedidos a where a.estado = 1 ;"; 
		$h=5;
	}
	else{
		$consulta="SELECT a.id as 'Id',(SELECT  b.mesa FROM tlb_mesas b where b.id =a.mesa)  as 'Mesa'
		, (SELECT d.estado FROM tbl_estados_pedidos d where d.id =a.estado) as 'Estado', a.subtotal  as 'Sub Total','' as 'Herramientas'
		FROM tbl_pedidos a where a.estado = 1 and a.asesor = $id;"; 
		$h=4; 
	}
      

    //creamos el arreglo que contiene el nombre de los campos

    $Campos=array();

    $val= $db->query($consulta);

    //$val = mysqli_query($this->conexion,$consulta);

    //contamos las columnas

    $NumCampos =mysqli_num_fields($val);

     /* Obtener la información del campo de cada columna */

     while ($finfo = $val->fetch_field()) {

         $Campos[]= $finfo->name;        

     }

     //se inicia la tabla (aquí se pueden agregar diseños)   

     



     echo "<div id='collapse4' class='body'>";

     echo "<table id='DataTables2' class='table table-bordered table-condensed table-hover table-striped'>";

     //se crea el encabezado de la tabla

     echo "<thead>";

     echo "<tr>";

     for ($i=0;$i<$NumCampos;$i++){

         Printf ("<th scope='col'><center>%s</center></th>",$Campos[$i]);

     } 

     echo "</tr>";

     echo "</thead>";

     echo "<tbody>";

     echo "<tr>";



     //SE CREA 

       while($row = mysqli_fetch_array($val))

    {	

   for ($i=0;$i<$NumCampos;$i++)

         {         
          if($i==$h){
			  $pago = "";
			$query3 = "SELECT id, tipo_pago  FROM tbl_tipo_pago;";
			$data4 = $db->query($query3);
			while ($val4 = $db -> fetch_array($data4)) 
			{
				$pago = $pago."<option value='$val4[0]'>$val4[1]</option>";
			} 
			$categoria = "";
			$query2 = "SELECT (Select b.nombre from tbl_productos b where b.id =  a.producto ), a.cantidad, a.valor
					   FROM tbl_detalles_pedido a where a.id_pedido = '$row[0]'";
			$data3 = $db->query($query2);
			while ($val3 = $db -> fetch_array($data3)) 
			{
				$categoria = $categoria."<tr><td>".$val3[0]."</td><td>".$val3[1]."</td><td>$".number_format($val3[2], 2, '.', ',')."</td></tr>";
			} 
			$servicio=$db->HallaValorUnico("SELECT  porcentaje FROM tbl_parametros where tipo = 'Servicio' and estado = 1;");
			$totalservicio=($row[4]*$servicio)/100;
			$iva=$db->HallaValorUnico("SELECT  porcentaje FROM tbl_parametros where tipo = 'Iva' and estado = 1;");
			$totaliva=($row[4]*$iva)/100;
			$total=$totaliva+$totalservicio+$row[4];
            $resp = "<td><center><a href='aproductosp.php?id=".$row[0]."' class='btn btn-metis-6 btn-round btn-grad' title='Agregar productos'><i class='fa fa-plus' ></i></a>
					
					 <button type='button' class='btn btn-success btn-round btn-grad' data-toggle='modal' data-target='#mde_".$row[0]."' data-whatever='@mdo' title='Cobrar'><i class='fa fa-credit-card'></i></button>
					<div class='modal fade' id='mde_".$row[0]."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
					<div class='modal-dialog' role='document'>
					  <div class='modal-content bg-dark text-white'>
						<div class='modal-header'>
						  <h3 class='modal-title text-left' id='exampleModalLabel'>Cobrar</h3>                    
						</div> 
						<form action='cobrar.php' method='post' enctype='multipart/form-data'>
						<div class='modal-body'>          
						<label></label>     
							<div class='alert alert-success' role='alert'>
								<h3>Productos del pedido : $row[0] .</h3>
							</div>
							<div class='alert alert-info' role='alert'>
								<table class='table responsive-table'>
							<thead>
							<tr><th>Nombre</th><th>Cantidad</th><th>Valor</th></tr>
							</thead>
							<tbody>
							$categoria
							</tbody>
							</table>
							</div>
							<div class='alert alert-success' role='alert'>
								<h4>Sub Total : $ ".number_format($row[4], 2, '.', ',').".</h4>
							</div>
							<div class='alert alert-success' role='alert'>
							   <h5> <input class='form-check-input' type='checkbox'name='servicio' value='servicio' id='defaultCheck1' checked = 'true'> Incluir Servicio</input></h5>
								<h4>Servicio : $ ".number_format($totalservicio, 2, '.', ',').".</h4>
							</div>
							<div class='alert alert-success' role='alert'>
								<h4>Iva : $ ".number_format($totaliva, 2, '.', ',').".</h4>
							</div>
							<div class='alert alert-success' role='alert'>
								<h4>Total : $ ".number_format($total, 2, '.', ',').".</h4>
							</div>
							<div class='alert alert-success' role='alert'>
								<h4>Pago Con  :
								<select name='pago' required >
								<option value=''></option>
								$pago
								</select>
								Voucher
								<input type='text' name ='nvoucher' value=''>
								</h4>
							</div>
							<input type='hidden' name='id' value='".$row[0]."'>
							<input type='hidden' name ='tbl' value='pedidos'>        
						</div>                  
						<div class='modal-footer'>
						  <button type='button' class='btn btn-danger btn-grad' data-dismiss='modal'>Cancelar</button>
						  <button type='submit' class='btn btn-success btn-grad' id='btnenviar' name='btnenviar'>Cobrar</button>
						</div>
						</form>
					  </div>
					</div>
					</div>		
					
					<button type='button' class='btn btn-danger btn-round btn-grad' data-toggle='modal' data-target='#mdeim_".$row[0]."' data-whatever='@mdo'><i class='fa fa-trash'></i></button>
					<div class='modal fade' id='mdeim_".$row[0]."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
					<div class='modal-dialog' role='document'>
					  <div class='modal-content bg-dark text-white'>
						<div class='modal-header'>
						  <h3 class='modal-title text-left' id='exampleModalLabel'>Eliminar</h3>                    
						</div> 
						<form action='eliminar.php' method='post' enctype='multipart/form-data'>
						<div class='modal-body'>          
						<label></label>     
							<div class='alert alert-danger' role='alert'>
								¿Esta seguro de eliminar esta actividad?.
							</div>     
							<input type='hidden' name='id' value='".$row[0]."'>
							<input type='hidden' name ='tbl' value='pedido'>        
						</div>                  
						<div class='modal-footer'>
						  <button type='button' class='btn btn-danger btn-grad' data-dismiss='modal'>No</button>
						  <button type='submit' class='btn btn-success btn-grad' id='btnenviar' name='btnenviar'>Si</button>
						</div>
						</form>
					  </div>
					</div>
					</div>
					</center>
                    </td>
                    ";     

             echo $resp;



           }elseif($i==6){
            $queryint = $db->query("SELECT imagenes FROM tbl_productos where id = '".$row[0]."';");
            $data = $db -> fetch_array($queryint);
            $resp = "<td><center><img src='".$data[0]."' alt='' width='100'></center></td>";
             echo $resp;

           }else{  

            Printf ("<td><center>%s</center></td>",$row[$i]);          

        }   

                

 

         }      

        

     echo "</tr>";

    }

     echo "</tbody>";

     echo "</table>";    

     echo "</div>";

}

function tabla_productos_pedido($db,$id) {
	
    
	
	$consulta="SELECT a.id as 'ID', if( tipo=1, (SELECT b.nombre  FROM tbl_productos b where b.id = a.producto), (SELECT c.combo  FROM tbl_combo c where c.id = a.producto)) as 'Producto' , a.cantidad as 'Cantidad', concat('$',FORMAT(a.valor,2))  as 'Valor', '' as 'Herramientas' FROM tbl_detalles_pedido a where a.id_pedido = '$id';"; 

      

    //creamos el arreglo que contiene el nombre de los campos

    $Campos=array();

    $val= $db->query($consulta);

    //$val = mysqli_query($this->conexion,$consulta);

    //contamos las columnas

    $NumCampos =mysqli_num_fields($val);

     /* Obtener la información del campo de cada columna */

     while ($finfo = $val->fetch_field()) {

         $Campos[]= $finfo->name;        

     }

     //se inicia la tabla (aquí se pueden agregar diseños)   

     



     echo "<div id='collapse4' class='body'>";

     echo "<table id='DataTablesClientes' class='table table-bordered table-condensed table-hover table-striped'>";

     //se crea el encabezado de la tabla

     echo "<thead>";

     echo "<tr>";

     for ($i=0;$i<$NumCampos;$i++){

         Printf ("<th scope='col'><center>%s</center></th>",$Campos[$i]);

     } 

     echo "</tr>";

     echo "</thead>";

     echo "<tbody>";

     echo "<tr>";



     //SE CREA 

       while($row = mysqli_fetch_array($val))

    {	

   for ($i=0;$i<$NumCampos;$i++)

         {  
	   if($i==4){            
			  
            $resp = "<td>	<center>				
					 <button type='button' class='btn btn-danger btn-round btn-grad' data-toggle='modal' data-target='#mde_".$row[0]."' data-whatever='@mdo' title='Eliminar'><i class='fa fa-trash'></i></button>
					<div class='modal fade' id='mde_".$row[0]."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
					<div class='modal-dialog' role='document'>
					  <div class='modal-content bg-dark text-white'>
						<div class='modal-header'>
						  <h3 class='modal-title text-left' id='exampleModalLabel'>Eliminar</h3>                    
						</div> 
						<form action='eliminar.php' method='post' enctype='multipart/form-data'>
						<div class='modal-body'>          
						<label></label>     
							<div class='alert alert-danger' role='alert'>
								¿Esta seguro de eliminar esta actividad?.
							</div>     
							<input type='hidden' name='id' value='".$row[0]."'>
							<input type='hidden' name='idpedido' value='".$id."'>
							<input type='hidden' name ='tbl' value='productospedido'>        
						</div>                  
						<div class='modal-footer'>
						  <button type='button' class='btn btn-danger btn-grad' data-dismiss='modal'>No</button>
						  <button type='submit' class='btn btn-success btn-grad' id='btnenviar' name='btnenviar'>Si</button>
						</div>
						</form>
					  </div>
					</div>
					</div>		</center>			
                    </td>
                    ";     

             echo $resp;



           }else{
            Printf ("<td><center>%s</center></td>",$row[$i]);  
	   }
         }      

        

     echo "</tr>";

    }

     echo "</tbody>";

     echo "</table>";    

     echo "</div>";

}

function tabla_combos($db) {
	
		$consulta="SELECT id as 'ID', combo as 'Combo', valor as 'Valor', descripcion as 'Descripción', concat(".'"'."<img src='".'"'.",imagen,".'"'."' height='80'>".'"'.") as 'Imagen',	if(estado = 1, ".'"'."Activo".'"'.", ".'"'."Inactivo".'"'.") as 'Estado', '' as 'Herramientas'
			FROM tbl_combo;"; 
		$h=6; 

      

    //creamos el arreglo que contiene el nombre de los campos

    $Campos=array();

    $val= $db->query($consulta);

    //$val = mysqli_query($this->conexion,$consulta);

    //contamos las columnas

    $NumCampos =mysqli_num_fields($val);

     /* Obtener la información del campo de cada columna */

     while ($finfo = $val->fetch_field()) {

         $Campos[]= $finfo->name;        

     }

     //se inicia la tabla (aquí se pueden agregar diseños)   

     



     echo "<div id='collapse4' class='body'>";

     echo "<table id='DataTablesClientes' class='table table-bordered table-condensed table-hover table-striped'>";

     //se crea el encabezado de la tabla

     echo "<thead>";

     echo "<tr>";

     for ($i=0;$i<$NumCampos;$i++){

         Printf ("<th scope='col'><center>%s</center></th>",$Campos[$i]);

     } 

     echo "</tr>";

     echo "</thead>";

     echo "<tbody>";

     echo "<tr>";



     //SE CREA 

       while($row = mysqli_fetch_array($val))

    {	

   for ($i=0;$i<$NumCampos;$i++)

         {         
          if($i==$h){  
			  
			$categoria = "";
			$query2 = "SELECT  (Select b.nombre from tbl_productos b where b.id = a.id_producto ), (Select  b.valor_compra from tbl_productos b where b.id = a.id_producto ), a.cantidad , (Select b.cantidad from tbl_productos b where b.id = a.id_producto )
			FROM tbl_detalles_combo a where id_combo = '$row[0]'";
			$data3 = $db->query($query2);
			while ($val3 = $db -> fetch_array($data3)) 
			{
				$categoria = $categoria."<tr><td>".$val3[0]."</td><td>".$val3[1]."</td><td>".$val3[2]."</td><td>".$val3[3]."</td></tr>";
			}  	
			  
            $resp = "<td><center><a href='estado.php?id=".$row[0]."&tipo=combos' class='btn btn-metis-6 btn-round btn-grad' title='Cambiar estado'><i class='fa fa-edit'></i></a>
					
					 <button type='button' class='btn btn-success btn-round btn-grad' data-toggle='modal' data-target='#mde_".$row[0]."' data-whatever='@mdo' title='Ver Productos'><i class='fa fa-eye'></i></button>
					 
					<div class='modal fade' id='mde_".$row[0]."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
					<div class='modal-dialog' role='document'>
					  <div class='modal-content '>
						<div class='modal-header'>
						  <h3 class='modal-title text-left' id='exampleModalLabel'>Productos Combo: ".$row[1]." </h3>                    
						</div> 						
						<div class='modal-body'>          
						<label></label>   
							<table class='table responsive-table'>
							<thead>
							<tr><th>Nombre</th><th>Valor Compra</th><th>Cantidad combo</th><th>Cantidad inventario</th></tr>
							</thead>
							<tbody>
							$categoria
							</tbody>
							</table>
							       
						</div>                  
						<div class='modal-footer'>
						  <button type='button' class='btn btn-danger btn-grad' data-dismiss='modal'>Salir</button>						  
						</div>						
					  </div>
					</div>
					</div>					</center>
                    </td>
                    ";     

             echo $resp;



           }elseif($i==6){
            $queryint = $db->query("SELECT imagenes FROM tbl_productos where id = '".$row[0]."';");
            $data = $db -> fetch_array($queryint);
            $resp = "<td><center><img src='".$data[0]."' alt='' width='100'></center></td>";
             echo $resp;

           }else{  

            Printf ("<td><center>%s</center></td>",$row[$i]);          

        }   

                

 

         }      

        

     echo "</tr>";

    }

     echo "</tbody>";

     echo "</table>";    

     echo "</div>";

}

function tabla_ventas($db,$id) {
	
	$consulta="SELECT a.id as 'Id',(SELECT  b.mesa FROM tlb_mesas b where b.id =a.mesa)  as 'Mesa'
	, (SELECT concat(c.nombres,' ' ,c.apellidos) FROM tbl_usuarios c where c.id = a.asesor) as 'Asesor', (SELECT d.estado FROM tbl_estados_pedidos d where d.id =a.estado) as 'Estado', a.subtotal  as 'Sub Total'
		FROM tbl_pedidos a WHERE estado = 2;"; 
		$h=5;

    //creamos el arreglo que contiene el nombre de los campos

    $Campos=array();

    $val= $db->query($consulta);

    //$val = mysqli_query($this->conexion,$consulta);

    //contamos las columnas

    $NumCampos =mysqli_num_fields($val);

     /* Obtener la información del campo de cada columna */

     while ($finfo = $val->fetch_field()) {

         $Campos[]= $finfo->name;        

     }

     //se inicia la tabla (aquí se pueden agregar diseños)   

     



     echo "<div id='collapse4' class='body'>";

     echo "<table id='DataTablesClientes' class='table table-bordered table-condensed table-hover table-striped'>";

     //se crea el encabezado de la tabla

     echo "<thead>";

     echo "<tr>";

     for ($i=0;$i<$NumCampos;$i++){

         Printf ("<th scope='col'><center>%s</center></th>",$Campos[$i]);

     } 

     echo "</tr>";

     echo "</thead>";

     echo "<tbody>";

     echo "<tr>";



     //SE CREA 

       while($row = mysqli_fetch_array($val))

    {	

   for ($i=0;$i<$NumCampos;$i++)

         {         
          /*if($i==$h){
            $queryint = $db->query("SELECT nombre as 'Nombre', valor_compra as 'Valor Compra', valor_venta AS 'Valor Venta', cantidad AS 'Cantidad', categoria AS 'Categoria', imagenes FROM tbl_productos where id = '".$row[0]."';");
            $data = $db -> fetch_array($queryint);
			  
			$categoria = "";
			$query2 = "SELECT id , categoria FROM `tbl_categoria_productos`";
			$data3 = $db->query($query2);
			while ($val3 = $db -> fetch_array($data3)) 
			{
				$categoria = $categoria."<option  value=".$val3['categoria'].">".$val3['categoria']."</option>";
			}  	
			  
            $resp = "<td><center><a href='aproductosp.php?id=".$row[0]."' class='btn btn-metis-6 btn-round btn-grad'>Agregar productos</a>
					
					 <button type='button' class='btn btn-success btn-round btn-grad' data-toggle='modal' data-target='#mde_".$row[0]."' data-whatever='@mdo'>Cobrar</button>
					<div class='modal fade' id='mde_".$row[0]."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
					<div class='modal-dialog' role='document'>
					  <div class='modal-content bg-dark text-white'>
						<div class='modal-header'>
						  <h3 class='modal-title text-left' id='exampleModalLabel'>Cobrar</h3>                    
						</div> 
						<form action='cobrar.php' method='post' enctype='multipart/form-data'>
						<div class='modal-body'>          
						<label></label>     
							<div class='alert alert-danger' role='alert'>
								¿Esta seguro de eliminar esta actividad?.
							</div>     
							<input type='hidden' name='id' value='".$row[0]."'>
							<input type='hidden' name ='tbl' value='productos'>        
						</div>                  
						<div class='modal-footer'>
						  <button type='button' class='btn btn-danger btn-grad' data-dismiss='modal'>No</button>
						  <button type='submit' class='btn btn-success btn-grad' id='btnenviar' name='btnenviar'>Si</button>
						</div>
						</form>
					  </div>
					</div>
					</div>					</center>
                    </td>
                    ";     

             echo $resp;

           }else{*/

            Printf ("<td><center>%s</center></td>",$row[$i]);          

        //}   

                

 

         }      

        

     echo "</tr>";

    }

     echo "</tbody>";

     echo "</table>";    

     echo "</div>";

}

/*function tabla_ventasxls($db,$id,$fecha1,$fecha2){
	
	$consulta="SELECT a.id as 'Id',(SELECT  b.mesa FROM tlb_mesas b where b.id =a.mesa)  as 'Mesa'
	, (SELECT concat(c.nombres,' ' ,c.apellidos) FROM tbl_usuarios c where c.id = a.asesor) as 'Asesor', (SELECT d.estado FROM tbl_estados_pedidos d where d.id =a.estado) as 'Estado', a.subtotal  as 'Sub Total', fecha AS Fecha FROM tbl_pedidos a WHERE estado = 2 AND fecha BETWEEN '$fecha1' AND '$fecha2'
    "; 
	
	//$consulta="SELECT a.id as 'Id',(SELECT  b.mesa FROM tlb_mesas b where b.id =a.mesa)  as 'Mesa'
	//, (SELECT concat(c.nombres,' ' ,c.apellidos) FROM tbl_usuarios c where c.id = a.asesor) as 'Asesor', (SELECT d.estado FROM tbl_estados_pedidos d where d.id =a.estado) as 'Estado', a.subtotal  as 'Sub Total', fecha AS Fecha FROM tbl_pedidos a WHERE estado = 2 AND YEAR(fecha)=DATE_FORMAT(NOW(), '%Y') AND MONTH(fecha)=DATE_FORMAT(NOW(), '%m') AND DAY(fecha)=DATE_FORMAT(NOW(), '%d')
    //"; 
		$h=5;

    //creamos el arreglo que contiene el nombre de los campos

    $Campos=array();

    $val= $db->query($consulta);

    //$val = mysqli_query($this->conexion,$consulta);

    //contamos las columnas

    $NumCampos =mysqli_num_fields($val);

      //Obtener la información del campo de cada columna 

     while ($finfo = $val->fetch_field()) {

         $Campos[]= $finfo->name;        

     }

     //se inicia la tabla (aquí se pueden agregar diseños)   

     



     //echo "<div id='collapse4' class='body'>";

     echo "<table>";

     //se crea el encabezado de la tabla

     echo "<thead>";

     echo "<tr>";

     for ($i=0;$i<$NumCampos;$i++){

         Printf ("<th scope='col'><center>%s</center></th>",$Campos[$i]);

     } 

     echo "</tr>";

     echo "</thead>";

     echo "<tbody>";

     echo "<tr>";



     //SE CREA 

       while($row = mysqli_fetch_array($val))

    {	

   for ($i=0;$i<$NumCampos;$i++)

         {         
          if($i==$h){
            $queryint = $db->query("SELECT nombre as 'Nombre', valor_compra as 'Valor Compra', valor_venta AS 'Valor Venta', cantidad AS 'Cantidad', categoria AS 'Categoria', imagenes FROM tbl_productos where id = '".$row[0]."';");
            $data = $db -> fetch_array($queryint);
			  
			$categoria = "";
			$query2 = "SELECT id , categoria FROM `tbl_categoria_productos`";
			$data3 = $db->query($query2);
			while ($val3 = $db -> fetch_array($data3)) 
			{
				$categoria = $categoria."<option  value=".$val3['categoria'].">".$val3['categoria']."</option>";
			}  	
			  
            $resp = "<td><center><a href='aproductosp.php?id=".$row[0]."' class='btn btn-metis-6 btn-round btn-grad'>Agregar productos</a>
					
					 <button type='button' class='btn btn-success btn-round btn-grad' data-toggle='modal' data-target='#mde_".$row[0]."' data-whatever='@mdo'>Cobrar</button>
					<div class='modal fade' id='mde_".$row[0]."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
					<div class='modal-dialog' role='document'>
					  <div class='modal-content bg-dark text-white'>
						<div class='modal-header'>
						  <h3 class='modal-title text-left' id='exampleModalLabel'>Cobrar</h3>                    
						</div> 
						<form action='cobrar.php' method='post' enctype='multipart/form-data'>
						<div class='modal-body'>          
						<label></label>     
							<div class='alert alert-danger' role='alert'>
								¿Esta seguro de eliminar esta actividad?.
							</div>     
							<input type='hidden' name='id' value='".$row[0]."'>
							<input type='hidden' name ='tbl' value='productos'>        
						</div>                  
						<div class='modal-footer'>
						  <button type='button' class='btn btn-danger btn-grad' data-dismiss='modal'>No</button>
						  <button type='submit' class='btn btn-success btn-grad' id='btnenviar' name='btnenviar'>Si</button>
						</div>
						</form>
					  </div>
					</div>
					</div>					</center>
                    </td>
                    ";     

             echo $resp;

           }else{

            Printf ("<td><center>%s</center></td>",$row[$i]);          

        //}   

                

 

         }      

        

     echo "</tr>";

    }

     echo "</tbody>";

     echo "</table>";    

     echo "</div>";

} */

function tabla_ventasxsl2($db,$id,$fecha1,$fecha2){
	
	$consulta="SELECT a.id as 'Id',(SELECT  b.mesa FROM tlb_mesas b where b.id =a.mesa)  as 'Mesa'
	, (SELECT concat(c.nombres,' ' ,c.apellidos) FROM tbl_usuarios c where c.id = a.asesor) as 'Asesor', '' as 'Productos', a.subtotal  as 'Sub Total', fecha AS Fecha FROM tbl_pedidos a WHERE estado = 2 AND fecha BETWEEN '$fecha1' AND '$fecha2'
    "; 
	
	//$consulta="SELECT a.id as 'Id',(SELECT  b.mesa FROM tlb_mesas b where b.id =a.mesa)  as 'Mesa'
	//, (SELECT concat(c.nombres,' ' ,c.apellidos) FROM tbl_usuarios c where c.id = a.asesor) as 'Asesor', (SELECT d.estado FROM tbl_estados_pedidos d where d.id =a.estado) as 'Estado', a.subtotal  as 'Sub Total', fecha AS Fecha FROM tbl_pedidos a WHERE estado = 2 AND YEAR(fecha)=DATE_FORMAT(NOW(), '%Y') AND MONTH(fecha)=DATE_FORMAT(NOW(), '%m') AND DAY(fecha)=DATE_FORMAT(NOW(), '%d')
    //"; 
		$h=5;

    //creamos el arreglo que contiene el nombre de los campos

    $Campos=array();

    $val= $db->query($consulta);

    //$val = mysqli_query($this->conexion,$consulta);

    //contamos las columnas

    $NumCampos =mysqli_num_fields($val);

     /* Obtener la información del campo de cada columna */

     while ($finfo = $val->fetch_field()) {

         $Campos[]= $finfo->name;        

     }

     //se inicia la tabla (aquí se pueden agregar diseños)   

     



     //echo "<div id='collapse4' class='body'>";

     echo "<table border='1'>";

     //se crea el encabezado de la tabla

     echo "<thead>";

     echo "<tr>";

     for ($i=0;$i<$NumCampos;$i++){

         Printf ("<th scope='col'><center>%s</center></th>",$Campos[$i]);

     } 

     echo "</tr>";

     echo "</thead>";

     echo "<tbody>";

     echo "<tr>";



     //SE CREA 

       while($row = mysqli_fetch_array($val))

    {	

   for ($i=0;$i<$NumCampos;$i++)

         {         
          if($i==3){
            $queryint = $db->query("SELECT cantidad AS Cantidad, (SELECT nombre FROM tbl_productos WHERE id = a.producto) AS Productos FROM tbl_detalles_pedido AS a WHERE id_pedido = '".$row[0]."';");
            //$data = $db -> fetch_array($queryint);
			//echo "SELECT cantidad AS Cantidad, (SELECT nombre FROM tbl_productos WHERE id = a.producto) AS Productos FROM tbl_detalles_pedido AS a WHERE id = '".$row[0]."';";
			$ventas = "";
			//$data3 = $db->query($queryint);
			while ($val3 = $db -> fetch_array($queryint)) 
			{
				$ventas = $ventas."".$val3['Cantidad']." ".$val3['Productos']."<br>";
			}
			  
            $resp = "<td><center>$ventas</center>
                    </td>
                    ";     

             echo $resp;

           }else{

            Printf ("<td><center>%s</center></td>",$row[$i]);          

        }   

                

 

         }      

        

     echo "</tr>";

    }

     echo "</tbody>";

     echo "</table>";    

     echo "</div>";

}

function tabla_cajamenorxsl2($db,$id,$fecha1,$fecha2){
	
	if(!empty($_POST['nombre'])){
		$nombre = "b.asesor = (SELECT id FROM tbl_usuarios WHERE nombres = '".$_POST['nombre']."') AND ";
	}
	
	$consulta="SELECT id as 'ID', producto as 'Producto', (SELECT tipo_producto FROM tbl_tipo_producto WHERE id = a.tipo_producto) as 'Tipo Producto', valor AS 'Valor', fecha AS 'Fecha' FROM tbl_caja_menor as a WHERE $nombre a.fecha BETWEEN '$fecha1' AND '$fecha2'"; 
	
	//$consulta="SELECT a.id as 'Id',(SELECT  b.mesa FROM tlb_mesas b where b.id =a.mesa)  as 'Mesa'
	//, (SELECT concat(c.nombres,' ' ,c.apellidos) FROM tbl_usuarios c where c.id = a.asesor) as 'Asesor', (SELECT d.estado FROM tbl_estados_pedidos d where d.id =a.estado) as 'Estado', a.subtotal  as 'Sub Total', fecha AS Fecha FROM tbl_pedidos a WHERE estado = 2 AND YEAR(fecha)=DATE_FORMAT(NOW(), '%Y') AND MONTH(fecha)=DATE_FORMAT(NOW(), '%m') AND DAY(fecha)=DATE_FORMAT(NOW(), '%d')
    //"; 
		$h=5;

    //creamos el arreglo que contiene el nombre de los campos

    $Campos=array();

    $val= $db->query($consulta);

    //$val = mysqli_query($this->conexion,$consulta);

    //contamos las columnas

    $NumCampos =mysqli_num_fields($val);

     /* Obtener la información del campo de cada columna */

     while ($finfo = $val->fetch_field()) {

         $Campos[]= $finfo->name;        

     }

     //se inicia la tabla (aquí se pueden agregar diseños)   

     



     //echo "<div id='collapse4' class='body'>";

     echo "<table border='1'>";

     //se crea el encabezado de la tabla

     echo "<thead>";

     echo "<tr>";

     for ($i=0;$i<$NumCampos;$i++){

         Printf ("<th scope='col'><center>%s</center></th>",$Campos[$i]);

     } 

     echo "</tr>";

     echo "</thead>";

     echo "<tbody>";

     echo "<tr>";



     //SE CREA 

       while($row = mysqli_fetch_array($val))

    {	

   for ($i=0;$i<$NumCampos;$i++)

         {         
          /*if($i==3){
            $queryint = $db->query("SELECT cantidad AS Cantidad, (SELECT nombre FROM tbl_productos WHERE id = a.producto) AS Productos FROM tbl_detalles_pedido AS a WHERE id_pedido = '".$row[0]."';");
            //$data = $db -> fetch_array($queryint);
			//echo "SELECT cantidad AS Cantidad, (SELECT nombre FROM tbl_productos WHERE id = a.producto) AS Productos FROM tbl_detalles_pedido AS a WHERE id = '".$row[0]."';";
			$ventas = "";
			//$data3 = $db->query($queryint);
			while ($val3 = $db -> fetch_array($queryint)) 
			{
				$ventas = $ventas."".$val3['Cantidad']." ".$val3['Productos']."<br>";
			}
			  
            $resp = "<td><center>$ventas</center>
                    </td>
                    ";     

             echo $resp;

           }else{*/

            Printf ("<td><center>%s</center></td>",$row[$i]);          

        //}   

                

 

         }      

        

     echo "</tr>";

    }

     echo "</tbody>";

     echo "</table>";    

     echo "</div>";

}


function tabla_comisionesxsl2($db,$id,$fecha1,$fecha2){
	
	if(!empty($_POST['nombre'])){
		$nombre = "a.id_usuario = (SELECT id FROM tbl_usuarios WHERE nombres = '".$_POST['nombre']."') AND ";
	}
	//echo "SELECT a.id_usuario as 'ID', (SELECT  concat(c.nombres,' ', c.apellidos) FROM tbl_usuarios c where c.id=a.id_usuario) as 'Asesor', concat('$',FORMAT(sum(a.valor),2)) as 'Valor', a.fecha as 'Fecha' FROM tbl_comisiones AS a WHERE $nombre a.fecha BETWEEN '$fecha1' AND '$fecha2' group by a.id_usuario "; 
	
	$consulta="SELECT a.id_usuario as 'ID', (SELECT concat(c.nombres,' ', c.apellidos) FROM tbl_usuarios c where c.id=a.id_usuario) as 'Asesor', concat('$',FORMAT(sum(a.valor),2)) as 'Valor', a.fecha as 'Fecha' FROM tbl_comisiones AS a  WHERE $nombre a.fecha BETWEEN '$fecha1' AND '$fecha2' group by a.id_usuario"; 
	
	//$consulta="SELECT a.id as 'Id',(SELECT  b.mesa FROM tlb_mesas b where b.id =a.mesa)  as 'Mesa'
	//, (SELECT concat(c.nombres,' ' ,c.apellidos) FROM tbl_usuarios c where c.id = a.asesor) as 'Asesor', (SELECT d.estado FROM tbl_estados_pedidos d where d.id =a.estado) as 'Estado', a.subtotal  as 'Sub Total', fecha AS Fecha FROM tbl_pedidos a WHERE estado = 2 AND YEAR(fecha)=DATE_FORMAT(NOW(), '%Y') AND MONTH(fecha)=DATE_FORMAT(NOW(), '%m') AND DAY(fecha)=DATE_FORMAT(NOW(), '%d')
    //"; 
		$h=5;

    //creamos el arreglo que contiene el nombre de los campos

    $Campos=array();

    $val= $db->query($consulta);

    //$val = mysqli_query($this->conexion,$consulta);

    //contamos las columnas

    $NumCampos =mysqli_num_fields($val);

     /* Obtener la información del campo de cada columna */

     while ($finfo = $val->fetch_field()) {

         $Campos[]= $finfo->name;        

     }

     //se inicia la tabla (aquí se pueden agregar diseños)   

     



     //echo "<div id='collapse4' class='body'>";

     echo "<table border='1'>";

     //se crea el encabezado de la tabla

     echo "<thead>";

     echo "<tr>";

     for ($i=0;$i<$NumCampos;$i++){

         Printf ("<th scope='col'><center>%s</center></th>",$Campos[$i]);

     } 

     echo "</tr>";

     echo "</thead>";

     echo "<tbody>";

     echo "<tr>";



     //SE CREA 

       while($row = mysqli_fetch_array($val))

    {	

   for ($i=0;$i<$NumCampos;$i++)

         {         
          /*if($i==3){
            $queryint = $db->query("SELECT cantidad AS Cantidad, (SELECT nombre FROM tbl_productos WHERE id = a.producto) AS Productos FROM tbl_detalles_pedido AS a WHERE id_pedido = '".$row[0]."';");
            //$data = $db -> fetch_array($queryint);
			//echo "SELECT cantidad AS Cantidad, (SELECT nombre FROM tbl_productos WHERE id = a.producto) AS Productos FROM tbl_detalles_pedido AS a WHERE id = '".$row[0]."';";
			$ventas = "";
			//$data3 = $db->query($queryint);
			while ($val3 = $db -> fetch_array($queryint)) 
			{
				$ventas = $ventas."".$val3['Cantidad']." ".$val3['Productos']."<br>";
			}
			  
            $resp = "<td><center>$ventas</center>
                    </td>
                    ";     

             echo $resp;

           }else{*/

            Printf ("<td><center>%s</center></td>",$row[$i]);          

        //}   

                

 

         }      

        

     echo "</tr>";

    }

     echo "</tbody>";

     echo "</table>";    

     echo "</div>";

}


function tabla_comisiones($db) {

    $consulta="SELECT a.id_usuario as 'ID', (SELECT  concat(c.nombres,' ', c.apellidos) FROM tbl_usuarios c where c.id=a.id_usuario) as 'Asesor', concat('$',FORMAT(sum(a.valor),2)) as 'Valor', a.fecha as 'Fecha', '' as 'Pagar'
FROM tbl_comisiones a   group by a.id_usuario;";   

    //creamos el arreglo que contiene el nombre de los campos

    $Campos=array();

    $val= $db->query($consulta);

    //$val = mysqli_query($this->conexion,$consulta);

    //contamos las columnas

    $NumCampos =mysqli_num_fields($val);

     /* Obtener la información del campo de cada columna */

     while ($finfo = $val->fetch_field()) {

         $Campos[]= $finfo->name;        

     }

     //se inicia la tabla (aquí se pueden agregar diseños)   

     



     echo "<div id='collapse4' class='body'>";

     echo "<table id='DataTablesClientes' class='table table-bordered table-condensed table-hover table-striped'>";

     //se crea el encabezado de la tabla

     echo "<thead>";

     echo "<tr>";

     for ($i=0;$i<$NumCampos;$i++){

         Printf ("<th scope='col'><center>%s</center></th>",$Campos[$i]);

     } 

     echo "</tr>";

     echo "</thead>";

     echo "<tbody>";

     echo "<tr>";



     //SE CREA 

       while($row = mysqli_fetch_array($val))

    {	

   for ($i=0;$i<$NumCampos;$i++)

         {         
          if($i==4 ){
            $categoria = "";
			$query2 = "SELECT id, concat(nombres,' ', apellidos)  FROM tbl_usuarios where estado = 1;";
			$data3 = $db->query($query2);
			while ($val3 = $db -> fetch_array($data3)) 
			{
				$categoria = $categoria."<option value='$val3[0]'>$val3[1]</option>";
			} 
            $resp = "<td><center>
					<a href='pagar.php?idusr=$row[0]&fecha=$row[3]' class='btn btn-warning btn-round btn-grad' title='Pagar'><i class='fa fa-credit-card' aria-hidden='true'></i></a>					
					 	</center>			
                    </td>
                    ";    

             echo $resp;



           }else{  



            Printf ("<td><center>%s</center></td>",$row[$i]);          



        }   

                

 

         }      

        

     echo "</tr>";

    }

     echo "</tbody>";

     echo "</table>";    

     echo "</div>";

}

function tabla_ingresos($db) {

    $consulta="SELECT id as 'ID', documento as 'Datos', carnetcovid as 'Carnet Covid', fecha as 'Fecha',  img as 'Imagen' FROM tbl_ingresos;";   

    //creamos el arreglo que contiene el nombre de los campos

    $Campos=array();

    $val= $db->query($consulta);

    //$val = mysqli_query($this->conexion,$consulta);

    //contamos las columnas

    $NumCampos =mysqli_num_fields($val);

     /* Obtener la información del campo de cada columna */

     while ($finfo = $val->fetch_field()) {

         $Campos[]= $finfo->name;        

     }

     //se inicia la tabla (aquí se pueden agregar diseños)   

     



     echo "<div id='collapse4' class='body'>";

     echo "<table id='DataTablesClientes' class='table table-bordered table-condensed table-hover table-striped'>";

     //se crea el encabezado de la tabla

     echo "<thead>";

     echo "<tr>";

     for ($i=0;$i<$NumCampos;$i++){

         Printf ("<th scope='col'><center>%s</center></th>",$Campos[$i]);

     } 

     echo "</tr>";

     echo "</thead>";

     echo "<tbody>";

     echo "<tr>";



     //SE CREA 

       while($row = mysqli_fetch_array($val))

    {	

   for ($i=0;$i<$NumCampos;$i++)

         {         
          if($i==4 ){
			  	Printf ("<td><center><img src='data:image/png;base64, %s' alt='Img' height='50' /></center></td>",$row[$i]);
           }else{  
            Printf ("<td><center>%s</center></td>",$row[$i]);   
        }   

                

 

         }      

        

     echo "</tr>";

    }

     echo "</tbody>";

     echo "</table>";    

     echo "</div>";

}

function tabla_alertas($db) {

    $consulta="SELECT id as 'Id', cantidad as 'Cantidad de Productos', if(prioridad=3,'Nivel bajo', if(prioridad=2,'nivel Medio',if(prioridad=1,'nivel alto','')))  as 'Nivel de la alerta', '' as 'Editar'
	FROM tbl_alertas_producto;";   

    //creamos el arreglo que contiene el nombre de los campos

    $Campos=array();

    $val= $db->query($consulta);

    //$val = mysqli_query($this->conexion,$consulta);

    //contamos las columnas

    $NumCampos =mysqli_num_fields($val);

     /* Obtener la información del campo de cada columna */

     while ($finfo = $val->fetch_field()) {

         $Campos[]= $finfo->name;        

     }

     //se inicia la tabla (aquí se pueden agregar diseños)   

     



     echo "<div id='collapse4' class='body'>";

     echo "<table id='DataTablesClientes' class='table table-bordered table-condensed table-hover table-striped'>";

     //se crea el encabezado de la tabla

     echo "<thead>";

     echo "<tr>";

     for ($i=0;$i<$NumCampos;$i++){

         Printf ("<th scope='col'><center>%s</center></th>",$Campos[$i]);

     } 

     echo "</tr>";

     echo "</thead>";

     echo "<tbody>";

     echo "<tr>";



     //SE CREA 

       while($row = mysqli_fetch_array($val))

    {	

   for ($i=0;$i<$NumCampos;$i++)

         {         
          if($i==3 ){
            
            $resp = "<td><center><button type='button' class='btn btn-primary btn-round btn-grad ' data-toggle='modal' data-target='#md_".$row[0]."' data-whatever='@mdo'><i class='fa fa-edit'></i></button>              
                    <div class='modal fade' id='md_".$row[0]."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                    <div class='modal-dialog' role='document'>
                    <div class='modal-content bg-dark text-white'>
                        <div class='modal-header'>
                        <h3 class='modal-title text-left' id='exampleModalLabel'>Editar cantidad de produtos</h3>                    
                        </div> 
                        <form action='editar.php' method='post' enctype='multipart/form-data'>
                        <div class='modal-body'>          
                        <label></label>     
							<div class='form-group'>
								<label for='recipient-name' class='col-form-label'>Cantidad de productos:</label>
								<input class='form-control' type='number' name ='Nproducto' id='Nproducto' placeholder='Ingrese la cantidad de produtos' value='".$row[1]."' required/>
							</div> 
                           
                            <input type='hidden' name='id' value='".$row[0]."'>
                            <input type='hidden' name ='tbl' value='alertas'>        
                        </div>                  
                        <div class='modal-footer'>
                        <button type='button' class='btn btn-danger btn-grad' data-dismiss='modal'>Cancelar</button>
                        <button type='submit' class='btn btn-success btn-grad' id='btnenviar' name='btnenviar'>Enviar</button>
                        </div>
                        </form>
                    </div>
                    </div>
                    </div>
					
					 		</center>			
                    </td>
                    ";     

             echo $resp;



           }else{  



            Printf ("<td><center>%s</center></td>",$row[$i]);          



        }   

                

 

         }      

        

     echo "</tr>";

    }

     echo "</tbody>";

     echo "</table>";    

     echo "</div>";

}

//===========================INICIO FUNCIONES BASE=========================//

function CerrarSesion(){

	session_destroy();
	header("Location: ../login.php");

}

function CargaImagen($db, $tipo, $ubic){
	$img = $db->HallaValorUnico("SELECT url FROM tbl_media WHERE tipo = '$tipo' AND ubicacion = '$ubic'");
	echo $img;
}

function ValidarSesion2(){
	if(empty($_SESSION['id'])){
		echo "<script>window.location.replace('login.php');</script>";
	}
}

function ValidarSesion($id){
	if(!empty($_SESSION['id'])){
		echo "<script>window.location.replace('index.php');</script>";
	}
	if(!empty($id)){
		if(!empty($_SESSION['id'])){
			//echo "<script>window.location.replace('index.php');</script>";
		}else{
			echo "<script>window.location.replace('login.php');</script>";
		}
	}
}

function IniciarSesion($db,$usuario,$clave){
	
	//Se validan que los datos esten llegando
	
	if(!empty($usuario) && !empty($clave)){
		
		$pass1= Enc('enc', $clave);
		$despass=Enc('dec', $pass1);
		$val = $db->HallaValorUnico("SELECT id FROM tbl_usuarios WHERE usuario = '$usuario' AND pass = '$pass1'");				//SE CONSULTA SI CON LOS DATOS DE INICIO SI EXISTE UN USUARIO
		
		if(!empty($val)){																										//SI EXISTE SE CREAN LAS VARIALBES DE SESION Y SE REDIRECCIONA AL INDEX
			$_SESSION['id']= $val;
			$_SESSION['usuario']= $usuario;
			echo "<script>window.location.replace('index.php');</script>";
		}else{
			echo "<script>alert('Datos incorrectos')</script>";
		}
	}
	
}

