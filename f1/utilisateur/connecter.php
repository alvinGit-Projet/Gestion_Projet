<!DOCTYPE html>
    <html>
     <head>

         <?php 
            require("../fonction.php");
            $bdd = getBD();
            session_start();
        ?>

        <?php
            $q = "SELECT * FROM utilisateur WHERE utilisateur.email_adress='".$_POST['mail']."' and utilisateur.motdepasse='".$_POST['mdp']."'";
            $rep = $bdd -> query($q);

            if(!$rep){
                echo "<meta http-equiv='refresh' content='0; URL=./connexion.php'>" ;
            }
            else {
                $info = $rep -> fetch();
                $_SESSION["utilisateur"] = $info;
                echo "<meta http-equiv='refresh' content='0; URL=../index.php'>" ;
            }
        ?>

    </head>
     <body>

    </body>

</html>