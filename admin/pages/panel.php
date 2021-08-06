<?php
	session_start();  //Iniciar una sesion
	require '../funcs/conexion.php'; //Funcion para incluir el archivo
	include '../funcs/funcs.php'; //incluir el archivo
	
	if(!isset($_SESSION["id_usuario"])){ //Si no ha iniciado sesión redirecciona a index.php
		header("Location: index");
	}
	
	$idUsuario = $_SESSION['id_usuario']; //se obtiene lo que tenga la variable id_usuario
	
	$sql = "SELECT id, nombre FROM usuarios WHERE id = '$idUsuario'"; //sentencia SQL
	$result = $mysqli->query($sql); //se ejecuta la sentencia
	
	$row = $result->fetch_assoc(); //visualizan los datos

  $profesores = "SELECT id_tipo FROM usuarios WHERE id_tipo = 3"; //sentencia SQL
  $query_run = mysqli_query($mysqli, $profesores); //se ejecuta la sentencia
  $profesor = mysqli_num_rows($query_run); //visualizan los datos

  $estudiantes = "SELECT id_tipo FROM usuarios WHERE id_tipo = 4"; //sentencia SQL
  $query_run = mysqli_query($mysqli, $estudiantes); //se ejecuta la sentencia
  $estudiante = mysqli_num_rows($query_run); //visualizan los datos

  $consultar = "SELECT * FROM usuarios WHERE id_tipo = 4"; //sentencia SQL
  $query = $mysqli->query($consultar); //se ejecuta la sentencia
  $array = mysqli_fetch_array($query); //visualizan los datos

  $consultarProf = "SELECT * FROM usuarios WHERE id_tipo = 3"; //sentencia SQL
  $queryProf = $mysqli->query($consultarProf); //se ejecuta la sentencia
  $array = mysqli_fetch_array($queryProf); //visualizan los datos

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
            <!-- submenu-->
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
       <!--Menu: barra lateral -->
      <div class="main-sidebar sidebar-style-3">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="panel">Folder X</a>
          </div>
          <?php 
            include_once '../includes/menu.php';
          ?>
        </aside>
      </div>

      <!-- Start app main Content -->
      <div class="main-content">
        <section class="section">
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
              <div class="card card-statistic-2">
                <div class="card-stats">
                  <div class="card-stats-title">Numero de estudiantes - </div>
                </div>
                <div class="card-icon shadow-primary bg-primary">
                  <i class="fas fa-archive" style="color: #f3f3f3"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total de estudiantes</h4>
                  </div>
                  <div class="card-body">
                    <?php echo $estudiante; ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
              <div class="card card-statistic-2">
                <div class="card-stats">
                  <div class="card-stats-title">Numero de profesores - </div>
                </div>
                <div class="card-icon shadow-primary bg-primary">
                  <i class="fas fa-archive" style="color: #f3f3f3"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total de Profesores</h4>
                  </div>
                  <div class="card-body">
                    <?php echo $profesor; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row row-deck">
            <div class="col-lg-4">
              
                <div class="card">
                  <div class="card-header">
                    <h4>Panel de estudiantes</h4>
                  </div>
                  <a href="estudiante/student">
                    <div class="card-body">
                      <p class="text-center" style="font-size: 60px; color: #162168">
                        <i class="fas fa-user-graduate"></i>
                      </p>
                    </div>
                  </a>
                </div>
            </div>
            <div class="col-lg-4">
              <div class="card">
                <div class="card-header">
                  <h4>Panel de profesores</h4>
                </div>
                <a href="profesor/teacher">
                  <div class="card-body">
                    <p class="text-center" style="font-size: 60px; color: #162168">
                      <i class="fas fa-chalkboard-teacher" style="font-size: 60px;"></i>
                    </p>             
                  </div>
                </a>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="card">
                <div class="card-header">
                  <h4>Panel de calificaciones</h4>
                </div>
                <div class="card-body">
                  <p class="text-center">
                    <i class="fas fa-poll" style="font-size: 60px;"></i>
                  </p>  
                </div>
              </div>
            </div>
          </div>
          <div class="row row-deck">
            <div class="col-md-6">
              <div class="card">
                <div class="card-header">
                  <h4>Ultimos estudiantes registrados</h4>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive table-invoice">
                  <table class="table table-striped">
                      <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Nombre de usuario</th>
                        <th>Correo</th>
                        <th>Acción</th>
                      </tr>
                      <?php 
                        foreach ($query as $row) {
                      ?>
                      <tr>
                        <td><?php echo $row['id'] ?></td> <!-- imprimir lo que tenga la variable id-->
                        <td><?php echo $row['nombre'] ?></td> <!--imprimir lo que tenga la variable nombre -->
                        <td><?php echo $row['usuario'] ?></td> <!--imprimir lo que tenga la variable usuario -->
                        <td> <?php echo $row['correo'] ?></td> <!--imprimir lo que tenga la variable correo-->
                        <td>
                        <a 
                          href="actualizar.php?id=<?php echo $row['id'] ?>" class="btn btn-secondary">
                          Editar
                        </a>
                        </td>
                      </tr>
                      <?php } ?>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card">
                <div class="card-header">
                  <h4>Ultimos profesores registrados</h4>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive table-invoice">
                  <table class="table table-striped">
                      <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Nombre de usuario</th>
                        <th>Correo</th>
                        <th>Acción</th>
                      </tr>
                      <?php 
                        foreach ($queryProf as $row) {
                      ?>
                      <tr>
                        <td><?php echo $row['id'] ?></td> <!-- imprimir lo que tenga la variable id-->
                        <td><?php echo $row['nombre'] ?></td> <!--imprimir lo que tenga la variable nombre -->
                        <td><?php echo $row['usuario'] ?></td>  <!--imprimir lo que tenga la variable usuario -->
                        <td> <?php echo $row['correo'] ?></td> <!--imprimir lo que tenga la variable correo-->
                        <td>
                        <a 
                          href="actualizar.php?id=<?php echo $row['id'] ?>" class="btn btn-secondary">
                          Editar
                        </a>
                        </td>
                      </tr>
                      <?php } ?>
                    </table>
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

<!--   Tue, 07 Jan 2020 03:35:12 GMT -->

</html>