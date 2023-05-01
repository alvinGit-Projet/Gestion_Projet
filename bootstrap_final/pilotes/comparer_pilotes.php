<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Outil de comparaison</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
		<link rel="stylesheet" href="pilote.css" type="text/css">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
   <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body>
<script>
	function openNav() {
	  document.getElementById("mySidebar").style.width = "250px";
	  document.getElementById("main").style.marginLeft = "250px";
	}

	function closeNav() {
	  document.getElementById("mySidebar").style.width = "0";
	  document.getElementById("main").style.marginLeft = "0";
	}
	</script>
	
	<?php 
    session_start();
    require("../fonction.php");
    $bdd=getBD();
	?>

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
			  <a class="nav-link" href="./pilotes.php">Pilotes</a>
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
			<input class="form-control me-2" type="text" placeholder="Search">
			<button class="btn btn-danger" type="button">Search</button> 
		  </form>
		  
		</div>
	  </div>
	</nav>

    <style>  
    .ligne-pilote{
        height: 60px; padding: 5px;
        width: 100%;
        background-color:black;
        border:1px solid black;
        margin: 0;
    }
    .ligne-pilote:hover{
        border: 2px solid black;
        background-color: darkred;
    }
    .ligne-pilote img{
        width:50px; height:50px; 
        border-radius:30px;
    }
    #p1, #p2{
        text-align: center;
    }
    #p1 img, #p2 img {
        text-align: center;
        height: 60px; width:60px;
    }
    #p1:hover, #p2:hover{
        cursor: pointer;
    }
    #db-graphe{
      height:600px;
    }
    .dropdown-menu{
      background-color: black;
    }
    .dropdown-item:hover{
      background-color: black;
    }


    </style>

    <?php 
    $q = "SELECT drivers.forename, drivers.surname, drivers.url_photo, drivers.driverId, drivers.code FROM drivers ORDER BY drivers.code ASC"; $ans = $bdd -> query($q); $rep = $ans -> fetchAll();
    $total = count($rep); $imax = $total/6; $i=0;
    ?>



    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-2">
          <div class="dropdown">
            <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php
              $code1 = $rep[$i]["code"]; $code2 = $rep[$imax-1]["code"];
              echo $code1." - ".$code2;
              ?>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <?php 
              while($i<$imax){
                echo "<button class='dropdown-item'><p class='ligne-pilote' id='".$rep[$i]["driverId"]."'>".$rep[$i]["forename"]." ".$rep[$i]["surname"]."<img src='".$rep[$i]["url_photo"]."' alt='photo du pilote'></p></button>";
                $i++;
              }
              $imax+=$total/6;
              ?>
            </div>
          </div>
        </div>
        <div class="col-lg-2">
        <div class="dropdown">
            <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php
              $code1 = $rep[$i]["code"]; $code2 = $rep[$imax-1]["code"];
              echo $code1." - ".$code2;
              ?>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <?php 
              while($i<$imax){
                echo "<button class='dropdown-item'><p class='ligne-pilote' id='".$rep[$i]["driverId"]."'>".$rep[$i]["forename"]." ".$rep[$i]["surname"]."<img src='".$rep[$i]["url_photo"]."' alt='photo du pilote'></p></button>";
                $i++;
              }
              $imax+=$total/6;
              ?>
            </div>
          </div>
        </div>
        <div class="col-lg-2">
        <div class="dropdown">
            <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php
              $code1 = $rep[$i]["code"]; $code2 = $rep[$imax-1]["code"];
              echo $code1." - ".$code2;
              ?>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <?php 
              while($i<$imax){
                echo "<button class='dropdown-item'><p class='ligne-pilote' id='".$rep[$i]["driverId"]."'>".$rep[$i]["forename"]." ".$rep[$i]["surname"]."<img src='".$rep[$i]["url_photo"]."' alt='photo du pilote'></p></button>";
                $i++;
              }
              $imax+=$total/6;
              ?>
            </div>
          </div>
        </div>
        <div class="col-lg-2">
        <div class="dropdown">
            <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php
              $code1 = $rep[$i]["code"]; $code2 = $rep[$imax-1]["code"];
              echo $code1." - ".$code2;
              ?>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <?php 
              while($i<$imax){
                echo "<button class='dropdown-item'><p class='ligne-pilote' id='".$rep[$i]["driverId"]."'>".$rep[$i]["forename"]." ".$rep[$i]["surname"]."<img src='".$rep[$i]["url_photo"]."' alt='photo du pilote'></p></button>";
                $i++;
              }
              $imax+=$total/6;
              ?>
            </div>
          </div>
        </div>
        <div class="col-lg-2">
        <div class="dropdown">
            <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php
              $code1 = $rep[$i]["code"]; $code2 = $rep[$imax-1]["code"];
              echo $code1." - ".$code2;
              ?>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <?php 
              while($i<$imax){
                echo "<button class='dropdown-item'><p class='ligne-pilote' id='".$rep[$i]["driverId"]."'>".$rep[$i]["forename"]." ".$rep[$i]["surname"]."<img src='".$rep[$i]["url_photo"]."' alt='photo du pilote'></p></button>";
                $i++;
              }
              $imax+=$total/6;
              ?>
            </div>
          </div>
        </div>
        <div class="col-lg-2">
        <div class="dropdown">
            <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php
              $code1 = $rep[$i]["code"]; $code2 = $rep[$imax-1]["code"];
              echo $code1." - ".$code2;
              ?>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <?php 
              while($i<$imax){
                echo "<button class='dropdown-item'><p class='ligne-pilote' id='".$rep[$i]["driverId"]."'>".$rep[$i]["forename"]." ".$rep[$i]["surname"]."<img src='".$rep[$i]["url_photo"]."' alt='photo du pilote'></p></button>";
                $i++;
              }
              $imax+=$total/6;
              ?>
            </div>
          </div>
        </div>

      </div>
    </div>

         <div class="container">
                <center> <button class="btn btn-dark" id="comparaison"> Comparer </button> </center>
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <p id="p1"> Pilote 1 : </p>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <p id="p2"> Pilote 2 : </p>
                    </div>
                </div>
            </div>

    <div class="container">
      <div class="row">
        <div class="col-lg-6">
              <canvas id="radar1">
        </div>
        <div class="col-lg-6">
          <canvas id="radar2">
        </div>
          

      </div>
      <div id="db-graph">
        <canvas id="evo">
      </div>

    </div>


    <style>
   /*   #db-graph{
        background-color: white;
      }  */

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
        let vide = 1;
        let id1, id2 = 0;
        $(".ligne-pilote").click(function(){

          if(vide==1){
              $("#p1").html("Pilote 1 : "+this.innerHTML);
              id1 = $(this).attr("id");
              vide=2;
          }
          else{
              $("#p2").html("Pilote 2 : "+this.innerHTML);
              id2 = $(this).attr("id");
              vide=1;
          }
        });


        $("#p1").click(function(){
            $(this).html("Pilote 1 : ");
            vide=1;
        });

        $("#p2").click(function(){
            $(this).html("Pilote 2 : ");
            vide=2;
        });
        
