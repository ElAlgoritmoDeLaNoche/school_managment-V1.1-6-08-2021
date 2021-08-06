<?php
	
	require 'funcs/conexion.php'; //Funcion para incluir el archivo
	require 'funcs/funcs.php'; //Funcion para incluir el archivo
	
	$errors = array(); //array
	
	if(!empty($_POST))
	{
    //inyeccion SQL
		$nombre = $mysqli->real_escape_string($_POST['nombre']);	
		$usuario = $mysqli->real_escape_string($_POST['usuario']);	
		$password = $mysqli->real_escape_string($_POST['password']);	
		$con_password = $mysqli->real_escape_string($_POST['con_password']);	
		$email = $mysqli->real_escape_string($_POST['email']);	
		$captcha = $mysqli->real_escape_string($_POST['g-recaptcha-response']);
		
		$activo = 0; //variable
		$tipo_usuario = 2; //variable
		$secret = '6LeYKIgaAAAAAMS_MLX-6uhEK4emgOSloXDxIgzl'; //variable
		
		if(!$captcha){ //si diferente al valor de la variable captcha
			$errors[] = "Por favor verifica el captcha"; //manda mensaje
		}
		
		if(isNull($nombre, $usuario, $password, $con_password, $email)) //si isNull obtiene variables
		{
			$errors[] = "Debe llenar todos los campos"; //manda mensaje
		}
		
		if(!isEmail($email))
		{//si diferente a isEmail obtiene lo que tiene la variable email
			$errors[] = "Dirección de correo inválida"; //manda mensaje
		}
		
		if(!validaPassword($password, $con_password)) //si diferente a validaPassword obtiene lo que tienen las variables password y con_password
		{
			$errors[] = "Las contraseñas no coinciden"; //manda mensaje
		}
		
		if(usuarioExiste($usuario)) //si usuarioexiste obtiene lo que tiene la variable usuario
		{
			$errors[] = "El nombre de usuario $usuario ya existe"; //manda mensaje
		}
		
		if(emailExiste($email))  //si emailExiste obtiene lo que tiene la variable email
		{
			$errors[] = "El correo electronico $email ya existe"; //manda mensaje
		}
		
		if(count($errors) == 0) //si al contar los errors son igual a 0
		{
			$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha"); //variable
			
			$arr = json_decode($response, TRUE); //variable
			
			if($arr['success']) //si el valor de la variable arr 
			{
				
				$pass_hash = hashPassword($password); //variable
				$token = generateToken(); //variable
				
				$registro = registraUsuario($usuario, $pass_hash, $nombre, $email, $activo, $token, $tipo_usuario); //variable
		
				if($registro > 0 ) //si el valor de la variable registro es mayor a 0
				{
					
					$url = 'http://'.$_SERVER["SERVER_NAME"].'/school_managment/root/pages/activar.php?id='.$registro.'&val='.$token; //variable
					
					$asunto = 'Activa Tu Cuenta'; //variable
					$cuerpo = "Estimado $nombre: <br /><br />Para continuar con el proceso de registro, es indispensable de click en la siguiente liga <a href='$url'>Activar Cuenta</a>"; //variable
					
					if(enviarEmail($email, $nombre, $asunto, $cuerpo)){ //si enviarEmail recibe variables
						
						echo "Para terminar el proceso de registro siga las instrucciones que le hemos enviado la direccion de correo electronico: $email"; //mensaje
						
						echo "<br><a href='index' >Iniciar Sesion</a>"; //mensaje
						exit;
						
						} else { //de lo contrario
						$erros[] = "Error al enviar Email"; //manda mensaje
					}
					
					} else { //de lo contrario
					$errors[] = "Error al Registrar"; //manda mensaje
				}
				
				} else {//de lo contrario
				$errors[] = 'Error al comprobar Captcha'; //manda mensaje
			}
			
		}
		
	}
	
?>

<!DOCTYPE html>
<html lang="en">

<!-- auth-register.html  Tue, 07 Jan 2020 03:39:47 GMT -->

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Register &mdash; Folder X</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="assets/modules/jquery-selectric/selectric.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.min.css">
  <link rel="stylesheet" href="assets/css/components.min.css">
  
  <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body class="layout-4">

  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
            <div class="login-brand">
              <img src="http://education.folderx.com.mx/images/logo.png" alt="logo" width="150"
                class="shadow-light rounded-circle">
            </div>
            <div class="card card-primary">
              <div class="card-header">
                <h4>Registro</h4>
              </div>
              <div class="card-body">
                <form id="signupform" class="form-horizontal" role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">

                  <div class="row">
                    <div class="form-group col-6">
                      <label for="nombre">Nombre Completo</label>
                      <input id="frist_name" type="text" class="form-control" name="nombre" autofocus value="<?php if(isset($nombre)) echo $nombre; ?>" required>
                    </div>


                    <div class="form-group col-6">
                      <label for="usuario">Usuario</label>
                      <input id="last_name" type="text" class="form-control" name="usuario" placeholder="Usuario" value="<?php if(isset($usuario)) echo $usuario; ?>" required>
                    </div>

                  </div>

                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" placeholder="Email" value="<?php if(isset($email)) echo $email; ?>" required>
                    <div class="invalid-feedback">
                    </div>
                  </div>

                  <div class="row">

                    <div class="form-group col-6">
                      <label for="password" class="d-block">Password</label>
                      <input id="password" type="password" class="form-control pwstrength" data-indicator="pwindicator"
                        name="password" placeholder="Password" required>
                      <div id="pwindicator" class="pwindicator">
                        <div class="bar"></div>
                        <div class="label"></div>
                      </div>
                    </div>

                    <div class="form-group col-6">
                      <label for="con_password" class="col-md-9 control-label">Confirmar Password</label>
                      <input type="password" class="form-control" name="con_password" placeholder="Confirmar Password" required>
                    </div>

                  </div>

                  <div class="form-group">
                    <label for="captcha" class="col-12 control-label"></label>
                    <div class="g-recaptcha col-12" data-sitekey="6LeYKIgaAAAAAKuO5tnedpvmkklXts0CibhYx82_"></div>
                  </div>

                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="agree" class="custom-control-input" id="agree">
                      <label class="custom-control-label" for="agree">Estoy de acuerdo con los términos y condiciones</label>
                    </div>
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" id="btn-signup">Registrar</button>
                  </div>

                </form>
                <?php echo resultBlock($errors); ?>
              </div>
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
  <script src="assets/modules/jquery-pwstrength/jquery.pwstrength.min.js"></script>
  <script src="assets/modules/jquery-selectric/jquery.selectric.min.js"></script>

  <!-- Page Specific JS File -->
  <script src="js/page/auth-register.js"></script>

  <!-- Template JS File -->
  <script src="js/scripts.js"></script>
  <script src="js/custom.js"></script>
</body>

<!-- auth-register.html  Tue, 07 Jan 2020 03:39:48 GMT -->

</html>

