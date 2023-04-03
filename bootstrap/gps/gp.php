<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">  
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  
	<link rel="stylesheet" href="../style_in.css" type="text/css">
    <link rel="icon" type="image/png" sizes="16x16" href="../images/profil.png">
    
	<script>
	/* Set the width of the sidebar to 250px and the left margin of the page content to 250px */
	function openNav() {
	  document.getElementById("mySidebar").style.width = "250px";
	  document.getElementById("main").style.marginLeft = "250px";
	}

	/* Set the width of the sidebar to 0 and the left margin of the page content to 0 */
	function closeNav() {
	  document.getElementById("mySidebar").style.width = "0";
	  document.getElementById("main").style.marginLeft = "0";
	}
	</script>
	
	<?php
        session_start();
        require("../fonction.php");
        $bdd = getBD();
        $q = "SELECT * FROM races WHERE races.raceId=:id";
        $statement = $bdd->prepare($q);
        $id = htmlspecialchars($_GET['id']); $statement -> bindParam(':id', $id); 
        $rep = $statement -> execute();

        if(!$rep){
          echo "a problem occur during the request to the BD";
          die;
        }
        else{
          $infos = $statement -> fetch(); $nb_infos = count($infos, $mode=0); 
          $add = "UPDATE races SET visites=visites+1 WHERE races.raceId=".$infos["raceId"];
          $bdd -> query($add);
        }
    ?>
	
    <title><?php echo $infos["name"];?></title>

	</head>
	
	
	<body>

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
		  <a href="../bd.php">Base de Données</a>

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
			  <a class="nav-link" href="gps.php">Grands Prix</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="../circuits/circuits.php">Circuits</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="../constructeurs/constructeurs.php">Constructeurs</a>
			</li>
		  </ul>
		  
		  <form class="d-flex">
			<input class="form-control me-2" action="../recherche.php" type="text" placeholder="Search">
			<button class="btn btn-danger" type="button">Search</button> 
		  </form>
		  
		</div>
	  </div>
	</nav>
	

	
	<!--STATS-->


    <div class="d-flex flex-row" id="title">
        <div class="p-2">

        <img  id="gp_indi" src= "<?php echo $infos['url_photo']; ?>"  alt='photo du pays'>
        </div>
        <div class="p-2">
        <h1 id="pilotes_title"> <?php echo $infos["name"];?></h1>
        </div>
        </div>

	
	
     
    <div class="container-fluid" id="first" >
            <div class="row">

        <div class="col-lg-6" id="courses">
            <p>
            <?php $url = $infos["url"];
                  require_once('../simple_html_dom.php');

                  // Récupérer le contenu de la page Web
                  $html = file_get_html($url);

                  // Trouver tous les éléments HTML avec la classe "content"
                  $elements = $html->find('p');


                  $i=0;
                  while($i<5){
                    echo $elements[$i]->plaintext;
                    echo "<br>";
                    $i++;// changer le css balise a
                  } ?>
                  <a href= "<?php echo $url; ?>" >  Plus d'infos. </a>

            </p>
        </div>

        <div class="col-lg-6" id="stats">
        <h2 id= "code">  <?php $rep = $bdd -> query("SELECT circuits.url_photo FROM circuits, races WHERE circuits.circuitId=races.circuitId AND races.raceId=".$infos["raceId"]); $nb = $rep -> fetch(); echo "<img id='img_cir_ind'src='".$nb['url_photo']."'>"; ?> </h2>
            <ul class="list-group list-group-dark" data-bs-theme="dark">
                <li class="list-group-item list-group-item-dark"> Localisation : <?php $rep = $bdd -> query("SELECT circuits.location, circuits.country FROM circuits, races WHERE circuits.circuitId=races.circuitId AND races.raceId=".$infos["raceId"]); $nb = $rep -> fetch(); echo $nb[0].", ".$nb[1]; ?> </li>
                <li class="list-group-item list-group-item-dark"> Circuit : <?php $rep = $bdd -> query("SELECT circuits.name FROM circuits, races WHERE races.circuitId=circuits.circuitId AND races.raceId=".$infos["raceId"]); $nb = $rep -> fetch(); echo "<a id='lien' href='../circuits/circuit.php?id=".$infos["circuitId"]."'> ".$nb[0]." </a>";?> </li>
                <li class="list-group-item list-group-item-dark"> Heure : <?php echo $infos["time"]; ?> </li>
                <li class="list-group-item list-group-item-dark"> Saison : <?php echo $infos["year"]; ?>   </li>
                <li class="list-group-item list-group-item-dark"> Vainqueur : <?php $rep = $bdd -> query("SELECT drivers.forename, drivers.surname FROM drivers, results, races WHERE drivers.driverId=results.driverId AND results.raceId=races.raceId AND  results.position=1 AND races.raceId=".$infos["raceId"]); $nb = $rep -> fetch(); echo $nb[0]." ".$nb[1];?> </li>
                </ul>
         </div>

    </div>
