<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résultats de la recherche </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">  
        <link rel="stylesheet" href="./style_in.css" type="text/css">
    <link rel="icon" href="./images/icon.jpg">
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
        <style> 
    img{ height:70px; border-radius: 100px;}
    a{text-decoration:none; color:black; text-align:center;}
    h2{ background-color:black; color:white; border:3px solid black; padding: 40px; margin-bottom:20px;}
</style>
</head>
<body>
    <?php 
    require("./fonction.php");
    session_start();
    
    $search_query = preg_replace('/\s+/', ' ', $_GET['search']);
    $search_query = supprimerCharSpec($search_query);
    $mots = explode(' ', trim($search_query));

    function requeter($var){
        if(!isset($bdd)){
            $bdd = getBD();
        }
        $mots = explode(" ", trim($var));
        $req_pilotes = "";
        $req_courses = "";
        $req_constructeurs = "";
        $req_circuits = "";
        foreach ($mots as $mot) {
            if (!empty($mot)) {
                $mot = supprimerCharSpec($mot);
                $req_pilotes .= "AND (drivers.forename LIKE '%".$mot."%' OR drivers.surname LIKE '%".$mot."%') ";
                $req_courses .= "AND races.name LIKE '%".$mot."%' ";
                $req_constructeurs .= "AND constructors.name LIKE '%".$mot."%' ";
                $req_circuits .= "AND circuits.name LIKE '%".$mot."%' ";
            }
        }
        $qp = "SELECT * FROM drivers WHERE 1 ".$req_pilotes;
        $qr = "SELECT * FROM races WHERE 1 ".$req_courses;
        $qf = "SELECT * FROM constructors WHERE 1 ".$req_constructeurs;
        $qc = "SELECT * FROM circuits WHERE 1 ".$req_circuits;
        $rep1 = $bdd -> query($qp); $rep2 = $bdd -> query($qr); $rep3 = $bdd -> query($qf); $rep4 = $bdd -> query($qc);
        $pilotes = $rep1 -> fetchAll(); $courses = $rep2 -> fetchAll(); $constructeurs = $rep3 -> fetchAll(); $circuits = $rep4 -> fetchAll();
        return array("pilotes" => $pilotes, "constructeurs" => $constructeurs, "courses" => $courses, "circuits" => $circuits);
    }  

    function transformer_url($url){
        $url = substr($url, 1, strlen($url)-1);
        return $url;
    }
    
    
        function afficher($liste){
            if(count($liste["pilotes"])>0){
                for($i=0; $i<count($liste["pilotes"]); $i++){
                    echo "Pilote : ".$liste["pilotes"][$i]["forename"]."<br>";
                }    
            }
            if(count($liste["constructeurs"])>0){
                for($i=0; $i<count($liste["constructeurs"]); $i++){
                    echo "Constructeur : ".$liste["constructeurs"][$i]["name"]."<br>";
                }    
            }
            if(count($liste["courses"])>0){
                for($i=0; $i<count($liste["courses"]); $i++){
                    echo "Course : ".$liste["courses"][$i]["name"]."<br>";
                }    
            }
            if(count($liste["circuits"])>0){
                for($i=0; $i<count($liste["circuits"]); $i++){
                    echo "Circuit : ".$liste["circuits"][$i]["name"]."<br>";
                }    
            }
            
        }
        
        function separerMots($var){
            $debut=0; $fin=0; $mots = array();
            while($fin<strlen($var)){
                echo "tour ".$fin." : debut -> ".$debut." fin -> ".$fin."<br>";
                if($var[$fin]==" " && $fin==$debut){
                    echo "Les conditions sont valides ici ";
                    array_push($mots, substr($var, $debut, $fin));
                //    $var = substr($var, $fin);
                    $debut=$fin;
                }
                else if($var[$fin]==" " && $fin!=$debut){
                    echo "Suppression d'un espace ";
                    $debut++;
                }
                else{
                    echo $var[$fin];
                }
                $fin++;
            }
            if($fin==strlen($var) && $fin!=0){
                array_push($mots, $var);
            }
            return $mots;
        }
        // On obtient des mots 'clean' qu'on va pouvoir chercher dans la base de donnée
        function supprimerCharSpec($var){
            $charsSpec = array("?", "!", "$", "%", "*", "~", "#", "[", ']', "{", '}', "\ ", "|", "§", "<", ">" );           
            $var = str_replace($charsSpec, " ", $var);
            return $var;
        }
   
    
    $pilotes = array(); $circuits = array(); $grandp = array(); $constructeurs = array();
    for($i=0; $i<count($mots); $i++){
      //  echo supprimerCharSpec($mots[$i])." <br>";
    //    echo "Requetage sur ... ".$mots[$i]; print_r(requeter(supprimerCharSpec($mots[$i])));
        $pilres = requeter($mots[$i])["pilotes"];
        for($j=0; $j<count($pilres); $j++){
            array_push($pilotes, $pilres[$j]);
        }
        $cirres = requeter($mots[$i])["circuits"];
        for($j=0; $j<count($cirres); $j++){
            array_push($circuits, $cirres[$j]);
        }
        $conres = requeter($mots[$i])["constructeurs"];
        for($j=0; $j<count($conres); $j++){
            array_push($constructeurs, $conres[$j]);
        }
        $gpsres = requeter($mots[$i])["courses"];
        for($j=0; $j<count($gpsres); $j++){
            array_push($grandp, $gpsres[$j]);
        }
       
    }

    
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
		  <a href="./utilisateur/favoris.php">Mes Favoris</a>
		  <a href="./utilisateur/abonnement.php">Mes Abonnements</a>
		  <a href="./utilisateur/parier.php">Parier</a>
		  <a href="./bd.php">Base de Données</a>

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
		  
		  <form class="d-flex" action="recherche.php" method="get">
			<input class="form-control me-2" type="text" name="search" placeholder="Search">
			<button class="btn btn-danger" type="submit">Search</button> 
		  </form>
		  
		</div>
	  </div>
	</nav>

        <?php

            if(!isset($pilotes) && !isset($circuits) && !isset($grandp) && !isset($constructeurs)){
                die(); 
            }
            if(isset($pilotes) && count($pilotes)>0){
                echo "<h2> Pilotes associés à votre recherche : </h2>";
                $i=0;
                echo "<div class='container-fluid'><div class='row'>";
                while($i<count($pilotes)){
                    echo "     <div class='col-lg-1 col-sm-2'><a href='./pilotes/pilote.php?id=".$pilotes[$i]["driverId"]."'><div class='container'><div class='row'><img src='".transformer_url($pilotes[$i]["url_photo"])."' alt='photo pilote'></div><div class='row'><p>".$pilotes[$i]["forename"]." ".$pilotes[$i]["surname"]."</p></div>";
                    echo "</div></a></div> ";
                    $i++;
                    if($i%12==0){
                        echo "</div><div class='row'>";
                    }
                }
                echo "</div></div>";
            }
            if(isset($constructeurs) && count($constructeurs)>0){
                echo "<h2> Constructeurs associés à votre recherche : </h2>"; 
                $i=0;
                echo "<div class='container-fluid'><div class='row'>";
                while($i<count($constructeurs)){
                    echo "     <div class='col-lg-1 col-sm-3'><a href='./constructeurs/constructeur.php?id=".$constructeurs[$i]["constructorId"]."'><div class='container'><div class='row'><img src='".transformer_url($constructeurs[$i]["url_photo"])."' alt='photo constructeur'></div><div class='row'><p>".$constructeurs[$i]["name"]."</p></div>";
                    echo "</div></a></div> ";
                    $i++;
                    if($i%12==0){
                        echo "</div><div class='row'>";
                    }
                }
                echo "</div></div>";
            }
            if(isset($grandp) && count($grandp)>0){
                echo "<h2> Grands Prix associés à votre recherche : </h2>"; 
                $i=0;
                echo "<div class='container-fluid'><div class='row'>";
                while($i<count($grandp)){
                    echo "     <div class='col-lg-1 col-md-2 col-sm-3 col-4'><a href='./gps/gp.php?id=".$grandp[$i]["raceId"]."'><div class='container'><div class='row'><img src='".transformer_url($grandp[$i]["url_photo"])."' alt='photo gp'></div><div class='row'><p>".$grandp[$i]["name"].", ".$grandp[$i]["year"]."</p></div>";
                    echo "</div></a></div> ";
                    $i++;
                    if($i%12==0){
                        echo "</div><div class='row'>";
                    }
                }
                echo "</div></div>";
                
            }
            if(isset($circuits) && count($circuits)>0){
                echo "<h2> Circuits associés à votre recherche : </h2>"; 
                $i=0;
                echo "<div class='container-fluid'><div class='row'>";
                while($i<count($circuits)){
                    echo "     <div class='col-lg-1 col-sm-3'><a href='./circuits/circuit.php?id=".$circuits[$i]["circuitId"]."'><div class='container'><div class='row'><img src='".transformer_url($circuits[$i]["url_photo"])."' alt='photo circuit'></div><div class='row'><p>".$circuits[$i]["name"]."</p></div>";
                    echo "</div></a></div> ";
                    $i++;
                    if($i%12==0){
                        echo "</div><div class='row'>";
                    }
                }
                echo "</div></div>";
            }







    ?>


    
</body>
</html>