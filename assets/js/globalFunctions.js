var regRegex = [];

var emailRegex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

var allValid;

/* Trovare le regex di validazione di tutti i campi del Form, inserirle nell'array e testare i campi del form con la rispettiva regex.
   Se un campo fallisce il check, attribuirgli una classe inputError e un messaggio in uno span.
   Il check si può fare on("input", callback) o on("change", callback") e, magari, che al successivo input l'eventuale classe di errore viene disattivata. */

function validateFields(formId) {

}


function manageResults(someData) {
    if('error' in someData) {
        /* Cose simili a validateFields per mostrare gli errori */
    } else {
        window.location.replace('mainPage.php?getVar=welcomeMsg');
    }
}

$('#regSubmit').on("submit", function(e) {
    e.preventDefault();

    if(allValid) {
        $.ajax({
            url: 'renatoReg.php',
            type: 'POST',
            dataType: 'JSON',
            error: function(XHR, ajaxOptions, thrownError) {
               $('#inputError').html('<p>An error has occurred!</p>'); /* <?php echo htmlspecialchars($infoAd); ?> 
                                                                          Nel PHP crei un oggetto con new stdClass() e gli inserisci campi con -> e poi, prima di spedirlo in echo, fai json_encode($returnObj) */
            },
            success: function(returnData) {
                manageResults(returnData);
            }
        });
    } else {
        
    }
}); 

$('#regForm input').on("change", function() {
    validateFields();
});

/* Nelle query SQL se puoi usa i Prepared Statements in INSERT e in SELECT. Ma se sono query piccole, sono più lenti che usare il mysqli_query o $sqliObj->query, perciò magari si possono invece usare questi due. In questo caso fai sempre la trim degli input, e poi se sono Integer per validarli bast il cast (int), mentre se sono di tipo String usa mysqli_real_escape_string o $sqliObj->real_escape_string e ricordati di passarli alle query come stringhe, cioè usa gli apici ''.
   Esempio di SELECT: $sqlQuery = "SELECT * FROM Table WHERE someField='" . $someVar "'"; */

/* Quando tu usi in PHP la funzione header(), che sia per veri header della chiamata o che sia per fare un redirect con header('Location: URL'), non ci deve essere niente in output prima. Niente HTML e niente righe vuote. Poichè appena c'è un output gli header vengono impacchettati, inviati e non sono più modificabili. Perciò usi ob_start e ob_flush / ob_end_flush per mandare tutto al buffer e poi inviare tutti i dati insieme. Esiste anche ob_end_clean che butta via tutto quello che c'è nel buffer ed è utile se tu vuoi evitare echo indesiderati prima di quelli che ti aspetti. */