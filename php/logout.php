
<?php 
	//Iniciamos sesion y la destruimos
	session_start();
	session_destroy();
	//Nos vamos al index.php
    header('Location: ../index.php');	
?>
