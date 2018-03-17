<?php  session_start(); 
	include_once('backend/Usuario.php');
$usuarioactual = unserialize($_SESSION['usuarioactual']);
include_once('backend/Foto.php');
if(isset($_SESSION['usuarioactual'])){ 
				$usuarioactual->DevolverSiguiendo ();
				$ussig=$usuarioactual->siguiendo;
				if ($ussig) {
				extract($_POST);
				$carga=array($dato , ($dato+10));
				$obfotos = Foto::FotosPublic($usuarioactual->idusuario,$carga);
			   
		      foreach ($obfotos as  $value) { 
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
		        
			
			echo"<div class='panel col-lg-offset-2 col-lg-8 panel-primary cont-index '>
				<div class=' col-xs-12 perfil-foto'>
					<div class='col-xs-1'>";
						 if (!isset($user->urlfoto)){ 
							echo"<img class='img-circle tamaño-foto' src='img/images.png' alt=''>";
					 } else {
						echo"<img class='img-circle tamaño-foto' src='$user->urlfoto' alt=''>";
					 	} 
					echo"</div>
					<h4 class='col-xs-6 alert-link'>$user->nombre_usuario  </h4>
					<h5 class='col-xs-6 alert-link'>$user->nombre </h5>
				
				</div>
				 <div class='panel-body centrar'>
					      <div class='centrar'><a class='afoto' title='$title' onclick='vmodal();' ><img class='thumbnail img-responsive tam-index-muestra fotoindex' src='$value->urlfoto '></a>
					      </div>  
					</div>  
				</div>";
		  } 
		}
	}
		 ?>