</div>


        </div>
    </div>


    <div class="container-fluid" id="courses">
            <h4> Résultats </h4>

                <?php
                  echo " <table class='table table-dark table-striped'> <tr class='table-dark'> <td class='table-dark'> Pilote </th> <td class='table-dark'> Position </th> <td class='table-dark'> Tours </th> <td class='table-dark'> Temps </th> </tr>";
                  $rep = $bdd -> query("SELECT drivers.forename, drivers.surname, results.position, results.laps, results.time FROM drivers, results, races WHERE drivers.driverId=results.driverId AND results.raceId=races.raceId AND races.raceId=".$infos["raceId"]);
                  $ans = $rep -> fetchAll();

                  for($i=0; $i<count($ans); $i++){
                    echo "<tr class='table-dark'> <td class='table-dark'>".$ans[$i]["forename"]." ".$ans[$i]["surname"]."</td><td class='table-dark'>".$ans[$i]["position"]."</td><td class='table-dark'>".$ans[$i]["laps"]."</td><td class='table-dark'>".$ans[$i]["time"]."</td></tr>";
                  }
                  echo "</table>";


                ?>

    </div>




	
<!--

        <div class="container-fluid" id="footer">
            <div class="row justify-content-between">
                <div class="col-lg-2">
                        <button class="btn btn-light" id="share">
                            <div class="row">
                                <div class="col-sm-4"> 
                                    <img src="../images/fia.jpg"> 
                                </div>
                                <div class="col-sm-8">
                                    <p> Partager </p>
                                </div>        
                            </div>
                        </button>
                </div>
				   <div class="col-lg-2" id='right-btn'>
                        <button class="btn btn-light" id="like">
                            <div class="row">
                                <div class="col-sm-4"> 
                                    <img src="../images/fia.jpg"> 
                                </div>
                                <div class="col-sm-8">
                                    <p> Aimer </p>
                                </div>    
                            </div>
                        </button>
                </div>
        </div>
		
		-->
    
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
              <a href="#!" class="text-white"><i class="fas fa-book fa-fw fa-sm me-2"></i>L'université</a>
            </li>
            <li>
              <a href="#!" class="text-white"><i class="fas fa-user-edit fa-fw fa-sm me-2"></i>Contactez-Nous</a>
            </li>
          </ul>
        </div>
        <!--Grid column-->


        <!--Grid column-->
        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase">Notre Formation</h5>

          <ul class="list-unstyled">
            <li>
              <a href="https://ufr6.www.univ-montp3.fr/fr/licence_miashs" class="text-white"><i class="fas fa-at fa-fw fa-sm me-2"></i> Licence MIASHS</a>
            </li>            <li>
              <a href="#!" class="text-white"><i class="fas fa-book fa-fw fa-sm me-2"></i>Notre Rapport</a>
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
      © 2021 Copyright:
      <a class="text-white" href="https://mdbootstrap.com/"> Tous Droits réservés</a>
    </div>
    <!-- Copyright -->
  </footer>


<!-- End of .container -->
	</body>
	
	
	
	
	
</html>	