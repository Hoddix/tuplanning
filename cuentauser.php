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
		//Cargamos las clases que necesitamos
		include_once('php/claseCalendario.php');
	    include_once('php/claseCalendarios.php');
	    include_once('php/claseUsuarios.php');
		include_once('php/claseConexion.php');
		//Conectamos con la base de datos
		$objConexion = new Conexion("localhost", "root", "", "tuplanning");
		$objConexion->conectarServidor();
		$objConexion->seleccionarBaseDatos();
		//Si el inicio de session es correcto entra en la web
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
				    <div>
				        <h2 class="h2size">Mi cuenta</h2>
				        <?php 
				        //Obtenemos los datos del usuario y los introducimos en los campos que corresponden
				        $result ="";
				        $result = claseUsuarios::completarUsuario($_SESSION['usuario']);
				        ?>
				        <!-- Formulario en el cual luego podemos actualizar nuestros datos -->
				        <form id="formulario" action="php/funciones.php" method="post" accept-charset="utf-8">
				            <div class="text-class-icon" id="nombre">&nbsp;</div>
				            <input class="text-class imagen" id="inombre" type="text" name="nombre" <?php if(!empty($result[0])){echo 'value="'.$result[0].'"';}else{ echo 'placeholder="Nombre"';} ?> onfocus="framew.colorInputText('inombre');">
				            <input class="text-class imagen" id="iapellidos" type="text" name="apellidos" <?php if(!empty($result[1])){echo 'value="'.$result[1].'"';}else{ echo 'placeholder="Apellidos"';} ?> onfocus="framew.colorInputText('iapellidos');"><br/>				           
				            <h1 class="h1size">Fecha de nacimiento</h1>
				            <?php 
				            	//Generamos los select para las fechas
				            	$meses = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
				            	if($result[2]!="0000-00-00"){
									$yearn = substr($result[2],0,4);	            	
									$mesn = substr($result[2],5,2);	            		
									$dian = substr($result[2],8,2);            											
				            	}else{
				            		$yearn = substr($result[2],0,4);	            	
									$mesn = substr($result[2],5,2);	            		
									$dian = substr($result[2],8,2);
				            	} 
				            ?>
							<div class="select-class-fechand select-blanco" id="selectdian">
								<select name='dian' id='dian'>
								<?php
									$options = "";
									for($x=1;$x<32;$x++){
									    if($x<10){
									    	if($dian == ("0".$x)){
									    		$options .= "<option value='0".$x."' selected>0".$x."</option>";
									    	}else{
									    		$options .= "<option value='0".$x."'>0".$x."</option>";
									    	}						      
									    }else{
									    	if($dian == $x){
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
							<div class="select-class-fechanm select-blanco" id="selectmesn">
								<select name='mesn' id='mesn'>
									<?php
										$options = "";
										for($x=1;$x<13;$x++){
									    	if($mesn == $x){
									    		$options .= "<option value='".$x."' selected>".$meses[$x]."</option>";
									    	}else{
									    		$options .= "<option value='".$x."'>".$meses[$x]."</option>";
									    	}						      
										}							
										echo $options;							
									?>
								</select>								
							</div>
							<div class="select-class-fechany select-blanco" id="selectyearn">
								<select name='yearn' id='yearn'>
									<?php
										$options = "";
										for($x=2014;$x>1930;$x--){
									    	if($yearn == $x){
									    		$options .= "<option value='".$x."' selected>".$x."</option>";
									    	}else{
									    		$options .= "<option value='".$x."'>".$x."</option>";
									    	}						      										    
										}							
										echo $options;							
									?>
								</select>								
							</div>
							<br/>
				            <input class="text-class imagen cien" id="iprovincia" type="text" name="provincia" <?php if(!empty($result[3])){echo 'value="'.$result[3].'"';}else{ echo 'placeholder="Provincia"';} ?> onfocus="framew.colorInputText('iprovincia');"><br/>
				            <input class="text-class imagen cien" id="itelefono" type="text" name="telefono" <?php if(!empty($result[4])){echo 'value="'.$result[4].'"';}else{ echo 'placeholder="Telefono"';} ?> onfocus="framew.colorInputText('itelefono');"><br/>
							<?php 				
								//Seleccionamos el calendario por defecto del usuario
								$cal="";		
						    	$cal = claseCalendarios::cargarCalendarios($_SESSION['usuario']);
						    	if(!empty($cal)){
				                    echo '<div class="select-class-cal select-blanco-cal" id="selectcal">';
						    		echo '<select name="calendario">';
							    	for($i=0;$i<count($cal);$i++){			
								    	if($result[5] == $cal[$i]['nombrecal']){
								    		echo '<option value="'.$cal[$i]['nombrecal'].'" selected>'.$cal[$i]['nombrecal'].'</option>';
								    	}else{
								    		echo '<option value="'.$cal[$i]['nombrecal'].'">'.$cal[$i]['nombrecal'].'</option>';
								    	}
					    			}
					    			echo '</select>';
					    			echo '</div>';
						    	}				   
					    	?>
				            <div class="text-class-icon-cien" id="email">&nbsp;</div>
				            <input class="text-class imagen cien" id="iemail" type="text" name="email" <?php if(!empty($result[6])){echo 'value="'.$result[6].'"';}else{ echo 'placeholder="Email"';} ?> onfocus="framew.colorInputText('iemail');"><br/>
				            <div class="text-class-icon-cien" id="password">&nbsp;</div>
				            <input class="text-class imagen cien" id="ipassword" type="password" name="password" placeholder="Nueva Contraseña" onfocus="framew.colorInputText('ipassword');"><br/>
				            <h6 id="contrasenah6">(Entre 8 y 10 caracteres, por lo menos un digito y un alfanumérico, y no puede contener caracteres espaciales)</h6>
				            <input class="btn-class bazul" type="submit" id="enviar" name="guardar" value="Guardar">
				        </form>
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


