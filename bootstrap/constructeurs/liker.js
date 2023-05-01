function like(email, id, liked){
    $.ajax({
        type: "POST",
        url: "ajax_like_constructeur.php",
        data: {
          email: email,
          id: id,
        },
        dataType: "text",
        success: function(response){
          console.log("liked with success");
          console.log(response);
          if(liked){
              $("#like").attr("class", "btn btn-outline-danger");
            }
            else{
              $("#like").attr("class", "btn btn-danger");
            }
        },
        error: function(xhr, status, error, data) {
            console.log(xhr.responseText);
            console.log(status);
            console.log(error);
            console.log("data "+data);
            
            

        },
        complete: function(xhr, status) {
          if (status !== "success") {
            console.log(xhr.responseText);
            console.log(status);
          }
        }
      })
  };