<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
		<link rel="stylesheet" href="../pilotes/pilote.css" type="text/css">
	  
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
		  	echo "".$_SESSION['utilisateur']['nom']." ".$_SESSION['utilisateur']['prenom'];
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
			  <a class="nav-link" href="../gps/gps.php">Grands Prix</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="../circuits/circuits.php">Circuits</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="#">Constructeurs</a>
			</li>
		  </ul>
		  
		  <form class="d-flex">
			<input class="form-control me-2" type="text" placeholder="Search">
			<button class="btn btn-danger" type="button">Search</button> 
		  </form>
		  
		</div>
	  </div>
	</nav>
	
	
<?php // requete pilote de la saison en cours + drivers.url_photo
    $query = "SELECT DISTINCT constructors.constructorId, constructors.name, constructors.nationality
FROM constructors, seasons, races, results 
WHERE races.year=(SELECT seasons.year FROM seasons ORDER BY seasons.year DESC LIMIT 1) 
AND races.raceId=results.raceId AND results.constructorId=constructors.constructorId";
    
	$statement=$bdd->prepare($query); $rep = $statement -> execute();
    $constructeur = $statement -> fetchAll(); $nb = count($constructeur);

    echo "<div class='container' id = 'pilot'> \n <div class='row'>\n  ";
    for($i=0; $i<$nb; $i++){
        echo "<div class='col-lg-6 col-sm-6'>\n";
        echo "<div class='row'>\n <div class='col-lg-4'><a href='./constructeur.php?id=".$constructeur[$i]["constructorId"]."'> \n";  //$constructeur[$i]["url_photo"]
        echo "<img src='../images/photo.jpg' alt='photo du constructeur'>\n</a></div>  <div class='col-lg-8'><a href='./constructeur.php?id=".$constructeur[$i]["constructorId"]."'> \n \n<p class='paragraphe'>".$constructeur[$i]["name"]." (".traduireNationalite($constructeur[$i]["nationality"]).") </p></a> \n</div>\n";echo "</div> \n</div>\n" ; 
        if($i%2==1 && $i!=$nb-1 && $i!=0){
            echo "</div> <div class='row'>";
        }
    }
    echo "</div> </div>";

    ?>

	
	
	
	
	
	



</body>
</html>