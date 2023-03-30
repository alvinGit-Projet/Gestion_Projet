<!DOCTYPE html>
<html lang="fr">
    <head>

    <?php 
      require("fonction.php");
      $bdd = getBD();
      session_start();
      ?> 

        <title> L'écurie des statistiques</title>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">  
        <link rel="stylesheet" href="./style_in.css" type="text/css">
        <link rel="icon" href="./images/icon.jpg">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


        <!-- Include in <head> to load fonts from Google -->
        <link href='https://fonts.googleapis.com/css?family=Lato:100italic' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>

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


	
	</head> 
	
	
    <body>
	
	<!-- BANDEROLLE -->
	
	<div >
        <img  src="./images/banniere2.png" class="responsive">
	</div>
	
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
		  <a href="./utilisateur/favoris.php">Mes Favoris</a>
		  <a href="./utilisateur/abonnement.php">Mes Abonnements</a>
		  <a href="./utilisateur/parier.php">Parier</a>
		  <a href="./bd.php">Base de Données</a>

		  <?php
		  if (!isset($_SESSION['utilisateur'])){
		  	echo '<a href="./utilisateur/inscription.php"> Inscription </a>';
		  	echo '<a href="./utilisateur/connexion.php"> Connexion </a>';
		  	}
		  else{
		  	echo '<a href="./utilisateur/deconnexion.php"> deconnexion </a>';
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
			  <a class="nav-link" href="./pilotes/pilotes.php">Pilotes</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="./gps/gps.php">Grands Prix</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="./circuits/circuits.php">Circuits</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="./constructeurs/constructeurs.php">Constructeurs</a>
			</li>
		  </ul>
		  <form class="d-flex">
          			<input class="form-control me-2" type="text" placeholder="Search">
          			<button class="btn btn-danger" type="button">Search</button>
          		  </form>
		  

		</div>
	  </div>
	</nav>
	

	
	
		<div class="intro">
		<h3>Introduction</h3>

		<p>
		La Formule 1, également connue sous le nom de F1,
		est l'une des compétitions automobiles les plus
		prestigieuses et les plus suivies au monde. Cette
		discipline est considérée comme la catégorie reine
		du sport automobile et attire chaque année des
		millions de fans à travers le monde.
		</p>
        <p>
        Ce sport est une compétition de courses de
        voitures monoplaces, qui se déroule sur des circuits
        spécialement conçus pour cette discipline.
        Les voitures de Formule 1 sont des machines
        hautement sophistiquées, construites selon des
        spécifications strictes pour garantir une performance
        optimale.
        </p>
        <p>
        Les équipes de Formule 1 sont composées de
        deux pilotes et d'un certain nombre d'ingénieurs
        et de mécaniciens qui travaillent ensemble pour
        maximiser les performances des voitures. Chaque
        course de Formule 1 se compose de plusieurs tours
        de piste, avec des arrêts aux stands pour changer
        les pneus et le carburant.
        <br>
        Les courses de Formule 1 sont connues pour
        leur vitesse, leur suspense et leur spectacle.
        Les voitures peuvent atteindre des vitesses allant
        jusqu'à 370 km/h, et les courses sont souvent
        disputées jusqu'à la ligne d'arrivée. Les fans
        de Formule 1 apprécient également la stratégie et
        la tactique qui entrent en jeu lors des courses,
        ainsi que la rivalité intense entre les équipes et
        les pilotes.
        </br>
        </p>
        <p>
        En résumé, la Formule 1 est une compétition
        automobile de premier plan qui attire des fans
         du monde entier grâce à son mélange unique de
         vitesse, de suspense et de compétition acharnée.
         Si vous êtes passionné de sport automobile, la
         Formule 1 est un événement à ne pas manquer.
        </p>
		</div>
	
	
	<!--SLIDE PHOTO -->
	
	<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block w-100" src="./images/rb_slide.png" alt="First slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="./images/merc_slide.png" alt="Second slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="./images/ferrari_slide.png" alt="Third slide">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only"></span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only"></span>
  </a>
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


<!-- End of .container -->
	</body>
	
	
	
	
	
</html>	