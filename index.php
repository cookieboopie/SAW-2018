<?php 
	session_start();
	$id_value = null;
	
	//varname e' l'id dell'utente loggato.
	if(isset($_SESSION['varname'])){
		$id_value= $_SESSION['varname']; //se e' loggato prendo il suo valore es. id_value = 3
  }


  //controlla se nel pc (lato client) sia presente un cookie con campo 'token' se si si collega al db e fa un piccolo check, per vedere se esiste un utente che abbia proprio quel token. Se si allora ti logga in automatico dando il valore dell'ID associato al cookie a $id_value. con la sessione qua sopra non so come interagire. Cioè se sei già loggato e torni alla home, ma non avevi messo il remember, con la sessione funziona, se hai messo il remember e sei loggato, torni nella home esegue entrambi gli if, il che non comporta nulla, solo il fatto che id value viene assegnato due volte.
  if(isset($_COOKIE["token"]) && !empty($_COOKIE["token"])){
    require 'assets/dbConn.php';
    $query  = "SELECT ID FROM Users WHERE COOKIE = ?";
    $stmt   = mysqli_prepare($conn,$query);
    mysqli_stmt_bind_param($stmt,"s",$_COOKIE["token"]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $find   = mysqli_num_rows($result);
    $result = $result->fetch_assoc();
    if($find===1){
      $id_value = $result['ID'];
    }

      
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta HTTP-equiv="X-UA-Compatible">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha384-fJU6sGmyn07b+uD1nMk7/iSb4yvaowcueiQhfVgQuD98rfva8mcr1eSvjchfpMrH" crossorigin="anonymous"></script>
    <script src="assets/js/globalFunctions.js"></script>
	
    <link async defer rel="stylesheet" type="text/css" href="assets/css/globalStyle2.css">
    <title>NotTooBed</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template -->
    <link href="css/landing-page.min.css" rel="stylesheet">
    <meta HTTP-equiv="X-UA-Compatible">

</head>

<body>

  <!-- Navigation --> 
  <nav class="navbar navbar-light bg-light static-top">
  <div class="container">
    <!-- Controllo se si e' loggati. In caso positivo mostro bottone profilo, se no mostro bottone login --> 
    <?php if(isset($id_value)){	
      echo '<button class="btn" id="profilo" onclick="window.open(\'profilo.php\',\'_self\')">Profilo</button>'; 
    }else{
      echo '<a class="navbar-brand" href="index.php">NotTooBed!</a>';
    }
    ?>
  
    <?php if(!isset($id_value)){
      echo '<button class="btn btn-primary" id="idContact">Login</button>';
    }else{
      echo '<button class="btn" id="logout" onclick="window.open(\'logout.php\',\'_self\')">Logout</button>'; 
    }
    ?>
  </div>
  </nav>
	
	
  <section class="wrapper">
    <div class="inner">
        
      <div class="formHeader">
          <div class="reg" style="cursor: pointer">Register</div>
          <div class="log" style="cursor: pointer">Login</div>
      </div>

      <div class="formBody">
        <form id="regForm" autocomplete="off">
            <span id="regUsr_err"></span>
            <label for="regUsr">Username </label><input type="text" id="regUsr" name="regUsr">
            
            <span id="regEml_err"></span>
            <label for="regEml">E-mail </label><input type="text" id="regEml" name="regEml">
            
            <span id="regPwd_err"></span>
            <label for="regPwd">Password </label><input type="password" id="regPwd" name="regPwd">
            
            <span id="pwdC_err"></span>
            <label for="pwdC">Conferma Password </label><input type="password" id="pwdC" name="pwdC">
            
            <input type="button" id="regSubmit" class="btn btn-primary" value="Crea Account">
        </form>

        <form id="logForm" autocomplete="off" > 
            <span id="logErr"></span> 

            <label for="logUsr">Username </label><input type="text" id="logUsr" name="logUsr">
            
            <span></span>
            
            <label for="logPwd">Password </label><input type="password" id="logPwd" name="logPwd">

            <span   id="check">
                <input type="checkbox" id="checkB">
                <label id="checkL">Remember Me</label>
            </span>
            
            <input type="button" id="logSubmit" class="btn btn-primary" value="Login">
        </form>
      </div>
      
    </div>
  </section>
	
	

    <!-- Header -->
    <header class="masthead text-white text-center" style="background-size:cover; background-attachment: fixed;background-position: center;background-repeat: no-repeat;background-size: cover">
		<div class="overlay"></div> <!-- DECIDERE SE METTERLO (RENDE OPACA LA FOTO) --> 
			<div class="container" style="position:relative;">
				<div class="row">
					<div class="col-xl-9 mx-auto">
						<h1 class="mb-5">Condividi la tua stanza o cercane una dove alloggiare!</h1>
					</div>
					<div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
						<form action="annunci.php" method="GET">  
							<div class="form-row" style=" padding:2px;">
								<div class="col-sm" id="cityDiv">
									<input  id="myInput" type="text" name="city" class="form-control" placeholder="CITTA'" autocomplete="off" required>
								</div>

								<div class="col-sm">
									<input type="date" id="data1" name="data1" class="form-control" placeholder="" required>
								</div>
								<div class="col-sm">
									<input type="date" id="data2" name="data2" class="form-control" placeholder="" required>
								</div>
								<div class="col-sm">
									<input type="submit" style="cursor:pointer" class="form-control" value="CERCA" onclick="confronto()" >
								</div>
							</div>  
						</form>
					</div>
				</div>
			</div>
    </header>

    <!-- Icons Grid -->
    <section class="features-icons bg-light text-center">
      <div class="container">
        <div class="row">
          <div class="col-lg-4">
            <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
              <div class="features-icons-icon d-flex">
                <i class="icon-screen-desktop m-auto text-primary"></i>
              </div>
              <h3>Informazioni</h3>
              <p class="lead mb-0">Informazioni generali.</p>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
              <div class="features-icons-icon d-flex">
                <i class="icon-layers m-auto text-primary"></i>
              </div>
              <h3>Regolamento</h3>
              <p class="lead mb-0">Regolamento del sito.</p>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="features-icons-item mx-auto mb-0 mb-lg-3">
              <div class="features-icons-icon d-flex">
                <i class="icon-check m-auto text-primary"></i>
              </div>
              <h3>Come usarlo</h3>
              <p class="lead mb-0">Leggi tutte le informazioni su come funziona il nostro sito!</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials text-center bg-light">
      <div class="container">
        <h2 class="mb-5">Cosa dice la gente..</h2>
        <div class="row">
          <div class="col-lg-4">
            <div class="testimonial-item mx-auto mb-5 mb-lg-0">
              <img class="img-fluid rounded-circle mb-3" src="img/testimonial-4.jpg" alt="">
              <h5>Gabil</h5>
              <p class="font-weight-light mb-0">"E' fantastico! Trovo molti gay!"</p>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="testimonial-item mx-auto mb-5 mb-lg-0">
              <img class="img-fluid rounded-circle mb-3" src="img/testimonials-2.jpg" alt="">
              <h5>Giacomo</h5>
              <p class="font-weight-light mb-0">"Ora posso farmi soldi quando rimango da solo senza i miei coinquilini"</p>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="testimonial-item mx-auto mb-5 mb-lg-0">
              <img class="img-fluid rounded-circle mb-3" src="img/testimonials-3.jpg" alt="">
              <h5>Sara</h5>
              <p class="font-weight-light mb-0">"Posso muovermi a basso costo nella varie città!"</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="footer bg-light">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 h-100 text-center text-lg-left my-auto">
            <ul class="list-inline mb-2">
              <li class="list-inline-item">
                <a href="#">About</a>
              </li>
              <li class="list-inline-item">&sdot;</li>
              <li class="list-inline-item">
                <a href="#">Contattaci</a>
              </li>
              <li class="list-inline-item">&sdot;</li>
              <li class="list-inline-item">
                <a href="#">Terms of Use</a>
              </li>
              <li class="list-inline-item">&sdot;</li>
              <li class="list-inline-item">
                <a href="#">Privacy</a>
              </li>
            </ul>
            <p class="text-muted small mb-4 mb-lg-0">&copy; NotTooBed!</p>
          </div>
          <div class="col-lg-6 h-100 text-center text-lg-right my-auto">
            <ul class="list-inline mb-0">
              <li class="list-inline-item mr-3">
                <a href="#">
                  <i class="fa fa-facebook fa-2x fa-fw"></i>
                </a>
              </li>
              <li class="list-inline-item mr-3">
                <a href="#">
                  <i class="fa fa-twitter fa-2x fa-fw"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                  <i class="fa fa-instagram fa-2x fa-fw"></i>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>

<script>

function validation(){
	var nu

}

function page(){
		var link= "https://www.google.it/maps/dir//" + myInput.value;
		document.getElementById("paragrafo").innerHTML = link;
}

function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
	  var newWidth = document.getElementById("myInput").offsetWidth;
	  
	  var stringa = "position:absolute; z-index: +1; background-color:white; width:".concat(newWidth);
	  a.setAttribute("style", stringa );

      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
		  b.setAttribute("style","cursor:pointer;color:black");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
          b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
      });
}

