<?php

	include_once('claseConexion.php');
  	$Conexion = new Conexion("localhost", "root", "", "tuplanning");
    $Conexion->conectarServidor();
    $Conexion->seleccionarBaseDatos();

class claseUsuarios {

    public $nombre;
    public $apellidos;
    public $fechanacimiento;
    public $provincia;
    public $telefono;
    public $calendario;
    public $email;
    public $usuario;
    public $password;

    function __construct($nom, $ape, $fechan, $prov, $tel, $cal, $ema, $ser, $pass){
        $this->nombre = $nom;
        $this->apellidos = $ape;
        $this->fechanacimiento= $fechan;
        $this->provincia = $prov;
        $this->telefono = $tel;
        $this->calendario = $cal;
        $this->email = $ema;
        $this->usuario = $ser;        
        $this->password = $pass;
    }
	//Generamos el sal con que crearemos el hash para codificar el pass del usuario
	function generarSal(){
		$salAleatorio = "";
		$length = 64; //Indicamos que el tamaño es de 64 chars
		$indice = "";
		$charElegido = "";
		$listaCaracteres = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"; //Lista de caracteres para hacer el sal
		settype($length, "integer");
		settype($salAleatorio, "string");
		settype($indice, "integer");
		settype($charElegido, "integer");
		//Generamos el sal
		for ($indice = 0; $indice <= $length; $indice++) {
			$charElegido = rand(0, strlen($listaCaracteres) - 1);
			$salAleatorio .= $listaCaracteres[$charElegido];
		}
		//Retornamos el sal para generar el pass, cada usuario tiene un sal diferente
		return $salAleatorio;
	}
	//Generamos el pass haseado con el sal
	function generarPassword(){
		$salAleatorio = self::generarsal();
		$passwordHaseado = hash('SHA256', "-".$salAleatorio."-".$this->password."-");
		//Retornamos el hash y pass haseado para guardarlos en la bd 
		return $packEncriptado = array('0' => $salAleatorio,'1' => $passwordHaseado);
	}
	//Añadimos el usuario
	function anadirUsuario(){
		//Comprobamos que el usuario no este cogido por otra persona
		$query = 'select usuario from usuarios where usuario="'.$this->usuario.'"';
		$consulta = mysql_query($query);
		$usuario = mysql_num_rows($consulta);
		//Comprobamos que el email no este cogido por otra persona
    	$query = 'select email from usuarios where email="'.$this->email.'"';
		$consulta = mysql_query($query);
		$email = mysql_num_rows($consulta);
		//En el caso de que esten libres usuario y email registramos al usuario
		if($usuario == 0 && $email == 0){
			$packEncriptado  = self::generarPassword();
			$query = "insert into usuarios(nombre,apellidos,fechanacimiento,provincia,telefono,calendario,email,usuario,password,user_hash,tempcode) values('".$this->nombre."','".$this->apellidos."','".$this->fechanacimiento."','".$this->provincia."','".$this->telefono."','','".$this->email."','".$this->usuario."','".$packEncriptado[1]."','".$packEncriptado[0]."','')";
			if(@mysql_query($query)){
				//Al registrar al usuario le creamos un calendario por defecto
				$query = "INSERT INTO calendarios (nombrecal,usuario) VALUES ('Calendario por defecto','".$this->usuario."')";
				if(@mysql_query($query)){
					//Le asignamos el calendario por defecto
					$query = "UPDATE usuarios SET calendario = 'Calendario por defecto' WHERE  usuario = '".$this->usuario."'";
					if(@mysql_query($query)){
						session_start(); //Iniciamos session
						//Guardamos el usuario para relizar las consultas
						$_SESSION['usuario'] = $this->usuario;
						$_SESSION['nombrecal'] = 'Calendario por defecto';
						//Si la sesion es correcta, en las posteriores paginas nos mostrara el contenido.
						$_SESSION['in'] = true;
						header('Location: ../calendario.php');
					}
				}
			}
			else{
				session_start(); //Iniciamos sesion
				//Mensaje de error cuando el usuario no se ha podido crear
				$_SESSION['textor'] = 'El usuario o el email ya existen.';
				header('Location: ../index.php');
			}
		}else{
			session_start(); //Iniciamos sesion
			//Mensaje de error cuando el usuario o el email estan ya en uso
			$_SESSION['textor'] = 'El usuario o el email ya existen.';
			header('Location: ../index.php');
		}

	}
	//Funcion de inicio de sesion
    static function loginUsuario($usuario,$password){
    	//Obtenemos el hash del usuario que quiere iniciar sesion
    	$query = 'select user_hash from usuarios where usuario="'.$usuario.'"';
		$consulta = mysql_query($query);
		$resultado = mysql_fetch_row($consulta);
		$hash = $resultado[0];
    	//Obtenemos el calendario del usuario que quiere iniciar sesion
    	$query = 'select calendario from usuarios where usuario="'.$usuario.'"';
		$consulta = mysql_query($query);
		$resultado = mysql_fetch_row($consulta);
		$cal = $resultado[0];		
		//Obtenemos los datos del usuario a partir del hash, para comprobar que es real
		$query = 'select nombre,usuario, password from usuarios where usuario="'.$usuario.'" and user_hash="'.$hash.'"';
		$consulta = mysql_query($query);
		$resultado = mysql_fetch_row($consulta);

		$password_db = $resultado[2];
		$usuario_db = $resultado[1];

		//Rehasehamos el password del usuario para ver si es igual que el de la base de datos
		$password_check = hash('SHA256', "-".$hash."-".$password."-");

		//Pasamos el usuario de la base de datos y el del campo de texto a minusculas
		//y comprobamos que el pass y el user sean iguales que el de la base de datos
		if(strtolower($usuario_db) === strtolower($usuario) && $password_db === $password_check){
			session_start(); //Iniciamos session
			//Guardamos unos parametros en sesiones
			$_SESSION['nombre'] = $resultado[0]; 
			$_SESSION['usuario'] = $resultado[1];
			$_SESSION['nombrecal'] = $cal;
			//En el caso de hacer login correcto, generamos sesion in para mostrar el contenido de la web
			$_SESSION['in'] = true;
			header('Location: ../calendario.php');
		}else{
			session_start(); //Iniciamos session
			$_SESSION['out'] = true; //Si el usuario no existe, volvemos a la pagina index y nos dice que el usuario no existe
			header('Location: ../index.php');
			echo 'Usuario no registrado';
		}		
    }
    //Funcion con la que recuperamos el password en caso de que se nos olvide
    static function recupearPassword($email){
    	session_start(); //Iniciamos session
    	$_SESSION['email'] = $email;//Guardamos el mail que mete el user para recuperar el pass
    	//Hacemos la consulta con el mail introducido y vemos si obtenemos algun dato
    	$query = 'select nombre from usuarios where email="'.$email.'"';
    	$consulta = mysql_query($query);
    	while($row=mysql_fetch_row($consulta)){
    		$result = $row;
    	}
    	//En el caso de obtener un dato, entramos
    	if(!empty($result)){
    		//Obtenemos la direccion del server
    		$domain = $_SERVER['HTTP_HOST'];  
    		//Generamos la url
			$url = "http://" . $domain; 
	    	$nombre = $result[0];
	    	//Generamos un ID_temporal a partir del nombre del usuario
	    	$id_temp = hash('SHA256', $nombre.$nombre);
	    	//introducimos ese id en la base de datos
			$query = 'UPDATE usuarios SET tempcode="'.$id_temp.'" WHERE email="'.$email.'"';    	
			if (mysql_query($query)) {
				//Escribimos los datos para mandar el mail de recuperacion de contraseña
				$headers = "From:Recuperar password <hoddix@hotmail.com>";  
				$texto_email = "Para recuperar tu contrasenia dar click en la url de abajo.	".$url."/nuevopass.php?id=".$id_temp."&email=".$email."";
				$texto_email .= "Tambien puedes introducir este codigo: ".$id_temp." en ".$url."/codigo.php";
				
				if (mail($email,"Recuperar password",$texto_email,$headers)){
					//cuando envia el mail, nos muestra un mensaje y nos dirige a la pagina donde tenemos que introducir el codigo
					$_SESSION['textok'] = "Email enviado correctamente.";
					header('Location: ../codigo.php');
				}else{
					//En el caso contrario, nos retorna a la web del email para que metamos uno correcto
					$_SESSION['textor'] = "No se ha podido enviar el email.";
					header('Location: ../recpass.php');
				}
			}else{
				echo 'No se ha podido generar el mail';
			}
		}else{
			echo 'Email incorrecto';
		}

    }
    //Funcion que comprueba que el codigo sea correcto
    static function comprobarCodigo($codigo){
    	session_start();
    	//Hacemos una consulta con el codigo introducido 
    	$query = 'select * from usuarios where tempcode="'.$codigo.'"';
		$consulta = mysql_query($query);
		if(mysql_num_rows($consulta) > 0){
			//Si entra, el codigo es correcto
			$_SESSION['textok'] = "Codigo verificado correctamente.";
			header('Location: ../nuevopass.php');
		}else{
			//codigo erroneo
			$_SESSION['textor'] = "El codigo introducido no existe.";
			header('Location: ../codigo.php');
		}
    }
    //Funcion para cambiar el password
    static function cambiarPassword($email,$password){
    	//Obtenemos el hash y el user a partir del mail del usuario que quiere recuperar el pass
    	$query = 'select user_hash,usuario from usuarios where email="'.$email.'"';
		$consulta = mysql_query($query);
		$resultado = mysql_fetch_row($consulta);
		$hash = $resultado[0];
		$usuario = $resultado[1];
		//Haseahmos el nuevo pass del user
		$password_hash = hash('SHA256', "-".$hash."-".$password."-");
		//Actualizamos la base de datos
		$query = 'UPDATE usuarios SET password="'.$password_hash.'" WHERE email="'.$email.'"';  
		if (mysql_query($query)) {
			session_start();
			//Hacemos login con el nuevo pass
			self::loginUsuario($usuario,$password);
		}else{
			session_start();
			//Error, volvemos al paso anterior
			$_SESSION['out'] = true;
			header('Location: ../nuevopass.php');
		}
    }
	//Obtenemos los datos del usuario para meterlos en el form de editar usuario
    static function completarUsuario($usuario){
    	$query = 'select * from usuarios where usuario="'.$usuario.'"';
		$consulta = mysql_query($query);
		$resultado = mysql_fetch_row($consulta);
		
		return $resultado;
    }

