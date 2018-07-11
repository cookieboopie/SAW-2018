<?php
        $servername = "localhost";
        $username = "root";
        $password = "Alakazam@123";
        $dbname = "Accounts";
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        $data   =   $_POST["registerInput"];
        $username=  $_POST["loginInputUsr"];
        $password=  $_POST["loginInputPwd"];
    
    if( isset($data) && !empty($data) ){
        $data   =   trim($data, " ");
        $data = preg_replace('/\s+/', '', $data);
        $myJSON = new stdClass();
        $query = mysqli_query($conn,"SELECT * FROM Users WHERE USERNAME =   '$data' ");
        $find = mysqli_num_rows($query);
        if($find===1){
            $myJSON ->found="1";
        }
        else if($find===0){
            $myJSON ->found="0";
        }
        else
            $myJSON ->found="ko";
        $JSON   =   json_encode($myJSON);
        echo($JSON);
        mysqli_close($conn);
    }
    else
        mysqli_close($conn);

    if( isset($username) && !empty($username) ){
        $username   =   trim($username, " ");
        $username = preg_replace('/\s+/', '', $username);
        $myJSON = new stdClass();
        //$query = mysqli_query($conn,"SELECT * FROM Users WHERE USERNAME =   '$username' ");
        //Da fare query che trovi lo username e da questo la password, poi hashi la pw e cerchi la corrispondenza.
        mysqli_close($conn);
    }
    else
        mysqli_close($conn);
    
?>
