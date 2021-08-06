<?php
	
	require 'funcs/conexion.php'; //Funcion para incluir el archivo 
	include 'funcs/funcs.php'; //para agregar el archivo
	
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	
	//if(isset($_SESSION["id_usuario"])){ //En caso de existir la sesión redireccionamos
	//	header("Location: welcome.php");
	//}
	
	$errors = array();  //array
	
	if(!empty($_POST))
	{
    //Para prevenir la inyeccion SQL
		$usuario = $mysqli->real_escape_string($_POST['usuario']);
		$password = $mysqli->real_escape_string($_POST['password']);
		
    //Ciclo if donde va a evaluar el usuario o contraseña corresponden en la base de datos
		if(isNullLogin($usuario, $password)) //si no coincide el usuario o la contraseña 
		{
			$errors[] = "Debe llenar todos los campos"; //manda un mensaje 
		}
		
		$errors[] = login($usuario, $password);	//Accede
	}
	
?>

<!DOCTYPE html>
<html lang="en">

<!-- auth-login.html  Tue, 07 Jan 2020 03:39:47 GMT -->

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Login &mdash; folder X</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="assets/modules/bootstrap-social/bootstrap-social.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.min.css">
  <link rel="stylesheet" href="assets/css/components.min.css">
</head>

<body class="layout-4">

  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <img src="http://education.folderx.com.mx/images/logo.png" alt="logo" width="150"
                class="shadow-light rounded-circle"> <!-- Logotipo-->
            </div>
            <div class="card card-primary">
              <div class="card-header">
                <h4>Login</h4>
              </div>
              <div class="card-body">
                <!--Formulario-->
                <form id="loginform" class="needs-validation" novalidate="" role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">

                  <!--Etiqueta y campo de texto para usuario o email -->
                  <div class="form-group">
                    <label for="email">Usuario o email</label>
                    <input id="usuario" type="text" class="form-control" name="usuario" value="" placeholder="usuario o email" required>   
                    <div class="invalid-feedback">
                      Revisa tu usuario o correo
                    </div>                                     
                  </div>

                  <!--Etiqueta y campo de texto para la password -->
                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="control-label">Password</label>
                      <div class="float-right">
                        <a href="pages/recupera" class="text-small">
                          ¿Has olvidado tu contraseña?
                        </a>
                      </div>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" placeholder="password" required>
                    <div class="invalid-feedback">
                      Ingresa una contraseña valida
                    </div>
                  </div>
                  <div class="form-group">
                    <button id="btn-login" type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Inicia Sesión
                    </button>
                  </div>
                </form>
                <?php echo resultBlock($errors); ?>
              </div>
            </div>
            <div class="mt-5 text-muted text-center">
              ¿No tienes una cuenta? <a href="pages/registro">Crea una</a>
            </div>
            <div class="simple-footer">
              Copyright &copy; Folder X 2021
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="assets/bundles/lib.vendor.bundle.js"></script>
  <script src="js/CodiePie.js"></script>

  <!-- JS Libraies -->

  <!-- Page Specific JS File -->

  <!-- Template JS File -->
  <script src="js/scripts.js"></script>
  <script src="js/custom.js"></script>
</body>

<!-- auth-login.html  Tue, 07 Jan 2020 03:39:47 GMT -->

</html>