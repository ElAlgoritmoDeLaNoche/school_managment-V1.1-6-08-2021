<?php 
  require '../../funcs/conexion.php'; //Funcion para incluir el archivo
	include '../../funcs/funcs.php'; //Incluir el archivo
  
  //function formatearFecha($fecha){
  //  return date('g:i a', strtotime($fecha));
  //}

  $consulta = "SELECT * FROM chat ORDER BY id DESC"; //sentencia SQL
  $ejecutar = $mysqli->query($consulta); //ejecutar la sentencia
  while($fila = $ejecutar->fetch_array()): //visualizar la informacion
?>

<div id="datos-chat">
  <span style="color: #1C62c4"><?php echo $fila['nombre'] ?></span> <!--imprime lo que tenga la variable fila:nombre -->
  <span style="color: #848484"><?php echo $fila['mensaje'] ?></span> <!--imprime lo que tenga la variable fila:mensaje -->
  <span style="float: right"><?php echo $fila['fecha'] ?></span> <!--imprime lo tenga la variable fila:fecha -->
</div>

<?php endwhile; ?>