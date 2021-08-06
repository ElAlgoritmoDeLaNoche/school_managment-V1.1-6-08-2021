<?php
	
	require '../funcs/conexion.php'; //Funcion para incluir el archivo
	require '../funcs/funcs.php';//Funcion para incluir el archivo
	
	//inyeccion SQL
	$user_id = $mysqli->real_escape_string($_POST['user_id']);
	$token = $mysqli->real_escape_string($_POST['token']);
	$password = $mysqli->real_escape_string($_POST['password']);
	$con_password = $mysqli->real_escape_string($_POST['con_password']);
	
	//si validaPassowd obtiene las variables
	if(validaPassword($password, $con_password))
	{
		
		$pass_hash = hashPassword($password); //variable
		
		//si cambiaPassword obtiene las variables
		if(cambiaPassword($pass_hash, $user_id, $token))
		{
			echo "Contrase&ntilde;a Modificada <br> <a href='../index' >Iniciar Sesion</a>"; //mensaje
			} else { //de lo contrario
			
			echo "Error al modificar contrase&ntilde;a"; //mensaje
			
		}
		
		} else { //de lo contrario
		
		echo 'Las contraseñas no coinciden'; //mensaje
		
	}
?>	