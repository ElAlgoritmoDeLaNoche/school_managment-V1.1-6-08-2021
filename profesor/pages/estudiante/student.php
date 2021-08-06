<?php
	session_start(); //Iniciar una sesion
	require '../../funcs/conexion.php';  //Funcion para incluir el archivo
	require '../../funcs/funcs.php';  //Funcion para incluir el archivo
	
	if(!isset($_SESSION["id_usuario"])){ //Si no ha iniciado sesión redirecciona a index.php
		header("Location: index");
	}
	
	$idUsuario = $_SESSION['id_usuario'];  //obtiene el valor que tenga la variable id_usuario
	
	$sql = "SELECT id, nombre FROM usuarios WHERE id = '$idUsuario'"; //sentencia SQL
	$result = $mysqli->query($sql); //ejecutar la sentencia
	$row = $result->fetch_assoc(); //visualizar la informacion 

  $NomSes = $row['nombre']; //variable

  $estudiantes = "SELECT * FROM asignacion_estu "; //sentencia SQL
  $est = $mysqli->query($estudiantes); //ejecutar la sentencia

  $grupo_d = $_GET['grupo']; //variable

  $consulta = "SELECT * FROM asignacion_estu"; //sentencia SQL
  $ejecutar = $mysqli->query($consulta); //ejecutar la sentencia
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
      <!-- menu: barra lateral-->
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
                <span style="margin-left: 10px">Dashboard</span>
              </a>
            </li>
            <li>
              <a class="nav-link" href="../biblioteca/library">
                <i class="fas fa-school"></i>
                <span style="margin-left: 10px">Biblioteca general</span>
              </a>
            </li>
          </ul>
        </aside>
      </div>

      <!-- menu principal-->
      <div class="main-content">
        <section class="section">
          <div class="col-12 col-sm-12 col-lg-12">
            <div class="card">
              <div class="card-header" style="justify-content: space-between">           
              <?php 
                while($fila = $ejecutar->fetch_array()): 
                $g_estu = $fila['grupo_estu']; //variable
                $nivel = $fila['nivel']; //variable
                $nom_estu = $fila['nom_estu']; //variable
                $carpeta = $nivel.$g_estu; //variable
              ?>
              <?php if($carpeta == $grupo_d): ?> <!--si lo que tenga la variable carpeta es igual a lo que tenga la variable grupo_d -->
                <h4>Lista de estudiantes del grupo <?php echo $g_estu; ?></h4><!--imprime lo que tenga la variable g_estu -->
                <?php elseif($g_estu == ""): ?><!--de lo contrario y si lo que tenga la variable g_estu es igual a "" -->
                <h3>No tienes grupos asignados</h3>
                <?php endif; ?>
              <?php endwhile; ?>
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
                                  <table>
                                    <thead>
                                      <th>Nombre del alumno</th>
                                      <td>Correo</td>
                                      <th>Grupo</th>
                                    </thead>
                                    <tbody>
                                    <?php 
                                      while($fila = $est->fetch_array()):
                                      $g_estu = $fila['grupo_estu']; //variable
                                      $nivel = $fila['nivel']; //variable
                                      $nom_estu = $fila['nom_estu']; //variable
                                      $correo = $fila['correo']; //variable
                                      $carpeta = $nivel.$g_estu; //variable
                                    ?>
                                    <?php if($carpeta == $grupo_d): ?> <!--si lo que tenga la variable carpeta es igual a lo que tenga la variable grupo_d -->
                                      <tr>
                                        <td><?php echo $nom_estu ?></td><!--imprime lo que tenga la variable nom_estu -->
                                        <td><?php echo $correo ?></td><!--imprime lo que tenga la variable correo -->
                                        <td><?php echo $g_estu ?></td><!--imprime lo que tenga la variable g_estu -->
                                      </tr>
                                      <?php elseif($g_estu == ""): ?><!--de lo contrario y si lo que tenga la variable g_estu es igual a "" -->
                                      <h3>No tienes grupos asignados</h3>
                                      <?php endif; ?>
                                    <?php endwhile; ?>
                                    </tbody>
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