    function actualizarUsuario(){
    	//Obtenemos el hash y el password, por si el usuario decide o no cambiarlo
    	$query = 'select user_hash,password from usuarios where usuario="'.$this->usuario.'"';
		$consulta = mysql_query($query);
		$resultado = mysql_fetch_row($consulta);
		$hash = $resultado[0];
		//Si el campo del pass esta vacio, no hacemos nada
		if($this->password != ""){
			$password_hash = hash('SHA256', "-".$hash."-".$this->password."-");
		}else{
			$password_hash = $resultado[1];
		}
		$fecha = date("Y-n-d",strtotime($this->fechanacimiento));
    	//Realizamos el update
    	$query = 'UPDATE usuarios SET nombre="'.$this->nombre.'",apellidos="'.$this->apellidos.'",fechanacimiento="'.$fecha.'",
    	provincia="'.$this->provincia.'",telefono="'.$this->telefono.'",calendario="'.$this->calendario.'",email="'.$this->email.'",password="'.$password_hash.'"
    	WHERE usuario="'.$this->usuario.'"';
    	if (mysql_query($query)) {
			session_start();
			$_SESSION['nombrecal'] = $this->calendario;
			$_SESSION['in'] = true;
			header('Location: ../cuentauser.php');
		}else{
			session_start();
			$_SESSION['out'] = true;
			header('Location: ../cuentauser.php');
		}
    }

}


?>