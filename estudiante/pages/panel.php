<?php
	session_start(); //iniciar una sesion
	require '../funcs/conexion.php'; //Funcion para incluir el archivo
	include '../funcs/funcs.php'; //Incluir el archivo
	
	if(!isset($_SESSION["id_usuario"])){ //Si no ha iniciado sesión redirecciona a index.php
		header("Location: index");
	}
	 
	$idUsuario = $_SESSION['id_usuario']; //obtener lo que tenga la variable id_usuario
	
	$sql = "SELECT id, nombre FROM usuarios WHERE id = '$idUsuario'"; //sentencia SQL
	$result = $mysqli->query($sql); //ejecutar la sentencia
	$row = $result->fetch_assoc(); //visualizar la informacion 

  $NomSes = $row['nombre'];//variable

  $consultar = "SELECT * FROM asignacion_estu WHERE nom_estu = '$NomSes'"; //sentencia SQL
  $query = $mysqli->query($consultar);//ejecutar la sentencia
  $array = $query->fetch_assoc();//visualizar la informacion

  foreach($query as $grado) {}


  //foreach($query as $row1){
  //  echo $row1['nombre'];
  //  echo $row1['nivel'];
  //  echo $row1['grupo'];
  //  if ($NomSes == $row1['nombre'] ) {
  //    echo 'iguales';
  //  }
  //}

  $g = "SELECT grupo FROM asignacion";//sentencia SQL
  $q = $mysqli->query($g); //ejecutar la sentencia
  $array = mysqli_fetch_array($q);//visualizar la informacion
  
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Panel &mdash; Folder X</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="../assets/modules/bootstrap/css/bootstrap.min.css">
    <!--<link rel="stylesheet" href="../assets/modules/fontawesome/css/all.min.css">-->
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="../assets/modules/jqvmap/dist/jqvmap.min.css">
    <link rel="stylesheet" href="../assets/modules/summernote/summernote-bs4.css">
    <link rel="stylesheet" href="../assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="../assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="../assets/css/style.min.css">
    <link rel="stylesheet" href="../assets/css/components.min.css">
    <link rel="stylesheet" href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">

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
                  Hola, <?php echo $row['nombre']; ?><!--obtener lo que tenga la variable nombre -->
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
        <!--menu: barra lateral -->
        <div class="main-sidebar sidebar-style-3">
          <aside id="sidebar-wrapper">
            <div class="sidebar-brand">
              <a href="panel">Folder X</a>
            </div>
            <?php 
              include_once '../includes/menu.php'; //Incluir el archivo
            ?>
          </aside>
        </div>

        <!-- Start app main Content -->
        <div class="main-content">
          <section class="section">
          <?php
            $nivel = $grado['nivel'];//variable
            $grupo = $grado['grupo_estu']; //variable
            $carpeta = $nivel . $grupo;//variable
          ?>
            <h4 class="text-center">
              Tu grado: <?php echo $nivel; ?> <!--imprime lo que tenga la variable nivel -->
              <i class="em em-raised_hands" aria-role="presentation" aria-label="PERSON RAISING BOTH HANDS IN CELEBRATION"></i>
            </h4>
            
            <div class="flex-row d-flex justify-content-center">
              <div class="col-lg-6 col-md-6 col-sm-12">
                  <div class="card p-10">
                    <h4 class="text-center p-2">
                      Tu grupo <?php echo $grupo ?><!--imprime lo que tenga la variable grupo -->
                      <i class="em em-mortar_board" aria-role="presentation" aria-label="GRADUATION CAP"></i>
                    </h4>
                      <a href="grupo.php?grupo=<?php echo $carpeta ?>"><!--imprime lo que tenga la variable carpeta -->
                        <h6 class="p-2">Entrar al grupo</h6>
                      </a>  
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
    <script src="../assets/bundles/lib.vendor.bundle.js"></script>
    <script src="../js/CodiePie.js"></script>

    <!-- JS Libraies -->
    <script src="../assets/modules/jquery.sparkline.min.js"></script>
    <script src="../assets/modules/chart.min.js"></script>
    <script src="../assets/modules/owlcarousel2/dist/owl.carousel.min.js"></script>
    <script src="../assets/modules/summernote/summernote-bs4.js"></script>
    <script src="../assets/modules/chocolat/dist/js/jquery.chocolat.min.js"></script>

    <!-- Page Specific JS File -->
    <script src="../js/page/index.js"></script>

    <!-- Template JS File -->
    <script src="../js/scripts.js"></script>
    <script src="../js/custom.js"></script>
  </body>
</html>

