<?php

    require 'assets/dbConn.php';
    
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
               
            require '/var/libsaw/sendmail/autoload.php';
            $mailer = new PHPMailer;

            $mailer->IsSMTP();
            $mailer->SMTPSecure = 'tls';
            $mailer->SMTPAuth = true;

            $mailer->Host = 'smtp.libero.it';
            $mailer->Port = 587;

            $mailer->Username = 'nottoobed@libero.it';
            $mailer->Password = 'saw@2018';

            $mailer->AddReplyTo('noreply@ntbed.it');
            $mailer->setFrom('nottoobed@libero.it', 'NotTooBed Sharing');
            $mailer->addAddress($regEml);

            $mailer->Subject  = 'Account Activation';
            $mailer->AltBody = 'Thanks for signing up ' . 'mario'. '


            Your account has been created, you can login with the following credentials by copying in the URL the link below.
            http://webdev.dibris.unige.it/~S4213112/saw/gab/regForm/confirm.php?token='.$token.'

            NotTooBed';
            $mailer->Body = '
            
            Thanks for signing up ' . 'mario'. '<br><br>  (inserire lo user da sessione al posto di mario)
            Your account has been created, you can login with the following credentials after you have activated your account by pressing the URL below.
                                    
                                    
            Perfavore clicca <a style="color:#2f889a" href="https://webdev.dibris.unige.it/~S4213112/filePhpCheMettaA1IlEmailConfirmed' . 'mario' . '"> QUI </a> per attivare il tuo account.
                                    
            '; 
            $mailer->IsHTML(true);
            if($mailer->send()){
                //invio riuscito
            } 
            else{
                //mettere condizioni di rendirizzamento in caso di invio non riuscito (per esempio su pagina 404 modificata) o di display di qualche messaggio.
            }

            mysqli_close($conn);
            unset($conn);
            }
        }
?>
