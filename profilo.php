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

	//SE NON SEI LOGGAto non entra in questa pagina
    if (!isset($id_value)) {
	    header("Location: ./index.php");
		die();

    }else{
		require 'assets/dbConn.php';
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		$sql = "SELECT id, titolo, citta, testoCasa FROM annunci WHERE id_proprietario='$id_value';";
		$sql .="SELECT request.host, request.guest, request.data1, request.data2, request.id_casa, accounts.username FROM request JOIN accounts ON request.guest=accounts.id WHERE accettazione=true AND hostReview=false AND host='$id_value';";
		$sql .="SELECT request.host, request.guest, request.data1, request.data2, request.id_casa, accounts.username FROM request JOIN accounts ON request.host=accounts.id WHERE accettazione=true AND guestReview=false AND guest='$id_value';";
		$sql .="SELECT  request.data1, request.data2, accounts.USERNAME FROM accounts JOIN request ON request.guest=accounts.ID WHERE request.host = '$id_value';";
		
		
		
		//Prima query variabili
		$idCasa;
		$titolo;
		$citta;
		$testoCasa;
		//Seconda query variabili
		$hostH= [];
		$guestH= [];
		$data1H= [];
		$data2H = [];
		$id_houseH = [];
		$usernameGuestH= [];
		//terza query variabili
		$hostG= [];
		$guestG= [];
		$data1G= [];
		$data2G = [];
		$id_houseG = [];
		$usernameHostG = [];
		//quarta query variabili
		$data1Req = [];
		$data2Req = [];
		$usernameGuest = [];
		
		
		
		if (mysqli_multi_query($conn,$sql)){
			//RISULTATO PRIMA QUERY (SALVATAGGIO)
			if ($result=mysqli_store_result($conn)) {
				  // Fetch one and one row
				  $num_results = $result->num_rows;
				  while ($row=mysqli_fetch_row($result)){
					$idCasa= $row[0];
					$titolo = $row[1];
					$citta = $row[2];
					$testoCasa= $row[3];				  }
				  // Free result set
				  mysqli_free_result($result);
			}
			
			//PASSO ALL'ALTRA QUERY
			mysqli_next_result($conn);

			if ($result=mysqli_store_result($conn)) {
				  // Fetch one and one row
					$increm=0;
					$num_resultsHost = $result->num_rows;			
				  while ($row=mysqli_fetch_row($result)){
					$hostH[$increm]= $row[0];
					$guestH[$increm]= $row[1];
					$data1H[$increm]= $row[2];
					$data2H[$increm] = $row[3];
					$id_houseH[$increm] = $row[4];
					$usernameGuestH[$increm] = $row[5];
					$increm++;
				  }

				  // Free result set
				  mysqli_free_result($result);
			}

			//PASSO ALL'ALTRA QUERY
			mysqli_next_result($conn);
			
			//RISULTATI SECONDA QUERY
		   if ($result=mysqli_store_result($conn)) {
					  // Fetch one and one row
					  $num_resultsGuest = $result->num_rows;
						$increm=0;
					  while ($row=mysqli_fetch_row($result)){
						$hostG[$increm]= $row[0];
						$guestG[$increm]= $row[1];
						$data1G[$increm]= $row[2];
						$data2G[$increm] = $row[3];
						$id_houseG[$increm] = $row[4];
						$usernameHostG[$increm] = $row[5];

						$increm++;						  
						  
					  }
					  // Free result set
					  mysqli_free_result($result);
				}
				
				
			//PASSO ALL'ALTRA QUERY
			mysqli_next_result($conn);
			//RISULTATI TERZA QUERY
		   if ($result=mysqli_store_result($conn)) {
					  // Fetch one and one row
					  $num_results4 = $result->num_rows;
						$increm=0;
					  while ($row=mysqli_fetch_row($result)){
						$data1Req[$increm]= $row[0];
						$data2Req[$increm]= $row[1];
						$usernameGuest[$increm]= $row[2];
						$increm++;						  
						  
					  }
					  // Free result set
					  mysqli_free_result($result);
				}
			
		}
		
		
		
			if(!empty($id_houseG[0])){
				$_SESSION['id_house'] = $id_houseG[0];
			}
			if(!empty($data2G[0])){
				$_SESSION['dataReviewGuest'] = $data2G[0];
			}
			if(!empty($data2H[0])){
				$_SESSION['dataReviewHost'] = $data2H[0];		
			}			

		$conn->close();
	

}

