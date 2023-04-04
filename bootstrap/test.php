<!DOCTYPE html>
<html lang="fr">
    <head>

    <?php
      require("fonction.php");
      $bdd = getBD();
      session_start();
      ?>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="./style_in.css" type="text/css">
         <script src="https://cdn.jsdelivr.net/npm/chart.js"> </script>
         <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>




        </head>

<div class="chartBox" id="backgroundColorChart">
  <canvas id="myChart"></canvas>
  <input type="checkbox" onchange="darkMode(this)" name=""> <span id="checkboxText" class="">Dark Mode </span>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const ctx = document.getElementById('myChart');

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
      datasets: [{
        label: '# of Votes',
        data: [12, 19, 3, 5, 2, 3],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
          grid: {
            color: 'black'
          }
        }
      }
    }
  });

function darkMode(checkbox){
    console.log(checkbox.checked)
    const x = myChart.config.options.scales.x;
    const y = myChart.config.options.scales.y;
    const bgColorChart = document.getElementById('backgroundColorChart');

    myChart.update();

}



</script>



