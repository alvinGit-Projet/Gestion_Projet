let latestChart = null;


function nbVicParSaison(id){
    $.ajax({
        url: "ajax_graph.php",
        type: "POST",
        data: {
            id: id,
            graphe: "nbVic",
        },
        dataType: "json",
        success: function(response){
            creerChart(response.data, "line", "nombre de victoires par saison");
        },
        error: function(result, status, err){ 
            console.log("ERROR "+result.responseText);
            console.log(status.responseText);
            console.log(err.Message); 
        },
        complete: function(xhr, status) {
            if (status !== "success") {
              console.log(xhr.responseText);
              console.log(status);
            }
          }
    })
};

function nbPodParSaison(id){
    $.ajax({
        url: "ajax_graph.php",
        type: "POST",
        data: {
            id: id,
            graphe: "nbPod",
        },
        dataType: "json",
        success: function(response){
            creerChart(response.data, "line", "nombre de podiums par saison");
        },
        error: function(result, status, err){ 
            console.log("ERROR "+result.responseText);
            console.log(status.responseText);
            console.log(err.Message); 
        },
        complete: function(xhr, status) {
            if (status !== "success") {
              console.log(xhr.responseText);
              console.log(status);
            }
          }
    })
};

function status(saison){
    $.ajax({
        url: "ajax_graph.php",
        type: "POST",
        data: {
            id: id,
            graphe: "status",
            year: saison,
        },
        dataType: "json",
        success: function(response){
            creerChart(response.data, "bar", "répartition des status sur la saison "+saison);
        },
        error: function(result, status, err){ 
            console.log("ERROR "+result.responseText);
            console.log(status.responseText);
            console.log(err.Message); 
        },
        complete: function(xhr, status) {
            if (status !== "success") {
              console.log(xhr.responseText);
              console.log(status);
            }
          }
    })
};

function classement(saison){
    $.ajax({
        url: "ajax_graph.php",
        type: "POST",
        data: {
            id: id,
            graphe: "classement",
            year: saison,
        },
        dataType: "json",
        success: function(response){
            creerChart(response.data, "line", "position sur chaque course");
        },
        error: function(result, status, err){ 
            console.log("ERROR "+result.responseText);
            console.log(status.responseText);
            console.log(err.Message); 
        },
        complete: function(xhr, status) {
            if (status !== "success") {
              console.log(xhr.responseText);
              console.log(status);
            }
          }
    })
}



function creerChart(data, type, titre){
    let labels = data["labels"];
    let values = data["values"];
    const dataVic = {
        labels: labels,
        datasets: [{
            label: titre,
            data: values,
    }],
        fill: false,
    };
    let canv = $("#chart");
    console.log(canv);
    if(latestChart!=null){
        latestChart.destroy();
    }
    let scales = null;
    if(titre=="position sur chaque course"){
        scales = {y :{ reverse: true}};
    }
    latestChart = new Chart(canv, {
        type: type,
        data: dataVic,
        options: {
            
          },
          options: {
            elements: {
              line: {
                borderWidth: 3,
              }
            },
            scales: scales,
         }
    })
}

function creerChartEvo(data){
    let labels = data["labels"];
    let values = data["values"];
    console.log("labels : "+labels);
    console.log("values : "+values);

    const dataVic = {
        labels: labels,
        datasets: [{
            label: 'Evolution du nombre de victoire',
            data: values,
    }],
        fill: false,
    };

    console.log(dataVic);

    let canv = $("#chart");
    console.log(canv);
    if(latestChart!=null){
        latestChart.destroy();
    }
    latestChart = new Chart(canv, {
        type: "bar",
        data: dataVic,
        options: {
            elements: {
              line: {
                borderWidth: 3,
              }
            }
          },
    })
}
function creerChartRadar(data){
    let labels = data["labels"];
    let values = data["values"];
    console.log("labels : "+labels);
    console.log("values : "+values);

    const dataVic = {
        labels: labels,
        datasets: [{
            label: 'Status sur la saison',
            data: values,
    }],
        fill: false,
    };

    console.log(dataVic);

    let canv = $("#chart");
    console.log(canv);
    if(latestChart!=null){
        latestChart.destroy();
    }
    latestChart = new Chart(canv, {
        type: "bar",
        data: dataVic,
        options: {
            elements: {
              line: {
                borderWidth: 3,
              }
            }
          },
    })
}