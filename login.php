<?php
session_start();

	include("lib/conex.php");
	$db = new MySQL();
	include('lib/funciones.php');
	$pagina = "login";

	$id = $_SESSION['id'];
	ValidarSesion($id);


	if(!empty($_POST)){
		IniciarSesion($db,$_POST['usuario'],$_POST['clave']);
	}
	

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!--IE Compatibility modes-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--Mobile first-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Login</title>
    
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

    <div class="form-signin">
		<div class="text-center">
			<img src="<?php CargaImagen($db, 'Logo', $pagina); ?>" alt="Metis Logo" height="100">
		</div>
		<hr>
		<div class="tab-content">
			<div id="login" class="tab-pane active">
				<form action="login.php" method="post">
					<p class="text-muted text-center">
						Ingresa tu usuario y tu contraseña
					</p>
					<input type="text" name="usuario" placeholder="Usuario" class="form-control top">
					<input type="password" name="clave" placeholder="Contraseña" class="form-control bottom">
					<div class="checkbox">
			  <label>
				<input type="checkbox"> Recordar
			  </label>
			</div>
					<button class="btn btn-lg btn-primary btn-block" type="submit">Iniciar Sesión</button>
				</form>
			</div>

			<div id="forgot" class="tab-pane">
				<form action="login.php">
					<p class="text-muted text-center">Enter your valid e-mail</p>
					<input type="email" placeholder="mail@domain.com" class="form-control">
					<br>
					<button class="btn btn-lg btn-danger btn-block" type="submit">Recover Password</button>
				</form>
			</div>
		</div>
		<hr>
		<div class="text-center">
			<ul class="list-inline">
				<li><a class="text-muted" href="#login" data-toggle="tab">Login</a></li>
				<li><a class="text-muted" href="#forgot" data-toggle="tab">¿Olvidaste tu contraseña?</a></li>
			</ul>
		</div>
  </div>


    <!--jQuery -->
    <script src="assets/lib/jquery/jquery.js"></script>

    <!--Bootstrap -->
    <script src="assets/lib/bootstrap/js/bootstrap.js"></script>


    <script type="text/javascript">
        (function($) {
            $(document).ready(function() {
                $('.list-inline li > a').click(function() {
                    var activeForm = $(this).attr('href') + ' > form';
                    //console.log(activeForm);
                    $(activeForm).addClass('animated fadeIn');
                    //set timer to 1 seconds, after that, unload the animate animation
                    setTimeout(function() {
                        $(activeForm).removeClass('animated fadeIn');
                    }, 1000);
                });
            });
        })(jQuery);
    </script>
</body>

</html>
