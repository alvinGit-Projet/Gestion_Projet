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
        $q = "SELECT * FROM drivers WHERE drivers.driverId=:id";
        $statement = $bdd->prepare($q);
        $id = htmlspecialchars($_GET['id']); $statement -> bindParam(':id', $id); 
        $rep = $statement -> execute();
        if(!$rep){
            echo "a problem occur during the request to the BD";
            die;
        }
        else{
            $infos = $statement -> fetch(); $nb_infos = count($infos, $mode=0); 
            # Un pilote contient un driverID (inutil pour client), driverRef, Number, nom, prenom, date de naissance, nationality, url wikipedia
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
	
    <title><?php echo $infos["forename"]." ".$infos["surname"];?></title>

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
			  <a class="nav-link" href="pilotes.php">Pilotes</a>
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
	

	
	<!--STATS-->

    <div class="d-flex flex-row" id="title">
    <div class="p-2">
    <img  id="p_indi" src= <?php echo $infos['url_photo']; ?>  alt='photo du pilote'>
    </div>
    <div class="p-2">
    <h1 id="pilotes_title"> <?php echo $infos["forename"]." ".$infos["surname"];?></h1>
    </div>
    </div>
	
     
    <div>
        <div class="container-fluid" id="first" >
            <div class="row">
            <div class="col-lg-6" id="courses">
                <h5> Biographie </h5>
                <p>
                Certe, gaudeo in hoc officio quod mihi datum est ut tibi litteras
                Latine scribam. Latinitas est lingua pulchra et antiqua, quam multos
                annos studui et amo.

                In principio erat Verbum, et Verbum erat apud Deum, et
                Deus erat Verbum. Hoc erat in principio apud Deum. Omnia per
                ipsum facta sunt, et sine ipso factum est nihil, quod factum
                est. In ipso vita erat, et vita erat lux hominum. Et lux in
                tenebris lucet, et tenebrae eam non comprehenderunt.
                </p>

                <p>
                Certe, gaudeo in hoc officio quod mihi datum est ut tibi litteras
                Latine scribam. Latinitas est lingua pulchra et antiqua, quam multos
                annos studui et amo.

                In principio erat Verbum, et Verbum erat apud Deum, et
                Deus erat Verbum. Hoc erat in principio apud Deum. Omnia per
                ipsum facta sunt, et sine ipso factum est nihil, quod factum
                est. In ipso vita erat, et vita erat lux hominum. Et lux in
                tenebris lucet, et tenebrae eam non comprehenderunt.
                </p>

            </div>

                <div class="col-lg-6" id="stats">
                    <h5>  </h5>
                    <ul class="list-group list-group-dark" data-bs-theme="dark">
                    <li class="list-group-item list-group-item-dark"> Nom : <?php if(isset($infos["surname"])){ echo $infos["surname"]; } ?> </li>
                    <li class="list-group-item list-group-item-dark"> Prénom : <?php if(isset($infos["forename"])){ echo $infos["forename"]; } ?> </li>
                    <li class="list-group-item list-group-item-dark"> Date de naissance : <?php if(isset($infos["dob"])){ echo $infos["dob"]; } ?> </li>
                    <li class="list-group-item list-group-item-dark"> Nationalité : <?php if(isset($infos["nationality"])){ echo traduireNationalite($infos["nationality"]); } ?> </li>

                        </ul>
                </div>
				

				
            </div>
        </div>

   
   
   
        <div class="container-fluid" id="bio">
            <div class="row">
                <div class="col-lg-8">
                    <ul class="infos-pilotes">

                    <li > Nombre de participations : <?php $rep = $bdd -> query("SELECT COUNT(results.raceId) FROM results WHERE results.driverId=".$infos["driverId"]); $nb = $rep -> fetch(); echo $nb[0];?>
                                            <li > Nombre de victoire : <?php $rep = $bdd -> query("SELECT COUNT(results.raceId) FROM results WHERE results.position=1 AND results.driverId=".$infos["driverId"]); $nb = $rep -> fetch(); echo $nb[0];?>
                                            <li > Position moyenne : <?php $rep = $bdd -> query("SELECT ROUND(AVG(results.position)) FROM results WHERE results.driverId=".$infos["driverId"]); $nb = $rep -> fetch(); echo $nb[0];?>
                                            <li > Temps moyen par tour : <?php $rep = $bdd -> query("SELECT ROUND(AVG(results.milliseconds)/laps) FROM results WHERE results.driverId=".$infos["driverId"]); $nb = $rep -> fetch(); echo afficherTemps($nb[0]);?>
                                           <li > Tour le plus rapide : <?php $rep = $bdd -> query("SELECT results.fastestLapTime FROM results WHERE results.driverId=".$infos["driverId"]." ORDER BY results.fastestLapTime ASC LIMIT 1;"); $ans = $rep-> fetch(); echo $ans[0]; ?>

                        </ul>

                        <?php
                                              $rep = $bdd -> query("SELECT COUNT(results.statusId) as nb, status.status FROM results, status WHERE results.driverId=".$infos["driverId"]." AND status.statusId=results.statusId GROUP BY results.statusId");
                                              $ans = $rep -> fetchAll();
                                              echo "<ul class='list-group list-group-dark' data-bs-theme='dark'>";
                                              for($i=0; $i<count($ans); $i++){
                                                 echo "<li class='list-group-item list-group-item-dark'>".$ans[$i]["nb"]." : ".$ans[$i]["status"]."</li>";
                                              }
                                              echo "</ul>";
                                           ?>
                </div>
				
				
				
				
                <div class="col-lg-4" id="div_wiki">
                       <a href="<?php echo $infos["url"];  ?>" target="_blank" class="lien-bdp"><img src="../images/wikipedia.png" id="wiki"> </a>
        <!--           <a href="#"><img src="../images/insta.png"></a>  -->
                </div>
            </div>
        </div>
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