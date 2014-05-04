<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	
    <!-- CSS -->
    <link rel="stylesheet" href="css/estiloscalendario.css" type="text/css">
    <link rel="stylesheet" href="css/estilosframework.css" type="text/css" media="screen"/>
	<link rel='stylesheet' href='css/estilomenu.css' type='text/css'/>
    <link rel="stylesheet" type="text/css" media="print" href="css/print.css">
    <!-- JAVASCRIPT -->
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.js"></script>

</head>
<body>
<?php
	//Iniciamos session
	session_start();
    //Cargamos las clases necesarias para esta pagina
    include_once('php/claseCalendario.php');
    include_once('php/claseCalendarios.php');
	include_once('php/claseConexion.php');
	include_once('php/claseEtiquetas.php');
	//Conectamos con la base de datos y la seleccionamos.
	$objConexion = new Conexion("localhost", "root", "", "tuplanning");
	$objConexion->conectarServidor();
	$objConexion->seleccionarBaseDatos();
	//En el caso de que la session sea correcta, no es entra en la web, de lo contrario, nos sacara al index.php
	if($_SESSION['in']){ 
?>
    <div class="contenido-calendario">
        <header>
        	<!-- Menu Css que esta en la parte header de la pagina, el menu se compone de listas. -->
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
			   <li class='has-sub'><a href='javascript:print()'><img src="images/print.png"></a></li>
			   <li class='last'><a href='php/logout.php'><img src="images/logout.png"></a></li>
			</ul>
			</div>
			<div class="select-cal">
			<h4 class="h4size">Mostrar calendario:</h4>
				<?php
					//Realizamos la consulta a la claseCalendarios para obtener las calendarios del usuario y las cargarnos en una tabla.v
					$cal="";		
			    	$cal = claseCalendarios::cargarCalendarios($_SESSION['usuario']);
			    	if(!empty($cal)){
			            echo '<div class="select-class-cal select-blanco-cal" id="selectcal">';
			    		echo '<select name="calendario" onchange="changecal(this.value)">';
				    	for($i=0;$i<count($cal);$i++){			
					    	if($_SESSION['nombrecal'] == $cal[$i]['nombrecal']){
					    		echo '<option value="'.$cal[$i]['nombrecal'].'" selected>'.$cal[$i]['nombrecal'].'</option>';
					    	}else{
					    		echo '<option value="'.$cal[$i]['nombrecal'].'">'.$cal[$i]['nombrecal'].'</option>';
					    	}
						}
						echo '</select>';					
						echo '</div>';
			    	}	
		    	?>				
			</div>	
        </header>
        <section>   
		    <!-- Div con el que podemos añadir un evento nuevo -->
		    <div class="panel" id="A">
		        <h1 class="h1size">Añadir nuevo evento</h1>
		        <form id="formulario" action="php/funciones.php" method="post" accept-charset="utf-8">
		        	<div class="text-class-icong" id="tituloevento">&nbsp;</div>
		            <input class="text-class imagen eventosgrande" id="itituloevento" type="text" name="titulo" placeholder="Titulo del evento" onfocus="framew.colorInputText('itituloevento');">
		            <br/>
		            <!-- Los select de las horas nos los crea un js, asi no metemos los datos uno a uno -->
		            <div class="horas">
		            	<div class="horainicial">
				            <h1 class="h1size">Hora de inicio</h1>
							<div class="select-class-horaifh select-blanco" id="selecthorai"></div>
							<div class="select-class-horaifm select-blanco" id="selectmini"></div>
		            	</div>
		            	<div class="horafinal">
							<h1 class="h1size">Hora final</h1>
							<div class="select-class-horaifh select-blanco" id="selecthoraf"></div>
							<div class="select-class-horaifm select-blanco" id="selectminf"></div>		            		
		            	</div>
		            </div>								           
		            <h1 class="h1size">Fecha de inicio</h1>
		            <!-- Los select de las fechas nos los crea un js -->
					<div class="select-class-fechaifd select-blanco" id="selectdiai"></div>
					<div class="select-class-fechaifm select-blanco" id="selectmesi"></div>
					<div class="select-class-fechaify select-blanco" id="selectyeari"></div>
					<br/>
					<h1 class="h1size">Fecha final</h1>
					<div class="select-class-fechaifd select-blanco" id="selectdiaf"></div>
					<div class="select-class-fechaifm select-blanco" id="selectmesf"></div>
					<div class="select-class-fechaify select-blanco" id="selectyearf"></div>
					<br/>					
					<!-- Añadir las etiquetas creadas por el usuario segun base de datos -->
					<div>
			            <h1 class="h1size">Etiqueta del evento</h1>
					    <?php 
					    	$result="";
					    	$result = claseEtiquetas::cargarEtiquetas($_SESSION['usuario']);
					    	if(!empty($result)){
					    		echo '<div>';	
					    		echo '<div class="colores-etiquetas-creadas" id="colord" onclick="getColorEtiquetaCreada(\'colorelegido\',this.id)">Etiqueta por defecto</div>';
						    	for($i=0;$i<count($result);$i++){				    				
				    				echo '<div class="colores-etiquetas-creadas" id="'.$result[$i]['color'].'" onclick="getColorEtiquetaCreada(\'colorelegido\',this.id)">'.$result[$i]['etiqueta'].'</div>';				    				
				    			}
				    			echo '<input type="hidden" name="coloreti" id="colorelegido" value="colord">';	
				    			echo '</div>';
					    		echo '<a href="crearetiquetas.php"><h6>Crear mas etiquetas.</h6></a>';
					    	}else{
					    		echo '<div class="colores-etiquetas-creadas" id="colord" style="background:#5593ca;" onclick="getColorEtiquetaCreada(\'colorelegido\',this.id)">Etiqueta por defecto</div>';
					    		echo '<input type="hidden" name="coloreti" id="colorelegido" value="colord">';
					    		echo '<h6>No tienes ninguna etiqueta creada. Debes crear al menos 1 etiqueta para poder crear el evento.</h6>';
					    		echo '<a href="crearetiquetas.php"><h6>Crear etiquetas.</h6></a>';
					    	}					   
					    ?>
					</div>
					<br/>
					<h1 class="h1size">Nombre del calendario</h1>
					<!-- Añadir los calendariso creados por el usuario segun base de datos -->
						<?php 				
							$result="";		
					    	$result = claseCalendarios::cargarCalendarios($_SESSION['usuario']);
					    	if(!empty($result)){
					    		echo '<div class="select-class-cal select-blanco-cal" id="selectcal">';
					    		echo '<select name="nombrecal">';
						    	for($i=0;$i<count($result);$i++){				    				
				    				echo '<option value="'.$result[$i]['nombrecal'].'">'.$result[$i]['nombrecal'].'</option>';				    				
				    			}
				    			echo '</select>';
				    			echo '</div>';
					    		echo '<a href="crearcalendarios.php"><h6>Crear mas calendarios.</h6></a>';
					    	}				   
				    	?>			
					<br/>
					<h1>Recordar</h1>
					<div class="select-class-fechaifd select-blanco" id="selectdiai">
						<select name="recordar" id="recordar">
							<option value="no">No</option>
							<option value="si">Si</option>
						</select>
					</div><br/>
		            <h1 class="h1size">Anotaciones extras</h1>	
					<textarea class="text-class txtarea" name="obs" id="eventodesc" cols="30" rows="10" onfocus="framew.colorInputText('eventodesc');"></textarea>
		            <input class="btn-class bazul" type="submit" id="enviar" name="guardareven" value="Guardar evento">
		        </form>
		        <a href="#" class="flop" id="cerrar"><img src="images/papelera.png" alt=""></a>
		    	</div>
		    	<!-- Div que contiene el panel que muestra los eventos individualemnte. -->
		    	<div id="C" class="panel">
					<a href="#" class="flop" id="cerrar"><img src="images/papelera.png" alt=""></a>
					<div id="event">
						
					</div>
			    </div>
		    <div class="calendario">
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
		//Sentencia nula del if que contola la session, en este caso podriamos decir que si no has iniciado bien la session, vuelves al indes.
		}else{
			echo 'No has iniciado session';
			session_destroy();
			header('Location: index.php');
		}
	?>
</body> 
	<!-- JAVASCRIPT -->
    <script type="text/javascript" src="js/funciones.js"></script>
    <!-- js que controla los sliders -->
    <script type="text/javascript" src="js/flipflop.js"></script>
    <script type="text/javascript">
    	//Cargamos los estilos de mi framework
    	var framew = framework.objframework;
    	//Controlamos los campos de texto
        var nuevoEvento = formularioNuevoEvento.objNewEvent;
        nuevoEvento.cargarEventos();
        //Background aleatorio
        var fondo = background.objFondo;
        fondo.fondoAleatorio();
        //Llamamos a las funciones que nos cargan las horas y las fechas
        var fechasIniciales = seleccionFechas.objFechasInicial;
        fechasIniciales.registroFechasI();
        fechasIniciales.registroFechasF();
        fechasIniciales.registroHoraI();
        fechasIniciales.registroHoraF();
    </script>
</html>


