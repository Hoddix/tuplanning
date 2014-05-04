<?php
	include_once('claseCalendario.php');
	include_once('claseUsuarios.php');
	include_once('claseCalendarios.php');
	include_once('claseEventos.php');
	include_once('claseEtiquetas.php');

	session_start(); //Iniciamos session
	//Si pulsamos mesSiguiente, nos muestra el mes siguiente al que estamos viendo
if(isset($_POST['elegido'])){
	if($_POST['elegido']=="messig"){
		if($_SESSION['mesvisual']==12){
			$objsig = new calendario(  /*DIA*/date( "j",mktime(0, 0, 0, date("n"), 1 ,date("Y")) ), /*MES*/date( "n",mktime(0, 0, 0, $_SESSION['mesvisual']+1, 1 ,date("Y")) ), /*AÑO*/date( "Y",mktime(0, 0, 0, date("n"), 1 ,$_SESSION['yearvisual']+1) )  );
		}else{
			$objsig = new calendario(  /*DIA*/date( "j",mktime(0, 0, 0, date("n"), 1 ,date("Y")) ), /*MES*/date( "n",mktime(0, 0, 0, $_SESSION['mesvisual']+1, 1 ,date("Y")) ), /*AÑO*/date( "Y",mktime(0, 0, 0, date("n"), 1 ,$_SESSION['yearvisual']) )  );
		}

        $arrayvalue = $objsig->crearCalendarios();

        $_SESSION['mesvisual'] = $arrayvalue[1];
        $_SESSION['yearvisual'] = $arrayvalue[2];
        echo $arrayvalue[0];

	}
	//Si pulsamos mesAnterior, nos muestra el mes anterior al que estamos viendo
	elseif($_POST['elegido']=="mesant"){
		if($_SESSION['mesvisual']==1){
			$objant = new calendario(  /*DIA*/date( "j",mktime(0, 0, 0, date("n"), 1 ,date("Y")) ), /*MES*/date( "n",mktime(0, 0, 0, $_SESSION['mesvisual']-1, 1 ,date("Y")) ), /*AÑO*/date( "Y",mktime(0, 0, 0, date("n"), 1 ,$_SESSION['yearvisual']-1) )  );
		}else{
			$objant = new calendario(  /*DIA*/date( "j",mktime(0, 0, 0, date("n"), 1 ,date("Y")) ), /*MES*/date( "n",mktime(0, 0, 0, $_SESSION['mesvisual']-1, 1 ,date("Y")) ), /*AÑO*/date( "Y",mktime(0, 0, 0, date("n"), 1 ,$_SESSION['yearvisual']) )  );
		}
    
        $arrayvalue = $objant->crearCalendarios();

        $_SESSION['mesvisual'] = $arrayvalue[1];
        $_SESSION['yearvisual'] = $arrayvalue[2];
        echo $arrayvalue[0];
	}
	//Cuando pulsamos borrar calendario, nos elimina el calendari llamando a la clase calendarios
	elseif($_POST['elegido']=="borrarcal"){
		$usuario = $_SESSION['usuario'];
		$nombrecal = $_POST['E_nombrecal'];

		$result = claseCalendarios::borrarCalendarios($usuario,$nombrecal);
		echo $result;

	}
	//Cuando pulsamos borrar calendario, nos elimina el calendari llamando a la clase calendarios
	elseif($_POST['elegido']=="tempcal"){
		$_SESSION['nombrecal'] = $_POST['E_nombrecal'];
	}	
	//Si pulsamos en un evento, 
	//nos muestra todas sus caracteristicas a traves de los datos que obtiene de la clase eventos
	elseif($_POST['elegido']=="evento"){
		echo '<h1 class="h1size">Evento Seleccionado</h1>';
		$result = claseEventos::mostrarEventosDiarios($_POST['E_usuario'],$_POST['F_dia'],$_POST['F_mes'],$_POST['F_year'],$_POST['F_horai'],$_POST['F_horaf'],$_POST['E_titulo']);

		echo '<table>';
		echo '<tr>';
		echo '<td colspan="2"><h3 class="h3size">Titulo del evento:</h3></td><td colspan="2"><span class="estilo-evento" id="'.$result[0]['etiqueta'].'">'.$result[0]['titulo'].'</span></td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td><h3 class="h3size">Nombre del calendario: </h3></td><td><span class="spaneventos">'.$result[0]['nombrecal'].'</span></td>';
		echo '<td><h3 class="h3size">Fecha: </h3></td><td><span class="spaneventos">'.$result[0]['dia'].' - '.$result[0]['mes'].' - '.$result[0]['ano'].'</span></td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td colspan="2"><h3 class="h3size">Hora de inicio: </h3></td><td colspan="2"><span class="spaneventos">'.$result[0]['horai'].'</span></td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td colspan="2"><h3 class="h3size">Hora final: </h3></td><td colspan="2"><span class="spaneventos">'.$result[0]['horaf'].'</span></td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td colspan="2"><h3 class="h3size">Fecha de inicio: </h3></td><td colspan="2"><span class="spaneventos">'.$result[0]['fechai'].'</span></td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td colspan="2"><h3 class="h3size">Fecha final: </h3></td><td colspan="2"><span class="spaneventos">'.$result[0]['fechaf'].'</span></td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td><h3 class="h3size">Recordar: </h3></td><td colspan="3"><span class="spaneventos">'.$result[0]['recordar'].'</span></td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td><h3 class="h3size">Observaciones: </h3></td><td colspan="3"><span class="spaneventos">'.$result[0]['observaciones'].'</span></td>';
		echo '</tr>';
		echo '</table>';

		echo '<h5 class="h3size">Eliminar este evento: </h5><span id="eliminarEventhoy"><a href="#" onclick="borrarEvent(\''.$_POST['F_dia'].'\',\''.$_POST['F_mes'].'\',\''.$_POST['F_year'].'\',\''.$_POST['F_horai'].'\',\''.$_POST['F_horaf'].'\',\''.$result[0]['fechai'].'\',\''.$result[0]['fechaf'].'\',\''.$_POST['E_usuario'].'\',\''.$_POST['E_titulo'].'\',\'hoy\')"><img src="images/borrar.png" alt=""></a></span>';
		echo '<h5 class="h3size">Eliminar todo el evento: </h5><span id="eliminarEventtodo"><a href="#" onclick="borrarEvent(\''.$_POST['F_dia'].'\',\''.$_POST['F_mes'].'\',\''.$_POST['F_year'].'\',\''.$_POST['F_horai'].'\',\''.$_POST['F_horaf'].'\',\''.$result[0]['fechai'].'\',\''.$result[0]['fechaf'].'\',\''.$_POST['E_usuario'].'\',\''.$_POST['E_titulo'].'\',\'todo\')"><img src="images/borrarall.png" alt=""></a></span>';
		echo '<h5 class="h3size">Editar este evento: </h5><span id="eliminarEventhoy"><a href="#" onclick="editarEventhoy(\''.$_POST['F_dia'].'\',\''.$_POST['F_mes'].'\',\''.$_POST['F_year'].'\',\''.$_POST['F_horai'].'\',\''.$_POST['F_horaf'].'\',\''.$result[0]['fechai'].'\',\''.$result[0]['fechaf'].'\',\''.$_POST['E_usuario'].'\',\''.$_POST['E_titulo'].'\',\'todo\')" ><img src="images/editareh.png" alt=""></a></span>';
	}	
	//Cuando pulsamos borrar etiquetas, hace la llamada a la clase etiquetas
	elseif($_POST['elegido']=="borraretiqueta"){
		$usuario = $_SESSION['usuario'];
		$etiqueta = $_POST['E_etiqueta'];
		$color = $_POST['E_color'];

		$result = claseEtiquetas::borrarEtiqueta($usuario,$etiqueta,$color);
		echo $result;
	}	
	//Cuando pulsamos borrar evento, hace la llamada a la clase evento
	elseif($_POST['elegido']=="borrarevento"){
		$usuario = $_SESSION['usuario'];
		$titulo = $_POST['E_titulo'];
		$horai = $_POST['F_horai'];
		$horaf = $_POST['F_horaf'];
		$fechai = $_POST['F_fechai'];
		$fechaf = $_POST['F_fechaf'];
		$dia = $_POST['F_dia'];
		$mes = $_POST['F_mes'];
		$year = $_POST['F_year'];
		$tipo = $_POST['E_tipodel'];

		if($tipo == "todo"){
	    	$result = claseEventos::borrarTodoElEvento($usuario,$fechai,$fechaf,$titulo);
    		echo $result;
		}
		elseif($tipo == "hoy"){
			$result = claseEventos::borrarEventoDeHoy($usuario,$dia,$mes,$year,$horai,$horaf,$titulo);
			echo $result;
		}
	}
}else{
	//Si pulsamos editamos el  usuario, nos guardar el usuario nuevo en la base de datos
	if(isset($_POST['guardar'])){
		$nombre = $_POST['nombre'];
		$apellidos = $_POST['apellidos'];
		$dian = $_POST['dian'];
		$mesn = $_POST['mesn'];
		$yearn = $_POST['yearn'];
		$fecha = $yearn.'-'.$mesn.'-'.$dian;
		$provincia = $_POST['provincia'];
		$telefono = $_POST['telefono'];
		$calendario = $_POST['calendario'];
		$email = $_POST['email'];
		$password = $_POST['password'];

		$actualizar = new claseUsuarios($nombre, $apellidos, $fecha, $provincia, $telefono, $calendario ,$email,$_SESSION['usuario'], $password);
		$actualizar->actualizarUsuario();

	}
	//Si pulsamos guardar calendario, nos guarda el calendario que crea el user, 
	//llamando a la clase calendarios
	elseif(isset($_POST['guardarcal'])){
		$calendarios = new claseCalendarios($_POST['nombrecal'],$_SESSION['usuario']);	
		$calendarios->guardarCalendarios();
	}

	//Cuando pulsamos guardar etiquetas, hace la llamada a la clase etiquetas
	elseif(isset($_POST['guardaretiqueta'])){
		$paletadecolores = new claseEtiquetas($_POST['nombreetiqueta'],$_SESSION['usuario'],$_POST['colorelegido']);	
		$paletadecolores->guardarEtiquetas();
	}

	//Cuando pulsamos guardar evento, hace la llamada a la clase evento
	elseif(isset($_POST['guardareven'])){
		$usuario = $_SESSION['usuario'];
		$titulo = $_POST['titulo'];
		$horai = $_POST['horai'];
		$mini = $_POST['mini'];
		$horaf = $_POST['horaf'];
		$minf = $_POST['minf'];
		$horaini = $horai.':'.$mini;
		$horafin = $horaf.':'.$minf;
		$diai = $_POST['diai'];
		$mesi = $_POST['mesi'];
		$yeari = $_POST['yeari'];
		$diaf = $_POST['diaf'];
		$mesf = $_POST['mesf'];
		$yearf = $_POST['yearf'];
		$fechaini = $yeari.'-'.$mesi.'-'.$diai;
		$fechafin = $yearf.'-'.$mesf.'-'.$diaf;
		$etiqueta = $_POST['coloreti'];
		$nombrecal = $_POST['nombrecal'];
		$obs = $_POST['obs'];
		$rec= $_POST['recordar'];

	    $evento = new claseEventos($usuario,$titulo,$etiqueta,$horaini,$horafin,$fechaini,$fechafin,$nombrecal,$obs,$rec);
	    $evento->insertarEventos();			
	}
	//Cuando pulsamos en actualizar Evento, hace la llamada a la calse evento
	elseif(isset($_POST['actualizarevento'])){
		$usuario = $_SESSION['usuario'];
		$v_titulo = $_POST['v_titulo'];
		$v_dia = $_POST['v_dia'];
		$v_mes = $_POST['v_mes'];
		$v_year = $_POST['v_year'];
		$v_horai = $_POST['v_horai'];
		$v_horaf = $_POST['v_horaf'];
		$v_fechai = $_POST['v_fechai'];
		$v_fechaf = $_POST['v_fechaf'];

		$titulo = $_POST['titulo'];
		$horai = $_POST['horai'];
		$mini = $_POST['mini'];
		$horaf = $_POST['horaf'];
		$minf = $_POST['minf'];
		$horaini = $horai.':'.$mini;
		$horafin = $horaf.':'.$minf;
		$etiqueta = $_POST['coloreti'];
		$nombrecal = $_POST['calendario'];
		$obs = $_POST['obs'];
		$rec = $_POST['recordar'];

	    claseEventos::actualizarEvento($usuario,$titulo,$etiqueta,$horaini,$horafin,$nombrecal,$obs,$rec,$v_titulo,$v_dia,$v_mes,$v_year,$v_horai,$v_horaf,$v_fechai,$v_fechaf);
	}

	//Cuando pulsamos en login, hace la llamada a la clase usuario
	elseif(isset($_POST['login'])){
		$usuario = $_POST['usuario'];
		$password = $_POST['password'];

		claseUsuarios::loginUsuario($usuario,$password);
	}
	//Cuando pulsamos en recuperar contraseña, hace la llamada a la clase usuario
	elseif(isset($_POST['recuperarpass'])){
		$email = $_POST['email'];

	    $recovery = claseUsuarios::recupearPassword($email);
	}
	//Cuando pulsamos comprobar codigo, hace la llamada a la clase usuario
	elseif(isset($_POST['comprobarcodigo'])){
		$codigo = $_POST['icodigo'];
		echo $codigo.'<br>';

	    $recovery = claseUsuarios::comprobarCodigo($codigo);
	}
	//Cuando pulsamos cambiar contraseña, hace la llamada a la clase usuario
	elseif(isset($_POST['cambiarpass'])){
		$email = $_SESSION['email'];
		$password = $_POST['ipassword'];
		$rpassword = $_POST['irpassword'];

	    claseUsuarios::cambiarPassword($email,$password);
	}
	//Cuando pulsamos Registrar, hace la llamada a la clase usuario
	elseif(isset($_POST['registrar'])){
		$_SESSION['nombre'] = $_POST['nombre'];
		$apellidos = $_POST['apellidos'];
		$dia = $_POST['dia'];
		$mes = $_POST['mes'];
		$year = $_POST['year'];
		$provincia = $_POST['provincia'];
		$telefono = $_POST['telefono'];
		$calendario = "";
		$email = $_POST['email'];
		$usuario = $_POST['usuario'];
		$password = $_POST['password'];

		$fechanacimiento = $year."-".$mes."-".$dia;

	    $registro = new claseUsuarios($_SESSION['nombre'], $apellidos, $fechanacimiento, $provincia, $telefono, $calendario, $email, $usuario, $password);
	    $registro->anadirUsuario();
	}	
}
?>