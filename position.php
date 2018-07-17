<?php

	session_start();
	$id_value = $_SESSION['varname'];
	
	
	
	if(isset($_POST['lng'])){
		$long = $_POST['lng'];
	}
	if(isset($_POST['lat'])){
		$lat = $_POST['lat'];
	}
	if(isset($_POST['data1'])){
		$data1 = $_POST['data1']; 
	}
	if(isset($_POST['data2'])){
		$data2 = $_POST['data2'];
	}
	if(isset($_POST['nameRoom'])){
		$nameRoom = $_POST['nameRoom'];
	}	
	if(isset($_POST['textArea'])){
		$description = $_POST['textArea'];
	}	
	if(isset($_POST['city'])){
		$city = $_POST['city'];
	}	
	
		if ($data2 <= $data1) {
			
			header("Location: ./map.php");
			die();

		}else{
		
		if(isset($_POST['bottone'])){
		
		$name= $_FILES['InputFile0']['name'];
		$name1= "0";
		$tmp_name= $_FILES['InputFile0']['tmp_name'];
		
			if (!file_exists('uploads/'.$id_value.'/')) {
				mkdir('uploads/'.$id_value.'/', 0777, true);
			}
		}
		
		if(isset($name)){
			$location= 'uploads/'.$id_value.'/';
			move_uploaded_file($tmp_name, $location.$name1.".jpg");
		}
		
		require 'assets/dbConn.php';
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		
		$query = "INSERT INTO annunci(titolo, id_proprietario, citta, path, lat, longit, data1, data2, testoCasa) VALUES('$nameRoom', '$id_value', '$city', 'alto2.jpg', '$lat', '$long', '$data1', '$data2','$description')";
		$result = $conn->query($query);

		$conn->close();

	}

?>