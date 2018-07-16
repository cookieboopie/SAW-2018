<?php

	session_start();
	$id_value = $_SESSION['varname'];
	$data2 = $_SESSION['dataReviewHost'];
	echo $id_value;
	echo $data2;
	
	if(isset($_POST['starReviewHost'])){
		$starHost = $_POST['starReviewHost'];
		echo $starHost;
	}
	if(isset($_POST['textReviewHost'])){
		$reviewHost = $_POST['textReviewHost'];
		echo $reviewHost;
	}
		
	$conn =  mysqli_connect("localhost", "root", "", "testdb");
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$query = "INSERT INTO reviewvisitatori(id_host, testo, data, stella) VALUES( '$id_value', '$reviewHost', '$starHost', '$data2');UPDATE request SET hostReview =1 WHERE host= '$id_value' AND data2 = '$data2';";
	$conn->multi_query($query);

	$conn->close();

	

?>