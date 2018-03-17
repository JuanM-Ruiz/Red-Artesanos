<?php 

include_once("backend/Comentario.php");

extract($_POST);
Comentario::EliminarComentario ($idcomentario);


 ?>