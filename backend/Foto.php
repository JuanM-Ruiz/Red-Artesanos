<?php 
include_once("conexion.php");
include_once("Comentario.php");

class Foto {
	private $idfoto;
	private $idalbum;
	private $titulofoto;
	private $privacidad;
	private $urlfoto;
	private $comentarios=array();
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
		$this->idalbum = $datos['idalbum']; 
		$this->idfoto = $datos['idfoto'];
		$this->titulofoto = $datos['titulofoto'];
		$this->privacidad = $datos['privacidad'];
		$this->urlfoto = $datos['urlfoto'];
	}

	function __get ($nombre){
		return $this->$nombre;
	}
	function __set($nombre , $valor){
		$this->$nombre = $valor;
	}

	static function AnadirFoto ( $privacidad ,  $fotos , $album , $idalbum , $idusuario,  $titulofoto , $cantf) {
		$conexion = new conexion();
		$conexion->connect();
		// copia fotos al servidor
		$fin = 20 - $cantf;
		for ($key = 0 ; $key < sizeof($privacidad) ; $key++) {
			$fin--;
			if ($fin >= 0) {
				
			
			$carpeta = "img/".$idusuario."/".$idalbum."/";
			$name = $carpeta . ++$cantf .$fotos['name'][$key];
			move_uploaded_file($fotos['tmp_name'][$key], $name);

			// inserta foto en la base de datos
			if ($titulofoto[$key]== "") {
				$query="INSERT INTO fotos (privacidad , urlfoto, idalbum) VALUES ($privacidad[$key] , '$name', $idalbum)";
			} else {
	
				$query="INSERT INTO fotos (privacidad , urlfoto ,titulofoto, idalbum) VALUES ($privacidad[$key] , '$name', '$titulofoto[$key]' , $idalbum)";
			}
			
			$conexion->query($query);
			}
			}

		$conexion->close();
		
	}

	function ModificarFoto( $titulofoto , $privacidad){
		
			
			$this->conexion->connect();
			$query = "UPDATE fotos SET titulofoto = '$titulofoto', privacidad=$privacidad WHERE idfoto = $this->idfoto";
			$this->conexion->query($query);
			$this->conexion->close();
		
	}

	function BorrarFoto(){
		$this->conexion->connect();
		$query = "DELETE FROM fotos WHERE idfoto = $this->idfoto";
		$this->conexion->query($query);
		$this->conexion->close();
		Comentario::EliminarComentarios ($this->idfoto);
		
	}

	static function BorrarFotosAlbum ($idalbum){
		$fotos=self::DevolverFotos($idalbum);
	
		if ($fotos) {	
		
		foreach ($fotos as $key => $value) {
			Comentario::EliminarComentarios ($value['idfoto']);
				}
			}
	}

	function DevolverFoto($idfoto){
		
		$this->conexion->connect();
		$query = "SELECT * FROM fotos WHERE idfoto = $idfoto ";
		$resultado = $this->conexion->query($query);
		$this->conexion->close();
		$this->idalbum = $resultado[0]['idalbum']; 
		$this->idfoto = $resultado[0]['idfoto'];
		$this->titulofoto = $resultado[0]['titulofoto'];
		$this->privacidad = $resultado[0]['privacidad'];
		$this->urlfoto = $resultado[0]['urlfoto'];
		

	}

	function AddComentarios () {
		$comentarios = Comentario::DevolverComentarios($this->idfoto);
		$comentario =  array ();
		if ($comentarios) {
			foreach ($comentarios as $key => $value) {
				$comentario[] = new Comentario($value);
				
			}
		}
		$this->comentarios=$comentario;
		unset($comentario);
	}

	static function DevolverFotos($idalbum) {
		$conexion = new conexion();
		$conexion->connect();
		$query = "SELECT * FROM fotos WHERE idalbum = $idalbum ";
		$resultados = $conexion->query($query);
		$conexion->close();
		return $resultados;
	}

	static function FotosPublic ($idusuario ,$carga){
		$conexion = new conexion();
		$conexion->connect();
		$query = "SELECT * FROM fotos WHERE privacidad = 1 and idalbum IN (SELECT idalbums FROM albums WHERE idusuario IN (SELECT idusuario FROM seguidores WHERE idseguidor = $idusuario)) ORDER BY idfoto DESC LIMIT $carga[0], $carga[1]";
		$resultados=$conexion->query($query);
		$conexion->close();
		$fotospublicas=array();
		if($resultados){
		foreach ($resultados as $key => $value) {
			$datos['idalbum'] = $value['idalbum']; 
			$datos['idfoto'] = $value['idfoto'];
			$datos['titulofoto'] = $value['titulofoto'];
			$datos['privacidad'] = $value['privacidad'];
			$datos['urlfoto'] = $value['urlfoto'];
			$fotospublicas[] = new Foto($datos);		
		}
		}
		return $fotospublicas;
	}
}

?>