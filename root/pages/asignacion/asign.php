<?php
	session_start(); //Iniciar una sesion
	require '../../funcs/conexion.php';//Funcion para incluir el archivo
	require '../../funcs/funcs.php';//Funcion para incluir el archivo
  include_once '../../includes/header.php';//incluir el archivo
	
	if(!isset($_SESSION["id_usuario"])){ //Si no ha iniciado sesión redirecciona a index.php
		header("Location: index");
	}
	
	$idUsuario = $_SESSION['id_usuario']; //se obtiene lo que tenga la variable id_usuario
	
	$sql = "SELECT id, nombre FROM usuarios WHERE id = '$idUsuario'"; //sentencia SQL
	$result = $mysqli->query($sql); //se ejecuta la sentencia
	
	$row = $result->fetch_assoc(); //visualizan los datos

?>

<?php 
  $usuario = mysqli_query($mysqli, "SELECT * FROM usuarios WHERE id_tipo = 3"); //sentencia SQL
  $n = mysqli_query($mysqli, "SELECT * FROM niveles"); //sentencia SQL
  $c = mysqli_query($mysqli, "SELECT * FROM clases"); //sentencia SQL
  $g = mysqli_query($mysqli, "SELECT * FROM grupos"); //sentencia SQL
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
              <a class="nav-link" href="../admin/admin">
                <i class="fas fa-pencil-ruler"></i>
                <span style="margin-left: 10px">Alta servicios academicos</span>
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
                <h4>Asignar materias a profesores</h4>
              </div>
              <div class="card-body">
                <form action="add" method="post">

                  <div class="section-title mt-0">Selecciona el profesor</div>
                  <div class="form-group">
                    <select class="form-control" name="profesor">
                      <?php 
                        while($profesores = mysqli_fetch_array($usuario)){ //mostrar todos los profesores
                      ?>
                        <option value="<?php echo $profesores['nombre'] ?>"> <!--imprimir a lo que tenga la variable profesores:nombre -->
                          <?php echo $profesores['nombre'] ?><!--imprimir la variable profesores -->
                        </option>
                      <?php } ?>
                    </select>
                  </div>
                  
                  <div class="section-title mt-0">Selecciona el nivel</div>
                  <div class="form-group">
                    <select class="form-control" name="nivel">
                      <?php 
                        while($niveles = mysqli_fetch_array($n)){ //mostrar todos los niveles
                      ?>
                        <option value="<?php echo $niveles['nivel'] ?>"><!--imprimir a lo que tenga la variable niveles:nivel -->
                          <?php echo $niveles['nivel'] ?> <!--imprimir la variable niveles -->
                        </option>
                      <?php } ?>
                    </select>
                  </div>

                  <div class="section-title mt-0">Selecciona el grupo</div> 
                  <div class="form-group">
                    <select class="form-control" name="grupo">
                      <?php 
                        while($grupos = mysqli_fetch_array($g)){ //mostrar todos los grupos
                      ?>
                        <option value="<?php echo $grupos['grupo'] ?>"><!--imprimir a lo que tenga la variable grupos:grupo -->
                          <?php echo $grupos['grupo'] ?> <!--imprimir la variable grupos -->
                        </option>
                      <?php } ?>
                    </select>
                  </div>
                  
                  <div class="section-title mt-0">Selecciona la clase</div>
                  <div class="form-group">
                    <select class="form-control" name="clase">
                      <?php 
                        while($clases = mysqli_fetch_array($c)){ //mostrar todas las clases 
                      ?>
                        <option  value="<?php echo $clases['clase'] ?>"><!--imprimir lo que tenga la variable clases:clase -->
                          <?php echo $clases['clase'] ?><!--imprimir la variable clases -->
                        </option>
                      <?php } ?>
                    </select>
                  </div>

                  <button type="submit" class="btn btn-success">Subir asignación</button>
                </form>
              </div>
            </div>
          </div>
        </section>
      </div>

<?php 
  include_once '../../includes/footer.php'; //incluir el archivo
?> 