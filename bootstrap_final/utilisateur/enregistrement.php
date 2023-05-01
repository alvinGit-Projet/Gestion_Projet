<!DOCTYPE html>
    <html>
     <head>

          <title> Enregistrement </title>

          <?php
          function enregistrer($nom,$prenom,$mail,$motdepasse){
               require("../fonction.php");
               $bdd = getBD();
               
               $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
               $requete = "INSERT INTO utilisateur(nom, prenom, email_adress, motdepasse) VALUES(:nom, :prenom, :mail, :motdepasse)";
               $statement = $bdd -> prepare($requete);
              
               $nom = htmlspecialchars($nom); $prenom = htmlspecialchars($prenom);  $mail = htmlspecialchars($mail); $motdepasse = htmlspecialchars($motdepasse);
               $nom = addslashes($nom); $prenom = addslashes($prenom); $mail = addslashes($mail); $motdepasse = addslashes($motdepasse);
              
               $statement -> bindParam(':nom', $nom); $statement -> bindParam(':prenom', $prenom);
               $statement -> bindParam(':mail', $mail); $statement -> bindParam(':motdepasse', $motdepasse);

               $statement->execute();  
          }
               if(isset($_POST["n"]) && isset($_POST["p"])
                    && isset($_POST["mail"]) && isset($_POST["mdp1"]) 
                    && isset($_POST["mdp2"])){

                    if(!empty($_POST['n']) && !empty($_POST['p']) && !empty($_POST['mail']) && !empty($_POST['mdp1']) && !empty($_POST['mdp2'])){

                         if($_POST["mdp1"] == $_POST["mdp2"]){
                          
                             enregistrer($_POST["n"], $_POST["p"], $_POST["mail"],$_POST["mdp1"]);
                             echo "<meta http-equiv='refresh' content='0; URL=../index.php'>" ;
                         }

                         else{
                              echo "<meta http-equiv='refresh'  content='0; URL=./inscription.php?n=".$_POST['n']."&p=".$_POST['p']."&mail=".$_POST['mail']."'>" ;
                         }
                    }
                    else{
                         echo "<meta http-equiv='refresh'  content='0; URL=./inscription.php?n=".$_POST['n']."&p=".$_POST['p']."&mail=".$_POST['mail']."'>" ;
                    }

      }         else{
                    echo "<meta http-equiv='refresh'  content='0; URL=./inscription.php?n=".$_POST['n']."&p=".$_POST['p']."&mail=".$_POST['mail']."'>" ;
                    }

               
          ?>


     </head>
     <body>
      
     </body>
    </html>