<?php
include("header.php");
?>
<div id="content">
	<div class="outer">
		<div class="inner bg-light lter">
		<div class="row">
<div class="col-lg-6">
    <div class="box dark">
        <header>
            <div class="icons"><i class="fa fa-plus"></i></div>
            <h5>Agregar Canciones</h5>
        </header>
        <div id="div-1" class="body">
            <form class="form-horizontal" method="POST" action="agregar.php">

                <div class="form-group">
                    <label for="text1" class="control-label col-lg-4">Nombre de la canción</label>

                    <div class="col-lg-8">
                        <input type="text" name="cancion" placeholder="Nombre de Canción" class="form-control">
                    </div>
                </div>
                <!-- /.form-group -->
		
                <div class="form-group">
                    <label for="pass1" class="control-label col-lg-4">Artista</label>

                    <div class="col-lg-8">
                        <input class="form-control" type="text" placeholder="Artista de la cancion" name="artista"/>
                    </div>
                </div>
				<input type='hidden' name ='tbl' value='canciones'>   
				
				<center>
					<button type="submit" class="btn btn-success">Agregar</button>
				</center>
                <!-- /.form-group -->
            </form>
        </div>
    </div>
</div>

<div class="row">
			<div class="col-lg-6">
				<div class="box">
				<header>
					<div class="icons"><i class="fa fa-music"></i></div>
					<h5>Canciones</h5>
				</header>
				 <?php tabla_canciones($db,1); ?> 
			</div>
			</div>
		</div>
<!--END TEXT INPUT FIELD-->

</div>
		</div>
	<!-- /.inner -->
	</div>
<!-- /.outer -->
</div>
<?php
include("footer.php");
?>
