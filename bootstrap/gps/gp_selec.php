<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">  
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  
<style> 
img{
    width: 100px; height: 100px;   
}    
.bigrow{
    margin-bottom: 30px;
    border : 1px solid black;
}

</style>

<?php

require("../fonction.php");
$bdd = getBD();

?>


</head>
<body>

<h1> Test GP </h1>

<div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Dropdown button
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <?php 
    $q = "SELECT DISTINCT races.year FROM races ORDER BY races.year DESC"; $rep = $bdd -> query($q); $ans = $rep -> fetchAll();
    $i=0;
    while($i < count($ans)){
        echo "<button class='dropdown-item selec' id='".$ans[$i]["year"]."'>".$ans[$i]["year"]."</button>";
        $i++;
    }
    ?>


<!--    <button class="dropdown-item" href="#">2022</button>  -->

  </div>
</div>

<?php
   

    $q = "SELECT * FROM races WHERE races.year=(SELECT races.year FROM races ORDER BY races.year DESC LIMIT 1)";
    $rep = $bdd -> query($q); $ans = $rep -> fetchAll();
    echo "<div class='container' id='year'> <div class='row'>";
    for($i=0; $i<count($ans); $i++){
        echo "<div class='col-lg-6'> <div class='container'> <div class='row bigrow'> <div class='col-lg-4'> <img src='".$ans[$i]["url_photo"]."' alt='photo gp'> </div> <div class='col-lg-8'> <p>".$ans[$i]["name"]."</p></div> </div></div></div>";
        if($i%2!=0){
            echo "</div> <div class='row'>";
        }
    }
    echo "</div> </div>";

?>


<script> 
    $(".selec").click(function(){
        let el = $(this);
        refresh(el.html());
    })

    function refresh(year){
        alert(year);
        // AJAX pour transformer variable script en php 

        // Je refresh la div id = year en query sur la year en question puis je modifie le html


    }



</script>

    
</body>
</html>