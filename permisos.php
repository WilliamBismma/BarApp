<?php
include("header.php");

$idperfil=$_GET['idperfil'];
?>

<div id="content">
	<div class="outer">
		<div class="inner bg-light lter">
		<!--Begin Datatables-->
		<div class="text-center">
		<br>			
			<!--<button type="button" class="btn btn-metis-6 btn-lg btn-grad btn-rect" data-toggle='modal' data-target='#add' data-whatever='@mdo'>
                                <i class="fa fa-archive"></i>&nbsp; Agregar</button>  -->
			
			</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="box">
				<header>
					<div class="icons"><i class="fa fa-table"></i></div>
					<?php $perfil = $db->HallaValorUnico("SELECT perfiles FROM tlb_perfiles  where id = '$idperfil';") ?>    
					<h5>Ajuste los permisos del perfil: <?php echo $perfil; ?></h5>
				</header>
 

    <!-- start checkboxTree configuration -->
    <script type="text/javascript" src="checbox/library/jquery-1.4.4.js"></script>
    <script type="text/javascript" src="checbox/library/jquery-ui-1.8.12.custom/js/jquery-ui-1.8.12.custom.min.js"></script>
    <link rel="stylesheet" type="text/css"
          href="checbox/library/jquery-ui-1.8.12.custom/css/smoothness/jquery-ui-1.8.12.custom.css"/>

    <script type="text/javascript" src="checbox/jquery.checkboxtree.js"></script>
    <link rel="stylesheet" type="text/css" href="checbox/jquery.checkboxtree.css"/>
    <!-- end checkboxTree configuration -->

    <script type="text/javascript" src="checbox/library/jquery.cookie.js"></script>
    <script type="text/javascript">
        //<!--
        $(document).ready(function() {
            $('#tabs').tabs({
                cookie: { expires: 30 }
            });
            $('.jquery').each(function() {
                eval($(this).html());
            });
            $('.button').button();
        });
        //-->
    </script>
<div id="tabs-1">
	<form action="permisos2.php" method="post">
    <ul id="tree1">
		
		<?php
	$menu1 = $db->query("SELECT id, principal,  nombre, link FROM tbl_menu where submenu= 0  and id> 1;");
	while ($datos1 = $db -> fetch_array($menu1)) 
	{
		if($datos1[3]=="#"){
			$activo=$db->HallaValorUnico("SELECT count(id) FROM tbl_permisos where perfil = '$idperfil' and permisos like '%,$datos1[0],%' or perfil = '$idperfil' and permisos like '%,$datos1[0]';");
			if($activo!=0){
				?>
		<li><input name='opcionesmenu[]' value='<?php echo $datos1[0]; ?>' type='checkbox' checked > <label><?php echo $datos1[2]; ?></label>
		<?php
			}else{
			?>
		<li><input name='opcionesmenu[]' value='<?php echo $datos1[0]; ?>' type='checkbox' > <label><?php echo $datos1[2]; ?></label>
		<?php	
			}
			?>		
		<ul>
		
		<?php
			
			$menu2 = $db->query("SELECT id,  nombre FROM tbl_menu where principal = '$datos1[1]' and submenu > 0");
			while ($datos2 = $db -> fetch_array($menu2)) 
			{
					$activo=$db->HallaValorUnico("SELECT count(id) FROM tbl_permisos where perfil = '$idperfil' and permisos like '%,$datos2[0],%' or perfil = '$idperfil' and permisos like '%,$datos2[0]';");
			if($activo!=0){
					?>
			<li><input name='opcionesmenu[]' value='<?php echo $datos2[0]; ?>' type='checkbox' checked > <label><?php echo $datos2[1]; ?></label></li>
			<?php
				}else{
				?>
			<li><input name='opcionesmenu[]' value='<?php echo $datos2[0]; ?>' type='checkbox' > <label><?php echo $datos2[1]; ?></label></li>
			<?php	
				}

				
			}
			?>
		</ul>
		</li>
		<?php
		}else{
		$activo=$db->HallaValorUnico("SELECT count(id) FROM tbl_permisos where perfil = '$idperfil' and permisos like '%,$datos1[0],%' or perfil = '$idperfil' and permisos like '%,$datos1[0]';");
			if($activo!=0){
				?>
		<li><input name='opcionesmenu[]' value='<?php echo $datos1[0]; ?>' type='checkbox' checked > <label><?php echo $datos1[2]; ?></label></li>
		<?php
			}else{
			?>
		<li><input name='opcionesmenu[]' value='<?php echo $datos1[0]; ?>' type='checkbox' > <label><?php echo $datos1[2]; ?></label></li>
		<?php	
			}
			
		}
		
	}
		?>
		
    </ul>
		<input type='hidden' name='perfil' value='<?php  echo $idperfil; ?>'>
		<button type='submit' class='btn btn-success btn-grad' id='btnenviar' name='btnenviar'>Guardar</button>
	</form>
</div>
			
					
<script type="text/javascript">   
	$('#tree1').checkboxTree({initializeUnchecked:'collapsed'});
</script>
					
					
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
