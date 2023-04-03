<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">  
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  
	<link rel="stylesheet" href="../style_in.css" type="text/css">

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
        $q = "SELECT * FROM circuits WHERE circuits.circuitId=:id";
        $statement = $bdd->prepare($q);
        $id = htmlspecialchars($_GET['id']); $statement -> bindParam(':id', $id); 
        $rep = $statement -> execute();
        if(!$rep){
            echo "a problem occur during the request to the BD";
            die;
        }
        else{
            $infos = $statement -> fetch(); $nb_infos = count($infos, $mode=0); 
            # Un circuit contient un circuitID (inutil pour client), circuitRef, name, location, country, url wikipedia
            # Possible ajout de photo (url_photo)
            # Le nombre d'éléments à diviser par 2 car à la fois la clé int et la clé str 
      /*      if(isset($infos['url_profil'])){
                echo "<link rel='icon' href=".$infos["url_profil"].">";
            }
            else{
                echo '<link rel="icon" type="image/png" sizes="16x16" href="../images/profil.png">';
            }  */ //Ne fonctionne pas, code html se met à jour mais pas d'évolution sur la page web -> EDGE
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

        <img  id="circuits_indi" src= "<?php echo $infos['url_photo']; ?>"  alt='photo du pays'>
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
                  while($i<3){
                    echo $elements[$i]->plaintext;
                    echo "<br>";
                    $i++;// changer le css balise a
                  } ?>
                  <a href= "<?php echo $url; ?>" >  Plus d'infos. </a>

            </p>
        </div>

				
        <div class="col-lg-6" id="stats">
         <?php $rep = $bdd -> query("SELECT circuits.url_photo FROM circuits WHERE circuits.circuitId=".$infos["circuitId"]); $nb = $rep -> fetch(); echo "<img id='img_cir_ind'src='".$nb['url_photo']."'>"; ?>
        <ul class="list-group list-group-dark" data-bs-theme="dark">
            <li class="list-group-item list-group-item-dark"> Localisation : <?php $rep = $bdd -> query("SELECT circuits.location, circuits.country FROM circuits WHERE circuits.circuitId=".$infos["circuitId"]); $nb = $rep -> fetch(); echo $nb[0].", ".$nb[1];?> </li>
            <li class="list-group-item list-group-item-dark"> Latitude : <?php $rep = $bdd -> query("SELECT circuits.lat FROM circuits WHERE circuits.circuitId=".$infos["circuitId"]); $nb = $rep -> fetch(); echo $nb[0];?> </li>
            <li class="list-group-item list-group-item-dark"> Longitude : <?php $rep = $bdd -> query("SELECT circuits.lng, circuits.country FROM circuits WHERE circuits.circuitId=".$infos["circuitId"]); $nb = $rep -> fetch(); echo $nb[0];?> </li>
            <!-- Ajouter les coordonnées -->
            <li class="list-group-item list-group-item-dark"> Dernier grand prix accueilli : <?php $query = "SELECT races.name, races.raceId, races.date FROM races, circuits WHERE races.circuitId=circuits.circuitId AND circuits.circuitId=".$infos["circuitId"]." ORDER BY races.date DESC LIMIT 1";$rep = $bdd -> query($query);
            $nb = $rep -> fetch(); echo "<a id='lien' href='../gps/gp.php?id=".$nb[1]."'>".$nb[0]." (".$nb[2].") </a>";?> </li>

        </ul>
        </div>
    </div>
</div>

  <div class="container-fluid" id="courses">

    <h2 id= "code">  Top 3 des vainqueurs sur le circuit :</h2>
    <?php $rep = $bdd -> query("SELECT COUNT(results.position) AS nb, drivers.forename, drivers.surname FROM drivers, results, circuits, races WHERE results.driverId=drivers.driverId AND results.position=1 AND circuits.circuitId=races.circuitId AND races.raceId=results.raceId AND circuits.circuitId=".$infos["circuitId"]." GROUP BY drivers.driverId ORDER BY nb DESC LIMIT 3"); $nb = $rep -> fetchAll();
    echo "<table class='table table-dark table-striped'> <tr class='table-dark'> <td class='table-dark'> Nombre de victoires </th> <td class='table-dark'> Pilote </th> </tr>";
    for($i=0; $i<count($nb); $i++){
      echo "<tr class='table-dark'> <td class='table-dark'>".$nb[$i]['nb']."</td><td>".$nb[$i]["forename"]." ".$nb[$i]["surname"]."</td></tr>";
    }
    ?>
    </table>

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