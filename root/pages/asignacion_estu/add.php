<?php 
	session_start(); //iniciar una sesion
	require '../../funcs/conexion.php'; //Funcion para incluir el archivo
	require '../../funcs/funcs.php'; //Funcion para incluir el archivo

  if (isset($_POST['alumno'])) { //obtener el valor de la variable alumno
    $alumno = $_POST['alumno']; //obtener el valor de la variable alumno
    $nivel = $_POST['nivel']; //obtener el valor de la variable nivel
    $grupo = $_POST['grupo']; //botener el valor de la variable grupo

    $asignacion = "INSERT INTO asignacion_estu (nom_estu, nivel, grupo_estu) VALUES ('$alumno', '$nivel', '$grupo') "; //sentencia SQL
      if (mysqli_query($mysqli, $asignacion)) { //si hay conexion a la base de datos, valor de la variable asignacion
        echo "Asignación creada"; //mensaje
        header('Location: asign'); //redireccion a asign
      } else { //de lo contrario
        echo "Error: " . $asignacion . "<br>" . mysqli_error($mysqli); //mensaje
    }
  }

?>