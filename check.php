<?php
        $servername = "localhost";
        $username = "root";
        $password = "Alakazam@123";
        $dbname = "Accounts";
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        $regUsername   =   $_POST["registerInputUsr"];
        $regEmail   =   $_POST["registerInputEml"];
        $logUsername    =  $_POST["loginInputUsr"];
        $logPassword    =  $_POST["loginInputPwd"];

        if (mysqli_connect_errno($conn)) {
            die("Connection failed: " . mysqli_connect_error($conn));
        }
        else{
            $varCase    =   3;
            $varCase    =   $_POST['varCase'];
            switch($varCase){
                case(0):
                if( isset($regUsername) && !empty($regUsername) ){
                    $regUsername    =   trim($regUsername, " ");
                    $regUsername    =   preg_replace('/\s+/', '', $regUsername);
                    $myJSON =   new stdClass();
                    $query  =   mysqli_query($conn,"SELECT * FROM Users WHERE USERNAME =   '$regUsername' ");
                    $find   =   mysqli_num_rows($query);
                    if($find===1)
                        $myJSON ->found="1";
                    
                    else if($find===0)
                        $myJSON ->found="0";
                    
                    else
                        $myJSON ->found="ko";
                    
                    $JSON   =   json_encode($myJSON);
                    echo($JSON);
                    mysqli_close($conn);
                    break;
                }
                else
                    break;
                case(1):
                if( isset($regEmail) && !empty($regEmail) ){
                    $regEmail    =   trim($regEmail, " ");
                    $regEmail    =   preg_replace('/\s+/', '', $regEmail);
                    $myJSON =   new stdClass();
                    $query  =   mysqli_query($conn,"SELECT * FROM Users WHERE EMAIL =   '$regEmail' ");
                    $find   =   mysqli_num_rows($query);
                    if($find===1)
                        $myJSON ->found="1";
                    
                    else if($find===0)
                        $myJSON ->found="0";
                    
                    else
                        $myJSON ->found="ko";
                    
                    $JSON   =   json_encode($myJSON);
                    echo($JSON);
                    mysqli_close($conn);
                    break;
                }
                else
                    break;
                case(2):
                if( isset($logUsername) && !empty($logUsername) ){
                    if( isset($logPassword) && !empty($logPassword) ){
                        $logUsername   =   trim($logUsername, " ");
                        $logUsername   =   preg_replace('/\s+/', '', $logUsername);
                        $logUsername   =   mysqli_real_escape_string($conn, $logUsername);
    
                        $logPassword   =   trim($logPassword, " ");
                        $logPassword   =   preg_replace('/\s+/', '', $logPassword);
                        $logPassword   =   mysqli_real_escape_string($conn, $logPassword);
                        
                        $query  =   mysqli_query($conn,"SELECT PASSWORD FROM Users WHERE USERNAME = '$logUsername' ");
                        $result =   mysqli_fetch_assoc($query);
                        if(password_verify( $logPassword, $result['PASSWORD'] )){
                            echo ("ok");
                        }
                        else{
                            echo("ko");
                        }
                        mysqli_close($conn);
                        break;
                    }
                }
                case(3):
                mysqli_close($conn);
            }
        }
        mysqli_close($conn);
?>