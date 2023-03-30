<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">  
    <link rel="stylesheet" href="../style_in.css" type="text/css">
    <link rel="stylesheet" href="../pilotes/pilote.css" type="text/css">

	
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


    <?php session_start();
        require("../fonction.php"); $bdd = getBD();

        if(isset($_SESSION["utilisateur"])){
            $query1 = "SELECT liker_pilote.driverId FROM liker_pilote WHERE liker_pilote.email_adress=".$_SESSION["utilisateur"]["email_adress"];
            $query2 = "SELECT liker_constructor.constructorId FROM liker_constructor WHERE liker_constructor.email_adress=".$_SESSION["utilisateur"]["email_adress"];

            $statement1 = $bdd -> prepare($query1); $statement2 = $bdd -> prepare($query2);

            $rep1 = $statement1 -> execute(); $rep2 = $statement2 -> execute();

            if($rep1 && $rep2){
                $pilotes=$statement1 -> fetchAll();
                $constructeurs=$statement2 -> fetchAll();
            }
            else{
                die("smth went wrong");
            }
        }
        else{
    //        die("Vous devez être connecté pour accéder à cette page");
    echo "connexion exceptionnelle";
            $query1 = "SELECT liker_pilote.driverId FROM liker_pilote WHERE liker_pilote.email_adress='a'";
            $query2 = "SELECT liker_constructor.constructorId FROM liker_constructor WHERE liker_constructor.email_adress='a'";

            $statement1 = $bdd -> prepare($query1); $statement2 = $bdd -> prepare($query2);

            $rep1 = $statement1 -> execute(); $rep2 = $statement2 -> execute();
            if($rep1 && $rep2){
                $pilotes=$statement1 -> fetchAll();
                $constructeurs=$statement2 -> fetchAll();
            }
            else{
                die("smth went wrong");
            }
        }
    ?>

    <title>Mes favoris</title>
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
		  <a href="favoris.php">Mes Favoris</a>
		  <a href="abonnement.php">Mes Abonnements</a>
		  <a href="parier.php">Parier</a>
		  <a href="../bd.php">Base de Données</a>
		  <?php
		  if (!isset($_SESSION['utilisateur'])){
		  	echo '<a href="inscription.php"> Inscription </a>';
		  	echo '<a href="connexion.php"> Connexion </a>';
		  	}
		  else{
		  	echo '<a href="deconnexion.php"> deconnexion </a>';
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
			  <a class="nav-link" href="../constructeurs/constructeurs.php">Constructeurs</a>
			</li>
		  </ul>
		  
		  <form class="d-flex">
			<input class="form-control me-2" type="text" placeholder="Search">
			<button class="btn btn-danger" type="button">Search</button> 
		  </form>
		  
		</div>
	  </div>
	</nav>
    
	
	
	
	
	<!-- Boucle php-->
	<div class="p-5 bg-secondary text-white text-center">
		<h2> Vos Favoris</h2>
	</div>

    <div class="container-fluid" id="favs">
        <div class="row">
            <div class="col-lg-6" id="col1">
                <h2> Pilotes favoris : </h2>
                <?php 
                    $nb_pilotes=count($pilotes);
					if($nb_pilotes ==0){
						echo "<center>Aucun favoris pour l'instant </center>";
					}
					else{
                    for($i=0; $i<$nb_pilotes; $i++){
                        $query = "SELECT drivers.forename, drivers.surname FROM drivers WHERE drivers.driverId=".$pilotes[$i]["driverId"];
                        $statement = $bdd -> prepare($query); $ans = $statement -> execute(); $pilote = $statement -> fetch();
                        echo "<div class='row'>  <div class='col-lg-4'> <a href='../pilotes/pilote?id=".$pilotes[$i]["driverId"]."'> <img src='../images/photo.jpg' alt='photo pilote'> </a> </div> <div class='col-lg-8'>  <a href='../pilotes/pilote?id=".$pilotes[$i]["driverId"]."'> <p class='paragraphe'>".$pilote["forename"]." ".$pilote["surname"]."</p> </a> </div> </div>";
                    }}

                ?>
            </div>
			
			
            <div class="col-lg-6" id="col2">
            <h2> Constructeurs favoris : </h2>
                <?php 
                    $nb_constructeurs=count($constructeurs);
					if($nb_constructeurs ==0){
						echo "<center/>Aucun favoris pour l'instant </center>";
					}
					else{
                    for($i=0; $i<$nb_constructeurs; $i++){
                        $query = "SELECT constructors.name FROM constructors WHERE constructors.constructorId=".$constructeurs[$i]["constructorId"];
                        $statement = $bdd -> prepare($query); $ans = $statement -> execute(); $constructeur = $statement -> fetch();
                        echo "<div class='row'> <div class='col-lg-4'><a href='../constructeurs/constructeur?id=".$constructeurs[$i]["constructorId"]."'> <img src='../images/photo.jpg' alt='photo constructeur'> </a> </div> <div class='col-lg-8'> <a href='../constructeurs/constructeur?id=".$constructeurs[$i]["constructorId"]."'> <p class='paragraphe'> ".$constructeur["name"]." </p> </a> </div> </div>";
                    }}
                
                ?>
            </div>
        </div>
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
	</body>
	
	
	
	
	
</html>	