<?php
	session_start(); //Iniciar una sesion
  require '../../funcs/conexion.php'; //Funcion para incluir el archivo
	include '../../funcs/funcs.php';  //Incluir el archivo
	
	if(!isset($_SESSION["id_usuario"])){ //Si no ha iniciado sesión redirecciona a index.php
		header("Location: index");
	}
	
	$idUsuario = $_SESSION['id_usuario']; //obtiene el valor que tenga la variable id_usuario
	
	$sql = "SELECT id, nombre FROM usuarios WHERE id = '$idUsuario'"; //sentencia SQL
	$result = $mysqli->query($sql); //ejecutar la sentencia
	$row = $result->fetch_assoc(); //visualizar la informacion 

  $NomSes = $row['nombre']; //variable

  $estudiantes = "SELECT DISTINCT * FROM asignacion_estu"; //sentencia SQL
  $query = $mysqli->query($estudiantes); //ejecutar la sentencia
  $array = mysqli_fetch_array($query); //visualizar la informacion

  $grupo_d = $_SESSION['param']; //variable

  // Get data to display on index page
  $blog = "SELECT * FROM blog"; //sentencia SQL
  $queryb = mysqli_query($mysqli, $blog); //acceder a la base de datos y ejecuta la sentencia

  $_SESSION['validacion'] = $grupo_d; //variable

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
              <a href='logout' class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
              </a>
            </div>
          </li>
        </ul>
      </nav>

      <!-- Start main left sidebar menu -->
       <!-- menu: barra lateral  -->
      <div class="main-sidebar sidebar-style-3">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="../panel1">Folder X</a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li>
              <a class="nav-link" href="../panel1">
                <i class="fas fa-fire"></i>
                <span style="margin-left: 10px">Dashboard</span>
              </a>
            </li>
          </ul>
        </aside>
      </div>

      <!-- Start app main Content -->
      <!-- menu central -->
      <div class="main-content">
        <section class="section">
          <div class="card">
            <div class="card-header">
              <?php foreach($query as $grupos) {
                $nivel = $grupos['nivel']; //variable
                $grupo = $grupos['grupo_estu']; //variable
                $carpeta = $nivel.$grupo; //variable
              ?>
              <?php if($carpeta == $grupo_d): ?> <!--si lo que tenga la variable carpeta es igual a lo que tenga la variable grupo_d -->
              <h4>Posts para el grupo <?php echo $grupo; ?></h4> <!--imprime lo que tenga la variable grupo -->
              <?php elseif($grupo == ""): ?><!--de lo contrario y si lo que tenga la variable grupo es igual a "" -->
              <h3>No tienes actividades asignadas</h3>
              <?php endif; ?>
              <?php } ?>
            </div>
            <div class="card-body">
              <!-- Display any info -->
              <?php if(isset($_REQUEST['info'])){ ?>
                <?php if($_REQUEST['info'] == "added"){?>
                <div class="alert alert-success" role="alert">
                  Post agregado
                </div> 
                <?php }?>
              <?php } ?>
              <!-- Create a new Post button -->
              <div class="text-center">
                <a href="create" class="btn btn-outline-dark">Crear nuevo post</a>
              </div>

              <!-- Display posts from database -->
              <div class="row">
                
                <?php foreach($queryb as $q){ ?>
                  <?php 
                    $nivel = $q['nivel'];  
                  ?>
                <?php if($grupo_d == $nivel): ?>
                <div class="col-12 col-lg-4 d-flex justify-content-center">
                  <div class="card text-white bg-dark mt-5" style="width: 18rem;">
                    <div class="card-body">
                      <h5 class="card-title"><?php echo $q['title'];?></h5> <!--imprime lo  que tenga la variable q -->
                      <p class="card-text"><?php echo substr($q['content'], 0, 50);?>...</p> <!--imprime lo que tenga la variable q -->
                      <!--link que redirecciona a view.php -->
                      <a href="view.php?id=<?php echo $q['id']?>" class="btn btn-light">Leer Más <span class="text-danger">&rarr;</span></a>
                    </div>
                  </div>
                </div>
                <?php endif; ?>
                <?php }?>
                
              </div>

            </div>
          </div>
        </section>
      </div>
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
  <!-- General JS Scripts -->
  <script src="../../assets/bundles/lib.vendor.bundle.js"></script>
  <script src="../../js/CodiePie.js"></script>

  <!-- JS Libraies -->
  <script src="../../assets/modules/cleave-js/dist/cleave.min.js"></script>
  <script src="../../assets/modules/cleave-js/dist/addons/cleave-phone.us.js"></script>
  <script src="../../assets/modules/jquery-pwstrength/jquery.pwstrength.min.js"></script>
  <script src="../../assets/modules/bootstrap-daterangepicker/daterangepicker.js"></script>
  <script src="../../assets/modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
  <script src="../../assets/modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
  <script src="../../assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
  <script src="../../assets/modules/select2/dist/js/select2.full.min.js"></script>
  <script src="../../assets/modules/jquery-selectric/jquery.selectric.min.js"></script>

  <!-- Page Specific JS File -->
  <script src="../../js/page/forms-advanced-forms.js"></script>

  <!-- Template JS File -->
  <script src="../../js/scripts.js"></script>
  <script src="../../js/custom.js"></script>
</body>

</html>