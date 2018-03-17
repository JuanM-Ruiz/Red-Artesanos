<?php include("header.php"); ?>
<?php include('perfil-usuario.php'); ?>
<!-- pantalla albums
==================================== -->
<section>

  <script type='text/javascript'>nav(2)</script>
	<?php 
  if(isset($_SESSION['usuarioactual'])){ 
  if (isset($modalbum)) {
    
     Album::ModificarAlbum($modalbum, $tit);
  }
  if (isset($id)){
    $al = new Album();
    $al->DevolverAlbum ($id);
    $al->BorrarAlbum();
    echo "<script type='text/javascript'>";
    echo "redirpag('albums.php');";
    echo "</script>";
  }
    $usuarioactual->AddAlbums ();
    $albums = $usuarioactual->albums;
    $_SESSION['usuarioactual']=serialize($usuarioactual);
    ?>
	<article>
		<div class="container">

          <div class="row">
    			<h2 class="col-xs-4 col-sm-9">Albums</h2>
                <a data-toggle="modal" href="#crearalbum" class="btn btn-primary btn-crear ">Crear album <span class="glyphicon glyphicon-plus icon-plus"></span></a>
            </div>
		</div>

	<div class="container">
    <div class="row">
    <?php foreach ($albums as $key => $value) { 
         if ($value->tituloalbum != $usuarioactual->nombre_usuario) { ?>

       <!-- albums  -->
		<div class="col-sm-5 col-md-4 col-lg-3 panel panel-primary album">
            <div class="panel-body row">
                <span class="glyphicon glyphicon-folder-open carpeta col-xs-6"></span>
                <div class="col-xs-6">
                    <a href="fotos.php?album=<?php echo $value->idalbum; ?>" class="btn-xs btn btn-primary btn-album">Ver album</a>
                     <a onclick= "borraralbum(<?php echo $value->idalbum;  ?>)" class="glyphicon glyphicon-trash btn-borrar pull-right" title="Borrar album"></a>
                    <a data-toggle="modal"  href="#Modificar" onclick="mod('<?php echo $value->idalbum; ?>');" class="btn-xs btn btn-primary btn-album" title="Borrar album">Modificar album</a>
                   
                </div>
            </div>
            <div class="panel-heading">
                <h4 class="panel-title text-center"><?php echo $value->tituloalbum; ?></h4>
            </div>
		</div> <!-- fin albums -->
        <?php } 
        }?>
	</div>

</div><!--.container-->
	</article>

<!-- crear album
=============================================== -->

<?php 


    if (isset($privacidad)) {
      $fo=$_FILES['fotos'];
        $alb = new Album ();
        $datos=array($privacidad, $fo , $titulo , sizeof($privacidad));
       if ($usuarioactual->nombre_usuario != $tituloalbum) {
        $alb->CrearAlbum($usuarioactual->idusuario , $tituloalbum, $datos);
        } else {
          echo "no puede usar el nombre de usaurio para crear un album";
        }
    }


?>

</section>
<!-- ventana modal de crear album
    ===================================================================== -->
    <div class="modal log" id="crearalbum">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
          <form class="form-horizontal" id="formfoto" action="albums.php" method="POST" enctype="multipart/form-data">
              <fieldset>
                <legend>Crear album</legend>

                <div class="form-group">
                  <label for="tituloalbum" class="col-lg-2 control-label">Titulo album</label>
                  <div class="col-lg-10">
                    <input type="text" class="form-control" name="tituloalbum" placeholder="Ingrese el nombre de album" required>
                  </div>
                </div>  
                <fieldset>
          <legend>Añadir Fotos
          <button type="button" class="btn btn-primary pull-right" onclick ="anadirfoto (0)">Añadir</button>
          </legend>
          <div class="form-group">
            <label for="titulo[]" class="col-lg-2 control-label">Titulo</label>
            <div class="col-lg-10" id="titulo-cont">
              <input type="text" class="form-control" name="titulo[]" id="titulo1" placeholder="Ingrese un Titulo">
            </div>
          </div>

          <div class="form-group">
            <label for="titulo" class="col-lg-2 control-label">Foto</label>
            <div class="col-lg-10" id="fotofile">
            <input type="file" class="form-control select-inputs" name="fotos[]" id="foto1" >
            
              <div id="div-foto" class="form-group">
                <input type="hidden" id="c" value="1">
                <div id="aviso"></div>
              </div>
            </div>
          </div>
          
           <div class="form-group">
              <label class="col-lg-2 control-label">Privacidad</label>
              <div class="col-lg-10" >
                <div class="radio">
                  <label id="radio-cont1">
                  <span id="sppub" class="pull-right"> Publica  </span>
                    <input type="radio" name="priv" id="oradio" value="1" checked="">

                  </label>
                </div>
                <div class="radio">
                  <label id="radio-cont2">
                    <span id="sppri" class="pull-right">Privada</span>
                    <input type="radio" name="priv" id="oradio1" value="0">
                     
                  </label>
                  <input type="hidden" value="1" id="idradios">
                </div>
              </div>
            </div>
               <div id="avisoenvio" class="pull-right aviso"></div>
              <button type="button" class="btn btn-default pull-right boton-cancelar" onclick ="CancelarSubida()" data-dismiss="modal">Cancelar</button>
              
              <a class="btn btn-primary pull-right "  name="anadirf" onclick="Comprobar();" href="#">Crear Album</a>
               </fieldset>
            </form>
          </div>
        </div>
      </div>
    </div>
<!-- ventana modificar album
  ===================================================================== -->
  <div class="modal log" id="Modificar">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">
        <form class="form-horizontal" action="albums.php" method="POST">
        <fieldset>
          <legend>Modificar titulo album</legend>
          <div class="form-group">
            <label for="tit" class="col-lg-2 control-label">Titulo</label>
            <div class="col-lg-10">
              <input type="text" class="form-control" name="tit" id="tit" placeholder="Ingresa nuevo titulo">
              <input type="hidden" value="" class="form-control" name="modalbum" id="modalbum">
            </div>
          </div>
          
          <button type="button" class="btn btn-default pull-right boton-cancelar" data-dismiss="modal">Cancelar</button>
          <input type="submit" class="btn btn-primary pull-right " value="Modificar" >
         </fieldset>
      </form>
        </div>
      </div>
    </div>
  </div>
  <?php }else{
  include("pagdeslogueado.php");
  }  ?>
<?php include("footer.php"); ?>