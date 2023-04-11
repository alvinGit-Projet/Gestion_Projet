<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Outil de comparaison</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
		<link rel="stylesheet" href="pilote.css" type="text/css">
        <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>

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
			  <a class="nav-link" href="#">Pilotes</a>
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
		  
		  <form class="d-flex">
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
        background-color:lightgrey;
        border:1px solid black;
        margin: 0;
    }
    .ligne-pilote:hover{
        border: 2px solid black;
        background-color: white;
    }
    .ligne-pilote img{
        width:50px; height:50px; 
        border-radius:30px;
        margin: -30px auto auto 75%; */
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


    </style>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2">
                <!-- Choix des pilotes -->
                <?php
                $q = "SELECT drivers.forename, drivers.surname, drivers.url_photo FROM drivers"; $ans = $bdd -> query($q); $rep = $ans -> fetchAll();
                $i=0;
                while($i<count($rep)/2){
                    if($rep[$i]["url_photo"]==NULL || $rep[$i]["url_photo"]==""){
                        echo "<p class='ligne-pilote'>".$rep[$i]["forename"]." ".$rep[$i]["surname"]."<img src='../images/photo.jpg' alt='photo du pilote'></p>";
                    }
                    else{
                        echo "<p class='ligne-pilote'>".$rep[$i]["forename"]." ".$rep[$i]["surname"]." <img src='".$rep[$i]["url_photo"]."' alt='photo du pilote'> </p>";
                    }
                    $i++;
                }
                
                ?>
            </div>
            <div class="col-lg-8">
                <!-- Zone des graphiques --->
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
            <div class="col-lg-2">
                <!-- Choix des pilotes -->
                <?php
               
                while($i<count($rep)){
                    if($rep[$i]["url_photo"]==NULL || $rep[$i]["url_photo"]==""){
                        echo "<p class='ligne-pilote'>".$rep[$i]["forename"]." ".$rep[$i]["surname"]." <img src='../images/photo.jpg' alt='photo du pilote'> </p>";
                    }
                    else{
                        echo "<p class='ligne-pilote'>".$rep[$i]["forename"]." ".$rep[$i]["surname"]." <img src='".$rep[$i]["url_photo"]."' alt='photo du pilote'> </p>";
                    }
                    $i++;
                }
                
                ?>
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
        $(".ligne-pilote").click(function(){

        if(vide==1){
            $("#p1").html("Pilote 1 : "+this.innerHTML);
            vide=2;
        }
        else{
            $("#p2").html("Pilote 2 : "+this.innerHTML);
            vide=1;
        }
        });

        function vider(element){
            var txt = $(element).html();
            if(txt[7]=="1"){
                $(element).html("Pilote 1 : ");
            }
            else{
                $(element).html("Pilote 2 : ");
            }
        }

        $("#p1").click(function(){
            $(this).html("Pilote 1 : ");
            vide=1;
        });

        $("#p2").click(function(){
            $(this).html("Pilote 2 : ");
            vide=2;
        });

        $("#comparaison").click(function(){
            alert("fonction appelée");
            let v1 = $("#p1").html(); console.log(v1); let v2 = $("#p2").html();
            if(v1.length > 12 && v2.length> 12){
                alert("2 pilotes sélectionnés");
                <?php $q="SELECT * FROM drivers WHERE drivers.driverId=1"; $rep = $bdd -> query($q); $ans = $rep -> fetch(); //echo $ans; ?>
                var infos = 1 ;
                alert(infos);
            }
            else{
                alert("vide");
            }
        })



                </script>