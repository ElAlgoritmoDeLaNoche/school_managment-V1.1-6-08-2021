<?php
	session_start();  //Iniciar una sesion
	require '../../funcs/conexion.php'; //Funcion para incluir el archivo
	require '../../funcs/funcs.php'; //Funcion para incluir el archivo
	
	if(!isset($_SESSION["id_usuario"])){ //Si no ha iniciado sesión redirecciona a index.php
		header("Location: index");
	}
	
	$idUsuario = $_SESSION['id_usuario']; //se obtiene lo que tenga la variable id_usuario
	
	$sql = "SELECT id, nombre FROM usuarios WHERE id = '$idUsuario'"; //sentencia SQL
	$result = $mysqli->query($sql);//ejecuta la sentencia SQL
	
	$row = $result->fetch_assoc(); //ver el resultado

  $errors = array(); //array
	
	if(!empty($_POST)){
    //inyeccion SQL
		$nombre = $mysqli->real_escape_string($_POST['nombre']);	
		$usuario = $mysqli->real_escape_string($_POST['usuario']);	
		$password = $mysqli->real_escape_string($_POST['password']);	
		$con_password = $mysqli->real_escape_string($_POST['con_password']);	
		$email = $mysqli->real_escape_string($_POST['email']);	
    //creamos las variables para subir a la base de datos
    $ruta = "upload/";
    $nombreFinal = trim($_FILES['fichero']['name']); //Eliminamos los espacios en blanco
    $nombreFinal = preg_replace("[^A-Za-z0-9]", "", strtolower($nombreFinal)); //Sustituye una expansión regular
    $upload = $ruta . $nombreFinal;
    //inyeccion SQL
    $nombreimg  = $mysqli->real_escape_string($_POST["nombreimg"]); 
    $final = $mysqli->real_escape_string($_FILES['fichero']['type']);
    $tamaño = $mysqli->real_escape_string($_FILES['fichero']['size']);  

		$captcha = $mysqli->real_escape_string($_POST['g-recaptcha-response']);
		
		$activo = 0; //variable
		$tipo_usuario = 4; //variable
		$secret = '6LeYKIgaAAAAAMS_MLX-6uhEK4emgOSloXDxIgzl'; //variable
		
		if(!$captcha){ //si diferente al valor de la variable captcha 
			$errors[] = "Por favor verifica el captcha"; //manda mensaje 
		}
		
		if(isNull($nombre, $usuario, $password, $con_password, $email)){ //si isNull obtiene variables
			$errors[] = "Debe llenar todos los campos"; //manda mensaje
		}
		
		if(!isEmail($email)){ //si diferente a isEmail obtiene lo que tiene la variable email
			$errors[] = "Dirección de correo inválida"; //manda mensaje
		}
		
		if(!validaPassword($password, $con_password)){ //si diferente a validaPassword obtiene lo que tienen las variables password y con_password
			$errors[] = "Las contraseñas no coinciden"; //manda mensaje
		}
		
		if(usuarioExiste($usuario)){ //si usuarioexiste obtiene lo que tiene la variable usuario
			$errors[] = "El nombre de usuario $usuario ya existe"; //manda mensaje
		}
		
		if(emailExiste($email)){ //si emailExiste obtiene lo que tiene la variable email
			$errors[] = "El correo electronico $email ya existe"; //manda mensaje
		}
		
		if(count($errors) == 0){ //si al contar los errors son igual a 0
			$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha"); //creacion de una variable
			
			$arr = json_decode($response, TRUE); //creacion de una variable
			
			if($arr['success']){ //si el valor de la variable arr 
				
				$pass_hash = hashPassword($password); //variable
				$token = generateToken(); //variable
				
				$registro = registraUsuario($usuario, $pass_hash, $nombre, $email, $activo, $token, $tipo_usuario, $nombreimg, $nombreFinal, $final, $tamaño); //variable
				
				if($registro > 0 ){ //si el valor de la variable registro es mayor a 0
					
					$url = 'http://'.$_SERVER["SERVER_NAME"].'/school_managment/root/pages/activar.php?id='.$registro.'&val='.$token; //variable
					
					$asunto = 'Activa Tu Cuenta'; //variable
					$cuerpo = "Estimado $nombre: <br /><br />Para continuar con el proceso de registro, es indispensable de click en la siguiente liga <a href='$url'>Activar Cuenta</a>"; //variable
					
					if(enviarEmail($email, $nombre, $asunto, $cuerpo)){ //si enviarEmail recibe variables
            if(is_uploaded_file($_FILES['fichero']['tmp_name'])){
        
              if (move_uploaded_file($_FILES['fichero']['tmp_name'], $upload)) {}
            }
              echo "Para terminar el proceso de registro indique al estudiante que verifique el email enviado a: $email"; //mensaje
              
              echo "<br><a href='../panel' >Regresar</a>"; //mensaje
						exit;
						
						} else { //de lo contrario
						$erros[] = "Error al enviar Email"; //manda mensaje
					}
					
					} else { //de lo contrario
					$errors[] = "Error al Registrar"; //manda mensaje
				}
				
				} else { //de lo contrario
				$errors[] = 'Error al comprobar Captcha'; //manda mensaje
			}
			
		}
		
	}

