<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">

    <title>Graphique</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">  
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

    <script src="./graphiques.js"></script>
    
</head>
<body>

<h1> Test Des Graphiques en PHP </h1>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



<?php
require("../fonction.php");
$bdd = getBD();

$q = "SELECT * FROM drivers WHERE drivers.driverId=1";
$rep = $bdd -> query($q); $pilote = $rep -> fetch();

$rep = $bdd -> query("SELECT COUNT(results.statusId) as nb, status.status FROM results, status WHERE results.driverId=".$pilote["driverId"]." AND status.statusId=results.statusId GROUP BY results.statusId");
$ans = $rep -> fetchAll();
/*$rep = $bdd -> query("SELECT COUNT(results.statusId) as nb, status.status FROM results, status WHERE results.driverId=".$pilote["driverId"]." AND status.statusId=results.statusId AND status.statusId!=1 GROUP BY results.statusId");
$ans = $rep -> fetchAll();  */


$dataset = array();
$labels = array();
for($i=0; $i<count($ans); $i++){
    array_push($dataset, $ans[$i]["nb"]);
    array_push($labels, $ans[$i]["status"]);
}


?>



<style> 
    .graph{ width: 400px; height: 400px; background-color: lightgrey;}
    body { background-color: black;}
</style>


<br> <br>
<h2> Graphique sélectionnables </h2>

<div class="container"> 
  <div class="row">
    <div class="col-lg-3 bd">
      <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span id="evo">Graphiques évolutifs</span> 
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <button class='dropdown-item' id="btn-vic"> Victoire par saison </button>
          <button class='dropdown-item' id='btn-pod'> Podium par saison </button>
        </div>
      </div>
    </div>
    <div class="col-lg-3 bd">
      <div class="row">
        <div class="col-lg-8" id="ponc">
          <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span id="ponct">Graphiques Ponctuels</span> 
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <button class='dropdown-item' id="status"> Status </button>
              <button class='dropdown-item' id="classement"> Classements </button>
            </div>
          </div>
        </div>
        <div class="col-lg-4" id="saison">
      <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span id="sais">Saison</span> 
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <?php 
            $q = "SELECT DISTINCT races.year FROM races, results, drivers WHERE races.raceId=results.raceId AND results.driverId=drivers.driverId AND drivers.driverId=".$pilote["driverId"]." ORDER BY races.year DESC";
            $rep = $bdd -> query($q); $year = $rep -> fetchAll();
            for($i=0; $i<count($year); $i++){
              echo "<button class='dropdown-item year'>".$year[$i][0]."</button>";
            }

          ?>
        </div>
      </div>
    </div>
</div>
</div>
    <div class="col-lg-3 bd">
      <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Graphiques 3ème type 
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <button class='dropdown-item'> Victoire par saison </button>
          <button class='dropdown-item'> Podium par saison </button>
        </div>
      </div>
    </div>
    <div class="col-lg-3 bd">
      <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Graphiques 4ème type 
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <button class='dropdown-item'> Victoire par saison </button>
          <button class='dropdown-item'> Podium par saison </button>
        </div>
      </div> 
</div>
</div>
</div>




<div class="graphique" id="graph1">
  <canvas id="chart"></canvas>
</div>




<style>
  .graphique{
    height: 300px;
    width: 60%;
    margin: 40px auto;
    background-color: lightgrey;
  }
  #chartV{
    background-color: lightblue;
  }
  #saison{
    display:none;
    padding-left:0;
    margin-left:0;
  }
  .bd {
    padding: 0 10px;
  }
  #ponc{
    margin-right:0;
    padding-right:0;
  }

</style>



<script>


//------------------------------



// ----------------------------------------


let id =<?php echo $pilote["driverId"]; ?>;

$("#btn-vic").click(function(){
  nbVicParSaison(id);
  $("#saison").css("display", "none");
  $("#evo").html("Evolution des victoires");
  $("#ponct").html("Graphiques ponctuels");

 // $("#graph1").css("display", "block");
});
$("#btn-pod").click(function(){
  nbPodParSaison(id);
  $("#saison").css("display", "none");
  $("#evo").html("Evolution des Podiums");
  $("#ponct").html("Graphiques ponctuels");
//   $("#graph2").css("display", "block");
});

$("#status").click(function(){
  status(2022);
  $("#saison").css("display", "block");
  $("#ponct").html("Status de la saison : ");
});
$(".year").click(function(){
  $("#sais").html($(this).html());
  $("#evo").html("Graphiques évolutifs");
  
  let type = $("#ponct").text();
  if(type=="Status de la saison : "){
     status($(this).html());
  }
  else if(type=="Classements de la saison : "){
    classement($(this).html()); 
  }
})
$("#classement").click(function(){
  classement(2022);
  $("#saison").css("display", "block");
  $("#evo").html("Graphiques évolutifs");
  $("#ponct").html("Classements de la saison : ");
})

















</script>


    
</body>
</html>