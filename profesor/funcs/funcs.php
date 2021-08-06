<?php
	
	//Funcion llamada isNull, la cual obtiene la longitud de los strings 
	function isNull($nombre, $user, $pass, $pass_con, $email){
		if(strlen(trim($nombre)) < 1 || strlen(trim($user)) < 1 || strlen(trim($pass)) < 1 || strlen(trim($pass_con)) < 1 || strlen(trim($email)) < 1)
		{
			return true; //retorna un true si se ejecuta el if
			} else { //de lo contrario
			return false; //retorna un false
		}		
	}
	
	//Funcion  llamada isEmail, la cual filtra los email
	function isEmail($email)
	{
		if (filter_var($email, FILTER_VALIDATE_EMAIL)){
			return true; //retorna un true si se ejecuta el if
			} else { //de lo contrario
			return false; //retorna un false
		}
	}
	
	//funcion llamada validaPassword, la cual va hacer una comparacion de string segura a nivel binario
	function validaPassword($var1, $var2)
	{
		if (strcmp($var1, $var2) !== 0){
			return false; //retorna un false si se ejecuta el if
			} else { //de lo contrario
			return true; //retorna un true si se ejecuta el else
		}
	}
	
	//Funcion llamada minMax, la cual obtiene la longitud de los strings 
	function minMax($min, $max, $valor){
		if(strlen(trim($valor)) < $min)
		{
			return true; //retorna un  true si se ejecuta el primer if
		}
		else if(strlen(trim($valor)) > $max)
		{
			return true; //retorna un true si se ejecuta el else if
		}
		else //de lo contrario
		{
			return false; //retorna un false si se ejecuta el else
		}
	}
	
	//Funcion llamada usuarioExiste, en el cual va a ver si el usuario ya existe
	function usuarioExiste($usuario)
	{
		global $mysqli; //Creacion de una variable global
		
		$stmt = $mysqli->prepare("SELECT id FROM usuarios WHERE usuario = ? LIMIT 1"); //Sentencia SQL
		$stmt->bind_param("s", $usuario); //parametro (s=string, variable)
		$stmt->execute(); //Ejecuta la sentencia
		$stmt->store_result(); //Visualizar resultado
		$num = $stmt->num_rows; //Guarda el resultado
		$stmt->close(); //Cierre de la base de datos
		
		if ($num > 0){ //si el valor de la variable num es mayor a 0
			return true; //retorna un true
			} else {// de lo contrario
			return false;//retorna false
		}
	}
	
	//Funcion llamada emailExiste, en el cual va a ver si el correo ya existe
	function emailExiste($email)
	{
		global $mysqli; //Creacion de una variable global
		
		$stmt = $mysqli->prepare("SELECT id FROM usuarios WHERE correo = ? LIMIT 1"); //Sentencia SQL
		$stmt->bind_param("s", $email); //parametro (s=string, variable)
		$stmt->execute(); //Ejecuta la sentencia
		$stmt->store_result();  //Visualizar resultado
		$num = $stmt->num_rows; //Guarda el resultado
		$stmt->close(); //Cierre de la base de datos
		
		if ($num > 0){ //si el valor de la variable num es mayor a 0
			return true; //retorna un true
			} else { //de lo contrario 
			return false;	 //retorna false
		}
	}

	//Funcion llamada generateToken, 
	function generateToken()
	{
		$gen = md5(uniqid(mt_rand(), false));	
		return $gen; //retorna lo que tenga la variable gen
	}
	
	//Funcion llamada hasPassword, en la cual va a encriptar la contraseña
	function hashPassword($password) 
	{
		$hash = password_hash($password, PASSWORD_DEFAULT);
		return $hash;  //retorna el valor que tenga hash
	}
	
	//Funcion llamada resultBlock, en la cual va a contar los errores 
	function resultBlock($errors){
		if(count($errors) > 0) //Si los errores son mayores a 0 manda una alerta
		{
			echo "<div id='error' class='alert alert-danger' role='alert'>
			<a href='#' onclick=\"showHide('error');\">[X]</a>
			<ul>";
			foreach($errors as $error)
			{
				echo "<li>".$error."</li>"; //imprime el error
			}
			echo "</ul>";
			echo "</div>";
		}
	}
	
	//Funcion llamada registraUsuario, 
	function registraUsuario($usuario, $pass_hash, $nombre, $email, $activo, $token, $tipo_usuario, $nombreimg, $nombreFinal, $final, $tamaño){
		
		global $mysqli; //Creacion de una variable global

		$stmt = $mysqli->prepare("INSERT INTO usuarios (usuario, password, nombre, correo, activacion, token, id_tipo, nombreimg, ruta, tipo, size) VALUES(?,?,?,?,?,?,?,?,?,?,?)"); //Sentencia SQL
		$stmt->bind_param('ssssisisssi', $usuario, $pass_hash, $nombre, $email, $activo, $token, $tipo_usuario, $nombreimg, $nombreFinal, $final, $tamaño); //parametro (s=string, variableS)
		
		if ($stmt->execute()){ //SI se Ejecuta la sentencia
			return $mysqli->insert_id;  //va a insertar al usuario
			} else { //de lo contrario
			return 0;	 	//de lo contrario retornara un 0
		}		
	}
	
	//Funcion llamada enviarEmail,
	function enviarEmail($email, $nombre, $asunto, $cuerpo){
		
		require_once 'PHPMailer/PHPMailerAutoload.php'; //Funcion para incluir el archivo
		
		$mail = new PHPMailer();
		$mail->isSMTP();
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'seguridad'; //Modificar
		$mail->Host = 'smtp.hostinger.mx'; //Modificar
		$mail->Port = '587'; //Modificar
		
		$mail->Username = 'account@folderx.com.mx'; //Modificar
		$mail->Password = 'oCAoVZhnE1;'; //Modificar
		
		$mail->setFrom('account@folderx.com.mx', 'Escuela Folder X'); //Modificar
		$mail->addAddress($email, $nombre);
		
		$mail->Subject = $asunto;
		$mail->Body    = $cuerpo;
		$mail->IsHTML(true);
		
		if($mail->send())
		return true;
		else
		return false;
	}
	
	//Funcion llamada validaIdToken, 
	function validaIdToken($id, $token){
		global $mysqli; //Creacion de una variable global
		
		$stmt = $mysqli->prepare("SELECT activacion FROM usuarios WHERE id = ? AND token = ? LIMIT 1"); //Sentencia SQL
		$stmt->bind_param("is", $id, $token); //parametro (s=string, variableS)
		$stmt->execute(); //se ejecuta la sentencia
		$stmt->store_result(); //visualizar el resultado
		$rows = $stmt->num_rows; //Guardar el resultado
		
		if($rows > 0) { //si el rows es mayor a 0
			$stmt->bind_result($activacion); //visualiza el resultado
			$stmt->fetch(); //array
			
			if($activacion == 1){ //si el valor de la variable activacion es igual a 1
				$msg = "La cuenta ya se activo anteriormente.";//manda un mensaje
				} else { //de lo contrario
				if(activarUsuario($id)){ //si activarUsuario checa el id
					$msg = 'Cuenta activada.';//manda un mensaje
					} else { //de lo contrario
					$msg = 'Error al Activar Cuenta';//manda un mensaje
				}
			}
			} else { //de lo contrario
			$msg = 'No existe el registro para activar.';//manda un mensaje
		}
		return $msg; //retorna el valor que tenga la varible msg
	}
	
	//Funcion llamada activarUsuario, en la cual se encarga para activar a los usuarios
	function activarUsuario($id)
	{
		global $mysqli; //Creacion de una varible global
		
		$stmt = $mysqli->prepare("UPDATE usuarios SET activacion=1 WHERE id = ?"); //sentencia SQL
		$stmt->bind_param('s', $id); //parametro (s=string, variable)
		$result = $stmt->execute(); //se ejecuta la sentencia
		$stmt->close(); //cerrar la base de datos
		return $result; //retorna lo que tiene la variable result
	}
	
	//funcion llamada inNullLogin, la cual obtiene la longitud de los strings
	function isNullLogin($usuario, $password){
		if(strlen(trim($usuario)) < 1 || strlen(trim($password)) < 1)
		{
			return true; //retorna un true si se efectua el if
		}
		else //de lo contrario
		{
			return false;  //retorna un false
		}		
	}
	
	//Funcion llamada login,
	function login($usuario, $password)
	{
		global $mysqli; //creacion de una variable global
		
		$stmt = $mysqli->prepare("SELECT id, id_tipo, password FROM usuarios WHERE usuario = ? || correo = ? LIMIT 1"); //sentencia SQL
		$stmt->bind_param("ss", $usuario, $usuario); //parametro (s=string, variable)
		$stmt->execute(); //se ejecuta la sentencia
		$stmt->store_result(); //visualizar el resultado
		$rows = $stmt->num_rows; //Guardar el resultado
		
		if($rows > 0) { //si el valor es rows a 0
			
			if(isActivo($usuario)){ //si el usuario esta activo
				
				$stmt->bind_result($id, $id_tipo, $passwd); //si el usuario esta activo
				$stmt->fetch(); //visualizar linea x linea en una tabla virtual
				
				$validaPassw = password_verify($password, $passwd); //encriptacion de contraseña
				
				if($validaPassw){ //si el passowrd es correcto
					
					lastSession($id);
					$_SESSION['id_usuario'] = $id;
					$_SESSION['tipo_usuario'] = $id_tipo;
					
					header("location: redirect"); //redirecciona a redirect
					} else { //de lo contrario
					
					$errors = "La contrase&ntilde;a es incorrecta"; //manda un mensaje
				}
				} else {//de lo contrario
				$errors = 'El usuario no esta activo'; //manda un mensaje
			}
			} else {//de lo contrario
			$errors = "El nombre de usuario o correo electr&oacute;nico no existe";//manda un mensaje
		}
		return $errors; //retorna lo que tenga la variable errors
	}
	
	//Funcion llamada lastSession
	function lastSession($id)
	{
		global $mysqli; //creacion de una varible global
		
		$stmt = $mysqli->prepare("UPDATE usuarios SET last_session=NOW(), token_password='', password_request=0 WHERE id = ?"); //sentencia SQL
		$stmt->bind_param('s', $id); //parametro (s=string, variable)
		$stmt->execute(); //se ejecuta la sentencia
		$stmt->close(); //cerrar la base de datos
	}
	
	//funcion llamada isActivo,
	function isActivo($usuario)
	{
		global $mysqli; //Creacion de una varible global
		
		$stmt = $mysqli->prepare("SELECT activacion FROM usuarios WHERE usuario = ? || correo = ? LIMIT 1"); //sentencia SQL
		$stmt->bind_param('ss', $usuario, $usuario); //parametro (s=string, variable)
		$stmt->execute(); //se ejecuta la sentencia
		$stmt->bind_result($activacion); //visualizacion de la sentenci
		$stmt->fetch(); //ver linea x linea en tabla virtual
		
		if ($activacion == 1) //si la variable activacion es igual a 1
		{
			return true;  //retorna true
		}
		else //de lo contrario 
		{
			return false;	//retorna false
		}
	}	
	
	//funcion llamada generaTokenPass,
	function generaTokenPass($user_id)
	{
		global $mysqli; //creacion de una variable global
		
		$token = generateToken(); //creacion de una variable
		
		$stmt = $mysqli->prepare("UPDATE usuarios SET token_password=?, password_request=1 WHERE id = ?"); //sentencia SQL
		$stmt->bind_param('ss', $token, $user_id);//parametro (s=string, variable)
		$stmt->execute(); //se ejecuta la sentencia
		$stmt->close(); //se cierra la base de datos
		
		return $token;//retorna lo que tenga la varible token
	}
	
		//funcion llamada getValor,
	function getValor($campo, $campoWhere, $valor)
	{
		global $mysqli;  //creacion de una varible global
		
		$stmt = $mysqli->prepare("SELECT $campo FROM usuarios WHERE $campoWhere = ? LIMIT 1"); //sentencia SQL
		$stmt->bind_param('s', $valor); //parametro (s=string, variable)
		$stmt->execute(); //se ejecuta la sentencia
		$stmt->store_result(); //obtiene los resultados
		$num = $stmt->num_rows; //guarda los datos
		
		if ($num > 0) //si el valor de num es mayor a 0
		{
			$stmt->bind_result($_campo);  //se obtiene lo que tenga la variable campo
			$stmt->fetch(); //imprime la variable
			return $_campo; //retorna la varible campo
		}
		else //de lo contrario
		{
			return null;	 //retorna null
		}
	}
	
	//funcion llamada getPasswordRequest,
	function getPasswordRequest($id)
	{
		global $mysqli; //creacion de una varible global
		
		$stmt = $mysqli->prepare("SELECT password_request FROM usuarios WHERE id = ?"); //sentencia SQL
		$stmt->bind_param('i', $id); //parametro (i=int, variable)
		$stmt->execute(); //se ejecuta la sentencia
		$stmt->bind_result($_id); //se obtiene los resultados
		$stmt->fetch(); //guarda los datos
		
		if ($_id == 1) //si el valor que tiene la variable _id es igual a 1
		{
			return true; //retorna true
		}
		else //de lo contrario
		{
			return null;	//retorna null
		}
	}
	
	//funcion llamada verificaTokenPass,
	function verificaTokenPass($user_id, $token){
		
		global $mysqli; //creacion de una variable global
		
		$stmt = $mysqli->prepare("SELECT activacion FROM usuarios WHERE id = ? AND token_password = ? AND password_request = 1 LIMIT 1"); //sentencia SQL
		$stmt->bind_param('is', $user_id, $token); //parametro (iS= , variable)
		$stmt->execute(); //se ejecuta la sentencia
		$stmt->store_result(); //se obtiene los resultados
		$num = $stmt->num_rows; //guarda los datos
		
		if ($num > 0) //si el valor de la variable num es mayor a 0
		{
			$stmt->bind_result($activacion); //toma el valor de la varible activacion 
			$stmt->fetch(); //imprime
			if($activacion == 1) //si el valor de la variable activacion es igual a 1
			{
				return true; //retorna true
			}
			else  //de lo contrario
			{
				return false; //retorna false
			}
		}
		else //de lo contrario
		{
			return false;	 //retorna false
		}
	}
	
	//funcion llamada cambiaPassword
	function cambiaPassword($password, $user_id, $token){
		
		global $mysqli; //creacion de una variable global
		
		$stmt = $mysqli->prepare("UPDATE usuarios SET password = ?, token_password='', password_request=0 WHERE id = ? AND token_password = ?"); //sentencia SQL
		$stmt->bind_param('sis', $password, $user_id, $token); //parametro (siS= , variable)
		
		if($stmt->execute()){ //si se ejecuta
			return true; //retorna un true
			} else { //de lo contrario 
			return false;	 //retorna false		
		}
	}		
