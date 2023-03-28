<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">  
    <link rel="icon" href="./images/icon.jpg">
    <link rel="stylesheet" href="./styles/style.css" type="text/css">
	<link rel="stylesheet" href="./style_in.css" type="text/css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
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
	
	
	
	<title>Base de données</title>
</head>




<body >

	
	<!-- NAV BAR -->
	
	<nav class="navbar navbar-expand-sm navbar-dark bg-dark ">
	<div class="container-fluid">
	
		
		<div id="mySidebar" class="sidebar">
		  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

		  <?php
		  if (isset($_SESSION['utilisateur'])){
		  	echo "".$_SESSION['utilisateur']['nom']." ".$_SESSION['utilisateur']['prenom'];
		  	}
		  ?>
		  <a href="#">Mes Favoris</a>
		  <a href="#">Mes Abonnements</a>
		  <a href="./utilisateur/parier.php">Parier</a>
		  <a href="./bd.html">Base de Données</a>

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
			  <a class="nav-link" href="./index.php">Accueil</a>
			</li>
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
		  
		  <form class="d-flex">
			<input class="form-control me-2" type="text" placeholder="Search">
			<button class="btn btn-danger" type="button">Search</button> 
		  </form>
		  
		  </div>
	  </div>
	</nav>
		  
		  
		<!--explication -->  
		  
	<div class="p-5 bg-secondary text-white text-center">
		<h2>Téléchargements</h2>
		<br>
		<p>
		Lorem ipsum dolor sit amet, consectetur adipisicing elit. 
		Excepturi repellat laboriosam culpa odit similique aliquam 
		nulla exercitationem dolorum, ad laborum, dicta, minus voluptatum
		suscipit aspernatur eveniet laudantium magnam incidunt rem.
		Recusandae eos labore voluptas velit non dicta temporibus, 
		vero dolorem dolores adipisci minima iste necessitatibus 
		voluptate aliquid hic magni quibusdam?
		
		</p>
		</div>	  
		
		
		
 <!--tableau-->	  
    <div id="bd-descr">
        <h2> L'export de la base de données comprend : </h2>
        <table class="table" id="tableau">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nom de la table</th>
                <th scope="col">Données</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">1</th>
                <td>Circuits</td>
                <td>(IdCircuit, Nom, latitude, longitude, ...)</td>
              </tr>
              <tr>
                <th scope="row">2</th>
                <td>Pilotes</td>
                <td>(IdPilote, Nom, Prénom, Nationalité, ... )</td>
              </tr>
              <tr>
                <th scope="row">3</th>
                <td>Constructeurs</td>
                <td>(IdConstructeur, Nom, ... )</td>
              </tr>
              <tr>
                <th scope="row">4</th>
                <td>Courses</td>
                <td>(IdCourse, Année, Round, IdCircuit, ... )</td>
              </tr>
              <tr>
                <th scope="row">5</th>
                <td>Résultats</td>
                <td>(IdResultat, IdCourse, IdPilotes, IdConstructeur, ... )</td>
              </tr>
              <tr>
                <th scope="row">6</th>
                <td>Saisons</td>
                <td>(Annéee, lien wikipedia)</td>
              </tr>
              <tr>
                <th scope="row">7</th>
                <td>Status</td>
                <td>(IdStatus, Status)</td>
              </tr>
              <tr>
                <th scope="row">8</th>
                <td>Pit Stops</td>
                <td>(IdCourse, IdPilote, durée, ... )</td>
              </tr>


            </tbody>
          </table>
    </div>
	
	
	
    <!--téléchargement -->
    <div class="container-fluid" id="téléchargement">
        
		
		<div class="row">
            <div class="col-lg-4">
                <div class="download">
                    <h5> Télécharger au format <strong>CSV</strong></h5>
                    <div class="btn-container" id = "btn_telechargement">
                        <button class="btn btn-dark" > Télécharger (.csv) </button>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="download">
                    <h5> Télécharger au format <strong>SQL</strong></h5>
                    <div class="btn-container"id = "btn_telechargement">
                        <button class="btn btn-dark"> Télécharger (.sql) </button>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="download">
                    <h5> Télécharger au format <strong>XLSX</strong></h5>
                    <div class="btn-container" id = "btn_telechargement">
                        <button class="btn btn-dark"> Télécharger (.xlsx) </button>
                    </div>
                </div>
            </div>
        </div>
    </div>



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