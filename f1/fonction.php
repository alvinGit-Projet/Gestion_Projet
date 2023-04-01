<html>
<head>
</head>
<body>
     
<?php
function getBD(){
     $bdd = new PDO("mysql:host=localhost;dbname=formula1;charset=utf8", "root", "");
     return $bdd;
}

function afficherTemps($millis){
     $sec = $millis/1000;
     $minutes = 0; $heures=0;
     while($sec>60){
          $minutes++;
          if($minutes==60){
               $heures++;
               $minutes=0;
          }
          $sec-=60;
     }
     if($heures>0){
          $time = $heures.":".$minutes.":".$sec;
     }
     else{
          $time=$minutes.":".$sec;
     }
     return $time;
}

function traduireNationalite($nationality){
     if($nationality=="British"){
          return "Anglais";
     }
     elseif($nationality=="German"){ return "Allemand";}
     elseif($nationality=="French"){ return "Français";}
     elseif($nationality=="Finnish"){ return "Finlandais";}
     elseif($nationality=="American"){ return "Américain";}
     elseif($nationality=="Japanese"){ return "Japonais";}

     else{
          return $nationality;
     }
}



?>

</body>
</html>