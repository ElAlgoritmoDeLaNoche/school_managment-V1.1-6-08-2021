<?php 
  require '../../funcs/conexion.php'; //Funcion para incluir el archivo
	include '../../funcs/funcs.php'; //incluir el archivo
	session_start();   //Iniciar una sesion
	//Set Question Number
	$number = $_GET['n']; //variable

	//Query for the Question
	$query = "SELECT * FROM questions WHERE question_number = $number"; //sentencia SQL

	// Get the question
	$result = mysqli_query($mysqli,$query); //acceder a la base de datos y ejecutar la sentencia
	$question = mysqli_fetch_assoc($result);  //visualizar la informacion 

	//Get Choices
	$query = "SELECT * FROM options WHERE question_number = $number"; //sentencia SQL
	$choices = mysqli_query($mysqli,$query); //acceder a la base de datos y ejecutar la sentencia 
	// Get Total questions
	$query = "SELECT * FROM questions"; //sentencia SQL
	$total_questions = mysqli_num_rows(mysqli_query($mysqli,$query)); //acceder a la base de datos y ejecutar la sentencia
	
?>
<html>
<head>
<meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Panel &mdash; Folder X</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="../../assets/modules/bootstrap/css/bootstrap.min.css">
  <!--<link rel="stylesheet" href="../assets/modules/fontawesome/css/all.min.css">-->
  <!-- CSS Libraries -->
  <link rel="stylesheet" href="../../assets/modules/jqvmap/dist/jqvmap.min.css">
  <link rel="stylesheet" href="../../assets/modules/summernote/summernote-bs4.css">
  <link rel="stylesheet" href="../../assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="../../assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="../../assets/css/style.min.css">
  <link rel="stylesheet" href="../../assets/css/components.min.css">
  <link rel="stylesheet" href="css/estilos.css">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
</head>
<body>

	<header>
		<div class="container">
			<p>Prueba</p>
		</div>
	</header>

	<main>
			<div class="container">
				<div class="current">Pregunta <?php echo $number; ?> de <?php echo $total_questions; ?> </div> <!--imprime lo que tenga la variable number y lo que tenga la variable total_questions -->
				<p class="question"><?php echo $question['question_text']; ?> </p> <!--imprime lo que tenga la variable question:question_text -->
				<form method="POST" action="process.php"> <!--formulario -->
					<ul class="choicess">
						<?php while($row=mysqli_fetch_assoc($choices)){ ?>
						<li><input type="radio" name="choice" value="<?php echo $row['id']; ?>"><?php echo $row['coption']; ?></li>
						<?php } ?> <!--imprime lo que tenga la variable row:id y row:coption -->
						
					</ul>
					<input type="hidden" name="number" value="<?php echo $number; ?>"><!--imprime lo que tenga la variable number -->
					<button type="submit" name="submit" value="Submit" class="btn btn-primary">Enviar</button>
				</form>
				

			</div>

	</main>

</body>
</html>