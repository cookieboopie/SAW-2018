<?php

    $servername = "localhost";
    $username = "root";
    $password = "Alakazam@123";
    $dbname = "Accounts";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    $regUsr =   $_POST["regUsr"];
    $regEml =   $_POST["regEml"];
    $regPwd =   $_POST["regPwd"];

    if (mysqli_connect_errno($conn)) {
        die("Connection failed: " . mysqli_connect_error($conn));
    } 
    else{
        if( (isset($regUsr) && !empty($regUsr)) &&  (isset($regEml) && !empty($regEml)) &&  (isset($regPwd) && !empty($regPwd)) ){
            $regUsr   =   trim($regUsr, " ");
            $regUsr   =   preg_replace('/\s+/', '', $regUsr);
            $regUsr   =   mysqli_real_escape_string($conn, $regUsr);

            $regEml   =   trim($regEml, " ");
            $regEml   =   preg_replace('/\s+/', '', $regEml);
            $regEml   =   mysqli_real_escape_string($conn, $regEml);

            $regPwd   =   trim($regPwd, " ");
            $regPwd   =   preg_replace('/\s+/', '', $regPwd);
            $regPwd   =   mysqli_real_escape_string($conn, $regPwd);
            $regPwd   =   password_hash($regPwd, PASSWORD_DEFAULT);

            $sql = "INSERT INTO Users (username, email, password) VALUES (?, ?, ?)";

            if($stmt = mysqli_prepare($conn, $sql)){
                mysqli_stmt_bind_param($stmt, "sss", $regUsr, $regEml, $regPwd);
                mysqli_stmt_execute($stmt);
                }
            mysqli_close($conn);
            }
        }
    

?>