<?php

ob_start();
require("../fonction.php");
ob_end_clean();

if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtoupper($_SERVER["HTTP_X_REQUESTED_WITH"])=="XMLHTTPREQUEST"){
    if(isset($_POST["id1"]) && isset($_POST["id2"])){
        
        $id1 = $_POST["id1"]; $id2 = $_POST["id2"];
        $q1 = "SELECT drivers.surname, drivers.forename FROM drivers WHERE drivers.driverId=".$id1;
        $q2 = "SELECT drivers.surname, drivers.forename FROM drivers WHERE drivers.driverId=".$id2;
        if(!isset($bdd)){
            $bdd = getBD();
        }
        $rep1 = $bdd -> query($q1); $rep2 = $bdd -> query($q2);
        $ans1 = $rep1 -> fetch(); $ans2 = $rep2 -> fetch(); 

        $data = array();
        $data["radar"] = radar_data($id1, $id2);
        $data["points"] = point_data($id1, $id2);
        $data["noms"] = array("pil1" => $ans1, "pil2" => $ans2);
        $message = "Recup ok";
        reponse(200, $message, $data);
    }
    else{
        $message = "variables post non transmises";
        reponse(400, $message);
    }
}
else{
    $message = "Variables serveur non définies";
    reponse(400, $message);
}

function reponse($code, $message, $data = NULL){
    http_response_code($code);
    header("Content-Type: application/json");
    $reponse = array(
        "code" => $code,
        "message" => $message,
        "data" => $data,
    );
    echo json_encode($reponse);
}

function radar_data($id1, $id2){
    if(!isset($bdd)){
        $bdd = getBD();
    }
    $rep = $bdd -> query("SELECT COUNT(results.statusId) as nb, status.status FROM results, status WHERE results.driverId=".$id1." AND status.statusId=results.statusId GROUP BY results.statusId ORDER BY nb DESC LIMIT 6");
    $data1 = $rep -> fetchAll();
    $dataset1 = array();
    $label1 = array();
    for($i=0; $i<count($data1); $i++){
        array_push($dataset1, $data1[$i]["nb"]);
        array_push($label1, $data1[$i]["status"]);
    }

    $rep = $bdd -> query("SELECT COUNT(results.statusId) as nb, status.status FROM results, status WHERE results.driverId=".$id2." AND status.statusId=results.statusId GROUP BY results.statusId ORDER BY nb DESC LIMIT 6");
    $data2 = $rep -> fetchAll();
    $dataset2 = array();
    $label2 = array();
    for($i=0; $i<count($data2); $i++){
        array_push($dataset2, $data2[$i]["nb"]);
        array_push($label2, $data2[$i]["status"]);
    }

    $data = array("label1" => $label1, "data1" => $dataset1, "label2" => $label2, "data2" => $dataset2);
    return $data;
}

function point_data($id1, $id2){
    if(!isset($bdd)){
        $bdd = getBD();
    }
    $q = "SELECT races.year, SUM(results.points) AS total FROM results, races, drivers WHERE races.raceId=results.raceId AND results.driverId=drivers.driverId AND drivers.driverId=".$id1." GROUP BY races.year ORDER BY races.year ASC";
    $ans = $bdd -> query($q); $rep = $ans -> fetchAll();
    $dataset1 = array();
    $label1 = array();
    for($i=0; $i<count($rep); $i++){
        array_push($dataset1, $rep[$i]["total"]);
        array_push($label1, $rep[$i]["year"]);
    }

    $q = "SELECT races.year, SUM(results.points) AS total FROM results, races, drivers WHERE races.raceId=results.raceId AND results.driverId=drivers.driverId AND drivers.driverId=".$id2." GROUP BY races.year ORDER BY races.year ASC";
    $ans = $bdd -> query($q); $rep = $ans -> fetchAll();
    $dataset2 = array();
    $label2 = array();
    for($i=0; $i<count($rep); $i++){
        array_push($dataset2, $rep[$i]["total"]);
        array_push($label2, $rep[$i]["year"]);
    }

    $labels=array();

    if($label1!=$label2){
        if($label1[0]<$label2[0]){
            $min = $label1[0];
        }
        else{
            $min = $label2[0];
        }
        if($label1[count($label1)-1]<$label2[count($label2)-1]){
            $max = $label2[count($label2)-1];

        }
        else{
            $max = $label1[count($label1)-1];

        }
        while($min<=$max){
            array_push($labels, $min);
            $min++;
        }
    }
    else{
        $labels=$label1;
    }
    $values1 = array();

    for($i=0;$i<count($labels); $i++){
        $found = false;
        $id=0;
        for($j=0; !$found && $j<count($label1); $j++){
            if($label1[$j]==$labels[$i]){
                $found=true;
                $id=$j;
            }
        }
        if($found){
            array_push($values1, $dataset1[$id]);
        }
        else{
            array_push($values1, 0);

        }
    }
    $values2 = array();
    for($i=0;$i<count($labels); $i++){
        $found = false;
        $id=0;
        for($j=0; !$found && $j<count($label2); $j++){
            if($label2[$j]==$labels[$i]){
                $found=true;
                $id=$j;
            }
        }
        if($found){
            array_push($values2, $dataset2[$id]);
        }
        else{
            array_push($values2, 0);
        }
    }

    $data = array("labels" => $labels, "data1" => $values1, "data2" => $values2);
    return $data;
}





?>