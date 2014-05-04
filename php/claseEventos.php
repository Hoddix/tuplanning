<?php 

	include_once('claseConexion.php');
  	$Conexion = new Conexion("localhost", "root", "", "tuplanning");
    $Conexion->conectarServidor();
    $Conexion->seleccionarBaseDatos();

	class claseEventos{

		public $usuario;
		public $titulo;
		public $etiqueta;
		public $year;
		public $mes;
		public $dia;
		public $horai;
		public $horaf;
		public $fechai;
		public $fechaf;
		public $nombrecal;
		public $recordar;
		public $observaciones;
		//Recibe los parametros necesarios para crear el evento
		function __construct($user,$tit,$eti,$hoi,$hof,$fechai,$fechaf,$nombrecal,$obs,$rec){
			$this->usuario = $user;
			$this->titulo = $tit;
			$this->etiqueta = $eti;
			$this->horai = $hoi;
			$this->horaf = $hof;
			$this->fechai = $fechai;
			$this->fechaf = $fechaf;
			$this->nombrecal = $nombrecal;
			$this->recordar = $rec;
			$this->observaciones = $obs;
		}
		//Funcion que inserta el evento
		function insertarEventos(){
			$fecha1 = new DateTime($this->fechai); //Obtenemos la fecha inicial
			$fecha2 = new DateTime($this->fechaf); //Obtenemos la fecha final
			$intervalo = $fecha1->diff($fecha2); //Hacemos la diferencia

			$Years = intval($intervalo->format('%y')); //Obtenemos los años de diferencia entre las fechas
			$Meses = intval($intervalo->format('%m')); //Obtenemos los meses de diferencia entre las fechas
			$Dias = intval($intervalo->format('%d')); //Obtenemos los dias de diferencia entre las fechas

			$DiasTotales = intval($intervalo->format('%a')); //Sacamos los dias totales de diferencia entre las fehcas

			//Separamos las fechas en dias, meses, años
			$this->dia = date("j",strtotime($this->fechai));
			$this->mes = date("n",strtotime($this->fechai));
			$this->year = date("Y",strtotime($this->fechai));

			//Cambiamos el formato de la fecha a Español
			$fechaini = date("Y-n-d",strtotime($this->fechai));
			$fechafin = date("Y-n-d",strtotime($this->fechaf));

			//Si no hay diferencia entre las fechas, significa que solo es un evento de un dia, e insertamos ese evento
			if($Dias == 0 && $Meses == 0 && $Years == 0){
				$query = 'insert into eventos (idevento,usuario,titulo,etiqueta,ano,mes,dia,horai,horaf,fechai,fechaf,nombrecal,observaciones,recordar) values (null,"'.$this->usuario.'","'.$this->titulo.'","'.$this->etiqueta.'","'.$this->year.'","'.$this->mes.'","'.$this->dia.'","'.$this->horai.'","'.$this->horaf.'","'.$fechaini.'","'.$fechafin.'","'.$this->nombrecal.'","'.$this->observaciones.'","'.$this->recordar.'")';
				if(mysql_query($query)){
					header('Location: ../calendario.php');
				}
			}
			//Si hay algun tipo de diferencia entre las fechas, creamos el evento en tantos dias como diferencia haya entre ellas.
			elseif($Dias > 0 || $Meses > 0 || $Years > 0){
				$x=0;
				while($x<=$DiasTotales){

					$year = date("Y",(mktime(0,0,0,$this->mes,$this->dia+$x,$this->year)));
					$mes = date("n",(mktime(0,0,0,$this->mes,$this->dia+$x,$this->year)));
					$dia = date("j",(mktime(0,0,0,$this->mes,$this->dia+$x,$this->year)));

					$query = 'insert into eventos (idevento,usuario,titulo,etiqueta,ano,mes,dia,horai,horaf,fechai,fechaf,nombrecal,observaciones,recordar) values (null,"'.$this->usuario.'","'.$this->titulo.'","'.$this->etiqueta.'","'.$year.'","'.$mes.'","'.$dia.'","'.$this->horai.'","'.$this->horaf.'","'.$fechaini.'","'.$fechafin.'","'.$this->nombrecal.'","'.$this->observaciones.'","'.$this->recordar.'")';
					if(!mysql_query($query)){
						echo mysql_error();
					}
					$x++;
																
				}
			header('Location: ../calendario.php'); //Despues de insertar el evento, actualiza la web para mostrarnoslo
			}
		}
		//Funcion que carga los eventos
		static function cargarEventos($usuario,$dia,$mes,$year,$cal){
			$result = "";
			$query = 'select * from eventos where usuario="'.$usuario.'" and dia="'.$dia.'" and mes="'.$mes.'" and ano="'.$year.'" and nombrecal="'.$cal.'"';
            $consulta = mysql_query($query);
            if(mysql_num_rows($consulta)>0){
	            while($row=mysql_fetch_array($consulta)){
	                $result[] = $row;
	            }
	            return $result;
            }else{
            	$result = "";
            	return $result;
            }          
		}
		//Funcion que carga los eventos diarios
        static function mostrarEventosDiarios($usuario,$dia,$mes,$year,$horai,$horaf,$titulo){
			$result = "";
			$query = 'select * from eventos where usuario="'.$usuario.'" and dia="'.$dia.'" and mes="'.$mes.'" and ano="'.$year.'" and horai="'.$horai.'" and horaf="'.$horaf.'" and titulo="'.$titulo.'"';
            $consulta = mysql_query($query);
            while($row=mysql_fetch_array($consulta)){
                $result[] = $row;
            }
            //print_r($result);
            return $result;
        }
        //Funcion que borrar todo el evento, ya sea de un dia o de semanas o meses
        static function borrarTodoElEvento($usuario,$fechai,$fechaf,$titulo){
			$result = "";
			$query = 'delete from eventos where usuario="'.$usuario.'" and fechai="'.$fechai.'" and fechaf="'.$fechaf.'" and titulo="'.$titulo.'"';
            if(mysql_query($query)){
            	$result =  'Borrado todo el evento';
            	return $result;
            }else{
            	$result = "No se ha podido borrar el evento.";
            	return $result;
            }
        }
        //Funcion que borrar solo el evento seleccionado, pero solo el de ese dia
        static function borrarEventoDeHoy($usuario,$dia,$mes,$year,$horai,$horaf,$titulo){
			$result = "";
			$query = 'delete from eventos where usuario="'.$usuario.'" and dia="'.$dia.'" and mes="'.$mes.'" and ano="'.$year.'" and horai="'.$horai.'" and horaf="'.$horaf.'" and titulo="'.$titulo.'"';
            if(mysql_query($query)){
            	echo 'Borrado el evento de hoy';
            }
        }
        //Funcion que nos carga los datos en un form para despues poder actualizar el evento
        static function editarEvento($usuario,$dia,$mes,$year,$horai,$horaf,$titulo){
    		$query = 'select * from eventos where usuario="'.$usuario.'" and dia="'.$dia.'" and mes="'.$mes.'" and ano="'.$year.'" and horai="'.$horai.'" and horaf="'.$horaf.'" and titulo="'.$titulo.'"';
			$consulta = mysql_query($query);
			$resultado = mysql_fetch_row($consulta);
		
			return $resultado;
    	}
    	//Funcion que nos actualiza el evento diario.
        static function actualizarEvento($usuario,$titulo,$etiqueta,$horai,$horaf,$nombrecal,$obs,$rec,$v_titulo,$v_dia,$v_mes,$v_year,$v_horai,$v_horaf,$v_fechai,$v_fechaf){
			
			$query = "UPDATE eventos SET titulo = '".$titulo."',
				etiqueta = '".$etiqueta."',
				horai = '".$horai."',
				horaf = '".$horaf."',
				nombrecal = '".$nombrecal."',
				observaciones = '".$obs."',
				recordar = '".$rec."' WHERE usuario = '".$usuario."' and fechai = '".$v_fechai."' and fechaf = '".$v_fechaf."' and titulo = '".$v_titulo."' and horai = '".$v_horai."' and horaf = '".$v_horaf."'";
	    	if (mysql_query($query)) {
				header('Location: ../calendario.php');
			}else{
				echo mysql_error();
			}
    	}
	}

?>
