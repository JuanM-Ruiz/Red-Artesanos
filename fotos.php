<?php include("header.php");
include('perfil-usuario.php');
include_once("backend/Foto.php");
$alb; 
$sv;
// modificar foto
// =============================================
if (isset($idfot)){
  $selecfoto= new Foto();
  $selecfoto->DevolverFoto($idfot);
  $selecfoto->ModificarFoto( $titl , $priva);

}
// borrar foto
// ================================================
if (isset($borrarf)) {
  $selecfoto= new Foto();
  $selecfoto->DevolverFoto($borrarf);
  $selecfoto->BorrarFoto();
  $al = new Album();
  $al->DevolverAlbum ($selecfoto->idalbum);
  $al->AddFotos ();
 if (count($al->fotos)==0) {
    $al->BorrarAlbum( $al->idusuario);
    echo "<script type='text/javascript'>";
    echo "redirpag('albums.php');";
    echo "</script>";
  } 
}

if (isset($album)){
 $_SESSION ['album'] = $album;
}else {
  $album = $_SESSION ['album'];
}

foreach ($usuarioactual->albums as $key => $value) {
  if ($value->idalbum == $album) {
    $alb = $value;
  }
}
if (isset($alb)) {
$alb->AddFotos();
$obfotos = $alb->fotos;
$sv=1;

}else {
  $usseg=unserialize($_SESSION['usseg']);
  $alb=$usseg->AlbumSeguido;
  $alb->FotosPublicas($usseg->idusuario);
  $obfotos=$alb->fotospublicas;
  $sv=0;

 } 
 ?>


<div class="container">
  <div class="row">
        <h1 class="col-sm-4"><?php echo $alb->tituloalbum; ?></h1>
        <?php if ($sv==1) { ?>
        <a data-toggle="modal" class="btn btn-info pull-right btn-anadir" href="#anadirfotos">Añadir Foto</a>
        <?php } ?>
      </div>
  <div class="row">
    
  
      <?php foreach ($obfotos as  $value) { 
        if ($value->titulofoto!="") {
          $title = $value->titulofoto;
        }else {

          $title = "Sin titulo";
        }
       
        ?>
        <div class="col-xs-6 col-sm-4  col-lg-3 muestra">
      <div class="">
      
      
      <h5 class="text-center "><strong><?php echo $title; ?></strong></h5>
      <a class="afoto" title="<?php echo $title; ?>" value="<?php echo $value->idfoto; ?> " onclick="vmodal(<?php echo $value->idfoto; ?>);" > 

      <img class="thumbnail img-responsive tam-index-muestra fotoindex" src="<?php echo $value->urlfoto; ?>"></a>
      </div>
         <?php if ($sv==1) { ?>
      <a data-toggle="modal"  onclick="modf('<?php echo $value->idfoto; ?>', '<?php echo $value->privacidad; ?>', '<?php echo $title; ?>');"   class="btn-xs btn btn-primary btn-album borrar-mod-f"  title="Borrar album">Modificar foto</a>
      <a onclick="borrarf(<?php echo $value->idfoto; ?>);" class="glyphicon glyphicon-trash btn-borrar borrar-mod-f" title="Borrar foto <?php echo $title; ?>"></a>
      
      <?php } ?>
      </div>
      <?php   } ?>
  </div>
</div>

<!-- modal fotos
========================================================================== -->

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
        <span id="final"></span>
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

<!-- ventana de modificacion de foto
======================================================================================= -->

<div class="modal log" id="modf">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">
        <form class="form-horizontal" action="fotos.php" method="POST">
        <fieldset>
          <legend>Modificar Foto</legend>
          <div class="form-group">
            <label for="titl" class="col-lg-2 control-label">Titulo Foto</label>
            <div class="col-lg-10">
              <input type="text" class="form-control" id="titl" name="titl" placeholder="Ingrese un Titulo">
              <input type="hidden" value="" id="idfot" name="idfot">
            </div>
          </div>

           <div class="form-group">
              <label class="col-lg-2 control-label">Privacidad</label>
              <div class="col-lg-10" >
                <div class="radio">
                  <label >
                  <span  class="pull-right"> Publica  </span>
                    <input type="radio" name="priva" id="rad" value="1" >

                  </label>
                </div>
                <div class="radio">
                  <label >
                    <span  class="pull-right">Privada</span>
                    <input type="radio" name="priva" id="rad1" value="0" >
                     
                  </label>
                </div>
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


<?php include("modal-anadir-foto.php"); ?>

<?php include("footer.php"); ?>