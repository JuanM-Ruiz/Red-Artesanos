<?php  session_start();
	
include_once("backend/Comentario.php");
	include_once("backend/Foto.php");
	include_once("backend/Usuario.php");
	if (isset($_SESSION['usuarioactual'])) {
		$usuarioactual= unserialize($_SESSION['usuarioactual']);
	}
	
	  extract($_POST);  
	  $foto = new Foto();
	  $foto->DevolverFoto($idfoto); 
	  $foto->AddComentarios();
	  $comentarios = $foto->comentarios; 
	  $user = new Usuario();
	  foreach ($comentarios as $key => $value) {
	  	$res = $user->usuarios ($value->idusuario);
	if ($value->idusuario == $usuarioactual->idusuario) {
		echo "<blockquote class='text-left'>
      <small>" . $res[0]['nombre_usuario'] .  " <span class='pull-right'>$value->fecha <a  onclick='borrarComentario($value->idcomentario , $value->idfoto)'class='glyphicon glyphicon-trash btn-borrar borrar-comentario'></a> </small>
      <p>$value->comentario </p>
    </blockquote>";

	}else{
    echo "<blockquote class='text-left'>
      <small>" . $res[0]['nombre_usuario'] .  " <span class='pull-right'>$value->fecha</span></small>
      <p>$value->comentario </p>
    </blockquote>";
		}
     } 

     ?>
