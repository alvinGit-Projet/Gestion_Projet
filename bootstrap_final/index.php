<!DOCTYPE html>
<html lang="fr">
    <head>

    <?php 
      require("fonction.php");
      $bdd = getBD();
      session_start();
      ?> 

        <title> L'écurie des statistiques</title>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">  
        <link rel="stylesheet" href="./style_in.css" type="text/css">
        <link rel="icon" href="./images/icon.jpg">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"> </script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

        <!-- Include in <head> to load fonts from Google -->
        <link href='https://fonts.googleapis.com/css?family=Lato:100italic' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>

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
	
	<!-- BANDEROLLE -->
	
	<div >
        <img  src="./images/banniere2.png" class="responsive">
	</div>
	
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
		  <a href="./utilisateur/favoris.php" id="fav">Mes Favoris</a>
		  <a href="./utilisateur/abonnement.php" id="abon">Mes Abonnements</a>
		  <a href="./utilisateur/parier.php">Parier</a>
		  <a href="./bd.php">Base de Données</a>

      <script>
        let loged = <?php if(isset($_SESSION['utilisateur'])){ echo "true"; }else{ echo "false";}?>;
        if(!loged){
           $("#fav").click(function(event){
            event.preventDefault();
            let bool = confirm("Vous devez être connecté pour accéder à vos favoris, souhaitez vous être redirigé vers une page de connexion?");
            if(bool){
                window.location.href="./utilisateur/connexion.php";
              }
           });
           $("#abon").click(function(event){
            event.preventDefault();
            let bool = confirm("Vous devez être connecté pour accéder à vos abonnements, souhaitez vous être redirigé vers une page de connexion?");
            if(bool){
                window.location.href="./utilisateur/connexion.php";
              }
           })
        }
      </script>

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
			  <a class="nav-link" href="./pilotes/pilotes.php">Pilotes</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="./gps/gps.php">Grands Prix</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="./circuits/circuits.php">Circuits</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="./constructeurs/constructeurs.php">Constructeurs</a>
			</li>
		  </ul>
		  <form class="d-flex" action="recherche.php" method="get">
                    <input class="form-control me-2" type="text" placeholder="Search" name="search">
                  <button class="btn btn-danger" type="submit">Search</button>
                </form>
		  

		</div>
	  </div>
	</nav>
	

	
	
		<div class="intro">
		<h3>Introduction</h3>

		<p>
		La Formule 1, également connue sous le nom de F1,
		est l'une des compétitions automobiles les plus
		prestigieuses et les plus suivies au monde. Cette
		discipline est considérée comme la catégorie reine
		du sport automobile et attire chaque année des
		millions de fans à travers le monde.
		</p>
        <p>
        Ce sport est une compétition de courses de
        voitures monoplaces, qui se déroule sur des circuits
        spécialement conçus pour cette discipline.
        Les voitures de Formule 1 sont des machines
        hautement sophistiquées, construites selon des
        spécifications strictes pour garantir une performance
        optimale.
        </p>
        <p>
        Les équipes de Formule 1 sont composées de
        deux pilotes et d'un certain nombre d'ingénieurs
        et de mécaniciens qui travaillent ensemble pour
        maximiser les performances des voitures. Chaque
        course de Formule 1 se compose de plusieurs tours
        de piste, avec des arrêts aux stands pour changer
        les pneus et le carburant.
        <br>
        Les courses de Formule 1 sont connues pour
        leur vitesse, leur suspense et leur spectacle.
        Les voitures peuvent atteindre des vitesses allant
        jusqu'à 370 km/h, et les courses sont souvent
        disputées jusqu'à la ligne d'arrivée. Les fans
        de Formule 1 apprécient également la stratégie et
        la tactique qui entrent en jeu lors des courses,
        ainsi que la rivalité intense entre les équipes et
        les pilotes.
        </br>
        </p>
        <p>
        En résumé, la Formule 1 est une compétition
        automobile de premier plan qui attire des fans
         du monde entier grâce à son mélange unique de
         vitesse, de suspense et de compétition acharnée.
         Si vous êtes passionné de sport automobile, la
         Formule 1 est un événement à ne pas manquer.
        </p>
		</div>
	
	
	<!--SLIDE PHOTO -->
	
	<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block w-100" src="./images/rb_slide.png" alt="First slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="./images/merc_slide.png" alt="Second slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="./images/ferrari_slide.png" alt="Third slide">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only"></span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only"></span>
  </a>
