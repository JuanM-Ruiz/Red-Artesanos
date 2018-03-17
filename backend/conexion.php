<?php 
	class conexion 
	{
		
		private $conexion;
		private $error;

		
		public function connect(){

			$this->conexion = new mysqli('localhost','root','12345','artesanos');
			if (!$this->conexion->connect_errno){
				$this->error = $this->conexion->connect_error;
				
			}
		
		}

		public function close(){
			$this->conexion->close();
		}

		public function query($query){
			$tipo = strtoupper(substr($query,0,6));
		
		switch ($tipo){
			case 'SELECT':
				$resultado = $this->conexion->query($query);
				if (!$resultado){
					$this->error = $this->conexion->error;
					return false;
				}
				else{
					if ($this->conexion->affected_rows == 0){

						return false;
					}
					else{
						while ($fila = $resultado->fetch_assoc()){
							$array_resultado[] = $fila;
						}
						return $array_resultado;
					}
			}
			break;
			case 'INSERT':
				$resultado = $this->conexion->query($query);
				if (!$resultado){
					$this->error = $this->conexion->error;
					return false;
				}
				else{
					return $this->conexion->insert_id;
				}
				break;
			case 'DELETE':
				$resultado = $this->conexion->query($query);
				if (!$resultado){
					$this->error = $this->conexion->error;
					return false;
				}
				else{
					return $this->conexion->affected_rows;
				}		
				break;
			case 'UPDATE':
				$resultado = $this->conexion->query($query);
				if (!$resultado){
					$this->error = $this->conexion->error;
					return false;
				}
				else{
					return $this->conexion->affected_rows;
				}		
				break;
			default:
				$this->error = "Tipo de consulta no permitida";
		}


		}
	}

 ?>