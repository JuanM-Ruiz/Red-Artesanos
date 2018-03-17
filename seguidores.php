<?php include("header.php"); 
 include('perfil-usuario.php'); 
 echo"<script type='text/javascript'>nav(3)</script>";
if(isset($_SESSION['usuarioactual'])){ 
$usuarioactual->DevolverSeguidores ();
$resultados=$usuarioactual->seguidores;
?>


<div class="container">
<h3>Administrar seguidores</h3>

	<?php
	if (!isset($sol)) {
		if ($resultados) {	
		 foreach ($resultados as $key => $value) {
		 	include ("precentacionperfil.php");
		?>
	
		<a href="seguidores.php?sol=b&id=<?php echo $value->idusuario; ?>&user=<?php echo $value->nombre_usuario; ?>" class="btn btn-danger btn-xs pull-right">Borrar Seguidor</a>

	</div>
	<?php } 
	}
	}elseif ($sol=="b") {
		$usuarioactual->BorrarSeguidor($id,$user);
		unset($sol);
		unset($user);
	}?>
</div>
<?php }else{
	include("pagdeslogueado.php");
	}  ?>
<?php include("footer.php"); ?>