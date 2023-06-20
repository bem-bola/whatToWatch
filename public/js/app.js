$(document).ready(function () {

     $(".containerInput label").hide(0);

    // Survole lien nav

    $(".nav-item").hover(function(){
        $(this).addClass("text-grey-custom");
    })

    // Survole lien footer

    $(".linkFooter").hover(function () {
        $(this).removeClass("colorLink");
        $(this).addClass("text-grey-custom");
    }, function () {
        $(this).addClass("colorLink");
        $(this).removeClass("text-grey-custom");
    })

    // survole reseaux sociaux

    $("#fb").hover(function () {
            
        $(this).css('background-color', '#0e76a8');
        $(this).removeClass("border-reseau")
       
    }, function () {
            $(this).css('background-color', 'inherit'); 
            $(this).addClass("border-reseau");
            
    });

    $("#inst").hover(function () {
            
        $(this).css('background', 'linear-gradient(45DEG, #405DE6, #5851DB, #833AB4, #C13584, #E1306C, #FD1D1D)');
        $(this).removeClass("border-reseau")
       
    }, function () {
            $(this).css('background', 'inherit'); 
            $(this).addClass("border-reseau");
            
    });

    $("#twi").hover(function () {
            
        $(this).css('background-color', '#1da1f2');
        $(this).removeClass("border-reseau")
       
    }, function () {
            $(this).css('background-color', 'inherit'); 
            $(this).addClass("border-reseau");
            
    });

   

    $(".containerInput input").keyup(function () {


        var tape = this.value; // recupère la valeur entrée dans le champs

        if (tape.length <= 0) { //tape est vide alors je cache le label
            $(this).parent().children("label").slideUp();
            
        } else {
            $(this).parent().children("label").slideDown(1000);

        }
        
    })

})