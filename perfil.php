<?php 

include_once("header.php");
?>
<script type='text/javascript'>nav(1)</script>
<!-- pantalla perfil
======================================================================= -->



<?php
// modificar perfil
//======================================================================

if(isset($_SESSION['usuarioactual'])){ 
extract($_POST);
$usuarioactual=unserialize($_SESSION['usuarioactual']);
if (isset($envlog)){
	$nombre = trim($nombre);
	$email = trim($email);
	$nombre_usuario = trim($nombre_usuario);
	$datos_mod = array ('nombre' => $nombre , 
						'email' => $email , 
						'nombre_usuario' => $nombre_usuario , 
						'antecedentes' => $antecedentes , 
						'intereses' => $intereses , 
						'foto' => $_FILES['foto']['tmp_name']);
	$usuarioactual->ActualizarPerfil($datos_mod);
	$_SESSION['usuarioactual']=serialize($usuarioactual);
	unset($envlog);
}

// cambio de contraseña
// ============================================
if (isset($passcam)){
	$passactual = md5($passactual, "atr");
	$inputPassword = md5($inputPassword, "atr");
	$repPassword = md5($repPassword, "atr");
	if ($inputPassword == $repPassword) {
	
		$usuarioactual->CambiarContrasena($passactual , $inputPassword);
	}
}
?>

<section>
	<article>
		<div class="container">
			<fieldset class="fil-datos">
			    <legend>Perfil</legend>
		    	
				<div class="col-xs-12 col-md-1">
					<?php
					if ($usuarioactual->fotoperfil == -1){ ?>
					<img src="img/images.png" alt="perfil" class="img-circle img-tamaño ">	
				<?php }else {
					
				$foto = $usuarioactual->urlfoto;
				echo "<img src='$foto' alt='perfil' class='img-circle img-tamaño'>";
				}
				 ?>
				</div>

			    <div class="form-group col-xs-12 col-lg-5 user-perfil">
			      <label class="col-lg-2 control-label">Usuario</label>
			      <label class="col-lg-4 control-label"><?php echo $usuarioactual->nombre_usuario; ?></label>
			    </div>
				<a data-toggle="modal" class="btn btn-info pull-right" href="#cambio-pass">Cambiar Contraseña</a>

			</fieldset>
			<fieldset class="fil-datos">
				<legend>Datos Personales</legend>
				<a data-toggle="modal" class="btn btn-info pull-right" href="#modificar-datos">Modificar Datos</a>
			    <div class="form-group col-lg-12">
			      <label class="col-xs-12 col-lg-2 control-label">Nombre:</label>
			      <label class="col-xs-12 col-lg-4 control-label"><?php echo $usuarioactual->nombre; ?></label>
			    </div>
			    <div class="form-group col-lg-12">
			      <label class="col-xs-12 col-lg-2 control-label">E-mail:</label>
			      <label class="col-xs-12 col-lg-4 control-label"><?php echo $usuarioactual->email; ?></label>
			    </div>
			    <div class="form-group col-lg-12">
			      <label class="col-xs-12 col-lg-2 control-label">Antecedentes:</label>
			      <label class="col-xs-12 col-lg-4 control-label"><?php echo $usuarioactual->antecedentes; ?></label>
			    </div>
			     <div class="form-group col-lg-12">
			      <label class="col-xs-12 col-lg-2 control-label">Intereses:</label>
			      <label class="col-xs-12 col-lg-4 control-label"><?php echo $usuarioactual->intereses ?></label>
			    </div>
			    
			</fieldset>

			<fieldset class="fil-datos">
				<legend>Historial de perfiles</legend>
				<?php $resultados=$usuarioactual->FotosPerfil();
					if ($resultados) {	
						foreach ($resultados as $key => $value) {
											
													
				 ?>
				<div class="col-lg-3 col-sm-4 col-xs-6">
					<img class="thumbnail img-responsive tam-muestra fotoindex" src="<?php echo $value['urlfoto']; ?>">
			    </div>
			    <?php } 
			    }?>
			</fieldset>
		</div>
	</article>

</section>


<!-- ventana modal de cambio de contraseña
	===================================================================== -->
	<div class="modal" id="cambio-pass">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	      </div>
	      <div class="modal-body">
	      <form class="form-horizontal" action="perfil.php" method="POST">
			  <fieldset>
			    <legend>Cambiar contraseña</legend>
			    <div class="form-group">
			      <label for="passactual" class="col-lg-4 control-label">Contraseña actual</label>
			      <div class="col-lg-8">
			        <input type="password" class="form-control" name="passactual" placeholder="Contraseña actual">
			      </div>
			    </div>
			    <div class="form-group">
			      <label for="inputPassword" class="col-lg-4 control-label">Contraseña</label>
			      <div class="col-lg-8">
			        <input type="password" class="form-control" name="inputPassword" placeholder="Ingrese su Contraseña">
			      </div>
			    </div>

			    <div class="form-group	">
			      <label for="reptPassword" class="col-lg-4 control-label">Repetir Contraseña</label>
			      <div class="col-lg-8">
			        <input type="password" class="form-control" name="repPassword" placeholder="Repita la Contraseña">
			      </div>
			    </div>

			    <button type="button" class="btn btn-default pull-right boton-cancelar" data-dismiss="modal">Cancelar</button>
			    <input type="submit" class="btn btn-primary pull-right " value="Cambiar" name="passcam">
			   </fieldset>
			</form>
	      </div>
	    </div>
	  </div>
	</div>


	<!-- ventana modal de modificacion de datos
	===================================================================== -->
	<div class="modal" id="modificar-datos">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	      </div>
	      <div class="modal-body">
	      <form class="form-horizontal" action="perfil.php" method="POST" enctype="multipart/form-data">
			  <fieldset>
			    <legend>Modificar Perfil</legend>
			    <div class="form-group">
			      <label for="nombre" class="col-lg-4 control-label">Nombre</label>
			      <div class="col-lg-8">
			        <input type="text" class="form-control" name="nombre" placeholder="Ingrese su Nombre" value="<?php echo $usuarioactual->nombre;  ?>">
			      </div>
			    </div>
			    <div class="form-group">
			      <label for="nombre_usuario" class="col-lg-4 control-label">Usuario</label>
			      <div class="col-lg-8">
			        <input type="text" class="form-control" name="nombre_usuario" placeholder="Ingrese su Usuario" value="<?php echo $usuarioactual->nombre_usuario;  ?>">
			      </div>
			    </div>

				 <div class="form-group	">
			      <label for="foto" class="col-lg-4 control-label">Cambiar Foto</label>
			      <div class="col-lg-8">
			        <input type="file" class="form-control" name="foto" >
			      </div>
			    </div>

			    <div class="form-group	">
			      <label for="email" class="col-lg-4 control-label">E-mail</label>
			      <div class="col-lg-8">
			        <input type="email" class="form-control" name="email" placeholder="Ingrese su e-mail" value="<?php echo $usuarioactual->email;  ?>">
			      </div>
			    </div>

			     <div class="form-group	">
			      <label for="antecedentes" class="col-lg-4 control-label">Antecedentes</label>
			      <div class="col-lg-8">
			      <textarea name="antecedentes" class="form-control" cols="30" rows="10"><?php echo $usuarioactual->antecedentes;  ?></textarea>
			      </div>
			    </div>

			     <div class="form-group	">
			      <label for="intereses" class="col-lg-4 control-label">Intereses</label>
			      <div class="col-lg-8">
			      <textarea name="intereses" class="form-control" cols="30" rows="10"><?php echo $usuarioactual->intereses; ?></textarea>
			      </div>
			    </div>

			    <button type="button" class="btn btn-default pull-right boton-cancelar" data-dismiss="modal">Cancelar</button>
			    <input type="submit" class="btn btn-primary pull-right " value="Modificar" name="envlog">
			   </fieldset>
			</form>
	      </div>
	    </div>
	  </div>
	</div>

<?php 
}else{
	include("pagdeslogueado.php");
	}
include_once("footer.php");
 ?>