<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Récup wiki id=1</title>
    
</head>
<body>

<!-- 

ALTER TABLE drivers ADD COLUMN description TEXT    => Idem pour circuits, constructors, races (là ou crawler)


-->


<?php
require("../fonction.php");
$bdd = getBD();

$q = "SELECT * FROM drivers WHERE drivers.driverId=1"; $rep = $bdd -> query($q); $ans = $rep -> fetch();


if(isset($ans["description"]) && $ans["description"]!=NULL && $ans["description"]!=""){
  echo $ans["description"];
}
else{



$url = $ans["url"];
require_once('simple_html_dom.php');

// Récupérer le contenu de la page Web
$html = file_get_html($url);

// Trouver tous les éléments HTML avec la classe "content"
$elements = $html->find('p');


$i=0;
$txt = "";
while($i<3){
  $txt .= $elements[$i]->plaintext;
  $i++;
}
//echo $txt;

$q = 'UPDATE drivers SET drivers.description="'.$txt.'" WHERE drivers.driverId = '.$ans["driverId"];
echo $q;
$rep = $bdd -> query($q);

}


/*
// Parcourir les éléments et extraire leur texte brut
foreach ($elements as $element) {
    echo $element->plaintext;
}
 */
?>
    
</body>
</html>