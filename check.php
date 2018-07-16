<?php
        $servername = "localhost";
        $username = "S4213112";
        $password = "saw@2018";
        $dbname = "S4213112";
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        
        if (mysqli_connect_errno($conn)) {
            die("Connection failed: " . mysqli_connect_error($conn));
        }
        else{
            $varCase    =   3;
            $varCase    =   $_POST['varCase'];
            switch($varCase){ //'varCase' is a var associated to a number generated in 3 different phases: '0' when we have to check if the username inserted in the regForm is already used; '1' the same check but for the email and '2' in the login phase, when the 'login' button is pressed and we have to check username and password in the db to make the login thingy possible. '3' shouldn't ever show up, it's just a default thingy, in case something went wrong.
                case(0):
                $regUsr   =   $_POST["registerInputUsr"];
                if( isset($regUsr) && !empty($regUsr) ){
                    $regUsr  =   trim($regUsr, " ");
                    $regUsr    =   preg_replace('/\s+/', '', $regUsr);
                    $myJSON =   new stdClass();
                    
                    $query  =   "SELECT * FROM Users WHERE USERNAME = ? ";
					$stmt = mysqli_prepare($conn, $query);
					mysqli_stmt_bind_param($stmt, "s", $regUsr);
					mysqli_stmt_execute($stmt);
					$result = mysqli_stmt_get_result($stmt);
					$find	=	mysqli_num_rows($result);
					
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
                $regEml   =   $_POST["registerInputEml"];
                if( isset($regEml) && !empty($regEml) ){
                    $regEml    =   trim($regEml, " ");
                    $regEml    =   preg_replace('/\s+/', '', $regEml);
                    $myJSON =   new stdClass();
                    
                    $query  =   "SELECT * FROM Users WHERE EMAIL = ? ";
					$stmt = mysqli_prepare($conn, $query);
					mysqli_stmt_bind_param($stmt, "s", $regEml);
					mysqli_stmt_execute($stmt);
					$result = mysqli_stmt_get_result($stmt);
					$find	=	mysqli_num_rows($result);
					
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
                $logUsr    =  $_POST["loginInputUsr"];
                $logPwd    =  $_POST["loginInputPwd"];
                if( isset($logUsr) && !empty($logUsr) ){
                    if( isset($logPwd) && !empty($logPwd) ){
                        $logUsr   =   trim($logUsr, " ");
                        $logUsr   =   preg_replace('/\s+/', '', $logUsr);
                        $logUsr   =   mysqli_real_escape_string($conn, $logUsr);
    
                        $logPwd   =   trim($logPwd, " ");
                        $logPwd   =   preg_replace('/\s+/', '', $logPwd);
                        $logPwd   =   mysqli_real_escape_string($conn, $logPwd);
                        
                        $query  =   "SELECT PASSWORD FROM Users WHERE USERNAME = ? ";
						$stmt = mysqli_prepare($conn, $query);
						mysqli_stmt_bind_param($stmt, "s", $logUsr);
						mysqli_stmt_execute($stmt);
						$result = mysqli_stmt_get_result($stmt);
						$find	=	mysqli_num_rows($result);
                        
                        if(password_verify( $logPwd,$result['PASSWORD'] )){
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
?>
