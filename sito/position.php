<?php

	session_start();
	$var_value = $_SESSION['varname'];
	echo $var_value;
	
	
	if(isset($_POST['bottone'])){
	
	$name= $_FILES['InputFile0']['name'];
	$name1= "0";
	echo $name;
	echo $name;
	$tmp_name= $_FILES['InputFile0']['tmp_name'];
	
	}
	
	if(isset($name)){
		$location= 'uploads/';
		move_uploaded_file($tmp_name, $location.$name1.".jpg");
	}
	if(isset($_POST['lng'])){
		$long = $_POST['lng'];
			echo " ". $long;
	}
	if(isset($_POST['lat'])){
		$lat = $_POST['lat'];
			echo " ". $lat;
	}
	if(isset($_POST['data1'])){
		$data1 = $_POST['data1'];
			echo " ". $data1;
	}
	if(isset($_POST['data2'])){
		$data2 = $_POST['data2'];
			echo " ". $data2;
	}
	if(isset($_POST['nameRoom'])){
		$nameRoom = $_POST['nameRoom'];
			echo " ". $nameRoom;
	}	
	if(isset($_POST['textArea'])){
		$description = $_POST['textArea'];
			echo " ". $description;
	}	
	if(isset($_POST['city'])){
		$city = $_POST['city'];
			echo " ". $city;
	}	
	

  
	
	$conn =  mysqli_connect("localhost", "root", "", "testdb");
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$query = "SELECT id_ospite, stella, testo, data FROM review WHERE id_casa='$city'";
	$result = $conn->query($query);
	$num_results = $result->num_rows;

	$id_ospite = [];
	$stella = [];
	$testo = [];
	$data = [];
		
	if ($result->num_rows > 0) {
		// output data of each row
		$incr = 0;
		while($row = $result->fetch_assoc()) {
			echo " RISULTATI QUERY RICERCA <br>ID_OSPITE:".$row["id_ospite"]."  ||  Stella: ". $row["stella"]."  || Testo: ".$row["testo"]."<br>";
			$id_ospite[$incr]= $row["id_ospite"];
			$stella[$incr] = $row["stella"];
			$testo[$incr] = $row["testo"];
			$data[$incr] = $row["data"];
			
			$incr++;

		}
	} else {
		echo "0 results";
	}

	echo $num_results;
$conn->close();

?>