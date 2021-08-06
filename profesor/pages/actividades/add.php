<?php 
	session_start(); //Iniciar una sesion
	require '../../funcs/conexion.php'; //Funcion para incluir el archivo
	require '../../funcs/funcs.php'; //Funcion para incluir el archivo

  if (isset($_POST['titulo'])) {  //obtiene el valor que tenga la variable titulo

    $titulo = $_POST['titulo']; //obtener lo que tenga la variable titulo 
    $descripcion = $_POST['descripcion']; //obtener lo que tenga la variable descripcion
    $materia = $_POST['materia']; //obtener lo que tenga la variable materia
    $nivel = $_POST['nivel']; //obtener lo que tenga la variable nivel
    $inicio = $_POST['inicio']; //obtener lo que tenga la variable inicio
    $final = $_POST['final']; //obtener lo que tenga la variable final

    $asignacion = "INSERT INTO actividades (titulo, materia, descripcion, nivel, inicio, final) VALUES ('$titulo', '$materia', '$descripcion','$nivel', '$inicio', '$final') "; //sentencia SQL
      if (mysqli_query($mysqli, $asignacion)) { //si hace la conexion  a la base de datos y ejecuta la sentencia
        $grupo_d = $_SESSION['param']; //variable
        echo "Asignación creada"; //mensaje
        header("Location: ../panel1"); //redireccionamiento a ../panel1
      } else { //de lo contrario 
        echo "Error: " . $asignacion . "<br>" . mysqli_error($mysqli); //mensaje
    }
  }

?>