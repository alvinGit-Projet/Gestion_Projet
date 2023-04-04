<!DOCTYPE html>
<html lang="fr">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">  

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
      $loged = false;
		  if (isset($_SESSION['utilisateur'])){
		  	echo "<p style='text-align:center'> Bonjour ".$_SESSION['utilisateur']['nom']." ".$_SESSION['utilisateur']['prenom']."</p>";
        $loged = true;
      }
		  ?>
		  <a href="./utilisateur/favoris.php" id="fav">Mes Favoris</a>
		  <a href="./utilisateur/abonnement.php" id="abon">Mes Abonnements</a>
		  <a href="./utilisateur/parier.php">Parier</a>
		  <a href="#">Base de Données</a>

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
		  
	<div class="d-flex flex-row" id="title">
        <div class="p-2">
		 <h1 id="pilotes_title"> Téléchargements</h1>
		</div>
		</div>



		
		
		
 <!--tableau-->
 <div class="container-fluid" id="courses">
        <h3> L'export de la base de données comprend : </h3>
        <table class='table table-dark table-striped'>

              <tr class='table-dark'>
                <td class='table-dark'> Tables </th>
                <td class='table-dark'> Description</th>
              </tr>

              <tr class='table-dark'>
                <td class='table-dark'> Circuits</td>
                <td class='table-dark'> (IdCircuit, Nom, latitude, longitude, ...)</td>
              </tr>
              <tr class='table-dark'>
                <td class='table-dark'> Pilotes</td>
                <td class='table-dark'> (IdPilote, Nom, Prénom, Nationalité, ... )</td>
              </tr>
              <tr class='table-dark'>
                <td class='table-dark'> Constructeurs</td>
                <td class='table-dark'> (IdConstructeur, Nom, ... )</td>
              </tr>
              <tr class='table-dark'>
                <td class='table-dark'> Courses</td>
                <td class='table-dark'> (IdCourse, Année, Round, IdCircuit, ... )</td>
              </tr>
              <tr class='table-dark'>
                <td class='table-dark'> Résultats</td>
                <td class='table-dark'> (IdResultat, IdCourse, IdPilotes, IdConstructeur, ... )</td>
              </tr>
              <tr class='table-dark'>
                <td class='table-dark'> Saisons</td>
                <td class='table-dark'> (Annéee, lien wikipedia)</td>
              </tr>
              <tr class='table-dark'>
                <td class='table-dark'> Status</td>
                <td class='table-dark'> (IdStatus, Status)</td>
              </tr>
              <tr class='table-dark'>
                <td class='table-dark'> Pit Stops</td>
                <td class='table-dark'> (IdCourse, IdPilote, durée, ... )</td>
              </tr>

          </table>
	    </div>
	
	
       <!--téléchargement -->
       <div class="container-fluid">


        <h5> Télécharger au format <strong>CSV</strong></h5>
        <div class="btn_telechargement" >
         <a href="./f1.csv" download="f1.csv">
          <button type="button" class="btn btn-dark btn-floating">
           <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" class="bi bi-download" viewBox="0 0 16 16" > <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/> <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/> </svg>
             (.csv)
          </button>
         </a>

        <h5> Télécharger au format <strong>CSV</strong></h5>


        <h5> Télécharger au format <strong>CSV</strong></h5>



   		<div class="d-flex flex-row align-items-center">
               <h5> Télécharger au format <strong>CSV</strong></h5>
               </div>
                 <div class="p-2" id = "btn_telechargement">
                 <a href="./f1.csv" download="f1.csv">
                  <button type="button" class="btn btn-dark btn-floating">
                   <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" class="bi bi-download" viewBox="0 0 16 16" > <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/> <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/> </svg>
                     (.csv)
                  </button>
                 </a>
               </div>
                </div>
               </div>
               </div>

            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                   <h5> Télécharger au format <strong>SQL</strong></h5>
                   </div>
                     <div class="flex-grow-1 " id = "btn_telechargement">
                     <a href="./f1.sql" download="f1.sql">
                      <button type="button" class="btn btn-dark btn-floating">
                       <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" class="bi bi-download" viewBox="0 0 16 16" > <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/> <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/> </svg>
                          (.sql)
                      </button>
                     </a>
                   </div>
                    </div>
                   </div>
                   </div>

           <div class="d-flex align-items-center">
               <div class="flex-shrink-0">
                  <h5> Télécharger au format <strong>XLSX</strong></h5>
                  </div>
                    <div class="flex-grow-1 " id = "btn_telechargement">
                    <a href="./f1.xlsx" download="f1.xsls">
                     <button type="button" class="btn btn-dark btn-floating">
                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" class="bi bi-download" viewBox="0 0 16 16" > <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/> <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/> </svg>
                         (.sql)
                     </button>
                    </a>
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