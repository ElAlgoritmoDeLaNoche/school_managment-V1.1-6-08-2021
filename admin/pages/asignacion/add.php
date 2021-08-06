<?php 
	session_start(); //Iniciar una sesion
	require '../../funcs/conexion.php'; //Funcion para incluir el archivo
	require '../../funcs/funcs.php'; //Funcion para incluir el archivo

  if (isset($_POST['profesor'])) { //obtener lo que tenga la variable profesor
    $profesor = $_POST['profesor']; //obtener lo que tenga la variable profesor
    $nivel = $_POST['nivel']; //obtener lo que tenga la variable param
    $clase = $_POST['clase']; //obtener lo que tenga la variable clase
    $grupo = $_POST['grupo']; //obtener lo que tenga la variable grupo

    $asignacion = "INSERT INTO asignacion (nom_prof, nivel, clase, grupo) VALUES ('$profesor','$nivel','$clase', '$grupo') "; //sentencia SQL
      if (mysqli_query($mysqli, $asignacion)) { //si hay conexion a la base de datos, valor de la variable asignacion
        echo "Asignación creada"; //mensaje
        header('Location: asign'); //redireccion a asign
      } else { //de lo contrario
        echo "Error: " . $asignacion . "<br>" . mysqli_error($mysqli); //mensaje
    }
  }

?>