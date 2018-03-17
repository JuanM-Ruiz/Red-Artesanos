<?php 

include_once("conexion.php");
include_once("Album.php");
class Usuario {
	private $idusuario;
	private $nombre_usuario;
	private $pass;
	private $nombre;
	private $email;
	private $antecedentes;
	private $intereses;
	private $urlfoto;
	private $fotoperfil;
	private $conexion;
	private $solicitudes=array();
	private $siguiendo=array();
	private $seguidores=array();
	private $albums = array();
	private $AlbumSeguido;
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
		$this->email = $datos[0]['email'];
		$this->idusuario =$datos[0]['id'];
		$this->nombre_usuario =$datos[0]['nombre_usuario'];
		$this->nombre =$datos[0]['nombre'];
		$this->antecedentes =$datos[0]['antecedentes'];
		$this->intereses =$datos[0]['intereses'];
		$this->fotoperfil =$datos[0]['fotoperfil'];
		$this->urlfoto = $datos[0]['urlfoto'];
	}

// Logearse
// =============================================

	function iniciarSecion ($email, $pass){

		$this->conexion->connect();
		// comprueba la validacion de los datos ingresados para inisio de secion.
		$query = "SELECT * FROM usuarios WHERE email = '$email'";
		$resultado = $this->conexion->query($query);
		
		if ($resultado!="") {
			if ($pass == $resultado[0]['contrasena']){
				
				$this->email = $resultado[0]['email'];
				$this->idusuario =$resultado[0]['id'];
				$this->nombre_usuario =$resultado[0]['nombre_usuario'];
				$this->nombre =$resultado[0]['nombre'];
				$this->antecedentes =$resultado[0]['antecedentes'];
				$this->intereses =$resultado[0]['intereses'];
				$this->fotoperfil =$resultado[0]['fotoperfil'];
				$this->devolversolicitudes();
			} else {
				return false;
			}
			
		}else {
				return false;

			}
		
		// recupera la foto de perfil del usuario.
		$query = "SELECT * FROM historialfoto WHERE idfoto = $this->fotoperfil";
		$resultado = $this->conexion->query($query);

		if($resultado){
			$this->urlfoto = $resultado[0]['urlfoto'];
		}
		$this->conexion->close();
		return true;
	}

	function __get ($nombre){
		return $this->$nombre;
	}
	function __set($nombre , $valor){
		$this->$nombre = $valor;
	}

// Registro de usuarios
// ==========================================
	function RegistroUsuario ($email, $pass, $nom, $user) {
		
		
		// valida datos y los inserta en la base de datos para el alta de un nuevo usuario.
		$comp=$this->validarEmaliUser ($email, $user);
		if ($comp['email']) {
			return "<span class='error'> El e-mail ya esta en uso </span>";
		}elseif ($comp['user']) {
			return "<span class='error'> El usuario ya esta en uso </span>";
		}else{
			$this->conexion->connect();
			$query = "INSERT INTO usuarios (email, contrasena, nombre , nombre_usuario , fotoperfil ) VALUES ('$email' , '$pass', '$nom', '$user', -1 )";
			$this->idusuario = $this->conexion->query($query);
			echo "<span class='exito'> Registrado con exito</span>";	
			$album = new Album();
			$album->CrearAlbum ($this->idusuario , $user);
			$this->conexion->close();

		}
		
	}

private function validarEmaliUser ($email, $user){
	$this->conexion->connect();
	// valida el email
	$query = "SELECT email FROM usuarios WHERE email = '$email'";
	$resultado = $this->conexion->query($query);
	$query = "SELECT nombre_usuario FROM usuarios WHERE nombre_usuario = '$user'";
	$resultadouser = $this->conexion->query($query);
	return array ('email' => $resultado[0]['email'], 
				  'user'  => $resultadouser[0]['nombre_usuario']);
	$this->conexion->close();

}

// añade los albumes pertenecientes al usuario
// =======================================================

	function AddAlbums (){
		$albums = Album::DevolverAlbums($this->idusuario);
		$alb = array ();
		if ($albums) {
			foreach ($albums as $key => $value) {
				$alb[] = new Album($value);
				
			}	
		}
		
		$this->albums=$alb;
		unset($alb);
	}


// devuelve un usuario especifico 
// =======================================================

	 function usuarios ($idusuario) {
		$this->conexion->connect();
		$query = "SELECT id, nombre , nombre_usuario , antecedentes , intereses , fotoperfil, email FROM usuarios WHERE id = $idusuario";
		$resultado = $this->conexion->query($query);
		$res = $resultado[0]['fotoperfil'];
		
		$query = "SELECT urlfoto FROM historialfoto WHERE idfoto = $res";

		$foto=$this->conexion->query($query);
		$resultado[0]['urlfoto']=$foto[0]['urlfoto'];
		return $resultado;

	}

