<div class="container">
	<div class="jumbotron"> 
		<!-- reg user
	=============================================0 -->

  	<?php 
	if (isset($regmail) && isset($regPass2) && isset($regPass) && isset($nom) && isset($nom_user)) {
	$user = new Usuario ();
	$regmail=trim($regmail);
	$regPass2=trim($regPass2);
	$regPass=trim($regPass);
	$nom=trim($nom);
	$nom_user=trim($nom_user);
	if($regPass2 == $regPass){
		$regPass2=md5($regPass2, "atr");
		$error= $user->RegistroUsuario($regmail, $regPass2, $nom, $nom_user);
		echo $error;
	}else {
		 echo "<span class='error'>Las contraseñas no coinciden</span>";
		 unset($regPass2);
	}


}


	 ?>

  <h1>Bienvenido a la Red Social de Artesanos!!!</h1>
  <p>This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
  <p>Ya tienes cuenta inicia seción</p>
  <p><a data-toggle="modal" href="#log" class="btn btn-primary btn-lg">Iniciar secion</a></p>
  <a data-toggle="modal" href="#reg" data-dismiss="modal">No tienes cuenta Regitrate</a>

</div>
</div>