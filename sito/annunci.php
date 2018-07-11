<?php
$city = $_GET['dato'];
$data1 = $_GET['data1'];
$data2 = $_GET['data2'];
//echo $city." ".$data1." ".$data2;

$conn =  mysqli_connect("localhost", "root", "", "testdb");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sq1 = "SELECT annunci.titolo, annunci.path, stelle.stelle, annunci.id FROM stelle RIGHT JOIN annunci ON stelle.id=annunci.id WHERE annunci.citta='$city'";
$result = $conn->query($sq1);
$num_results = $result->num_rows;
$ids = [];
$titles = [];
$paths = [];
$stelle = [];
$count=0;

if ($result->num_rows > 0) {
    // output data of each row
	$incr = 0;
    while($row = $result->fetch_assoc()) {
        //echo " RISULTATI QUERY RICERCA <br>TITOLO:".$row["titolo"]."  ||  PATH: ". $row["path"]."  ||  ".$row["stelle"]."<br>";
		$titles[$incr]= $row["titolo"];
		$paths[$incr] = $row["path"];
		$stelle[$incr] = $row["stelle"];
		$ids[$incr] = $row["id"];
		
		$incr++;

    }
} else {
    echo "0 results";
}

$conn->close();

?>

<script type="text/javascript">

		function aggiungiElemento(elementName, tito, pathElement, star, id) {
			
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
			

			newElement0 = document.createElement("div");
			newElement0.className = "col-md-4";
			newElement0.id = "extern00".concat(elementName);
			//newElement.onclick = cambiaSfondo;

			// aggiunge l'elemento appena creato e il suo contenuto al DOM
			flexContainer0 = document.getElementById("DivStart0");
			flexContainer0.appendChild(newElement0);			
			
			newElement = document.createElement("div");
			newElement.innerHTML = "<img class=\"card-img-top\" src=\"".concat(pathElement).concat("\" alt=\"Card image cap\" height=\"235\" width=\"288\" >");
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
			newElement3.innerHTML = "<form ><button type=\"button\" class=\"btn btn-sm btn-outline-secondary\">".concat(star).concat(" ☆</button>").concat("<input onclick=\"window.location='./get.php?var=").concat(tito).concat("&id=").concat(id).concat("'\" value=\"Vedi\" type=\"button\" class=\"btn btn-sm btn-outline-secondary\">").concat("</form>"); /*funzionerà? so mica METTI TITOLO CASA !!!*/ 
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
			
			for (i = 0; i < num_result; i++) { 
    			aggiungiElemento(i, tempArray[i], tempArrayP[i], tempArrayS[i], tempArrayI[i]);
			}
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
    <h2 id ="test"></h2>

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
            <div class="col-sm-8 col-md-7 py-4">
              <h4 class="text-white">About</h4>
              <p class="text-muted">Add some information about the album below, the author, or any other background context. Make it a few sentences long so folks can pick up some informative tidbits. Then, link them off to some social networking sites or contact information.</p>
            </div>
            <div class="col-sm-4 offset-md-1 py-4">
              <h4 class="text-white">Contact</h4>
              <ul class="list-unstyled">
                <li><a href="#" class="text-white">Follow on Twitter</a></li>
                <li><a href="#" class="text-white">Like on Facebook</a></li>
                <li><a href="#" class="text-white">Email me</a></li>
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

    <main role="main">

      <section class="jumbotron text-center">
        <div class="container">
          <h1 class="jumbotron-heading"> TESTOOì</h1>
          <p class="lead text-muted">QUI METTEREMO UN LOGO DELLA CITTA CERCATA.</p>
          <p>
            <a href="#" class="btn btn-primary my-2">ESPLORA CITTA</a>
            <a href="#" class="btn btn-secondary my-2">MODIFICA RICERCA</a>
          </p>
        </div>
      </section>

      <div class="album py-5 bg-light">
        <div class="container">

          <div class="row"id="DivStart0" >
					<script type="text/javascript">
						creaElementi(); //CREA DIV DINAMICAMENTE 
					</script>
          </div>
        </div>
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
    <script src="../../assets/js/vendor/popper.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script src="../../assets/js/vendor/holder.min.js"></script>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
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
