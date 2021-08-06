<?php 

require '../../funcs/conexion.php'; //Funcion para incluir el archivo
include '../../funcs/funcs.php'; //incluir el archivo
$query = "SELECT * FROM questions"; //sentencia SQL
$total_questions = mysqli_num_rows(mysqli_query($mysqli,$query)); //variable donde visualiza la informacion, accede a la base de datos y ejecuta la sentencia

if(!isset($_SESSION["id_usuario"])){ //Si no ha iniciado sesión redirecciona a index.php
	header("Location: index");
}

$idUsuario = $_SESSION['id_usuario']; //se obtiene lo que tenga la variable id_usuario

$sql = "SELECT id, nombre FROM usuarios WHERE id = '$idUsuario'"; //sentencia SQL
$result = $mysqli->query($sql); //ejecutar la sentencia
$row = $result->fetch_assoc(); //visualizar la informacion 

$NomSes = $row['nombre']; //variable

$estudiantes = "SELECT DISTINCT usuarios.id, usuarios.id_tipo, usuarios.nombre, usuarios.correo, asignacion.id_tipo, asignacion.grupo, asignacion_estu.grupo_estu, asignacion.nivel FROM `usuarios` INNER JOIN asignacion ON usuarios.id_tipo = usuarios.id_tipo INNER JOIN asignacion_estu ON asignacion.grupo = asignacion_estu.grupo_estu WHERE nom_prof = '$NomSes' AND usuarios.id_tipo = 4"; //sentencia SQL
$query = $mysqli->query($estudiantes); //ejecuta la sentencia
$array = mysqli_fetch_array($query); //visualizar la informacion

$grupo_d = $_SESSION['param']; //variable

?>

<html>
<head>
	<title>Panel &mdash; Folder X</title>

	<!-- General CSS Files -->
	<link rel="stylesheet" href="../assets/modules/bootstrap/css/bootstrap.min.css">
	<!--<link rel="stylesheet" href="../assets/modules/fontawesome/css/all.min.css">-->
	<!-- CSS Libraries -->
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" href="../assets/modules/jqvmap/dist/jqvmap.min.css">
	<link rel="stylesheet" href="../assets/modules/summernote/summernote-bs4.css">
	<link rel="stylesheet" href="../assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css">
	<link rel="stylesheet" href="../assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css">

	<!-- Template CSS -->
	<link rel="stylesheet" href="../assets/css/style.min.css">
	<link rel="stylesheet" href="../assets/css/components.min.css">

	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
	
</head>
<body>

	<main>
		<div class="container">
				<h2>Prueba de conocimiento</h2>
				<p>
					Este es un cuestionario de opción múltiple para evaluar tu conocimiento.
				</p>
				<ul>
					<li><strong>Numero de preguntas:</strong><?php echo $total_questions; ?> </li> <!--imprime lo que tenga la variable total_questions -->
					<li><strong>Tipo:</strong> Opción multiple</li>
					<li><strong>Tiempo estimado:</strong> <?php echo $total_questions*1.5; ?></li> <!--imprime lo que tenga la variable total_questions por 1.5 -->
				</ul>

				<a href="question.php?n=1" class="start">Iniciar questionario</a> <!--link que redirecciona a question.php -->

		</div>

	</main>

</body>
</html>