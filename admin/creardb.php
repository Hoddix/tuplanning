<!DOCTYPE html>
<html lang="es" xml:lang="es" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Language" content="es" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
    <title></title>

    <!-- Css -->
    <link rel="stylesheet" href="../css/estilos.css" type="text/css" media="screen"/>
    <link rel="stylesheet" href="../css/estilosframework.css" type="text/css" media="screen">

</head>
<body>
    <div class="contenido">
        <header>
            <!-- Menu de las paginas iniciales (En las que aun no se ha iniciado sesion) -->
            <div class="nav-container">

            </div>
        </header>
        <section>
            <div id="contenidoseccion">
				<?php
				//Creamos la instalacion inicial de la base de datos
				include('../php/claseConexion.php');
				session_start();
				if(isset($_POST['iniciar'])){
					$objConexion = new Conexion("localhost", "root", "", "tuplanning");
					$objConexion->conectarServidor();
					$objConexion->crearBasedatos();
					$objConexion->seleccionarBaseDatos();
					$objConexion->crearTablas();
				}else{
				?>
                <div id="registro">
                    <h1>Vamos a comerzar la instalacion de la base de datos. Para iniciar la instalacion hay que pulsar en siguiente.</h1>
                    <form id="formulario" action="" method="post" accept-charset="utf-8">
                        <input class="btn-class bazul" type="submit" id="enviar" name="iniciar" value="Instalar">
                    </form>
                </div>
                <?php
            	}
            	?>
            </div>
        </section>
        <footer>
            <p class="izquierda">
                Copyright © 2014 - Todos los derechos reservados<br>
            </p>
        </footer>

    </div>
    <!-- JAVASCRIPT -->
    <script src="../js/funciones.js" type="text/javascript"></script>
    <script type="text/javascript">
        //JS para el framework
        var framew = framework.objframework;
        //Fondo aleatorio
        var fondo = background.objFondo;
        fondo.fondoAleatorio();
    </script>

</body>
</html>