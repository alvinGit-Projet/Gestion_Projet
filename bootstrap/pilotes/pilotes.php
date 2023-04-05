<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
		<link rel="stylesheet" href="pilote.css" type="text/css">
	  
	  <title>Pilotes</title>
	  
	  
	  
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
	
	<?php 
    session_start();
    require("../fonction.php");
    $bdd=getBD();
	?>
	
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
			  <a class="nav-link" href="#">Pilotes</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="../gps/gps.php">Grands Prix</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="../circuits/circuits.php">Circuits</a>
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
        <button type="button" class="btn btn-dark" onclick="window.location='comparer_pilotes.php'"> Comparer</button>
    </div>

	
<?php // requete pilote de la saison en cours 
    $query = "SELECT DISTINCT drivers.forename, drivers.surname, drivers.code, drivers.driverId, drivers.url_photo FROM drivers, seasons, races, results WHERE races.year=(SELECT seasons.year FROM seasons ORDER BY seasons.year DESC LIMIT 1) AND races.raceId=results.raceId AND results.driverId=drivers.driverId";
    $statement=$bdd->prepare($query);
    $rep = $statement -> execute();
    $pilotes = $statement -> fetchAll();
    $nb = count($pilotes);

    echo "<div class='container'> \n <div class='row'>\n ";
    for($i=0; $i<$nb; $i++){
        echo "<div class='col-lg-6 d-flex justify-content-center '>\n";
        echo "<div class='row'>\n <div class='col-lg-4 d-flex justify-content-center'><a href='./pilote.php?id=".$pilotes[$i]["driverId"]."'> \n";  //$pilotes[$i]["url_photo"]
		if($pilotes[$i]["url_photo"]==""){
			echo "<img src='../images/photo.jpg'>\n</a></div>  <div class='col-lg-8 d-flex justify-content-center'><a href='./pilote.php?id=".$pilotes[$i]["driverId"]."'>  \n \n<p class='paragraphe'>".$pilotes[$i]["forename"]." ".$pilotes[$i]["surname"]."</p></a> \n</div>\n";
		}
		else{
			echo "<img src='".$pilotes[$i]["url_photo"]."' alt='photo du pilote'>\n</a></div>  <div class='col-lg-8 d-flex justify-content-center'><a href='./pilote.php?id=".$pilotes[$i]["driverId"]."'>  \n \n<p class='paragraphe'>".$pilotes[$i]["forename"]." ".$pilotes[$i]["surname"]."</p></a> \n</div>\n";
		}
        echo "</div> \n</div>\n" ; 
        if($i%2==1 && $i!=$nb-1 && $i!=0){
            echo "</div> <div class='row'>";
        }
    }
    echo "</div> </div>";

    ?>

