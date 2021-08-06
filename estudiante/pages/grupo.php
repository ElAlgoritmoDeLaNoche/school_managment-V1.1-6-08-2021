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

  $profesor = "SELECT DISTINCT * FROM asignacion"; //sentencia SQL
  $prf = $mysqli->query($profesor);//ejecutar la sentencia
	
  $grupo_d = $_GET['grupo'];//variable
  $_SESSION['param'] = $grupo_d; //variable

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
                  Hola, <?php echo $row['nombre']; ?> <!--obtener lo que tenga la variable nombre -->
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
            <ul class="sidebar-menu">
              <li class="menu-header">Dashboard</li>
              <li>
                <a class="nav-link" href="panel">
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
          <?php 
            while($fila = $prf->fetch_array()):
            $grupo = $fila['grupo']; //variable
            $nivel = $fila['nivel']; //variable
            $nom_prof = $fila['nom_prof']; //variable
            $carpeta = $nivel.$grupo; //variable
          ?>
            <?php if($carpeta == $grupo_d): ?><!--si lo que tenga la variable carpeta es igual a lo que tenga la variable grupo_d -->
              <h3>
                Tu profesor es: 
                <small>
                  <?php echo $nom_prof ?><!--imprime lo que tenga la variable nom_prof -->
                <small>
                <i class="em em-sunglasses" aria-role="presentation" aria-label="SMILING FACE WITH SUNGLASSES"></i>
              </h3>
            <?php endif; ?>
          <?php endwhile; ?>
            <div class="row row-deck mt-4">
              <div class="col-lg-3">
                  <div class="card">
                    <div class="card-header">
                      <h4>Mis materias</h4>
                    </div>
                    <a href="materias/subjects.php?grupo=<?php echo $grupo_d ?>"><!--imprime lo que tenga la variable grupo_d -->
                      <div class="card-body">
                        <p class="text-center" style="font-size: 60px; color: #162168">
                          <i class="fas fa-cubes"></i>
                        </p>
                      </div>
                    </a>
                  </div>
              </div>
              <div class="col-lg-3">
                <div class="card">
                  <div class="card-header">
                    <h4>Material de apoyo</h4>
                  </div>
                  <a href="biblioteca_grupo/library.php?grupo=<?php echo $grupo_d; ?>"><!--imprime lo que tenga la variable grupo_d -->
                    <div class="card-body">
                      <p class="text-center" style="font-size: 60px; color: #162168">
                        <i class="fas fa-chalkboard-teacher" style="font-size: 60px;"></i>
                      </p>
                    </div>
                  </a>
                </div>
              </div>
              <div class="col-lg-3">
                <div class="card">
                  <div class="card-header">
                    <h4>Actividades</h4>
                  </div>
                  <div class="card-body">
                    <a href="actividades/activity.php?activity=<?php echo $grupo_d; ?>"><!--imprime lo que tenga la variable grupo_d -->
                      <p class="text-center" style="font-size: 60px; color: #162168">
                        <i class="fas fa-poll" style="font-size: 60px;"></i>
                      </p> 
                    </a>
                  </div>
                </div>
              </div>
              <div class="col-lg-3">
                <div class="card">
                  <div class="card-header">
                    <h4>Blog</h4>
                  </div>
                  <div class="card-body">
                    <a href="blog/feedback.php?feedback=<?php echo $grupo_d; ?>"><!--imprime lo que tenga la variable grupo_d -->
                      <p class="text-center" style="font-size: 60px; color: #162168">
                        <i class="fas fa-clipboard" style="font-size: 60px;"></i>
                      </p> 
                    </a>
                  </div>
                </div>
              </div>
              <div class="col-lg-3">
                <div class="card">
                  <div class="card-header">
                    <h4>Temario</h4>
                  </div>
                  <div class="card-body">
                    <a href="temario/temary.php?temary=<?php echo $grupo_d; ?>"><!--imprime lo que tenga la variable grupo_d -->
                      <p class="text-center" style="font-size: 60px; color: #162168">
                        <i class="fas fa-clipboard-list" style="font-size: 60px;"></i>
                      </p>
                    </a>
                  </div>
                </div>
              </div>
              <div class="col-lg-3">
                <div class="card">
                  <div class="card-header">
                    <h4>Chat</h4>
                  </div>
                  <div class="card-body">
                    <a href="chat/chatpage.php?chat=<?php echo $grupo_d; ?>"><!--imprime lo que tenga la variable grupo_d -->
                      <p class="text-center" style="font-size: 60px; color: #162168">
                        <i class="fas fa-comment-dots" style="font-size: 60px;"></i>
                      </p> 
                    </a>
                  </div>
                </div>
              </div>
              <div class="col-lg-3">
                <div class="card">
                  <div class="card-header">
                    <h4>Quiz</h4>
                  </div>
                  <div class="card-body">
                    <a href="quiz/main.php?main=<?php echo $grupo_d; ?>"><!--imprime lo que tenga la variable grupo_d -->
                      <p class="text-center" style="font-size: 60px; color: #162168">
                        <i class="fas fa-vial" style="font-size: 60px;"></i>
                      </p> 
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>

        <!-- Start app Footer part -->
        <footer class="main-footer">
          <div class="footer-left">
            <div class="bullet"></div> <a href="https://folderx.com.mx" target="blank">Copyright &copy; Folder X</a>
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

