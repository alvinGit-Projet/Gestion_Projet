<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Document</title>

    <?php
 //   require("../fonction.php");
    

        function reco_content_based($bdd){
         /*   if(!isset($bdd)){
                $bdd = getBD();
            }  */
            // récupération de tous les pilotes :
            $allId = "SELECT drivers.driverId FROM drivers"; $rep = $bdd -> query($allId); $allIds = $rep -> fetchAll();

            // récupération des pilotes likés
            if(isset($_SESSION["utilisateur"])){
                $recup = "SELECT liker_pilote.driverId FROM liker_pilote WHERE liker_pilote.email_adress=".$_SESSION["utilisateur"]["email_adress"];
                $rep = $bdd -> query($recup); $ids = $rep -> fetchAll();
            }
            else{
                $recup = "SELECT liker_pilote.driverId FROM liker_pilote WHERE liker_pilote.email_adress='a'";
                $rep = $bdd -> query($recup); $ids = $rep -> fetchAll();
            }
            
            
            $matrice = array();
            $matriceLiked = array();
            for($i=0; $i<count($allIds); $i++){
                $q1 = "SELECT drivers.nationality FROM drivers WHERE drivers.driverId=".$allIds[$i][0]; $q2 = "SELECT COUNT(results.raceId) FROM results WHERE results.driverId=".$allIds[$i][0];
                $q3 = "SELECT COUNT(results.raceId) FROM results WHERE results.position=1 AND results.driverId=".$allIds[$i][0];
                $q4 = "SELECT COUNT(results.raceId) FROM results WHERE (results.position=1 OR results.position=2 OR results.position=3) AND results.driverId=".$allIds[$i][0];
                $rep = $bdd -> query($q1); $rep2 = $bdd -> query($q2);  $rep3 = $bdd -> query($q3); $rep4 = $bdd-> query($q4);
                $co1 = $rep -> fetch();  $co2 = $rep2 -> fetch();  $co3 = $rep3 -> fetch(); $co4 = $rep4 -> fetch(); 

            // déterminer si pilote aimé ou pas : 
                if(isset($ids)){
                    $find = FALSE;
                    for($j=0; $j<count($ids) && !$find; $j++){
                        if($ids[$j]["driverId"]==$allIds[$i][0]){
                            $find=TRUE;
                        }
                    }
                    if($find){
                        $vec = array('id' => $allIds[$i][0], 'nationality' => $co1[0], 'total' => $co2[0], 'victoires' => $co3[0], 'ratio' => $co3[0]/$co2[0], 'podium' => $co4[0]);
                        array_push($matriceLiked, $vec);
                    }
                    else{
                        $vec = array('id' => $allIds[$i][0], 'nationality' => $co1[0], 'total' => $co2[0], 'victoires' => $co3[0], 'ratio' => $co3[0]/$co2[0], 'podium' => $co4[0]);
                        array_push($matrice, $vec);  
                    }
                }
                else{
                    $vec = array('id' => $allIds[$i][0], 'nationality' => $co1[0], 'total' => $co2[0], 'victoires' => $co3[0], 'ratio' => $co3[0]/$co2[0], 'podium' => $co4[0]);
                    array_push($matrice, $vec);
                }
            }

            // clacul score des vecteurs de la matrice selon les critères
            // établir pour chaque pilote liké le taux de "compatibilité" avec les autres vecteurs

            $tops10 = array();

            for($i=0; $i<count($matriceLiked); $i++){
                $mtrx = $matrice;
                for($j=0; $j<count($mtrx); $j++){
                    $comp = calculerComp($matriceLiked[$i], $matrice[$j]);
                    $mtrx[$j]["compatibilite"] = $comp;
                }
                $top10 = extractionTop($mtrx, 10);
                for($j=0; $j<10; $j++){
                    array_push($tops10, $top10[$j]);
                }
            }
            // On a les top10 pour chaque vecteur liké regroupé dans $tops10 -> il faut compter ceux présents plusieurs fois et les favorisé
            
            for($i=0; $i<count($tops10); $i++){
                $nbOccur = 0;
                $vecteursI = array();
                $j=0;
                while($j<count($tops10)){
                // echo "On compare i=".$i." avec j=".$j." ==> ".$tops10[$i]["id"]." ".$tops10[$j]["id"]. "<br>";
                    if($tops10[$i]["id"]==$tops10[$j]["id"]){
                        $nbOccur++;
                        array_push($vecteursI, $tops10[$j]);
                        // on ajoute toutes les occurences d'un pilote dans vecteursI pour calculer le taux de compatibilité total, arraysplice pour supprimer les doublons 
                        if($nbOccur>1){
                            array_splice($tops10, $j, 1);
                            $j--;
                        }
                        // le else = c'est le 1er élément de ce type
                    }
                    // on incrémente J si ils sont différents / pas d'incrémentations si égaux car supprimé et donc nouveau vecteur à la position J
                    $j++;
                }
                if($nbOccur>1){
                    $compTot = 0;
                    for($j=0; $j<count($vecteursI); $j++){
                        $compTot+=0.9*$vecteursI[$j]["compatibilite"];
                    }
                    //on attribue le taux de compatibilité totale à l'occurence i (la première normalement car suppression des doublons) 
                    $tops10[$i]["compatibilite"]=$compTot;
                }
            }

            // Il reste à trier et extraire le top 8?
            $top8 = extractionTop($tops10, 4);


            return $top8;
        }


        // affichage des pilotes recommandés :
      /*  $top8 = reco_content_based();

        $i=0;
        while($i<8){
            if(!isset($bdd)){
                $bdd = getBD();
            }
            $q = "SELECT * FROM drivers WHERE drivers.driverId=".$top8[$i]["id"];
            $rep = $bdd -> query($q); $pilote = $rep -> fetch();
            echo "Recommandation ".($i+1)." : ".$pilote["forename"]." ".$pilote["surname"]." <br>";
            $i++;

        }   */

        function calculerComp($vecLiked, $vecInterr){
            $compatibilité = 0;
            if($vecLiked["nationality"]==$vecInterr["nationality"]){
                $compatibilité+=0.5;
            }
            $criteres = array(0 => "total", 1=> "victoires", 2=> "ratio", 3=> "podium");
            for($i=0; $i<count($criteres); $i++){
                 if($vecLiked[$criteres[$i]]>$vecInterr[$criteres[$i]]){
                    if($vecInterr[$criteres[$i]]!=0){
                        $rapport = $vecInterr[$criteres[$i]]/$vecLiked[$criteres[$i]];
                        $compatibilité+=$rapport;
                    }
                }
                else{
                    if($vecLiked[$criteres[$i]]==$vecInterr[$criteres[$i]]){
                        $compatibilité+=1;
                    }
                    else if($vecInterr[$criteres[$i]]!=0){
                        $rapport = $vecLiked[$criteres[$i]]/$vecInterr[$criteres[$i]];
                        $compatibilité+=$rapport;
                    }   
                }
            }
           return $compatibilité;
        }

        function extractionTop($matrice, $nombre){
            $top = array();
            
            for($j=0; count($matrice)>0 && $j<$nombre; $j++){
                $max = $matrice[0];
                $position=0;
                for($i=0; $i<count($matrice); $i++){
                    if($matrice[$i]["compatibilite"]>$max["compatibilite"]){
                        $max=$matrice[$i];
                        $position=$i;
                    }
                }
                array_push($top, $max);
                array_splice($matrice, $position, 1);
            }
            return $top;
        }
        

        function reco_user_based($bdd){
           /* if(!isset($bdd)){
                $bdd = getBD();
            }  */
            // on va récupéré la liste des pilotes likés par l'utilisateur 
            // chercher les autres utilisateurs les ayant liké 
            // parmi les utilisateurs les plus ressemblants on extrait les pilotes non likés par utilisateur 0
            $ownAdress="";
            if(isset($_SESSION["utilisateur"])){
                $q = "SELECT liker_pilote.driverId FROM liker_pilote WHERE liker_pilote.email_adress=".$_SESSION["utilisateur"]["email_adress"];
                $ownAdress=$_SESSION["utilisateur"]["email_adress"];
            }
            else{
                $q = "SELECT liker_pilote.driverId FROM liker_pilote WHERE liker_pilote.email_adress='a'";
                $ownAdress="a";
            }
            $rep = $bdd -> query($q); $ids = $rep -> fetchAll();
            $users = array();
            for($i=0; $i<count($ids); $i++){
                // On récupère les users qui ont liké des pilotes similaires
                $userq = "SELECT liker_pilote.email_adress FROM liker_pilote WHERE liker_pilote.driverId=".$ids[$i]["driverId"]." AND liker_pilote.email_adress!='".$ownAdress."'";
                $rep = $bdd -> query($userq); $ans = $rep -> fetchAll();
                for($j=0; $j<count($ans); $j++){
                    // on va ajouter les utilisateurs dans le tableau 'users'
                    // vérifier que l'user n'est pas déjà dans le tableau 
                    $alreadyIn = FALSE;
                    $index = -1;
                    for($k=0; !$alreadyIn && $k<count($users); $k++){
                        if($users[$k]["id"]==$ans[$j][0]){
                            $alreadyIn=TRUE;
                            $index=$k;
                        }
                    }
                    if(!$alreadyIn){
                        array_push($users, array("id" => $ans[$j][0], "commun" => 1));
                      //  $users[count($users)-1]["commun"]=0;
                    }
                    else{
                        $users[$index]["commun"]+=1;
                    }
                }
            }
            // on va maintenant extraire les 10 pilotes les plus semblables == ceux avec le plus de pilotes en commun
            $mostLikely = extractionPlusSemblable($users, 10);
            // on va extraire la liste des pilotes qu'ils ont likés mais pas l'utilisateur 0
            $recommandation = array();
            $liked = array();
            for($i=0; $i<count($mostLikely); $i++){
                $likelyq = "SELECT liker_pilote.driverId FROM liker_pilote WHERE liker_pilote.email_adress='".$mostLikely[$i]["id"]."' AND liker_pilote.driverId NOT IN (".$q.")";
                $rep = $bdd -> query($likelyq); $nonliked = $rep -> fetchAll();
                for($j=0; $j<count($nonliked); $j++){
                    // on parcourt les pilotes non-likés récupérés via likelyq et on va les ajouter dans recommandation en vérifiant s'ils y sont déjà ou pas
                    $alreadyIn=FALSE;
                    $index=-1;
                    for($k=0; !$alreadyIn && $k<count($recommandation); $k++){
                        if($recommandation[$k]["id"]==$nonliked[$j]["driverId"]){
                            $alreadyIn=TRUE;
                            $index=$k;
                        }
                    }
                    if(!$alreadyIn){
                        array_push($recommandation, array("id" => $nonliked[$j]["driverId"], "count" => 1));
                    }
                    else{
                        $recommandation[$index]["count"]+=1;
                    } 
                }
            }
            $top8 = extraction($recommandation, 8, "count");
            return $top8;

        }

    /*    echo "<br>  <br>";
        //generateLike(11, 600);
       //reset_like();
        $top8 = reco_user_based();
       /* if(!isset($bdd)){
                $bdd = getBD();
        }  
        for($i=0; $i<count($top8); $i++){
            $q = "SELECT * FROM drivers WHERE drivers.driverId=".$top8[$i]["id"];
            $rep = $bdd -> query($q); $pilote = $rep -> fetch();
            echo "Recommandation ".($i+1)." : ".$pilote["forename"]." ".$pilote["surname"]." <br>";
        }   */
        


        function extractionPlusSemblable($matrice, $nombre){
            $top = array();
            
            for($j=0; count($matrice)>0 && $j<$nombre; $j++){
                $max = $matrice[0];
                $position=0;
                for($i=0; $i<count($matrice); $i++){
                    if($matrice[$i]["commun"]>$max["commun"]){
                        $max=$matrice[$i];
                        $position=$i;
                    }
                }
                array_push($top, $max);
                array_splice($matrice, $position, 1);
            }
            return $top;
        }

        function extraction($matrice, $nombre, $parametre){
            $top = array();
            
            for($j=0; count($matrice)>0 && $j<$nombre; $j++){
                $max = $matrice[0];
                $position=0;
                for($i=0; $i<count($matrice); $i++){
                    if($matrice[$i][$parametre]>$max[$parametre]){
                        $max=$matrice[$i];
                        $position=$i;
                    }
                }
                array_push($top, $max);
                array_splice($matrice, $position, 1);
            }
            return $top;
        }


        function generateLike($nbUsers, $nbLikes, $bdd){
           /* if(!isset($bdd)){
                $bdd = getBD();
            }  */
            $q = "SELECT drivers.driverId FROM drivers";
            $rep = $bdd -> query($q); $pilotesId = $rep -> fetchAll();
            if($nbLikes>$nbUsers*count($pilotesId)){
                echo "Le nombre de like est impossible à réaliser sans répétition";
                die;
            }
            $users = array();
            $chars = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "x", "y", "z");
            $nbChars=ceil(log10($nbUsers));
            while(count($users)<$nbUsers){
                $randomName = "";    
                while(strlen($randomName)<$nbChars){
                    $rand = rand(0, count($chars)-1);
                    $randomName.=$chars[$rand];
                   
                }
                // vérification que userName n'existe pas déjà :
                $nouveau = TRUE;
                for($i=0; $nouveau && $i<count($users); $i++){
                    if($randomName==$users[$i]){
                        $nouveau=FALSE;
                    }
                }
                if($nouveau){
                    echo $randomName."<br>";
                    array_push($users, $randomName);
                } 
            }
            print_r($users);
            // maintenant les users doivent liker des pilotes
            $i=0;
            $nbPilotes = count($pilotesId)-1;
            while($i<$nbLikes){
                $randomPilote = rand(0, $nbPilotes);
                $randomUser = rand(0, count($users)-1);
                $verifq = "SELECT COUNT(*) FROM liker_pilote WHERE liker_pilote.email_adress='".$users[$randomUser]."' AND liker_pilote.driverId=".$pilotesId[$randomPilote]["driverId"];
                $rep = $bdd -> query($verifq); $ans = $rep -> fetch();
                if($ans[0]==0){ 
                    $insertq = "INSERT INTO liker_pilote VALUES (".$pilotesId[$randomPilote]["driverId"].", '".$users[$randomUser]."', '2000-01-01')";
                    $rep = $bdd -> query($insertq);$i++;
                } 
            }
        }

        function reset_like(){
          /*  if(!isset($bdd)){
                $bdd = getBD();
            }  */
            $q = "SELECT DISTINCT liker_pilote.email_adress FROM liker_pilote WHERE liker_pilote.email_adress!='a'";
            $rep = $bdd -> query($q); $ans = $rep -> fetchAll();
            for($i=0; $i<count($ans); $i++){
                $deleteq = "DELETE FROM liker_pilote WHERE liker_pilote.email_adress='".$ans[$i]["email_adress"]."'";
                $rep = $bdd -> query($deleteq);
            }
        }





    ?>


</head>
<body>
    
</body>
</html>