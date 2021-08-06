<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	require 'funcs/conexion.php'; //Funcion para incluir el archivo 
	include 'funcs/funcs.php'; //para agregar el archivo
	
	if(!isset($_SESSION["id_usuario"])){ //Si no ha iniciado sesión redirecciona a index.php
		header("Location: index.php"); //Redirecciona a index.php
	}
	
	$idUsuario = $_SESSION['id_usuario']; //obtener el valor de la variable id_usuario
	
	$sql = "SELECT id, nombre FROM usuarios WHERE id = '$idUsuario'"; //consulta SQL
	$result = $mysqli->query($sql); //Funcion para ejecutar la consulta SQL
	
	$row = $result->fetch_assoc(); //visualizar la informacion
?> 
<?php if($_SESSION['tipo_usuario'] == 3): ?>
<?php header('Location: pages/panel1'); ?> <!--Redirecciona a pages/panel1 -->
<?php else: ?>
<script>alert('No tienes privilegios de profesor'); location.href="index";</script>
<?php endif; ?> <!--Manda una alerta si no tienes acceso y te redirecciona a index -->