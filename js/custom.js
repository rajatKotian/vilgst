 $(document).ready(function() {
 "use strict";
   
  $('[data-toggle="tooltip"]').tooltip();
 
 
/* -------------------------------------------------------------------------*
 * PRE LOADER
 * -------------------------------------------------------------------------*/
   $(window).load(function() {
     //$('#status, .loading-text').delay(10).fadeOut(100);
    // $('#preloader').delay(10).fadeOut(100);        
   })



/* -------------------------------------------------------------------------*
 * MODAL BOXES
 * -------------------------------------------------------------------------*/
   $('.open-popup-link').magnificPopup({
     removalDelay: 500, //delay removal by X to allow out-animation
     callbacks: {
       beforeOpen: function() {
         this.st.mainClass = this.st.el.attr('data-effect');        
       },
       beforeClose:function() {
         $('.mfp-container').find('.alert').hide();
         $('.mfp-container').find('.form-group').removeClass('has-error');
       }
     },
     midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
   });        
   
   
/* -------------------------------------------------------------------------*
 * WOW ANIMATION
 * -------------------------------------------------------------------------*/
   new WOW().init();
   
/* -------------------------------------------------------------------------*
 * HEADER DATE AND TIME
 * -------------------------------------------------------------------------*/
   var datetime = null,
     date = null;
   var update = function() {
     date = moment(new Date())
     datetime.html(date.format('dddd, D MMMM  YYYY, h:mm:ss a'));
   };
   datetime = $('#time-date')
   update();
   setInterval(update, 1000);
     
/* -------------------------------------------------------------------------*
 * SEARCH BAR
 * -------------------------------------------------------------------------*/
   // Hide search wrap by default;
   $(".search-container").hide();
   $(".toggle-search").on("click", function(e) {
     // Prevent default link behavior
     e.preventDefault();
     // Stop propagation
     e.stopPropagation();
     // Toggle search-wrap
     $(".search-container").slideToggle(500, function() {
       // Focus on the search bar
       // When animation is complete
       $("#search-bar").focus();
     });
   });
   // Close the search bar if user clicks anywhere
   $(document).click(function(e) {
     var searchWrap = $(".search-container");
     if (!searchWrap.is(e.target) && searchWrap.has(e.target).length ===
       0) {
       searchWrap.slideUp(500);
     }
   });
   
/* -------------------------------------------------------------------------*
 * ADDING SLIDE UP AND ANIMATION TO DROPDOWN
 * -------------------------------------------------------------------------*/
enquire.register("screen and (min-width:767px)",
 {

   match: function()
   {
     $(".dropdown").hover(function()
     {
       $('.dropdown-menu', this).stop().fadeIn(100);
     }, function()
     {
       $('.dropdown-menu', this).stop().fadeOut(100);
     });
   },
 });
   
/* --------------------------------ticker-----------------------------------------*
 * HOT NEWS
 * -------------------------------------------------------------------------*/
   $('#js-news').ticker();

   $('.readMoreSubject').click(function (){
      $(this).parent().next().show();
      $(this).parent().hide();
      
    });
    $('.readLessSubject').click(function (){
      $(this).parent().prev().show();
      $(this).parent().hide();
      
    });

    /* -------------------------------------------------------------------------*
   * Sidebar Scroller
   * -------------------------------------------------------------------------*/
if($("#highlights-carousel").find('li').length > 4) {
    // $("#highlights-carousel").simplyScroll({
    //   orientation:'vertical',
    //   speed:3
    // });   
}

if($("#budgets_analysis-carousel").find('li').length > 4) {
    $("#budgets_analysis-carousel").simplyScroll({
      orientation:'vertical',
      speed:3
    });   
}


    $(window).scroll(function(){
      var sticky = $('.nav-search-outer'),
          scroll = $(window).scrollTop(),
          headerHeight = $('.container.header').outerHeight() + $('.header-toolbar').outerHeight();

    //alert(sticky.find('> .container').length );
      if (scroll >= headerHeight) {
        if(sticky.find('h1').length === 0) {
          $("h1").clone().appendTo(sticky).wrap('<div class="container"></div>');
        }
        sticky.addClass('fixed');
      } else {
        sticky.find('h1').closest('.container').remove();
        sticky.removeClass('fixed');
      }
    });
    
    $('.share-hide').click(function() {
        $('#ShareExpandDiv').hide('fast');
        $('#ShareDiv').show('slow');
    });

    $('#ShareDiv').click(function() {
        $('#ShareExpandDiv').show('slow');
        $('#ShareDiv').hide('fast');
    });
   
 });


var printIframe = function(iFrameId) {
  //debugger;
   var ua = window.navigator.userAgent;
    var msie = ua.indexOf ("MSIE");
    var iframe = document.getElementById(iFrameId);



    if (msie > 0) {
        iframe.contentWindow.document.execCommand('print', false, null);
    } else {
        iframe.contentWindow.print();   
        var iframe_content =  iframe.contentDocument.body.innerHTML;
         document.body.innerHTML = iframe_content;
    }
}

function printData(divName) {
    //debugger;
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();
     document.body.innerHTML = printContents;

     //document.body.innerHTML = originalContents;
}

var searchFileName = function(val) {
  if(val !== 0 && val!=='customsearch') {
    window.location.href=val;
  }else{
    $($("#searchFile").parents("div")[0]).append("<form action='https://www.vilgst.com/customsearch.php'><input type='text' name='q' placeholder='Enter Search Query'/><input type='submit'/> </form>")
  }
}//<form action='http://localhost/harry/Vligst Download/customsearch'>

var reqLogin = function() {
  $('#loginInError').modal('show'); 
  $('.open-popup-link').click(function() {
    $('#loginInError').modal('hide'); 
  });
}

var reqAccess = function() {
  alert("Your login credentials are not valid for this section. Please subscribe to this module to obtain access and regular email updates");
}



var showFrame = function(id,page,dataTable) {
  if(page!==null) {

    if(page == 'recent') {
      window.location.href = "https://www.vilgst.com/showiframe?V1Zaa1VsQlJQVDA9="+id+"&page="+page;
    } else if(page == 'emptypath'){
      window.open("https://www.vilgst.com/showdata?V1Zaa1VsQlJQVDA9="+id+"&datatable="+dataTable, '_blank');
    } else{
      window.open("https://www.vilgst.com/showiframe?V1Zaa1VsQlJQVDA9="+id+"&page="+page, '_blank');
    }  

  } else {
    window.open("https://www.vilgst.com/showiframe?V1Zaa1VsQlJQVDA9="+id+"&datatable="+dataTable, '_blank');  
  }  

}
  
/* -------------------------------------------------------------------------*
 * GO TO TOP
 * -------------------------------------------------------------------------*/
   $.scrollUp();

    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
      acc[i].addEventListener("click", function() {
        /* Toggle between adding and removing the "active" class,
        to highlight the button that controls the panel */
        this.classList.toggle("active");
    
        /* Toggle between hiding and showing the active panel */
        var panel = this.nextElementSibling;
        if (panel.style.display === "block") {
          panel.style.display = "none";
        } else {
          panel.style.display = "block";
        }
        // var panel2 = this.nextElementSibling;
        // if (panel2.style.maxHeight) {
        //   panel2.style.maxHeight = null;
        // } else {
        //   panel2.style.maxHeight = panel2.scrollHeight + "px";
        // } 
      });
    }
;