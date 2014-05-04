<?php
    include_once('claseConexion.php');
    include_once('claseEventos.php');
    $Conexion = new Conexion("localhost", "root", "", "tuplanning");
    $Conexion->conectarServidor();
    $Conexion->seleccionarBaseDatos();

	class calendario{
		
		public $diaActual;
		public $mesActual;
		public $yearActual;
		//El constructor recibe unos parametros
		function __construct($diaA, $mesA, $yearA){
			$this->diaActual = $diaA;
			$this->mesActual = $mesA;
			$this->yearActual = $yearA;
		}
		//Declaramos los dias de la semana en castellano
        function diasDeLaSemana(){
            $diasdelasemana = array('0' => "Lunes",'1' => "Martes",'2' => "Miercoles",'3' => "Jueves",'4' => "Viernes",'5' => "Sabado",'6' => "Domingo",);
            return $diasdelasemana;
        }
        //Declaramos los meses en castellano
        function meses(){
            $meses = array('1'=> "Enero",'2'=> "Febrero",'3'=> "Marzo",'4'=> "Abril",'5'=> "Mayo",'6'=> "Junio",'7'=> "Julio",'8'=> "Agosto",'9'=> "Septiembre",'10'=> "Octubre",'11'=> "Noviembre",'12'=> "Diciembre");
            return $meses;
        }
        //Declaramos el primer dia del mes
		function getPrimerDiaMes(){
			return 1; 
		}
		//Obtenemos el ultimo dia del mes
		function getUltimoDiaMes() {
            $ultimoDiaMes = intval(date("d",(mktime(0,0,0,$this->mesActual+1,1,$this->yearActual)-1)));
            $nombreUltimoDiaMes = date("l",(mktime(0,0,0,$this->mesActual+1,1,$this->yearActual)-1));
            switch ($nombreUltimoDiaMes) {
                case 'Monday':
                    $nombreUltimoDiaMes = "Lunes";
                    break;
                case 'Tuesday':
                    $nombreUltimoDiaMes = "Martes";
                    break;
                case 'Wendesday':
                    $nombreUltimoDiaMes = "Miercoles";
                    break;
                case 'Thursday':
                    $nombreUltimoDiaMes = "Jueves";
                    break;
                case 'Friday':
                    $nombreUltimoDiaMes = "Viernes";
                    break;
                case 'Saturday':
                    $nombreUltimoDiaMes = "Sabado";
                    break;
                case 'Sunday':
                    $nombreUltimoDiaMes = "Domingo";
                    break;
            }
            return $arrayName = array('0' => $nombreUltimoDiaMes ,'1' => $ultimoDiaMes);
		}
		//Obtenemos el dia actual
		function getDiaActual(){
			$x = date("l", mktime(0,0,0,$this->mesActual,$this->diaActual,$this->yearActual));
			switch ($x) {
				case 'Monday':
					$nombreDia = "Lunes";
					$indice = 0;
				break;
				case 'Tuesday':
					$nombreDia = "Martes";
					$indice = 1;
				break;
				case 'Wednesday':
					$nombreDia = "Miercoles";
					$indice = 2;
				break;
				case 'Thursday':
					$nombreDia = "Jueves";
					$indice = 3;
				break;
				case 'Friday':
					$nombreDia = "Viernes";
					$indice = 4;
				break;
				case 'Saturday':
					$nombreDia = "Sabado";
					$indice = 5;
				break;
				case 'Sunday':
					$nombreDia = "Domingo";
					$indice = 6;
				break;
			}
			return $arrayName = array('0' => $nombreDia ,'1' => $indice);
		}
		//Obtenemos el ultimo dia numerico del mes
		function getDiasMes(){
			$diasMes = array();
			$ultimoDiaMes = self::getUltimoDiaMes();
			for($x=0;$x<$ultimoDiaMes[1];$x++){
				$diasMes[] = $x+1;
			}
			return $diasMes;
		}
		//Obtenemos el nombre del primer dia del mes
		function getNombrePrimerDiaMes(){
			$x = date("w",mktime(0, 0, 0, $this->mesActual , 1 , $this->yearActual));
			$nombreDia = array('0'=> "Domingo",'1'=> "Lunes",'2'=> "Martes",'3'=> "Miercoles",'4'=> "Jueves",'5'=> "Viernes",'6'=> "Sabado");
			$indice = array('0'=> "6",'1'=> "0",'2'=> "1",'3'=> "2",'4'=> "3",'5'=> "4",'6'=> "5");
			return $arrayName = array('0' => $nombreDia[$x] ,'1' => $indice[$x]);
		}
		//Declaramos el mes 1
		function getPrimerMes(){
			$primerMes = 1;
			return $primerMes; 
		}
		//Declaramos el mes 12
		function getUltimoMes() {
		 	$ultimoMes = 12;
		 	return $ultimoMes;
		}
		//Obtenemos el nombre del mes actual
		function getNombreMes($numeroDeMes){
			$x = $numeroDeMes;
			$NombreMes = array('1'=> "Enero",'2'=> "Febrero",'3'=> "Marzo",'4'=> "Abril",'5'=> "Mayo",'6'=> "Junio",'7'=> "Julio",'8'=> "Agosto",'9'=> "Septiembre",'10'=> "Octubre",'11'=> "Noviembre",'12'=> "Diciembre");
			$indice = array('1'=> "0",'2'=> "1",'3'=> "2",'4'=> "3",'5'=> "4",'6'=> "5",'7'=> "6",'8'=> "7",'9'=> "8",'10'=> "9",'11'=> "10",'12'=> "11");
			return $arrayName = array('0' => $NombreMes[$x] ,'1' => $indice[$x]);
		}
		/* Funcion que nos crea el calendario */
        function crearCalendarios(){
            @session_start();
            $diasDeLaSemana = self::diasDeLaSemana();
            $diasMes = self::getDiasMes();
            $primerDiaMes = self::getNombrePrimerDiaMes();
            $ultimoDiaMes = self::getUltimoDiaMes();
			$nombreDelMes = self::getNombreMes(date("n",mktime(0, 0, 0, $this->mesActual , 1 , $this->yearActual)));
			//Creamos el div que contendra la tabla con los dias del mes y lo almacenamos en un string que luego mostraremos
            $calendariosSTR = "<div class='mes'>";
            $calendariosSTR .= "<table border='1'>";
            $calendariosSTR .= "<tr class='filas-peq'>";
            $calendariosSTR .= "<td colspan='7'><span class='big-name'>".date("Y",mktime(0, 0, 0, $this->mesActual , 1 , $this->yearActual))."</span></td>";
            $calendariosSTR .= "</tr>";
            $calendariosSTR .= "<tr class='filas-peq'>";
            $calendariosSTR .= "<td colspan='7'><button id='botonant' class='btn-class bazul' onclick='mesAnterior()'><</button><span class='big-name fijo'>".$nombreDelMes[0]."</span><button id='botonsig' class='btn-class bazul' onclick='mesSiguiente()'>></button></td>";
            $calendariosSTR .= "</tr>";
            $calendariosSTR .= "<tr class='filas-peq'>";
            for($i=0;$i<7;$i++){
                $calendariosSTR .= '<td><span class="big-name">'.$diasDeLaSemana[$i].'</span></td>';
            }
            $calendariosSTR .= "</tr>";
            $x=0;
            for($s=0;$s<6;$s++){
                $calendariosSTR .= "<tr>";
                for($d=0;$d<7;$d++){
                    if($s==0 && $d<$primerDiaMes[1]){
                        $calendariosSTR .= "<td></td>";
                        continue;
                    }else{
                        if($x<$ultimoDiaMes[1]){
                        	//Obtenemos los eventos de todo el mes y los mostramos
                            $result;
                            $result = claseEventos::cargarEventos($_SESSION['usuario'],$diasMes[$x],date("n",mktime(0, 0, 0, $this->mesActual , 1 , $this->yearActual)),date("Y",mktime(0, 0, 0, $this->mesActual , 1 , $this->yearActual)),$_SESSION['nombrecal']);

                            if($diasMes[$x]==date("j") && $this->mesActual==date("n") && $this->yearActual==date("Y")){
                        		$calendariosSTR .= "<td class='diaactual'><a href='#' class='big-link' flip='A' onclick='fechasIniciales.fechaSeleccionada(";
                                $fd = date("j",mktime(0, 0, 0, $this->mesActual , $diasMes[$x] , $this->yearActual));
                                $fm = date("n",mktime(0, 0, 0, $this->mesActual , $diasMes[$x] , $this->yearActual));
                                $fy = date("Y",mktime(0, 0, 0, $this->mesActual , $diasMes[$x] , $this->yearActual));
                                $calendariosSTR .= $fd.',';
                                $calendariosSTR .= $fm.',';
                                $calendariosSTR .= $fy;
                                $calendariosSTR .= ")'>".$diasMes[$x]."</a>";
                                $calendariosSTR .= '<p>';
                                if(!empty($result)){
                                    for($e=0;$e<count($result);$e++){
                                        if($e<3){
                                        	$calendariosSTR .= '<span class="estilo-evento" id="'.$result[$e]['etiqueta'].'">';
                                        	$calendariosSTR .=  '<a href="#" class="a-white" onclick="consultarEventos(\''.$diasMes[$x].'\',\''.$this->mesActual.'\',\''.$this->yearActual.'\',\''.$result[$e]['horai'].'\',\''.$result[$e]['horaf'].'\',\''.$_SESSION['usuario'].'\',\''.$result[$e]['titulo'].'\');" flip="C">';
                                        	$calendariosSTR .= $result[$e]['titulo'].'</a></span>';
                                        }else{
                                        	break;
                                        }
                                    }
                                    $calendariosSTR .= '<a href="#" class="no-ver" onclick="consultarListaEventos(\''.$diasMes[$x].'\',\''.$this->mesActual.'\',\''.$this->yearActual.'\',\''.$_SESSION['usuario'].'\',\''.$_SESSION['nombrecal'].'\');">Mas...</a>';
                                }
                                $calendariosSTR .= '</p>';
                                $calendariosSTR .= '</td>';
                        	}else{
                            	$calendariosSTR .= "<td><a href='#' class='big-link' flip='A' onclick='fechasIniciales.fechaSeleccionada(";
                                $fd = date("j",mktime(0, 0, 0, $this->mesActual , $diasMes[$x] , $this->yearActual));
                                $fm = date("n",mktime(0, 0, 0, $this->mesActual , $diasMes[$x] , $this->yearActual));
                                $fy = date("Y",mktime(0, 0, 0, $this->mesActual , $diasMes[$x] , $this->yearActual));
                                $calendariosSTR .= $fd.',';
                                $calendariosSTR .= $fm.',';
                                $calendariosSTR .= $fy;
                                $calendariosSTR .= ")'>".$diasMes[$x]."</a>";
                                $calendariosSTR .= '<p>';
                                if(!empty($result)){
                                    for($e=0;$e<count($result);$e++){
                                        if($e<3){
                                        	$calendariosSTR .= '<span class="estilo-evento" id="'.$result[$e]['etiqueta'].'">';
                                       		$calendariosSTR .=  '<a href="#" class="a-white" onclick="consultarEventos(\''.$diasMes[$x].'\',\''.$this->mesActual.'\',\''.$this->yearActual.'\',\''.$result[$e]['horai'].'\',\''.$result[$e]['horaf'].'\',\''.$_SESSION['usuario'].'\',\''.$result[$e]['titulo'].'\');" flip="C">';
                                        	$calendariosSTR .= $result[$e]['titulo'].'</a></span>';
                                        }else{
                                        	break;
                                        }
                                    }
                                    $calendariosSTR .= '<a href="#" class="no-ver" onclick="consultarListaEventos(\''.$diasMes[$x].'\',\''.$this->mesActual.'\',\''.$this->yearActual.'\',\''.$_SESSION['usuario'].'\',\''.$_SESSION['nombrecal'].'\');">Mas...</a>';
                                }else{
                                    $calendariosSTR .= '<span class="estilo-evento" style="">&nbsp;</span>';
                                }
                                $calendariosSTR .= '</p>';
                                $calendariosSTR .= '</td>';
                            }
                            $x++;
                        }else{
                            $calendariosSTR .= "<td><span class='numerooculto'>0</span></td>";
                        }

                    }
                }
                $calendariosSTR .= "</tr>";
            }
            $calendariosSTR .= "</table>";
            $calendariosSTR .= "</div>";
            $_SESSION['calendario'] = $calendariosSTR;
            //Guardamos el mes y el año que estamos viendo, para que al pulsar siguiente, pase el mes siguiete al que estamos vieno.
            //Lo mismo cuando pulsamos anterior, regesamos el mes anterior al que estamos viendo
            $mesvisual = date("n",mktime(0, 0, 0, $this->mesActual , 1 , $this->yearActual));
            $yearvisual = date("Y",mktime(0, 0, 0, $this->mesActual , 1 , $this->yearActual));
            return $arrayvalue = array('0' => $calendariosSTR, '1' => $mesvisual,'2' => $yearvisual);
        }

	}

?>
