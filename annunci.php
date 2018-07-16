<?php

	session_start();
	$id_value = null;
	$myName = null;
	
	if(isset($_SESSION['varname'])){
		$id_value= $_SESSION['varname'];
	}
	if(isset($_SESSION['myName'])){
		$myname= $_SESSION['myName'];
	}



	//Prendo valori della ricerca.
	$city = $_GET['city'];
	$data1 = $_GET['data1'];
	$data2 = $_GET['data2'];
//echo $city." ".$data1." ".$data2;

	//Se la data di checkout e' precedente a quella di checkin torna alla home page.
    if ($data2 <= $data1) {
	    header("Location: ./index.html");
		die();
    }else{ 
		$conn =  mysqli_connect("localhost", "root", "", "testdb");
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}

		$sq1 = "SELECT annunci.titolo, annunci.path, stelle.stelle, annunci.id, annunci.id_proprietario FROM stelle RIGHT JOIN annunci ON stelle.id=annunci.id WHERE annunci.citta='$city'";
		$result = $conn->query($sq1);
		$num_results = $result->num_rows;
		
		//Dichiaro variabili che conterranno i dati delle stanze trovate
		$ids = [];
		$titles = [];
		$paths = [];
		$stelle = [];
		$id_proprietario = [];
		

		if ($result->num_rows > 0) {
			//Inizializzo contattore per salvataggio dati dal db
			$incr = 0;
			while($row = $result->fetch_assoc()) { //salvo tutti i dati trovati
				$titles[$incr]= $row["titolo"];
				$paths[$incr] = $row["path"];
				$stelle[$incr] = $row["stelle"];
				$ids[$incr] = $row["id"];
				$id_proprietario[$incr] = $row["id_proprietario"];
				
				$incr++;

			}
		} else {
			echo "0 results"; // DA TOGLIERE!!!!
		}

		$conn->close();
}

?>

<script type="text/javascript">

		function aggiungiElemento(elementName, tito, id_host, star, id) {
			
			var flexContainer0 = null;
			var newElement0 = null;			
			var flexContainer = null;
			var newElement = null;
			var flexContainer1 = null;
			var newElement1 = null;
			var flexContainer2 = null;
			var newElement2 = null;
			var flexContainer3 = null;
			var newElement3 = null;
			
			var urlProfiloRoom ="('./get.php?nameRoom="+tito+"&id_casa="+id+"&id_prop="+id_host+"&star="+star+"')\"";

			newElement0 = document.createElement("div");
			newElement0.className = "col-md-4";
			newElement0.id = "extern00".concat(elementName);
			//newElement.onclick = cambiaSfondo;

			// aggiunge l'elemento appena creato e il suo contenuto al DOM
			flexContainer0 = document.getElementById("DivStart0");
			flexContainer0.appendChild(newElement0);			
			
			newElement = document.createElement("div");
			newElement.innerHTML = "<img class=\"card-img-top\" src=\"uploads/".concat(id_host).concat("/0.jpg\"").concat("\" alt=\"Card image cap\" height=\"235\" width=\"288\" >");
			newElement.className = "card mb-4 box-shadow";
			newElement.id = "extern0".concat(elementName);
			//newElement.onclick = cambiaSfondo;

			// aggiunge l'elemento appena creato e il suo contenuto al DOM
			flexContainer = document.getElementById("extern00".concat(elementName));
			flexContainer.appendChild(newElement);
			
			newElement1 = document.createElement("div");
			newElement1.innerHTML = "<p class=\"card-text\"><strong>".concat(tito).concat("</strong></p>");
			newElement1.className = "card-body";
			newElement1.id = "intern1".concat(elementName);
			
			// aggiunge l'elemento appena creato e il suo contenuto al DOM
			flexContainer1 = document.getElementById("extern0".concat(elementName));
			flexContainer1.appendChild(newElement1);

			newElement2 = document.createElement("div");
			newElement2.className = "d-flex justify-content-between align-items-center";
			newElement2.id = "intern2".concat(elementName);
			
			// aggiunge l'elemento appena creato e il suo contenuto al DOM
			flexContainer2 = document.getElementById("intern1".concat(elementName));
			flexContainer2.appendChild(newElement2);
			
			newElement3 = document.createElement("div");
			newElement3.innerHTML = "<form ><button type=\"button\" class=\"btn btn-sm btn-outline-secondary\">".concat(generaStelle(star)).concat("</button>").concat("<input onclick=\"window.open").concat(urlProfiloRoom).concat(" value=\"vedi\" type=\"button\" class=\"btn btn-sm btn-outline-secondary\">").concat("</form>"); /*funzionerà? so mica METTI TITOLO CASA !!!*/ 
			newElement3.className = "btn-group";
			newElement3.id = "intern3".concat(elementName);
			
			
			// aggiunge l'elemento appena creato e il suo contenuto al DOM
			flexContainer3 = document.getElementById("intern2".concat(elementName));
			flexContainer3.appendChild(newElement3);
			
		}
		

		
		function creaElementi() {
			var i;
			var num_result = <?php echo $num_results; ?>;
			
			var tempArray = <?php echo json_encode($titles); ?>;
			var tempArrayP = <?php echo json_encode($paths); ?>;
			var tempArrayS = <?php echo json_encode($stelle); ?>;
			var tempArrayI = <?php echo json_encode($ids); ?>;
			var tempArrayHost = <?php echo json_encode($id_proprietario); ?>; 
			
			for (i = 0; i < num_result; i++) {
				//funzione modifica stelle.
				//var stelleTotali= generaStelle(tempArrayS[i]);
    			aggiungiElemento(i, tempArray[i], tempArrayHost[i], tempArrayS[i], tempArrayI[i]);
			}
		}

		//funzione che mi generea stringhe contenenti il numero delle stelle di ogni stanza.
		function generaStelle(stellaCasa){
			if(stellaCasa=="1"){
				return "☆ Stella";
			}else if(stellaCasa=="2"){
				return "☆☆ Stelle";
			}else if(stellaCasa=="3"){
				return "☆☆☆ Stelle";
			}else if(stellaCasa=="4"){
				return"☆☆☆☆ Stelle";
			}else if(stellaCasa=="5"){
				return "☆☆☆☆☆ Stelle";
			}
			return "0 Recensioni";
		}
