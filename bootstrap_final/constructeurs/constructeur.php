<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">  
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="./liker.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
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
        $q = "SELECT * FROM constructors WHERE constructors.constructorId=:id";
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
			  <a class="nav-link" href="constructeurs.php">Constructeurs</a>
			</li>
		  </ul>
		  
		  <form class="d-flex" action="../recherche.php" method="get">
                    <input class="form-control me-2" type="text" placeholder="Search" name="search">
                  <button class="btn btn-danger" type="submit">Search</button>
                </form>
		  
		</div>
	  </div>
	</nav>
	

	
	<!--STATS-->
	


    <div class="d-flex flex-row" id="title">
        <div class="p-2">

        <img  id="const_indi" src= "<?php echo $infos['url_photo']; ?>"  alt='photo du pays'>
        </div>
        <div class="p-2">
        <h1 id="pilotes_title"> <?php echo $infos["name"];?></h1>
    </div>
    <div class="p-2">
      <button class="btn btn-outline-danger" id="like">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16" id="coeur">
            <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
          </svg>
      </button>
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
               <h2 id= "code">  L'essentiel :</h2>
               <ul class="list-group list-group-dark" data-bs-theme="dark">
               <li class="list-group-item list-group-item-dark"> Pays d'Origine : <?php $rep = $bdd -> query("SELECT constructors.nationality FROM constructors WHERE constructors.constructorId=".$infos["constructorId"]); $nb = $rep -> fetch(); echo traduireNationalite($nb[0]);?> </li>
               <li class="list-group-item list-group-item-dark"> Pilotes associés : <?php $rep = $bdd -> query("SELECT DISTINCT drivers.forename, drivers.surname, drivers.driverId FROM drivers, results, constructors, races WHERE constructors.constructorId=results.constructorId AND results.driverId=drivers.driverId AND constructors.constructorId=".$infos["constructorId"]." AND races.raceId=results.raceId ORDER BY races.date DESC");
                              $nb = $rep -> fetchAll();

               echo "<ul id='pilote-list'>"; for($i=0; $i<count($nb); $i++){
               echo "<li> <a id='lien' href='../pilotes/pilote.php?id=".$nb[$i]["driverId"]."'> ".$nb[$i]["forename"]." ".$nb[$i]["surname"]." </a></li>";
               }
               echo "</ul>";
               ?> </li>
               <li class="list-group-item list-group-item-dark"> Nombre de victoire depuis 2010 : <?php $rep = $bdd -> query("SELECT COUNT(results.position) AS nb FROM results, constructors WHERE results.position=1 AND results.constructorId=constructors.constructorId AND constructors.constructorId=".$infos["constructorId"]);
               $nb = $rep -> fetch();
               echo $nb["nb"];
            ?>

        </ul>
    </div>




		<div class="container-fluid" id="courses">
                <h3> Une Sélection des meilleurs pilotes : </h3>
                    <?php 
                      $rep = $bdd -> query("SELECT COUNT(results.position) AS nb, drivers.forename, drivers.surname FROM drivers, results, constructors WHERE constructors.constructorId=results.constructorId AND results.driverId=drivers.driverId AND results.position=1 AND constructors.constructorId=".$infos["constructorId"]." GROUP BY drivers.driverId ORDER BY nb DESC");
                      $nb = $rep -> fetchAll(); 
                      if(count($nb)==0){
                        echo "<p> Aucun pilote victorieux";
                      }else{
                        echo "<table class='table table-dark table-striped'> <tr class='table-dark'> <td class='table-dark'> Pilote </th> <td class='table-dark'> Nombre de victoire </th> </tr>";
                        for($i=0;$i<count($nb); $i++){
                          echo "<tr class='table-dark'> <td class='table-dark'>".$nb[$i]["forename"]." ".$nb[$i]["surname"]."</td> <td class='table-dark'>".$nb[$i]["nb"]."</td></tr>";
                        }
                        echo "</table>";
                      }
                    ?>
                </div>
				
            </div>
      

   
   
    </div>
	
	
    <script>
          loged = <?php if(isset($_SESSION["utilisateur"])){
            $q = "SELECT COUNT(*) FROM liker_constructor WHERE liker_constructor.email_adress='".$_SESSION["utilisateur"]["email_adress"]."' AND liker_constructor.constructorId=".$infos["constructorId"];
            $rep = $bdd -> query($q); $ans = $rep -> fetch(); if($ans[0]>0){ $liked = "true";} else{ $liked="false";}
              echo "true";
          }
          else{
            echo "false";
          }
          ?>;
          let liked = <?php if(isset($liked)){ echo $liked; }else{ echo "false";} ?>;
          if(liked){
            $("#like").attr("class", "btn btn-danger");
          }

          let email = "<?php if(isset($_SESSION["utilisateur"])){ echo $_SESSION["utilisateur"]["email_adress"];}else{ echo "none";}  ?>";
          let id = <?php echo $infos["constructorId"]; ?>;
          if(loged){
            $("#like").click(function(){
              like(email, id, liked);
              if(liked){
                liked = false;
              }
              else{
                liked = true;
              }
              console.log("liked : "+liked);
            });
          }
          else{
            $("#like").click(function(){
              let bool = confirm("Vous devez être connecté pour aimer un pilotes, souhaitez vous être redirigé vers une page de connexion?");
              if(bool){
                window.location.href="../utilisateur/connexion.php";
              }
            })
          }
        </script>
    
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