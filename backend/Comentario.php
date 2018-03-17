<?php 
include_once("conexion.php");
/**
* 
*/
class Comentario {
	private $idcomentario;
	private $comentario;
	private $idusuario;
	private $idfoto;
	private $fecha;
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
		$this->idcomentario = $datos['idcomentario']; 
		$this->comentario = $datos['comentario'];
		$this->idfoto = $datos['idfoto'];
		$this->idusuario = $datos['idusuario'];
		$this->fecha = $datos['fecha'];
	}

	function __get ($nombre){
		return $this->$nombre;
	}
	function __set($nombre , $valor){
		$this->$nombre = $valor;
	}

	function CrearComentario ($idfoto , $comentario , $idusuario){
		$fecha = date("Y-m-d ") ." a las ". date("G:i");
		$this->conexion->connect();
		$query = "INSERT INTO comentarios (idfoto , comentario , idusuario, fecha) VALUES ($idfoto , '$comentario' , $idusuario, '$fecha')";
		$this->conexion->query($query);
		$this->conexion->close();
	}

	static function DevolverComentarios($idfoto){
		$conexion = new conexion();
		$conexion->connect();
		$query = "SELECT * FROM comentarios WHERE idfoto = $idfoto";
		$resultados = $conexion->query($query);
		$conexion->close();	
		return $resultados;
	}

	
	static function EliminarComentario ($idcomentario){
		$conexion = new conexion();
		$conexion->connect();
		$query = "DELETE FROM comentarios WHERE idcomentario = $idcomentario";
		$conexion->query($query);
		$conexion->close();	
	}

	static function EliminarComentarios ($idfoto){
		$conexion=new conexion();
		$conexion->connect();
		$query = "DELETE FROM comentarios WHERE idfoto = $idfoto";
		$conexion->query($query);
		$conexion->close();	
	}

}

?>