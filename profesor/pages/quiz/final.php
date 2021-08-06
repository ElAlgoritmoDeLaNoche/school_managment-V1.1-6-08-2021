<?php 
	session_start(); //Iniciar una sesion
	require '../../funcs/conexion.php'; //Funcion para incluir el archivo
	include '../../funcs/funcs.php'; //incluir el archivo

?>

<html>
<head>
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
	<link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="../../assets/css/style.min.css">
  <link rel="stylesheet" href="../../assets/css/components.min.css">
  <link rel="stylesheet" href="css/estilos.css">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
	
</head>
<body>

	<header>
		<div class="container">
			<p>PHP Quizer</p>
		</div>
	</header>

	<main>
		<div class="container">
			<h2>Tu resultado</h2>
			<p>Felicitaciones Ha completado esta prueba con éxito.</p>
			<p>Tu <strong>puntaje</strong> es <?php echo $_SESSION['score']; ?>  </p> <!--imprime lo que tenga score -->
			<?php unset($_SESSION['score']); ?> 
			<button type="submit" class="btn btn-primary" >Terminar</button>
		</div>
	</main>

	<?php
		$url ="http://192.168.64.2/school_managment/profesor/pages/panel1"; // aqui pones la url
		$tiempo_espera = 10; // Aquí se configura cuántos segundos hasta la actualización.
		// Declaramos la funcion apra la redirección
		header("refresh: $tiempo_espera; url=$url");
	?>
	
</body>
</html>