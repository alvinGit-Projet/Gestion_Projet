<?php
ob_start();
require("../fonction.php");
ob_end_clean();


if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtoupper($_SERVER["HTTP_X_REQUESTED_WITH"])=="XMLHTTPREQUEST"){
    if(isset($_POST["year"]) && $_POST["year"]){
        $constructeur = requete($_POST["year"]);
        $txt = "<div class='row'>";
        for($i=0; $i<count($constructeur); $i++){
            $txt .= "<div class='col-lg-6 col-sm-6'><div class='row'>\n <div class='col-lg-4'><a href='./constructeur.php?id=".$constructeur[$i]["constructorId"]."'>";
            $txt .="<img id='constr' src='".$constructeur[$i]["url_photo"]."' alt='photo du constructeur'>\n</a></div>  <div class='col-lg-8 d-flex justify-content-center'><a href='./constructeur.php?id=".$constructeur[$i]["constructorId"]."'><p class='paragraphe'>".$constructeur[$i]["name"]." </p></a>\n</div>";
            $txt .= "</div></div>";
            if($i%2==1 && $i!=count($constructeur)-1 && $i!=0){
                $txt .= "</div> <div class='row'>";
            }
        }
        $txt .= "</div>";
        $message = "Recup succesful";
        reponse(200, $message, $txt);
    }
}
else{

}



function requete($year){
    if(!isset($bdd)){
        $bdd = getBD();
    }
    $q = "SELECT DISTINCT constructors.constructorId, constructors.name, constructors.nationality, constructors.url_photo FROM constructors, seasons, races, results WHERE races.year=".$year." AND races.raceId=results.raceId AND results.constructorId=constructors.constructorId";
    $rep = $bdd -> query($q); $ans = $rep -> fetchAll();
    return $ans;
}
function reponse($code, $message, $data){
 //   header("Content-Type: application/json");
    http_response_code($code);
    echo $data;
}