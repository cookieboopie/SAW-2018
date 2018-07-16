<!DOCTYPE html >
<?php

	session_start();
	$_SESSION['varname'] = 9;
	
	if(isset($_POST['lng']) && isset($_POST['lat'])){
		$long = $_POST['lng'];
		$lat = $_POST['lat'];
	}else{
		header("Location: ./profilo.php");
		die();
	}
	
?>
<head>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBoyfZQDXWDpFe7VNraYfMg5zB-W12kP5g&callback=initialize"></script>

	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
	<title>Carica la tua stanza!</title>
	
	<style>
		html,
		body,
		#googleMap {
		  height: 100%;
		  width: 100%;

		}

		#bottone {
			background-color: #4CAF50;
			border: none;
			color: white;
			padding: 15px 32px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 16px;
			margin: 4px 2px;
			cursor: pointer;
		}
    </style>
</head>
<body style="background-color:grey">
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
          <a href="#" class="navbar-brand d-flex align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
            <strong>Annunci</strong>
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        </div>
      </div>
    </header>


	<div class="container">
			<div class="card w-100" >
				<div class="card-body" style="padding:0 !important">
					<div class="card-header" style="text-align:center"> Mappa 
						<p class="card-text">Clicca sulla mappa dove si trova esattamente la tua casa.</p>
					</div>
					<div id="googleMap" style="margin:0; width:100%;height:280px;background:yellow"></div>
				</div>
			</div>
			
		<div class="card text-center" >
			<div class="card-header">
				AGGIUNGI INFORMAZIONI
			</div>
			<form action="position.php" method="POST" enctype="multipart/form-data">
			<div class="card-body">
				<fieldset style="display:none">
			    <div class="form-group">
					<label for="disabledTextInput">Longitudine</label>
					<input type="text" id="lng" name ="lng" class="form-control" placeholder="Disabled input" required>
				</div>
				<div class="form-group">
					<label for="disabledTextInput">Latitudine</label>
					<input type="text" id="lat" name="lat" class="form-control" placeholder="Disabled input" required>
				</div>
				</fieldset>

				<div class="form-group">
					<label for="exampleInputEmail1">Nome della stanza</label>
					<input type="text" class="form-control" name="nameRoom" id="nameRoom" aria-describedby="emailHelp" placeholder="Nome stanza" required>
				</div>
				<div class="form-group">
					<label for="exampleSelect1">Città</label>
					<select class="form-control" name="city" id="exampleSelect1"required>
					</select>
				</div>
				<div class="form-group">
					<label for="example-date-input" >Data checkIn</label>
					<input class="form-control" name="data1"type="date" id="data1"required>
				</div>
				<div class="form-group">
					<label for="example-date-input">Data checkOut</label>
					<input class="form-control" name="data2" type="date" id="data2"required>
				</div>
				<div class="form-group">
					<label for="exampleTextarea">Descrizione della stanza(150 caratteri)</label>
					<textarea class="form-control" name="textArea" id="textArea" rows="3" maxlength="150"required></textarea>
				</div>
				<div class="form-group">
					<label for="exampleInputFile">Foto Copertina</label>
					<p><input type="file"  name="InputFile0" data-max-size="2048" class="form-control-file" id="InputFile0" accept="image/*" aria-describedby="fileHelp" required></p>
					<small id="fileHelp" class="form-text text-muted">Carica la foto principale del tuo annuncio.</small>
									</div>

					<div class="form-group">
					<label for="exampleInputFile">Altre Foto</label>
					<input type="file" name="InputFile1" class="form-control-file" id="InputFile1" accept="image/*" aria-describedby="fileHelp">
					<input type="file" name="InputFile2" class="form-control-file" id="InputFile2" accept="image/*" aria-describedby="fileHelp">
					<small id="fileHelp" class="form-text text-muted">Carica altre due foto della stanza o della casa.</small>
				</div>
				  
				<input type="submit" id="bottone" name="bottone" class="btn btn-primary" onclick="confronto()"value="CARICA STANZA">
			</div>
			</form>

		</div>
	</div>

<script>

var url = null;
var map;
var myCenter = new google.maps.LatLng(<?php echo $lat ?>, <?php echo $long ?>);
var marker;
var infowindow;
var latlng;
function initialize() {
  var mapProp = {
    center: myCenter,
    zoom: 14
  };

  map = new google.maps.Map(document.getElementById("googleMap"), mapProp);

  google.maps.event.addListener(map, 'click', function(event) {
	  latlng=event.latLng;
			var b= null;
			var a= null;
				  /*create a OPTION element for each city:*/
				  
				document.getElementById('lng').value = latlng.lng();
				document.getElementById('lat').value = latlng.lat();


				
    placeMarker(event.latLng);
  });
}

function placeMarker(location) {
  if (!marker || !marker.setPosition) {
    marker = new google.maps.Marker({
      position: location,
      map: map,
    });
  } else {
    marker.setPosition(location);
	
  }
  if (!!infowindow && !!infowindow.close) {
    infowindow.close();
  }
  infowindow = new google.maps.InfoWindow({
    content: 'CASA TUA'

  });
  infowindow.open(map, marker);
	
}
google.maps.event.addDomListener(window, 'load', initialize);


function saveData() {
        url = './position.php?lat=' + latlng.lat() + '&lng=' + latlng.lng()+ '&data1='+data1.value+'&data2='+data2.value+'&textArea='+textArea.value+'&nameRoom='+nameRoom.value;

		location.href = url;
		
        downloadUrl(url, function(data, responseCode) {

          if (responseCode == 200 && data.length <= 1) {
            infowindow.close();
            messagewindow.open(map, marker);
          }
        });
}

function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
          if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request.responseText, request.status);
          }
        };

        request.open('GET', url, true);
        request.send(null);
}

function doNothing () {
}

function autocomplete(arr) {
	for (i = 0; i < arr.length; i++) {
			var b= null;
			var a= null;
				  /*create a OPTION element for each city:*/
				b = document.createElement("OPTION");
				b.innerHTML = arr[i];
			
				a = document.getElementById("exampleSelect1");
				a.appendChild(b);
	}
}
	
function confronto(){
    var x= new Date(data1.value);
    var y= new Date(data2.value);
	
	var longitudine = document.getElementById('lng').value;
	var latitudine = document.getElementById('lat').value;

	
	//controlla se non sono e' stata inserita la posizione nella mappa della casa
	if(longitudine== "" || latitudine == ""){
		alert("Clicca sulla mappa per indicare la posizione della casa!");
	}
	
	//controlla se la data di checkout e' precedente a checkin
    if (y <= x) {
       alert("NON PUOI SCEGLIERE UNA DATA DI CHECKOUT PRECEDENTE O UGUALE AL CHECKIN");
    }
}	
	
	
	
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
'Taranto','Teramo','Terni','Torino','Trapani','Trento','Treviso','Trieste',
'Udine',
'Varese','Venezia','Verbano-Cusio-Ossola','Vercelli','Verona','Vibo Valentia','Vicenza','Viterbo'];	

autocomplete(countries);

</script>
	
	
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>

	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>	
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

</body>
</html>
