<?php

	session_start();

	
	$nameRoom = null;
	
	if(isset($_GET['nameRoom'])){
		$nameRoom = $_GET['nameRoom'];
	}
	$id_casa = null;
	
	if(isset($_GET['id_casa'])){
		$id_casa = $_GET['id_casa'];

	}
	if(isset($_GET['star'])){
		$avgStars= $_GET['star'];
	}
	
	$conn =  mysqli_connect("localhost", "root", "", "testdb");
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$query= "SELECT annunci.id , annunci.data1, annunci.data2, annunci.id_proprietario, annunci.citta, annunci.lat, annunci.longit, review.id_ospite, annunci.testoCasa, review.testo, review.stella FROM annunci LEFT JOIN review ON annunci.id=review.id_casa WHERE annunci.id = '$id_casa' ";
	$result = $conn->query($query);
	$num_results = $result->num_rows;
	
	
	$id_ospite = [];
	$stella = [];
	$testo = [];
	$data = [];
	$longit= null;
	$lat= null;
	$id_host= null;
	$testoCasa= null;
	$data1 = null;
	$data2 = null;

	
	if ($result->num_rows > 0) {
		// output data of each row
		$incr = 0;

		while($row = $result->fetch_assoc()) {
			//echo " RISULTATI QUERY RICERCA <br>ID_OSPITE:".$row["id_ospite"]."  ||  Stella: ". $row["stella"]."  || Testo: ".$row["testo"]." || Lat: ".$row["lat"]." || Testo: ".$row["longit"]."<br>";
			$id_ospite[$incr]= $row["id_ospite"];
			$stella[$incr] = $row["stella"];
			$testo[$incr] = $row["testo"];
			$longit = $row["longit"];
			$lat = $row["lat"];
			$id_host = $row["id_proprietario"];
			$testoCasa = $row["testoCasa"];
			$data1 = $row["data1"];
			$data2 = $row["data2"];

			$incr++;
		}
	} else {
		//echo "0 results";
	}

	//echo $num_results;
$conn->close();

?>
  <script>

function initMap() {
  // The location of Home 44.400732, 8.963052
  var uluru = {lat: <?php echo $lat; ?>, lng:<?php echo $longit; ?>};
  // The map, centered at Uluru
  var map = new google.maps.Map(
      document.getElementById('map'), {zoom: 10, center: uluru});
  // The marker, positioned at Uluru
  var marker = new google.maps.Marker({position: uluru, map: map});
}


  </script>


