<?php

	session_start();
	$id_value = $_SESSION['varname'];
	$id_house = $_SESSION['id_house'];
	$data2 = $_SESSION['dataReviewGuest'];
	
	echo $data2;
	echo " ".$id_house;
	
	if(isset($_POST['starReviewGuest'])){
		$starReview = $_POST['starReviewGuest'];
	}
	if(isset($_POST['textReviewGuest'])){
		$reviewGuest = $_POST['textReviewGuest'];
	}
		
	require 'assets/dbConn.php';
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$query = "INSERT INTO review(id_casa, id_ospite, testo, stella, data) VALUES('$id_house', '$id_value', '$reviewGuest', '$starReview', '$data2');UPDATE request SET guestReview =1 WHERE guest= '$id_value' AND data2 = '$data2';";
	$conn->multi_query($query);

	$conn->close();

	

?>