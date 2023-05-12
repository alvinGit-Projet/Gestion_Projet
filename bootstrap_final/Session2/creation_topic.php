<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Topic</title>

    <?php 
      require("../fonction.php");
      $bdd = getBD();
      session_start();
      ?> 

    
    <link rel="stylesheet" href="../style_in.css" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">  
    <link rel="stylesheet" href="./forum.css" type="text/css">
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
		  <a href="../utilisateur/favoris.php" id="fav">Mes Favoris</a>
		  <a href="../utilisateur/abonnement.php" id="abon">Mes Abonnements</a>
		  <a href="../utilisateur/parier.php">Parier</a>
		  <a href="../bd.php">Base de Données</a>

      <script>
        let loged = <?php if(isset($_SESSION['utilisateur'])){ echo "true"; }else{ echo "false";}?>;
        if(!loged){
           $("#fav").click(function(event){
            event.preventDefault();
            let bool = confirm("Vous devez être connecté pour accéder à vos favoris, souhaitez vous être redirigé vers une page de connexion?");
            if(bool){
                window.location.href="../utilisateur/connexion.php";
              }
           });
           $("#abon").click(function(event){
            event.preventDefault();
            let bool = confirm("Vous devez être connecté pour accéder à vos abonnements, souhaitez vous être redirigé vers une page de connexion?");
            if(bool){
                window.location.href="../utilisateur/connexion.php";
              }
           })
        }
      </script>

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
			  <a class="nav-link" href="../constructeurs/constructeurs.php">Constructeurs</a>
			</li>
		  </ul>
		  <form class="d-flex" action="../recherche.php" method="get">
                    <input class="form-control me-2" type="text" placeholder="Search" name="search">
                  <button class="btn btn-danger" type="submit">Search</button>
                </form>
		</div>
	  </div>
	</nav>

    <div class="container" id="menu">
    <div class="row">
      <div class="col-lg-4">
        <button id="annulation" onclick="window.location.href='./forum.php'" > Annuler </button>
      </div>
      <div class="col-lg-4">
        <button> Mon activité </button>
      </div>
      <div class="col-lg-4">
        <input value="Je suis une barre de recherche">
      </div>
    </div>
  </div>



    <div class="container">
        <div class="row">
            <p> Titre du Topic : </p>
            <input type="text" value="titre">
        </div>
        <div class="row">
            <p> Exprimez-vous </p>
            <textarea rows="12" cols="40">  </textarea>
        </div> 
        <div class="row bottom">
            <div class="col-lg-3">
                <button> Créer </button>
            </div>
            <div class="col-lg-6">
                <p id="msg-erreur">
            </div>
            <div class="col-lg-3">
                <button onclick="window.location.href='./forum.php'" id="annulation"> Annuler </button>
            </div>
        </div>
    </div>
    






    
</body>
</html>