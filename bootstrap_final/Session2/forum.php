<!DOCTYPE html>
<html lang="fr">
    <head>

    <?php 
      require("../fonction.php");
      $bdd = getBD();
      session_start();
      ?> 
    <title> Forum </title>
    
    <meta charset="UTF-8">
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


  <!-- Menu -->
  <div class="container" id="menu">
    <div class="row">
      <div class="col-lg-3">
        <button onclick="window.location.href='./creation_topic.php'"> Lancer un Topic </button>
      </div>
      <div class="col-lg-3">
        <button> Mon activité </button>
      </div>
      <div class="col-lg-2">
        <button> Trier Topics </button>
      </div>
      <div class="col-lg-4">
        <input value="Je suis une barre de recherche">
      </div>
    </div>
  </div>

  <!-- Proposition topics --> 

  <?php

  $q = "SELECT utilisateur.prenom, topic.titre, message.contenu FROM utilisateur, topic, message WHERE utilisateur.email_adress=topic.email_adress AND message.message_prec_id=-1 AND message.topic_id=topic.topic_id AND message.email_adress=topic.email_adress LIMIT 3";
  $rep = $bdd -> query($q); $data = $rep -> fetchAll();
  $q2 = "SELECT utilisateur.prenom, COUNT(message.message_id)+COUNT(reaction.message_id) AS interactions FROM utilisateur, message, reaction, topic WHERE ((utilisateur.email_adress=message.email_adress AND message.date_msg > CURRENT_TIMESTAMP-7)  OR (utilisateur.email_adress=reaction.email_adress AND reaction.date_reac > CURRENT_TIMESTAMP-7)) GROUP BY utilisateur.prenom ORDER BY interactions DESC LIMIT 3";
  $rep = $bdd -> query($q2); $contributeurs = $rep -> fetchAll();

// Requete des topics de la semaine à modifier pour obtenir les plus populaires --> Order by Count de reaction + message mais nécessite double requete car filtré sur les message_id=-1

  ?>

  <div class='container'>
    <h2> Topics de la semaine </h2>
    <div class="row"> 
        <!-- Topics -->
        <?php 
        if(count($data)>0){
          echo "<div class='container'><div class='col-lg-9'>";
          for($i=0; $i<count($data); $i++){
            echo "<p>".$data[$i]["titre"]." par ".$data[$i]["prenom"]." : ".$data[$i]["contenu"]." </p>";
          }
          echo "</div>  <div class='col-lg-3'> <h3> Principaux contributeurs : </h3>";
          for($i=0; $i<count($contributeurs); $i++){
            echo "<p>".($i+1)." : ".$contributeurs[$i]["prenom"]." (".$contributeurs[$i]["interactions"].") </p>";
          }
          echo "</div></div>";
        }
        else{
          echo "<h3> Il n'y a pas eu d'activité récemment... Lancez un topic ! </h3>";
        }
        ?>
    </div>
  </div>

  <!-- A décliner en Topics recommandés pour vous / Topics les plus populaires ....
      







</body>
</html>