</script>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>Risultati ricerca</title>

    <!-- Bootstrap core CSS -->
    <link href="../../dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="album.css" rel="stylesheet">
  </head>

<body style="background-color:#f7f7f7">

    <header >
	
      <div class="collapse bg-dark" id="navbarHeader" >
        <div class="container"  >
          <div class="row">
            <div class="col-sm-4 offset-md-1 py-4">
				<h4 class="text-white"> 
					<?php 
						if(isset($myname)){
							echo 'Ciao '.$myname.'!</h4> 
							<ul class="list-unstyled">
								<li><a href="./profilo.php" class="text-white">•Inserisci/Modifica stanza!</a></li>
								<li><a href="./profilo.php" class="text-white">•Modifica Profilo</a></li>
								<li><a href="#" class="text-white">•Messaggi</a></li>
								</ul>';
						}else{
							echo 'Benvenuto Ospite!</h4>              
									<ul class="list-unstyled">
										<li><a href="./profilo.php" class="text-white">•Registrati!</a></li>
									</ul>';
						}								
					?>
				
            </div>
          </div>
        </div>
      </div>
      <div class="navbar navbar-dark bg-dark box-shadow" >
        <div class="container d-flex justify-content-between" >
          <a href="./index.html" class="navbar-brand d-flex align-items-center" >
            <strong>Annunci</strong>
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
            <span  class="navbar-toggler-icon"></span>
          </button>
        </div>
      </div>
    </header>



	<section class="jumbotron text-center" style="background-image: <?php echo "url('./img/".$city.".jpg')" ?>; background-size:cover; background-attachment: fixed;background-position: center;background-repeat: no-repeat;background-size: cover;"> 

		<h1 class="jumbotron-heading" style="font-size:4em"><?php echo $city ?> </h1>
          
		  <?php if($data2 > $data1)
					echo '<p ><a  target="_blank" rel="noopener noreferrer" href="https://www.google.com/maps?q='.$city.'&oe=utf-8&client=firefox-b-ab&um=1&ie=UTF-8&sa=X&ved=0ahUKEwjs77eIg5fcAhXN2qQKHYL7CRgQ_AUICygC" class="btn btn-primary my-2">ESPLORA CITTA</a> <a href="./index.html" class="btn btn-secondary my-2">MODIFICA RICERCA</a></p>' ;
								
				if(!$city)
					echo'<p>CITTA\' NON INSERITA.<br><a href="./index.html" class="btn btn-primary my-2">CAMBIA DATE</a></h5>'
			?>
          
	</section>

    <div class="album py-5 bg-light" style="border-radius:10px"  >

        <div class="container" >
          <div class="row"id="DivStart0" >
					<script type="text/javascript">
						creaElementi(); //CREA DIV DINAMICAMENTE 
					</script>
          </div>
        </div>      

	</div>


    <footer class="text-muted">
      <div class="container">
	  
        <div class="row">
          <div class="col-md-4">
            <h2>Informazioni</h2>
            <p>Qui metteremo qualcosa</p>
            <p><a id="bottone" class="btn btn-secondary" href="#" role="button">Vedi info &raquo;</a></p>
          </div>
          <div class="col-md-4">
            <h2>Regolamento</h2>
            <p >Link al regolamento </p>
            <p><a class="btn btn-secondary" href="#" role="button">Regolamento &raquo;</a></p>
          </div>
          <div class="col-md-4">
            <h2>Dona</h2>
            <p>Donec sed odio dui.</p>
            <p><a class="btn btn-secondary" href="#" role="button">PayPal &raquo;</a></p>
          </div>
        </div>

        <hr>

      </div> <!-- /container -->
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>

	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
  </body>
</html>

<style>

.btn.btn-secondary{
	
 background:green;
}
.btn.btn-secondary:hover{
	 background:grey;
}

</style>
