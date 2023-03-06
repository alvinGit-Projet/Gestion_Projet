<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes abonnements</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">  
    <link rel="stylesheet" href="../styles/style.css" type="text/css">
    <link rel="icon" href="./images/icon.jpg">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <style> html{background-color:cadetblue;}</style>
    <?php 
        session_start();
        require("../fonction.php");
        $bdd = getBD();
        // On va générer les abonnements du client connecté = récupération de l'id Session
        if(!isset($_SESSION['client']['id'])){ 
        //   echo "<meta http-equiv='refresh'  content='0; URL=../accueil.php'>";
         //   die("Vous n'êtes pas censé arriver ici, retour page d'accueil");
            echo "autorisation exceptionnelle"; 
        } 
        else{
            $id=$_SESSION['client']['id'];  // ou email_adress et il ne reste plus qu'à utiliser $id dans les requêtes ci-dessous
        }
    ?>
</head>
<body>
    <header id="bandeau">
        <a href="../accueil.php"> <button class="btn btn-dark" id="retour"> Retour </button> </a>
        <h1 id="abo-titre"> Mes abonnements </h1>
    </header>

    <?php 
        if(isset($_POST["nw"])){
            $rep = $bdd -> query("SELECT utilisateur.news_letter FROM utilisateur WHERE utilisateur.email_adress=1"); $ans = $rep-> fetch(); $bool = $ans[0];
            if($bool){
                $query = "UPDATE utilisateur SET utilisateur.news_letter=0 WHERE utilisateur.email_adress=1";
                $statement = $bdd -> prepare($query);
                $statement -> execute();
            }
            else{
                $query = "UPDATE utilisateur SET utilisateur.news_letter=1 WHERE utilisateur.email_adress=1";
                $statement = $bdd -> prepare($query);
                $statement -> execute();
            }
        }
        if(isset($_POST["actu"])){
            $rep=$bdd->query("SELECT abonnement.year FROM abonnement WHERE abonnement.email_adress=2 AND abonnement.year=(SELECT seasons.year FROM seasons ORDER BY seasons.year DESC LIMIT 1)"); $ans = $rep-> fetch();
            if($ans==""){
                $query="INSERT INTO abonnement (year, email_adress, date, notification_active) VALUES (2022, 2, '2023-02-28', 1)";
                $statement = $bdd -> prepare($query);
                $statement -> execute();
            }
            else{
                $query="DELETE FROM abonnement WHERE abonnement.year=(SELECT seasons.year FROM seasons ORDER BY seasons.year DESC LIMIT 1) AND abonnement.email_adress=2";
                $statement = $bdd -> prepare($query);
                $statement -> execute();
            }
        }
    ?>



    
    <div class="container">
        <div class="row">
            <div class="col-lg-6 abonnement">
                <h2> News Letter </h2>
                <form method="post">
                    <input type="submit" id="nw" name="nw" value="Statut :<?php $rep = $bdd -> query("SELECT utilisateur.news_letter FROM utilisateur WHERE utilisateur.email_adress=1");   $ans = $rep-> fetch(); $bool = $ans[0];
                            if(!$bool){echo "\nNon abonné";}else{echo "\nabonné";}// pareil pour email adress on remplace par $_SESSION....    ?>">
                      <?php      if($bool){ echo "<style> #nw{background-color:lightgreen;} </style>";} else{ echo "<style> #nw{background-color:red;} </style>"; }   ?>  
                   
                </form>
                <h3> Description : </h3>
                <p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Totam cum nesciunt eos nam tempora, possimus ipsum deleniti explicabo inventore
                     id reprehenderit optio perspiciatis dolorem aspernatur tenetur facere debitis! Nihil, necessitatibus.
                </p>
            </div>
            <div class="col-lg-6 abonnement">
                <h2> Actualités saison en cours (<?php $rep = $bdd -> query("SELECT seasons.year FROM seasons ORDER BY seasons.year DESC LIMIT 1"); $ans = $rep->fetch(); echo $ans[0];?>)</h2>
                <form method="post">
                    <input type="submit" id="actu-saison" name="actu" value="Statut :<?php $rep = $bdd -> query("SELECT abonnement.year FROM abonnement WHERE abonnement.email_adress=2 AND abonnement.year=(SELECT seasons.year FROM seasons ORDER BY seasons.year DESC LIMIT 1)"); $ans = $rep-> fetch();
                        if($ans==""){echo "\nNon abonné"; $bool=FALSE;}else{$bool=TRUE; echo "\nabonné";} // pour email_adresse on remplace par $_SESSION['client']['email_adress'] récupéré au moment de la connection  ?> ">  
               <?php         if($bool){ echo "<style> #actu-saison{background-color:lightgreen;} </style>";} else{ echo "<style> #actu-saison{background-color:red;} </style>"; }   ?> 
                    
                    <h3> Description : </h3>
                    <p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Totam cum nesciunt eos nam tempora, possimus ipsum deleniti explicabo inventore
                        id reprehenderit optio perspiciatis dolorem aspernatur tenetur facere debitis! Nihil, necessitatibus.
                    </p>
            </div>
        </div>
    </div>

<footer id="abo-footer">
        <p id="mentions"> Le site l'écurie des statistiques n'est pas la propriété exclusive de ses créateurs, Aucun droit réservé © </p
</footer>
    
</body>
</html>