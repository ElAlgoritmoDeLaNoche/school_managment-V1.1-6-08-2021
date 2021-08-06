<?php 
	session_start(); //Iniciar una sesion
	require '../../funcs/conexion.php'; //Funcion para incluir el archivo
	require '../../funcs/funcs.php'; //Funcion para incluir el archivo

  if(isset($_POST['submit'])){
    
    $grupo = $_POST['grupo']; //obtenemos el valor de la variable de grupo

    $class = "INSERT INTO grupos (grupo) VALUES ('$grupo') "; //sentencia SQL
      if (mysqli_query($mysqli, $class)) { //acceder a la base de datos y ejecutar la sentencia
        echo "Nuevo grupo Agregado"; //mensaje
        header('Location: grupo'); //redireccionar a grupo
      } else { //de lo contrario
        echo "Error: " . $class . "<br>" . mysqli_error($mysqli); //mensaje
    }
  }

?>