/*An array containing all the country names in the world:*/
var countries = ['Agrigento','Alessandria','Ancona','Aosta','Aquila ','Arezzo','Ascoli Piceno','Asti','Avellino',
'Bari','Belluno','Benevento','Bergamo','Biella','Bologna','Bolzano','Brescia','Brindisi',
'Cagliari','Caltanissetta','Campobasso','Caserta', 'Catania','Catanzaro','Chieti','Como','Cosenza','Cremona','Crotone','Cuneo',
'Enna',
'Ferrara','Firenze','Foggia','Forlì e Cesena','Frosinone',
'Genova','Gorizia','Grosseto',
'Imperia','Isernia',
'La Spezia','Latina','Lecce','Lecco','Livorno','Lodi', 'Lucca',
'Macerata','Mantova','Massa-Carrara','Matera','Messina','Milano','Modena',
'Napoli','Novara','Nuoro',
'Oristano',
'Padova','Palermo','Parma','Pavia','Perugia','Pesaro e Urbino','Pescara','Piacenza','Pisa','Pistoia','Pordenone','Potenza','Prato',
'Ragusa','Ravenna','Reggio Calabria','Reggio Emilia','Rieti','Rimini','Roma','Rovigo',
'Salerno','Sassari','Savona','Siena','Siracusa','Sondrio',
'Taranto','Teramo','Terni','Torino','Trapani','Tre nto','Treviso','Trieste',
'Udine',
'Varese','Venezia','Verbano-Cusio-Ossola','Vercelli','Verona','Vibo Valentia','Vicenza','Viterbo'];

/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
autocomplete(document.getElementById("myInput"), countries);


//Confronta se le due date inserite sono : la prima antecedente della seconda.
function confronto(){
    var x= new Date(data1.value);
    var y= new Date(data2.value);	

    if (y <= x) {
       alert("NON PUOI SCEGLIERE UNA DATA DI CHECKOUT PRECEDENTE O UGUALE AL CHECKIN");
		window.location.href = '/index.html';
        return false;
    }
	

    return true;
}


</script>
