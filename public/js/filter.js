$(document).ready(function () {

    function transformMinutesHours(value)
    {
        var n;
        var h;
        var m;

        if(value < 60){
            n = value + " min";
        }else{
            m = value % 60;
            h = (value / 60).toPrecision(1);
            n = h + "h" + m + "min";
        }
        return n;
    }
    // transformMinutesHours();
    
    $(".filter-select").change(function () {
        let filterPlatform = ( $('#plat-select').val() == '') ? '?platform='+ 'none' : '?platform='+ $('#plat-select').val() ;
        let filterDate =  ( $('#date-select').val() == '') ? '&pushblishDate='+ 'none' : '&pushblishDate='+ $('#date-select').val() ;
        let filterGenre =  ( $('#genre-select').val() == '') ? '&genre='+ 'none' : '&genre='+ $('#genre-select').val() ;
        let filterType = ($('#type-select').val() == '') ? '&type=' + 'none' : '&type=' + $('#type-select').val();
        
        $.ajax({ 
            url: "/movie/serie/search/filter" + filterPlatform + filterDate + filterGenre + filterType,
            dataType: "json"
        }).done(function (data) {
            $('#movie-serie-result').empty();
                data.forEach(movieSerie => {
                    
                    var $classCard;
                    if (movieSerie.typeFilter == 'serie') {
                        $classCard = "bgSerie";
                    } else {
                        $classCard = "bgFilm";
                    }

                    var $lengthDescr
                    if (movieSerie.descr.length > 100) {
                        $lengthDescr = movieSerie.descr.slice(0, 100) + "...";
                    } else {
                        $lengthDescr = movieSerie.descr;
                    }
                    $('#movie-serie-result').append(

                        "<a href='" + movieSerie.show + "'>" +
                        "<div class='card m-5' style='width: 18rem;'>" +

                            "<span class='cate " + $classCard + "'>" + movieSerie.typeFilter + "</span>" +


                            "<div class='div-image'>" +
                        "<img src='" + movieSerie.path + "' class='card-img-top' alt=''>" + "<p class='card-hover'>" + movieSerie.titre + "</p>" +
                                "<p class=" + "'synopsis'>" + $lengthDescr + "</p>" +
                            "</div>" + 
                            "<div class='card-body'>" + 
                                "<p class='card-text'>" + movieSerie.titre + "</p>" + 
                                "<span class=" + "'duree'>" + transformMinutesHours(movieSerie.time) + "</span>" + 
                                "<span class='date'>" +  movieSerie.date.date.substring(0,4) + "</span>" +
                            "</div>" +
                        "</div>" +
                    "</a>"
                
                    )
                });
            
        });

    });

})

