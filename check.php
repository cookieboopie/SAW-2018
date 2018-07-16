<?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "testdb";
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        
        
        
        

        if (mysqli_connect_errno($conn)) {
            die("Connection failed: " . mysqli_connect_error($conn));
        }
        else{
            $varCase    =   3;
            $varCase    =   $_POST['varCase'];
            switch($varCase){ //'varCase' is a var associated to a number generated in 3 different phases: '0' when we have to check if the username inserted in the regForm is already used; '1' the same check but for the email and '2' in the login phase, when the 'login' button is pressed and we have to check username and password in the db to make the login thingy possible. '3' shouldn't ever show up, it's just a default thingy, in case something went wrong.
                case(0):
                $regUsername   =   $_POST["registerInputUsr"];
                if( isset($regUsername) && !empty($regUsername) ){
                    $regUsername    =   trim($regUsername, " ");
                    $regUsername    =   preg_replace('/\s+/', '', $regUsername);
                    $myJSON =   new stdClass();
                    $query  =   mysqli_query($conn,"SELECT * FROM accounts WHERE USERNAME =   '$regUsername'");
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
                $regEmail   =   $_POST["registerInputEml"];
                if( isset($regEmail) && !empty($regEmail) ){
                    $regEmail    =   trim($regEmail, " ");
                    $regEmail    =   preg_replace('/\s+/', '', $regEmail);
                    $myJSON =   new stdClass();
                    $query  =   mysqli_query($conn,"SELECT * FROM accounts WHERE EMAIL ='$regEmail'");
                    $find   =   mysqli_num_rows($query);
                    if($find===1)
                        $myJSON ->found="1";

                    else if($find===0)
                        $myJSON ->found="0";
                    
                    else
                        $myJSON ->found="ko";
                    
                    $JSON   =   json_encode($myJSON);
                    echo($JSON);
					$conn->close();
                    break;
                }
                else
                    break;
                case(2):
                $logUsername    =  $_POST["loginInputUsr"];
                $logPassword    =  $_POST["loginInputPwd"];
                if( isset($logUsername) && !empty($logUsername) ){
                    if( isset($logPassword) && !empty($logPassword) ){
                        $logUsername   =   trim($logUsername, " ");
                        $logUsername   =   preg_replace('/\s+/', '', $logUsername);
                        $logUsername   =   mysqli_real_escape_string($conn, $logUsername);
    
                        $logPassword   =   trim($logPassword, " ");
                        $logPassword   =   preg_replace('/\s+/', '', $logPassword);
                        $logPassword   =   mysqli_real_escape_string($conn, $logPassword);
                        
                        $query  =   mysqli_query($conn,"SELECT USERNAME,ID, PASSWORD FROM accounts WHERE USERNAME = '$logUsername' ");
                        $result =   mysqli_fetch_assoc($query);
						session_start();
						$_SESSION['varname'] =$result['ID'] ;
						$_SESSION['myName'] =$result['USERNAME'] ;
						
                        if(password_verify( $logPassword, $result['PASSWORD'] )){
                            echo ("ok");
                        }
                        else{
                            echo("ko");
                        }
						$conn->close();
                        break;
                    }
                }
                case(3):
                mysqli_close($conn);
            }
        }
?>