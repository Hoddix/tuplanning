
<?php 
	include_once('claseConexion.php');
	$objConexion = new Conexion("localhost", "root", "", "tuplanning");
	$objConexion->conectarServidor();
	$objConexion->seleccionarBaseDatos();

	class claseCalendarios{

		public $nombrecal;
		public $usuario;
		//Revibimos los parametros necesarios para guardar calendarios
		function __construct($nom,$user){
			$this->usuario = $user;
			$this->nombrecal = $nom;
		}
		//Funcion que guarda los calendarios que crea el usuario
		function guardarCalendarios(){
			session_start();//Iniciamos sesion
			//Consultamos en la base de datos si ya existe el calendario que queremos crear.
			$query = 'select nombrecal from calendarios where nombrecal="'.$this->nombrecal.'" and usuario="'.$this->usuario.'"';
			$consulta = mysql_query($query);
			$nombrecal = mysql_num_rows($consulta);
			//Si existe nos da error, en el caso de que no exist, lo crea.
			if($nombrecal == 0){
				$query = "insert into calendarios values('".$this->nombrecal."','".$this->usuario."')";
				if(@mysql_query($query)){
					header("location: ../crearcalendarios.php");
				}else{
					$_SESSION['textor'] = "No se ha podido crear el calendario porque ya existe";
					header("location: ../crearcalendarios.php");	
				}
			}else{
				$_SESSION['textor'] = "No se ha podido crear el calendario porque ya existe";
				header("location: ../crearcalendarios.php");
			}
		}
		//Cargamos los calendarios cuando se necesita
		static function cargarCalendarios($user){
			$result="";
			$query = 'select * from calendarios where usuario="'.$user.'"';
			$consulta = mysql_query($query);
			while($row=mysql_fetch_array($consulta)){
				$result[] = $row;
			}
			return $result;
		}
		//Cargamos el calendario por defecto del usuario
		static function cargarCalendarioDefecto($user){
			$result="";
			$query = 'select calendario from usuarios where usuario="'.$user.'"';
			$consulta = mysql_query($query);
			while($row=mysql_fetch_array($consulta)){
				$result[] = $row;
			}
			return $result;
		}
		//Funcion que borra calendarios, cuando quiera el usuario
		static function borrarCalendarios($usuario,$nombrecal){
	    	$query = 'UPDATE eventos SET nombrecal = "Calendario por defecto" WHERE  usuario = "'.$usuario.'" and nombrecal = "'.$nombrecal.'"';
	    	 if(mysql_query($query)){
				$query = 'delete from calendarios where usuario="'.$usuario.'" and nombrecal="'.$nombrecal.'"';
	            if(mysql_query($query)){
	            	echo 'Calendario eliminado';
	            }
            }

        }

	}






?>
