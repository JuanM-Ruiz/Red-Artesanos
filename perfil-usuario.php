<!-- Inicia el article perfil-pag-principal
	========================================================= -->
	
	<section class="container section-perfil">
		
		<article id="article-perfil-index">
			<div class="row">

				<div class="fondo">
					<?php 
					if (isset($_SESSION['usuarioactual'])){
						$usuarioactual = unserialize($_SESSION['usuarioactual']);
						?>
					<div class="col-xs-4 col-sm-1">
						<?php
						if ($usuarioactual->fotoperfil==-1){ ?>
						<img src="img/images.png" alt="perfil" class="img-circle img-tamaño ">	
					<?php }else {
							$foto = $usuarioactual->urlfoto;
							echo "<img src='$foto' alt='perfil' class='img-circle img-tamaño'>";
							} ?>
					</div>
					<h3 class="nombre-us col-xs-7 col-sm-5"><?php echo $usuarioactual->nombre; ?></h3>
					<div class=" col-xs-12 col-sm-4 boton-us">
						<div class="col-xs-12 link-perfil">
							<a href="solicitudes.php" class="btn btn-info  col-xs-6 col-sm-8 col-xs-offset-2 ">Solicitudes <span class="badge span-info"><?php echo count($usuarioactual->solicitudes); ?></span> </a>					
							<a href="siguiendo.php" class="btn btn-info col-xs-6 col-sm-8 col-xs-offset-2">Siguiendo</a>
						</div>
					</div>
					<?php }else {?>
					<div class="col-xs-1">
						<img src="img/images.png" alt="perfil" class="img-circle img-tamaño ">	
					</div>
					<h3 class="nombre-us col-xs-6"></h3>
					<div class=" col-xs-4 boton-us">
					<div class="col-xs-12 link-perfil">					
							<a data-toggle="modal" href="#reg" data-dismiss="modal" class="btn btn-info col-xs-6 col-xs-offset-6">Registrate</a>
					</div>
					
						
					</div>
					<?php } ?>
				</div>
			</div>
		</article>
		<!-- reg user
	=============================================0 -->
	<?php 
	if (isset($regmail) && isset($regrepPass) && isset($regPass) && isset($nom) && isset($nom_user)) {
	$user = new Usuario ();
	$regmail=trim($regmail);
	$regrepPass=trim($regrepPass);
	$regPass=trim($regPass);
	$nom=trim($nom);
	$nom_user=trim($nom_user);
	if($regrepPass == $regPass){
		$regrepPass=md5($regrepPass, "atr");
		$user->RegistroUsuario($regmail, $regrepPass, $nom, $nom_user);
	}
}


	 ?>
	</section>