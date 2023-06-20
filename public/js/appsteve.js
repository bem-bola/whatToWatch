$("select").on("click" , function() {
  
    $(this).parent(".custom-dropdown").toggleClass("open");
    
  });

  
  $(document).mouseup(function (e)
  {
      var container = $(".custom-dropdown");
  
      if (container.has(e.target).length <= 0.5)
      {
          container.removeClass("open");
      }
  });

   
    //   Dark-mode-switch

    $('main, body').toggleClass(localStorage.toggled);

    function darkLight() {
      /*DARK CLASS*/
      if (localStorage.toggled != 'dark') {
        $('main, body').toggleClass('dark', true);
        localStorage.toggled = "dark";
         
      } else {
        $('main, body').toggleClass('dark', false);
        localStorage.toggled = "";
      }
    }
    
    /*Add 'checked' property to input if background == dark*/

    if ($('main, body').hasClass('dark')) {
       $( '#checkBox' ).prop( "checked", true )
    } else {
      $( '#checkBox' ).prop( "checked", false )
    }

