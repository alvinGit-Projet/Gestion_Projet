<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes abonnements</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">  
    <link rel="stylesheet" href="../style_in.css" type="text/css">
    <link rel="icon" href="./images/icon.jpg">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>

    <?php 
        session_start();
        require("../fonction.php");
        $bdd = getBD();
        // On va générer les abonnements du client connecté = récupération de l'id Session
        if(!isset($_SESSION['utilisateur'])){ 
           echo "<meta http-equiv='refresh'  content='0; URL=./connexion.php?error=connexion-necessaire'>";
            die("Vous n'êtes pas censé arriver ici, retour page d'accueil");
          //  echo "autorisation exceptionnelle"; 
        } 
        else{
            $email=$_SESSION['utilisateur']["email_adress"];  // ou email_adress et il ne reste plus qu'à utiliser $id dans les requêtes ci-dessous
        }
    ?>


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
		  <a href="./favoris.php">Mes Favoris</a>
		  <a href="#">Mes Abonnements</a>
		  <a href="./parier.php">Parier</a>
		  <a href="../bd.php">Base de Données</a>

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
            	<a class="nav-link" href="../index.php"> Accueil</a>
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
		  
		  <form class="d-flex" action="../recherche.php" method="get">
			<input class="form-control me-2" type="text" name="search" placeholder="Search">
			<button class="btn btn-danger" type="submit">Search</button> 
		  </form>
		  
		</div>
	  </div>
	</nav>



    <?php 
        if(isset($_POST["nw"])){
            $rep = $bdd -> query("SELECT utilisateur.news_letter FROM utilisateur WHERE utilisateur.email_adress=".$email); $ans = $rep-> fetch(); if($ans==""){ echo "L'utilisateur n'existe pas "; }else{$bool = $ans[0]; }     
            if($bool){
                $query = "UPDATE utilisateur SET utilisateur.news_letter=0 WHERE utilisateur.email_adress='".$email."'";
                $statement = $bdd -> prepare($query);
                $statement -> execute();
            }
            else{
                $query = "UPDATE utilisateur SET utilisateur.news_letter=1 WHERE utilisateur.email_adress='".$email."'";
                $statement = $bdd -> prepare($query);
                $statement -> execute();
            }
        }
        if(isset($_POST["actu"])){
            $rep=$bdd->query("SELECT abonnement.year FROM abonnement WHERE abonnement.email_adress='".$email."' AND abonnement.year=(SELECT seasons.year FROM seasons ORDER BY seasons.year DESC LIMIT 1)"); $ans = $rep-> fetch();
            if($ans==""){
                $query="INSERT INTO abonnement (year, email_adress, date, notification_active) VALUES (2022, '".$email."', '2023-02-28', 1)";
                $statement = $bdd -> prepare($query);
                $statement -> execute();
            }
            else{
                $query="DELETE FROM abonnement WHERE abonnement.year=(SELECT seasons.year FROM seasons ORDER BY seasons.year DESC LIMIT 1) AND abonnement.email_adress='".$email."'";
                $statement = $bdd -> prepare($query);
                $statement -> execute();
            }
        } 
    ?>





 
    <div class="container" id ="abo">
        <div class="row">
            <div class="col-lg-6 abonnement">
                <h2> News Letter </h2>
                <form method="post">
                    <input type="submit" id="nw" name="nw" value="Statut :<?php $rep = $bdd -> query("SELECT utilisateur.news_letter FROM utilisateur WHERE utilisateur.email_adress=1");   $ans = $rep-> fetch();$bool = $ans[0];
                            if(!$bool){echo "\nNon abonné";}else{echo "\nabonné";}// pareil pour email adress on remplace par $_SESSION....    ?>">
                      <?php    if($bool){ echo "<style> #nw{background-color:lightgreen; border-radius:20px; width:100px; margin:40px 0; margin-left:35%;} </style>";} else{ echo "<style> #nw{background-color:red;  border-radius:20px; width:100px;margin:40px 0; margin-left:35%;} </style>"; }   ?>  
                   
                </form>

                <h3> Description : </h3>
                <p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Totam cum nesciunt eos nam tempora, possimus ipsum deleniti explicabo inventore
                     id reprehenderit optio perspiciatis dolorem aspernatur tenetur facere debitis! Nihil, necessitatibus.
                </p>
            </div>


            <div class="col-lg-6 abonnement">
                <h2> Actualités saison en cours (<?php $rep = $bdd -> query("SELECT seasons.year FROM seasons ORDER BY seasons.year DESC LIMIT 1"); $ans = $rep->fetch(); echo $ans[0];?>)</h2>



                <form method="post">
                    <input type="submit" id="actu-saison" name="actu" value="Statut :<?php $rep = $bdd -> query("SELECT abonnement.year FROM abonnement WHERE abonnement.email_adress=1 AND abonnement.year=(SELECT seasons.year FROM seasons ORDER BY seasons.year DESC LIMIT 1)"); $ans = $rep-> fetch();
                        if($ans==""){echo "\nNon abonné"; $bool=FALSE;}else{$bool=TRUE; echo "\nabonné";} // pour email_adresse on remplace par $_SESSION['client']['email_adress'] récupéré au moment de la connection  ?> ">  
               <?php         if($bool){ echo "<style> #actu-saison{background-color:lightgreen;  border-radius:20px; width:100px; margin:40px 0; margin-left:35%;} </style>";} else{ echo "<style> #actu-saison{background-color:red; border-radius:20px; width:100px; margin:40px 0; margin-left:35%;} </style>"; }   ?> 
                    
                    <h3> Description : </h3>
                    <p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Totam cum nesciunt eos nam tempora, possimus ipsum deleniti explicabo inventore
                        id reprehenderit optio perspiciatis dolorem aspernatur tenetur facere debitis! Nihil, necessitatibus.
                    </p>
            </div>
        </div>
    </div>




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


  <script>
    function changerActu(){
      if(bool){
       $("#actu-saison").html("Statut : Non abonné");
       $("#actu-saison").css("background-color", "red"); 
       <?php 
        $query="DELETE FROM abonnement WHERE abonnement.year=(SELECT seasons.year FROM seasons ORDER BY seasons.year DESC LIMIT 1) AND abonnement.email_adress=2";
        $statement = $bdd -> prepare($query);
        $statement -> execute();
       ?>
      } 
      else{
      $("#actu-saison").html("Statut : abonné"); 
      $("#actu-saison").css("background-color", "lightgreen");  
      <?php 
        $query="INSERT INTO abonnement (year, email_adress, date, notification_active) VALUES (2022, 2, '2023-02-28', 1)";
        $statement = $bdd -> prepare($query);
        $statement -> execute();
      ?>
      }
    }
    
    $("#actu-saison").click(changerActu());

    </script>
    
</body>
</html>