</div>
	
	
<div>

<?php

    $sqlQuery = "SELECT COUNT(*) as victoire, drivers.surname
                 FROM results, drivers
                 WHERE results.driverId=drivers.driverId
                 AND results.position=1
                 GROUP BY results.driverId
                 ORDER BY victoire DESC";
    $statement=$bdd->prepare($sqlQuery);
    $rep = $statement -> execute();
    $result = $statement -> fetchAll();

    $data = [];

    foreach ($result as $row) {
        $data[] = $row;
    }


    $dataset = array();
    $labels = array();
    for($i=0; $i<count($data); $i++){
        array_push($dataset, $data[$i]["victoire"]);
        array_push($labels, $data[$i]["surname"]);
    }



        $sqlQuery2 = "SELECT COUNT(*) as victoire, results.constructorId, constructors.name as constructor
                 FROM results, constructors
                 WHERE results.constructorId=constructors.constructorId
                 AND results.position=1
                 GROUP BY results.constructorId
                 ORDER BY victoire DESC
                 LIMIT 5";
    $statement2 = $bdd->prepare($sqlQuery2);
    $rep2 = $statement2->execute();
    $result2 = $statement2->fetchAll();

    $data2 = array();

    foreach ($result2 as $row2) {
        $data2[] = array(
            "victoire" => $row2["victoire"],
            "constructor" => $row2["constructor"]
        );
    }

    $dataset2 = array();
    $labels2 = array();
    foreach ($data2 as $row2) {
        array_push($dataset2, $row2["victoire"]);
        array_push($labels2, $row2["constructor"]);
    }


?>


<center>
<div class="graphique2" >
  <canvas id="graph1"></canvas>
</div>
</center>

<center>
    <div class="graphique2">
        <canvas id="graph2"></canvas>
    </div>
</center>

<style>
.graphique2{
  width: 60%;
  margin-bottom: 60px;
}


</style>


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


<script>

    const data = {
      labels: [<?php for($i=0; $i<count($labels); $i++){
       if($i+1<count($labels)){
         echo '"'.$labels[$i].'", ';
        }
        else{
            echo '"'.$labels[$i].'"';
        }
        } ?>],
        datasets: [{
            label: "Nombre De Victoire",
            data: [<?php for($i=0; $i<count($dataset); $i++){
       if($i+1<count($dataset)){
         echo '"'.$dataset[$i].'", ';
        }
        else{
            echo '"'.$dataset[$i].'"';
        }
        } ?>],
        fill: true,
        backgroundColor: [
                        'rgb(54, 162, 235)',
                    ],


        }]
      };



     const ctx = document.getElementById('graph1');

      new Chart(graph1,  {
        type: 'bar',
        data: data,
        options: {
         indexAxis: 'y',
          elements: {
            line: {
              borderWidth: 7
            }
          },
          plugins: {
                      title: {
                          display: true,
                          text: 'Les 10 pilotes les plus victorieux depuis 2010. '
                      }
                  }
        },
        scales: {
              x: {
                min: -100,
                max: 100,
              },
              y: {
                min: -100,
                max: 100,
              }
            }
      });



    const data2 = {
        labels: <?php echo json_encode($labels2); ?>,
        datasets: [{
            label: 'Victoires par constructeur',
            data: <?php echo json_encode($dataset2); ?>,
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(210, 295, 86)',
                'rgb(200, 205, 07)',
                'rgb(99, 102, 56)'
            ],
            hoverOffset: 5
        }]
    };

    const config = {
        type: 'doughnut',
        data: data2,
        options: {
        responsive:true,
        maintainAspectRatio: true,
          plugins: {
                      title: {
                          display: true,
                          text: 'Les 5 constructeurs les plus victorieux depuis 2010. '
                      }
                  }
        }
    };

    var myChart = new Chart(
        document.getElementById('graph2'),
        config
    );
</script>




