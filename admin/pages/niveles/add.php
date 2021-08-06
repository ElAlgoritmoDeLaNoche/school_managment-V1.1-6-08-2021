<?php 
	session_start(); //Iniciar una sesion
	require '../../funcs/conexion.php';  //Funcion para incluir el archivo
	require '../../funcs/funcs.php';  //Funcion para incluir el archivo

  if(isset($_POST['submit'])){
    
    $nivel = $_POST['nivel']; //obtenemos el valor de la variable de nivel

    $class = "INSERT INTO niveles (nivel) VALUES ('$nivel') "; //sentencia SQL
      if (mysqli_query($mysqli, $class)) { //acceder a la base de datos y ejecutar la sentencia
        echo "Nueva clase Agregada"; //mensaje
        header('Location: nivel'); //redireccionar a nivel
      } else { //de lo contrario
        echo "Error: " . $class . "<br>" . mysqli_error($mysqli); //mensaje
    }
  }

?>