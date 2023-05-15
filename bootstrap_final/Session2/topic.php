<!DOCTYPE html>
<html lang="fr">
<head>

<?php
require("../fonction.php");
$bdd = getBD();

$q = "SELECT * FROM topic WHERE topic.topic_id=".$_GET["id"];
$rep = $bdd -> query($q); $topic = $rep-> fetch();
$contenu = "SELECT * FROM message, utilisateur WHERE message.email_adress=utilisateur.email_adress AND message.message_prec_id=-1 AND message.topic_id=".$topic["topic_id"];
$rep = $bdd -> query($contenu); $principal = $rep -> fetch();
$reponses = "SELECT * FROM message, utilisateur WHERE message.email_adress=utilisateur.email_adress AND message.message_prec_id=".$principal["message_id"];
$rep = $bdd -> query($reponses); $reponse = $rep -> fetchAll();  
?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $topic["titre"]; ?></title>

    <link rel="stylesheet" href="../style_in.css" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">  
    <link rel="stylesheet" href="./forum.css" type="text/css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    
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
        let loged = <?php if(isset($_SESSION['utilisateur'])){ echo "true"; }else{ echo "false";}?>;
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

    <div class="container">
        <div class="row topic">
            <div class="col-lg-3">
                <button> Accueil Forum </button>
            </div>
            <div class="col-lg-3">
                <button> Topics similaire </button>
            </div>
            <div class="col-lg-3">
                <button> Tri par date </button>
            </div>
            <div class="col-lg-3">
                <button> Tri par pertinence/réactions </button>
            </div>
        </div>
    </div>

    <h1> <?php echo $topic["titre"]; ?> </h1>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2">
            </div>
            <div class="col-lg-8">
               <div class="row message">
                    <div class="col-lg-3">
                        <p> <?php echo $principal["prenom"]; ?> </p>
                        <img src="" alt="photo correspondate au rang">
                    </div>
                    <div class="col-lg-9">
                        <p> <?php echo $principal["contenu"]; ?> </p>
                    </div>
                </div>
                <div class="container"> <!-- Bloc pour les reponses --> 
                    <div class="col-lg-2"> <!-- Ecart pour distinguer réponses -->
                    </div>
                    <div class="col-lg-10">
                        <?php
                        for($i=0; $i<count($reponse); $i++){
                            echo "<div class='row message'><div class='col-lg-3'><p>".$reponse[$i]["prenom"]."</p><img src='' alt='photo correspondate au rang'>
                            </div><div class='col-lg-9'><p>".$reponse[$i]["contenu"]." </p></div></div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
            </div>




    
</body>
</html>