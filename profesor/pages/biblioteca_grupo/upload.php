<?php
	session_start();  //Iniciar una sesion
	require '../../funcs/conexion.php';  //Funcion para incluir el archivo
	require '../../funcs/funcs.php';  //Funcion para incluir el archivo
	
	if(!isset($_SESSION["id_usuario"])){ //Si no ha iniciado sesión redirecciona a index.php
		header("Location: index");
	}
	
	$idUsuario = $_SESSION['id_usuario']; //obtiene el valor que tenga la variable id_usuario

	
	$sql = "SELECT id, nombre FROM usuarios WHERE id = '$idUsuario'"; //sentencia SQL
	$result = $mysqli->query($sql); //ejecutar la sentencia
	$row = $result->fetch_assoc(); //visualizar la informacion

  $NomSes = $row['nombre']; //variable

  $grupo_d = $_SESSION['param']; //variable

  $profesor = "SELECT DISTINCT * FROM asignacion_estu"; //sentencia SQL
  $query = $mysqli->query($profesor); //ejecutar la sentencia
  $array = mysqli_fetch_array($query); //visualizar la informacion

  

?>

<!DOCTYPE html>
<html lang="en">

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
            <!--submenu-->
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
            <a href="../panel">Folder X</a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li>
              <a class="nav-link" href="../panel1">
                <i class="fas fa-fire"></i>
                <span>Dashboard</span>
              </a>
            </li>
          </ul>
        </aside>
      </div>

      <!-- menu central-->
      <div class="main-content">
        <section class="section">
          <div class="col-12 col-sm-12 col-lg-12">
            <div class="card">
              <div class="card-header">
                <?php 
                  foreach($query as $grupos) { 
                    $nivel = $grupos['nivel']; //variable
                    $grupo = $grupos['grupo_estu']; //variable
                    $carpeta = $nivel.$grupo;  //variable
                ?>
                  <?php if($carpeta == $grupo_d): ?> <!--si lo que tenga la variable carpeta es igual a lo que tenga la variable grupo_d -->
                    <h4>Biblioteca del grupo <?php echo $grupo; ?> ¡NO AGREGAR CARACTER "Ñ" EN EL DOCUMENTO A CARGAR! </h4> <!--imprime lo que tenga la variable grupo -->
                  <?php endif; ?>
                  <?php 
                    if (isset($_POST['submit'])) {
                      if(is_uploaded_file($_FILES['fichero']['tmp_name'])){
                        //creamos las variables para subir a la base de datos
                        $ruta = "../../../$grupo_d/";
                        $nombreFinal = trim($_FILES['fichero']['name']); //Eliminamos los espacios en blanco
                        $nombreFinal = preg_replace("[^A-Za-z0-9]", "", strtolower($nombreFinal)); //Sustituye una expansión regular
                        $upload = $ruta . $nombreFinal;
                        
                        if (move_uploaded_file($_FILES['fichero']['tmp_name'], $upload)) {
                  
                          $nombre  = $_POST["nombre"]; //variable
                          $description  = $_POST["description"];  //variable
                          $final = $_FILES['fichero']['type']; //variable
                          $tamaño = $_FILES['fichero']['size']; //variable
                  
                          $query = "INSERT INTO biblioteca_grupo (nombre, descripcion, grupo_estu, ruta, tipo, size) 
                          VALUES ('$nombre', '$description', '$grupo_d', '".$nombreFinal."','".$final."','".$tamaño."')";  //sentencia SQL
                          
                          mysqli_query($mysqli, $query) or die(mysql_error()); //acceder a la base de datos y ejecutar la sentencia
                          echo "El archivo '".$nombre."' se ha subido con éxito <br>";    //mensaje
                        }
                      }
                    }
                  ?>
                  
                <?php } ?>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-12 col-sm-12 col-md-12">
                    <div class="tab-content no-padding" id="myTab2Content">
                      <div class="tab-pane fade show active" id="home4" role="tabpanel" aria-labelledby="home-tab4">
                      <div class="card-body">
                          <div class="table-responsive">
                            <div class="col-12 col-md-12 col-lg-12">
                              <div class="card">
                                <form 
                                  action="<?php echo $_SERVER['PHP_SELF'] ?>"
                                  method="post" 
                                  enctype="multipart/form-data"
                                >
                                  <div class="card-header">
                                    <h4>Agrega cualquier tipo de archivo a la biblioteca</h4>
                                  </div>
                                  <div class="card-body">
                                    <div class="form-group">
                                      <label>Nombre</label>
                                      <input 
                                        type="text" 
                                        class="form-control is-valid" 
                                        placeholder="Cambia este nombre" 
                                        required=""
                                        name="nombre"
                                        size="70"
                                        maxlength="70"
                                      >
                                      <div class="valid-feedback">Nombre!</div>
                                    </div>
                                    <div class="form-group">
                                      <label>Descripción</label>
                                      <input 
                                        type="text" 
                                        class="form-control is-valid" 
                                        required="" 
                                        placeholder="descripción"
                                        name="description"
                                        size="100"
                                        maxlength="250"
                                      >
                                      <div class="valid-feedback">
                                        Agrega una descripción.
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label>Selecciona un archivo</label>
                                      <input 
                                        type="file" 
                                        class="form-control is-valid" 
                                        required=""
                                        name="fichero"
                                      >
                                      <div class="valid-feedback">
                                        Subir algún archivo.
                                      </div>
                                    </div>
                                  </div>
                                  </div>
                                    <div class="card-footer text-right">
                                      <input class="btn btn-primary" name="submit" type="submit" value="SUBIR ARCHIVO">   
                                    </div>
                                </form>
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
  
  <!-- Eliminar usuario -->
  <script src="../../js/confirm.js"></script>
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