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
        $q = "SELECT * FROM races WHERE races.raceId=:id";
        $statement = $bdd->prepare($q);
        $id = htmlspecialchars($_GET['id']); $statement -> bindParam(':id', $id); 
        $rep = $statement -> execute();

        if(!$rep){
          echo "a problem occur during the request to the BD";
          die;
        }
        else{
          $infos = $statement -> fetch(); $nb_infos = count($infos, $mode=0); 
          $add = "UPDATE races SET visites=visites+1 WHERE races.raceId=".$infos["raceId"];
          $bdd -> query($add);
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
			  <a class="nav-link" href="gps.php">Grands Prix</a>
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
	
    <div class="container-fluid" id="title">
        <h2> <?php echo $infos["name"];?></h2>
    </div>

	
	
     
    <div>
        <div class="container-fluid" id="stats" >
           
                    <h2> Informations </h2>
                    <ul class='infos-pilotes'>
                        <li> Saison : <?php echo $infos["date"]; ?> (<?php echo $infos["time"]; ?>)  </li>
                        <li> Vainqueur : <?php $rep = $bdd -> query("SELECT drivers.forename, drivers.surname FROM drivers, results, races WHERE drivers.driverId=results.driverId AND results.raceId=races.raceId AND  results.position=1 AND races.raceId=".$infos["raceId"]); $nb = $rep -> fetch(); echo $nb[0]." ".$nb[1];?> </li>
                        <li> Circuit : <?php $rep = $bdd -> query("SELECT circuits.name FROM circuits, races WHERE races.circuitId=circuits.circuitId AND races.raceId=".$infos["raceId"]); $nb = $rep -> fetch(); echo "<a id='lien' href='../circuits/circuit.php?id=".$infos["circuitId"]."'> ".$nb[0]." </a>";?> </li>
                        <li> Localisation : <?php $rep = $bdd -> query("SELECT circuits.location, circuits.country FROM circuits, races WHERE circuits.circuitId=races.circuitId AND races.raceId=".$infos["raceId"]); $nb = $rep -> fetch(); echo $nb[0].", ".$nb[1]; ?> </li>
                        <li> <a href="<?php echo $infos["url"] ?>" id="lien"> Wikipedia  <img src="../images/wikipedia.png" id="wiki"> </a> </li>
                    </ul>
                
				 </div>
		<div class="container-fluid" id="courses">
                <h2> Résultats </h2>
                    <?php 
                      echo "<table class='table'> <tr> <th> Pilote </th> <th> Position </th> <th> Tours </th> <th> Temps </th> </tr>";
                      $rep = $bdd -> query("SELECT drivers.forename, drivers.surname, results.position, results.laps, results.time FROM drivers, results, races WHERE drivers.driverId=results.driverId AND results.raceId=races.raceId AND races.raceId=".$infos["raceId"]);
                      $ans = $rep -> fetchAll(); 
                                    
                      for($i=0; $i<count($ans); $i++){
                        echo "<tr> <td>".$ans[$i]["forename"]." ".$ans[$i]["surname"]."</td> <td>".$ans[$i]["position"]."</td><td>".$ans[$i]["laps"]."</td><td>".$ans[$i]["time"]."</td></tr>";
                      }
                      echo "</table>";

                      $rows = [];
                      foreach($ans as $l){
                          $rows[] = $l;
                      }

                      print_r($rows);
                    ?>


				
            </div>
        </div>
    </div>






	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
              google.charts.load('current', {'packages':['table']});
              google.charts.setOnLoadCallback(drawTable);

              function drawTable() {
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Name');
                data.addColumn('string', 'Surname');
                data.addColumn('number', 'Position');
                data.addColumn('string', 'Lap');
                data.addColumn('string', 'Time');
                data.addRows([ <?php echo $rows ?>]);

                var table = new google.visualization.Table(document.getElementById('table_div'));

                table.draw(data, {showRowNumber: true, width: '100%', height: '100%'});
              }
       </script>




	
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