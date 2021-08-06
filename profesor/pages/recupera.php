<?php
	
	require '../funcs/conexion.php'; //Funcion para incluir el archivo
	include '../funcs/funcs.php'; //incluir el archivo
	
	session_start(); //Iniciar una sesion
	
	//if(isset($_SESSION["id_usuario"])){
	//	header("Location: welcome.php");
	//}
	
	$errors = array(); //array
	
	if(!empty($_POST))
	{
    //inyeccion SQL
		$email = $mysqli->real_escape_string($_POST['email']);
		
    //si diferente al isEmail obteniendo la variable
		if(!isEmail($email))
		{
			$errors[] = "Debe ingresar un correo electronico valido"; // manda mensaje
		}
		
    //si emailExiste obteniendo la variable
		if(emailExiste($email))
		{			
			$user_id = getValor('id', 'correo', $email); //variable
			$nombre = getValor('nombre', 'correo', $email); //variable
			
			$token = generaTokenPass($user_id); //variable
			
			$url = 'http://'.$_SERVER["SERVER_NAME"].'/admin/pages/cambia_pass.php?user_id='.$user_id.'&token='.$token; //variable
			
			$asunto = 'Recuperar Password - Escuela Folder X';
			$cuerpo = "Hola $nombre: <br /><br />Se ha solicitado un reinicio de contrase&ntilde;a. <br/><br/>Para restaurar la contrase&ntilde;a, visita la siguiente direcci&oacute;n: <a href='$url'>$url</a>"; //variable
			
      //si enviarEmail obtiene varias variables
			if(enviarEmail($email, $nombre, $asunto, $cuerpo)){
				echo "Hemos enviado un correo electronico a las direcion $email para restablecer tu password.<br />";//mensaje
				echo "<a href='../index' >Iniciar Sesion</a>";//mensaje
				exit;
			}
			} else { //de lo contrario
			$errors[] = "La direccion de correo electronico no existe"; //manda mensaje
		}
	}
	
?>

<!DOCTYPE html>
<html lang="en">

<!-- auth-forgot-password.html  Tue, 07 Jan 2020 03:39:47 GMT -->

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Has olvidado tu contraseña &mdash; Folder X</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="../assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->

  <!-- Template CSS -->
  <link rel="stylesheet" href="../assets/css/style.min.css">
  <link rel="stylesheet" href="../assets/css/components.min.css">
</head>

<body class="layout-4">

  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <img src="http://education.folderx.com.mx/images/logo.png" alt="logo" width="150"
                class="shadow-light rounded-circle">
            </div>
            <div class="card card-primary">
              <div class="card-header">
                <h4>Has olvidado tu contraseña</h4>
              </div>
              <div class="card-body">
                <p class="text-muted">Le enviaremos un enlace para restablecer su contraseña.</p>
                <form id="loginform" class="form-horizontal" role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" placeholder="email" required>  
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4" id="btn-login">
                      Has olvidado tu contraseña
                    </button>
                  </div>
                </form>
              </div>
            </div>
            <div class="simple-footer">
              Copyright &copy; Folder X
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="../assets/bundles/lib.vendor.bundle.js"></script>
  <script src="../js/CodiePie.js"></script>

  <!-- JS Libraies -->

  <!-- Page Specific JS File -->

  <!-- Template JS File -->
  <script src="../js/scripts.js"></script>
  <script src="../js/custom.js"></script>
</body>

<!-- auth-forgot-password.html  Tue, 07 Jan 2020 03:39:47 GMT -->

</html>