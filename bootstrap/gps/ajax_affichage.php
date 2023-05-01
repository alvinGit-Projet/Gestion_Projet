<?php
ob_start();
require("../fonction.php");
ob_end_clean();


if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtoupper($_SERVER["HTTP_X_REQUESTED_WITH"])=="XMLHTTPREQUEST"){
    if(isset($_POST["year"]) && $_POST["year"]){
        $gps = requete($_POST["year"]);
        $txt = "<div class='row'>";
        for($i=0; $i<count($gps); $i++){
            $txt .= "<div class='col-lg-6 d-flex justify-content-center '><div class='row'>\n <div class='col-lg-4 d-flex justify-content-center'><a href='./gp.php?id=".$gps[$i]["raceId"]."'>";
            $txt .="<img id='races' src='".$gps[$i]["url_photo"]."' alt='photo du gp'>\n</a></div>  <div class='col-lg-8 d-flex justify-content-center'><a href='./gp.php?id=".$gps[$i]["raceId"]."'><p class='paragraphe'>".$gps[$i]["name"].", ".$gps[$i]["location"]." (".$gps[$i]["year"].")</p></a>\n</div>";
            $txt .= "</div></div>";
            if($i%2==1 && $i!=count($gps)-1 && $i!=0){
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
    $q = "SELECT DISTINCT races.raceId, races.name, circuits.location, races.url_photo, races.year FROM circuits, seasons, races WHERE races.year=".$year." AND races.circuitId=circuits.circuitId ORDER BY races.date DESC";
    $rep = $bdd -> query($q); $ans = $rep -> fetchAll();
    return $ans;
}
function reponse($code, $message, $data){
 //   header("Content-Type: application/json");
    http_response_code($code);
    echo $data;
}