<?php include("header.php"); 
include('perfil-usuario.php');?>

<div class="container">
<h3>Perfiles</h3>
	<?php $usuarioactual->DevolverSiguiendo ();
		$resultados =  $usuarioactual->siguiendo;
		if (!isset($id)) {
		  foreach ($resultados as $key => $value) {	
		  include ("precentacionperfil.php");
	?>
		<a href="siguiendo.php?idb=<?php echo $value->idusuario; ?>" class="btn btn-danger btn-xs pull-right btn-siguiendo">Borrar seguidor</a>
		<a href="siguiendo.php?id=<?php echo $value->idusuario; ?>" class="btn btn-primary btn-xs 
		pull-right">Ver Perfil</a>
		
	</div>
	<?php } 
		  }else {
		  	$usseg;
		  	foreach ($resultados as $key => $value) {
		  		if ($value->idusuario == $id) {
		  			$usseg = $value;
		  		}
		  	}
		  	?>
				
<section>
	<article>
		<div class="container">
			<fieldset class="fil-datos">
			    <legend>Perfil</legend>
		    	
				<div class="col-xs-1">
					<?php
					if ($usseg->fotoperfil==-1){ ?>
					<img src="img/images.png" alt="perfil" class="img-circle img-tamaño ">	
				<?php }else {
				$foto = $usseg->urlfoto;
				echo "<img src='$foto' alt='perfil' class='img-circle img-tamaño'>";
				}
				 ?>
				</div>

			    <div class="form-group col-xs-8 col-lg-5 user-perfil">
			      <label class="col-lg-2 control-label">Usuario</label>
			      <label class="col-lg-4 control-label"><?php echo $usseg->nombre_usuario; ?></label>
			    </div>
				

			</fieldset>
			<fieldset class="fil-datos">
				<legend>Datos Personales</legend>
			    <div class="form-group col-lg-12">
			      <label class="col-xs-12 col-lg-2 control-label">Nombre:</label>
			      <label class="col-xs-12 col-lg-4 control-label"><?php echo $usseg->nombre; ?></label>
			    </div>
			    <div class="form-group col-lg-12">
			      <label class="col-xs-12 col-lg-2 control-label">E-mail:</label>
			      <label class="col-xs-12 col-lg-4 control-label"><?php echo $usseg->email; ?></label>
			    </div>
			    <div class="form-group col-lg-12">
			      <label class="col-xs-12 col-lg-2 control-label">Antecedentes:</label>
			      <label class="col-xs-12 col-lg-4 control-label"><?php echo $usseg->antecedentes; ?></label>
			    </div>
			     <div class="form-group col-lg-12">
			      <label class="col-xs-12 col-lg-2 control-label">Intereses:</label>
			      <label class="col-xs-12 col-lg-4 control-label"><?php echo $usseg->intereses ?></label>
			    </div>
			    
			</fieldset>
			<?php 
			$usseg->AlbumSeguido($usseg->nombre_usuario);

			$value = $usseg->AlbumSeguido; 
			$_SESSION['usseg']= serialize($usseg);
			 ?>
			
			 <!-- albums  -->
		<div class="col-sm-5 col-md-4 col-lg-3 panel panel-primary album">
            <div class="panel-body row">
                <span class="glyphicon glyphicon-folder-open carpeta col-xs-6"></span>
                <div class="col-xs-6">
                    <a href="fotos.php?album=<?php echo $value->idalbum; ?>" class="btn-xs btn btn-primary btn-album">Ver album</a>
                    
                </div>
            </div>
            <div class="panel-heading">
                <h4 class="panel-title text-center"><?php echo $value->tituloalbum; ?></h4>
            </div>
		</div> <!-- fin albums -->

		</div>
	</article>

</section>

		  <?php } ?>
</div>

<?php if (isset($idb)) {
	$usuarioactual->BorrarSiguiendo($idb);
	 echo "<script type='text/javascript'>";
    echo "redirpag('siguiendo.php');";
    echo "</script>";
} ?>
<?php include("footer.php"); ?>