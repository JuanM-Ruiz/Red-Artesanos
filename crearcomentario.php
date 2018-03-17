<?php include_once("backend/Comentario.php");
	include_once("backend/Foto.php");
	include_once("backend/Usuario.php");
	  extract($_POST);
	  $foto = new Foto();
	  $foto->DevolverFoto($idfoto); 
	  $user = new Usuario();
	  $res = $user->usuarios ($idusuario);
	  $com = new Comentario();
	  $com->CrearComentario($idfoto , $comentario , $idusuario);

?>