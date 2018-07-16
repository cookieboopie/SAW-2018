<?php
	use PHPMailer\PHPMailer\PHPMailer;
	
    $servername = "localhost";
    $username = "S4213112";
    $password = "saw@2018";
    $dbname = "S4213112";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    

    if (mysqli_connect_errno($conn)) {
        die("Connection failed: " . mysqli_connect_error($conn));
    } 
    else{
		$regUsr =   $_POST["regUsr"];
		$regEml =   $_POST["regEml"];
		$regPwd =   $_POST["regPwd"];
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
            
			$token    =   'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM!$()';
            $token    =   str_shuffle($token);
            $token    =   substr($token,2,17);
            
            $default	=	0;
            
            
			
            //The following sql thing is a prepared statements, in fact we have ? instead '$data', done in a procedural way.
            $sql = "INSERT INTO Users (username, email, password, token, emailconfirmed) VALUES (?, ?, ?, ?, ?)";

            if($stmt = mysqli_prepare($conn, $sql)){
                mysqli_stmt_bind_param($stmt, "ssssi", $regUsr, $regEml, $regPwd, $token, $default); //'ssss' specify that the three arguments given to the query are string, 'i' that it's an integer.
                mysqli_stmt_execute($stmt);
                }
               
			include_once	"assets/PHPMailer/PHPMailer.php";
            
            require 'assets/PHPMailer/Exception.php';
			require 'assets/PHPMailer/PHPMailer.php';
			require 'assets/PHPMailer/SMTP.php';
            
            $mailer	=	new	PHPMailer();
            $mailer->setFrom('nottoobed@libero.it','NotTooBed Sharing!');
            $mailer->addAddress($regEml);
            $mailer->Subject	=	"Please verify email!";
            $mailer->IsSMTP();
            $mailer->Host   =   'smtp.libero.it';
			$mailer->Port   =   587;
			$mailer->Username   =   'nottoobed@libero.it';
			$mailer->Password   =   'saw@2018';
			$mailer->SMTPSecure =   'tls';
			$mailer->SMTPAuth   =   true;
            $mailer->Body="
				Please click on the link below:<br><br>
				
				<a href='http://webdev.dibris.unige.it/~S4213112/saw/gab/regForm/confirm.php?email=$regEml&token=$token'>Click Here</a>
				";
			$mailer->IsHTML(true);
            $mailer->send();
            mysqli_close($conn);
            unset($conn);
            }
        }
?>
