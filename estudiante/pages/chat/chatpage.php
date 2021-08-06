<?php
	session_start();  //Iniciar una sesion
  require '../../funcs/conexion.php';  //Funcion para incluir el archivo
	include '../../funcs/funcs.php';  //Incluir el archivo
	
	if(!isset($_SESSION["id_usuario"])){ //Si no ha iniciado sesión redirecciona a index.php
		header("Location: index");
	}
	
	$idUsuario = $_SESSION['id_usuario']; //obtiene el valor que tenga la variable id_usuario
	
	$sql = "SELECT id, nombre FROM usuarios WHERE id = '$idUsuario'"; //sentencia SQL
	$result = $mysqli->query($sql); //ejecutar la sentencia
	$row = $result->fetch_assoc(); //visualizar la informacion 

  $NomSes = $row['nombre']; //varible

  $estudiantes = "SELECT DISTINCT usuarios.id, usuarios.id_tipo, usuarios.nombre, usuarios.correo, asignacion.id_tipo, asignacion.grupo, asignacion_estu.grupo_estu, asignacion.nivel FROM `usuarios` INNER JOIN asignacion ON usuarios.id_tipo = usuarios.id_tipo INNER JOIN asignacion_estu ON asignacion.grupo = asignacion_estu.grupo_estu WHERE nom_prof = '$NomSes' AND usuarios.id_tipo = 4"; //sentencia SQL
  $query = $mysqli->query($estudiantes); //ejecutar la sentencia
  $array = mysqli_fetch_array($query); //visualizar la informacion 

  $grupo_d = $_SESSION['param']; //varible

  // Get data to display on index page
  $chat = "SELECT * FROM chat";
  $queryb = mysqli_query($mysqli, $chat);

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
  <link rel="stylesheet" href="css/estilos.css">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>

  
  <script>
    function ajax(){
      var req = new XMLHttpRequest();
      req.onreadystatechange = function(){
        if (req.readyState == 4 && req.status == 200) {
          document.getElementById('chat').innerHTML = req.responseText;
        }
      }
      req.open('GET', 'chat.php', true);
      req.send();
    }

    // Linea que se refrescque la pagina cada segundo
    setInterval(() => {
      ajax();
    }, 1000);

  </script>


</head>

<body class="layout-4" onLoad="ajax();">
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
      <!--menu: barra lateral -->
      <div class="main-sidebar sidebar-style-3">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="panel">Folder X</a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li>
              <a class="nav-link" href="../panel">
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
                $nivel = $grupos['nivel']; //variable
                $grupo = $grupos['grupo_estu']; //variable
                $carpeta = $nivel.$grupo; //variable
              ?>
              <?php if($carpeta == $grupo_d): ?><!--si lo que tenga la variable carpeta es igual a lo que tenga la variable grupo_d -->
              <h4>Chat grupo <?php echo $grupo; ?></h4><!--imprime lo que tenga la variable grupo -->
              <?php elseif($grupo == ""): ?><!--de lo contrario y si lo que tenga la variable grupo es igual a "" -->
              <h3>No tienes actividades asignadas</h3>
              <?php endif; ?>
              <?php } ?>
            </div>
            <div class="card-body">
              <div id="caja-chat">
              <?php foreach($queryb as $q){ ?>
                <?php 
                  $nivel = $q['nivel'];  //variable
              ?>
                <?php if($grupo_d == $nivel): ?><!--si lo que tenga la variable grupo_d es igual a lo que tenga la variable nivel -->
                  <div id="chat"></div>
                <?php endif; ?>
              <?php }?>
              </div>
              <br>
              <!--formulario -->
              <form action="chatpage.php?chat=<?php echo $grupo_d; ?>" method="post">
                <div class="row">
                  <div class="col-9">
                    <div class="form-group">
                      <textarea name="mensaje" placeholder="Ingresa un mensaje aquí" class="form-control"></textarea>
                    </div>
                  </div>
                  <div class="col-3">
                  <button class="btn btn-primary" type="submit" name="enviar" style="margin-top: 20px">Enviar</button>
                  </div>
                </div>
              </form>
              <?php 
                if(isset($_POST['enviar'])){

                  $NomSes = $row['nombre']; //variable
                  $mensaje = $_POST['mensaje']; //variable
                  $grupo_d = $_SESSION['param']; //variable

                  $consulta = "INSERT INTO chat (nombre, mensaje, nivel) VALUES ('$NomSes', '$mensaje','$grupo_d')"; //sentencia SQL
                  $ejecutar = $mysqli->query($consulta);//ejecutar la sentencia

                  if ($ejecutar) {//si lo que tenga la variable ejecutar
                    echo "<embed loop='false' src='beep.mp3' hidden='true' autoplay='true'> "; //manda un mensaje
                  }

                }
              ?>
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