?>

<?php 
  $consultar = "SELECT * FROM usuarios WHERE id_tipo = 4"; //sentencia SQL
  $query = $mysqli->query($consultar); //ejecutar la sentencia
  $array = mysqli_fetch_array($query); //visualizar los datos
?>

<!DOCTYPE html>
<html lang="en">

<!--   Tue, 07 Jan 2020 03:33:27 GMT -->

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
  <link rel="stylesheet" href="../../assets/css/style.min.css">
  <link rel="stylesheet" href="../../assets/css/components.min.css">

  <script src='https://www.google.com/recaptcha/api.js'></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
</head>

<body class="layout-4">
  <!-- Page Loader -->
  <div class="page-loader-wrapper">
    <span class="loader"><span class="loader-inner"></span></span>
  </div>

  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>

      <!-- Start app top navbar -->
      <nav class="navbar navbar-expand-lg main-navbar">
        <div class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li>
              <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg">
                <i class="fas fa-bars"></i>
              </a>
            </li>
          </ul>
        </div>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
              <!--<img alt="image" src="assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">-->
              <div class="d-sm-none d-lg-inline-block">
                Hola, <?php echo $row['nombre']; ?> <!--Obtiene el valor de la variable nombre -->
              </div>
            </a>
            <!--submenu -->
            <div class="dropdown-menu dropdown-menu-right">
              <div class="dropdown-title">Sesión</div>
              <a href="#" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Perfil
              </a>
              <a href="#" class="dropdown-item has-icon">
                <i class="fas fa-cog"></i> Configuraciones
              </a>
              <div class="dropdown-divider"></div>
              <a href='../logout' class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
              </a>
            </div>
          </li>
        </ul>
      </nav>

      <!-- Start main left sidebar menu -->
      <!--Menu: barra lateral -->
      <div class="main-sidebar sidebar-style-3">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="../../panel">Folder X</a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li>
              <a class="nav-link" href="panel">
                <i class="fas fa-fire"></i>
                <span>Dashboard</span>
              </a>
            </li>
            <li>
              <a class="nav-link" href="credits.html">
                <i class="fas fa-pencil-ruler"></i>
                <span>Credits</span>
              </a>
            </li>
          </ul>
        </aside>
      </div>

      <div class="main-content">
        <section class="section">
          <div class="col-12 col-sm-12 col-lg-12">
            <div class="card">
              <div class="card-header">
                <h4>Estudiantes</h4>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-12 col-sm-12 col-md-4">
                    <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="home-tab4" data-toggle="tab" href="#home4" role="tab" aria-controls="home" aria-selected="true">
                          Agregar estudiante 
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="profile-tab4" data-toggle="tab" href="#profile4"
                          role="tab" aria-controls="profile" aria-selected="false">
                          Ver datos del estudiante
                        </a>
                      </li>
                    </ul>
                  </div>
                  <div class="col-12 col-sm-12 col-md-8">
                    <div class="tab-content no-padding" id="myTab2Content">
                      <div class="tab-pane fade show active" id="home4" role="tabpanel" aria-labelledby="home-tab4">
                      
                        <form id="signupform" class="form-horizontal" role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off" enctype="multipart/form-data">
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

                          
                          <div class="row">
                          
                            <div class="form-group col-6">
                              <label>Nombre</label>
                              <input 
                                type="text" 
                                class="form-control" 
                                placeholder="Cambia este nombre" 
                                required=""
                                name="nombreimg"
                                size="70"
                                maxlength="70"
                              >
                            </div>
                            <div class="form-group col-6">
                              <label>Selecciona un archivo</label>
                              <input 
                                type="file" 
                                class="form-control" 
                                required=""
                                name="fichero"
                              >
                            </div>
                          
                          </div>


                          <div class="form-group">
                            <label for="captcha" class="col-12 control-label"></label>
                            <div class="g-recaptcha col-12" data-sitekey="6LeYKIgaAAAAAKuO5tnedpvmkklXts0CibhYx82_"></div>
                          </div>

                          <div class="form-group">
                            <input type="submit" class="btn btn-primary btn-lg btn-block" id="btn-signup" value="Register estudiante">
                          </div>

                        </form>

                        <?php echo resultBlock($errors); ?>
                      </div>
                      <div class="tab-pane fade" id="profile4" role="tabpanel" aria-labelledby="profile-tab4">
                      <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                          <div class="card">
                            <div class="card-header">
                              <h4>Datos de estudiantes</h4>
                            </div>
                              <div class="card-body">
                                <div class="table-responsive">
                                  <table class="table table-bordered table-md v_center">
                                    <tbody>
                                      <tr>
                                        <th>#</th>
                                        <th>Foto</th>
                                        <th>Nombre</th>
                                        <th>Usuario</th>
                                        <th>Correo</th>
                                        <th>Acción</th>
                                      </tr>
                                      <?php 
                                      foreach ($query as $row) {
                                      ?>
                                      <tr>
                                          <td><?php echo $row['id'] ?></td> <!--imprime el valor de la variable id -->
                                          <td>
                                            <img 
                                              width="100"
                                              height="70"
                                              class="rounded-circle profile-widget-picture"
                                              src="upload/<?php echo $row['ruta'] ?>" 
                                              alt="<?php echo $row['ruta'] ?>"
                                            >
                                          </td>
                                          <td><?php echo $row['nombre'] ?></td> <!--imprime el nombre -->
                                          <td><?php echo $row['usuario'] ?></td> <!--imprime el usuario -->
                                          <td>
                                            <?php echo $row['correo'] ?> <!--imprime el correo -->
                                          </td>
                                        <td>
                                          <a href="edit" class="btn btn-secondary">
                                            Actualizar datos
                                          </a>
                                        </td>
                                      </tr>
                                      </tbody>
                                    <?php } ?>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>

      <!-- Start app Footer part -->
      <footer class="main-footer">
        <div class="footer-left">
          <div class="bullet"></div> <a href="http://folderx.com.mx" target="blank">Copyright &copy; Folder X</a>
        </div>
        <div class="footer-right">

        </div>
      </footer>
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="../../assets/bundles/lib.vendor.bundle.js"></script>
  <script src="../../js/CodiePie.js"></script>

  <!-- JS Libraies -->
  <script src="../../assets/modules/jquery.sparkline.min.js"></script>
  <script src="../../assets/modules/chart.min.js"></script>
  <script src="../../assets/modules/owlcarousel2/dist/owl.carousel.min.js"></script>
  <script src="../../assets/modules/summernote/summernote-bs4.js"></script>
  <script src="../../assets/modules/chocolat/dist/js/jquery.chocolat.min.js"></script>

  <!-- Page Specific JS File -->
  <script src="../../js/page/index.js"></script>

  <!-- Template JS File -->
  <script src="../../js/scripts.js"></script>
  <script src="../../js/custom.js"></script>
</body>

<!--   Tue, 07 Jan 2020 03:35:12 GMT -->

</html>