
<?php
ob_start();
require("../fonction.php");
ob_end_clean();

if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtoupper($_SERVER["HTTP_X_REQUESTED_WITH"])=="XMLHTTPREQUEST"){

    if(isset($_POST["graphe"])){
        $graphe = $_POST["graphe"];
        if($graphe=="nbVic"){
            $data = requeteVic(htmlspecialchars($_POST["id"]));
        }
        else if($graphe=="nbPod"){
            $data = requetePod(htmlspecialchars($_POST["id"]));
        }
        else if($graphe=="status"){
            $data = requeteStatus(htmlspecialchars($_POST["id"]), htmlspecialchars($_POST["year"]));
        }
        else if($graphe=="classement"){
            $data = requeteClassement(htmlspecialchars($_POST["id"]), $_POST["year"]);
        }




        $message = "Récupération des données effectuée avec succès";
        reponse(200, $message, $data);
    }
    else{
        $message = "Paramètre graphe manquant";
        reponse(400, $message, 0);
    }
}
else{
    $message = "ERREUR dans les variables serveur";
    reponse(400, $message, 0);
}




function reponse($code, $message, $data){
    header("Content-Type: application/json");
    http_response_code($code);
    $response = array(
        "code" => $code,
        "message" => $message,
        "data" => $data,
    );
    echo json_encode($response);
}

function requeteVic($id){
    if(!isset($bdd)){
        $bdd = getBD();
    }
    $q = "SELECT COUNT(results.resultId) AS nb, races.year FROM results, drivers, races WHERE results.driverId=drivers.driverId AND drivers.driverId=".$id." AND results.raceId=races.raceId AND results.position=1 GROUP BY races.year ORDER BY races.year ASC";
    $rep = $bdd -> query($q); $ans = $rep -> fetchAll();
    $labels = array(); $values = array();
    for($i=0; $i<count($ans); $i++){
        array_push($labels, $ans[$i]["year"]);
        array_push($values, $ans[$i]["nb"]);
    }
    $data = array("labels" => $labels, "values" => $values);

    return $data;
}

function requetePod($id){
    if(!isset($bdd)){
        $bdd = getBD();
    }
    $q = "SELECT COUNT(results.resultId) AS nb, races.year FROM results, drivers, races WHERE results.driverId=drivers.driverId AND drivers.driverId=".$id." AND results.raceId=races.raceId AND (results.position=1 OR results.position=2 OR results.position=3) GROUP BY races.year ORDER BY races.year ASC";
    $rep = $bdd -> query($q); $ans = $rep -> fetchAll();
    $labels = array(); $values = array();
    for($i=0; $i<count($ans); $i++){
        array_push($labels, $ans[$i]["year"]);
        array_push($values, $ans[$i]["nb"]);
    }
    $data = array("labels" => $labels, "values" => $values);

    return $data;
}

function requeteStatus($id, $year){
    if(!isset($bdd)){
        $bdd = getBD();
    }
    $q = "SELECT COUNT(status.statusId) AS nb, status.status FROM status, results, drivers, races WHERE status.statusId=results.statusId AND results.driverId=drivers.driverId AND drivers.driverId=".$id." AND results.raceId=races.raceId AND races.year=".$year." GROUP BY status.statusId";
    $rep = $bdd -> query($q);
    $ans = $rep -> fetchAll();
    $labels = array(); $values = array();
    for($i=0; $i<count($ans); $i++){
        array_push($labels, $ans[$i]["status"]);
        array_push($values, $ans[$i]["nb"]);
    }
    $data = array("labels" => $labels, "values" => $values);

    return $data;
}

function requeteClassement($id, $year){
    if(!isset($bdd)){
        $bdd = getBD();
    }
    $q = "SELECT results.position, races.date FROM results, races, drivers WHERE races.raceId=results.raceId AND results.driverId=drivers.driverId AND drivers.driverId =".$id." AND races.year=".$year." ORDER BY races.date ASC";
    $rep = $bdd -> query($q);
    $ans = $rep -> fetchAll();
    $labels = array(); $values = array();
    for($i=0; $i<count($ans); $i++){
        array_push($labels, $ans[$i]["date"]);
        array_push($values, $ans[$i]["position"]);
    }
    $data = array("labels" => $labels, "values" => $values);

    return $data;
}

?>