<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <link rel="stylesheet" href="carte.css" type="text/css">

	  <title>Circuits</title>



	 <script>
	function openNav() {
	  document.getElementById("mySidebar").style.width = "250px";
	  document.getElementById("main").style.marginLeft = "250px";
	}

	function closeNav() {
	  document.getElementById("mySidebar").style.width = "0";
	  document.getElementById("main").style.marginLeft = "0";
	}
	</script>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
     <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
     integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin=""/>


     <!-- Make sure you put this AFTER Leaflet's CSS -->
     <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
         integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>



    <?php
            session_start();
            require("../fonction.php");
            $bdd=getBD();

            $q = "SELECT circuits.circuitId, circuits.lat, circuits.lng, circuits.name, circuits.location, circuits.country FROM circuits";
            $statement=$bdd->prepare($q);
            $rep = $statement -> execute();
            $circuits = $statement -> fetchAll();
            $nb = count($circuits);


            foreach($circuits as $c){
            //echo ($c['lat'].";".$c['lng']."->".$c['name']."<br>");
            }

            $rows = [];
            foreach($circuits as $l){
                   $rows[] = $l;
                 }


            $liste_json = json_encode($rows);
            //print_r($rows);


     ?>

</head>
<style>
        html, body { height: 100% }
</style>

<body >
<!-- NAV BAR -->

	<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
	<div class="container-fluid">


		<div id="mySidebar" class="sidebar">
		  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
		  <?php
		  if (isset($_SESSION['utilisateur'])){
		  	echo "<p style='text-align:center'> Bonjour ".$_SESSION['utilisateur']['nom']." ".$_SESSION['utilisateur']['prenom']."</p>";
            }
		  ?>

		  <a href="../utilisateur/favoris.php">Mes Favoris</a>
		  <a href="../utilisateur/abonnement.php">Mes Abonnements</a>
		  <a href="../utilisateur/parier.php">Parier</a>
		  <a href="../bd.html">Base de Données</a>
		  <?php
		  if (!isset($_SESSION['utilisateur'])){
		  	echo '<a href="../utilisateur/inscription.php"> Inscription </a>';
		  	echo '<a href="../utilisateur/connexion.php"> Connexion </a>';
		  	}
		  else{
		  	echo '<a href="../utilisateur/deconnexion.php"> deconnexion </a>';
		  	}

		  ?>
		  <!-- redirection vers ./utilisateur/inscription.php -->
		</div>

		<div id="main">
			<button class="openbtn" onclick="openNav()">&#9776;</button>
		</div>

		<div class="collapse navbar-collapse" id="mynavbar">

		  <ul class="navbar-nav me-auto">
			<li class="nav-item">
			  <a class="nav-link" href="../index.php">Accueil</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="../pilotes/pilotes.php">Pilotes</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="../gps/gps.php">Grands Prix</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="circuits.php">Circuits</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="../constructeurs/constructeurs.php">Constructeurs</a>
			</li>
		  </ul>

		  <form class="d-flex" action="recherche.php" method="get">
                    <input class="form-control me-2" type="text" placeholder="Search" name="search">
                  <button class="btn btn-danger" type="submit">Search</button>
                </form>

		</div>
	  </div>
	</nav>



<div class="btn_modif">
    <button type="button" class="btn btn-dark" onclick="window.location='circuits.php'"> Recherche Par Liste</button>
    </div>

<div id="map" >
</div>

<!-- FOOTER -->

  <footer class="bg-dark text-center text-lg-start text-white">
    <!-- Grid container -->
    <div class="container p-4">
      <!--Grid row-->
      <div class="row mt-4">
	  <div class="col-lg-3">
	  </div>
        <!--Grid column-->
        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase"> Informations</h5>

          <ul class="list-unstyled mb-0">
            <li>
              <a href="#!" class="text-white"><i class="fas fa-book fa-fw fa-sm me-2"></i> Rapport Du Projet </a>
            </li>
            <li>
              <a href="#!" class="text-white"><i class="fas fa-book fa-fw fa-sm me-2"></i> La Vidéo de Présentation</a>
            </li>
          </ul>
        </div>
        <!--Grid column-->


        <!--Grid column-->
        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase">Notre Formation</h5>

          <ul class="list-unstyled">
            <li>
              <a href="https://ufr6.www.univ-montp3.fr/fr/licence_miashs" class="text-white"><i class="fas fa-at fa-fw fa-sm me-2"></i> La Licence MIASHS</a>
            </li>
            <li>
              <a href="https://www.univ-montp3.fr/" class="text-white"><i class="fas fa-book fa-fw fa-sm me-2"></i>L'Université Paul Valéry </a>
            </li>



          </ul>
        </div>
        <!--Grid column-->
      </div>
      <!--Grid row-->
    </div>
    <!-- Grid container -->

    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
      © 2023 Copyright: Tous Droits réservés
    </div>
    <!-- Copyright -->
  </footer>


<!-- End of .container -->

</body>
</html>

<script type="text/javascript">

    // Create the map
    var map = L.map('map').setView([21.505, -7.09], 2);

    // Add a tile layer (we'll use OpenStreetMap)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: 'L\'écurie des Statistiques <a href="https://openstreetmap.org">OpenStreetMap</a> contributors',
      maxZoom: 28,
    }).addTo(map);

    var liste = <?php echo $liste_json;?>;
    console.log(liste);

    for (let i = 0; i < liste.length; i++){
    L.marker([liste[i].lat, liste[i].lng]).addTo(map)
            .bindPopup("<a href=./circuit.php?id="+liste[i].circuitId+">"+liste[i].name+"</a>"+", "+ liste[i].location+" ("+liste[i].country+")").openPopup();
    }



</script>