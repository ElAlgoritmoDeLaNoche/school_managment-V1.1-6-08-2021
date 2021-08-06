<?php
	
	require '../funcs/conexion.php'; //Funcion para incluir el archivo 
	require '../funcs/funcs.php'; //Funcion para incluir el archivo 

  $id = $_GET['id']; //obtenemos el valor de la varible id
  
  $eliminar = "DELETE FROM usuarios WHERE id = '$id'"; //sentencia SQL
  $resultado = mysqli_query($mysqli, $eliminar); //Funcion para ejecutar la consulta SQL

  if($resultado){ //si el valor de la variable resultado
    echo "<script>alert('Se ha eliminado con exito'); window.location='../pages/panel'</script>";//manda una alerta y redireccion a ../pages/panel
  }else{ //de lo contrario
    echo "<script>alert('Ah ocurrido un error al eliminar'); window.history.go(-1);</script>"; //manda una alerta
  }
?>