<?php
	session_start(); //Iniciar una sesion
	require '../../funcs/conexion.php';  //Funcion para incluir el archivo
	require '../../funcs/funcs.php';  //Funcion para incluir el archivo
  include_once '../../includes/header.php';  //incluir el archivo
	
	if(!isset($_SESSION["id_usuario"])){ //Si no ha iniciado sesión redirecciona a index.php
		header("Location: index");
	}
	
	$idUsuario = $_SESSION['id_usuario']; //obtiene el valor que tenga la variable id_usuario
	
	$sql = "SELECT id, nombre FROM usuarios WHERE id = '$idUsuario'"; //sentencia SQL
	$result = $mysqli->query($sql); //ejecuta la sentencia SQL
	
	$row = $result->fetch_assoc(); //ver el resultado

?>

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
              <a class="nav-link" href="../../panel">
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
              <a class="nav-link" href="class">
                <i class="fas fa-school"></i>
                <span style="margin-left: 10px">Agregar nivel</span>
              </a>
            </li>
            <li>
              <a class="nav-link" href="../clases/clase">
                <i class="fas fa-school"></i>
                <span style="margin-left: 10px">Agregar clase</span>
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

      <div class="main-content">
        <section class="section">
          <div class="col-12 col-sm-12 col-lg-12">
            <div class="card">
              <div class="card-header">
                <h4>Agregar Nivel</h4>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-12 col-sm-12 col-md-12">
                    <div class="tab-content no-padding" id="myTab2Content">
                      <div class="tab-pane fade show active" id="home4" role="tabpanel" aria-labelledby="home-tab4">
                          <div class="table-responsive">
                            <div class="col-12">
                              <div class="card">
                                <form action="add" method="post">
                                  <div class="card-body">
                                      <div class="form-group">
                                        <label>
                                          Ingresa el nombre del nivel corresponde (ejemplo primaria)
                                        </label>
                                        <input 
                                          type="text"
                                          class="form-control"
                                          placeholder="Ingresa el nombre del nivel corresponde (ejemplo primaria)"
                                          name="nivel"
                                        >
                                      </div>
                                    <div class="form-group">
                                      <button 
                                        name="submit"
                                        type="submit" 
                                        class="btn btn-primary btn-lg btn-block"
                                        id="btn-signup"
                                      >
                                        Registrar nivel
                                      </button>
                                    </div>
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
      </diQuiv>


<?php 
  include_once '../../includes/footer.php'; //incluir el archivo
?> 