// Perfil 
// ==========================================


// cambiar contraseña
// ================================================

	function CambiarContrasena ($passactual, $inputpass){

		$this->conexion->connect();
		$query="SELECT contrasena FROM usuarios WHERE id=$this->idusuario AND contrasena = '$passactual'";
		$resultado = $this->conexion->query($query);

		if ($resultado) {
			$query ="UPDATE usuarios SET contrasena='$inputpass' WHERE id=$this->idusuario";
			$this->conexion->query($query);
			echo "Contraseña modificada correctamente";
		}
		$this->conexion->close();

	}


	function ActualizarPerfil ($datos) {
		// cambio de foto perfil y la inserta en la base de datos del historial de fotos
		
			if($datos['foto']!=""){
				$this->conexion->connect();
				$cant = $this->conexion->query("SELECT * FROM historialfoto WHERE idusuario = $this->idusuario");
				if ($cant[0]['idfoto']=="") {
					$cant=0;
				}else {
					$cant = sizeof($cant);
				}

				$ub = "img/perfiles/$this->idusuario $cant.jpg";
				copy($datos['foto'] , $ub);
				$query = "INSERT INTO historialfoto (urlfoto, idusuario) values ('$ub', $this->idusuario)";
				$this->fotoperfil = $this->conexion->query($query);
				$this->urlfoto = $ub;
				$this->conexion->close();
			}

			$comp= $this->validarEmaliUser ( $datos['email'],  $datos['nombre_usuario']);
			if ($comp['email']  && $comp['email'] != $this->email) {
				echo "<div class='container'><span class='error'> El e-mail ya esta en uso </span></div>";
			}elseif ($comp['user'] && $comp['user'] != $this->nombre_usuario) {
				echo "<div class='container'><span class='error'> El usuario ya esta en uso </span></div>";
			}else{
			$this->conexion->connect();
			// actualizar atributos del objeto actual.
			$this->email = $datos['email'];
			$this->nombre_usuario =$datos['nombre_usuario'];
			$this->nombre =$datos['nombre'];
			$this->antecedentes =$datos['antecedentes'];
			$this->intereses =$datos['intereses'];
			
			// actualizacion de datos de perfil en la base de datos.
			$a = $this->nombre;
			$query = "UPDATE usuarios SET nombre = '$this->nombre' , nombre_usuario = '$this->nombre_usuario' , email = '$this->email' , antecedentes = '$this->antecedentes' , intereses = '$this->intereses' , fotoperfil = $this->fotoperfil WHERE id = $this->idusuario";
			$this->conexion->query($query);
			$this->conexion->close();
			}

		
	}

// Buscar usuario
// =====================================
	function buscar($nombre){
		
		$this->conexion->connect();
		$users=array();
		// selecciona usuarios segun la busqueda por nombre
		$query = "SELECT id , nombre , nombre_usuario , email ,  fotoperfil FROM usuarios WHERE nombre LIKE '%".$nombre."%'";
		$resultados = $this->conexion->query($query);
		$this->conexion->close();
		if ($resultados) {
			foreach ($resultados as $key => $value) {
				$res = $this->usuarios($value['id']);
				$users[]=$res[0];
			}
		}
		$this->conexion->connect();
		// elimina resultados que ya enviaron solicitudes o son seguidores.
		// obtiene solicitudes
		
		$query = "SELECT idusuario FROM solicitudes WHERE idseguidor = $this->idusuario";
		$solicitudes = $this->conexion->query($query);		
		// obtiene seguidores
		
		$query = "SELECT idusuario FROM seguidores WHERE idseguidor = $this->idusuario";
		$seguidores = $this->conexion->query($query);
			$this->conexion->close();
		// une resultados seguidores y solicitudes
		if ($seguidores && $solicitudes) {
				$nobuscar = array_merge($solicitudes, $seguidores);
		} elseif (!$seguidores) {
			$nobuscar =$solicitudes;
		}elseif (!$solicitudes) {
			$nobuscar = $seguidores;
		} 
		
		// elimina seguidores y solicitudes enviadas de las busquedas
		if ($nobuscar) {
			foreach ($users as $key => $value) {
				foreach ($nobuscar as  $seg) {
					if ($value['id'] == $seg['idusuario']) {
						unset($resultados[$key]);
					}
				}
			}	
		}
		
		// retorna resultados
		if ($resultados) {
		return $resultados;
		}else {
			return false;
		}
	
	}

	
