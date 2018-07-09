<?php
    $servername = "localhost";
    $username = "root";
    $password = "Alakazam@123";
    $dbname = "Accounts";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    $data   =   trim($_POST["robe"], " ");
    if( isset($data) && !empty($data) ){
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
    mysqli_close($conn);
?>
