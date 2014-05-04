<?php 
	include_once('claseConexion.php');
  	$Conexion = new Conexion("localhost", "root", "", "tuplanning");
    $Conexion->conectarServidor();
    $Conexion->seleccionarBaseDatos();

    //Obtenemos el dia siguiente del actual
    $Diasiguiente = date('Y').'-'.date('n').'-'.date('j',mktime(0,0,0,date('n'),date('j')+1,date('Y')));

	$query = 'select * from eventos where fechai="'.$Diasiguiente.'" and recordar="si" group by etiqueta,titulo';
	$consulta = mysql_query($query);
	while($row=mysql_fetch_array($consulta)){
		$eventos[] = $row;
	}

	if(@count($eventos)!=0){
		$query = 'select * from eventos where fechai="'.$Diasiguiente.'" group by usuario';
		$consulta = mysql_query($query);
		while($row=mysql_fetch_array($consulta)){
			$usuarios[] = $row;
		}

		for($x=0;$x<count($usuarios);$x++){
			$query = 'select * from eventos where fechai="'.$Diasiguiente.'" and recordar="si" and usuario="'.$usuarios[$x][1].'" group by titulo';
			$consulta = mysql_query($query);
			while($row=mysql_fetch_array($consulta)){
				$eventordeusuario[] = $row;
			}

			$query = 'select * from usuarios where usuario="'.$usuarios[$x][1].'" group by email,usuario';
			$consulta = mysql_query($query);
			while($row=mysql_fetch_array($consulta)){
				$email[] = $row;
			}
			for($y=0;$y<count($eventordeusuario);$y++){
				$body = "
				<html>
				<head>
				<title>Recordatorio de evento</title>
				</head>
				<body style='background:#EEE; padding:30px;'>
				<h2 style='color:#767676;'>Recordatorio de evento " .$eventordeusuario[$y]['titulo']. "</h2><br/>";

				$body .= "
				<strong style='color:#0090C6;'>Titulo del evento: </strong>
				<span style='color:#767676;'>" .$eventordeusuario[$y]['titulo']. "</span><br/>";

				$body .= "
				<strong style='color:#0090C6;'>Hora de inicio: </strong>
				<span style='color:#767676;'>" .$eventordeusuario[$y]['horai']. "</span><br/>";

				$body .= "
				<strong style='color:#0090C6;'>Hora final: </strong>
				<span style='color:#767676;'>" .$eventordeusuario[$y]['horaf']. "</span><br/>";

				$body .= "
				<strong style='color:#0090C6;'>Fecha de inicio: </strong>
				<span style='color:#767676;'>" .$eventordeusuario[$y]['fechai']. "</span><br/>";

				$body .= "
				<strong style='color:#0090C6;'>Fecha final: </strong>
				<span style='color:#767676;'>" .$eventordeusuario[$y]['fechaf']. "</span><br/>";

				$body .= "
				<strong style='color:#0090C6;'>Anotaciones: </strong>
				<span style='color:#767676;'>" .$eventordeusuario[$y]['observaciones']. "</span><br/>";

				$body .= "</body></html>";
		
			}
			
				
			// HTML HEADERS
			$headers = "From: Tuplanning.com <recordatorio@tuplanning.com>\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
			$headers .= "Content-Transfer-Encoding: 8bit\r\n";
			
			// SEND MAIL
			mail($email[$x][6], "Recordatorio Tuplanning.com" , $body, $headers);
			unset($eventordeusuario);		
		}
	}
?>