// solicitudes
// ==================================

	function enviarsolicitud($user){

		$this->conexion->connect();
		
		// busca la persona a seguir
		$user=trim($user);
		$query = "SELECT id FROM usuarios WHERE nombre_usuario = '$user'";

		$resultado = $this->conexion->query($query);

		// inserta la solicitud de seguimiento
		$res = $resultado[0]['id'];
		$query = "INSERT INTO solicitudes (idusuario , idseguidor ) VALUES ($res , $this->idusuario )";
		$resultado = $this->conexion->query($query);

		$this->conexion->close();
	}

	function Devolversolicitudes () {
		$this->conexion->connect();
		// recupera datos de usuarios que enviaron solicitud
		$query="SELECT idseguidor FROM solicitudes WHERE idusuario = $this->idusuario";
		$resultados = $this->conexion->query($query);
		if ($resultados) {
				
				$resultado = $this->usuarios($resultados[0]['idseguidor']);	
				$this->solicitudes[] = new Usuario($resultado);		
		}
		
	}

	function RechazarSolicitud($id){
		$this->conexion->connect();

		foreach ($this->solicitudes as $key => $value) {
			
			if ($value->idusuario == $id) {
				unset($this->solicitudes[$key]);
			}
		}
		$query = "DELETE FROM solicitudes WHERE idusuario = $this->idusuario and idseguidor = $id";
		$this->conexion->query($query);
		return $id;
		$this->conexion->close();
	}

	function AceptarSolicitud ($id) {
		$this->conexion->connect();
		$id=$this->RechazarSolicitud($id);
		$query="INSERT INTO seguidores (idseguidor , idusuario) VALUES ($id, $this->idusuario)";
		$this->conexion->query($query);
		$this->conexion->close();
		

	}


// usuario a los que se sigue 
//======================================================= 

	
	function DevolverSeguidores ()  {
		$this->conexion->connect();
		$query="SELECT idseguidor FROM seguidores WHERE idusuario= $this->idusuario";
		$resultados= $this->conexion->query($query);

		$this->conexion->close();
		if($resultados){
			foreach ($resultados as $key => $value) {
				$resultado = $this->usuarios($value['idseguidor']);
				$this->seguidores[] = new Usuario($resultado);
			}
			
		}
		
	}

	function BorrarSeguidor ($idseguidor , $nombre_usuario){
		$this->conexion->connect();
		$query="DELETE FROM seguidores WHERE idusuario = $this->idusuario and idseguidor = $idseguidor";

		$this->conexion->query($query);
		$query="DELETE FROM albums WHERE idusuario = $this->idusuario and tituloalbum = '$this->nombre_usuario'";
		$this->conexion->query($query);
		$this->conexion->close();
	}

// Usuarios seguidos
// ================================================
	function BorrarSiguiendo ($idsig){
		$this->conexion->connect();
		$query="DELETE FROM seguidores WHERE idseguidor= $this->idusuario and idusuario = $idsig";
		$this->conexion->query($query);
		$this->conexion->close();
	}

	function DevolverSiguiendo ()  {
		$this->conexion->connect();
		$query="SELECT idusuario FROM seguidores WHERE idseguidor= $this->idusuario";
		$resultados= $this->conexion->query($query);
		$this->conexion->close();
		if($resultados){
			foreach ($resultados as $key => $value) {
				$resultado = $this->usuarios($value['idusuario']);
				$this->siguiendo[] = new Usuario($resultado);	
			}
			
			
		}

		
	} 
// devuelve los albumes de los usuarios que se esta siguiendo
// ===========================================================
	function AlbumSeguido ($nombre_usuario)  {
		$this->conexion->connect();
		$nombre_usuario = trim($nombre_usuario);
		$query="SELECT * FROM albums WHERE tituloalbum = '$nombre_usuario'";
		$resultados = $this->conexion->query($query);
		$this->conexion->close();
		$datos['idalbums']=$resultados[0]['idalbums'];
		$datos['idusuario']=$resultados[0]['idusuario'];
		$datos['tituloalbum']=$resultados[0]['tituloalbum'];
		
		$this->AlbumSeguido = new Album($datos);
	}


// devolver todas las fotos de perfil
// =======================================================================

function FotosPerfil(){
	$this->conexion->connect();
	$query="SELECT * FROM historialfoto WHERE idusuario = $this->idusuario";
	$resultados = $this->conexion->query($query);
	$this->conexion->close();
	return $resultados;
}

}

?>