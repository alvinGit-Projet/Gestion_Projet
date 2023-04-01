<!DOCTYPE html>
<html lang="fr">
    <head>
        <title> Inscription </title>
        <link rel="stylesheet" href="../style_in.css" type="text/css">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">  
        
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

	<style>

	</style>


		
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
		  <a href="../parier.php">Parier</a>
		  <a href="../bd.html">Base de Données</a>

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
		  <form class="d-flex" action="../recherche.php" method="get">
			<input class="form-control me-2" type="text" name="search" placeholder="Search">
			<button class="btn btn-danger" type="submit">Search</button> 
		  </form>

		  
		</div>
	  </div>
	</nav>	
	
	
	
	
	
	
	
<!-- NOTRE FORM -->


<section class="vh-100 bg-image">
  <div class="mask d-flex align-items-center h-100 gradient-custom-3">
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-9 col-lg-7 col-xl-6">
          <div class="card" style="border-radius: 15px;">
            <div class="card-body p-5">
              <h2 class="text-uppercase text-center mb-5">Inscription</h2>

              <form method="post" action="enregistrement.php" autocomplete="off" >

                <div class="form-outline mb-4">
                  <input type="text" id="form3Example1cg" class="form-control form-control-lg" name="n" 
				  value="<?php if (isset($_GET['n'])) {
            echo $_GET['n'];} 
			else {echo ""; } ?>" />
                  <label class="form-label" for="form3Example1cg">Nom</label>
                </div>
				
				

                <div class="form-outline mb-4">
                  <input type="text" id="form3Example3cg" class="form-control form-control-lg" name="p" 
				  value="<?php if (isset($_GET['p'])) {
            echo $_GET['p'];} 
			else {echo ""; } ?>"/>
                  <label class="form-label" for="form3Example3cg"> Prénom</label>
                </div>
				
				<div class="form-outline mb-4">
                  <input type="email" id="form3Example3cg" class="form-control form-control-lg" name="mail" 
				  value="<?php if (isset($_GET['mail'])) {
            echo $_GET['mail'];} 
			else {echo ""; } ?>"/>
                  <label class="form-label" for="form3Example3cg"> Adresse Email</label>
                </div>

                <div class="form-outline mb-4">
                  <input type="password" id="form3Example4cg" class="form-control form-control-lg" name="mdp1" 
				  value="<?php if (isset($_GET['mdp1'])) {
            echo $_GET['mdp1'];} 
			else {echo ""; } ?>"  />
                  <label class="form-label" for="form3Example4cg">Mot de Passe</label>
                </div>

                <div class="form-outline mb-4">
                  <input type="password" id="form3Example4cdg" class="form-control form-control-lg" name="mdp2" 
				  value="<?php if (isset($_GET['mdp2'])) {
            echo $_GET['mdp2'];} 
			else {echo ""; } ?>"/>
                  <label class="form-label" for="form3Example4cdg"> Confirmer Votre Mot de Passe</label>
                </div>


                <div class="d-flex justify-content-center">
                  <button type="input"
                    class="btn btn-danger btn-block btn-lg gradient-custom-4 text-body"> Valider </button>
                </div>

                <p class="text-center text-muted mt-5 mb-0"> Déjà inscrit ? <a href="connexion.php"
                    class="fw-bold text-body"><u> Se Connecter </u></a></p>

              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>




<!-- FOOTER -->

  <footer class="bg-dark text-center text-lg-start text-white" id ="utilisateur">
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