<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">

    <title>Graphique</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">  
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  
    
</head>
<body>

<h1> Test Des Graphiques en PHP </h1>

<div class="container">
    <div class="row">
        <div class="col-lg-6"> 
<div class="graph">
  <canvas id="bar" height="100px" width="200px"></canvas>
</div>
</div>
<div class="col-lg-6">
<div class="graph">
  <canvas id="radar" height="100px" width="200px"></canvas>
</div>
</div>
</div>
</div> 

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
        label: "Nombre",
        data: [<?php for($i=0; $i<count($dataset); $i++){
   if($i+1<count($dataset)){
     echo '"'.$dataset[$i].'", ';
    }
    else{ 
        echo '"'.$dataset[$i].'"'; 
    }
    } ?>], 
    fill: true,
    backgroundColor: "lightred",
    }]
  };
  
  

let graph1 = document.getElementById("bar");
let graph2 = document.getElementById("radar");

new Chart(graph1,  {
  type: 'bar',
  data: data,
  options: {
    elements: {
      line: {
        borderWidth: 3
      }
    }
  },
});
new Chart(graph2,  {
  type: 'radar',
  data: data,
  options: {
    elements: {
      line: {
        borderWidth: 3
      }
    }
  },
});



</script>


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
              <button class='dropdown-item'> Classements </button>
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
              echo "<button class='dropdown-item'>".$year[$i][0]."</button>";
            }

          ?>


       <!--   <button class='dropdown-item'> 2022 </button>
          <button class='dropdown-item'> 2021 </button> -->
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
  <canvas id="chartV"></canvas>
</div>
<div class="graphique" id="graph2">
  <canvas id="chartP"></canvas>
</div>



<style>
  .graphique{
    width: 60%;
    margin: 40px auto;
    background-color: lightgrey;
    display: none;
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
<?php
// Evolution des victoires : 
$q = "SELECT COUNT(results.resultId) AS nb, races.year FROM results, drivers, races WHERE results.driverId=drivers.driverId AND drivers.driverId=1 AND results.raceId=races.raceId AND results.position=1 GROUP BY races.year ORDER BY races.year ASC";
$rep = $bdd -> query($q); $ans = $rep -> fetchAll();

$dataVic = array(); 
$labelsVic = array();

for($i=0; $i<count($ans); $i++){
  array_push($dataVic, $ans[$i]["nb"]);
  array_push($labelsVic, $ans[$i]["year"]);
}

$q = "SELECT COUNT(results.resultId) AS nb, races.year FROM results, drivers, races WHERE results.driverId=drivers.driverId AND drivers.driverId=1 AND results.raceId=races.raceId AND (results.position=1 OR results.position=2 OR results.position=3) GROUP BY races.year ORDER BY races.year ASC";
$rep = $bdd -> query($q); $ans = $rep -> fetchAll();

$dataPod = array(); 
$labelsPod = array();

for($i=0; $i<count($ans); $i++){
  array_push($dataPod, $ans[$i]["nb"]);
  array_push($labelsPod, $ans[$i]["year"]);
}


?>

//------------------------------

let labelsVic = [<?php for($i=0; $i<count($labelsVic); $i++){
      if($i+1<count($labelsVic)){
        echo '"'.$labelsVic[$i].'", ';
       }
       else{ 
           echo '"'.$labelsVic[$i].'"'; 
       }
    }   ?>];

const dataVic = {
  labels: labelsVic,
  datasets: [{
    label: 'Evolution du nombre de victoire',
    data: [<?php for($i=0; $i<count($dataVic); $i++){
      if($i+1<count($dataVic)){
        echo $dataVic[$i].', ';
       }
       else{ 
           echo $dataVic[$i]; 
       }
    }   ?>],
    fill: false,
    borderColor: 'rgb(75, 192, 192)',
    tension: 0.1
  }]
};

let graphiqueV = document.getElementById("chartV").getContext("2d");
new Chart(graphiqueV,  {
  type: 'line',
  data: dataVic,
  options: {
    elements: {
      line: {
        borderWidth: 3
      }
    }
  },
});

// ----------------------------------------

let labelsPod = [<?php for($i=0; $i<count($labelsPod); $i++){
      if($i+1<count($labelsPod)){
        echo '"'.$labelsPod[$i].'", ';
       }
       else{ 
           echo '"'.$labelsPod[$i].'"'; 
       }
    }   ?>];
const dataPod = {
  labels: labelsPod,
  datasets: [{
    label: 'Evolution du nombre de podiums',
    data: [<?php  for($i=0; $i<count($dataPod); $i++){
      if($i+1<count($dataPod)){
        echo $dataPod[$i].', ';
       }
       else{ 
           echo $dataPod[$i]; 
       }
    }   ?>],
    fill: false,
    borderColor: 'rgb(75, 192, 192)',
    tension: 0.1
  }]
}; 

let graphiqueP = document.getElementById("chartP").getContext("2d");
new Chart(graphiqueP,  {
  type: 'line',
  data: dataPod,
  options: {
    elements: {
      line: {
        borderWidth: 3
      }
    }
  },
});

function reinitialiser(){
  $("#evo").html("Graphiques évolutifs");
  $("#saison").css("display", "none");
  $("#ponct").html("Graphiques ponctuels");
  $(".graphique").css("display", "none");
}



$("#btn-vic").click(function(){
  reinitialiser();
  $("#evo").html("Evolution des victoires");
  $("#graph1").css("display", "block");
});
$("#btn-pod").click(function(){
  reinitialiser();
  $("#evo").html("Evolution des Podiums");
  $("#graph2").css("display", "block");
});
$("#status").click(function(){
  reinitialiser();
  $("#saison").css("display", "block");
  $("#ponct").html("Status de la saison : ");
});













</script>


    
</body>
</html>