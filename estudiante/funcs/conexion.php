<?php
	
	$mysqli=new mysqli("localhost","root","root","u687324508_school_managme"); //servidor, usuario de base de datos, contraseña del usuario, nombre de base de datos
	
	//Funcion para error al conectar con la base de datos
	if(mysqli_connect_errno()){
		echo 'Conexion Fallida : ', mysqli_connect_error();
		exit(); //Funcion para salir del codigo
	}
	
?>