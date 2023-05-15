<?php
ob_start();
require("../fonction.php");
$bdd = getBD();
ob_end_clean();


//if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtoupper($_SERVER["HTTP_X_REQUESTED_WITH"])=="XMLHTTPREQUEST"){
    if(isset($_POST["auteur"]) && isset($_POST["titre"]) && isset($_POST["contenu"])){
        if(strlen($_POST["titre"])<50 && strlen($_POST["contenu"])>20 && strlen($_POST["contenu"])<200){  
            $time = "SELECT CURRENT_TIMESTAMP"; $rep = $bdd -> query($time); $ans = $rep -> fetch(); $time = $ans[0];
            $q = "INSERT INTO topic (titre, email_adress, mots_cles, date_topic) VALUES ('".$_POST["titre"]."', '".$_POST["auteur"]."', '', '".$time."')";
       //     $q = "INSERT INTO topic (titre, email_adress, mots_cles, date_topic) VALUES ('titre', 'a', '', '".$time."')";
            $rep = $bdd -> query($q); $idq = "SELECT topic.topic_id FROM topic WHERE topic.date_topic='".$time."' AND topic.email_adress='".$_POST["auteur"]."'"; $rep = $bdd -> query($idq); $ans = $rep -> fetch(); $id = $ans[0];
            $q2 = "INSERT INTO message (email_adress, contenu, topic_id, message_prec_id, date_msg) VALUES ('".$_POST["auteur"]."', '".$_POST["contenu"]."', ".$id.", -1, '".$time."')";
      //      $q2 = "INSERT INTO message (email_adress, contenu, topic_id, message_prec_id, date_msg) VALUES ('a', 'orfef krfnofrnr rfnfonf rkfnrfn', 1, -1, '".$time."')";
            $rep = $bdd -> query($q2);
            reponse(200, "creation OK");
        }  
        else{
            if(strlen($_POST["titre"])>=50){
                reponse(400, "titre long");
            }
            else if(strlen($_POST["contenu"])>=200){
                reponse(400, "contenu long");
            }
            else if(strlen($_POST["contenu"])<=20){
                reponse(400, "contenu court");
            }  
        }
    }
    else{
        reponse(200, "paramètres non set");
    }  
/*}
else{
    reponse(200, "dans le grand else");
}   */

function reponse($code, $message){
    header("Content-Type: application/json");
    http_response_code($code);
    $response = array(
        "code" => $code,
        "message" => $message,
    );
    echo json_encode($response);
}



?>