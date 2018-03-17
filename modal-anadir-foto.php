<!-- datos para subir nueva foto
======================================================================= -->

<?php if (isset($privacidad)){ 
  $fo=$_FILES['fotos'];
    Foto::AnadirFoto($privacidad , $fo , $alb->tituloalbum, $alb->idalbum, $usuarioactual->idusuario , $titulo , count($alb->fotos)); 
         echo "<script type='text/javascript'>";
  echo "redirpag('fotos.php');";
  echo "</script>";
  }
  
  unset($anadirf);

 ?>

<!-- ventana modal de añadir foto
  ===================================================================== -->
  <div class="modal log" id="anadirfotos">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">
        <form class="form-horizontal" id="formfoto" action="fotos.php" method="POST" enctype="multipart/form-data">
        <fieldset>
          <legend>Añadir Fotos
          <?php if (isset($alb)) {
            $cant = count($alb->fotos);
          }else {
            $cant = 0;
            } ?>
          <button type="button" class="btn btn-primary pull-right" onclick ="anadirfoto (<?php echo  $cant; ?>)">Añadir</button>
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
          
          <a class="btn btn-primary pull-right "  name="anadirf" onclick="Comprobar();" href="#">Añadir Foto</a>
         </fieldset>
      </form>
        </div>
      </div>
    </div>
  </div>