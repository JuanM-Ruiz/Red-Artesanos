<?php include_once('header.php'); ?>
<?php include_once('perfil-usuario.php'); ?>
<?php include_once('backend/Usuario.php'); ?>
<!-- Inicia buscador
================================================= -->
<?php 
  if(isset($_SESSION['usuarioactual'])){ ?>
<section>
	<article>
		<div class="container">
			<?php $resultado = $usuarioactual->buscar($buscar);
			 ?>
			<h3>Usuarios:</h3>

			<?php
			if ($resultado) {
			 foreach ($resultado as  $value) {
			 	if($value['id']!= $usuarioactual->idusuario){
			 		
			?>
			<div class="col-xs-12  col-md-8 center-block perfil-foto alert alert-dismissible alert-info">
			<div class="col-xs-2 col-sm-1">
				<?php if (!isset($value['urlfoto'])){ ?>
					<img class="img-circle tamaño-foto" src="img/images.png" alt="">
				<?php } else {?>
					<img class="img-circle tamaño-foto" src=" <?php echo $value['urlfoto'] ?> " alt="">
				<?php } ?>
			</div>
				<h4 class="col-xs-6 alert-link"> <?php echo $value['nombre_usuario'] ?> </h4>
				<h6 class="col-xs-6 alert-link"> <?php echo $value['nombre'] ?> </h6>
				<a href="enviarsolicitud.php?user= <?php echo $value['nombre_usuario']; ?> " class="btn btn-success btn-xs pull-right">Enviar Solicitud</a>
			</div>
			<?php } }}?>

		</div>
	</article>
</section>
<?php }else{
include("pagdeslogueado.php");
  }  ?>
<?php include("footer.php"); ?>