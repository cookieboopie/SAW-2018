<?php
	session_start();
	$id_value = null;
	if(isset($_SESSION['varname'])){
		session_destroy();
		echo 'Hai appena eseguito il Logout.<br> <button class="btn btn-primary" onclick="window.open(\'index.php\')">TORNA ALLA HOME PAGE</button>';
	}else{
		header("Location: ./index.php");
		die(); 
	}
?>

<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    