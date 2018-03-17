<div class="col-xs-12  col-md-8 center-block perfil-foto alert alert-dismissible alert-info">
		<div class="col-xs-2 col-sm-1">
			<?php if (!isset($value->urlfoto)){ ?>
					<img class="img-circle tamaño-foto" src="img/images.png" alt="">	
			<?php } else {?>
					<img class="img-circle tamaño-foto" src=" <?php echo $value->urlfoto; ?>" alt="">	
			<?php } ?>
		</div>
		<h4 class="col-xs-6 alert-link"> <?php echo $value->nombre_usuario; ?> </h4>
		<h5 class="col-xs-6 alert-link"><?php echo $value->nombre; ?></h5>