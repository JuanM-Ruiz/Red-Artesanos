<?php session_start(); 
include_once("backend/autoload.php");	
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Artesanos</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/responsive.css">
	<link rel="shortcut icon" sizes="60x60" href="img/apple-icon-60x60.png" type="image/png">
	<script src="js/main.js"></script>
	<!--[if lt IE 9]>
	    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  	<![endif]-->
</head>
<body>

	<!-- Inicia el header
	================================================= -->

	<?php 
	extract($_REQUEST);
	if (isset($mail)) {
		if ($mail != "" && $inputPassword != "") {
			$inputPassword = md5($inputPassword, "atr");
			$usuarioactual = new Usuario();
			$inicio = $usuarioactual->iniciarSecion($mail, $inputPassword);

		}
		if (!$inicio){
				echo "<script type='text/javascript'>";
			    echo "window.onload=logincorrecto;";
			    echo "</script>";
			    unset($mail);
				unset($inputPassword);
			}else{
				$_SESSION['usuarioactual']=serialize($usuarioactual);
				unset($mail);
				unset($inputPassword);
			}

	}

	?>
	<header>
		<nav class="navbar navbar-inverse">
		  <div class="container conte">
		  	<div class="navbar-header col-xs-10 col-sm-6">
		  		<div class="row">

				  	<form class=" navbar-left bordes-form col-sm-12" role="search" action="buscador.php" method="GET">
				  	
						  	<a href="index.php">
						  		<img src="img/logo.png" alt="logo artistas" class="img-responsive logo pull-left">
						  	</a>
					 
				        <div class="form-group col-xs-8 col-sm-9">
				          <input type="text" class="form-control" placeholder="Buscar Usuario" name="buscar" value="<?php echo isset($buscar)? $buscar : ''; ?>" >
				        </div>
				        <button type="submit" class="btn btn-default col-xs-2 col-sm-1 glyphicon glyphicon-search"></button>
				    </form>
			    </div>
			</div>    
		    <div class="navbar-header col-xs-2 col-sm-5 nav-p">
		     
		      <button type="button" class="navbar-toggle collapsed button-res" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		    </div>
		      
		      <div class="collapse navbar-collapse pull-right col-xs-4 " id="bs-example-navbar-collapse-2">
		      <ul class="nav navbar-nav">
					<li id="perfil"><a href="perfil.php">Perfil</a></li>
					<li id="albums"><a href="albums.php" >Albums</a></li>
					<li id="seguidores"><a href="seguidores.php">Seguidores</a></li>
					<?php if(!isset($_SESSION['usuarioactual'])){ ?>
					<li><a data-toggle="modal" href="#log">Log in</a></li>			
					<?php } else {?>
					<li><a href="backend/logout.php">Log out</a></li>			
					<?php } ?>
		      </ul>
		    </div>
		  </div>
		</nav>
	</header>



	<!-- ventana modal de inicio de seción
	===================================================================== -->
	<div class="modal log" id="log">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	      </div>
	      <div class="modal-body">
	      <form class="form-horizontal" action="index.php" method="POST">
			  <fieldset>
			    <legend>Iniciar Seción</legend>
			    <div class="form-group">
			      <label for="mail" class="col-lg-2 control-label">Email</label>
			      <div class="col-lg-10">
			        <input type="email" class="form-control" name="mail" placeholder="Ingrese su E-mail" required>
			      </div>
			    </div>
			    <div class="form-group	">
			      <label for="inputPassword" class="col-lg-2 control-label">Password</label>
			      <div class="col-lg-10">
			        <input type="password" class="form-control" name="inputPassword" placeholder="Ingrese su Contraseña" required>
			       <div>
			          <label>
			            <a data-toggle="modal" href="#reg" data-dismiss="modal">No tienes cuenta Regitrate</a>
			          </label>
			        </div>
			      </div>
			    </div>
			    <button type="button" class="btn btn-default pull-right boton-cancelar" data-dismiss="modal">Cancelar</button>
			    <input type="submit" class="btn btn-primary pull-right " value="Iniciar secion" name="envlog">
			   </fieldset>
			</form>
	      </div>
	    </div>
	  </div>
	</div>


	<!-- Login Incorrecto 
	========================================================================= -->

	<div class="modal log" id="logincorrecto">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	         <h1>Error al iniciar secion</h1>
	      </div>
	      <div class="modal-body">
	      
			  <fieldset>
			    	 <p><a data-toggle="modal" href="#log" class="btn btn-primary btn-lg" data-dismiss="modal">Vuelve a ingresar</a></p>
  					<a data-toggle="modal" href="#reg" data-dismiss="modal" data-dismiss="modal">No tienes cuenta Regitrate</a>
			   </fieldset>
			</form>
	      </div>
	    </div>
	  </div>
	</div>


	<!-- ventana modal registro 
	======================================================================= -->

	<div class="modal" id="reg">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	      </div>
	      <div class="modal-body">
	      <form class="form-horizontal" action="index.php" method="POST">
			  <fieldset>
			    <legend>Registrate</legend>
			    <div class="form-group">
			      <label for="nom_user" class="col-lg-2 control-label">Usuario</label>
			      <div class="col-lg-10">
			        <input type="text" class="form-control" name="nom_user" placeholder="Ingrese su Usuario" required>
			      </div>
			    </div>
			    <div class="form-group">
			      <label for="nom" class="col-lg-2 control-label">Nombre</label>
			      <div class="col-lg-10">
			        <input type="text" class="form-control" name="nom" placeholder="Ingrese su Nombre" required>
			      </div>
			    </div>
			    <div class="form-group">
			      <label for="regmail" class="col-lg-2 control-label">Email</label>
			      <div class="col-lg-10">
			        <input type="email" class="form-control" name="regmail" placeholder="Ingrese su E-mail" required>
			      </div>
			    </div>
			    <div class="form-group	">
			      <label for="regPass" class="col-lg-2 control-label">Pass</label>
			      <div class="col-lg-10">
			        <input type="password" class="form-control" name="regPass" placeholder="Ingrese su Contraseña" required>
			      </div>
			    </div>

			     <div class="form-group">
			      <label for="regPass2" class="col-lg-2 control-label">Repetir Pass</label>
			      <div class="col-lg-10">
			        <input type="password" class="form-control" name="regPass2" placeholder="Repita su Contraseña">
			      </div>
			    </div>
			    
			    <button type="button" class="btn btn-default pull-right boton-cancelar" data-dismiss="modal">Cancelar</button>
			    <input type="submit" class="btn btn-primary pull-right boton-cancelar" value="Registrarse">
			   </fieldset>
			</form>
	      </div>
	    </div>
	  </div>
	</div>