<!doctype html>
<html lang="en">
  <head>
      

    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha384-fJU6sGmyn07b+uD1nMk7/iSb4yvaowcueiQhfVgQuD98rfva8mcr1eSvjchfpMrH" crossorigin="anonymous"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="icon" href="../../../../favicon.ico">
	<?php require 'indexHeader2.php'; ?>

	
    <title>
        <?php echo $nameRoom; ?>
    </title>
	
    <style>
		.review {
		  border: 2px solid #ccc;
		  background-color: #eee;
		  border-radius: 5px;
		  padding: 16px;
		  margin: 16px 0
		}

		.review::after {
		  content: "";
		  clear: both;
		  display: table;
		}

		.review img {
		  float: left;
		  margin-right: 20px;
		  border-radius: 50%;
		}

		.review span {
		  font-size: 20px;
		  margin-right: 15px;
		}

		@media (max-width: 500px) {
		  .review {
			  text-align: center;
		  }
		  .review img {
			  margin: auto;
			  float: none;
			  display: block;
		  }
		}
				
			
		.classeMia{
			overflow:auto;
			display:grid;
			grid-template-columns: 50% 50%;
			grid-column-gap: 50px;
		}
			
		.d-block.w-100 {
			width: 100%;
			height: 40vw;

		}
        
        .grid_container{
            display:grid;
            grid-template-columns: repeat(24, 1fr);
            grid-template-rows: repeat(24,1fr);
            height:1px;
            /*grid-auto-rows:minmax(1px,auto);/*40px default, but if it goes beyond, it will go in auto mode, stretching every oter columns on the same row.*/
            grid-gap:1em;

        }
        .grid_container > div{
            padding:1em;
           /* background:#eee;*/
        }
        /*.grid_container > div:nth-child(odd){
            background:#ddd;
        }*/
        .slideshow{
            grid-column:1/14;
            grid-row:1/27;
        }
        .prev, .next {
            cursor: pointer;
            padding:8px;
            color: white;
            font-weight: bold;
            font-size: 18px;
            transition: 0.6s ease;
            border-radius: 0 3px 3px 0;
            text-align: center;
            border:1px solid white;
        }
        .prev{
            margin-left:16px;
            grid-column:1;
            grid-row:13;
        }
        .next{
            grid-column:13;
            grid-row:13;
            margin-right:16px;
            border-radius: 3px 0 0 3px;
        }
        .prev:hover, .next:hover {
            opacity: 0.7;
            background-color: black;
        }
        .stars{
            grid-column:14/25;
            grid-row:1;
        }
        .review{
            grid-column:14/25;
            grid-row:2/9;
        }
        .punti{
            margin-left:2em;
            grid-column:1/3;
            grid-row:25;
        }
        .dot { 
            display: inline-block;
            cursor: pointer;
            height: 15px;
            width: 15px;
            margin: 0 2px;
            border: grey solid 1px;
            background-color: rgb(255, 255, 255);
            border-radius: 50%;
            margin-left: 0;
            
            transition: background-color 0.6s ease;
        }

        .active, .dots:hover {
            background-color: #ff0000;     

        }
		#responsive {
			display: inline-block;
			position: relative;
			width: 100%;
			
			background-size: contain;
		}


    </style>

    <title>Profilo casa</title>

    <!-- Bootstrap core CSS -->
    <link href="../../dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="album.css" rel="stylesheet">
  </head>

  <body >

  
  
    <header>
      <div class="collapse bg-dark" id="navbarHeader">
        <div class="container">
          <div class="row">
            <div class="col-sm-4 offset-md-1 py-4">
              <h4 class="text-white">Utente _NOME_</h4>
              <ul class="list-unstyled">
                <li><a href="./profilo.php" class="text-white">Inserisci/Modifica stanza!</a></li>
                <li><a href="./profilo.php" class="text-white">Modifica Profilo</a></li>
                <li><a href="#" class="text-white">Messaggi</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="navbar navbar-dark bg-dark box-shadow">
        <div class="container d-flex justify-content-between">
          <a href="./index.html" class="navbar-brand d-flex align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
            <strong> NotTooBed</strong>
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        </div>
      </div>
    </header>