?>




<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">


    <link rel="icon" href="../../../../favicon.ico">

    <title>Profilo|Casa|Messaggi</title>

    <!-- Bootstrap core CSS -->
    <link href="../../dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="album.css" rel="stylesheet">
  </head>

  <body>

    <header>
      <div class="collapse bg-dark" id="navbarHeader">
        <div class="container">
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
	  
      <div class="navbar navbar-dark bg-dark box-shadow">
        <div class="container d-flex justify-content-between">
          <a href="#" class="navbar-brand d-flex align-items-center">
            <strong>Profilo</strong>
          </a>
          <button class="navbar-toggler" type="button"style="white-space: normal;" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        </div>
      </div>
    </header>

    <main role="main" style="background-color:#f7f7f7">
	   

      <section class="jumbotron text-center" style="background-image: <?php echo "url('./img/bg-masthead.jpg')" ?>; background-size:cover; height:40%; background-attachment: fixed;background-position: center;background-repeat: no-repeat;background-size: cover;"> 
      </section>

	  				<div class="card text-center">
					<div class="card-header" style="background-color: grey">Modifica Profilo</div>
					<div class="card-body">
					
<div class="container">
					
<div id="accordion">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h5 class="mb-0">
        <button class="btn btn-link" style="white-space: normal;" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">MODIFICA PASSWORD</button>
      </h5>
    </div>

    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
      <div class="card-body">
	  <form>
				<div class="form-group">
					<label for="formGroupExampleInput">Vecchia Password</label>
					<input type="text" class="form-control" id="formGroupExampleInput" placeholder="Inserisci la password">
				</div>
				<div class="form-group">
					<label for="formGroupExampleInput2">Nuova Password</label>
					<input type="text" class="form-control" id="formGroupExampleInput2" placeholder="Inserisci la nuova password">
				</div>
				<div class="form-group">
					<label for="formGroupExampleInput2">Conferma Nuova Password</label>
				<input type="text" class="form-control" id="formGroupExampleInput2" placeholder="Inserisci ancora la nuova password">
				</div>
				<div>
					<input type="submit" style="white-space: normal;" class="btn btn-primary" id="submitPw" value="Aggiorna Password!">
				</div>
			</form>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" style="white-space: normal;" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">MODIFICA PROFILO</button>
      </h5>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
      <div class="card-body">
	  <form>
				<div class="form-group">
				<div class="text-center">
          <img src="uploads\<?php echo $id_value ?>\0.jpg" style="border-radius: 20%;width:90px" class="avatar img-circle" alt="Avatar">
          <h6>Carica nuova foto profilo...</h6>
          
          <input class="form-control" type="file">
        </div>
				</div>
				<div class="form-group">
					<label for="formGroupExampleInput2">Aggiungi una descrizione..</label>
					<textarea type="text" class="form-control" rows="3" style="resize:none"maxlength="100" id="formGroupExampleInput2" ><?=$titolo?></textarea>
				</div>
				<div>
					<label for="formGroupExampleInput2">Modifica Email</label>
					<input type="text" class="form-control" id="submitEmail" placeholder="email@email.it">
				</div>
				<div>
					<label for="formGroupExampleInput2">Citta'</label>
					<input type="text" class="form-control" id="submitCity" placeholder="Inserisci citta'.."><br>
				</div>			
				<div>
					<input type="submit" style="white-space: normal;" class="btn btn-primary" id="submitPw" value="Aggiorna Profilo!">
				</div>
				
			</form>
      </div>
    </div>
  </div>
  
</div>
					</div>
									</div>

				</div>
				
				
				
