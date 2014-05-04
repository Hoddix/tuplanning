<?php 
	
    include_once('claseConexion.php');
    include_once('claseEventos.php');
    $Conexion = new Conexion("localhost", "root", "", "tuplanning");
    $Conexion->conectarServidor();
    $Conexion->seleccionarBaseDatos();

	class clasePatron{

		public $diaActual;
		public $mesActual;
		public $yearActual;

		function __construct($diaA, $mesA, $yearA){
			$this->diaActual = $diaA;
			$this->mesActual = $mesA;
			$this->yearActual = $yearA;
		}

        function diasDeLaSemana(){
            $diasdelasemana = array('0' => "Lunes",'1' => "Martes",'2' => "Miercoles",'3' => "Jueves",'4' => "Viernes",'5' => "Sabado",'6' => "Domingo",);
            return $diasdelasemana;
        }

        function meses(){
            $meses = array('1'=> "Enero",'2'=> "Febrero",'3'=> "Marzo",'4'=> "Abril",'5'=> "Mayo",'6'=> "Junio",'7'=> "Julio",'8'=> "Agosto",'9'=> "Septiembre",'10'=> "Octubre",'11'=> "Noviembre",'12'=> "Diciembre");
            return $meses;
        }

		function getPrimerDiaMes(){
			return 1; 
		}

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

		function getDiasMes(){
			$diasMes = array();
			$ultimoDiaMes = self::getUltimoDiaMes();
			for($x=0;$x<$ultimoDiaMes[1];$x++){
				$diasMes[] = $x+1;
			}
			return $diasMes;
		}

		function getNombrePrimerDiaMes(){
			$x = date("w",mktime(0, 0, 0, $this->mesActual , 1 , $this->yearActual));
			$nombreDia = array('0'=> "Domingo",'1'=> "Lunes",'2'=> "Martes",'3'=> "Miercoles",'4'=> "Jueves",'5'=> "Viernes",'6'=> "Sabado");
			$indice = array('0'=> "6",'1'=> "0",'2'=> "1",'3'=> "2",'4'=> "3",'5'=> "4",'6'=> "5");
			return $arrayName = array('0' => $nombreDia[$x] ,'1' => $indice[$x]);
		}

		function getPrimerMes(){
			$primerMes = 1;
			return $primerMes; 
		}

		function getUltimoMes() {
		 	$ultimoMes = 12;
		 	return $ultimoMes;
		}

		function getNombreMes($numeroDeMes){
			$x = $numeroDeMes;
			$NombreMes = array('1'=> "Enero",'2'=> "Febrero",'3'=> "Marzo",'4'=> "Abril",'5'=> "Mayo",'6'=> "Junio",'7'=> "Julio",'8'=> "Agosto",'9'=> "Septiembre",'10'=> "Octubre",'11'=> "Noviembre",'12'=> "Diciembre");
			$indice = array('1'=> "0",'2'=> "1",'3'=> "2",'4'=> "3",'5'=> "4",'6'=> "5",'7'=> "6",'8'=> "7",'9'=> "8",'10'=> "9",'11'=> "10",'12'=> "11");
			return $arrayName = array('0' => $NombreMes[$x] ,'1' => $indice[$x]);
		}

        function crearCalendarios(){
            $diasDeLaSemana = self::diasDeLaSemana();
            $diasMes = self::getDiasMes();
            $primerDiaMes = self::getNombrePrimerDiaMes();
            $ultimoDiaMes = self::getUltimoDiaMes();
			$nombreDelMes = self::getNombreMes(date("n",mktime(0, 0, 0, $this->mesActual , 1 , $this->yearActual)));

            $calendariosSTR = "<div id='mes'>";
            $calendariosSTR .= "<table border='1'>";
            $calendariosSTR .= "<tr class='filas-peq'>";
            $calendariosSTR .= "<td colspan='7'><span class='big-name'>".date("Y",mktime(0, 0, 0, $this->mesActual , 1 , $this->yearActual))."</span></td>";
            $calendariosSTR .= "</tr>";
            $calendariosSTR .= "<tr class='filas-peq'>";
            $calendariosSTR .= "<td colspan='7'>".$nombreDelMes[0]."</td>";
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
                            if($diasMes[$x]==date("j") && $this->mesActual==date("n") && $this->yearActual==date("Y")){
                        		$calendariosSTR .= "<td id='diaactual'>".$diasMes[$x]."</td>";

                        	}else{
                            	$calendariosSTR .= "<td>".$diasMes[$x]."</td>";
                            }
                            $x++;
                        }else{
                            $calendariosSTR .= "<td><span class='numerooculto'>&nbsp;</span></td>";
                        }

                    }
                }
                $calendariosSTR .= "</tr>";
            }
            $calendariosSTR .= "</table>";
            $calendariosSTR .= "</div>";
            //$mesvisual = date("n",mktime(0, 0, 0, $this->mesActual , 1 , $this->yearActual));
            //$yearvisual = date("Y",mktime(0, 0, 0, $this->mesActual , 1 , $this->yearActual));
            //return $arrayvalue = array('0' => $calendariosSTR, '1' => $mesvisual,'2' => $yearvisual);
            return $calendariosSTR;
        }









	}

?>