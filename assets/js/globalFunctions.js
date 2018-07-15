var emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
var allValid;
var pwdRegex  = /^(?=.*\d)(?=.*[a-zA-Z])[A-Za-z\d$@$!%*#?&£.,]{5,}$/ ; /*almeno 5 caratteri con almeno 1 numero e una lettera minuscola/maiusc*/
var usrRegex  = /^([0-9a-zA-Z_])+$/i;
var nameRegex = /^[a-zA-Z\-_ ’'‘ÆÐƎƏƐƔĲŊŒẞÞǷȜæðǝəɛɣĳŋœĸſßþƿȝĄƁÇĐƊĘĦĮƘŁØƠŞȘŢȚŦŲƯY̨Ƴąɓçđɗęħįƙłøơşșţțŧųưy̨ƴÁÀÂÄǍĂĀÃÅǺĄÆǼǢƁĆĊĈČÇĎḌĐƊÐÉÈĖÊËĚĔĒĘẸƎƏƐĠĜǦĞĢƔáàâäǎăāãåǻąæǽǣɓćċĉčçďḍđɗðéèėêëěĕēęẹǝəɛġĝǧğģɣĤḤĦIÍÌİÎÏǏĬĪĨĮỊĲĴĶƘĹĻŁĽĿʼNŃN̈ŇÑŅŊÓÒÔÖǑŎŌÕŐỌØǾƠŒĥḥħıíìiîïǐĭīĩįịĳĵķƙĸĺļłľŀŉńn̈ňñņŋóòôöǒŏōõőọøǿơœŔŘŖŚŜŠŞȘṢẞŤŢṬŦÞÚÙÛÜǓŬŪŨŰŮŲỤƯẂẀŴẄǷÝỲŶŸȲỸƳŹŻŽẒŕřŗſśŝšşșṣßťţṭŧþúùûüǔŭūũűůųụưẃẁŵẅƿýỳŷÿȳỹƴźżžẓ]$/;

var regUsrValid = false;
var regPwdValid = false;
var regEmlValid = false;
var regPwCValid = false;


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
  FACEBOOK usa le seguenti limitazioni per il nome utente (robe non utilizzabili nei nomi): 
    -Symbols, numbers, unusual capitalization, repeating characters or punctuation
    -Characters from multiple languages
    -Titles of any kind (ex: professional, religious, etc)
    -Words, phrases, or nicknames in place of a middle name
    -Offensive or suggestive content of any kind.
*/

function passwordConfirm(pwd,pwdC){
  if($(pwd).val()===$(pwdC).val()){
    $("#pwdC_err").text("");
    $("#pwdC").removeClass("ui-state-error");
    return  true;
  }
  else {
    $(pwdC).addClass("ui-state-error");
    updateTips("#pwdC_err","Password doesn't match");
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

/*Function used to (re)validate every field in the logForm 'in toto' when we press 'submit'*/
function validateLog(input) {
  //check length username
  if( ($('#logUsr').val().length  > 16)  ||  ($('#logUsr').val().length < 3) ){
    return false;
  }
  else{
    //check regExp username
    if( !(usrRegex.test( $('#logUsr').val() )) ){
      return false;
    }
    else{
      //check length password
      if( $('#logPwd').val().length  > 16  ||  $('#logPwd').val().length  < 3 ){
        return false;
      }
      else{
        //check regExp password
        if( !(pwdRegex.test( $('#logPwd').val() )) ){
          return false;
        }
        else
          //We can press submit if everything valid.
          return true;
      }
    }
  }
}
/*Function used to validate every single field (triggered by an 'onChange' event listener on form fields) */
function validateField(inputObj){ 
  switch(inputObj.id){
    case("regUsr"): 
      return (checkLength(('#'+inputObj.id),"username",3,16)) && checkRegExp(('#'+inputObj.id),usrRegex,"Username may consist of a-z, 0-9,'_'");
      break;
    case("regEml"): 
      return(checkLength(('#'+inputObj.id),"email", 6,250)  &&  checkRegExp(('#'+inputObj.id),emailRegex,"eg. ab@abcde.com"));
      break;
    case("regPwd"): 
      resetField("#pwdC");//it resets the password confirmation field (textarea).
      return(checkLength(('#'+inputObj.id),"password",5,16) &&  checkRegExp(('#'+inputObj.id),pwdRegex,"Insert at least 5 characters and 1 number"));
      break;
    case("pwdC"):
      return(passwordConfirm("#regPwd","#pwdC"));
      break;
  }
}

$('document').ready(function() {
  var obj;
  $("#regForm input").on("change",function(){ 
    var id  = this.id;
    if(validateField(this)  &&  (this.id!=="pwdC" || this.id!=="regPwd"))
      {
        switch(this.id){
          case("regUsr"):
            $.ajax({
              type: "POST",
              url: "check.php",
              data: {
                registerInputUsr: $('#'+this.id).val(),
                varCase:  0
              },
              success: function(result){
                obj = JSON.parse(result);
                if(obj.found==="1"){
                  $('#'+id).addClass( "ui-state-error" );
                  updateTips('#'+id+"_err","Username already taken!");
                }
                else if(obj.found==="ko"){
                $('#'+id).addClass( "ui-state-error" );
                updateTips('#'+id+"_err","Internal error occurred. Change username");
                }
              }
            });
            break;
          case("regEml"):
            $.ajax({
              type: "POST",
              url: "check.php",
              data: {
                registerInputEml: $('#'+this.id).val(),
                varCase:  1
              },
              success: function(result){
                obj = JSON.parse(result);
                if(obj.found==="1"){
                  $("#"+id).addClass( "ui-state-error" );
                  updateTips('#'+id+"_err","Email already in use!");
                }
                else if(obj.found==="ko"){
                $("#"+id).addClass( "ui-state-error" );
                updateTips('#'+id+"_err","Internal error occurred. Change email");
                }
              }
            });
            break;
        }
      }
  });

  $("#regSubmit").click(function(){
    if( ($('#regUsr').val().length !== 0) &&  ($('#regEml').val().length !== 0)  &&  ($('#regPwd').val().length !== 0)  &&  ($('#pwdC').val().length !== 0) ){
      //check length username
      if( ($('#regUsr').val().length  > 16)  ||  ($('#regUsr').val().length < 3) ){
        return false;
      }
      else{
        //check regExp username
        if( !(usrRegex.test( $('#regUsr').val() )) ){
          return false;
        }
        else{
          //check length password
          if( ($('#regPwd').val().length  > 16)  ||  ($('#regPwd').val().length < 5) ){
            return false;
          }
          else{
            //check regExp password
            if( !(pwdRegex.test( $('#regPwd').val() )) ){
              return false;
            }
            else{
              //check length mail
              if( ($('#regEml').val().length  > 250)  ||  ($('#regEml').val().length < 6) ){
                return false;
              }
              else{
                //check regExp mail
                if( !(emailRegex.test( $('#regEml').val() )) ){
                  return false;
                }
                else{
                  //check: regPwd and pwdC must be the same thing
                  if( !($('#regPwd').val() === $('#pwdC').val()) ){
                    return false;
                  }
                  else{
                    //we cannot have ui-state-error classes indicating already used thingy.
                    if( $('#regForm').find(".ui-state-error").length!==0 ){
                      return false;
                    }
                    else{
                      $.ajax({
                        type: "POST",
                        url: "register.php",
                        data: {
                          regUsr: $('#regUsr').val(),
                          regEml: $('#regEml').val(),
                          regPwd: $('#regPwd').val()
                        },
                        success: function(result){
                          alert("Ti sei registrato correttamente!");
                          $(".wrapper").hide();
                          document.getElementById("regForm").reset();
                          document.getElementById("logForm").reset();

                        }
                      });
                      return true;
                    }
                  }
                }
              }
            }
          }
        }
      }
    }
    else{

    }
  });

  $("#logSubmit").click(function(){
    $('#logUsr').removeClass("ui-state-error");
    $('#logPwd').removeClass("ui-state-error");
    if( validateLog($("#logForm input"))  ){
      //submit in ajax
      $.ajax({
        type: "POST",
        url: "check.php",
        dataType: "html",
        data: {
          loginInputUsr:  $('#logUsr').val(),
          loginInputPwd:  $('#logPwd').val(),
          varCase:  2
        },
        success: function(result){
          if(result==="ok"){
            alert("Bentornato Pierino!");
          }
          else{
            alert("Fai schifo!");
            $('#logErr').text( "Username or Password wrong" );
            $('#logUsr').addClass("ui-state-error");
            $('#logPwd').addClass("ui-state-error");
          }

        }
      });
    }
    else{
      updateTips('#logErr',"Username or Password wrong");
      $('#logUsr').addClass("ui-state-error");
      $('#logPwd').addClass("ui-state-error");
    }
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
        $("#regForm").css("display","grid");
    })
    $(".log").click(function(){
        $("#logForm").css("display","grid");
        $("#regForm").hide();
    })


});


/* Nelle query SQL se si può si usano i Prepared Statements in INSERT e in SELECT. Ma se sono query piccole, sono più lenti che usare il mysqli_query o $sqliObj->query, perciò magari si possono invece usare questi due. In questo caso faccio sempre la trim degli input, e poi se sono Integer per validarli bast il cast (int), mentre se sono di tipo String uso mysqli_real_escape_string o $sqliObj->real_escape_string e bisogna ricordarsi di passarli alle query come stringhe,cioè di usare gli apici ''.
   
  Esempio di SELECT: $sqlQuery = "SELECT * FROM Table WHERE someField='" . $someVar "'"; */

/* Quando in PHP si usa la funzione header(), che sia per veri header della chiamata o che sia per fare un redirect con header('Location: URL'), non ci deve essere niente in output prima. Niente HTML e niente righe vuote. Poichè appena c'è un output gli header vengono impacchettati, inviati e non sono più modificabili. Perciò si usa ob_start e ob_flush / ob_end_flush per mandare tutto al buffer e poi inviare tutti i dati insieme. Esiste anche ob_end_clean che butta via tutto quello che c'è nel buffer ed è utile se vuoi evitare echo indesiderati prima di quelli che ti aspetti. */