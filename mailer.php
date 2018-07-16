<?php



//includiamo la classe PHPMailer
require '/var/libsaw/sendmail/autoload.php';


//istanziamo la classe
$messaggio = new PHPmailer();
$messaggio->IsSMTP();
$messaggio->Host='Host SMTP';

//definiamo le intestazioni e il corpo del messaggio
$messaggio->From='nottoobed@libero.it';
$messaggio->AddAddress('gabrialb96@gmail.com');
$messaggio->AddReplyTo('info@mittente.it'); 
$messaggio->Subject='Prova.';
$messaggio->Body=stripslashes('Ciao!!!!');

//definiamo i comportamenti in caso di invio corretto 
//o di errore
if(!$messaggio->Send()){ 
  echo $messaggio->ErrorInfo; 
}else{ 
  echo 'Email inviata correttamente!';
}

//chiudiamo la connessione
$messaggio->SmtpClose();
unset($messaggio);
?>