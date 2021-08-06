<?php
	session_start(); //Iniciar una sesion
  require '../../funcs/conexion.php'; //Funcion para incluir el archivo
	include '../../funcs/funcs.php'; //Incluir el archivo
	
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

  $_SESSION['validacion']; //variable

  $validacion = $_SESSION['validacion']; //variable

  // Get data to display on index page
  $blog = "SELECT * FROM blog"; //sentencia SQL
  $queryb = mysqli_query($mysqli, $blog); //acceder a la base de datos y ejecutar la sentencia

  // Get post data based on id
  if(isset($_REQUEST['id'])){
    $id = $_REQUEST['id']; //variable
    $sqli = "SELECT * FROM blog WHERE id = $id"; //sentencia SQL
    $get = mysqli_query($mysqli, $sqli); //acceder a la base de datos y ejecutar la sentencia
  }

  // Update a post
  if(isset($_REQUEST['update'])){
    $id = $_REQUEST['id']; //variable
    $title = $_REQUEST['title']; //variable
    $content = $_REQUEST['content']; //variable

    $sqli = "UPDATE blog SET title = '$title', content = '$content' WHERE id = $id"; //sentencia SQL
    mysqli_query($mysqli, $sqli); //acceder a la base de datos y ejecutar la sentencia

    header("Location: feedback.php"); //redireccionamiento a feedback.php
    exit();
  }

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
      <!-- menu: barra lateral -->
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
      <!--menu: central -->
      <div class="main-content">
        <section class="section">
          <div class="card">
            <div class="card-header">
              <?php foreach($query as $grupos) {
                $nivel = $grupos['nivel']; //variable
                $grupo = $grupos['grupo_estu']; //variable
                $carpeta = $nivel.$grupo; //variable
              ?>
              <?php if($carpeta == $grupo_d): ?><!--si lo que tenga la variable carpeta es igual a lo que tenga la variable grupo_d -->
              <h4>Actividades para el grupo <?php echo $grupo; ?></h4> <!--imprime lo que tenga la variable grupo -->
              <?php elseif($grupo == ""): ?> <!--de lo contrario si lo que tenga la variable grupo es igual a "" -->
              <h3>No tienes actividades asignadas</h3>
              <?php endif; ?>
              <?php } ?>
            </div>
            <div class="card-body">
              <div class="container mt-5">
                <?php foreach($queryb as $q){ 
                  $titulo = $q['title']; //variable
                  $descripcion = $q['content']; //variable
                  $nivel = $q['nivel']; //variable
                ?>
                <?php if($nivel == $validacion) {?> <!--si lo que tenga la variable nivel es igual a lo que tenga la variable validacion -->
                <form method="POST">
                  <input type="text" hidden value='<?php echo $q['id']?>' name="id"> <!--imprime lo que tenga la variable q -->
                  <input type="text" placeholder="Blog Title" class="form-control my-3 bg-dark text-white text-center" name="title" value="<?php echo $titulo ?>"> <!--imprime lo que tenga la varible titulo -->
                  <textarea name="content" class="form-control my-3 bg-dark text-white" cols="30"
                    rows="10"><?php echo $descripcion ?></textarea>
                  <button class="btn btn-dark" name="update">Update</button>
                </form>
                <?php } ?>
              </div>
            <?php } ?>
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