<main role="main" >
  

	<div class="card" style="border:hidden" >
		<div class="card-body" style="text-align:center;background-color:#f7f7f7">
		<h1 style="font-size:3em;font-family:verdana;margin:0;" ><?php echo $nameRoom ?></h1>
		</div>
	</div>

		  
		  
		  
		            	         <div class="album py-5 bg-light"  >

		  
	<div class="container" >
        <div class="container">
			<div class="row" >
				<div class="col-md-8">
					<div class="card bg-light mb-3" style="max-width: 50rem;" >
						<div class="card-body" style="position:static; padding:0px !important">
						<div id="carouselExampleControls" class="carousel slide" data-ride="carousel" >
								<div class="carousel-inner">
									<div class="carousel-item active">
										<img class="d-block w-100" style="width:100%"src="uploads\<?php echo $id_host ?>\0.jpg" alt="First slide">
									</div>
									<div class="carousel-item">
										<img class="d-block w-100" src="dovizioso.png" alt="Second slide">
									</div>
									<div class="carousel-item">
										<img class="d-block w-100" src="sentiero.jpg" alt="Third slide">
									</div>
							  </div>
							<a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
							<span class="carousel-control-prev-icon" aria-hidden="true"></span>
							<span class="sr-only">Previous</span>
							</a>
							<a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
							<span class="carousel-control-next-icon" aria-hidden="true"></span>
							<span class="sr-only">Next</span>
							</a>
						</div>
					</div>
				</div>
				<div class="card text-center">
					<div class="card-header">Informazioni della stanza</div>
					<div class="card-body">
						<h5 class="card-title"><?php echo $nameRoom; ?></h5>
						<p class="card-text"><?php echo $testoCasa ?></p>
						<?php 
						if(isset($id_value)){ 
							echo '<button class="btn btn-primary" id="sendRequest" style="white-space: normal;">Invia una richiesta!</button>';
						}else{
							echo '<button class="btn btn-primary" id="idContact" style="white-space: normal;">Login per contattare!</button>';
						} ?>
						<div id="name-data"></div>  
					</div>
				</div>
				<br>
			</div>
			<div class="col-md-4">
				<ul class="list-group list-group-flush" style="list-style-type: none;">
					<li>
						<div style="left:0px;"><div class="card w-100">
							<div class="card-body" style="padding:0 !important">
								<div class="card-header" style="text-align:center"> Mappa </div>
									<div id="map" style="margin:0; width:100%;height:280px;background:yellow"</div>
					  
					  </div>
</div>
</div>
</div>
			</li>

			<li>
				<br>
			</li>

			<li style="top:10px">

	
			
			
			
            <div style="left:0px;"><div class="card w-100">
			  <div class="card-header" style="text-align:center"> Recensioni </div>
  <div class="card-body">
    
		<p class="card-text">Questa casa <?php if($avgStars== "null"){ echo "non ha recensioni";}else{ echo "ha una media di: $avgStars stelle";}?></p>
			<div id="recensioni" class="">


				<script type="text/javascript">
						creaElementi(); //CREA DIV DINAMICAMENTE 
					</script>
				
			</div>
				<?php if($num_results>3){
					echo '<a href="#" class="btn btn-primary">Vedi altro</a>'; 
				}?>
  </div>
</div>
</div>



			</li>

</ul>
          </div>

        </div>

        <hr>

      </div> 
        </div>
      </section>

     	</div>
					<!---  QUESTO PEZZO SAREBBE IL LOGIN!! ESCE SOLO QUANDO NON SEI LOGGATO--->
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
                            
                            <input type="button" id="regSubmit" style="white-space: normal;" class="btn btn-primary" value="Crea Account">
                        </form>

                        <form id="logForm" autocomplete="off" > 
                            <span id="logErr"></span> 

                            <label for="logUsr">Username </label><input type="text" id="logUsr" name="logUsr">
                            
                            <span></span>
                            
                            <label for="logPwd">Password </label><input type="password" id="logPwd" name="logPwd">

                            <input type="button" id="logSubmit" style="white-space: normal;" class="btn btn-primary" value="Login">
                        </form>
                    </div>
                </div>
            </section>
		
		
    </main>




    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="../../assets/js/vendor/popper.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script src="../../assets/js/vendor/holder.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBoyfZQDXWDpFe7VNraYfMg5zB-W12kP5g&callback=initMap"></script>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>

