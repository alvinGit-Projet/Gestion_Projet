<?php
ob_start();
header("Content-Type: application/json");
require("../fonction.php");
$bdd = getBD();
ob_end_clean();


if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtoupper($_SERVER["HTTP_X_REQUESTED_WITH"])=="XMLHTTPREQUEST"){
    
        $message ="";
        $action = "";

        $id = htmlspecialchars($_POST["id"]); $mail = htmlspecialchars($_POST["email"]);
        $q = "SELECT COUNT(*) FROM liker_constructor WHERE liker_constructor.email_adress='".$mail."' AND liker_constructor.constructorId=".$id;
        $rep = $bdd -> query($q); $ans = $rep -> fetch();
        if($ans[0]>0){
         /*   $statement = $bdd -> prepare($delq);
            $statement -> bindParam(":email", $mail); $statement -> bindParam(":id", $id); ;
            $rep = $statement -> execute(); */
            $query = "DELETE FROM liker_constructor WHERE liker_constructor.constructorId=".$id." AND liker_constructor.email_adress='".$mail."'";
            $rep = $bdd -> query($query);
            $message = "Suppression de la valeur effectuée avec succès";
            $action="DEL";
        } 
        else{
          /*  $statement = $bdd -> prepare($insq);
            $statement -> bindParam(":email", $mail); $statement -> bindParam(":id", $id);
            $rep = $statement -> execute();   */
            $query = "INSERT INTO liker_constructor VALUE(".$id.", '".$mail."', '2000-01-01')";
            $rep = $bdd -> query($query);
            $message = "Insertion de la valeur réalisée avec succès";
            $action = "INS";
        }
        reponse(200, $message, $action);
    }
else{
    $message = "Variables serveurs non définies / non valides";
    reponse(400, $message, "NONE");
}

function reponse($code, $message, $action){
    header("Content-Type: application/json");
    http_response_code($code);
    $response = array(
        "code" => $code,
        "message" => $message, 
        "action" => $action
    );
    echo json_encode($response);
 //   echo $response;
    exit;
}






?>