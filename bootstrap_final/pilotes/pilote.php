<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">  
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="./liker.js"></script>
   
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
	  <link rel="stylesheet" href="../style_in.css" type="text/css">
     <script src="./graphiques.js"></script>
    
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
		  <a href="../utilisateur/favoris.php" id="fav">Mes Favoris</a>
		  <a href="../utilisateur/abonnement.php" id="abon">Mes Abonnements</a>
		  <a href="../utilisateur/parier.php">Parier</a>
		  <a href="../bd.php">Base de Données</a>

      <script>
        loged = <?php if(isset($_SESSION['utilisateur'])){ echo "true"; }else{ echo "false";}?>;
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
                    <input class="form-control me-2" type="text" placeholder="Search" name="search">
                  <button class="btn btn-danger" type="submit">Search</button>
                </form>
		  
		</div>
	  </div>
	</nav>


	

	
	<!--STATS-->

    <div class="d-flex flex-row" id="title">
    <div class="p-2">
    <img  id="p_indi" src= "<?php echo $infos['url_photo']; ?>"  alt='photo du pilote'>
    </div>
    <div class="p-2">
    <h1 id="pilotes_title"> <?php echo $infos["forename"]." ".$infos["surname"];?></h1>
    </div>
    <div class="p-2">
      <button class="btn btn-outline-danger" id="like">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16" id="coeur">
            <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
          </svg>
      </button>
    </div>
    </div>
	
     
<div>
    <div class="container-fluid" id="first" >
        <div class="row">
        <div class="col-lg-6" id="stats">
            <h2 id= "code">  <?php if(isset($infos["code"])){ echo $infos["code"]; } ?> </h2>
            <ul class="list-group list-group-dark" data-bs-theme="dark">
            <li class="list-group-item list-group-item-dark"> Nom : <?php if(isset($infos["surname"])){ echo $infos["surname"]; } ?> </li>
            <li class="list-group-item list-group-item-dark"> Prénom : <?php if(isset($infos["forename"])){ echo $infos["forename"]; } ?> </li>
            <li class="list-group-item list-group-item-dark"> Numéro : <?php if(isset($infos["number"])){ echo $infos["number"]; } ?> </li>
            <li class="list-group-item list-group-item-dark"> Date de naissance : <?php if(isset($infos["dob"])){ echo $infos["dob"]; } ?> </li>
            <li class="list-group-item list-group-item-dark"> Nationalité : <?php if(isset($infos["nationality"])){ echo traduireNationalite($infos["nationality"]); } ?> </li>
            </ul>
        </div>


        <div class="col-lg-6" id="courses">
            <h5> Biographie </h5>
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
	
	
    <script>
          let loged = <?php if(isset($_SESSION["utilisateur"])){
            $q = "SELECT COUNT(*) FROM liker_pilote WHERE liker_pilote.email_adress='".$_SESSION["utilisateur"]["email_adress"]."' AND liker_pilote.driverId=".$infos["driverId"];
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
            let id = <?php echo $infos["driverId"]; ?>;

          if(loged){
            $("#like").click(function(){
              like(email, id, liked);
              if(liked){
                liked = false;
                $("#like").attr("class", "btn btn-outline-danger");
              }
              else{
                liked = true;
                $("#like").attr("class", "btn btn-danger");
              }
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

<div class="container"> 
  <div class="row">
    <div class="col-lg-3 bd">
      <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span id="evo">Graphiques évolutifs</span> 
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <button class='dropdown-item' id="btn-vic"> Victoire par saison </button>
          <button class='dropdown-item' id='btn-pod'> Podium par saison </button>
        </div>
      </div>
    </div>
    <div class="col-lg-3 bd">
      <div class="row">
        <div class="col-lg-8" id="ponc">
          <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span id="ponct">Graphiques Ponctuels</span> 
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <button class='dropdown-item' id="status"> Status </button>
              <button class='dropdown-item' id="classement"> Classements </button>
            </div>
          </div>
        </div>
        <div class="col-lg-4" id="saison">
      <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span id="sais">Saison</span> 
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <?php 
            $q = "SELECT DISTINCT races.year FROM races, results, drivers WHERE races.raceId=results.raceId AND results.driverId=drivers.driverId AND drivers.driverId=".$infos["driverId"]." ORDER BY races.year DESC";
            $rep = $bdd -> query($q); $year = $rep -> fetchAll();
            for($i=0; $i<count($year); $i++){
              echo "<button class='dropdown-item year'>".$year[$i][0]."</button>";
            }

          ?>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>


<div class="graphique" id="graph1">
  <canvas id="chart"></canvas>
</div>

<style>
  .graphique{
    height: 300px;
    width: 60%;
    margin: 40px auto;
  }
  #chartV{
    background-color: lightblue;
  }
  #saison{
    display:none;
    padding-left:0;
    margin-left:0;
  }
  .bd {
    padding: 0 10px;
  }
  #ponc{
    margin-right:0;
    padding-right:0;
  }

</style>

<script>
id =<?php echo $infos["driverId"]; ?>;

$("#btn-vic").click(function(){
  nbVicParSaison(id);
  $("#saison").css("display", "none");
  $("#evo").html("Evolution des victoires");
  $("#ponct").html("Graphiques ponctuels");

 // $("#graph1").css("display", "block");
});
$("#btn-pod").click(function(){
  nbPodParSaison(id);
  $("#saison").css("display", "none");
  $("#evo").html("Evolution des Podiums");
  $("#ponct").html("Graphiques ponctuels");
//   $("#graph2").css("display", "block");
});

$("#status").click(function(){
  status(2022);
  $("#saison").css("display", "block");
  $("#ponct").html("Status de la saison : ");
});
$(".year").click(function(){
  $("#sais").html($(this).html());
  $("#evo").html("Graphiques évolutifs");
  
  let type = $("#ponct").text();
  if(type=="Status de la saison : "){
     status($(this).html());
  }
  else if(type=="Classements de la saison : "){
    classement($(this).html()); 
  }
})
$("#classement").click(function(){
  classement(2022);
  $("#saison").css("display", "block");
  $("#evo").html("Graphiques évolutifs");
  $("#ponct").html("Classements de la saison : ");
})


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