<?php
	session_start(); //Iniciar una sesion
	require '../../funcs/conexion.php';  //Funcion para incluir el archivo
	require '../../funcs/funcs.php';  //Funcion para incluir el archivo
  include_once '../../includes/header.php'; //Incluir un archivo
	
	if(!isset($_SESSION["id_usuario"])){ //Si no ha iniciado sesión redirecciona a index.php
		header("Location: index"); //redirecciona a index
	}
	
	$idUsuario = $_SESSION['id_usuario']; //obtiene el valor que tenga la variable id_usuario
	
	$sql = "SELECT id, nombre FROM usuarios WHERE id = '$idUsuario'"; //sentencia SQL
	$result = $mysqli->query($sql); //ejecuta la sentencia SQL
	
	$row = $result->fetch_assoc(); //ver el resultado 

  $errors = array(); //array
	
	if(!empty($_POST)){
    //inyeccion SQL
		$nombre = $mysqli->real_escape_string($_POST['nombre']);	
		$usuario = $mysqli->real_escape_string($_POST['usuario']);	
		$password = $mysqli->real_escape_string($_POST['password']);	
		$con_password = $mysqli->real_escape_string($_POST['con_password']);	
		$email = $mysqli->real_escape_string($_POST['email']);	
		$captcha = $mysqli->real_escape_string($_POST['g-recaptcha-response']);
		
		$activo = 0; //creacion de una variable
		$tipo_usuario = 2; //creacion de una variable
		$secret = '6LeYKIgaAAAAAMS_MLX-6uhEK4emgOSloXDxIgzl';//creacion de una variable

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
			$errors[] = "El correo electronico $email ya existe"; //manda un mensaje
		}
		
		if(count($errors) == 0){ //si al contar los errors son igual a 0
			$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha"); //creacion de una variable
			
			$arr = json_decode($response, TRUE); //creacion de una variable
			
			if($arr['success']){ //si el valor de la variable arr 
				
				$pass_hash = hashPassword($password); //variable
				$token = generateToken(); //variable
				
				$registro = registraUsuario($usuario, $pass_hash, $nombre, $email, $activo, $token, $tipo_usuario); //variable
				
				if($registro > 0 ){ //si el valor de la variable registro es mayor a 0
					
					$url = 'http://'.$_SERVER["SERVER_NAME"].'/school_managment/activar.php?id='.$registro.'&val='.$token; //variable
					
					$asunto = 'Activa Tu Cuenta'; //variable
					$cuerpo = "Estimado $nombre: <br /><br />Para continuar con el proceso de registro, es indispensable de click en la siguiente liga <a href='$url'>Activar Cuenta</a>"; //variable
					
					if(enviarEmail($email, $nombre, $asunto, $cuerpo)){ //si enviarEmail recibe variables
						
						echo "Asegurate de que el estudiante active su cuenta para ser dado de alta correctamente"; //mensaje
						
						echo "<br><a href='../../panel' >regresar</a>"; //mensaje
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

  $consultar = "SELECT * FROM usuarios WHERE id_tipo = 2"; //sentencia SQL
  $query = $mysqli->query($consultar); //ejecutar la sentencia
  $array = mysqli_fetch_array($query); //guarda los datos en una tabla virtual
?>


              <div class="d-sm-none d-lg-inline-block">
                Hola, <?php echo $row['nombre']; ?> <!--Obtiene el valor de la variable nombre -->
              </div>
            </a>
          <!--Submenu-->
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
              <a class="nav-link" href="../panel">
                <i class="fas fa-fire"></i> 
                <span style="margin-left: 10px">Dashboard</span>
              </a>
            </li>
            <li>
              <a class="nav-link" href="../niveles/nivel">
                <i class="fas fa-school"></i>
                <span style="margin-left: 10px">Agregar nivel</span>
              </a>
            </li>
            <li>
              <a class="nav-link" href="../clases/clase">
                <i class="fas fa-school"></i>
                <span style="margin-left: 10px">Agregar clases</span>
              </a>
            </li>
            <li>
              <a class="nav-link" href="../grupos/grupo">
                <i class="fas fa-school"></i>
                <span style="margin-left: 10px">Agregar grupos</span>
              </a>
            </li>
            <li>
              <a class="nav-link" href="../asignacion/asign">
                <i class="fas fa-school"></i>
                <span style="margin-left: 10px">Asignar materias</span>
              </a>
            </li>
            <li>
              <a class="nav-link" href="../biblioteca/library">
                <i class="fas fa-book-reader"></i>
                <span style="margin-left: 10px">Biblioteca General</span>
              </a>
            </li>
          </ul>
        </aside>
      </div>

      <!-- menu: central-->
      <div class="main-content">
        <section class="section">
          <div class="col-12 col-sm-12 col-lg-12">
            <div class="card">
              <div class="card-header">
                <h4>Profesores</h4>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-12 col-sm-12 col-md-4">
                    <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="home-tab4" data-toggle="tab" href="#home4" role="tab" aria-controls="home" aria-selected="true">
                          Agregar profesor 
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="profile-tab4" data-toggle="tab" href="#profile4"
                          role="tab" aria-controls="profile" aria-selected="false">
                          Ver datos de los profesores
                        </a>
                      </li>
                    </ul>
                  </div>
                  <div class="col-12 col-sm-12 col-md-8">
                    <div class="tab-content no-padding" id="myTab2Content">
                      <div class="tab-pane fade show active" id="home4" role="tabpanel" aria-labelledby="home-tab4">
                      
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
                            <button type="submit" class="btn btn-primary btn-lg btn-block" id="btn-signup">Register estudiante</button>
                          </div>

                        </form>

                        <?php echo resultBlock($errors); ?>
                      </div>
                      <div class="tab-pane fade" id="profile4" role="tabpanel" aria-labelledby="profile-tab4">
                      <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                          <div class="card">
                            <div class="card-header">
                              <h4>Datos de profesores</h4>
                            </div>
                              <div class="card-body">
                                <div class="table-responsive">
                                  <table class="table table-bordered table-md v_center">
                                    <tbody>
                                      <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Usuario</th>
                                        <th>Correo</th>
                                        <th>Acción</th>
                                      </tr>
                                      <?php 
                                      foreach ($query as $row) {
                                      ?>
                                      <tr>
                                          <td><?php echo $row['id'] ?></td> <!--Se imprime el valor de la variable id-->
                                          <td><?php echo $row['nombre'] ?></td> <!--se imprime el valor de la variable nombre -->
                                          <td><?php echo $row['usuario'] ?></td> <!--se imprime el valor de la variable usuario-->
                                          <td>
                                            <?php echo $row['correo'] ?><!--Se imprime rl valor de la variable correo -->
                                          </td>
                                        <td>
                                          <!--boton para mandar a edit -->
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

<?php 
  include_once '../../includes/footer.php'; //incluir el archivo
?>