<?php
	
	require '../funcs/conexion.php'; //Funcion para incluir el archivo 
	require '../funcs/funcs.php'; //Funcion para incluir el archivo 

  $id = $_POST['id'];//obtenemos el valor de la varible id
  //inyeccion SQL
  $nombre = $mysqli->real_escape_string($_POST['nombre']);	
  $usuario = $mysqli->real_escape_string($_POST['usuario']);	
  $email = $mysqli->real_escape_string($_POST['email']);	

  $actualizar = "UPDATE usuarios SET nombre='$nombre', usuario='$usuario', correo='$email' WHERE id='$id'"; //sentencia SQL
  $resultado = mysqli_query($mysqli, $actualizar); //Funcion para ejecutar la consulta SQL

  if($resultado){ //si el valor de la variable resultado
    echo "<script>alert('Se han actualizado los cambios correctamente'); window.location='../panel'</script>"; //manda una alerta y redireccion a ../panel
  }else{ //de lo contrario
    echo "<script>alert('Ah ocurrido un error al actualizar los datos');</script>"; //manda una alerta
  }
?>