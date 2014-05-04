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
	    include_once('php/claseEventos.php');
	    include_once('php/claseCalendarios.php');
	    include_once('php/claseUsuarios.php');
		include_once('php/claseConexion.php');
		include_once('php/claseEtiquetas.php');
		//Conectamos con la base de datos
		$objConexion = new Conexion("localhost", "root", "", "tuplanning");
		$objConexion->conectarServidor();
		$objConexion->seleccionarBaseDatos();
	?>
    <div class="contenido-calendario">
        <header>
        	<!-- Menu -->
			<div id='cssmenu'>
			<ul>
			   <li class='active'><a href='calendario.php'><img src="images/home.png"></a></li>
			   <li class='has-sub'><a href='#'><img src="images/ajustes.png"></a>
			      <ul>
			         <li><a href='#'><img src="images/cuenta.png">Mi cuenta</a></li>
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
		    <div class="editarevento">
		    	<div id="evento">
		    	<?php
		    		//Hacemos una consulta a la calse de los eventos para obtener los datos del evento.
		    		$usuario = $_POST['usuario'];
					$datosEvento = claseEventos::editarEvento($_POST['usuario'],$_POST['dia'],$_POST['mes'],$_POST['year'],$_POST['horai'],$_POST['horaf'],$_POST['titulo']);
				?>
				<h1 class="h1size">Editar evento</h1>
				<!-- Formulario en el que se cargan los datos del evento y posteriormente se pueden modificar -->
				<form id="formulario" action="php/funciones.php" method="post" accept-charset="utf-8">
				<input type="hidden" value=<?php echo '"'.$datosEvento[2].'"'; ?> name="v_titulo">
				<input type="hidden" value=<?php echo '"'.$datosEvento[4].'"'; ?> name="v_year">
				<input type="hidden" value=<?php echo '"'.$datosEvento[5].'"'; ?> name="v_mes">
				<input type="hidden" value=<?php echo '"'.$datosEvento[6].'"'; ?> name="v_dia">
				<input type="hidden" value=<?php echo '"'.$datosEvento[7].'"'; ?> name="v_horai">
				<input type="hidden" value=<?php echo '"'.$datosEvento[8].'"'; ?> name="v_horaf">
				<input type="hidden" value=<?php echo '"'.$datosEvento[9].'"'; ?> name="v_fechai">
				<input type="hidden" value=<?php echo '"'.$datosEvento[10].'"'; ?> name="v_fechaf">
				<div class="text-class-icong" id="tituloevento">&nbsp;</div>
		        <input class="text-class imagen eventosgrande" id="itituloevento" type="text" name="titulo" placeholder="Titulo del evento" value=<?php echo '"'.$datosEvento[2].'"'; ?> onfocus="framew.colorInputText(\'itituloevento\');">
		        <br/>
				
	            <div class="horas">
	            	<?php 
	            		//Seleccionamos las horas iniciales y finales
	            		$horai = substr($datosEvento[7],0,2);	            	
	            		$mini = substr($datosEvento[7],3,5);	            		
	            		$horaf = substr($datosEvento[8],0,2);	            		
	            		$minf = substr($datosEvento[8],3,5);	            		
	            	?>
	            	<div class="horainicial">
			            <h1 class="h1size">Hora de inicio</h1>
						<div class="select-class-horaifh select-blanco" id="selecthorai">
							<select name='horai' id='horai'>
							<?php
								//Cargamos todos los options con las horas iniciales
								$options = "";
								for($x=0;$x<24;$x++){
								    if($x<10){
								    	if($horai == ("0".$x)){
								    		$options .= "<option value='0".$x."' selected>0".$x."</option>";
								    	}else{
								    		$options .= "<option value='0".$x."'>0".$x."</option>";
								    	}						      
								    }else{
								    	if($horai == $x){
								    		$options .= "<option value='".$x."' selected>".$x."</option>";
								    	}else{
								    		$options .= "<option value='".$x."'>".$x."</option>";
								    	}	
								    }
								}							
								echo $options;							
							?>
							</select>
						</div>
						<div class="select-class-horaifm select-blanco" id="selectmini">
							<select name='mini' id='mini'>
							<?php 
								//Cargamos todos los options con los minutos iniciales
								$options = "";								
								for($x=0;$x<60;$x++){
								    if($x<10){
								    	if($mini == ("0".$x)){
								    		$options .= "<option value='0".$x."' selected>0".$x."</option>";
								    	}else{
								    		$options .= "<option value='0".$x."'>0".$x."</option>";
								    	}						      
								    }else{
								    	if($mini == $x){
								    		$options .= "<option value='".$x."' selected>".$x."</option>";
								    	}else{
								    		$options .= "<option value='".$x."'>".$x."</option>";
								    	}	
								    }
								}								
								echo $options;							
							?>
							</select>
						</div>
	            	</div>
	            	<div class="horafinal">
						<h1 class="h1size">Hora final</h1>
						<div class="select-class-horaifh select-blanco" id="selecthoraf">
							<select name='horaf' id='horaf'>
							<?php
								//Cargamos todos los options con las horas finales
								$options = "";
								for($x=0;$x<24;$x++){
								    if($x<10){
								    	if($horaf == ("0".$x)){
								    		$options .= "<option value='0".$x."' selected>0".$x."</option>";
								    	}else{
								    		$options .= "<option value='0".$x."'>0".$x."</option>";
								    	}						      
								    }else{
								    	if($horaf == $x){
								    		$options .= "<option value='".$x."' selected>".$x."</option>";
								    	}else{
								    		$options .= "<option value='".$x."'>".$x."</option>";
								    	}	
								    }
								}							
								echo $options;							
							?>
							</select>							
						</div>
						<div class="select-class-horaifm select-blanco" id="selectminf">
							<select name='minf' id='minf'>
							<?php 
								//Cargamos todos los options con los minutos finales
								$options = "";								
								for($x=0;$x<60;$x++){
								    if($x<10){
								    	if($minf == ("0".$x)){
								    		$options .= "<option value='0".$x."' selected>0".$x."</option>";
								    	}else{
								    		$options .= "<option value='0".$x."'>0".$x."</option>";
								    	}						      
								    }else{
								    	if($minf == $x){
								    		$options .= "<option value='".$x."' selected>".$x."</option>";
								    	}else{
								    		$options .= "<option value='".$x."'>".$x."</option>";
								    	}	
								    }
								}								
								echo $options;							
							?>
							</select>							
						</div>		            		
	            	</div>
	            </div>					
		        <br/>
				<div>
		         <h1 class="h1size">Etiqueta del evento</h1>
				<?php		
				//Realizamos la consulta a la claseEtiquetas para obtener las etiquetas del usuario y las cargarnos en una tabla.		    
		    	$result="";
		    	$result = claseEtiquetas::cargarEtiquetas($_SESSION['usuario']);
		    	if(!empty($result)){
		    		echo '<div id="listadeetiquetas">';	
		    		echo '<div class="colores-etiquetas-creadas" id="colord" onclick="getColorEtiquetaCreada(\'colorelegido\',this.id)">Etiqueta por defecto</div>';
			    	for($i=0;$i<count($result);$i++){				    				
						echo '<div class="colores-etiquetas-creadas" id="'.$result[$i]['color'].'" onclick="getColorEtiquetaCreada(\'colorelegido\',this.id)">'.$result[$i]['etiqueta'].'</div>';				    				
					}
					echo '<input type="hidden" name="coloreti" id="colorelegido" value="'.$datosEvento[3].'">';	
					echo '</div>';
		    		echo '<a href="#" class="big-link-flip-flop flop" flip="B"><h6>Crear mas etiquetas.</h6></a>';
		    	}else{
		    		echo '<div class="colores-etiquetas-creadas" id="colord" onclick="getColorEtiquetaCreada(\'colorelegido\',this.id)">Etiqueta por defecto</div>';
		    		echo '<input type="hidden" name="coloreti" id="colorelegido" value="colord">';
		    		echo '<h6>No tienes ninguna etiqueta creada. Debes crear al menos 1 etiqueta para poder crear el evento.</h6><br/>';
		    		echo '<a href="#" class="big-link-flip-flop flop" flip="B"><h6>Crear etiquetas.</h6></a>';
		    	}					   
				?>				   
				</div>
				<br/>
				<h1 class="h1size">Nombre del calendario</h1>
				<?php
				//Realizamos la consulta a la claseCalendarios para obtener las calendarios del usuario y las cargarnos en una tabla.v
				$cal="";		
		    	$cal = claseCalendarios::cargarCalendarios($_SESSION['usuario']);
		    	if(!empty($cal)){
		            echo '<div class="select-class-cal select-blanco-cal" id="selectcal">';
		    		echo '<select name="calendario">';
			    	for($i=0;$i<count($cal);$i++){			
				    	if($datosEvento[11] == $cal[$i]['nombrecal']){
				    		echo '<option value="'.$cal[$i]['nombrecal'].'" selected>'.$cal[$i]['nombrecal'].'</option>';
				    	}else{
				    		echo '<option value="'.$cal[$i]['nombrecal'].'">'.$cal[$i]['nombrecal'].'</option>';
				    	}
					}
					echo '</select>';					
					echo '</div>';
					echo '<a href="crearcalendarios.php"><h6>Crear mas calendarios.</h6></a><br/>';
		    	}	

		    	?>
				<h1 class="h1size">Recordar</h1>
				<?php
		            echo '<div class="select-class-fechaifd select-blanco" id="selectdiai">';
		    		echo '<select name="recordar">';		
			    	if($datosEvento[13] == "si"){
			    		echo '<option value="si" selected>Si</option>';
			    		echo '<option value="no">No</option>';
			    	}else{
			    		echo '<option value="no" selected>No</option>';
			    		echo '<option value="si">Si</option>';
			    	}
					echo '</select>';					
					echo '</div>';
		    	?><br/>
				<h1 class="h1size">Anotaciones extras</h1>
				<textarea class="text-class txtarea" name="obs" id="eventodesc" cols="30" rows="10" value=<?php echo '"'.$datosEvento[12].'"'; ?> onfocus="framew.colorInputText(\'eventodesc\');"></textarea>
				<input class="btn-class bazul" type="submit" id="enviar" name="actualizarevento" value="Guardar evento">
				</form>
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
</body>
	<!-- JAVASCRIPT -->
    <script type="text/javascript" src="js/funciones.js"></script>
    <script type="text/javascript">
    	//JS del framework
    	var framew = framework.objframework;
    	//Fondo aleatorio
        var fondo = background.objFondo;
        fondo.fondoAleatorio();
    </script>
</html>