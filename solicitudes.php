<?php include_once('header.php'); 
include_once('perfil-usuario.php'); 
$resultados = $usuarioactual->solicitudes;
?>
<div class="container">
<h3>Administrar solicitudes</h3>
	<?php if (!isset($sol)){ 
	$resultados = $usuarioactual->solicitudes;?>
	<?php if ($resultados){
			foreach ($resultados as $key => $value) {
				include ("precentacionperfil.php");
			?>

	
		<a href="solicitudes.php?sol=r&user=<?php echo $value->idusuario; ?>" class="btn btn-danger btn-xs pull-right">Rechazar</a>
		<a href="solicitudes.php?sol=a&user=<?php echo $value->idusuario; ?>" class="btn btn-success btn-xs pull-right btn-aceptar">Aceptar</a>

	</div>
	<?php } 
			}?>
	<?php } elseif ($sol == 'r'){  
			$usuarioactual->RechazarSolicitud($user);
			$_SESSION['usuarioactual']=serialize($usuarioactual);
			unset($sol);
			unset($user);
			echo "<script type='text/javascript'>";
		    echo "redirpag('solicitudes.php');";
		    echo "</script>";
				} elseif ($sol == 'a'){  
					$usuarioactual->AceptarSolicitud($user);
					$_SESSION['usuarioactual']=serialize($usuarioactual);
					unset($sol);
					unset($user);
					echo "<script type='text/javascript'>";
				    echo "redirpag('solicitudes.php');";
				    echo "</script>";
				} ?>
</div>
<?php include("footer.php"); ?>