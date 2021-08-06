<?php
	
	require '../funcs/conexion.php'; //Funcion para incluir el archivo
	require '../funcs/funcs.php'; //Funcion para incluir el archivo
	
	if(isset($_GET["id"]) AND isset($_GET['val'])) //si tenemo el id y val correctos
	{
		
		$idUsuario = $_GET['id']; //obtener lo que tenga la variable id
		$token = $_GET['val']; //obtener lo que tenga la variable val

		$mensaje = validaIdToken($idUsuario, $token);	 //variable
	}
?>

<html>
	<head>
		<title>Registro</title>
		<link rel="stylesheet" href="css/bootstrap.min.css" >
		<link rel="stylesheet" href="css/bootstrap-theme.min.css" >
		<script src="js/bootstrap.min.js" ></script>
		
	</head>
	
	<body>
		<div class="container">
			<div class="jumbotron">
				
				<h1><?php echo $mensaje; ?></h1> <!--mensaje -->
				
				<br />
				<!--parrafo con un link -->
				<p><a class="btn btn-primary btn-lg" href="../index" role="button">Iniciar Sesi&oacute;n</a></p>
			</div>
		</div>
	</body>
</html>														