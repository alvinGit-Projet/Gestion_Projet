<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./onglets.css" type="text/css">
  <title>Pilotes</title>
</head>
<body>
<nav class="navbar navbar-expand-sm bg-black">
            <div class="collapse navbar-collapse">

                <div class="nav-item" id="deroulant">
                    <div class="dropdown dropdown-toggle">
                        <a class="nav-link" href="#" role="button" id="deroulanta" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Filtre</a>
                        <div class="dropdown-menu" aria-labelledby="deroulanta" id="sous">
                            <a class="dropdown-item" href="#"> Trier par popularité </a>  <!-- Pas de a mais des boutons pour effet javascript -->
                            <a class="dropdown-item" href="#"> Trier par ordre alphabétique</a>
                            <a class="dropdown-item" href="#"> Trier par récence </a>   <!-- Insérer php pour récup id de connexion: si non connecté pop up connection sinon génération php de favoris à partir de id-->
                        </div>
                    </div>
                </div>

                 <div class="input-group nav-item">
                    <input type="search" class="form-control" placeholder="Rechercher par Nom">
                    <div class="input-group-append">
                        <button id="bouton_loupe"><img id="loupe" src="./images/loupe.webp" alt="loupe" height="60px"></button>
                    </div>
                </div>
                
                <a href="#" class="nav-item"> <img id="logo" src="./images/logo.jpg" alt="logo"> </a>
            </div>
        </nav>


</body>
</html>