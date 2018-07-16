<?php



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
							$mailer->addAddress('gabrialb96@gmail.com');

							$mailer->Subject  = 'Attivazione Account';
							$mailer->AltBody = 'Thanks for signing up ' . 'mario'. '


							Your account has been created, you can login with the following credentials by copying in the URL the link below.
							http://webdev.dibris.unige.it/~S4213112/saw/gab/regForm/confirm.php?token=' . '123567' . '

							NotTooBed';
							$mailer->Body = '
							
							Thanks for signing up ' . 'mario'. '<br><br>  (inserire lo user da sessione al posto di mario)
							Your account has been created, you can login with the following credentials after you have activated your account by pressing the URL below.
													
													
							Perfavore clicca <a style="color:#2f889a" href="https://webdev.dibris.unige.it/~S4213112/filePhpCheAttiviLaMail' . 'mario' . '"> QUI </a> per attivare il tuo account.
													
							'; 
              $mailer->IsHTML(true);
              $mailer->send();
?>