<div id="recommandation">
	<?php

	if(isset($_SESSION["client"])){
		$countq = "SELECT COUNT(*) FROM liker_pilote WHERE liker_pilote.email_adress=".$_SESSION["client"]["email_adress"];
		$sttm = $bdd -> prepare($countq); $rep = $sttm -> execute(); $count = $sttm -> fetch();
		if($count>10){
			require("./recommandation_pilotes.php");
			// algo de recommandation avancé
			echo "<h2> Pilotes similaires à ceux aimés </h2>";
			// recommandation par les plus consultés
			$similaire = reco_content_based($bdd);

			echo "<div class='container'> <div class='row'>";
			for($i=0; $i<count($similaire); $i++){
				$q = "SELECT * FROM drivers WHERE drivers.driverId=".$similaire[$i]["id"];
				$rep = $bdd -> query($q); $pilote = $rep -> fetch();

				echo "<div class='col-lg-3 col-sm-6'><a href='./pilote.php?id=".$pilote["driverId"]."'>";
				if($pilote["url_photo"]!=""){
					echo "<img src='".$pilote["url_photo"]."' alt='photo du pilote'>\n<br><p class='paragraphe2'>".$pilote["forename"]." ".$pilote["surname"]."</p>";
				}
				else{
					echo "<img src='../images/photo.jpg' alt='photo du pilote'>\n<br><p class='paragraphe2'>".$pilote["forename"]." ".$pilote["surname"]."</p>";
				}
				echo "</a></div>\n\n";
				if($i==3){ echo "</div><div class='row'>"; }
			}
			echo "</div></div>";

			echo "<h2> Pilotes aimés par d'autres utilisateurs </h2>";
			// recommandation par les plus consultés
			$similaire = reco_user_based($bdd);

			echo "<div class='container'> <div class='row'>";
			for($i=0; $i<count($similaire); $i++){
				$q = "SELECT * FROM drivers WHERE drivers.driverId=".$similaire[$i]["id"];
				$rep = $bdd -> query($q); $pilote = $rep -> fetch();

				echo "<div class='col-lg-3 col-sm-6'><a href='./pilote.php?id=".$pilote["driverId"]."'>";
				if($pilote["url_photo"]!=""){
					echo "<img src='".$pilote["url_photo"]."' alt='photo du pilote'>\n<br><p class='paragraphe2'>".$pilote["forename"]." ".$pilote["surname"]."</p>";
				}
				else{
					echo "<img src='../images/photo.jpg' alt='photo du pilote'>\n<br><p class='paragraphe2'>".$pilote["forename"]." ".$pilote["surname"]."</p>";
				}
				echo "</a></div>\n\n";
				if($i==3){ echo "</div><div class='row'>"; }
			}
			echo "</div></div>";

		}
		else{
			// algo recommandation classique
			echo "<h2> Pilotes les plus consultés </h2>";
			// recommandation par les plus consultés
			$mostvisited = "SELECT * FROM drivers ORDER BY drivers.visites DESC LIMIT 8";
			$rep = $bdd -> query($mostvisited); $top8=$rep -> fetchAll();

			echo "<div class='container'> <div class='row'>";
			for($i=0; $i<count($top8); $i++){
				echo "<div class='col-lg-3 col-sm-6'><a href='./pilote.php?id=".$top8[$i]["driverId"]."'>";
				if($top8[$i]["url_photo"]!=""){
					echo "<img src='".$top8[$i]["url_photo"]."' alt='photo du pilote'>\n<br><p class='paragraphe2'>".$top8[$i]["forename"]." ".$top8[$i]["surname"]."</p>";
				}
				else{
					echo "<img src='../images/photo.jpg' alt='photo du pilote'>\n<br><p class='paragraphe2'>".$top8[$i]["forename"]." ".$top8[$i]["surname"]."</p>";
				}
				echo "</a></div>\n\n";
				if($i==3){ echo "</div><div class='row'>"; }
			}
			echo "</div></div>";

		}
	}
	else{

	echo "<h3> Pilotes les plus consultés </h3>";

	// recommandation par les plus consultés
	$mostvisited = "SELECT * FROM drivers ORDER BY drivers.visites DESC LIMIT 4";
	$rep = $bdd -> query($mostvisited); $top8=$rep -> fetchAll();

	echo "<div class='container'> <div class='row'>";
	for($i=0; $i<count($top8); $i++){
		echo "<div class='col-lg-3 col-sm-6'><a href='./pilote.php?id=".$top8[$i]["driverId"]."'>";
		if($top8[$i]["url_photo"]!=""){
			echo "<img src='".$top8[$i]["url_photo"]."' alt='photo du pilote'>\n<br><p class='paragraphe2'>".$top8[$i]["forename"]." ".$top8[$i]["surname"]."</p>";
		}
		else{
			echo "<img src='../images/photo.jpg' alt='photo du pilote'>\n<br><p class='paragraphe2'>".$top8[$i]["forename"]." ".$top8[$i]["surname"]."</p>";
		}
		echo "</a></div>\n\n";
		if($i==3){ echo "</div><div class='row'>"; }
	}
	echo "</div></div>";
}
	echo "<h3> Sélection aléatoire de pilotes </h3>" ;

	// recommandation par random
	$randomq = "SELECT * FROM drivers ORDER BY RAND() LIMIT 4";
	$rep2 = $bdd -> query($randomq); $rand8=$rep2 -> fetchAll();

	echo "<div class='container'> <div class='row'>";
	for($i=0; $i<count($rand8); $i++){
		echo "<div class='col-lg-3 col-sm-6'><a href='./pilote.php?id=".$rand8[$i]["driverId"]."'>";
		if($rand8[$i]["url_photo"]!=""){
			echo "<img src='".$rand8[$i]["url_photo"]."' alt='photo du pilote'>\n<br><p class='paragraphe2'>".$rand8[$i]["forename"]." ".$rand8[$i]["surname"]."</p>";
		}
		else{
			echo "<img src='../images/photo.jpg' alt='photo du pilote'>\n<br><p class='paragraphe2'>".$rand8[$i]["forename"]." ".$rand8[$i]["surname"]."</p>";
		}
		echo "</a></div>\n\n";
		if($i==3){ echo "</div><div class='row'>"; }
	}
	echo "</div></div>";
	?>


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