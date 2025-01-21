$(document).ready(function(){

    console.log("Comman js is loaded");


})

let baseUrls = $("#baseUrl").val();

// Logout logic is here

function logout(){


    console.log("hello clcik")

    $.ajax({
        url: baseUrls+"logincontroller/logout",
        type: "POST",
        success: function(data){
            if(data == "success"){
                window.location.href=baseUrls+"indexcontroller";
            }
        }
    })

}

