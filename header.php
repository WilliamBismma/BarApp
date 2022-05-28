<?php
include('lib/funciones.php');
include("lib/conex.php");
session_start();
$db = new MySQL();
$id = $_SESSION['id'];
ValidarSesion2();

if($_POST['val'] == "cerrar" || $_GET['val'] == "cerrar"){
	CerrarSesion();
}

$pagina = "admin";
$perfil= $db->HallaValorUnico("SELECT perfil FROM tbl_usuarios where id = $id;");
$permisos =$db->HallaValorUnico("SELECT  permisos FROM tbl_permisos where perfil = $perfil");
if($permisos==""){
	$permisos="1";	
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
    <title>BAR</title>
    
    <meta name="description" content="">
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
	
	 <link rel="stylesheet" href="/assets/lib/inputlimiter/jquery.inputlimiter.css">
        <link rel="stylesheet" href="/assets/lib/bootstrap-daterangepicker/daterangepicker-bs3.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/Uniform.js/2.1.2/themes/default/css/uniform.default.min.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/chosen/1.1.0/chosen.min.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-tagsinput/1.3.3/jquery.tagsinput.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.2/css/bootstrap3/bootstrap-switch.min.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.1/css/datepicker3.min.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.0.1/css/bootstrap-colorpicker.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.5/fullcalendar.min.css">
	<script src="https://kit.fontawesome.com/96b491a5a7.js" crossorigin="anonymous"></script>
	

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

    <!--For Development Only. Not required -->
    <script>
        less = {
            env: "development",
            relativeUrls: false,
            rootpath: "/assets/"
        };
    </script>
    <link rel="stylesheet" href="assets/css/style-switcher.css">
    <link rel="stylesheet/less" type="text/css" href="assets/less/theme.less">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/less.js/2.7.1/less.js"></script>

  </head>

        <body class="  " style="background-color: #3a3a3a !important;">
            <div class="bg-dark dk" id="wrap">
                <div id="top">
                    <!-- .navbar -->
                    <nav class="navbar navbar-inverse navbar-static-top">
                        <div class="container-fluid">
                    
                    
                            <!-- Brand and toggle get grouped for better mobile display -->
                            <header class="navbar-header">
                    
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <a href="index.html" class="navbar-brand"><img src="assets/img/logo.png" alt=""></a>                    
                            </header>
                    
                    
                    
                            <div class="topnav">
                                <!--<div class="btn-group">
                                    <a data-placement="bottom" data-original-title="Fullscreen" data-toggle="tooltip"
                                       class="btn btn-default btn-sm" id="toggleFullScreen">
                                        <i class="glyphicon glyphicon-fullscreen"></i>
                                    </a>
                                </div>
                                <div class="btn-group">
                                    <a data-placement="bottom" data-original-title="E-mail" data-toggle="tooltip"
                                       class="btn btn-default btn-sm">
                                        <i class="fa fa-envelope"></i>
                                        <span class="label label-warning">5</span>
                                    </a>
                                    <a data-placement="bottom" data-original-title="Messages" href="#" data-toggle="tooltip"
                                       class="btn btn-default btn-sm">
                                        <i class="fa fa-comments"></i>
                                        <span class="label label-danger">4</span>
                                    </a>
                                    <a data-toggle="modal" data-original-title="Help" data-placement="bottom"
                                       class="btn btn-default btn-sm"
                                       href="#helpModal">
                                        <i class="fa fa-question"></i>
                                    </a>
                                </div>-->
                                <div class="btn-group">
									<form action="" method="post">
										<input type="hidden" name="val" value="cerrar">
										<button data-toggle="tooltip" data-original-title="Logout" data-placement="bottom" class="btn btn-metis-1 btn-sm" type="submit">
											<i class="fa fa-power-off"></i>
										</button>
									</form>
                                </div>
                                <div class="btn-group">
                                    <a data-placement="bottom" data-toggle="tooltip"
                                       class="btn btn-primary btn-sm toggle-left" id="menu-toggle">
                                        <i class="fa fa-bars"></i>
                                    </a>
                                    <!--<a href="#right" data-toggle="onoffcanvas" class="btn btn-default btn-sm" aria-expanded="false">
                                        <span class="fa fa-fw fa-comment"></span>
                                    </a>-->
                                </div>
                    
                            </div>
                    
                    
                    
                    
                            <div class="collapse navbar-collapse navbar-ex1-collapse">
                    
                                <!-- .nav -->
                                <ul class="nav navbar-nav">
									<?php $minmenu1 = $db->query("SELECT id, principal,  nombre, link FROM tbl_menu where id in ($permisos)and id in (1,13,14,15,16,17,18,19,4) and submenu = 0 ");
									while ($datosmin1 = $db -> fetch_array($minmenu1)) 
									{ 
										if($datosmin1[3]=="#"){
											?>
									<li class='dropdown '>
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                            <?php echo $datosmin1[2]; ?> <b class="caret"></b>
                                        </a>
                                        <ul class="dropdown-menu">
											<?php
										$menumini2 = $db->query("SELECT id,  nombre, link FROM tbl_menu where id in ($permisos) and principal = '$datosmin1[1]' and submenu > 0");
										while ($datosmini2 = $db -> fetch_array($menumini2)) 
										{
											?>
											<li><a href="<?php echo $datosmini2[2]; ?>"><?php echo $datosmini2[1]; ?></a></li>
											<?php
										}
										?>                                           
                                        </ul>
                                    </li>
									<?php
										}else{
											?>
									<li><a href="<?php echo $datosmin1[3]; ?>"><?php echo $datosmin1[2]; ?></a></li>
									<?php
										}
									
									}  ?>                                                                      
									
                                </ul>
                                <!-- /.nav -->
                            </div>
                        </div>
                        <!-- /.container-fluid -->
                    </nav>
                    <!-- /.navbar -->
                        <header class="head">
                                <div class="search-bar">
                                    <!--<form class="main-search" action="">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Live Search ...">
                                            <span class="input-group-btn">
                                                <button class="btn btn-primary btn-sm text-muted" type="button">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </form>-->
                                    <!-- /.main-search -->                                </div>
                                <!-- /.search-bar -->
                            <div class="main-bar">
                                <h3>
              <i class="fa fa-home"></i>&nbsp;
            Bar
          </h3>
                            </div>
                            <!-- /.main-bar -->
                        </header>
                        <!-- /.head -->
                </div>
                <!-- /#top -->
                    <div id="left">
                        <div class="media user-media bg-dark dker">
                            <div class="user-media-toggleHover">
                                <span class="fa fa-user"></span>
                            </div>
                            <div class="user-wrapper bg-dark">
                                <a class="user-link" href="index.php">
                                    <img class="media-object img-thumbnail user-img" alt="User Picture" src="<?php CargaImagen($db, 'logo', $pagina); ?>" width="100">
                                 <!--CANTIDAD DE NOTIFICACIONES   <span class="label label-danger user-label">16</span>-->
                                </a>
                        
                                <div class="media-body">
                                    <h5 class="media-heading"><?php $nombre = $db->HallaValorUnico("SELECT nombres FROM tbl_usuarios WHERE id = '$id'"); echo "Nombre: ".$nombre;?></h5>
                                    <ul class="list-unstyled user-info">
                                        <li><a href=""><?php $perfil = $db->HallaValorUnico("SELECT (SELECT perfiles FROM tlb_perfiles WHERE id = a.perfil) AS perfil FROM tbl_usuarios AS a WHERE id = '$id'"); echo "Cargo: ".$perfil;?></a></li>
                                        <!--<li>Ultimo Acceso : <br>
                                            <small><i class="fa fa-calendar"></i>&nbsp;16 Mar 16:32</small>
                                        </li>-->
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- #menu -->
                        <ul id="menu" class="bg-blue dker">
                                  <li class="nav-header">Menu</li>
                                  <li class="nav-divider"></li>
                                  
								   <?php									  						
									  $menu1 = $db->query("SELECT id, fainco, principal, nombre, link 
										FROM  tbl_menu where id in ($permisos) and submenu = 0;");
									while ($datos1 = $db -> fetch_array($menu1)) 
									{
										if($datos1[4]=="#"){
											?> 
							<li class="">
                                    <a href="javascript:;">
                                      <i class="<?php echo $datos1[1]; ?>"></i>
                                      <span class="link-title"><?php echo $datos1[3]; ?></span>
                                      <span class="fa arrow"></span>
                                    </a>
                                    <ul class="collapse">
										<?php
										$menu2 = $db->query("SELECT id, fainco, nombre, link FROM tbl_menu where id in ($permisos) and principal = '$datos1[2]' and submenu > 0");
										while ($datos2 = $db -> fetch_array($menu2)) 
										{
										?>
										<li>
											<a href="<?php echo $datos2[3]; ?>">
											  <i class="<?php echo $datos2[1]; ?>"></i>&nbsp; <?php echo $datos2[2]; ?> </a>
										  </li>
										<?php
										}
										?>
                               
                                    </ul>
                                  </li>							
									<?php
											
										}else{
										?>
									   <li class="">
										<a href="<?php echo $datos1[4]; ?>">
										  <i class="<?php echo $datos1[1]; ?>"></i><span class="link-title">&nbsp;<?php echo $datos1[3]; ?></span>
										</a>
									  </li>
									  <?php
										}

									}
									  ?>
							
                                  <li>
                                    <a href="index.php?val=cerrar">
                                      <i class="fa fa-sign-in"></i>
                                   		<span class="link-title">
									  		Cerrar Sesión
										</span>
                                    </a>
                                  </li>
                                </ul>
                        <!-- /#menu -->
                    </div>