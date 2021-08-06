<?php 
	session_start(); //Iniciar una sesion
	require '../../funcs/conexion.php'; //Funcion para incluir el archivo
	require '../../funcs/funcs.php'; //Funcion para incluir el archivo

  if(isset($_POST['submit'])){
    
    $clase = $_POST['clase']; //obtener lo que tenga la variable clase

    $class = "INSERT INTO clases (clase) VALUES ('$clase') "; //sentencia SQL
      if (mysqli_query($mysqli, $class)) {  //acceder a la base de datos, ejecutar la sentencia
        echo "Nueva clase Agregada"; //mensaje
        header('Location: clase'); //redireccionar a clase
      } else { //de lo contrario
        echo "Error: " . $class . "<br>" . mysqli_error($mysqli); //mensaje
    }
  }

?>