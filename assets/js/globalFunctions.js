var emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
var allValid;
var pwdRegex  = /^(?=.*\d)(?=.*[a-z])[0-9a-z]{5,}$/ /*almeno 5 caratteri con almeno 1 numero e una lettera minuscola*/
var usrRegex  = /^[a-zA-Z0-9]/;
var nameRegex = /^[a-zA-Z\-_ ’'‘ÆÐƎƏƐƔĲŊŒẞÞǷȜæðǝəɛɣĳŋœĸſßþƿȝĄƁÇĐƊĘĦĮƘŁØƠŞȘŢȚŦŲƯY̨Ƴąɓçđɗęħįƙłøơşșţțŧųưy̨ƴÁÀÂÄǍĂĀÃÅǺĄÆǼǢƁĆĊĈČÇĎḌĐƊÐÉÈĖÊËĚĔĒĘẸƎƏƐĠĜǦĞĢƔáàâäǎăāãåǻąæǽǣɓćċĉčçďḍđɗðéèėêëěĕēęẹǝəɛġĝǧğģɣĤḤĦIÍÌİÎÏǏĬĪĨĮỊĲĴĶƘĹĻŁĽĿʼNŃN̈ŇÑŅŊÓÒÔÖǑŎŌÕŐỌØǾƠŒĥḥħıíìiîïǐĭīĩįịĳĵķƙĸĺļłľŀŉńn̈ňñņŋóòôöǒŏōõőọøǿơœŔŘŖŚŜŠŞȘṢẞŤŢṬŦÞÚÙÛÜǓŬŪŨŰŮŲỤƯẂẀŴẄǷÝỲŶŸȲỸƳŹŻŽẒŕřŗſśŝšşșṣßťţṭŧþúùûüǔŭūũűůųụưẃẁŵẅƿýỳŷÿȳỹƴźżžẓ]$/;

/* Trovare le regex di validazione di tutti i campi del Form, inserirle nell'array e testare i campi del form con la rispettiva regex.
   Se un campo fallisce il check, attribuirgli una classe inputError e un messaggio in uno span.
   Il check si può fare on("input", callback) o on("change", callback") e, magari, che al successivo input l'eventuale classe di errore viene disattivata. */

/*Con questa funzione voglio: dato l'id del form da validare, prendere tutti i suoi campi e verificare che siano corretti.
  ->dato che qua non posso fare escape (mi serve conn. al db e php), come gestirò il php? cioò come farò il php che dovrà gestirmi il mysqli_real_escape_string
  Io so verificare i campi in php, ma non in js, quindi devo studiarmi un po' il linguaggio e le cose che devo fare.
  Da validare: 1)USERNAME, 2)EMAIL, 3)PASSWORD, 4)CONFERMA PASSWORD(just to control che deve essere uguale all'altra). 
  1)-required; -minimo 3/4caratteri; -regex per sintassi; -ajax per nome in uso -> ajax posso farlo in jquery!!. 
  2)-required; -regex per sintassi; -ajax per email già in uso.
  3)-required; -minimo tot caratteri; (-almeno carattere speciale e/o numero).
  Ma a sto punto faccio ajax direttamente in php (?).
  aggiungere nome e cognome nel regForm.
  nome e congome è strict solo char (occhio alle lingue strane) [a-zA-Z].
  FACEBOOK usa le seguenti limitazioni (robe non utilizzabili nei nomi): 
    -Symbols, numbers, unusual capitalization, repeating characters or punctuation
    -Characters from multiple languages
    -Titles of any kind (ex: professional, religious, etc)
    -Words, phrases, or nicknames in place of a middle name
    -Offensive or suggestive content of any kind.


  Per il LOGIN form, imposto due controlli base base sulla lunghezza dei campi, e poi controllo che sia in database.
  per il display error, basta mettere "username/password errato in caso di lunghezza errata."
*/


function passwordConfirm(pwd,pwdC){
  if($(pwd).val()===$(pwdC).val()){
    $("#pwdC_err").text("");
    $("#pwdC").removeClass("ui-state-error");
    return  true;
  }
  else {
    $(pwdC).addClass("ui-state-error");
    updateTips("#pwdC_err","password doesn't match");
    return  false;
  }
};

function resetField(field) {
  $(field).val(function() {
      return this.defaultValue;
  });
};

function checkLength(obj,field,min,max){
  if ( $(obj).val().length > max || $(obj).val().length < min ) {
    $(obj).addClass("ui-state-error");
    updateTips((obj+"_err"),"Length of " + field + " must be between " +
      min + " and " + max + "." );
    return false;
  } else {
    return true;
  }
};

function checkRegExp(obj, regexp, _errText){
  if ( !( regexp.test( $(obj).val() ) ) ) {
    $(obj).addClass( "ui-state-error" ); //obv devo farmi le classi ui per il display di errori
    updateTips(obj+"_err",_errText );
    return false;
  } else {
    $(obj).removeClass("ui-state-error");
    $(obj+"_err").text("");
    return true;
  }
};

function updateTips(errElem,_errText){
      $(errElem)
        .text(_errText)
        .addClass("ui-state-highlight");
      setTimeout(function() {
        $(errElem).removeClass( "ui-state-highlight", 1500 );
      }, 800 );
    };

/*Funzione per validare tutti i campi del logForm quando si preme il tasto 'submit'*/
function validateLog(input) {

}

function validateField(inputObj){ 
  switch(inputObj.id){
    case("regUsr"): 
      return (checkLength(('#'+inputObj.id),"username",3,16)) && checkRegExp(('#'+inputObj.id),/^[a-z]([0-9a-z_\s])+$/i,"Username may consist of a-z, 0-9,'_' and must start with a letter");
      break;
    case("regEml"): 
      return(checkLength(('#'+inputObj.id),"email", 6,250)  &&  checkRegExp(('#'+inputObj.id),emailRegex,"eg. ab@abcde.com"));
      break;
    case("regPwd"): 
      resetField("#pwdC");/*resetta il campo di conferma della password*/
      return(checkLength(('#'+inputObj.id),"password",5,16) &&  checkRegExp(('#'+inputObj.id),pwdRegex,"Password MUST contain at least five characters of which at least one number"));
      break;
    case("pwdC"):
      return(passwordConfirm("#regPwd","#pwdC"));
      break;
  }
}

$('document').ready(function() {
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
            
        }e
    });

    $("#regForm input").on("change",function(){ 
      var id  = this.id;
      if(validateField(this)  &&  (this.id!=="pwdC" || this.id!=="regPwd"))
        {
          $.ajax({
            type: "POST",
            url: "check.php",
            data: {
              robe: $('#'+this.id).val()
            },
            success: function(result){
              var obj = JSON.parse(result);
              if(obj.found==="1"){
                $("#"+id).addClass( "ui-state-error" );
                updateTips('#'+id+"_err","Username already taken!");
              }
              else if(obj.found==="ko"){
              $("#"+id).addClass( "ui-state-error" );
              updateTips('#'+id+"_err","Internal error occurred. Change username");
              }
            }
          });
        }
    });
    $("#logSubmit").click(function(){
      validateLog($("#logForm input"));
      submitData();
    });

    $(".close").click(function() {
        $(".ui-state-error").removeClass();
        $("[id$='_err']").text("");
        $(".wrapper").hide();
        document.getElementById("regForm").reset();
        document.getElementById("logForm").reset();
    });

    $(".regBtn").click(function(){
        $(".wrapper").css("display","flex");
        $(".reg").click();
    });

    $(".logBtn").click(function(){
        $(".wrapper").css("display","flex");
        $(".log").click();
    });

    $(".reg").click(function(){
        $("#logForm").hide();
        $("#regForm").show();
    })
    $(".log").click(function(){
        $("#logForm").show();
        $("#regForm").hide();
    })


});



/* Nelle query SQL se si può si usano i Prepared Statements in INSERT e in SELECT. Ma se sono query piccole, sono più lenti che usare il mysqli_query o $sqliObj->query, perciò magari si possono invece usare questi due. In questo caso faccio sempre la trim degli input, e poi se sono Integer per validarli bast il cast (int), mentre se sono di tipo String uso mysqli_real_escape_string o $sqliObj->real_escape_string e bisogna ricordarsi di passarli alle query come stringhe,cioè di usare gli apici ''.
   
  Esempio di SELECT: $sqlQuery = "SELECT * FROM Table WHERE someField='" . $someVar "'"; */

/* Quando in PHP si usa la funzione header(), che sia per veri header della chiamata o che sia per fare un redirect con header('Location: URL'), non ci deve essere niente in output prima. Niente HTML e niente righe vuote. Poichè appena c'è un output gli header vengono impacchettati, inviati e non sono più modificabili. Perciò si usa ob_start e ob_flush / ob_end_flush per mandare tutto al buffer e poi inviare tutti i dati insieme. Esiste anche ob_end_clean che butta via tutto quello che c'è nel buffer ed è utile se vuoi evitare echo indesiderati prima di quelli che ti aspetti. */

