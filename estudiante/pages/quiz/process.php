<?php 
	session_start(); //Iniciar una sesion
	require '../../funcs/conexion.php'; //Funcion para incluir el archivo
	include '../../funcs/funcs.php';  //incluir el archivo

	//For first question, score will not be there.
	if(!isset($_SESSION['score'])){
		$_SESSION['score'] = 0;
	}
		if($_POST){
		//We need total question in process file too
		$query = "SELECT * FROM questions";
		$total_questions = mysqli_num_rows(mysqli_query($mysqli,$query));
		
		//We need to capture the question number from where form was submitted
		$number = $_POST['number'];
		
		//Here we are storing the selected option by user
		$selected_choice = $_POST['choice'];
		
		//What will be the next question number
		$next = $number+1;
		
		//Determine the correct choice for current question
		$query = "SELECT * FROM options WHERE question_number = $number AND is_correct = 1"; //sentencia SQL
		$result = mysqli_query($mysqli,$query); //ejecutar la sentencia
		$row = mysqli_fetch_assoc($result); //visualizar la informacion

		$correct_choice = $row['id']; //variable
		
		//Increase the score if selected cohice is correct
		if($selected_choice == $correct_choice){
			$_SESSION['score']++;
		}
			//Redirect to next question or final score page. 
		if($number == $total_questions){
			header("LOCATION: final"); //redireccionamiento a final
		}else{//de lo contrario
			header("LOCATION: question.php?n=". $next); //redireccionamiento a question.php
		}

	}

?>