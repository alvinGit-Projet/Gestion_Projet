
<?php
    session_start();
    require("fonction.php");
    $bdd=getBD();
	?>


<?php
    header('Content-Type: application/json');

    $conn = mysqli_connect("localhost","root","","chart");

    $sqlQuery = "SELECT COUNT(*) as victoire, drivers.surname
                 FROM results, drivers
                 WHERE results.driverId=drivers.driverId
                 AND results.position=1
                 GROUP BY results.driverId
                 ORDER BY victoire DESC";
    $statement=$bdd->prepare($sqlQuery);
    $rep = $statement -> execute();
    $result = $statement -> fetchAll();

    $data = [];

    foreach ($result as $row) {
        $data[] = $row;
    }

    echo json_encode($data);
?>