<script>

		$(document).ready(function(){
			$('#sendRequest').click(function(){
				var id_house = <?php echo json_encode($id_casa); ?>;
				var guest = <?php echo json_encode($id_value); ?>;
				var data1 = <?php echo json_encode($data1); ?>;
				var data2 = <?php echo json_encode($data2); ?>;
				var host = <?php echo json_encode($id_host); ?>;

				var varData = 'id_house='+id_house+'&guest='+guest+'&data1='+data1+'&data2='+data2+'&id_host='+host;

				$.ajax({
					type: 'POST',
					url:'queries.php',
					data: varData,
					success: function(result){
					  if(result==="ok"){
						alert("Richiesta inviata correttamente!");
					  }
					  else{
						alert("Ci sono problemi, riprova piu tardi!");
					  }
					}
					
				});
			});
			
		});
		



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
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
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
'Bari','Belluno','Benevento','Bergamo','Biella','B ologna','Bolzano','Brescia','Brindisi',
'Cagliari','Caltanissetta','Campobasso','Caserta', 'Catania','Catanzaro','Chieti','Como','Cosenza','C remona','Crotone','Cuneo',
'Enna',
'Ferrara','Firenze','Foggia','Forlì e Cesena','Frosinone',
'Genova','Gorizia','Grosseto',
'Imperia','Isernia',
'La Spezia','Latina','Lecce','Lecco','Livorno','Lodi', 'Lucca',
'Macerata','Mantova','Massa-Carrara','Matera','Messina','Milano','Modena',
'Napoli','Novara','Nuoro',
'Oristano',
'Padova','Palermo','Parma','Pavia','Perugia','Pesa ro e Urbino','Pescara','Piacenza','Pisa','Pistoia','Por denone','Potenza','Prato',
'Ragusa','Ravenna','Reggio Calabria','Reggio Emilia','Rieti','Rimini','Roma','Rovigo',
'Salerno','Sassari','Savona','Siena','Siracusa','S ondrio',
'Taranto','Teramo','Terni','Torino','Trapani','Tre nto','Treviso','Trieste',
'Udine',
'Varese','Venezia','Verbano-Cusio-Ossola','Vercelli','Verona','Vibo Valentia','Vicenza','Viterbo'];

/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
autocomplete(document.getElementById("myInput"), countries);


            var slideIndex = 1;
            showSlides(slideIndex);
    
            function plusSlides(n) {
            showSlides(slideIndex += n);
            }
    
            function currentSlide(n) {
                showSlides(slideIndex = n);
            }
    
            function showSlides(n) {
                var i;
                var slides = document.getElementsByClassName("mySlides");
                var dots = document.getElementsByClassName("dot");
                if (n > slides.length) {slideIndex = 1}    
                if (n < 1) {slideIndex = slides.length}
                for (i = 0; i < slides.length; i++) {
                    slides[i].style.display = "none";  
                }
                for (i = 0; i < dots.length; i++) {
                    dots[i].className = dots[i].className.replace(" active", "");
                }
                slides[slideIndex-1].style.display = "block";  
                dots[slideIndex-1].className += " active";
            }



			

		//aggiunge elementi recensioni
		function aggiungiElemento(id, testo, stella) {
			
			var flexContainer0 = null;
			var newElement0 = null;			
			
			newElement0 = document.createElement("div");
			newElement0.className = "review";
			newElement0.innerHTML = "<img src=\"casa.jpg\" alt=\"Avatar\" style=\"width:90px\">".concat("<p><span>").concat("Giovanni"+" ✰:"+stella).concat("</span></p><p>").concat(testo).concat("</p>");
			
			// aggiunge l'elemento appena creato e il suo contenuto al DOM
			flexContainer0 = document.getElementById("recensioni");
			flexContainer0.appendChild(newElement0);			
		
		}

		function creaElementi() {
			var i;
			var num_result = <?php echo $num_results; ?>;
			
			var id_ospite = <?php echo json_encode($id_ospite); ?>;
			var testo = <?php echo json_encode($testo); ?>;
			var data = <?php echo json_encode($data); ?>;
			var stella = <?php echo json_encode($stella); ?>;
			for (i = 0; i < num_result; i++) { 
				if(stella[i] != null){
				aggiungiElemento(id_ospite[i],testo[i],stella[i]);
				}
			}
			
		}
		

</script>
	
	
	
 </body>
</html>

<style>

.btn.btn-secondary{
	
 background:green;
}
.btn.btn-secondary:hover{
	 background:blue;
}

</style>