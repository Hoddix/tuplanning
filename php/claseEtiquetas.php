
<?php 
	include_once('claseConexion.php');
	$objConexion = new Conexion("localhost", "root", "", "tuplanning");
	$objConexion->conectarServidor();
	$objConexion->seleccionarBaseDatos();

	class claseEtiquetas{

		public $nombre;
		public $color;
		public $usuario;
		//Recibimos parametros necesarios para crear etiquetas
		function __construct($nom,$user,$col){
			$this->usuario = $user;
			$this->nombre = $nom;
			$this->color = $col;
		}
		//Mostramos la lista de colores por defecto de la web
		static function listaDeColores(){
			$result="";
			$query = 'select * from colores';
			$consulta = mysql_query($query);
			while($row=mysql_fetch_array($consulta)){
				$result[] = $row;
			}
			return $result;
		}
		//Funcion que guarda las etiquetas que crea el usuario
		function guardarEtiquetas(){			
			session_start();//Iniciamos sesion
			//Comprobamos que no exista la etiqueta que queremos crear, en el caso de que exista, nos avisa que ya esta creada
			$query = 'select etiqueta,color from etiquetas where etiqueta="'.$this->nombre.'" and usuario="'.$this->usuario.'" and color="'.$this->color.'"';
			$consulta = mysql_query($query);
			$etiqueta = mysql_num_rows($consulta);
			//Si la etiqueta esta sin crear, la crea y actualizar la web
			if($etiqueta == 0){
				$query = "insert into etiquetas values('".$this->nombre."','".$this->usuario."','".$this->color."')";
				if(@mysql_query($query)){
					header("location: ../crearetiquetas.php");		
				}else{
					$_SESSION['textor'] = "No se ha podido crear la crearetiquetas porque ya existe";
					header("location: ../crearetiquetas.php");
				}
			}else{
				$_SESSION['textor'] = "No se ha podido crear la crearetiquetas porque ya existe";
				header("location: ../crearetiquetas.php");
			}
		}
		//Mostramos las etiquetas del usuario cuando se necesite
		static function cargarEtiquetas($user){
			$result="";
			$query = 'select * from etiquetas where usuario="'.$user.'"';
			$consulta = mysql_query($query);
			while($row=mysql_fetch_array($consulta)){
				$result[] = $row;
			}
			return $result;
		}
		//Funcion que borra las etiquetas cuando el usurio quiera
	    static function borrarEtiqueta($usuario,$etiqueta,$color){
	    	$query = 'UPDATE eventos SET etiqueta = "colord" WHERE usuario = "'.$usuario.'" and etiqueta = "'.$color.'"';
	    	 if(mysql_query($query)){
				$query = 'delete from etiquetas where usuario="'.$usuario.'" and etiqueta="'.$etiqueta.'"';
	            if(mysql_query($query)){
	            	echo 'Etiqueta eliminada';
	            }
            }

        }



	}






?>