let rad1 = null;
let rad2 = null;
let points = null;

        $("#comparaison").click(function(){
            let v1 = $("#p1").html(); console.log(v1); let v2 = $("#p2").html();
            if(v1.length > 12 && v2.length> 12 && id1!=0 && id2!=0){
                $.ajax({
                  url: "comparaison.php",
                  type: "POST",
                  dataType: "json",
                  data:{
                    id1: id1,
                    id2: id2,
                  },
                  success: function(response){
                    console.log(response.data.points);
                    radar1 = {
                      labels: response.data.radar.label1,
                      values: response.data.radar.data1,
                    }
                    creerChart(radar1, "radar", "#radar1", "rad1");
                    radar2 = {
                      labels: response.data.radar.label2,
                      values: response.data.radar.data2,
                    }
                    creerChart(radar2, "radar", "#radar2", "rad2");
                    datap = {
                      labels: response.data.points.labels,
                      data1: response.data.points.data1,
                      data2: response.data.points.data2,
                    }
                    noms = {
                      surname1: response.data.noms.pil1.surname,
                      forename1: response.data.noms.pil1.forename,
                      surname2: response.data.noms.pil2.surname,
                      forename2: response.data.noms.pil2.forename,
                    }
                    console.log(response.data.points);
                    pointsChart(datap.data1, datap.data2, datap.labels, "#evo", "points", noms)
                  },
                  error: function(xhr, status, error, data) {
            console.log(xhr.responseText);
            console.log(status);
            console.log(error);
            console.log("data "+data);
                   },
                });
            }
            else{
                alert("vide");
            }
        });



  function creerChart(data, type, lieu, nom){
    console.log(nom);
    let labels = data["labels"];
    let values = data["values"];
    const dataVic = {
        labels: labels,
        datasets: [{
            data: values,
    }],
        fill: false,
    };
    let canv = $(lieu);
    
    let scales = null;
    if(nom=="rad1"){
      if(rad1!=null){
      rad1.destroy();
      }
      rad1 = new Chart(canv, {
      type: "pie",
      data: dataVic,
      options: {  
          },
          options: {
            elements: {
              line: {
                borderWidth: 3,
              }
            },
            plugins: {
                      title: {
                          display: true,
                          text: 'Répartition des 6 états les plus fréquents en fin de course',
                      }
                  },
            scales: scales,
         }
    })
    }
    else if(nom=="rad2"){
      if(rad2!=null){
        rad2.destroy();
      }
      rad2 = new Chart(canv, {
      type: "pie",
      data: dataVic,
      options: {  
          },
          options: {
            elements: {
              line: {
                borderWidth: 3,
              }
            },
            plugins: {
                      title: {
                          display: true,
                          text: 'Répartition des 6 états les plus fréquents en fin de course',
                      }
                  },
            scales: scales,
         }
    })
    }
    
}

function pointsChart(data1, data2, labels, lieu, nom, names){
    console.log(nom);
    
    const dataVic = {
        labels: labels,
        datasets: [{
            data: data1,
            label: names.forename1+" "+names.surname1,
    },
          { data: data2,
            label: names.forename2+" "+names.surname2,

    },
  ],
        fill: false,
    };
    let canv = $(lieu);
    
    let scales = null;
      if(points!=null){
        points.destroy();
      }
      points = new Chart(canv, {
      type: "bar",
      data: dataVic,
      options: {  
          },
          options: {
            elements: {
              line: {
                borderWidth: 3,
              }
            },
            plugins: {
                      title: {
                          display: true,
                          text: 'Nombre de points gagnés par saison',
                      }
                  },
            scales: scales,
         }
    })
    }


                </script>