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
		//Iniciamos session
		session_start();
		//Cargamos las clases necesarias para estaweb
	    include_once('php/claseCalendario.php');
	    include_once('php/claseCalendarios.php');
	    include_once('php/claseUsuarios.php');
		include_once('php/claseConexion.php');
		include_once('php/claseEtiquetas.php');
		//Conectamos con la bases de datos y la seleccionamos
		$objConexion = new Conexion("localhost", "root", "", "tuplanning");
		$objConexion->conectarServidor();
		$objConexion->seleccionarBaseDatos();
		//Si la sesion es correcta entramos en la web
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
				<div class="parte1">
					<div>
						<h1 class="h1size">Añadir nuevo calendarios</h1>
						<!-- Formulario de creacion de calendario -->
						<form action="php/funciones.php" method="POST">
							<input type="text" class="text-class imagen cien" placeholder="Nombre del calendario" id="nombrecal" name="nombrecal">	
							<input type="submit" class="btn-class bazul" id="guardarcal" name="guardarcal" value="Guardar calendario">
						</form>
	                    <h3>
	                        <?php 
	                            //Mensajes que se mostraran si hay algun error en el proceso de recuperar password
	                            if(empty($_SESSION['textor']) && !empty($_SESSION['textok'])){
	                                echo $_SESSION['textok'];
	                                unset($_SESSION['textok']);
	                            }elseif(empty($_SESSION['textok']) && !empty($_SESSION['textor'])){
	                                echo $_SESSION['textor'];
	                                unset($_SESSION['textor']);
	                            }else{
	                                echo "";
	                            }                     
	                        ?>
	                    </h3>
					</div>
				</div>
				<div class="parte2">
					<div>
						<hr>
						<h1 class="h1size">Lista de calendarios creados</h1>
					    <?php 
					    	//Hacemos una lista con todos los calendarios del usuario
					    	$result="";
					    	$result = claseCalendarios::cargarCalendarios($_SESSION['usuario']);
					    	if(!empty($result)){
					    		echo '<div>';	
					    		echo '<table>';
					    		echo '<tr>';
					    		echo '<td>';
					    		echo '<h1 class="h1size">Nombre del calendario</h1>';
					    		echo '</td>';
					    		echo '<td>';
					    		echo '<h1 class="h1size">Eliminar calendario</h1>';
					    		echo '</td>';
					    		echo '</tr>';
					    		echo '<tr>';
					    		echo '<td>';
					    		echo '<div class="calendarios" id="'.$result[0]['nombrecal'].'"><h2 class="h2size">'.$result[0]['nombrecal'].'</h2></div>';
					    		echo '</td>';
					    		echo '<td>';
					    		echo '</td>';
					    		echo '</tr>';
						    	for($i=1;$i<count($result);$i++){				    				
							    	echo '<tr>';
						    		echo '<td>';
				    				echo '<div class="calendarios" id="'.$result[$i]['nombrecal'].'"><h2 class="h2size">'.$result[$i]['nombrecal'].'</h2></div>';
					    			echo '</td>';
					    			echo '<td>';
					    			echo '<span class="centrar"><a href="#" onclick="borrarCal(\''.$_SESSION['usuario'].'\',\''.$result[$i]['nombrecal'].'\')"><img src="images/borrar.png" alt=""></a></span>';
					    			echo '</td>';
						    		echo '</tr>';
				    			}
				    			echo '</table>';
				    			echo '</div>';
					    	}				   
					    ?>
					</div>
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
			//Si la session es incorrecta, nos lleva a la index.php
			echo 'No has iniciado session';
			session_destroy();
			header('Location: index.php');
		}
	?>
</body>
    <!-- JAVASCRIPT -->
    <script type="text/javascript" src="js/funciones.js"></script>
    <script type="text/javascript">
    	//JS para el fromework
    	var framew = framework.objframework;
    	//Fondos aleatorios
        var fondo = background.objFondo;
        fondo.fondoAleatorio();
    </script>
</html>


