<?php
session_start();

	include("lib/conex.php");
	$db = new MySQL();
	include('lib/funciones.php');
	$pagina = "reserva";

	$id = $_SESSION['id'];

	if(!empty($_GET)){
		echo "<script>alert('Su reserva a sido agendada, nuestro personal se comunicara con usted para confirmarla')</script>";
	}

?>
<!doctype html>

<html>
<head>
    <meta charset="UTF-8">
    <!--IE Compatibility modes-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--Mobile first-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Reservas</title>
    
    <meta name="description" content="Free Admin Template Based On Twitter Bootstrap 3.x">
    <meta name="author" content="">
    
    <meta name="msapplication-TileColor" content="#5bc0de" />
    <meta name="msapplication-TileImage" content="assets/img/metis-tile.png" />
    
    <!-- Bootstrap -->
    <link rel="stylesheet" href="assets/lib/bootstrap/css/bootstrap.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/lib/font-awesome/css/font-awesome.css">
    
    <!-- Metis core stylesheet -->
    <link rel="stylesheet" href="assets/css/main.css">
    
    <!-- metisMenu stylesheet -->
    <link rel="stylesheet" href="assets/lib/metismenu/metisMenu.css">
    
    <!-- onoffcanvas stylesheet -->
    <link rel="stylesheet" href="assets/lib/onoffcanvas/onoffcanvas.css">
    
    <!-- animate.css stylesheet -->
    <link rel="stylesheet" href="assets/lib/animate.css/animate.css">

</head>
<body class="login" style="background: url('<?php CargaImagen($db, 'fondo', $pagina); ?>') repeat #444; background-repeat: no-repeat; background-position: center center; background-attachment: fixed; background-size: cover;">

	<div class="form-signin row" style="max-width: 630px; position: absolute; top: 20px; left: 25%">
		<div class="text-center">
			<img src="<?php CargaImagen($db, 'Logo', $pagina); ?>" alt="Metis Logo">
		</div>
		<hr>
		<div class="tab-content" style="max-width: 650px!important">
			<div id="login" class="tab-pane active">
				<form action="agregar.php" method="post">
					<p class="text-muted text-center">
						Ingresa tus datos para la reservacion
					</p>
					<div class="form-group col-lg-6">
						<label for="input1">Nombres</label>
						<input type="text" class="form-control" id="input1" placeholder="Nombres y apellidos completos" name="nombre">
					</div>

				  <div class="form-group col-lg-6">
					<label for="input2">Cedula</label>
					<input type="number" class="form-control" id="input2" placeholder="Numero de cedula" name="cedula">
				  </div>

				  <div class="form-group col-lg-12">
					<label for="input2">Fecha de la reservación</label>
					<input type="datetime-local" class="form-control" id="input2" placeholder="" name="fecha">
				  </div>

				  <div class="form-group col-lg-6">
					<label for="input2">Cantidad de personas que asistiran</label>
					<input type="number" class="form-control" id="input2" name="can_personas" placeholder="personas que asistiran">
				  </div>

				  <div class="form-group col-lg-6">
					<label for="input2">Observacion adicional</label>
					<input type="text" class="form-control" id="input2" name="observaciones" placeholder="Alguna observación adicional?">
				  </div>

				  <input type='hidden' name ='tbl' value='reservasusu'>
				  <input type='hidden' name ='est' value='Pendiente'>
				
				  <button class="btn btn-lg btn-primary btn-block" type="submit">Generar Reserva</button>
				</form>
			</div>
		</div>
		<hr>
  </div>
	
<?php
	include("footer.php");
?>