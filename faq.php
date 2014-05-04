<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	
    <!-- CSS -->
    <link rel="stylesheet" href="css/estiloscalendario.css" type="text/css">
    <link rel="stylesheet" href="css/estilosframework.css" type="text/css" media="screen"/>
	<link rel='stylesheet' href='css/estilomenu.css' type='text/css'/>

    <!-- JAVASCRIPT -->
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.js"></script>

</head>
<body>
	<?php
		//Iniciamos sesion
		session_start();
		//Cargamos las clases necesarias para la pagina
		include_once('php/claseCalendario.php');
	    include_once('php/claseUsuarios.php');
		include_once('php/claseConexion.php');
		include_once('php/claseEtiquetas.php');
		//Conectamos con la base de datos
		$objConexion = new Conexion("localhost", "root", "", "tuplanning");
		$objConexion->conectarServidor();
		$objConexion->seleccionarBaseDatos();
		
	if($_SESSION['in']){ 
	?>
    <div class="contenido-calendario">
        <header>
        	<!-- Menu superior -->
			<div id='cssmenu'>
			<ul>
			   <li class='active'><a href='calendario.php'><img src="images/home.png"></a></li>
			   <li class='has-sub'><a href='#'><img src="images/ajustes.png"></a>
			      <ul>
			         <li><a href='cuentauser.php'><img src="images/cuenta.png">Mi cuenta</a></li>
			         <li><a href='crearetiquetas.php'><img src="images/paleta.png">Mi Paleta de colores</a></li>
			         <li class="last"><a href='crearcalendarios.php'><img src="images/calendario.png">Mis Calendarios</a></li>
			      </ul>
			   </li>
			   <li class='has-sub'><a href='#'><img src="images/ayuda.png"></a>
			      <ul>
			         <li><a href='faq.php'><img src="images/faq.png">F.A.Q.</a></li>
			         <li class='last'><a href='#'><img src="images/about.png">About</a></li>
			      </ul>
			   </li>
			   <li class='last'><a href='php/logout.php'><img src="images/logout.png"></a></li>
			</ul>
			</div>
        </header>
        <section>   
			<div class="cuerpo">
				<div class="parte3">
					<h1 class="h1sizefaq">PREGUNTAS FRECUENTES</h1>
					<ul>
						<li><h1><a href="#crearevento">Crear un nuevo evento.</a></h1></li>
						<li><h1><a href="#editarevento">Editar un evento.</a></h1></li>
						<li><h1><a href="#eliminarevento">Eliminar un evento.</a></h1></li>
						<li><h1><a href="#eliminartodoelevento">Eliminar todo el evento.</a></h1></li>
						<li><h1><a href="#crearetiqueta">Crear una etiqueta nueva.</a></h1></li>
						<li><h1><a href="#eliminaretiqueta">Eliminar una etiqueta.</a></h1></li>
						<li><h1><a href="#crearcalendario">Crear un calendario nuevo.</a></h1></li>				
						<li><h1><a href="#eliminarcalendario">Eliminar un calendario.</a></h1></li>
						<li><h1><a href="#editarcuenta">Editar nuestra cuenta.</a></h1></li>	
						<li><h1><a href="#imprimir">Imprimir calendario.</a></h1></li>			
					</ul>
				</div>
				<div class="parte4">
					<h1 class="h1sizefaq" id="crearevento">Crear un nuevo evento.</h1>
					<p>
						Para crear un nuevo evento tenemos que pulsar sobre el numero del dia en el que queremos crear dicho evento.<br/>
						Al pulsar sobre el dia nos saldra un formulario como este:<br/>
						<img class="imgfaq" src="images/faq/formularioevento.png" alt="" width="50%"><br/>
						En este formulario rellenaremos los campos que necesitemos. El campo titulo es un campo requerido, asi que, en caso de no
						rellenarlo, a la hora de guardar el evento, nos dara un mensaje de error y no nos dejara guardarlo hasta que el titulo no este introducido.<br/>
						Los campos a rellenar son:<br/>
						Titulo: Aqui introducimos el titulo de nuestro evento.<br/>
						Hora inicial y hora final: En dichos campos marcaremos la hora de inicio del evento y la hora final del mismo.<br/>
						Fecha inicial y fecha final: Como en los anteriores, aqui seleccionamos la fecha en la que se inicial el evento y la fecha en la que acaba.<br/>
						Etiqueta: La <a href="#editarcuenta">etiqueta</a> etiqueta es una manera de reconocer visualmente el evento mediante un color.<br/>
						Calendario: El <a href="#editarcuenta">calendario</a> es una manera de tener organizado nuestros eventos, creando asi distintos calendarios para distintos tipos de eventos.<br/>
						Observaciones: Campo en el cual podemos añadir nuestras anotaciones en dicho evento.<br/>
					</p>
					<h1 class="h1sizefaq" id="editarevento">Editar un evento.</h1>					
					<p>
						Cuando queremos editar un evento ya creado pulsamos en el evento y nos muesta un panel con la informacion diaria de ese evento. Podemos verlo en esta imagen:<br/>
						<img class="imgfaq" src="images/faq/infoevento.png" alt="" width="50%"><br/>
						Como vemos en la imagen, en la parte de abajo, tenemos un link que nos dara acceso a la zona de editar el evento, pulsamos en el y nos llevara a la pagina correspondiente.<br/>
						Cuando estemos en la pagina donde se edita el evento veremos algo como esto:<br/>
						<img class="imgfaq" src="images/faq/editarevento.png" alt="" width="50%"><br/>
						Podemos modificar todo el contenido del evento menos las fecha en la que se efectua al evento. La opcion de modifical la fecha no esta incluida en esta version.<br/>
						En el caso de querer modificar la fecha, debemos <a href="#eliminartodoelevento">eliminar el evento completo</a> y <a href="#crearevento">crearlo de nuevo el evento</a>.
						Una vez editado el evento, pulsaremos el boton de actualizar y ya nos habra cambiado el evento para ese dia.
					</p>
					<h1 class="h1sizefaq" id="eliminarevento">Eliminar un evento.</h1>
					<p>
						Para eliminar un evento tenemos 2 opciones, eliminar el evento solo para ese dia o <a href="#eliminartodoelevento">eliminar todo el evento</a>.<br/>
						En este caso eliminaremos el evento solo para un dia. Es tan facil como pulsar en el evento que deseamos eliminar y nos saldra el panel con la informacion del evento:<br/>
						<img class="imgfaq" src="images/faq/infoevento.png" alt="" width="50%"><br/>
						Vemos como abajo nos da la opcion de eliminar este evento, pulsaremos en ella y el evento quedara eliminado.<br/>
					</p>
					<h1 class="h1sizefaq" id="eliminartodoelevento">Eliminar todo el evento</h1>
					<p>
						Para eliminar todo el evento. Es tan facil como pulsar en el evento que deseamos eliminar y nos saldra el panel con la informacion del evento:<br/>
						<img class="imgfaq" src="images/faq/infoevento.png" alt="" width="50%"><br/>
						Vemos como abajo nos da la opcion de eliminar todo el evento, pulsaremos en ella y el evento quedara eliminado en su totalidad.<br/>
					</p>
					<h1 class="h1sizefaq" id="crearetiqueta">Crear una etiqueta nueva</h1>
					<p>
						Para crear una etiqueta nueva, iremos al menu superior, pulsaremos en la rueda de ajustes y nos despliega el menu con el link para crear etiquetas.<br/>
						Cuando pulsemos en el, nos llevara a una pagina igual que esta:<br/>
						<img class="imgfaq" src="images/faq/crearetiqueta.png" alt="" width="50%"><br/>
						En dicha pagina, seleccionaremos un color de la lista que nos da y le daremos un nombre a la etiqueta, despues de eso, pulsaremos en "Guardar etiqueta". Ya tendremos nuestra etiqueta guardada.						
					</p>
					<h1 class="h1sizefaq" id="eliminaretiqueta">Eliminar una etiqueta</h1>
					<p>
						Cuando queremos eliminar una etiqueta, nos dirigimos a la pagina donde se <a href="#crearetiqueta">crean las etiquetas</a> y veremos la lista de las etiquetas que ya tenemos creadas.<br/>
						Al lado de cada etiqueta nos sale una papelera como se muestra en la siguiente imagen:<br/>
						<img class="imgfaq" src="images/faq/eliminaretiqueta.png" alt="" width="50%"><br/>
						Pulsaremos en la imagen de la papelera y nuestra etiqueta quedara eliminada. Si algun evento llevase dicha etiqueta, este se podnria con la etiqueta por defecto.
					</p>
					<h1 class="h1sizefaq" id="crearcalendario">Crear un calendario nuevo</h1>
					<p>
						Para crear un calendario nuevo, iremos al menu superior, pulsaremos en la rueda de ajustes y nos despliega el menu con el link para crear calendarios.<br/>
						Cuando pulsemos en el, nos llevara a una pagina igual que esta:<br/>
						<img class="imgfaq" src="images/faq/crearcalendario.png" alt="" width="50%"><br/>
						En dicha pagina, seleccionaremos un nombre para el calendario, despues de eso, pulsaremos en "Guardar calendario". Ya tendremos nuestro calendario guardado.
					</p>
					<h1 class="h1sizefaq" id="eliminarcalendario">Eliminar un calendario</h1>
					<p>
						Cuando queremos eliminar un calendario, nos dirigimos a la pagina donde se <a href="#crearetiqueta">crean los calendarios</a> y veremos la lista de calendarios que ya tenemos creados.<br/>
						Al lado de cada calendario nos sale una papelera como se muestra en la siguiente imagen:<br/>
						<img class="imgfaq" src="images/faq/eliminarcalendario.png" alt="" width="50%"><br/>
						Pulsaremos en la imagen de la papelera y nuestro calendario quedara eliminado. Si algun evento llevase dicho calendrio, este se pondria con el calendario por defecto.						
					</p>
					<h1 class="h1sizefaq" id="editarcuenta">Editar nuestra cuenta</h1>
					<p>
						Para editar nuestros datos, iremos al menu superior, pulsaremos en la rueda de ajustes y nos despliega el menu con el link para editar nuestra cuenta.<br/>
						Cuando pulsemos en el, nos llevara a una pagina igual que esta:<br/>
						<img class="imgfaq" src="images/faq/editardatos.png" alt="" width="50%"><br/>
						En dicha pagina podemos editar nuestros datos, solamente basta con cambiarlos y darle a "Guardar".
					</p>
					<h1 class="h1sizefaq" id="imprimir">Imprimir calendario</h1>
					<p>
						Para imprimir el calendario solo tenemos que pulsar el siguiente icono:<br/>
						<img class="imgfaq" src="images/faq/iconprint.png" alt="" width="50%"><br/>
						Una vez pulsado, nos saldra esta pantalla:<br/>
						<img class="imgfaq" src="images/faq/print.png" alt="" width="50%"><br/>
						Ahora solo tendremos que configurar la impresión, según nuestros gustos y la impresora y ya podremos pegar nuestro calendario en la pared.
					</p>					
				</div>
			</div>
			<div class="bagro2"></div>
		    <div class="pordetras">
		    <?php
		    	//Creamos un objeto para llamar a la funcion que nos genera el calendario.
		    	//A esta clase le mandamos los datos que necesita para saber en que fecha estamos y en base a eso nos genera todo el calendario del mes
		    	//y nos lo imprime por pantalla en html
		        echo '<div id="year">';
		        $obj = new calendario( /*DIA*/date( "j",mktime(0, 0, 0, date("n"), date("j") ,date("Y")) ), /*MES*/date( "n",mktime(0, 0, 0, date("n"), date("j") ,date("Y")) ), /*AÑO*/date( "Y",mktime(0, 0, 0, date("n"), date("j") ,date("Y")) ) );
		        $arrayvalue = $obj->crearCalendarios();
		        echo $arrayvalue[0];
		        echo '</div>';
		        //Guardamos los el mes actual y año actual para luego navegar entre meses.
		        $_SESSION['mesvisual'] = $arrayvalue[1];
		        $_SESSION['yearvisual'] = $arrayvalue[2];
		    ?>
		    </div>  	
		</section>	
        <footer>
            <div class="primero-footer">
                <p class="izquierda">Copyright © 2014 - Todos los derechos reservados</p>
            </div>
            <div class="centro segundo-footer">
                <a rel="license" href="http://creativecommons.org/licenses/by-nc/4.0/deed.es_ES"><img alt="Licencia de Creative Commons" style="border-width:0" src="http://i.creativecommons.org/l/by-nc/4.0/88x31.png" /></a>
            </div>
            <div class="social derecha tercer-footer">
                <a href="#" target="_blank"><img src="images/facebook.png" alt="Facebook"></a>
                <a href="#" target="_blank"><img src="images/flickr.png" alt="Flicker"></a>
                <a href="#" target="_blank"><img src="images/linkedin.png" alt="Linkedin"></a>
                <a href="#" target="_blank"><img src="images/myspace.png" alt="Myspace"></a>
                <a href="#" target="_blank"><img src="images/twitter.png" alt="Twitter"></a>
            </div>
        </footer>
	</div>

	<?php
		}else{
			//En el caso de que no sea correcto el inicio de sesion, iremos a la index.php
			echo 'No has iniciado session';
			session_destroy();
			header('Location: index.php');
		}
	?>
</body>
    <!-- JAVASCRIPT -->
    <script type="text/javascript" src="js/funciones.js"></script>
    <script type="text/javascript">
    	//JS para el framework
        var framew = framework.objframework;
        //Fondos aleatorios
        var fondo = background.objFondo;
        fondo.fondoAleatorio();
    </script>
</html>


