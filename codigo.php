<!DOCTYPE html>
<html lang="es" xml:lang="es" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Language" content="es" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
    <title></title>

    <!-- Css -->
    <link rel="stylesheet" href="css/estilos.css" type="text/css" media="screen"/>
    <link rel="stylesheet" href="css/estilosframework.css" type="text/css" media="screen">

</head>
<body>
    <div class="contenido">
        <header>
            <!-- Menu de las paginas iniciales (En las que aun no se ha iniciado sesion) -->
            <div class="nav-container">
                <nav>
                    <ul>
                        <li><a href="#" class="selected">Inicio</a></li>
                        <li><a href="#">Sobre nosotros</a></li>                        
                        <li><a href="#">Contacto</a></li>
                    </ul>
                </nav>
            </div>
            <!-- Formulario de login -->
            <div id="login">
                <form action="php/funciones.php" method="post">
                    <input class="text-class pequeno" id="usuario" type="text" name="usuario" placeholder="Usuario" onclick="framew.colorInputText('usuario');"/>
                    <input class="text-class pequeno" id="contrasena" type="password" name="password" placeholder="Contraseña" onclick="framew.colorInputText('contrasena');"/>
                    <input class="btn-class bgris extra" type="submit" name="login" value="Iniciar sesion">
                    <a class="texto-blanco" href="recpass.php">¿Recuperar contraseña?</a>
                </form>
                <?php 
                    //Iniciamos sesion
                    session_start();
                    //Controlamos que al hacer login sean correctos los datos, en el caso contrario nos muestra este mensaje.
                    if(!empty($_SESSION['out'])){
                        session_destroy();
                        echo '<h5 id="error">Usuario o contraseña incorrectos.</h5>';
                    }else{
                        echo '';
                    }
                ?>
            </div>
        </header>
        <section>
            <div id="contenidoseccion">
                <div id="registro">
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
                    <h2>Introduce el codigo que se te ha enviado por correo.</h2>
                    <!-- Formulario para introducir el codigo de verificacion -->
                    <form id="formulario" action="php/funciones.php" method="post" accept-charset="utf-8">
                        <div class="text-class-icon-cien" id="codigo">&nbsp;</div>
                        <input class="text-class imagen cien" id="icodigo" type="text" name="icodigo" placeholder="Introduce el codigo" onfocus="colorInputText('icodigo');"><br/>
                        <input class="btn-class bazul" type="submit" id="enviar" name="comprobarcodigo" value="Valdiar codigo">
                    </form>
                </div>
            </div>
        </section>
        <footer>
            <div class="primero-footer">
                <p class="izquierda">Copyright © 2014 - Todos los derechos reservados</p>
            </div>
            <div class="centro segundo-footer">
                <a rel="license" href="http://creativecommons.org/licenses/by-nc/4.0/deed.es_ES"><img alt="Licencia de Creative Commons" style="border-width:0" src="http://i.creativecommons.org/l/by-nc/4.0/88x31.png" /></a><br/>
                <span xmlns:dct="http://purl.org/dc/terms/" property="dct:title">Tuplanning</span> by 
                <a xmlns:cc="http://creativecommons.org/ns#" href="http://www.tuplanning.com" property="cc:attributionName" rel="cc:attributionURL">Javier</a> is licensed under a 
                <a rel="license" href="http://creativecommons.org/licenses/by-nc/4.0/deed.es_ES">Creative Commons Reconocimiento-NoComercial 4.0 Internacional License</a>.
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
    <!-- JAVASCRIPT -->
    <script src="js/funciones.js" type="text/javascript"></script>
    <script type="text/javascript">
        //JS para el framework
        var framew = framework.objframework;
        //Comprobamos que el campo de texto no exte vacio
        var objCode = formularioCodigo.objCodigo;
        objCode.cargarEventos();
        //Fondo aleatioro
        var fondo = background.objFondo;
        fondo.fondoAleatorio();
    </script>
</body>
</html>