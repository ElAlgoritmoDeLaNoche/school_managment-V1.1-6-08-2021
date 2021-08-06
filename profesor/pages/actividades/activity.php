<?php
	session_start(); //Iniciar una sesion
	require '../../funcs/conexion.php'; //Funcion para incluir el archivo
	include '../../funcs/funcs.php'; //Incluir el archivo

	if(!isset($_SESSION["id_usuario"])){ //Si no ha iniciado sesión redirecciona a index.php
		header("Location: index"); //redireccionar a index
	}
	
	$idUsuario = $_SESSION['id_usuario'];  //obtener el valor que tenga la variable id_usuario
	
	$sql = "SELECT id, nombre FROM usuarios WHERE id = '$idUsuario'"; //sentencia SQL
	$result = $mysqli->query($sql); //ejecucion de la sentencia
	$row = $result->fetch_assoc(); //visualizacion de los datos

  $NomSes = $row['nombre']; //variable

  $estudiantes = "SELECT DISTINCT * FROM asignacion_estu"; //sentencia SQL
  $query = $mysqli->query($estudiantes); //ejecucion de la sentencia
  $array = mysqli_fetch_array($query); //visualizacion de los datos

  $c = mysqli_query($mysqli, "SELECT * FROM asignacion"); //sentencia SQL

  $a = mysqli_query($mysqli, "SELECT * FROM actividades"); //sentencia SQL

  $grupo_d = $_SESSION['param']; //variable
  
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
      <!--Menu: barra lateral -->
      <div class="main-sidebar sidebar-style-3">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="panel">Folder X</a>
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
      <!--menu principal -->
      <div class="main-content">
        <section class="section">
          <div class="card">
            <div class="card-header">
              <?php foreach($query as $grupos) {
                $nivel = $grupos['nivel']; // creacion de una variable
                $grupo = $grupos['grupo_estu']; //creacion de una variable
                $carpeta = $nivel.$grupo; //creacion de una variable
              ?>
              <?php if($carpeta == $grupo_d): ?> <!--si lo que tenga la variable carpeta es igual a lo que tenga la variable grupo_d -->
              <h4>Actividades para el grupo <?php echo $grupo; ?></h4> <!--imprime lo que tenga la varible grupo -->
              <?php elseif($grupo == ""): ?> <!--si  y de lo contrario lo que tenga la variable grupo es igual a "" -->
              <h3>No tienes actividades asignadas</h3>
              <?php endif; ?>
              <?php } ?>
            </div>
            <div class="card-body">
              <form action="add" method="post">
                <div class="row">
                  <div class="col-12">
                    <div class="form-group">
                      <label>Agrega el titulo de la actividad</label>
                      <input type="text" class="form-control" placeholder="Agrega el titulo de la activudad"
                        name="titulo">
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group">
                      <label>Ingresa la descripción de la actividad</label>
                      <textarea class="form-control" placeholder="Ingresa la descripción de la actividad"
                        name="descripcion"></textarea>
                    </div>
                  </div>
                  <input type="hidden" class="form-control" placeholder="Agrega el titulo de la activudad" name="nivel"
                    value="<?php echo $grupo_d ?>"> <!--imprime lo que tenga la variable grupo_d -->
                  <div class="col-12">
                    <label>Selecciona la clase</label>
                    <div class="form-group">
                      
                      <select class="form-control" name="materia">
                        <?php foreach($query as $grupos) {
                          $nivel = $grupos['nivel']; //creacion de una varible
                          $grupo = $grupos['grupo']; //creacion de una variable
                          $carpeta = $nivel.$grupo; //creacion de una variable
                        ?>
                          <?php if($carpeta == $grupo_d): ?> <!--si lo que tenga la variable carpeta es igual a lo que tenga la variable grupo_d -->
                            <?php 
                              while($clases = mysqli_fetch_array($c)){ //muestra los datos que tenga la variable c
                            ?>
                              <?php  
                                $clase = $clases['clase']; //creacion de una variable
                                $grupo_as = $clases['grupo']; //creacion de una variable
                              ?>
                              <?php if($grupo == $grupo_as): ?> <!--si lo que tenga la variable grupo es igual a lo que tenga la variable grupo_as -->
                              <option value="<?php echo $clases['clase'] ?>"> <!--imprime lo que tenga la variable clases -->
                                  <?php echo $clase ?> <!--imprime lo que tenga la variable clase -->
                              </option>
                              <?php endif ?>
                            <?php } ?>
                          <?php endif; ?>
                        <?php }?>
                      </select>
                    </div>
                    
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label>Fecha Inicial</label>
                      <input type="text" class="form-control datetimepicker" name="inicio">
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label>Fecha de entrega</label>
                      <input type="text" class="form-control datetimepicker" name="final">
                    </div>
                  </div>
                </div>
                <button type="submit" class="btn btn-success">Agregar actividad</button>
              </form>
            </div>
          </div>
          <div class="card">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Tabla de actividades</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped v_center">
                        <thead>
                          <tr>
                            <th class="text-center">
                              #
                            </th>
                            <th>Titulo</th>
                            <th>Descripción</th>
                            <th>Matería</th>
                            <th>Fecha de inicio</th>
                            <th>Fecha de entrega</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php 
                          while($actividades = mysqli_fetch_array($a)){ //visualizar lo que tenga la variable actividades
                            $id = $actividades['id']; //creacion de una variable
                            $titulo = $actividades['titulo']; //creacion de una variable
                            $materia = $actividades['materia']; //creacion de una variable
                            $descripcion = $actividades['descripcion']; //creacion de una variable
                            $nivel = $actividades['nivel']; //creacion de una variable
                            $inicio = $actividades['inicio']; //creacion de una variable
                            $final = $actividades['final']; //creacion de una variable
                        ?>
                          <?php if($grupo_d == $nivel): ?> <!--si lo que tenga la variable grupo_d es igual a lo que tenga la variable nivel -->
                          <tr>
                            <td>
                              <p ><?php echo $id ?></p> <!--imprime lo que tenga la variable id -->
                            </td>
                            <td>
                              <p><?php echo $titulo ?></p> <!--imprime lo que tenga la variable titulo -->
                            </td>
                            <td class="align-large" style="padding: 0px;">
                              <p><?php echo $descripcion ?></p> <!--imprime lo que tenga la variable descripcion -->
                            </td>
                            <td>
                            <p><?php echo $materia ?></p> <!-- imprime lo que tenga la variable materia-->
                            </td>
                            <td>
                              <p><?php echo $inicio ?></p> <!-- imprime lo que  tenga la variable inicio-->
                            </td>
                            <td>
                              <p><?php echo $final ?></p><!-- imprime lo que tenga la variable final-->
                            </td>
                          </tr>
                          <?php endif ?>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
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