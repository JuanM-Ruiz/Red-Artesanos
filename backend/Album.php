<?php 
include_once("conexion.php");
include_once("Foto.php");
class Album
{
	private $idalbum;
	private $tituloalbum;
	private $idusuario;
	private $fotos=array();
	private $fotospublicas=array();
	function __construct(){
		$numargs = func_num_args();
		$getargs = func_get_args();
		if ($numargs == 0) {
			$this->conexion = new conexion();
		} elseif ($numargs == 1) {
			self::__construct1($getargs[0]);
		}
	}

	function __construct1 ($datos){
		$this->conexion = new conexion();
		$this->idalbum = $datos['idalbums'];
		$this->idusuario = $datos['idusuario'];
		$this->tituloalbum = $datos['tituloalbum'];
	}

	function CrearAlbum ($idusuario , $tituloalbum , $datos=""){
		
		$this->conexion->connect();
		
		$query="SELECT * FROM albums WHERE tituloalbum = '$tituloalbum' and idusuario = $idusuario";
		$resultado = $this->conexion->query($query);
		
		if ($resultado) {
			$this->conexion->close();
			return "El album ya existe";
		}
		
		$query="INSERT INTO albums (idusuario , tituloalbum) VALUES ($idusuario , '$tituloalbum')";
		$idalbum=$this->conexion->query($query);
		$this->conexion->close();
		if($datos!=""){
			$carpeta = "img/".$idusuario;
			if (!file_exists($carpeta)) {
				mkdir($carpeta);
			}
			$carpeta = $carpeta ."/".$idalbum."/";
			if (!file_exists($carpeta)) {
				mkdir($carpeta);
			}

			Foto::AnadirFoto ( $datos[0] ,  $datos[1] , $tituloalbum , $idalbum , $idusuario,  $datos[2] , $datos[3]);
			echo "<script type='text/javascript'>";
			echo "redirpag('albums.php');";
			echo "</script>";
		}
	}

	static function ModificarAlbum($idalbum , $tituloalbum){
		if ($tituloalbum != "") {
			$conexion=new conexion();
			$conexion->connect();
			$query = "UPDATE albums SET tituloalbum = '$tituloalbum' WHERE idalbums = $idalbum";
			$conexion->query($query);
			$conexion->close();
		}
	}


	private function eliminar_directorio($dir){
		$result = false;
		if ($handle = opendir("$dir")){
			$result = true;
		while ((($file=readdir($handle))!==false) && ($result)){
			if ($file!='.' && $file!='..'){
				$result = unlink("$dir/$file");}}
				closedir($handle);
			if ($result){
				$result = rmdir($dir);
			}
	}
}
	function BorrarAlbum(){
		
		

		$carpeta= "img/$this->idusuario/$this->idalbum";
		$this->eliminar_directorio($carpeta);
		$this->conexion->connect();
		$query = "DELETE FROM albums WHERE idalbums = $this->idalbum";
		$this->conexion->query($query);
		$this->conexion->close();
		Foto::BorrarFotosAlbum($this->idalbum); 
	}

	function DevolverAlbum ($idalbum) {

		$this->conexion->connect();
		$query = "SELECT * FROM albums WHERE idalbums = $idalbum ";
		$resultados = $this->conexion->query($query);
		$this->conexion->close();
		$this->idalbum = $resultados[0]['idalbums'];
		$this->idusuario = $resultados[0]['idusuario'];
		$this->tituloalbum = $resultados[0]['tituloalbum'];
	
		
	}

	static function DevolverAlbums ($idusuario) {
		$conexion = new conexion();
		$conexion->connect();
		$query = "SELECT * FROM albums WHERE idusuario = $idusuario ";
		
		$resultados = $conexion->query($query);
		$conexion->close();
		return $resultados;
	}

	function __get ($nombre){
		return $this->$nombre;
	}
	function __set($nombre , $valor){
		$this->$nombre = $valor;
	}

function AddFotos (){
		$fotos = Foto::DevolverFotos($this->idalbum);
		$foto = array ();
		if ($fotos) {
			foreach ($fotos as $key => $value) {
				$foto[] = new Foto($value);
				
			}
		}
		
		$this->fotos=$foto;
		unset($foto);
		return $this->fotos;
	}

	function FotosPublicas ($idusuario) {
		$this->conexion->connect();
		$query = "SELECT * FROM fotos WHERE privacidad = 1 and idalbum IN (SELECT idalbums FROM albums WHERE idusuario = $idusuario)";

		$resultados = $this->conexion->query($query);
		$this->conexion->close();
		if($resultados){
			foreach ($resultados as $key => $value) {
				$datos['idalbum']=$value['idalbum']; 
				$datos['idfoto']=$value['idfoto'];
				$datos['titulofoto']=$value['titulofoto'];
				$datos['privacidad']=$value['privacidad'];
				$datos['urlfoto']=$value['urlfoto'];
				$this->fotospublicas[]= new Foto($datos);
			}
			
		}
	}


}

?>