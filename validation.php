<?php
    session_start();
    
    $con=mysqli_connect("localhost","*","*","S4213112");

    $statusU    =   "ko";
    $statusP    =   "ko";
    $statusE    =   "ko";

    $regUsr = trim($_POST['regUsr'], " ");
    $regPwd = trim($_POST['regPwd'], " ");
    $regEml = trim($_POST['regEml'], " ");

    $regUsr = mysqli_real_escape_string($con, $regUsr);
    $regPwd = mysqli_real_escape_string($con, $regPwd);
    $regEml = mysqli_real_escape_string($con, $regEml);

    if( isset($regUsr) && !empty($regUsr) )
		$statusU = "ok";
	else
		$statusU = "empty";
    
    if( isset($regPwd) && !empty($regPwd) )
		$statusP	=	"ok";
	else
        $statusP	=	"empty";
        
    if( isset($regEml) && !empty($regEml) )
		$statusE	=	"ok";
	else
		$statusE	=	"empty";

    if( $statusU === "ok" && $statusP === "ok" && $statusE === "ok" ){
        //devo collegarmi al DB e verificare le robe
        
    }
?>