<?php if($num_results4!=0){
echo '	
<div class="card text-center">
	<div class="card-header" style="background-color: grey;">Richieste da ospiti!</div>
		<div class="card-body">				
			<div class="container">					
				<div id="accordion">
					<div class="card">
						<div class="card-header" id="headingOne">
							<h5 class="mb-0">
							<button class="btn btn-link" style="white-space: normal;color:red" data-toggle="collapse" data-target="#collapseRequest" aria-expanded="false" aria-controls="collapseRequest">('.$num_results4.'!) NUOVE RICHIESTE </button>
							</h5>
						</div>
						<div id="collapseRequest" class="collapse" aria-labelledby="headingRequest" data-parent="#accordion">
							<div class="card-body">
								<h3 class="mb-0">Hai una nuova richiesta da '.$usernameGuest[0].' </h3>
								<p class="mb-0">Per le date dal '.$data1Req[0].' al '.$data2Req[0].'</p><br>
								<form action="" method="POST">
								<input type="submit" style="white-space: normal;" class="btn btn-primary" id="accettaRequest" value="Accetta!">
								</form>
								<a href="profilo.php?id=xxx" id="accettaRequest">Vedi '.$usernameGuest[0].'</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>';} ?> 
				
								
				
				
				
				
				
				
				
				
				



<div class="card text-center">
					<div class="card-header" style="background-color: grey">Recensioni</div>
					<div class="card-body"><?php if($num_resultsHost== 0 && $num_resultsGuest== 0){ echo '<label>Non hai recensioni da lasciare.</label>';}else{ echo'
					
<div class="container">
					
<div id="accordion">';} ?>
<?php if($num_resultsHost!= 0){
	echo '
  <div class="card">
    <div class="card-header" id="headingRev">
      <h5 class="mb-0">
        <button class="btn btn-link" style="white-space: normal;"data-toggle="collapse" data-target="#collapseReview" aria-expanded="false" aria-controls="collapseReview">Recensione come Host</button>
      </h5>
    </div>

    <div id="collapseReview" class="collapse" aria-labelledby="headingRev" data-parent="#accordion">
      <div class="card-body">  
	  
		<div class="card" >
		  <div class="card-header">Recensione per '.$usernameGuestH[0].'</div>
		  <ul class="list-group list-group-flush">
			<li class="list-group-item">Dal '.$data1H[0].' al '.$data2H[0].' </li>
			<li class="list-group-item">
				  <form action="hostsReview.php" method="POST">
				<div class="form-group">
					<label for="formGroupExampleInput">Lascia la recensione al tuo ospite.. </label>
					<textarea type="text" style="resize:none" rows="3" class="form-control" name="textReviewHost" id="textReviewHost" placeholder="Inserisci recensione.."></textarea>
				</div>
				<div class="form-group">
					<label for="formGroupExampleInput2">Stelle complessive.</label>
					    <select class="form-control" name="starReviewHost" id="starReviewHost">
						  <option>1</option>
						  <option>2</option>
						  <option>3</option>
						  <option>4</option>
						  <option>5</option>
						</select>
				</div>
				<div>
					<input type="submit" style="white-space: normal;" class="btn btn-primary" id="submitReviewHost" value="Invia Recensione!">
				</div>
			</form>
		  </ul>
		</div>
	  

      </div>
    </div>
  </div>
</div>';} ?> 


  
<?php if($num_resultsGuest!= 0){
	echo '
  <div class="card">
    <div class="card-header" id="headingRevGuest">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" style="white-space: normal;"data-toggle="collapse" data-target="#collapseReviewGuest" aria-expanded="false" aria-controls="collapseReviewGuest">Recensione come ospite</button>
      </h5>
    </div>
    <div id="collapseReviewGuest" class="collapse" aria-labelledby="headingRevGuest" data-parent="#accordion">
      <div class="card-body">
		<div class="card" >
		  <div class="card-header">Recensione per la casa di '.$usernameHostG[0].'  </div>
		  <ul class="list-group list-group-flush">
			<li class="list-group-item">Dal '.$data1G[0].' al '.$data2G[0].' </li>
			<li class="list-group-item">
				<form action="guestsReview.php" method="POST">
				<div class="form-group">
					<label for="formGroupExampleInput">Lascia la recensione alla casa.. </label>
					<textarea type="text" style="resize:none" rows="3" class="form-control" name="textReviewGuest" id="textReviewGuest" placeholder="Inserisci recensione.."></textarea>
				</div>
				<div class="form-group">
					<label for="formGroupExampleInput2">Stelle complessive casa.</label>
					    <select class="form-control" name="starReviewGuest" id="starReviewGuest">
						  <option>1</option>
						  <option>2</option>
						  <option>3</option>
						  <option>4</option>
						  <option>5</option>
						</select>
				</div>
				<div>
					<input type="submit" style="white-space: normal;" class="btn btn-primary" id="submitReviewGuest" value="Invia Recensione!">
				</div>
			</form>
		  </ul>
		</div>
      </div>
    </div>
  </div>
  
  </div>';} ?>
					</div>
									</div>

				</div>	'			
				
				</div>				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
<div class="card text-center">
					<div class="card-header" style="background-color: grey">AGGIUNGI STANZA</div>
					<div class="card-body">
<div class="container">
					
<div id="accordion">

<?php if($num_results ==0){
	echo '
  <div class="card">
    <div class="card-header" id="headingTre">
      <h5 class="mb-0">
        <button class="btn btn-link" style="white-space: normal;" data-toggle="collapse" data-target="#collapseTre" aria-expanded="false" aria-controls="collapseTre">INSERISCI VIA</button>
      </h5>
    </div>

    <div id="collapseTre" class="collapse" aria-labelledby="headingTre" data-parent="#accordion">
      <div class="card-body">
	        <div class="container">
			

	  
      <div id="pac-container" >

	  	<div class="form-group">
	  	  	<form action="map.php" method="POST">
		<fieldset style="display:none">
			    <div class="form-group">
					<label for="disabledTextInput">Longitudine</label>
					<input type="text" id="lng" name ="lng" class="form-control" placeholder="Disabled input">
				</div>
				<div class="form-group">
					<label for="disabledTextInput">Latitudine</label>
					<input type="text" id="lat" name="lat" class="form-control" placeholder="Disabled input">
				</div>
				</fieldset>
				<div class="form-group">
				<input id="pac-input" class="form-control" type="text" placeholder="Inserisci la via della casa..">
				    </div>
			   </div>
				<div class="form-group">

			<input type="submit" class="btn btn-primary" id="submitCity" value="Aggiungi Stanza!">
	        </div>
		   </div>

			</form>

		</div>

	 
    </div>
	</div>


	
    <div id="map" style="display:none"></div>
    <div id="infowindow-content">
      <img src="" width="16" height="16" id="place-icon">
      <span id="place-name"  class="title"></span><br>
      <span id="place-address"></span>


    </div>
</div>';}else{ echo '
  <div class="card">
    <div class="card-header" id="headingQuattro">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed"style="white-space: normal;" data-toggle="collapse" data-target="#collapseTre" aria-expanded="false" aria-controls="collapseTre">SCEGLI NUOVE DATE</button>
      </h5>
    </div>
    <div id="collapseTre" class="collapse" aria-labelledby="headingTre" data-parent="#accordion">
      <div class="card-body">
	  <div class="card-group">
  <div class="card">
    <img class="card-img-top" src="./forest.jpg" height="235" width="288"  alt="Card image cap">
    <div class="card-body">
      <h5 class="card-title">Foto1</h5>
      <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
    </div>
  </div>
  <div class="card">
    <img class="card-img-top" src="./sentiero.jpg" height="235" width="288"  alt="Card image cap">
    <div class="card-body">
      <h5 class="card-title">Foto2</h5>
      <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
    </div>
  </div>
  <div class="card">
    <img class="card-img-top" src="./casa.jpg" height="235" width="288" alt="Card image cap">
    <div class="card-body">
      <h5 class="card-title">Foto3</h5>
      <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
    </div>
  </div>
</div>
<div class="card">
  <div class="card-body">
      <p><?php echo $testoCasa ?></p>
  </div>
</div>
	  <form method="POST" action="updateHome.php">
				<div class="form-group">
					<label for="example-date-input" >Data checkIn</label>
					<input class="form-control" name="data1"type="date" id="data1"required>
				</div>
				<div class="form-group">
					<label for="example-date-input">Data checkOut</label>
					<input class="form-control" name="data2" type="date" id="data2"required>
				</div>
				<div>
					<input type="submit" style="white-space: normal;" class="btn btn-primary" id="submitHome" value="Aggiorna Casa!">
				</div>
			</form>
      </div>
    </div>
  </div>
  
					</div>
</div>';}?>
									

				</div>

    </main>

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
    <script>
      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBoyfZQDXWDpFe7VNraYfMg5zB-W12kP5g&libraries=places">

      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -33.8688, lng: 151.2195},
          zoom: 14
        });
        var card = document.getElementById('pac-card');
        var input = document.getElementById('pac-input');
        var types = document.getElementById('type-selector');
        var strictBounds = document.getElementById('strict-bounds-selector');

        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);

        var autocomplete = new google.maps.places.Autocomplete(input);

        // Bind the map's bounds (viewport) property to the autocomplete object,
        // so that the autocomplete requests use the current map bounds for the
        // bounds option in the request.
        autocomplete.bindTo('bounds', map);

        // Set the data fields to return when the user selects a place.
        autocomplete.setFields(
            ['address_components', 'geometry', 'icon', 'name']);

        var infowindow = new google.maps.InfoWindow();
        var infowindowContent = document.getElementById('infowindow-content');
        infowindow.setContent(infowindowContent);
        var marker = new google.maps.Marker({
          map: map,
          anchorPoint: new google.maps.Point(0, -29)
        });

        autocomplete.addListener('place_changed', function() {
          infowindow.close();
          marker.setVisible(false);
          var place = autocomplete.getPlace();
		  var location;
			//location += "<b>Latitude:</b>"+place.geometry.location.lat()+"<br/> ";
			//location += "<b>Longitude:</b>"+place.geometry.location.lng()+"<br/> ";
			document.getElementById('lat').value= place.geometry.location.lat();
			document.getElementById('lng').value= place.geometry.location.lng();
          if (!place.geometry) {
            // User entered the name of a Place that was not suggested and
            // pressed the Enter key, or the Place Details request failed.
            window.alert("No details available for input: '" + place.name + "'");
            return;
          }

          // If the place has a geometry, then present it on a map.
          if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
          } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);  // Why 17? Because it looks good.
          }
          marker.setPosition(place.geometry.location);
          marker.setVisible(true);

          var address = '';
          if (place.address_components) {
            address = [
              (place.address_components[0] && place.address_components[0].short_name || ''),
              (place.address_components[1] && place.address_components[1].short_name || ''),
              (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
          }

          infowindowContent.children['place-icon'].src = place.icon;
          infowindowContent.children['place-name'].textContent = place.name;
          infowindowContent.children['place-address'].textContent = address;
          infowindow.open(map, marker);
        });

        // Sets a listener on a radio button to change the filter type on Places
        // Autocomplete.
        function setupClickListener(id, types) {
          var radioButton = document.getElementById(id);
          radioButton.addEventListener('click', function() {
            autocomplete.setTypes(types);
          });
        }

        setupClickListener('changetype-all', []);
        setupClickListener('changetype-address', ['address']);
        setupClickListener('changetype-establishment', ['establishment']);
        setupClickListener('changetype-geocode', ['geocode']);

        document.getElementById('use-strict-bounds')
            .addEventListener('click', function() {
              console.log('Checkbox clicked! New state=' + this.checked);
              autocomplete.setOptions({strictBounds: this.checked});
            });
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBoyfZQDXWDpFe7VNraYfMg5zB-W12kP5g&libraries=places&callback=initMap"
        async defer></script>
	
	
  </body>
</html>

<style>

 /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #description {
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
      }

      #infowindow-content .title {
        font-weight: bold;
      }

      #infowindow-content {
        display: none;
      }

      #map #infowindow-content {
        display: inline;
      }

      .pac-card {
        margin: 10px 10px 0 0;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        background-color: #fff;
        font-family: Roboto;
      }

      #pac-container {
        padding-bottom: 12px;
        margin-right: 12px;
      }

      .pac-controls {
        display: inline-block;
        padding: 5px 11px;
      }

      .pac-controls label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        text-overflow: ellipsis;
        width: 100%;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      #title {
        color: #fff;
        background-color: #4d90fe;
        font-size: 25px;
        font-weight: 500;
        padding: 6px 12px;
      }


.profile img {
  float: left;
  margin-right: 30px;
  border-radius: 20%;
}



.btn.btn-secondary{
	
 background:green;
}
.btn.btn-secondary:hover{
	 background:blue;
}

</style>
