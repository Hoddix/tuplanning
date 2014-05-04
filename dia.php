<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agendario -- Tu calendario online.</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="css/estiloscalendario.css" type="text/css">
    <link rel="stylesheet" href="css/estilosframework.css" type="text/css" media="screen"/>
    <link rel='stylesheet' href='css/estilomenu.css' type='text/css'/>
    <!-- JAVASCRIPT-->
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.js"></script>
</head>
<body>
<?php
    //Iniciamos session
    session_start();
    //Cargamos las clases necesarias para esta pagina
    include_once('php/claseCalendario.php');
    include_once('php/claseEventos.php');
    include_once('php/claseConexion.php');
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
               <li class='last'><a href='php/logout.php'><img src="images/logout.png"></a></li>
            </ul>
            </div>
        </header>
        <section>        
            <!-- Cuerpo completo donde esta todo el contenido de la pagina. En este caso los eventos diarios -->
            <div class="cuerpocompleto">
                <div class="contabladia">
                    <table class="tabladia">
                    <tr>
                    <td><h1 class="h1size">Lista de eventos</h1></td>
                    <td>00:00</td>
                    <td>01:00</td>
                    <td>02:00</td>
                    <td>03:00</td>
                    <td>04:00</td>
                    <td>05:00</td>
                    <td>06:00</td>
                    <td>07:00</td>
                    <td>08:00</td>
                    <td>09:00</td>
                    <td>10:00</td>
                    <td>11:00</td>
                    <td>12:00</td>
                    <td>13:00</td>
                    <td>14:00</td>
                    <td>15:00</td>
                    <td>16:00</td>
                    <td>17:00</td>
                    <td>18:00</td>
                    <td>19:00</td>
                    <td>20:00</td>
                    <td>21:00</td>
                    <td>22:00</td>
                    <td>23:00</td>
                    </tr>
                    <?php                  
                        $result;
                        //Consultamos a la claseEventos por los eventos que hay en el dia.
                        $result = claseEventos::cargarEventos($_POST['usuario'],$_POST['dia'],$_POST['mes'],$_POST['year'],$_POST['calendario']);
                        $horaactual = date("H",time()); //Obtenemos la hora actual, para indicarle al usuario en la parte de dia en la que estamos
                        //For que se encarga de recorrer tantas veces como eventos haya en el dia.
                        for($x=0;$x<count($result);$x++){
                            $horaini = substr($result[$x][7],0,2);//Extraemos la hora inicial
                            $horafin = substr($result[$x][8],0,2);//Extraemos la hora final
                            //Comenzamos a escribir el codigo de la tabla donde iran los eventos con sus lineas de tiempo.
                            echo "<tr>";
                            echo '<td><span class="estilo-evento"id="'.$result[$x]['etiqueta'].'">';
                            echo '<a href="#" class="a-white" onclick="consultarEventos(\''.$result[$x]['dia'].'\',\''.$result[$x]['mes'].'\',\''.$result[$x]['ano'].'\',\''.$result[$x]['horai'].'\',\''.$result[$x]['horaf'].'\',\''.$_SESSION['usuario'].'\',\''.$result[$x]['titulo'].'\');" flip="C">';
                            echo $result[$x]['titulo']."</a></span></td>";
                            //Controlamos que tipo de horarios hay, ya que hay gente que comienza a trabajar de noche y acabar de mañana, 
                            //por lo tanto la hora final es mayor a la inicial y hay que controlarlo
                            if(intval($horafin)>intval($horaini)){
                                for($i = 0; $i < intval($horaini); $i++){
                                    if($horaactual == $i){                                        
                                        echo "<td>";
                                        echo '<div class="horaactual">';
                                        echo '</div>';
                                        echo "</td>";
                                    }else{
                                        echo "<td></td>";
                                    }                                    
                                }                                                  
                            }elseif(intval($horafin)<intval($horaini)){
                                for($i = 0; $i <= intval($horafin); $i++){
                                    if($horaactual == $i){
                                        echo '<td>';
                                        echo '<div class="horaactual"></div>';
                                        echo '<span class="estilo-evento-diario"id="'.$result[$x]['etiqueta'].'">&nbsp;</span>';                                        
                                        echo '</td>';            
                                    }else{
                                        echo '<td>';
                                        echo '<span class="estilo-evento-diario"id="'.$result[$x]['etiqueta'].'">&nbsp;</span>';
                                        echo '</td>';
                                    }   
                                }
                            }
                            
                            if(intval($horaini)<intval($horafin)){
                                for($i = intval($horaini); $i <= intval($horafin); $i++){
                                    if($horaactual == $i){
                                        echo '<td>';
                                        echo '<div class="horaactual"></div>';
                                        echo '<span class="estilo-evento-diario" id="'.$result[$x]['etiqueta'].'">&nbsp;</span>';                                        
                                        echo '</td>';   
                                    }else{
                                        echo '<td>';
                                        echo '<span class="estilo-evento-diario" id="'.$result[$x]['etiqueta'].'">&nbsp;</span>';
                                        echo '</td>';                                        
                                    }   
                                }
                            }elseif(intval($horaini)>intval($horafin)){
                                for($i = intval($horafin)+1; $i < intval($horaini); $i++){
                                    if($horaactual == $i){
                                        echo "<td>";
                                        echo '<div class="horaactual">';
                                        echo '</div>';
                                        echo "</td>";
                                    }else{
                                        echo "<td></td>";
                                    }                                       
                                }
                            }
                            
                            if(intval($horaini)<intval($horafin)){
                                for($i = intval($horafin); $i < 23; $i++){
                                    if($horaactual == $i){
                                        echo "<td>";
                                        echo '<div class="horaactual">';
                                        echo '</div>';
                                        echo "</td>";
                                    }else{
                                        echo "<td></td>";
                                    }                                       
                                }
                            }elseif(intval($horaini)>intval($horafin)){
                                for($i = intval($horaini); $i < 24; $i++){
                                    if($horaactual == $i){
                                        echo '<td>';
                                        echo '<div class="horaactual"></div>';
                                        echo '<span class="estilo-evento-diario" id="'.$result[$x]['etiqueta'].'">&nbsp;</span>';                                        
                                        echo '</td>';   
                                    }else{
                                        echo "<td>";
                                        echo '<span class="estilo-evento-diario" id="'.$result[$x]['etiqueta'].'">&nbsp;</span>';
                                        echo "</td>";                                        
                                    }                                       
                                }
                            }

                            echo "</tr>";
                        }
                        echo '</table>';
                    ?> 
                </div>
            </div>
            <!-- Div que contiene el panel donde se muestran las caracteristicas de un evento seleccionado -->
            <div id="C" class="panel">
                <a href="#" class="flop" id="cerrar"><img src="images/papelera.png" alt=""></a>
                <div id="event">
                        
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
        //Sentencia nula del if que contola la session, en este caso podriamos decir que si no has iniciado bien la session, vuelves al indes.
        }else{
            echo 'No has iniciado session';
            session_destroy();
            header('Location: index.php');
        }
    ?>
</body>   
    <!-- JAVASCRIPT-->
    <script type="text/javascript" src="js/funciones.js"></script>
    <script type="text/javascript" src="js/flipflop.js"></script>
    <script type="text/javascript">
        //Efectos visuales de un framework html que he programado.
        var framew = framework.objframework;
        //Background aleatorio.
        var fondo = background.objFondo;
        fondo.fondoAleatorio();
    </script>
</html>