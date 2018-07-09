<?php
    $servername = "localhost";
    $username = "root";
    $password = "Alakazam@123";
    $dbname = "Accounts";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $data   =   trim($_POST['data'], " ");
    if( isset($data) && !empty($data) ){
        $myJSON = new stdClass();
        $query = mysqli_query($conn,"SELECT * FROM Users WHERE username =   '$data' ");
        $find = mysqli_num_rows($query);
        echo $find;
        mysqli_close($con);
    }
?>
NON SEI UP TO DATE
