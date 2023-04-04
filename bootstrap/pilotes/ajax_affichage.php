<?php
ob_start();
require("../fonction.php");
ob_end_clean();


if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtoupper($_SERVER["HTTP_X_REQUESTED_WITH"])=="XMLHTTPREQUEST"){
    if(isset($_POST["year"]) && $_POST["year"]){
        $pilotes = requete($_POST["year"]);
        $txt = "<div class='row'>";
        for($i=0; $i<count($pilotes); $i++){
            $txt .= "<div class='col-lg-6 d-flex justify-content-center '><div class='row'>\n <div class='col-lg-4 d-flex justify-content-center'><a href='./pilote.php?id=".$pilotes[$i]["driverId"]."'>";
            $txt .="<img src='".$pilotes[$i]["url_photo"]."' alt='photo du pilote'>\n</a></div>  <div class='col-lg-8 d-flex justify-content-center'><a href='./pilote.php?id=".$pilotes[$i]["driverId"]."'><p class='paragraphe'>".$pilotes[$i]["forename"]." ".$pilotes[$i]["surname"]."</p></a> \n</div>";
            $txt .= "</div></div>";
            if($i%2==1 && $i!=count($pilotes)-1 && $i!=0){
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
    $q = "SELECT DISTINCT drivers.forename, drivers.surname, drivers.code, drivers.driverId, drivers.url_photo FROM races, results, drivers WHERE races.year=".$year." AND races.raceId=results.raceId AND results.driverId=drivers.driverId";
    $rep = $bdd -> query($q); $ans = $rep -> fetchAll();
    return $ans;
}
function reponse($code, $message, $data){
 //   header("Content-Type: application/json");
    http_response_code($code);
    echo $data;
}