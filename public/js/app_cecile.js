$( document ).ready(function() {
    console.log( "ready to staaaaart!" );

    $( "#button_header_movie" ).click(function() {
        $("#video_header").css("display", "block");
    });
  
  // annimation bouton moteur de recherche
    $( "#button_search" )
    .mouseenter(function() {
      $("#icon_button_search").removeClass("fas fa-search").addClass("fa fa-arrow-right");
    })
    .mouseleave(function() {
      $("#icon_button_search").removeClass("fas fa-arrow-right").addClass("fas fa-search");
    });
  
  
});