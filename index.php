<?php include('header.php'); ?>
<?php include('perfil-usuario.php'); 
include_once('backend/Foto.php');?>

	<!-- Inicia Section vista section pag principal
	==================================================== -->
	<?php if(isset($_SESSION['usuarioactual'])){  ?>
	<section>
		<article class="container">
			<div id="otronombre">
		 
	<?php 
				$usuarioactual->DevolverSiguiendo ();
				$ussig=$usuarioactual->siguiendo;
				if ($ussig) {

				$carga=array(0 , 10);
				$obfotos = Foto::FotosPublic($usuarioactual->idusuario,$carga);
				
				
				?>

		      <?php foreach ($obfotos as  $value) { 
		        if ($value->titulofoto != "") {
		          $title = $value->titulofoto;
		        }else {
		          $title = "Sin titulo";
		        }
		       	$user="";

		       	foreach ($ussig as $key => $svalue) {
		       		$svalue->AddAlbums ();
					$alb=$svalue->albums;
		       		foreach ($alb as $key => $value3) {
		       			if ($value3->idalbum == $value->idalbum){
		       				$user=$svalue;
		       				break;
		       			} 
		       			if ($user != "") {
		       				break;
		       			}
		       		}
		       	}
		        ?>

				<!-- foto -->
			<div class="panel col-lg-offset-2 col-lg-8 panel-primary cont-index ">
				<div class=" col-xs-12 perfil-foto">
					<div class="col-xs-2 col-sm-1">
						<?php if (!isset($user->urlfoto)){ ?>
							<img class="img-circle tamaño-foto" src="img/images.png" alt="">	
					<?php } else {?>
							<img class="img-circle tamaño-foto" src=" <?php echo $user->urlfoto; ?>" alt="">	
					<?php } ?>
					</div>
					<h4 class="col-xs-6 alert-link"> <?php echo $user->nombre_usuario; ?> </h4>
					<h5 class="col-xs-6 alert-link"><?php echo $user->nombre; ?></h5>
				
				</div>
				 <div class="panel-body centrar">
					      <div class="centrar"><a class="afoto" title="<?php echo $title; ?>" onclick="vmodal(<?php echo $value->idfoto; ?>);" value="<?php echo $value->idfoto; ?> "><img class="thumbnail img-responsive tam-index-muestra fotoindex" src="<?php echo $value->urlfoto; ?>"></a>
					      </div>  
					</div>  
				</div>
				
		 <?php   } 
		 ?>		
				</div>
		 		<input type="hidden" id="cantfotos" value="10">
		 		
				<button class="btn btn-primary col-xs-offset-5 col-lg-2" onclick="cargarfotos();">Cargar +</button>
				
		</article>
	</section>


<div tabindex="-1" class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
		<button class="close" type="button" data-dismiss="modal">×</button>
		<h3 class="modal-title modal-t-mod">Heading</h3>
	</div>
	<div class="modal-body modal-b-mod">
		
	</div>
	<div class="modal-footer modal-f-mod">
    
      <div id="comentarios">
        
     </div>
    <div id="coment">
    <div id="com1">
    <textarea name='com' id='com' onkeyup='autosize();' class='pull-left' rows='1' ></textarea>
    </div>
    <button class="btn btn-primary pull-left btn-sm" onclick="crearcomentario(<?php echo $usuarioactual->idusuario; ?>,  '<?php echo $usuarioactual->nombre_usuario; ?>');">Comentar</button>
		<button class="btn btn-default pull-left btn-sm" data-dismiss="modal">Close</button>
    </div>
	</div>
   </div>
  </div>
</div>

<?php }
}else{
	include("pagdeslogueado.php");
	} ?>
<?php include("footer.php"); ?>