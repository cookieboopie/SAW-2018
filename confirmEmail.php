<?php
    //session_start();
    //get user id o lo username, non so cosa dav abbia salvato e il token dalla sessione

    //require connessione db

    //if variabili di sessione settate

    $query  =   "SELECT token FROM Users WHERE username =   ?";
    $stmt   =   mysqli_prepare($conn,$query);
    mysqli_stmt_bind_param($stmt,"s",$userId(dallaSessione));
    mysql_stmt_execute($stmt);
    $result =   mysqli_stmt_get_result($stmt);
    $find   =   mysqli_num_rows($result);
    /*
        if con risultato 1 allora lo stesso che ha fatto la richiesta
        è anche quello che ha confermato, quindi faccio la query per mettere
        il campo EMAILCONFIRMED a 1:
        $query  =   "UPDATE Users SET emailconfirmed    =   1   WHERE   username    =   ?";
        mysqli_stmt_bind_param($conn,"s",$username o $userid);
        mysqli_stmt_execute($stmt);
        una volta che è stata confermata la pw, di solito i siti reindirizzano, noi possiamo farlo pure, sulla home per esempio.

        else display di un errore o pagina 404 modificata, come al solito. Per quest'ultima
        bisogna però farsi tutti i codici di errore, con relativo messaggio ciascuno.
    */

?>